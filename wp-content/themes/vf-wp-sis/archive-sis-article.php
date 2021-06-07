<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-post">

    <p>
        to do: once you get in to a category, filter and facet
    </p>
    <!--
    https://www.scienceinschool.org/search-page?f[0]=search_api_language%3Aen&f[1]=field_categories%3A63
    -->

    <h1>Teach articles</h1>

    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            setup_postdata($post);
            include(locate_template('partials/vf-articleList-articleTeaser.php', false, false));
        }

        wp_reset_postdata();
    }
    ?>


</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
