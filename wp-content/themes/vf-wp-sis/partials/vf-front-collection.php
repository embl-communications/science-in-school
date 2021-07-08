<!-- Special collection -->
<?php
    $currentCollectionTitle = get_field('current_collection_title');
    $currentCollectionText = get_field('current_collection_text');
    $currentCollectionLink = get_field('current_collection_link');
    $currentCollectionArticles = get_field('current_collection_articles');
?>
<section class="vf-card-container | vf-u-fullbleed sis-u-background-dots" style="margin-top: 0 !important;">
    <div class="vf-card-container__inner">
        <div class="vf-section-header">
            <a class="vf-section-header__heading vf-section-header__heading--is-link" href="<?php echo $currentCollectionLink; ?>"
               id="section-link"><?php echo $currentCollectionTitle; ?>
                <svg aria-hidden="true"
                     class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                            fill="" fill-rule="nonzero"></path>
                </svg>
            </a>
            <p class="vf-section-header__text"><?php echo $currentCollectionText; ?>.</p>
        </div>

        <?php
        if($currentCollectionArticles){
            $count = 0;
            foreach($currentCollectionArticles as $post){
                $count++;
                setup_postdata($post);
                include(locate_template('partials/vf-front-collectionArticleType.php', false, false));
                if($count > 2){
                    break;
                }
            }
            wp_reset_postdata();
        }
        ?>

    </div>
</section>
