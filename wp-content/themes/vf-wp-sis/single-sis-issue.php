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
    $iss_cover_image = get_field('iss_cover_image');
    //$iss_articles = get_field('iss_articles');
    //$iss_previous_issue = get_field('iss_previous_issue');
    //$iss_next_issue = get_field('iss_next_issue');
    //$iss_show_banner = get_field('iss_show_banner');
    $iss_migrated_from_drupal = get_field('iss_migrated_from_drupal');
    $iss_reviewed_after_migration_from_drupal = get_field('iss_reviewed_after_migration_from_drupal');
    ?>

    <section class="vf-hero | vf-u-fullbleed" style="--vf-hero--bg-image: url('/wp-content/themes/vf-wp-sis/assets/images/header/h1-issue.jpg'); --vf-hero--bg-image-size: auto 28.5rem;">
        <div class="vf-hero__content | vf-box | vf-stack vf-stack--400">
            <h2 class="vf-hero__heading"><a class="vf-hero__heading_link"
                                            href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h2>
        </div>
    </section>

    <?php
    $articleTypesArray = sis_getArticleTypesArray();

    foreach ($articleTypesArray as $articleTypeKey => $articleTypeValue) {
        $featureLoop = new WP_Query(
            array(
                'post_type' => 'sis-article',
                'post_status' => 'publish',
                'posts_per_page' => '25',
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'sis-issues',
                        'field' => 'term_id',
                        'terms' => $iss_issue
                    ),
                    array(
                        'taxonomy' => 'sis-article-types',
                        'field' => 'term_id',
                        'terms' => $articleTypeValue
                    ))
            )
        );
        $count = 0;

        while ($featureLoop->have_posts()) :
            $featureLoop->the_post();
            if ($count == 0) {
                ?>
                <section class="">
                <div class="vf-section-header">
                    <span class="vf-section-header__heading"><?php echo $articleTypeKey; ?></span>
                    <br/>
                    <br/>
                </div>
                <div class="vf-grid vf-grid__col-3">
                <?php
            }
            include(locate_template('partials/vf-issue-articleTeaser.php', false, false));
            $count++;
        endwhile;
        wp_reset_postdata();
        if ($count > 0) {
            ?>
            </div>
            </section><br/><br/>
            <?php
        }
    }
    ?>


</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
