<!-- Featured (manual example) -->
<section class="vf-card-container | vf-u-fullbleed sis-u-background-dots vf-u-margin__bottom"
         style="margin-top: 0 !important; margin-bottom: 0 !important;">
    <div class="vf-card-container__inner">

        <?php
            $featuredArticles = get_field('featuredarticles');
            if($featuredArticles){
                $count = 0;
                foreach($featuredArticles as $post){
                    $count++;
                    setup_postdata($post);
                    include(locate_template('partials/vf-front-featureArticleType.php', false, false));
                    if($count > 2){
                        break;
                    }
                }
                wp_reset_postdata();
            }
        ?>

    </div>
</section>
