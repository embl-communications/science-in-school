<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<?php 
global $post;

$event_organiser = get_field('vf_event_organiser');
$social_media_container = get_field('vf_event_social_media', $post->post_parent);
$cpp_container = get_field('vf_event_cpp_container', $post->post_parent);
$cancelled = get_field('vf_event_canceled');
?>
<?php  
   
// vf-hero container
include( plugin_dir_path( __FILE__ ) . 'partials-events/hero.php'); 
?>

<section class="vf-grid vf-grid__col-4">
  <div class="vf-grid__col--span-3 | vf-content">
    <?php the_content(); ?>
  </div>
  <?php 
// info box
include( plugin_dir_path( __FILE__ ) . 'partials-events/event-info.php'); ?>
</section>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
