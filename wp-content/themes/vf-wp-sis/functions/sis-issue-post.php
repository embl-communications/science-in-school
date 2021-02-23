<?php


  /**
   * Action: `init`
   * Register the custom post type
   */

add_action(
  'init',
  'sis_issue_init_register'
);

  function sis_issue_init_register() {
    register_post_type('sis-issue', array(
      'labels'              => sis_issue_get_labels(),
      'description'         => __('SIS Issue', 'vfwp'),
      'public'              => true,
      'hierarchical'        => true,
      'exclude_from_search' => false,
      'publicly_queryable'  => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'show_in_rest'        => true,
      'rest_base'           => "sis-issue",
      'menu_icon'           => 'dashicons-book-alt',
      'capability_type'     => 'page',
      'supports'            => array('title', 'editor', 'page-attributes', 'excerpt', 'thumbnail'),
      'has_archive'         => true,
      'rewrite'             => array(
        'slug' => 'sis-issue'
      ),
      'query_var'           => true,
      'can_export'          => true,
      'delete_with_user'    => false,
      'taxonomies'          => array(
        'age-group'
      ),
    ));

  }
  /**
   * Reference: `get_post_type_labels`
   * https://core.trac.wordpress.org/browser/tags/5.4/src/wp-includes/post.php
   */
  function sis_issue_get_labels() {
    return array(
      'name'                     => _x( 'SIS Issues', 'SIS Issue type general name', 'vfwp' ),
      'singular_name'            => _x( 'SIS Issue', 'SIS Issue type singular name', 'vfwp' ),
      'add_new'                  => _x( 'Add New', 'SIS Issue', 'vfwp' ),
      'add_new_item'             => __( 'Add New SIS Issue', 'vfwp' ),
      'edit_item'                => __( 'Edit SIS Issue', 'vfwp' ),
      'new_item'                 => __( 'New SIS Issue', 'vfwp' ),
      'view_item'                => __( 'View SIS Issue', 'vfwp' ),
      'view_items'               => __( 'View SIS Issues', 'vfwp' ),
      'search_items'             => __( 'Search SIS Issues', 'vfwp' ),
      'not_found'                => __( 'No SIS Issues found.', 'vfwp' ),
      'not_found_in_trash'       => __( 'No SIS Issues found in Trash.', 'vfwp' ),
      'parent_item_colon'        => __( 'Parent Page:', 'vfwp' ),
      'all_items'                => __( 'All SIS Issues', 'vfwp' ),
      'archives'                 => __( 'SIS Issue Archives', 'vfwp' ),
      'attributes'               => __( 'SIS Issue Attributes', 'vfwp' ),
      'insert_into_item'         => __( 'Insert into SIS Issue', 'vfwp' ),
      'uploaded_to_this_item'    => __( 'Uploaded to this SIS Issue', 'vfwp' ),
      'featured_image'           => _x( 'Featured image', 'SIS Issue', 'vfwp' ),
      'set_featured_image'       => _x( 'Set featured image', 'SIS Issue', 'vfwp' ),
      'remove_featured_image'    => _x( 'Remove featured image', 'SIS Issue', 'vfwp' ),
      'use_featured_image'       => _x( 'Use as featured image', 'SIS Issue', 'vfwp' ),
      'filter_items_list'        => __( 'Filter SIS Issues list', 'vfwp' ),
      'items_list_navigation'    => __( 'SIS Issues list navigation', 'vfwp' ),
      'items_list'               => __( 'SIS Issues list', 'vfwp' ),
      'item_published'           => __( 'SIS Issue published.', 'vfwp' ),
      'item_published_privately' => __( 'SIS Issue published privately.', 'vfwp' ),
      'item_reverted_to_draft'   => __( 'SIS Issue reverted to draft.', 'vfwp' ),
      'item_scheduled'           => __( 'SIS Issue scheduled.', 'vfwp' ),
      'item_updated'             => __( 'SIS Issue updated.', 'vfwp' ),
    );
  }


