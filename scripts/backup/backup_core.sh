#!/bin/bash

# halt on errors
set -x
set -e;
set -u;

source ./backup_secrets.sh

echo "Starting to backup files."
tar c /var/www/html/wordpress | gzip --fast > /var/www/backup/wordpress.${interval}.tar.gz
tar c /usr/share/phpMyAdmin | gzip --fast > /var/www/backup/phpmyadmin${interval}.tar.gz

cd /var/www/backup

echo "Starting to dump the database."
mysqldump  -u ${USER} --password=${PASS} -h ${HOST} ${DB} > ${DUMPNAME}_${interval}.sql



