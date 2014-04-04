sub backup {

system ("mysqldump -av","-u root","-p balmes15","clouddb" >" /seguridad/backup.sql");
system ("rsync -r","/var/www/html/owncloud/data/*"," /seguridad/") ;


}                                                     
open my $tee, "|-", "tee file.log";
print $tee < &backup;
close $tee;  
