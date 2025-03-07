<?php

// Require Gutenberg block classes
require_once(__DIR__.'/../vf-wp/functions/theme-block.php');
require_once('blocks/vfwp-sis-info-box/index.php');

require_once('functions/sis-article-post.php');
require_once('functions/sis-issue-post.php');
require_once('functions/events-cpt.php');

require_once('functions/custom-taxonomies.php');


// enable featured image
add_theme_support('post-thumbnails');
add_theme_support('title-tag');

function sis_getArticleTypesArray(){
    $ARTICLE_TYPE_INSPIRE = 2559;
    $ARTICLE_TYPE_UNDERSTAND = 2558;
    $ARTICLE_TYPE_TEACH = 2560;
    $ARTICLE_TYPE_EDITORIAL = 2544;

    return array(
        'INSPIRE' => $ARTICLE_TYPE_INSPIRE,
        'UNDERSTAND' => $ARTICLE_TYPE_UNDERSTAND,
        'TEACH' => $ARTICLE_TYPE_TEACH,
        'EDITORIAL' => $ARTICLE_TYPE_EDITORIAL
    );
}

// CHILD THEME CSS FILE
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles', 30);
function my_theme_enqueue_styles() {
  $parent_style = 'parent-style';

  wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
  wp_enqueue_style('child-style',
    get_stylesheet_directory_uri() . '/style.css',
    array($parent_style),
    wp_get_theme()->get('Version')
  );
  // load the SiS specific VF styles
  wp_enqueue_style('vf-sis',
    get_stylesheet_directory_uri() . '/assets/css/styles.css',
    array('child-style'),
    wp_get_theme()->get('Version')
  );
  // unload the generic vf-wp styles
  wp_dequeue_style('vfwp');

  // load the SiS specific JS
  wp_enqueue_script(
    'vf-sis-scripts',
    get_stylesheet_directory_uri() . '/assets/scripts/scripts.js',
    array(),
    wp_get_theme()->get('Version'),
    true
  );
  // unload the generic vf-wp scripts
  wp_dequeue_script('vf-scripts');  
}

add_filter( 'body_class','my_body_classes' );
function my_body_classes( $classes ) {
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

function sis_getTermIdsFromGetParam($taxonomyName)
{
    $getParamArrayIds = array();
    $getParamValue = get_query_var($taxonomyName);
    if($getParamValue){
        $getParamArray = explode(',',$getParamValue);
        foreach($getParamArray as $singleGetParam){
            $term = get_term_by( 'slug', $singleGetParam, $taxonomyName);
            if($term){
                $getParamArrayIds[] = $term->term_id;
            }
        }
    }
    return $getParamArrayIds;
}

function sis_archive_page_query_mod( $query ) {
    $query['orderby'] = 'publish_date';
    $query['order'] = 'ASC';
    return $query;
}

function sis_disable_pagination( $query ) {
    if($query->get('post_type') == 'sis-issue') {
        $query->set('nopaging', true);
    }
}
add_action( 'pre_get_posts', 'sis_disable_pagination' );


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
            echo $tag->name;
        }
        if($count > 0){
            print $end;
        }
    }
}


function sis_printTagsWithBeforeAndAfter($before, $art_tags, $after){
    if (is_array($art_tags)) {
        $count = 0;
        foreach ($art_tags as $tagId) {
            print $before;
            if($count > 0){
                print ', ';
            }
            $count++;
            $tag = get_term($tagId);
            echo $tag->name . $after;
        }
    }
}

function sis_printSingleTagWithHeader($header, $art_tag){
    if (!empty($art_tag)) {
        $tag = get_term($art_tag);
        echo $header . ' ' . $tag->name;
    }
}

function sis_printSingleTagWithAfter($art_tag, $after){
    if (!empty($art_tag)) {
        $tag = get_term($art_tag);
        echo $tag->name . $after;
    }
}

function sis_printSingleTagAsUrl($art_tag){
    if (!empty($art_tag)) {
        $tag = get_term($art_tag);
        $art_url = str_replace(' ', '-', $tag->name);
        echo $art_url;
    }
}

function sis_printSingleTag($art_tag){
    sis_printSingleTagWithAfter($art_tag, '');
}

function sis_printFieldWithHeader($header, $field){
    if(trim($field) != ''){
        print $header;
        print $field;
    }
}

function sis_printFieldWithEnding($ending, $field){
    if(trim($field) != ''){
        print $field . ' ' . $ending;
    }
}

function sis_printFieldWithHeaderClass($header, $field, $className){
    if(trim($field) != ''){
        print '<div class="' . $className . '">';
        print $header;
        print $field;
        print '</div>';
    }
}

function sis_printArticlePDFLink($art_pdf){
    sis_printArticlePDFLinkWithHeaderAndEnd('', $art_pdf, '');
}

function sis_printArticlePDFLinkWithHeaderAndEnd($header, $art_pdf, $end){
    if (is_array($art_pdf) && array_key_exists("url", $art_pdf) && !empty($art_pdf['url'])) {
        echo $header . $art_pdf['url'] . $end;
    }
}

// custom language switcher for the WPML plugin
function languages_links_switcher(){
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

// custom language switcher for the WPML plugin
function sis_articleLanguageSwitcher(){
    $languages = icl_get_languages('skip_missing=1');
    echo __(' <ul class="vf-links__list vf-links__list--secondary | vf-list">');
        foreach($languages as $l){
            $langs[] = '<li class="vf-list__item"><a class="vf-list__link" href="'.$l['url'].
                '"><img class="wpml-ls-flag" src="' . $l['country_flag_url'].'" />&nbsp;' .$l['native_name'].'</a></li>';
        }
        echo join(' ', $langs);
        echo __('
    
  </ul>' );

}


// Show linked WPML posts in a loop
function wpml_post_languages_in_loop() {
    $thispostid = get_the_ID();
    $post_trid = apply_filters('wpml_element_trid', NULL, get_the_ID(), 'post_' . get_post_type());
    $languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0&orderby=code' );
    //var_dump($post_trid);
    //var_dump($languages);
    if (empty($post_trid))
        return;
    $translation = apply_filters('wpml_get_element_translations', NULL, $post_trid, 'post_' . get_post_type());

    //var_dump($translation);
    if (1 < count($translation)) {
        echo '<p class="vf-summary__meta">Other language(s): &nbsp;&nbsp;';
        foreach ($translation as $l) {
            $translatedLink = apply_filters('wpml_permalink', ( get_permalink($l->element_id)), $l->language_code);
            $translatedLink = substr($translatedLink, 0,-1);
            if($l->language_code != 'en' && $l->language_code != ''){
            }
            if ($l->element_id != $thispostid) {
                $langs[] = '<a href="' . $translatedLink . '"><img class="wpml-ls-flag iclflag" src="'.$languages[$l->language_code]['country_flag_url'].'" />' . '</a>';
            }
        }
        echo join(' &nbsp; ', $langs);
        echo '</p>';
    }
}


// Show linked WPML posts in a loop
function sis_articleLanguageSwitcherInLoop() {
    $home_url = get_home_url();
    $thispostid = get_the_ID();
    $post_trid = apply_filters('wpml_element_trid', NULL, get_the_ID(), 'post_' . get_post_type());
    $languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0&orderby=code' );
    if (empty($post_trid)) return;
    $translation = apply_filters('wpml_get_element_translations', NULL, $post_trid, 'post_' . get_post_type());
        foreach ($translation as $l) {
            $translatedLink = apply_filters('wpml_permalink', ( get_permalink($l->element_id)), $l->language_code);
            $translatedLink = substr($translatedLink, 0, -1);
            if($l->language_code != 'en' && $l->language_code != ''){
            }
            $langs[] = '<span class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-post-translations">'
                . '<a class="vf-card__link" href="' . $translatedLink . '">'
                . '<img class="wpml-ls-flag iclflag" src="'.$languages[$l->language_code]['country_flag_url'] . '" />'
                . '</a>'
                . '</span>';

        }
        echo join(' &nbsp; ', $langs);
}
// Show linked WPML posts in a loop in issues
function sis_articleLanguageSwitcherInLoopIssue() {
    $home_url = get_home_url();
    $thispostid = get_the_ID();
    $post_trid = apply_filters('wpml_element_trid', NULL, get_the_ID(), 'post_' . get_post_type());
    $languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0&orderby=code' );
    if (empty($post_trid)) return;
    $translation = apply_filters('wpml_get_element_translations', NULL, $post_trid, 'post_' . get_post_type());
        foreach ($translation as $l) {
            $translatedLink = apply_filters('wpml_permalink', ( get_permalink($l->element_id)), $l->language_code);
            $translatedLink = substr($translatedLink, 0, -1);
            if($l->language_code != 'en' && $l->language_code != ''){
            }
            $langs[] = '<span class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-post-translations">'
                . '<a class="vf-card__link" href="' . $translatedLink . '">'
                . '<img class="wpml-ls-flag iclflag" src="' . $home_url . '/wp-content/plugins/sitepress-multilingual-cms/res/flags/' . $l->language_code .'.png" />'
                . '</a>'
                . '</span>';

        }
        echo join(' &nbsp; ', $langs);
}

// Show linked WPML posts in a loop
function sis_articleLanguageSwitcherInLoopWithLanguageNames() {
    $thispostid = get_the_ID();
    $post_trid = apply_filters('wpml_element_trid', NULL, get_the_ID(), 'post_' . get_post_type());
    $languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0&orderby=code' );

    if (empty($post_trid)) return;
    $translation = apply_filters('wpml_get_element_translations', NULL, $post_trid, 'post_' . get_post_type());

    foreach ($translation as $l) {
        $translatedLink = apply_filters('wpml_permalink', ( get_permalink($l->element_id)), $l->language_code);
        $translatedLink = substr($translatedLink, 0,-1);
        if($l->language_code != 'en' && $l->language_code != ''){
        }
        $langs[] =
            '<span class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-post-translations">'
            . '<a class="vf-list__link" href="' . $translatedLink . '">'
            . '<img class="wpml-ls-flag iclflag" src="'.$languages[$l->language_code]['country_flag_url'] . '" '
            . ' alt="' . $languages[$l->language_code]['native_name'] . '" '
            .' /> '
            . $languages[$l->language_code]['native_name']
            . '</a>'
            . '</span>'
            ;

    }
    echo join(' &nbsp; ', $langs);
}


add_filter( 'posts_search', function( $search, \WP_Query $q )
{
    if( ! is_admin() && empty( $search ) && $q->is_search() && $q->is_main_query() )
        $search .=" AND 0=1 ";

    return $search;
}, 10, 2 );

// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

    global $wp_version;
    if ( $wp_version !== '4.7.1' ) {
       return $data;
    }
  
    $filetype = wp_check_filetype( $filename, $mimes );
  
    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
  
  }, 10, 4 );
  
  function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
  add_filter( 'upload_mimes', 'cc_mime_types' );
  
  function fix_svg() {
    echo '<style type="text/css">
          .attachment-266x266, .thumbnail img {
               width: 100% !important;
               height: auto !important;
          }
          </style>';
  }
  add_action( 'admin_head', 'fix_svg' );

  // sort sis-article columns by date by default

  function sort_sis_articles( $query ) {
    if ( ! is_admin() ) {
        return;
    }

    // Get the post type from the query
    $post_type = $query->get('post_type');

    // Check if the current post type in the admin is your custom post type
    if ( 'sis-article' == $post_type ) {
        // Check if 'orderby' is set to the default value
        if ( ! isset( $_GET['orderby'] ) ) {
            // Set the query to order by 'date' by default
            $query->set( 'orderby', 'date' );
            $query->set( 'order', 'DESC' ); // Use 'ASC' for ascending order
        }
    }
}

// Hook the function to the 'pre_get_posts' action
add_action( 'pre_get_posts', 'sort_sis_articles' );


  // sort sis-issue columns by date by default

  function sort_sis_issues( $query ) {
    if ( ! is_admin() ) {
        return;
    }

    // Get the post type from the query
    $post_type = $query->get('post_type');

    // Check if the current post type in the admin is your custom post type
    if ( 'sis-issue' == $post_type ) {
        // Check if 'orderby' is set to the default value
        if ( ! isset( $_GET['orderby'] ) ) {
            // Set the query to order by 'date' by default
            $query->set( 'orderby', 'date' );
            $query->set( 'order', 'DESC' ); // Use 'ASC' for ascending order
        }
    }
}

// Hook the function to the 'pre_get_posts' action
add_action( 'pre_get_posts', 'sort_sis_issues' );






// removes <p> tag from ACF WYSYWIG field
// function my_acf_add_local_field_groups() {
//     remove_filter('acf_the_content', 'wpautop' );
// }
// add_action('acf/init', 'my_acf_add_local_field_groups');


/* Exclude a Category from Search Results */

//  add_filter( 'pre_get_posts', 'exclude_editorials_category_from_search' );
//  function exclude_editorials_category_from_search($query) {
//      if ( $query->is_search ) {
//         $args = array(
//             'tax_query' => array(
//                 array(
//                     'taxonomy' => 'sis-article-types',
//                     'field' => 'term_id',
//                     'terms' => [ 2544 ],
//                     'operator' => 'NOT IN',
//                        ),
//             ),
//             'meta_query'	=> array(
//                 array(
//                     'key'	  	=> 'art_slider_exclude',
//                     'value'	  	=> '1',
//                     'compare' 	=> '!=',
//                 ),
//             )
//             );
 
//          $query->set( 'tax_query', $args );
//          $query->set( 'meta_query', $args );
 
//          }
 
//          return $query;
//      } 

?>