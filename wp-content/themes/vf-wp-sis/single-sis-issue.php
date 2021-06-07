<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-post">

    <?php
    $title = esc_html(get_the_title());

    $iss_issue = get_field('iss_issue');
    $iss_pdf = get_field('iss_pdf');
    $iss_articles = get_field('iss_articles');
    $iss_previous_issue = get_field('iss_previous_issue');
    $iss_next_issue = get_field('iss_next_issue');
    $iss_show_banner = get_field('iss_show_banner');
    $iss_migrated_from_drupal = get_field('iss_migrated_from_drupal');
    $iss_reviewed_after_migration_from_drupal = get_field('iss_reviewed_after_migration_from_drupal');
    ?>

    <section class="vf-hero | vf-u-fullbleed" style=" --vf-hero--bg-image-size: auto 28.5rem">
        <div class="vf-hero__content | vf-box | vf-stack vf-stack--400">
            <h2 class="vf-hero__heading"><a class="vf-hero__heading_link" href="<?php the_permalink(); ?>"><?php echo $title;?></a></h2>
        </div>
    </section>

    <section class="">
        <div class="vf-section-header">
            <span class="vf-section-header__heading">Understand</span>
            <br/>
            <br/>
        </div>
        <div class="vf-grid vf-grid__col-3">

            <?php
            if (is_array($iss_articles)) {
                foreach ($iss_articles as $singleArticle) {
                    $post = get_post($singleArticle->ID);
                    setup_postdata($post);
                    include(locate_template('partials/vf-issue-articleTeaser.php', false, false));
                }
                wp_reset_postdata();
            }
            ?>

        </div>
    </section>

    <section class="">
        <br/>
        <br/>
        <div class="vf-section-header">
            <span class="vf-section-header__heading">Inspire</span>
            <br/>
            <br/>
        </div>
        <div class="vf-grid vf-grid__col-3">

            <?php
            if (is_array($iss_articles)) {
                foreach ($iss_articles as $singleArticle) {
                    $post = get_post($singleArticle->ID);
                    setup_postdata($post);
                    include(locate_template('partials/vf-issue-articleTeaser.php', false, false));
                }
                wp_reset_postdata();
            }
            ?>

        </div>
    </section>


</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
