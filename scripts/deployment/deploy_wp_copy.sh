#!/bin/bash

# halt on errors
set -e;
set -u;

SCRIPTS_DEPLOY_DIR=$(pwd -P);

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

cd /var/www/html/wordpress/wp-content/themes/
rm -rf ./vf-wp/
rm -rf ./vf-wp-documents/
rm -rf ./vf-wp-ells/
rm -rf ./vf-wp-elmi/
rm -rf ./vf-wp-groups/
rm -rf ./vf-wp-intranet/
rm -rf ./vf-wp-sis/


cd /var/www/webdeploy/science-in-school/deployable/wordpress/
cp -R ./wp-admin/ /var/www/html/wordpress/
cp -R ./wp-includes/ /var/www/html/wordpress/

cp index.php /var/www/html/wordpress/
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


cd /var/www/webdeploy/science-in-school/deployable/vf-wp/wp-content/themes/
cp -R ./vf-wp/ /var/www/html/wordpress/wp-content/themes/
cp -R ./vf-wp-documents/ /var/www/html/wordpress/wp-content/themes/
cp -R ./vf-wp-ells/ /var/www/html/wordpress/wp-content/themes/
cp -R ./vf-wp-elmi/ /var/www/html/wordpress/wp-content/themes/
cp -R ./vf-wp-groups/ /var/www/html/wordpress/wp-content/themes/
cp -R ./vf-wp-intranet/ /var/www/html/wordpress/wp-content/themes/

cd /var/www/webdeploy/science-in-school/wp-content/themes/
cp -R ./vf-wp-sis/ /var/www/html/wordpress/wp-content/themes/

chown -R apache:apache /var/www/html/wordpress


cd ${SCRIPTS_DEPLOY_DIR}

