#!/bin/bash

# halt on errors
set -e;
set -u;

SCRIPTS_DEPLOY_DIR=$(pwd -P);

source ../backup/backup_secrets.sh

# Post processing for taxonomies
mysql  -u ${USER} --password=${PASS} -h ${HOST} ${DB} < ./postprocess-taxonomies.sql

# Post process for post types articles and issues and their custom fields
mysql  -u ${USER} --password=${PASS} -h ${HOST} ${DB} < ./postprocess-migration-review-fields.sql


# Back to deployment directory
cd ${SCRIPTS_DEPLOY_DIR}
