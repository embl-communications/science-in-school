#!/bin/bash

# halt on errors
set -e;
set -u;

SCRIPTS_DEPLOY_DIR=$(pwd -P);
WP_VERSION=latest

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

# Copy all files to website folder
cd /var/www/html/wordpress/
rm -rf ./wp-admin/
rm -rf ./wp-includes/

rm -f index.php
rm -f wp-activate.php
rm -f wp-blog-header.php
rm -f wp-comments-post.php
rm -f wp-cron.php
rm -f wp-links-opml.php
rm -f wp-load.php
rm -f wp-login.php
rm -f wp-mail.php
rm -f wp-settings.php
rm -f wp-signup.php
rm -f wp-trackback.php
rm -f xmlrpc.php

cd /var/www/webdeploy/science-in-school/deployable/wordpress/
cp -R ./wp-admin/ /var/www/html/wordpress/
cp -R ./wp-includes/ /var/www/html/wordpress/

cp wp-activate.php /var/www/html/wordpress/
cp wp-blog-header.php /var/www/html/wordpress/
cp wp-comments-post.php /var/www/html/wordpress/
cp wp-cron.php /var/www/html/wordpress/
cp wp-links-opml.php /var/www/html/wordpress/
cp wp-load.php /var/www/html/wordpress/
cp wp-login.php /var/www/html/wordpress/
cp wp-mail.php /var/www/html/wordpress/
cp wp-settings.php /var/www/html/wordpress/
cp wp-signup.php /var/www/html/wordpress/
cp wp-trackback.php /var/www/html/wordpress/
cp xmlrpc.php /var/www/html/wordpress/

chown -R apache:apache /var/www/html/wordpress


cd ${SCRIPTS_DEPLOY_DIR}

