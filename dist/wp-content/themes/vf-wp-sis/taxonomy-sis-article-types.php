<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-post">

    <?php
    $articleTypeGetParam = get_query_var('sis-article-types');
    $header = 'Articles';
    if($articleTypeGetParam){
        $header = ucfirst($articleTypeGetParam) . ' articles';
    }
    ?>

    <h1><?php echo $header; ?></h1>

    <section class="embl-grid">
        <div class="vf-stack vf-stack--800">
            <?php include(locate_template('partials/vf-archive-filters-taxonomy.php', false, false)); ?>
        </div>

        <div class="vf-stack">

            <p class="vf-text-body vf-text-body--4">
                <?php
                echo 'Showing ' . $GLOBALS['wp_query']->post_count . ' results from a total of ' . $GLOBALS['wp_query']->found_posts;
                ?>

            <p>

                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        setup_postdata($post);
                        include(locate_template('partials/vf-articleList-articleTeaser.php', false, false));
                    }

                    wp_reset_postdata();
                }

                vf_pagination();
                ?>

                <!--nav class="vf-pagination" aria-label="Pagination">
                    <ul class="vf-pagination__list">
                        <li class="vf-pagination__item">
                            <span class="vf-u-sr-only">Result </span> 1 - 10 of 1,345
                        </li>
                        <li class="vf-pagination__item vf-pagination__item--jump-back">
                            <a href="JavaScript:Void(0);" class="vf-pagination__link">
                                << <span class="vf-u-sr-only">First set</span>
                            </a>
                        </li>
                        <li class="vf-pagination__item vf-pagination__item--previous-page">
                            <a href="JavaScript:Void(0);" class="vf-pagination__link">
                                < Previous <span class="vf-u-sr-only">set</span>
                            </a>
                        </li>
                        <li class="vf-pagination__item vf-pagination__item--next-page">
                            <a href="JavaScript:Void(0);" class="vf-pagination__link">
                                Next > <span class="vf-u-sr-only">set</span>
                            </a>
                        </li>
                        <li class="vf-pagination__item vf-pagination__item--jump-forward">
                            <a href="JavaScript:Void(0);" class="vf-pagination__link">
                                >> <span class="vf-u-sr-only">Last set</span>
                            </a>
                        </li>
                    </ul>
                </nav -->

        </div>
    </section>


</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
