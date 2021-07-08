<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-home">
    <?php include(locate_template('partials/vf-hero--as-promotion.php', false, false)); ?>


    <section class="vf-grid vf-grid__col-3 | vf-content">
        <div class="vf-grid__col--span-2">
            <h2>
                Latest news</h2>
            <div>
                <?php $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                    'posts_per_page' => 6,
                    'paged' => $page,);
                query_posts($args); ?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php include(locate_template('partials/vf-summary--news.php', false, false)); ?>
                <?php endwhile; endif; ?>
            </div>
            <div class="vf-grid" style="margin: 4%"> <?php vf_pagination();
                ?>
            </div>
        </div>
        <div>
        </div>
    </section>

</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
