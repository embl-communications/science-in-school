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

echo "Started configuring bootstrap settings for group VF site";

cd ${RELATIVE_DOCUMENT_ROOT}

# Change default tagline.
wp option update blogdescription "${WP_GROUP_SITE_DESCRIPTION}"
wp option update blogname "${WP_GROUP_SITE_TITLE}"
# Permalinks
wp option update permalink_structure /%year%/%monthnum%/%postname%/

# Turn on debugging.
wp config set WP_DEBUG true --raw --type="constant"
wp config set WP_DEBUG_LOG true --raw --type="constant"

if [ "${WP_NEED_BLANK_SITE}" = "Yes" ]; then
    echo "WordPress defaults - removing default junk"
    # Remove all posts, comments, and terms.
    wp site empty --yes

    # Remove default plugins and themes.
    wp plugin delete hello
    wp plugin delete akismet
    wp theme delete twentyfifteen
    wp theme delete twentysixteen

    # Remove widgets.
    wp widget delete recent-posts-2
    wp widget delete recent-comments-2
    wp widget delete archives-2
    wp widget delete search-2
    wp widget delete categories-2
    wp widget delete meta-2

    # Disable comments
    wp option update default_comment_status closed
fi


echo "Download core VF-WP plugins and themes"
rm -rf vf-wp || true;
git clone https://github.com/visual-framework/vf-wp.git
# Start symlink for plugins
mkdir ./wp-content # fallback to ensure this directory always exists
mkdir ./wp-content/plugins # fallback to ensure this directory always exists
if [ -d "./wp-content/plugins" ]; then
  echo "Creating Plugins symlinks";
  PLUGIN_DIRS=$(ls ./vf-wp/wp-content/plugins | xargs);
  for DIR in $PLUGIN_DIRS; do
    if [ -d "./vf-wp/wp-content/plugins/$DIR" ]; then
      ln -sf ${ROOT}/${RELATIVE_DOCUMENT_ROOT}/vf-wp/wp-content/plugins/${DIR} ${ROOT}/${RELATIVE_DOCUMENT_ROOT}/wp-content/plugins;
    fi
  done;
fi
# Start symlink for themes
echo "Creating Themes symlinks";
mkdir ./wp-content/themes
PLUGIN_DIRS=$(ls ./vf-wp/wp-content/themes | xargs);
for DIR in $PLUGIN_DIRS; do
  if [ -d "./vf-wp/wp-content/themes/$DIR" ]; then
    ln -sf ${ROOT}/${RELATIVE_DOCUMENT_ROOT}/vf-wp/wp-content/themes/${DIR} ${ROOT}/${RELATIVE_DOCUMENT_ROOT}/wp-content/themes;
  fi
done;

echo "Download external VF-WP plugins"
rm -rf vfwp-external-plugins || true;
git clone https://github.com/visual-framework/vfwp-external-plugins.git
# Start symlink for plugins
echo "Creating Plugins symlinks";
PLUGIN_DIRS=$(ls ./vfwp-external-plugins | xargs);
for DIR in $PLUGIN_DIRS; do
  if [ -d "./vfwp-external-plugins/$DIR" ]; then
    ln -sf ${ROOT}/${RELATIVE_DOCUMENT_ROOT}/vfwp-external-plugins/${DIR} ${ROOT}/${RELATIVE_DOCUMENT_ROOT}/wp-content/plugins;
  fi
done;


# List of Array for default VF plugins
PLUGINS_LIST='
advanced-custom-fields-pro
vf-wp
vf-latest-posts-block
vf-publications-block
vf-gutenberg
vf-group-header-block
vf-navigation-container
vf-banner-container
vf-hero-container
vf-masthead-container
';

echo "VF Plugins - Activating VF Plugins"
# Check if plugin is active, if not then activate plugins
for PLUGIN in ${PLUGINS_LIST}; do
    if ! $(wp plugin is-active ${PLUGIN}); then
        wp plugin activate ${PLUGIN}
    fi
done;

echo "Activating header/footer theme based plugins"
# Activate header/footer based on the theme given
if [ "$site_theme" = EBI* ]; then
     wp plugin activate 'vf-ebi-global-header-container' 'vf-ebi-global-footer-container'
else
    wp plugin activate 'vf-global-header-container' 'vf-global-footer-container'
fi

echo "VF theme - Activating VF theme"
if ! $(wp theme is-active vf-wp); then
       wp theme activate "vf-wp"
fi

wp plugin install user-role-editor --activate

# Define postcontent of vf_template.
case "$site_theme" in
    EMBL)
      vf_template_content='
        <!-- wp:acf/vf-container-global-header {"id":"block_5ebb9edff871c","name":"acf/vf-container-global-header"} /-->

<!-- wp:acf/vf-container-breadcrumbs {"id":"block_5ebb9fd224009","name":"acf/vf-container-breadcrumbs"} /-->

<!-- wp:acf/vf-container-wp-groups-header {"id":"block_5ebb9fe02400a","name":"acf/vf-container-wp-groups-header"} /-->

<!-- wp:acf/vf-container-page-template {"id":"block_5ebb9edff871d","name":"acf/vf-container-page-template"} /-->

<!-- wp:acf/vf-container-embl-news {"id":"block_5ebb9fef2400b","name":"acf/vf-container-embl-news"} /-->

<!-- wp:acf/vf-container-global-footer {"id":"block_5ebb9edff871e","name":"acf/vf-container-global-footer"} /-->';
    ;;
    EBI-SERVICE|EBI-CLUSTERS|EBI-RESEARCH)
      vf_template_content='
       <!-- wp:acf/vf-container-ebi-global-header {"id":"block_5ebba0902400e","name":"acf/vf-container-ebi-global-header"} /-->

<!-- wp:acf/vf-container-breadcrumbs {"id":"block_5ebb9fd224009","name":"acf/vf-container-breadcrumbs"} /-->

<!-- wp:acf/vf-container-wp-groups-header {"id":"block_5ebb9fe02400a","name":"acf/vf-container-wp-groups-header"} /-->

<!-- wp:acf/vf-container-page-template {"id":"block_5ebb9edff871d","name":"acf/vf-container-page-template"} /-->

<!-- wp:acf/vf-container-embl-news {"id":"block_5ebb9fef2400b","name":"acf/vf-container-embl-news"} /-->

<!-- wp:acf/vf-container-ebi-global-footer {"id":"block_5ebba0942400f","name":"acf/vf-container-ebi-global-footer"} /-->';
    ;;
    *)
      # Default content
      vf_template_content='
        <!-- wp:acf/vf-container-global-header {"id":"block_5ebb9edff871c","name":"acf/vf-container-global-header"} /-->

<!-- wp:acf/vf-container-page-template {"id":"block_5ebb9edff871d","name":"acf/vf-container-page-template"} /-->

<!-- wp:acf/vf-container-global-footer {"id":"block_5ebb9edff871e","name":"acf/vf-container-global-footer"} /-->';
    ;;
  esac;

echo "=== VF plugin config ==="
if [ $(wp option get show_on_front) != 'page' ] ; then
    echo "VF plugin config - setting config"
    # # Create some core pages
    home_page_id="$(wp post create --post_title='Home' --post_type=page --post_status=publish --porcelain)"
    blog_page_id="$(wp post create --post_title='Blog' --post_type=page --post_status=publish --porcelain)"

    # Lock the homepage and blog page agianst further edits from non-admins
    wp post meta update $home_page_id vf_locked 1
    wp post meta update $home_page_id _vf_locked field_vf_locked
    wp post meta update $blog_page_id vf_locked 1
    wp post meta update $blog_page_id _vf_locked field_vf_locked


    # # Core settings
    wp option update show_on_front 'page'
    wp option update page_on_front $home_page_id
    wp option update page_for_posts $blog_page_id
    wp option update date_format 'j F Y'
    wp option update default_ping_status 'closed'
    wp option update default_pingback_flag 0
    wp option update options_vf_cdn_stylesheet $VF_CDN_STYLESHEET
    wp option update options_vf_cdn_javascript $VF_CDN_JAVASCRIPT
    wp option update options_vf_api_url $VF_API_URL

    # Create menus
    wp menu create "Primary"
    wp menu location assign primary primary
    wp menu create "Secondary"
    wp menu location assign secondary secondary

    # Updated vf_template post content.
    vf_template_post_id="$(wp post list --name=default --post_type=vf_template --field=ID)";
    wp post update $vf_template_post_id --post_content="$vf_template_content";
else
    echo "VF plugin config - already configured"
fi

# Update blog post content
 wp post update 1 --post_title="Welcome to your new blog!" --post_content="$default_blog_post_content";

# Flush the rewrite cache from DB
wp rewrite flush

# Update DB if any.
wp core update-db

echo "Wordpress Group Visual framework local setup completed!!!"
