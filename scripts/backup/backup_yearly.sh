#!/bin/bash

# halt on errors
set -e;
set -u;

interval=yearly

source /var/www/webdeploy/science-in-school/scripts/backup/backup_core.sh
