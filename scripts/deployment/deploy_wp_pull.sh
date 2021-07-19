#!/bin/bash


# halt on errors
set -e;
set -u;

SCRIPTS_DEPLOY_DIR=$(pwd -P);
WP_VERSION=wordpress-5.6.2

# Important: Pull the current branch from origin, can be changed for dev.beta
# Should be main branch on production
git pull

cd ../../deployable/

rm -rf ./wp.tar.gz
rm -rf ./wordpress
curl -o wp.tar.gz https://wordpress.org/${WP_VERSION}.tar.gz

tar xzvf wp.tar.gz -C ./

rm -rf ./vf-wp
git clone https://github.com/visual-framework/vf-wp.git
cd ./vf-wp
git checkout v1.0.0-beta.53
cd ..

rm -rf ./vfwp-external-plugins
git clone https://github.com/visual-framework/vfwp-external-plugins.git
cd ./vfwp-external-plugins
git checkout 92f2dcd13046cbc44cb32f393d866e7eead089b1
cd ..

cd ${SCRIPTS_DEPLOY_DIR}

