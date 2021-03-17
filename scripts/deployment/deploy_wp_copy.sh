#!/bin/bash

# halt on errors
set -e;
set -u;

SCRIPTS_DEPLOY_DIR=$(pwd -P);

# Copy all files to website folder
cd /var/www/html/wordpress/

# First remove wp-admin and wp-includes
rm -rf ./wp-admin/
rm -rf ./wp-includes/

## Remove all files on first level
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

# Remove special themes
cd /var/www/html/wordpress/wp-content/themes/
rm -rf ./vf-wp/
rm -rf ./vf-wp-documents/
rm -rf ./vf-wp-ells/
rm -rf ./vf-wp-elmi/
rm -rf ./vf-wp-groups/
rm -rf ./vf-wp-intranet/
rm -rf ./vf-wp-sis/

# Remove special plugins
cd /var/www/html/wordpress/wp-content/plugins/
rm -rf ./acf-better-search
rm -rf ./acfml
rm -rf ./advanced-custom-fields-pro
rm -rf ./duplicate-post
rm -rf ./header-footer
rm -rf ./hookpress
rm -rf ./sitepress-multilingual-cms
rm -rf ./widget-options
rm -rf ./wpml-media-translation
rm -rf ./wpml-string-translation
rm -rf ./wpml-translation-management

rm -rf ./embl-group-site-roles
rm -rf ./embl-taxonomy
rm -rf ./vf-banner-container
rm -rf ./vf-beta-container
rm -rf ./vf-breadcrumbs-container
rm -rf ./vf-data-resources-block
rm -rf ./vf-ebi-global-footer-container
rm -rf ./vf-ebi-global-header-container
rm -rf ./vf-embl-news-block
rm -rf ./vf-embl-news-container
rm -rf ./vf-events
rm -rf ./vf-example-block
rm -rf ./vf-factoid-block
rm -rf ./vf-global-footer-container
rm -rf ./vf-global-header-container
rm -rf ./vf-group-header-block
rm -rf ./vf-gutenberg
rm -rf ./vf-hero-container
rm -rf ./vf-hero-container-lp
rm -rf ./vf-intranet-breadcrumbs
rm -rf ./vf-jobs-block
rm -rf ./vf-latest-posts-block
rm -rf ./vf-masthead-container
rm -rf ./vf-members-block
rm -rf ./vf-navigation-container
rm -rf ./vf-publications-block
rm -rf ./vf-publications-group-ebi-block
rm -rf ./vf-wp

rm -rf ./content-views-query-and-display-post-page
rm -rf ./easy-wp-smtp
rm -rf ./fg-drupal-to-wp-premium
rm -rf ./fg-drupal-to-wp-premium-internationalization-module
rm -rf ./fg-drupal-to-wp-premium-metatag-module
rm -rf ./redirection
rm -rf ./relevanssi
rm -rf ./toolset-blocks
rm -rf ./types
rm -rf ./types-access


# Copy wp-admin and wp-includes with latest sources
cd /var/www/webdeploy/science-in-school/deployable/wordpress/
cp -R ./wp-admin/ /var/www/html/wordpress/
cp -R ./wp-includes/ /var/www/html/wordpress/

# Copy files in root directory with latest sources
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

# Copy special themes
cd /var/www/webdeploy/science-in-school/deployable/vf-wp/wp-content/themes/
cp -R ./vf-wp/ /var/www/html/wordpress/wp-content/themes/
cp -R ./vf-wp-documents/ /var/www/html/wordpress/wp-content/themes/
cp -R ./vf-wp-ells/ /var/www/html/wordpress/wp-content/themes/
cp -R ./vf-wp-elmi/ /var/www/html/wordpress/wp-content/themes/
cp -R ./vf-wp-groups/ /var/www/html/wordpress/wp-content/themes/
cp -R ./vf-wp-intranet/ /var/www/html/wordpress/wp-content/themes/

cd /var/www/webdeploy/science-in-school/wp-content/themes/
cp -R ./vf-wp-sis/ /var/www/html/wordpress/wp-content/themes/

# Copy special plugins
cd /var/www/webdeploy/science-in-school/deployable/vfwp-external-plugins/
cp -R ./acf-better-search /var/www/html/wordpress/wp-content/plugins/
cp -R ./acfml /var/www/html/wordpress/wp-content/plugins/
cp -R ./advanced-custom-fields-pro /var/www/html/wordpress/wp-content/plugins/
cp -R ./duplicate-post /var/www/html/wordpress/wp-content/plugins/
cp -R ./header-footer /var/www/html/wordpress/wp-content/plugins/
cp -R ./hookpress /var/www/html/wordpress/wp-content/plugins/
cp -R ./sitepress-multilingual-cms /var/www/html/wordpress/wp-content/plugins/
cp -R ./widget-options /var/www/html/wordpress/wp-content/plugins/
cp -R ./wpml-media-translation /var/www/html/wordpress/wp-content/plugins/
cp -R ./wpml-string-translation /var/www/html/wordpress/wp-content/plugins/
cp -R ./wpml-translation-management /var/www/html/wordpress/wp-content/plugins/

cd /var/www/webdeploy/science-in-school/deployable/vf-wp/wp-content/plugins/
cp -R ./embl-group-site-roles /var/www/html/wordpress/wp-content/plugins/
cp -R ./embl-taxonomy /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-banner-container /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-beta-container /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-breadcrumbs-container /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-data-resources-block /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-ebi-global-footer-container /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-ebi-global-header-container /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-embl-news-block /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-embl-news-container /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-events /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-example-block /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-factoid-block /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-global-footer-container /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-global-header-container /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-group-header-block /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-gutenberg /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-hero-container /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-hero-container-lp /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-intranet-breadcrumbs /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-jobs-block /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-latest-posts-block /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-masthead-container /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-members-block /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-navigation-container /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-publications-block /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-publications-group-ebi-block /var/www/html/wordpress/wp-content/plugins/
cp -R ./vf-wp /var/www/html/wordpress/wp-content/plugins/

cd /var/www/webdeploy/science-in-school/wp-content/plugins/
cp -R ./content-views-query-and-display-post-page /var/www/html/wordpress/wp-content/plugins/
cp -R ./easy-wp-smtp /var/www/html/wordpress/wp-content/plugins/
cp -R ./fg-drupal-to-wp-premium /var/www/html/wordpress/wp-content/plugins/
cp -R ./fg-drupal-to-wp-premium-internationalization-module /var/www/html/wordpress/wp-content/plugins/
cp -R ./fg-drupal-to-wp-premium-metatag-module /var/www/html/wordpress/wp-content/plugins/
cp -R ./redirection /var/www/html/wordpress/wp-content/plugins/
cp -R ./relevanssi /var/www/html/wordpress/wp-content/plugins/
cp -R ./toolset-blocks /var/www/html/wordpress/wp-content/plugins/
cp -R ./types /var/www/html/wordpress/wp-content/plugins/
cp -R ./types-access /var/www/html/wordpress/wp-content/plugins/

# Change owner and group to apache
chown -R apache:apache /var/www/html/wordpress

# Back to deployment directory
cd ${SCRIPTS_DEPLOY_DIR}

