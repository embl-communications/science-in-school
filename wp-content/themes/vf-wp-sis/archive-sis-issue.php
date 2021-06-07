<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-post">

    <section class="vf-hero | vf-u-fullbleed" style=" --vf-hero--bg-image-size: auto 28.5rem">
        <div class="vf-hero__content | vf-box | vf-stack vf-stack--400">
            <h2 class="vf-hero__heading"><a class="vf-hero__heading_link" href="JavaScript:Void(0);">Issue archive</a>
            </h2>
            <p class="vf-hero__subheading">In 2020 Science in School became an online publication. Here your can browse
                all publications dating back to 2006.</p>
        </div>
    </section>


    <div class="embl-grid">
        <div class="vf-section-header">
            <h2 class="vf-section-header__heading">2021</h2>
        </div>
        <section class="vf-grid">

            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    setup_postdata($post);
                    include(locate_template('partials/vf-issueList-issueTeaser.php', false, false));
                }
                wp_reset_postdata();
            }
            ?>

        </section>
    </div>

    <div class="embl-grid">
        <div class="vf-section-header">
            <h2 class="vf-section-header__heading">2020</h2>
        </div>
        <section class="vf-grid">
            <?php include(locate_template('partials/vf-issueList-issueTeaser.php', false, false)); ?>
            <?php include(locate_template('partials/vf-issueList-issueTeaser.php', false, false)); ?>
            <?php include(locate_template('partials/vf-issueList-issueTeaser.php', false, false)); ?>


        </section>
    </div>

    <!-- OLD -->
    <div class="embl-grid">
        <div>
        </div>
        <div class="vf-content">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    the_title();
                }
            } else {
                echo '<p>', __('No documents found', 'vfwp'), '</p>';
            } ?>
            <div class="vf-grid"> <?php vf_pagination(); ?></div>
            <!--/vf-grid-->
        </div>
        <!--/vf-content-->
    </div>
    <!--/embl-grid-->

</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
