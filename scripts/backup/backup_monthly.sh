#!/bin/bash

# halt on errors
set -x
set -e;
set -u;

interval=monthly

source ./backup_core.sh
