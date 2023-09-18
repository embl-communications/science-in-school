<?php
get_header();
$current_date = date('Ymd');

?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-home">

    <?php include(locate_template('partials/vf-front-articleOfWeek.php', false, false)); ?>

    <?php include(locate_template('partials/vf-front-feature.php', false, false)); ?>

    <?php //the_content(); ?>

    <?php include(locate_template('partials/vf-front-discover.php', false, false)); ?>

    <?php include(locate_template('partials/vf-front-currentIssue.php', false, false)); ?>

  <section id="events">
    <?php include(locate_template('partials/vf-front-webinars.php', false, false)); ?>
     
    <?php include(locate_template('partials/vf-front-events.php', false, false)); ?>
  </section>

    <?php //include(locate_template('partials/vf-front-collection.php', false, false)); ?>

    <?php include(locate_template('partials/vf-front-contribute.php', false, false)); ?>

    <?php // include(locate_template('partials/vf-front-newsletter.php', false, false)); ?>

</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>

