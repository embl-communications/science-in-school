#!/bin/bash

# halt on errors
set -e;
set -u;

cd ../../dist/wp-content/plugins


rm -rf relevanssi-premium
rm -rf content-views-query-and-display-post-page
rm -rf custom-post-type-permalinks
rm -rf custom-twitter-feeds
rm -rf easy-wp-smtp
rm -rf fg-drupal-to-wp-premium
rm -rf fg-drupal-to-wp-premium-internationalization-module
rm -rf fg-drupal-to-wp-premium-metatag-module
rm -rf mailchimp-for-wp
rm -rf mathml-block
rm -rf post-types-order
rm -rf redirection
rm -rf relevanssi
rm -rf taxonomy-terms-order
rm -rf toolset-blocks
rm -rf types
rm -rf types-access

ln -s /var/www/html/wp-content/plugins/relevanssi-premium
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

