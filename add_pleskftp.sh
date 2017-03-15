[root@ijlamp-1 ~]# cat /root/bin/add_pleskftp.sh
#!/bin/sh

PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin:/usr/local/psa/bin:/usr/local/psa/admin/sbin:/root/bin

# Comprobamos parametros
if [ -z "$1" -o -z "$2" -o -z "$3" -o -z "$4" ]
then
        echo "Usage: $0 dominio usuario password directorio"
        exit 1
fi

DOMINIO=$1
USUARIO=$2
PASSWRD=$3
RELPATH=$4

# Verificamos que el dominio existe en Plesk
VHOSTPATH=/var/www/vhosts/${DOMINIO}
if [ ! -d ${VHOSTPATH} ]
then
        echo "El dominio ${DOMINIO} no existe en Plesk"
        exit 1
fi

# Verificamos que el usuario no exista en el sistema
USEREXISTS=`id -u ${USUARIO} 2> /dev/null || echo no`
if [ "${USEREXISTS}" != "no" ]
then
        echo "El usuario ${USUARIO} ya existe en el sistema"
        exit 1
fi

# Verificamos que el HOMEDIR exista
CHECK=`echo ${RELPATH} | grep -c "^/"`
if [ ${CHECK} -gt 0 ]
then
        HOMEDIR=${VHOSTPATH}${RELPATH}
else
        HOMEDIR=${VHOSTPATH}/${RELPATH}
fi
if [ ! -d ${HOMEDIR} ]
then
        echo "El directorio ${HOMEDIR} no existe"
        exit 1
fi

HOMEUID=$(stat -c %u ${HOMEDIR})

if [ $HOMEUID -lt 500 ]
then
        echo "El UID es demasiado bajo, comprueba el propietario de ${HOMEDIR}"
        exit 1
fi

# Creamos el usuario, cambiamos el password y le damos permisos
useradd -d${HOMEDIR} -o -u${HOMEUID} -gpsacln -s/bin/false ${USUARIO}
echo "${PASSWRD}" | passwd --stdin ${USUARIO}
#chmod -R a+w $HOMEDIR
# Reinicio del FTP para que actualice usuarios
service xinetd restart
# Todo ha ido bien
echo "Usuario ${USUARIO} creado con CHROOT a ${HOMEDIR}"
