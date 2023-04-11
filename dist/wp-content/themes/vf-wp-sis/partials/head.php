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
    <meta name="google-site-verification" content="zTTG8tkBva5M6gLMzV8W8Q5DnPZNJS1QC0jxss_q_L8" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-18009732-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-18009732-1');
    </script>
    <!-- Search indexing optimisations -->
    <?php
    // https://swiftype.com/documentation/site-search/crawler-configuration/meta-tags#thumbnails
    if (get_the_post_thumbnail_url()) {
        echo '<meta class="swiftype" name="image" data-type="enum" content="' . get_the_post_thumbnail_url() . '" />';
    }
    ?>

    <!-- Social media cards -->

  <?php
  if(is_singular('sis-article') || is_singular('sis-issue')) {
  $card_url    = get_permalink();
  $card_title  = get_the_title();
  $card_desc   = get_the_excerpt();
  $card_name   = str_replace('@', '', get_the_author_meta('twitter')); 
  $card_thumb = get_the_post_thumbnail_url(); ?>
  <!-- Twitter -->
  <meta name="twitter:card" value="summary" />
  <meta name="twitter:url" value="<?php echo $card_url; ?>" />
  <meta name="twitter:title" value="<?php echo $card_title; ?>" />
  <meta name="twitter:description" value="<?php echo $card_desc; ?>" />
  <meta name="twitter:image" value="<?php echo $card_thumb; ?>" />
  <meta name="twitter:site" value="@SciInSchool" />
<?php
if($card_name) { ?>
  <meta name="twitter:creator" value="@<?php echo $card_name; ?>" />
<?php } ?>
  <!-- Facebook -->
  <meta property="og:url" content="<?php echo $card_url; ?>" />
  <meta property="og:title" content="<?php echo $card_title; ?>" />
  <meta property="og:description" content="<?php echo $card_desc; ?>" />
  <meta property="og:image" content="<?php echo $card_thumb; ?>" />
  <?php } 
  else { ?>
    <meta name="twitter:image" value="http://www.scienceinschool.org/wp-content/uploads/2023/04/2019_Logo_SIS_short_2.png" />
    <meta property="og:image" content="http://www.scienceinschool.org/wp-content/uploads/2023/04/2019_Logo_SIS_short_2.png" />
  <?php
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
