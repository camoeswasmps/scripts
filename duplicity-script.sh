#!/bin/bash
#
# Script for making duplicity backups in SmartHost servers
#
PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin:/root/bin
SERVER=$(cat /etc/exim/smarthost_name | cut -d "=" -f2 | tr -d " ")
DEST="scp://smarthost@xen-ovh.celingest.es/smarthost/${SERVER}/"
ROOT="/"
INCLIST=( "${ROOT}" )
EXCLIST=( "/proc" \
          "/sys" \
          "/dev" \
          "/mnt" \
          "/tmp" \
          "/**.cache" \
          "/var/spool/exim/input" \
          "/var/spool/exim/msglog" \
          "/var/named/chroot" \
)
GPG_KEY=""
PASSPHRASE=""
STATIC_OPTIONS="--exclude-device-files --full-if-older-than 14D --volsize 200"
CLEAN_UP_TYPE="remove-all-but-n-full"
CLEAN_UP_VARIABLE="2"
LOGDIR="/root/backupLogs/ssh/"
LOG_FILE="duplicity-$(date +%Y-%m-%d_%H-%M).txt"
LOG_FILE_OWNER="root:root"
VERBOSITY="-v3"
##############################################################
# Script Happens Below This Line - Shouldn't Require Editing #
##############################################################
LOGFILE="${LOGDIR}${LOG_FILE}"
DUPLICITY="$(which duplicity)"
MAIL="$(which mail)"

README_TXT="In case you've long forgotten, this is a backup script that you used to backup some files (most likely remotely SSH server).  In order to restore these files, you first need to import your GPG private key (if you haven't already).  The key is in this directory and the following command should do the trick:\n\ngpg --allow-secret-key-import --import secret.key.txt\n\nAfter your key as been succesfully imported, you should be able to restore your files.\n\nGood luck!"
CONFIG_VAR_MSG="Oops!! ${0} was unable to run!\nWe are missing one or more important variables at the top of the script.\nCheck your configuration because it appears that something has not been set yet."

if [ ! -x "$DUPLICITY" ]; then
  echo "ERROR: duplicity not installed, that's gotta happen first!" >&2
  exit 1
fi

if [ ! -d ${LOGDIR} ]; then
  echo "Attempting to create log directory ${LOGDIR} ..."
  if ! mkdir -p ${LOGDIR}; then
    echo "Log directory ${LOGDIR} could not be created by this user: ${USER}"
    echo "Aborting..."
    exit 1
  else
    echo "Directory ${LOGDIR} successfully created."
  fi
elif [ ! -w ${LOGDIR} ]; then
  echo "Log directory ${LOGDIR} is not writeable by this user: ${USER}"
  echo "Aborting..."
  exit 1
fi

if [ -z "${GPG_KEY}" ]; then
        GPG_OPTIONS="--no-encryption"
else
        GPG_OPTIONS="--encrypt-key=${GPG_KEY} --sign-key=${GPG_KEY}"
fi

get_source_file_size()
{
  echo "---------[ Source File Size Information ]---------" >> ${LOGFILE}

  for exclude in ${EXCLIST[@]}; do
    DUEXCLIST="${DUEXCLIST}${exclude}\n"
  done

  for include in ${INCLIST[@]}; do
    echo -e $DUEXCLIST | \
    du -hs --exclude-from="-" ${include} | \
    awk '{ print $2"\t"$1 }' \
    >> ${LOGFILE}
  done
  echo >> ${LOGFILE}
}

get_remote_file_size()
{
  echo "------[ Destination File Size Information ]------" >> ${LOGFILE}
  if [ $(echo ${DEST} | cut -c 1,2,3) = "ssh" ]; then
    TMPDEST=$(echo ${DEST} | cut -d "/" -f4-)
    SERVER=$(echo ${DEST} | cut -d "/" -f3)
    SIZE=$(ssh $SERVER du -hs ${TMPDEST} | awk '{print $1}')
  else
    SIZE="method not allowed."
  fi
  echo "Current Remote Backup File Size: ${SIZE}" >> ${LOGFILE}
  echo >> ${LOGFILE}
}

include_exclude()
{
  for include in ${INCLIST[@]}; do
        TMP=" --include="$include
        INCLUDE=$INCLUDE$TMP
  done
  for exclude in ${EXCLIST[@]}; do
    TMP=" --exclude "$exclude
    EXCLUDE=$EXCLUDE$TMP
  done
  EXCLUDEROOT="--exclude=**"
}

duplicity_cleanup()
{
  echo "-----------[ Duplicity Cleanup ]-----------" >> ${LOGFILE}
  ${ECHO} ${DUPLICITY} ${CLEAN_UP_TYPE} ${CLEAN_UP_VARIABLE} --force \
            ${GPG_OPTIONS} ${DEST} >> ${LOGFILE}
  echo >> ${LOGFILE}
}

duplicity_backup()
{
  ${ECHO} ${DUPLICITY} ${OPTION} ${VERBOSITY} ${STATIC_OPTIONS} \
  ${GPG_OPTIONS} \
  ${EXCLUDE} \
  ${INCLUDE} \
  ${EXCLUDEROOT} \
  ${ROOT} ${DEST} \
  >> ${LOGFILE}
}

get_file_sizes()
{
  get_source_file_size
  get_remote_file_size

  sed -i '/-------------------------------------------------/d' ${LOGFILE}
  chown ${LOG_FILE_OWNER} ${LOGFILE}
}

backup_this_script()
{
  if [ $(echo ${0} | cut -c 1) = "." ]; then
    SCRIPTFILE=$(echo ${0} | cut -c 2-)
    SCRIPTPATH=$(pwd)${SCRIPTFILE}
  else
    SCRIPTPATH=$(which ${0})
  fi
  TMPDIR=dt-ssh-backup-$(date +%Y-%m-%d)
  TMPFILENAME=${TMPDIR}.tar.gpg
  README=${TMPDIR}/README

  echo "You are backing up: "
  echo "      1. ${SCRIPTPATH}"
  if [ ! -z "${GPG_KEY}" ]; then
        echo "      2. GPG Secret Key: ${GPG_KEY}"
        fi
  echo "Backup will be saved to: $(pwd)/${TMPFILENAME}"
  echo
  echo ">> Are you sure you want to do that ('yes' to continue)?"
  read ANSWER
  if [ "$ANSWER" != "yes" ]; then
    echo "You said << ${ANSWER} >> so I am exiting now."
    exit 1
  fi

  mkdir -p ${TMPDIR}
  cp $SCRIPTPATH ${TMPDIR}/
  if [ ! -z "${GPG_KEY}" ]; then
        gpg -a --export-secret-keys ${GPG_KEY} > ${TMPDIR}/secret.key.txt
        fi
  echo -e ${README_TXT} > ${README}
  echo "Encrypting tarball, choose a password you'll remember..."
  tar c ${TMPDIR} | gpg -aco ${TMPFILENAME}
  rm -Rf ${TMPDIR}
  echo -e "\nIMPORTANT!!"
  echo ">> To restore these files, run the following (remember your password):"
  echo "gpg -d ${TMPFILENAME} | tar x"
  echo -e "\nYou may want to write the above down and save it with the file."
}

check_variables ()
{
  if [[ ${ROOT} = "" || ${DEST} = "" || ${INCLIST} = "" || \
       ${GPG_KEY} = "foobar_gpg_key" || \
       ${PASSPHRASE} = "foobar_gpg_passphrase" ]]; then
    echo -e ${CONFIG_VAR_MSG}
    echo -e ${CONFIG_VAR_MSG}"\n--------    END    --------" >> ${LOGFILE}
    exit 1
  fi
}

echo -e "--------    START DT-SSH-BACKUP SCRIPT    --------\n" >> ${LOGFILE}

if [ "$1" = "--backup-script" ]; then
  backup_this_script
  exit
elif [ "$1" = "--full" ]; then
  check_variables
  OPTION="full"
  include_exclude
  duplicity_backup
  duplicity_cleanup
  get_file_sizes

elif [ "$1" = "--verify" ]; then
  check_variables
  OLDROOT=${ROOT}
  ROOT=${DEST}
  DEST=${OLDROOT}
  OPTION="verify"

  echo -e "-------[ Verifying Source & Destination ]-------\n" >> ${LOGFILE}
  include_exclude
  duplicity_backup

  OLDROOT=${ROOT}
  ROOT=${DEST}
  DEST=${OLDROOT}

  get_file_sizes

  echo -e "Verify complete.  Check the log file for results:\n>> ${LOGFILE}"

elif [ "$1" = "--restore" ]; then
  check_variables
  ROOT=$DEST
  OPTION="restore"

  if [[ ! "$2" ]]; then
    echo "Please provide a destination path (eg, /home/user/dir):"
    read -e NEWDESTINATION
    DEST=$NEWDESTINATION
    echo ">> You will restore from ${ROOT} to ${DEST}"
    echo "Are you sure you want to do that ('yes' to continue)?"
    read ANSWER
    if [[ "$ANSWER" != "yes" ]]; then
      echo "You said << ${ANSWER} >> so I am exiting now."
      echo -e "User aborted restore process ...\n" >> ${LOGFILE}
      exit 1
    fi
  else
    DEST=$2
  fi

  echo "Attempting to restore now ..."
  duplicity_backup

elif [ "$1" = "--restore-file" ]; then
  check_variables
  ROOT=$DEST
  INCLUDE=
  EXCLUDE=
  EXLUDEROOT=
  OPTION=

  if [[ ! "$2" ]]; then
    echo "Which file do you want to restore (eg, mail/letter.txt):"
    read -e FILE_TO_RESTORE
    FILE_TO_RESTORE=$FILE_TO_RESTORE
    echo
  else
    FILE_TO_RESTORE=$2
  fi

  if [[ "$3" ]]; then
    DEST=$3
  else
                DEST=$(basename $FILE_TO_RESTORE)
  fi

  echo -e "YOU ARE ABOUT TO..."
  echo -e ">> RESTORE: $FILE_TO_RESTORE"
  echo -e ">> TO: ${DEST}"
  echo -e "\nAre you sure you want to do that ('yes' to continue)?"
  read ANSWER
  if [ "$ANSWER" != "yes" ]; then
    echo "You said << ${ANSWER} >> so I am exiting now."
    echo -e "--------    END    --------\n" >> ${LOGFILE}
    exit 1
  fi

  echo "Restoring now ..."
  #use INCLUDE variable without create another one
  INCLUDE="--file-to-restore ${FILE_TO_RESTORE}"
  duplicity_backup

elif [ "$1" = "--list-current-files" ]; then
  check_variables
  OPTION="list-current-files"
  ${DUPLICITY} ${OPTION} ${VERBOSITY} ${STATIC_OPTIONS} \
        ${GPG_OPTIONS} \
  ${DEST}
  echo -e "--------    END    --------\n" >> ${LOGFILE}

elif [ "$1" = "--backup" ]; then
  check_variables
  include_exclude
  duplicity_backup
  duplicity_cleanup
  get_file_sizes

else
  echo -e "[Only show $(basename $0) usage options]\n" >> ${LOGFILE}
  echo "  USAGE:
    $(basename $0) [options]

  Options:
    --backup: runs an incremental backup
    --full: forces a full backup

    --verify: verifies the backup
    --restore [path]: restores the entire backup
    --restore-file [file] [destination/filename]: restore a specific file
    --list-current-files: lists the files currently backed up in the archive

    --backup-script: automatically backup the script and secret key to the current working directory

  CURRENT SCRIPT VARIABLES:
  ========================
    DEST (backup destination) = ${DEST}
    INCLIST (directories included) = ${INCLIST[@]:0}
    EXCLIST (directories excluded) = ${EXCLIST[@]:0}
    ROOT (root directory of backup) = ${ROOT}
  "
fi

echo -e "--------    END DT-SSH-BACKUP SCRIPT    --------\n" >> ${LOGFILE}

if [ $EMAIL_TO ]; then
  if [ ! -x "$MAIL" ]; then
    echo -e "Email coulnd't be sent. mailx not available." >> ${LOGFILE}
  else
    EMAIL_FROM=${EMAIL_FROM:+"-r ${EMAIL_FROM}"}
    EMAIL_SUBJECT=${EMAIL_SUBJECT:="DT-S3 Alert ${LOG_FILE}"}
    ${MAIL} -s """${EMAIL_SUBJECT}""" $EMAIL_FROM ${EMAIL_TO} < ${LOGFILE}
    echo -e "Email alert sent to ${EMAIL_TO} using ${MAIL}" >> ${LOGFILE}
  fi
fi

if [ ${ECHO} ]; then
  echo "TEST RUN ONLY: Check the logfile for command output."
fi
