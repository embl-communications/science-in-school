<!-- Featured articles -->
<section class="vf-card-container | vf-u-fullbleed vf-u-margin__bottom"
         style="margin-top: 0 !important; margin-bottom: 0 !important;">
    <div class="vf-card-container__inner">

        <?php
        $featuredArticles = get_field('featuredarticles');
        $numberOfDisplayedArticles = 0;
        if ($featuredArticles) {
            $numberOfDisplayedArticles += count($featuredArticles);
            $featureLoop = new WP_Query(
                array(
                    'post_type' => 'sis-article',
                    'post__in' => $featuredArticles
                )
            );

            while ($featureLoop->have_posts()) : $featureLoop->the_post();
                include(locate_template('partials/vf-front-featureArticleType.php', false, false));
            endwhile;
            wp_reset_postdata();
        }

        if ($numberOfDisplayedArticles < 3) {
            $featureLoop = new WP_Query(
                array(
                    'post_type' => 'sis-article',
                    'posts_per_page' => 3 - $numberOfDisplayedArticles,
                    'post_status' => 'publish',
                    'orderby' => 'rand',
                    'order' => 'DESC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'sis-article-types',
                            'field' => 'slug',
                            'terms' => array('inspire', 'teach', 'understand'),
                        ),
                    ),
                    'meta_query'	=> array(
                        array(
                            'key'	  	=> 'art_slider_exclude',
                            'value'	  	=> '1',
                            'compare' 	=> '!=',
                        ),
                    )
                )
            );

            while ($featureLoop->have_posts()) : $featureLoop->the_post();
                include(locate_template('partials/vf-front-featureArticleType.php', false, false));
            endwhile;
            wp_reset_postdata();
        }
        ?>

    </div>
</section>


