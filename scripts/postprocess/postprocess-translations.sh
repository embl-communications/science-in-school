#!/bin/bash

# halt on errors
set -e;
set -u;

SCRIPTS_DEPLOY_DIR=$(pwd -P);

source ../backup/backup_secrets.sh

# Post processing for translations
mysql  -u ${USER} --password=${PASS} -h ${HOST} ${DB} < ./postprocess-translations.sql



# Back to deployment directory
cd ${SCRIPTS_DEPLOY_DIR}