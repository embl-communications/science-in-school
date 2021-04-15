#!/bin/bash

# halt on errors
set -e;
set -u;

cd ../../dist/wp-content/plugins

ln -s /var/www/html/wp-content/plugins/content-views-query-and-display-post-page
ln -s /var/www/html/wp-content/plugins/custom-post-type-permalinks
ln -s /var/www/html/wp-content/plugins/custom-twitter-feeds
ln -s /var/www/html/wp-content/plugins/easy-wp-smtp
ln -s /var/www/html/wp-content/plugins/fg-drupal-to-wp-premium
ln -s /var/www/html/wp-content/plugins/fg-drupal-to-wp-premium-internationalization-module
ln -s /var/www/html/wp-content/plugins/fg-drupal-to-wp-premium-metatag-module
ln -s /var/www/html/wp-content/plugins/mailchimp-for-wp
ln -s /var/www/html/wp-content/plugins/mathml-block
ln -s /var/www/html/wp-content/plugins/post-types-order
ln -s /var/www/html/wp-content/plugins/redirection
ln -s /var/www/html/wp-content/plugins/relevanssi
ln -s /var/www/html/wp-content/plugins/taxonomy-terms-order
ln -s /var/www/html/wp-content/plugins/toolset-blocks
ln -s /var/www/html/wp-content/plugins/types
ln -s /var/www/html/wp-content/plugins/types-access

cd -

