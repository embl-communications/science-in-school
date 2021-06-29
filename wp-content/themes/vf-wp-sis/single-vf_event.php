<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<!-- https://www.embl.org/about/info/course-and-conference-office/events/pev21-01/ -->
<main class="tmpl-post">
<?php

global $post;

$event_organiser = get_field('vf_event_organiser');
$social_media_container = get_field('vf_event_social_media', $post->post_parent);
$cpp_container = get_field('vf_event_cpp_container', $post->post_parent);
$cancelled = get_field('vf_event_canceled');

?>
<?php 
// info banner
if ($cancelled == 'postponed') { ?>
<div class="vf-banner vf-banner--alert vf-banner--info | vf-u-margin__bottom--200 vf-u-margin__top--200">
  <div class="vf-banner__content">
    <p class="vf-banner__text">This event has been postponed</a></p>
  </div>
</div>
<?php }

if ($cancelled == 'yes') { ?>
<div class="vf-banner vf-banner--alert vf-banner--danger | vf-u-margin__bottom--200 vf-u-margin__top--200">
  <div class="vf-banner__content">
    <p class="vf-banner__text">This event has been cancelled</a></p>
  </div>
</div>
<?php } ?>

<style>
  .vf-details--summary {
    background-color: #f3f3f3 !important;
  }

</style>

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

<?php 
// CPP container
if ($cpp_container == 1 && $event_organiser == "cco_hd") {
include( plugin_dir_path( __FILE__ ) . 'partials-events/cpp-container.php');
}

// Social media container
if ($social_media_container == 1 && $event_organiser == "cco_hd") {
include( plugin_dir_path( __FILE__ ) . 'partials-events/social-container.php');
}

// Global Footer
if (class_exists('VF_Global_Footer')) {
  VF_Plugin::render(VF_Global_Footer::get_plugin('vf_global_footer'));
}

?>

</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
