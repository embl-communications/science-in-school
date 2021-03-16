#!/bin/bash

# halt on errors
set -e;
set -u;

SCRIPTS_DEPLOY_DIR=$(pwd -P);
WP_VERSION=wordpress-5.7

cd ../../deployable/

rm -rf ./wp.tar.gz
rm -rf ./wordpress
curl -o wp.tar.gz https://wordpress.org/${WP_VERSION}.tar.gz

tar xzvf wp.tar.gz -C ./

rm -rf ./vf-wp
git clone https://github.com/visual-framework/vf-wp.git
cd ./vf-wp
git checkout master
git pull origin master
cd ..

rm -rf ./vfwp-external-plugins
git clone https://github.com/visual-framework/vfwp-external-plugins.git
cd ./vfwp-external-plugins
git checkout master
git pull origin master
cd ..

cd ${SCRIPTS_DEPLOY_DIR}

