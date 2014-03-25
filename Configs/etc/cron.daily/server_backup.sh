#!/bin/sh
# yourBackupShellFileName.sh
find /home/backups/* -mtime +30 -exec rm {} \;
Mdate="$(date +"%d-%m-%Y")"
mysqldump -uuser -pdbpass alltutors_ru --ignore-table=alltutors_ru.cities --ignore-table=alltutors_ru.coutries --ignore-table=alltutors_ru.regions | gzip > /home/backups/backup.$Mdate.sql.gz