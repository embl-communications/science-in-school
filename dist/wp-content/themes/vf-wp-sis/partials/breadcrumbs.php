<?php 

$delimiter = '&raquo;';
$name = 'Science in School'; //text for the 'Home' link
$currentBefore = '<li class="vf-breadcrumbs__item" aria-current="location">';
$currentAfter = '</li>';
$home = get_bloginfo('url');
$post = get_queried_object();

echo '<nav class="vf-breadcrumbs | vf-u-margin__top--1200" aria-label="Breadcrumb">';
echo '<ul class="vf-breadcrumbs__list | vf-list vf-list--inline">';



if ( !is_home() && !is_archive('sis-article') && !is_front_page() || is_paged() ) {
  echo '
  <li class="vf-breadcrumbs__item">
  <a href="' . $home . '" class="vf-breadcrumbs__link" >' . $name . '</a></li>';
  echo '
  <li class="vf-breadcrumbs__item">
  <a href="/issue" class="vf-breadcrumbs__link" >Issue</a></li>';
  if ( is_singular('sis-article') ) {?>
<li class="vf-breadcrumbs__item"><a href="/issue/<?php sis_printSingleTagAsUrl($art_issue);?>"
        class="vf-breadcrumbs__link"><?php sis_printSingleTagWithAfter($art_issue, ''); ?></a></li>
<?php
    echo $currentBefore;
    echo $currentAfter;
  } 
  echo '</ul>';
  echo '</nav>';
}
?>