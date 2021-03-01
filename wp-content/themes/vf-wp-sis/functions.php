<?php

require_once('functions/sis-article-post.php');
require_once('functions/sis-issue-post.php');

require_once('functions/custom-taxonomies.php');

require_once('functions/ells-breadcrumbs.php');
require_once('functions/embl-visit-post.php');

// enable featured image
add_theme_support('post-thumbnails');
add_theme_support('title-tag');

// CHILD THEME CSS FILE
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles()
{

  $parent_style = 'parent-style';

  wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
  wp_enqueue_style('child-style',
    get_stylesheet_directory_uri() . '/style.css',
    array($parent_style),
    wp_get_theme()->get('Version')
  );
}

