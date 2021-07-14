<!-- Current issue -->

<section
        class="vf-grid vf-grid__col-1 | vf-u-fullbleed sis-u-background-dots">
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
                        $currentIssueArticles = get_field('current_issue_articles');
                        if($currentIssueArticles){
                            $count = 0;
                            foreach($currentIssueArticles as $post) {
                                $count++;
                                setup_postdata($post);
                                include(locate_template('partials/vf-front-currentIssueArticleTeaser.php', false, false));
                                if ($count > 2) {
                                    break;
                                }
                            }
                            wp_reset_postdata();
                        }
                    ?>
                </div>
            </section>
        </section>
    </div>
</section>
