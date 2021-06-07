<?php

require_once('functions/sis-article-post.php');
require_once('functions/sis-issue-post.php');

require_once('functions/custom-taxonomies.php');

require_once('functions/ells-breadcrumbs.php');

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

add_filter('body_class', 'my_body_classes');
function my_body_classes($classes)
{
    $classes[] = 'vf-wp-sis';
    return $classes;
}


add_filter('acf/settings/remove_wp_meta_box', '__return_false');
add_filter('acf/settings/show_admin', '__return_true');

function my_acf_save_post($post_id)
{
    // get new value
    $user = get_field('author', $post_id);
    if ($user) {
        wp_update_post(array('ID' => $post_id, 'post_author' => $user['ID']));
    }
}

add_action('acf/save_post', 'my_acf_save_post', 20);

function sis_printTags($art_tags){
    sis_printTagsWithHeader('', $art_tags);
}

function sis_printTagsWithHeader($header, $art_tags){
    sis_printTagsWithHeaderAndEnd($header, $art_tags, '');
}

function sis_printTagsWithHeaderAndEnd($header, $art_tags, $end){
    if (is_array($art_tags)) {
        $count = 0;
        foreach ($art_tags as $tagId) {
            if($count == 0){
                print $header;
            }
            if($count > 0){
                print ', ';
            }
            $count++;
            $tag = get_term($tagId);
            echo $tag->name . ' ';
        }
        if($count > 0){
            print $end;
        }
    }
}

function sis_printSingleTag($art_tag){
    if (!empty($art_tag)) {
        $tag = get_term($art_tag);
        echo $tag->name . ' ';
    }
}

function sis_printFieldWithHeader($header, $field){
    if(trim($field) != ''){
        print $header;
        print $field;
    }
}

function sis_printArticlePDFLink($art_pdf){
    if (is_array($art_pdf) && array_key_exists("url", $art_pdf)) {
        echo $art_pdf['url'];
    }
}

// custom language switcher for the WPML plugin
function languages_links_switcher(){
    var_dump(icl_get_languages('skip_missing=1'));
    $languages = icl_get_languages('skip_missing=1');
    if(1 < count($languages)){ echo __(' <div class="vf-banner vf-banner--alert vf-banner--info | vf-u-margin__bottom--200">
  <div class="vf-banner__content">
    <style>
      .vf-banner__content p {
        font-size: 16px !important;
        margin: 0px !important;
      }
    </style>
    <p class="vf-banner__text">This article is also available in ');
        foreach($languages as $l){
            if(!$l['active']) $langs[] = '<a href="'.$l['url'].'"><img class="wpml-ls-flag iclflag" src="' . $l['country_flag_url'].'" />&nbsp;' .$l['native_name'].'</a>';
        }
        echo join(' and ', array_filter(array_merge(array(join(', ', array_slice($langs, 0, -1))), array_slice($langs,
            -1)), 'strlen'));
        echo __('
    </p>
  </div>
  </div>' );
    }
}
