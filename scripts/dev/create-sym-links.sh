#!/bin/bash

# halt on errors
set -e;
set -u;

cd ../../dist/wp-content/plugins

rm -f ./content-views-query-and-display-post-page
rm -f ./easy-wp-smtp
rm -f ./fg-drupal-to-wp-premium
rm -f ./fg-drupal-to-wp-premium-internationalization-module
rm -f ./fg-drupal-to-wp-premium-metatag-module
rm -f ./mailchimp-for-wp
rm -f ./redirection
rm -f ./relevanssi
rm -f ./toolset-blocks
rm -f ./types
rm -f ./types-access

ln -s /var/www/html/wp-content/plugins/content-views-query-and-display-post-page
ln -s /var/www/html/wp-content/plugins/easy-wp-smtp
ln -s /var/www/html/wp-content/plugins/fg-drupal-to-wp-premium
ln -s /var/www/html/wp-content/plugins/fg-drupal-to-wp-premium-internationalization-module
ln -s /var/www/html/wp-content/plugins/fg-drupal-to-wp-premium-metatag-module
ln -s /var/www/html/wp-content/plugins/mailchimp-for-wp
ln -s /var/www/html/wp-content/plugins/redirection
ln -s /var/www/html/wp-content/plugins/relevanssi
ln -s /var/www/html/wp-content/plugins/toolset-blocks
ln -s /var/www/html/wp-content/plugins/types
ln -s /var/www/html/wp-content/plugins/types-access

cd -

