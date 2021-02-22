#!/bin/bash
#set -x
# determine root of repo
ROOT=$(cd $(dirname ${0})/../.. 2>/dev/null && pwd -P);
cd ${ROOT};
# set environment variables
set -a; . ${ROOT}/.env; set +a;
# WP Site Docker URL passed by script argument
WP_SITE_URL=$1;

if [ ! -d ${RELATIVE_DOCUMENT_ROOT} ]; then
    echo "${RELATIVE_DOCUMENT_ROOT} folder doesn't exists!";
    exit 1;
fi;

cd ${RELATIVE_DOCUMENT_ROOT}


ls -l

# Check if wordpress tables/db installed, if not then install them.
# This condition applies in case of first time site installation.
if ! $(wp core is-installed); then
    # Download core.
    echo "Downloading Wordpress core..."
    wp core download
fi

# Create WP config file (if one doesn't already exist).
echo "Creating Wordpress database"
if [ ! -f wp-config.php ]; then
    wp config create \
        --dbhost="mysql:3306" \
        --dbname=${DOCKER_DATABASE} \
        --dbuser=${DOCKER_DATABASE_USER} \
        --dbpass=${DOCKER_DATABASE_PASS} \
        --force \
        --allow-root 
fi

## Perform WP installation process.
if ! $(wp core is-installed); then
    echo "Installing Wordpress & configuring database"
    wp core install \
        --url=${WP_SITE_URL} \
        --title="${WP_SITE_TITLE}" \
        --admin_user=${WP_SITE_ADMIN_USERNAME} \
        --admin_password=${WP_SITE_ADMIN_PASSWORD} \
        --admin_email=${WP_SITE_ADMIN_EMAIL} \
        --allow-root
fi

# Configure the site url in config
wp config set WP_SITEURL "$WP_SITE_URL"
wp config set WP_HOME "$WP_SITE_URL"

if [ "${WP_NEED_BLANK_SITE}" = "Yes" ]; then
    echo "WordPress defaults - removing default junk"
    # Remove all posts, comments, and terms.
    wp site empty --yes --allow-root

    # Remove default plugins and themes.
    wp plugin delete hello --allow-root
    wp plugin delete akismet --allow-root
    wp theme delete twentyfifteen --allow-root
    wp theme delete twentysixteen --allow-root

    # Remove widgets.
    wp widget delete recent-posts-2 --allow-root
    wp widget delete recent-comments-2 --allow-root
    wp widget delete archives-2 --allow-root
    wp widget delete search-2 --allow-root
    wp widget delete categories-2 --allow-root
    wp widget delete meta-2 --allow-root
fi

#UPDATE wp_posts SET post_content=(REPLACE (post_content, 'http://dev.thetgmi.org','http://thetgmi.org.docker.localhost:32811'));

# Update password for admin
wp user update 1 --user_pass=admin --skip-email

echo "Create .htaccess file"
echo "
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress" >> ./.htaccess

wp rewrite flush

echo "Wordpress local setup completed!!!"
