<?php


/**
 * Action: `init`
 */
add_action(
    'init',
    'vf_wp_sis_taxonomies__init'
);


// SIS taxonomy: Ages
function vf_wp_sis_ages_labels()
{
    return array(
        'name' => _x('Ages', 'taxonomy general name', 'vfwp'),
        'singular_name' => _x('Ages', 'taxonomy singular name', 'vfwp'),
        'search_items' => __('Search Ages', 'vfwp'),
        'all_items' => __('All Ages', 'vfwp'),
        'parent_item' => __('Parent Ages', 'vfwp'),
        'parent_item_colon' => __('Parent Ages:', 'vfwp'),
        'edit_item' => __('Edit Ages', 'vfwp'),
        'update_item' => __('Update Ages', 'vfwp'),
        'add_new_item' => __('Add New Ages', 'vfwp'),
        'new_item_name' => __('New Ages Name', 'vfwp'),
        'menu_name' => __('Ages', 'vfwp'),
    );
}


// SIS taxonomy: Article Types
function vf_wp_sis_article_types_labels()
{
    return array(
        'name' => _x('Article Types', 'taxonomy general name', 'vfwp'),
        'singular_name' => _x('Article Types', 'taxonomy singular name', 'vfwp'),
        'search_items' => __('Search Article Types', 'vfwp'),
        'all_items' => __('All Article Types', 'vfwp'),
        'parent_item' => __('Parent Article Types', 'vfwp'),
        'parent_item_colon' => __('Parent Article Types:', 'vfwp'),
        'edit_item' => __('Edit Article Types', 'vfwp'),
        'update_item' => __('Update Article Types', 'vfwp'),
        'add_new_item' => __('Add New Article Types', 'vfwp'),
        'new_item_name' => __('New Article Types Name', 'vfwp'),
        'menu_name' => __('Article Types', 'vfwp'),
    );
}


// SIS taxonomy: Categories
function vf_wp_sis_categories_labels()
{
    return array(
        'name' => _x('Categories', 'taxonomy general name', 'vfwp'),
        'singular_name' => _x('Categories', 'taxonomy singular name', 'vfwp'),
        'search_items' => __('Search Categories', 'vfwp'),
        'all_items' => __('All Categories', 'vfwp'),
        'parent_item' => __('Parent Categories', 'vfwp'),
        'parent_item_colon' => __('Parent Categories:', 'vfwp'),
        'edit_item' => __('Edit Categories', 'vfwp'),
        'update_item' => __('Update Categories', 'vfwp'),
        'add_new_item' => __('Add New Categories', 'vfwp'),
        'new_item_name' => __('New Categories Name', 'vfwp'),
        'menu_name' => __('Categories', 'vfwp'),
    );
}


// SIS taxonomy: Editor Tags
function vf_wp_sis_editor_tags_labels()
{
    return array(
        'name' => _x('Editor Tags', 'taxonomy general name', 'vfwp'),
        'singular_name' => _x('Editor Tags', 'taxonomy singular name', 'vfwp'),
        'search_items' => __('Search Editor Tags', 'vfwp'),
        'all_items' => __('All Editor Tags', 'vfwp'),
        'parent_item' => __('Parent Editor Tags', 'vfwp'),
        'parent_item_colon' => __('Parent Editor Tags:', 'vfwp'),
        'edit_item' => __('Edit Editor Tags', 'vfwp'),
        'update_item' => __('Update Editor Tags', 'vfwp'),
        'add_new_item' => __('Add New Editor Tags', 'vfwp'),
        'new_item_name' => __('New Editor Tags Name', 'vfwp'),
        'menu_name' => __('Editor Tags', 'vfwp'),
    );
}


// SIS taxonomy: Institutions
function vf_wp_sis_institutions_labels()
{
    return array(
        'name' => _x('Institutions', 'taxonomy general name', 'vfwp'),
        'singular_name' => _x('Institutions', 'taxonomy singular name', 'vfwp'),
        'search_items' => __('Search Institutions', 'vfwp'),
        'all_items' => __('All Institutions', 'vfwp'),
        'parent_item' => __('Parent Institutions', 'vfwp'),
        'parent_item_colon' => __('Parent Institutions:', 'vfwp'),
        'edit_item' => __('Edit Institutions', 'vfwp'),
        'update_item' => __('Update Institutions', 'vfwp'),
        'add_new_item' => __('Add New Institutions', 'vfwp'),
        'new_item_name' => __('New Institutions Name', 'vfwp'),
        'menu_name' => __('Institutions', 'vfwp'),
    );
}


// SIS taxonomy: Issues
function vf_wp_sis_issues_labels()
{
    return array(
        'name' => _x('Issues', 'taxonomy general name', 'vfwp'),
        'singular_name' => _x('Issues', 'taxonomy singular name', 'vfwp'),
        'search_items' => __('Search Issues', 'vfwp'),
        'all_items' => __('All Issues', 'vfwp'),
        'parent_item' => __('Parent Issues', 'vfwp'),
        'parent_item_colon' => __('Parent Issues:', 'vfwp'),
        'edit_item' => __('Edit Issues', 'vfwp'),
        'update_item' => __('Update Issues', 'vfwp'),
        'add_new_item' => __('Add New Issues', 'vfwp'),
        'new_item_name' => __('New Issues Name', 'vfwp'),
        'menu_name' => __('Issues', 'vfwp'),
    );
}


// SIS taxonomy: License
function vf_wp_sis_license_labels()
{
    return array(
        'name' => _x('License', 'taxonomy general name', 'vfwp'),
        'singular_name' => _x('License', 'taxonomy singular name', 'vfwp'),
        'search_items' => __('Search License', 'vfwp'),
        'all_items' => __('All License', 'vfwp'),
        'parent_item' => __('Parent License', 'vfwp'),
        'parent_item_colon' => __('Parent License:', 'vfwp'),
        'edit_item' => __('Edit License', 'vfwp'),
        'update_item' => __('Update License', 'vfwp'),
        'add_new_item' => __('Add New License', 'vfwp'),
        'new_item_name' => __('New License Name', 'vfwp'),
        'menu_name' => __('License', 'vfwp'),
    );
}


// SIS taxonomy: Reviewer Tags
function vf_wp_sis_reviewer_tags_labels()
{
    return array(
        'name' => _x('Reviewer Tags', 'taxonomy general name', 'vfwp'),
        'singular_name' => _x('Reviewer Tags', 'taxonomy singular name', 'vfwp'),
        'search_items' => __('Search Reviewer Tags', 'vfwp'),
        'all_items' => __('All Reviewer Tags', 'vfwp'),
        'parent_item' => __('Parent Reviewer Tags', 'vfwp'),
        'parent_item_colon' => __('Parent Reviewer Tags:', 'vfwp'),
        'edit_item' => __('Edit Reviewer Tags', 'vfwp'),
        'update_item' => __('Update Reviewer Tags', 'vfwp'),
        'add_new_item' => __('Add New Reviewer Tags', 'vfwp'),
        'new_item_name' => __('New Reviewer Tags Name', 'vfwp'),
        'menu_name' => __('Reviewer Tags', 'vfwp'),
    );
}


// SIS taxonomy: Series
function vf_wp_sis_series_labels()
{
    return array(
        'name' => _x('Series', 'taxonomy general name', 'vfwp'),
        'singular_name' => _x('Series', 'taxonomy singular name', 'vfwp'),
        'search_items' => __('Search Series', 'vfwp'),
        'all_items' => __('All Series', 'vfwp'),
        'parent_item' => __('Parent Series', 'vfwp'),
        'parent_item_colon' => __('Parent Series:', 'vfwp'),
        'edit_item' => __('Edit Series', 'vfwp'),
        'update_item' => __('Update Series', 'vfwp'),
        'add_new_item' => __('Add New Series', 'vfwp'),
        'new_item_name' => __('New Series Name', 'vfwp'),
        'menu_name' => __('Series', 'vfwp'),
    );
}


function vf_wp_sis_taxonomies__init()
{
    // SIS Taxonomy: ages
    register_taxonomy('sis-ages', array('sis-article'), array(
        'labels' => vf_wp_sis_ages_labels(),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'rewrite' => false,
        'show_in_rest' => false,
        'show_in_menu' => true
    ));


    // SIS Taxonomy: article types
    register_taxonomy('sis-article-types', array('sis-article'), array(
        'labels' => vf_wp_sis_article_types_labels(),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'rewrite' => false,
        'show_in_rest' => false,
        'show_in_menu' => true
    ));


    // SIS Taxonomy: categories
    register_taxonomy('sis-categories', array('sis-article'), array(
        'labels' => vf_wp_sis_categories_labels(),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'rewrite' => false,
        'show_in_rest' => false,
        'show_in_menu' => true
    ));


    // SIS Taxonomy: editor tags
    register_taxonomy('sis-editor-tags', array('sis-article'), array(
        'labels' => vf_wp_sis_editor_tags_labels(),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => false,
        'query_var' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'rewrite' => false,
        'show_in_rest' => false,
        'show_in_menu' => true
    ));


    // SIS Taxonomy: institutions
    register_taxonomy('sis-institutions', array('sis-article'), array(
        'labels' => vf_wp_sis_institutions_labels(),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => false,
        'query_var' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'rewrite' => false,
        'show_in_rest' => false,
        'show_in_menu' => true
    ));


    // SIS Taxonomy: issues
    register_taxonomy('sis-issues', array('sis-article', 'sis-issue'), array(
        'labels' => vf_wp_sis_issues_labels(),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'rewrite' => false,
        'show_in_rest' => false,
        'show_in_menu' => true
    ));


    // SIS Taxonomy: license
    register_taxonomy('sis-license', array('sis-article'), array(
        'labels' => vf_wp_sis_license_labels(),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => false,
        'query_var' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'rewrite' => false,
        'show_in_rest' => false,
        'show_in_menu' => true
    ));


    // SIS Taxonomy: reviewer tags
    register_taxonomy('sis-reviewer-tags', array('sis-article'), array(
        'labels' => vf_wp_sis_reviewer_tags_labels(),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => false,
        'query_var' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'rewrite' => false,
        'show_in_rest' => false,
        'show_in_menu' => true
    ));


    // SIS Taxonomy: series
    register_taxonomy('sis-series', array('sis-article'), array(
        'labels' => vf_wp_sis_series_labels(),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => false,
        'query_var' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'rewrite' => false,
        'show_in_rest' => false,
        'show_in_menu' => true
    ));

}

