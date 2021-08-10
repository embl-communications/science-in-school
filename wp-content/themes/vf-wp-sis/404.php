<?php
get_header();
include(locate_template('partials/vf-global-header.php', false, false));
?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-post">

    <section class="vf-hero | vf-u-fullbleed">
        <div class="vf-hero__content | vf-box | vf-stack vf-stack--400">
            <h2 class="vf-hero__heading"><?php _e('404 page not found.'); ?></h2>
        </div>
    </section>

    <?php the_content(); ?>


</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
