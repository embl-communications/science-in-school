<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-post">
    <section class="vf-hero | vf-u-fullbleed"
        style="--vf-hero--bg-image: url('/wp-content/themes/vf-wp-sis/assets/images/header/h1-issue.jpg'); --vf-card__image--aspect-ratio 4/5; --vf-hero--bg-image-size: auto 28.5rem">
        <div class="vf-hero__content | vf-box | vf-stack vf-stack--400">
            <h2 class="vf-hero__heading">Issue archive
            </h2>
            <p class="vf-hero__subheading">In 2020 Science in School became an online publication. Here you can browse
                all publications dating back to 2006.</p>
        </div>
    </section>
    <div class="vf-stack vf-stack--800">

        <?php
            $arrayOfDisplayedYears = array();
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    setup_postdata($post);

                    $publicationYear = get_the_date('Y');
                    if(!in_array($publicationYear, $arrayOfDisplayedYears)){
                        if(count($arrayOfDisplayedYears) > 0){
                            echo '</section></div><hr class="vf-divider">';
                        }
                        $arrayOfDisplayedYears[] = $publicationYear;
                        ?>
        <div class="vf-grid">
            <div class="vf-section-header">
                <h2 class="vf-section-header__heading"><?php echo $publicationYear; ?></h2>
            </div>
            <section class="vf-grid vf-grid__col-5">
                <?php
                    }
                    include(locate_template('partials/vf-issueList-issueTeaser.php', false, false));

                }
                wp_reset_postdata();
            }
            ?>
        </div>

</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>