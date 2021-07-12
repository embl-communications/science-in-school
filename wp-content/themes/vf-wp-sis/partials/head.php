<!DOCTYPE html>
<html <?php language_attributes(); ?> class="vf-no-js">
<head>
    <link rel="shortcut icon" href="/wp-content/themes/vf-wp-sis/assets/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180"
          href="/wp-content/themes/vf-wp-sis/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
          href="/wp-content/themes/vf-wp-sis/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
          href="/wp-content/themes/vf-wp-sis/assets/favicon/favicon-16x16.png">
    <link rel="mask-icon" href="/wp-content/themes/vf-wp-sis/assets/favicon/safari-pinned-tab.svg" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Search indexing optimisations -->
    <?php
    // https://swiftype.com/documentation/site-search/crawler-configuration/meta-tags#thumbnails
    if (get_the_post_thumbnail_url()) {
        echo '<meta class="swiftype" name="image" data-type="enum" content="' . get_the_post_thumbnail_url() . '" />';
    }
    ?>
    <?php wp_head(); ?>
</head>
<body <?php
$articleType = get_field('art_article_type');
$cssClass = '';
if($articleType && !empty($articleType)){
    $articleTypesArray = sis_getArticleTypesArray();
    if($articleType == $articleTypesArray['UNDERSTAND']){
        $cssClass = 'sis-article-understand';
    } else if($articleType == $articleTypesArray['INSPIRE']){
        $cssClass = 'sis-article-inspire';
    } else if($articleType == $articleTypesArray['TEACH']){
        $cssClass = 'sis-article-teach';
    } else if($articleType == $articleTypesArray['EDITORIAL']){
        $cssClass = 'sis-article-editorial';
    }
}

$articleMigrated = get_field('art_migrated_from_drupal');
if($articleMigrated === true){
    $cssClass .= ' sis-article-legacy';
}

body_class($cssClass);
?>>
