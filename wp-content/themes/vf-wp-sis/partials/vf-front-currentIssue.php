<!-- Current issue -->

<section
        class="vf-vf-grid vf-grid__col-1 | vf-u-fullbleed sis-u-background-dots vf-u-margin__bottom--800">
    <div>
        <section class="embl-grid | vf-u-padding__bottom--800 vf-u-padding__top--800">
            <section>
                <?php
                $currentIssue = get_field('current_issue');
                if($currentIssue){
                    $count = 0;
                    foreach($currentIssue as $post) {
                        $count++;
                        setup_postdata($post);
                        include(locate_template('partials/vf-front-currentIssueHeader.php', false, false));
                        if ($count > 0) {
                            break;
                        }
                    }
                    wp_reset_postdata();
                }
                ?>
            </section>
            <section>
                <div class="vf-grid vf-grid__col-3">
                    <?php
                        $numberOfIssueArticles = 0;
                        $currentIssueArticles = get_field('current_issue_articles');
                        if($currentIssueArticles){
                            foreach($currentIssueArticles as $post) {
                                $numberOfIssueArticles++;
                                setup_postdata($post);
                                include(locate_template('partials/vf-front-currentIssueArticleTeaser.php', false, false));
                                if ($numberOfIssueArticles > 2) {
                                    break;
                                }
                            }
                            wp_reset_postdata();
                        }

                    if ($numberOfIssueArticles < 3) {
                        $featureLoop = new WP_Query(
                            array(
                                'post_type' => 'sis-article',
                                'posts_per_page' => 3 - $numberOfIssueArticles,
                                'post_status' => 'publish',
                                'orderby' => 'rand',
                                'order' => 'DESC',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'sis-issues',
                                        'field' => 'slug',
                                        'terms' => $currentIssue->post_title,
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
                            include(locate_template('partials/vf-front-currentIssueArticleTeaser.php', false, false));
                        endwhile;
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </section>
        </section>
    </div>
</section>
