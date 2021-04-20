<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
    <main class="tmpl-home">
<?php include(locate_template('partials/vf-hero--as-promotion.php', false, false)); ?>

<div class="embl-grid">
  <div>
  </div>
  <div class="vf-content">
    <?php
        if ( have_posts() ) {
          while ( have_posts() ) {
            the_post();
            the_title();
          }
        } else {
          echo '<p>', __('No documents found', 'vfwp'), '</p>';
        } ?>
    <div class="vf-grid"> <?php vf_pagination();?></div>
    <!--/vf-grid-->
  </div>
  <!--/vf-content-->
</div>
<!--/embl-grid-->

    </main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
