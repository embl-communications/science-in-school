#!/bin/bash

# halt on errors
set -e;
set -u;

SCRIPTS_DEPLOY_DIR=$(pwd -P);

source ../backup/backup_secrets.sh

# Post processing for taxonomies
mysql  -u ${USER} --password=${PASS} -h ${HOST} ${DB} < ./postprocess-taxonomies.sql



# Back to deployment directory
cd ${SCRIPTS_DEPLOY_DIR}
