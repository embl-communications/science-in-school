#!/bin/bash

# IMPORTANT: This script is only allowed to be run on the DEV server!

# halt on errors
set -e;
set -u;

SCRIPTS_DEPLOY_DIR=$(pwd -P);

source /var/www/webdeploy/science-in-school/scripts/backup/backup_secrets.sh

# IMPORTANT: You have to run the backup_once.sh script on the BETA server before!
# Copy all files to website folder
cd /var/www/backup

# Delete all backup files
rm -f ./wp_db_once.sql
rm -f ./wordpress.once.tar.gz

# Copy files from beta to dev.beta
scp root@sis-web01:/var/www/backup/wp_db_once.sql .
scp root@sis-web01:/var/www/backup/wordpress.once.tar.gz .

# Delete current tables in database
TABLES=$(mysql -u ${USER} -p${PASS} ${DB} -e 'show tables' | awk '{ print $1}' | grep -v '^Tables' )

for t in $TABLES
do
	echo "Deleting $t table from ${DB} database..."
	#mysql -u ${USER} -p${PASS} ${DB} -e "drop table $t"
done

# Insert new data into database

# Delete old wordpress files

# Extract and copy new wordpress files
