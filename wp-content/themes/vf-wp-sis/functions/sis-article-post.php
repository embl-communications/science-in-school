<?php


/**
 * Action: `init`
 * Register the custom post type
 */

add_action(
    'init',
    'sis_article_init_register'
);

function sis_article_init_register()
{
    register_post_type('sis-article', array(
        'labels' => sis_article_get_labels(),
        'description' => __('SIS Article', 'vfwp'),
        'public' => true,
        'hierarchical' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'show_in_rest' => true,
        'rest_base' => "sis-article",
        'menu_icon' => 'dashicons-book-alt',
        'capability_type' => 'post',
        'supports' => array('title', 'editor', 'page-attributes', 'excerpt', 'thumbnail'),
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'article'
        ),
        'query_var' => true,
        'can_export' => true,
        'delete_with_user' => false,
        'taxonomies' => array(
            'sis-ages',
            'sis-article-types',
            'sis-categories',
            'sis-editor-tags',
            'sis-institutions',
            'sis-issues',
            'sis-license',
            'sis-reviewer-tags',
            'sis-series'
        ),
    ));

}

/**
 * Reference: `get_post_type_labels`
 * https://core.trac.wordpress.org/browser/tags/5.4/src/wp-includes/post.php
 */
function sis_article_get_labels()
{
    return array(
        'name' => _x('SIS Articles', 'SIS Article type general name', 'vfwp'),
        'singular_name' => _x('SIS Article', 'SIS Article type singular name', 'vfwp'),
        'add_new' => _x('Add New', 'SIS Article', 'vfwp'),
        'add_new_item' => __('Add New SIS Article', 'vfwp'),
        'edit_item' => __('Edit SIS Article', 'vfwp'),
        'new_item' => __('New SIS Article', 'vfwp'),
        'view_item' => __('View SIS Article', 'vfwp'),
        'view_items' => __('View SIS Articles', 'vfwp'),
        'search_items' => __('Search SIS Articles', 'vfwp'),
        'not_found' => __('No SIS Articles found.', 'vfwp'),
        'not_found_in_trash' => __('No SIS Articles found in Trash.', 'vfwp'),
        'parent_item_colon' => __('Parent Page:', 'vfwp'),
        'all_items' => __('All SIS Articles', 'vfwp'),
        'archives' => __('SIS Article Archives', 'vfwp'),
        'attributes' => __('SIS Article Attributes', 'vfwp'),
        'insert_into_item' => __('Insert into SIS Article', 'vfwp'),
        'uploaded_to_this_item' => __('Uploaded to this SIS Article', 'vfwp'),
        'featured_image' => _x('Featured image', 'SIS Article', 'vfwp'),
        'set_featured_image' => _x('Set featured image', 'SIS Article', 'vfwp'),
        'remove_featured_image' => _x('Remove featured image', 'SIS Article', 'vfwp'),
        'use_featured_image' => _x('Use as featured image', 'SIS Article', 'vfwp'),
        'filter_items_list' => __('Filter SIS Articles list', 'vfwp'),
        'items_list_navigation' => __('SIS Articles list navigation', 'vfwp'),
        'items_list' => __('SIS Articles list', 'vfwp'),
        'item_published' => __('SIS Article published.', 'vfwp'),
        'item_published_privately' => __('SIS Article published privately.', 'vfwp'),
        'item_reverted_to_draft' => __('SIS Article reverted to draft.', 'vfwp'),
        'item_scheduled' => __('SIS Article scheduled.', 'vfwp'),
        'item_updated' => __('SIS Article updated.', 'vfwp'),
    );
}


