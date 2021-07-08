<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-post">


    <h1>Upcoming Events </h1>

    Layout to be done

    <?php include(locate_template('partials/vf-eventList-eventTeaser.php', false, false)); ?>

    <?php include(locate_template('partials/vf-eventList-eventTeaser.php', false, false)); ?>


    <br>

    <?php include(locate_template('partials/vf-sub-relatedArticles.php', false, false)); ?>

    <br>

    <?php include(locate_template('partials/vf-sub-newsletter.php', false, false)); ?>

</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
