#!/bin/bash

# halt on errors
set -x
set -e;
set -u;

interval=weekly

source ./backup_core.sh
