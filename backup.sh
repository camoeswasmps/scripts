#!/bin/bash 
mysqldump -av -u root -pbalmes15 clouddb > /backup/backup.sql
rsync -r /var/www/html/oencloud/data/* /backup 
