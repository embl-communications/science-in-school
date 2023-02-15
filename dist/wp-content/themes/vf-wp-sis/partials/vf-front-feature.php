<!-- Featured articles -->
<section class="vf-card-container | vf-u-fullbleed vf-u-margin__bottom | vf-content"
         style="margin-top: 0 !important; margin-bottom: 0 !important;">
    <div class="vf-card-container__inner">
    <div class="vf-section-header">
      <?php
                $currentIssue = get_field('current_issue');
                if($currentIssue){
                    $count = 0;
                    foreach($currentIssue as $post) {
                        $count++;
                        setup_postdata($post); 
                        ?>
                        <h2 class="vf-section-header__heading vf-section-header__heading--is-link"><a href="<?php echo get_the_permalink(); ?>">From the current issue</a><svg aria-hidden="true" class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z" fill="" fill-rule="nonzero"></path>
                            </svg></h2>
                       <?php
                        if ($count > 0) {
                            break;
                        }
                    }
                    wp_reset_postdata();
                }
                ?>
    </div>
    <?php
                        $currentIssue = get_field('current_issue');
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


