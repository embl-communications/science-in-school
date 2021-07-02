<article class="vf-card vf-card--brand vf-card--bordered">
    <?php
        $articleType = get_field('art_article_type');
        $articleTypesArray = sis_getArticleTypesArray();
        if($articleType == $articleTypesArray['UNDERSTAND']){
        ?>
    <span class="vf-badge vf-badge--secondary" style="background: #8dd13e; color: #fff;">Understand</span>
    <?php
        } else if($articleType == $articleTypesArray['INSPIRE']){
    ?>
            <span class="vf-badge vf-badge--primary" style="background: orange; border-color: orange;">Inspire</span>
    <?php
        } else {
    ?>
            <span class="vf-badge vf-badge--primary">Teach</span>
    <?php
        }
    ?>
    <img src="<?php echo get_the_post_thumbnail_url(); ?>"
         alt="Image alt text" class="vf-card__image" loading="lazy">
    <div class="vf-card__content | vf-stack vf-stack--400">
        <h3 class="vf-card__heading"><a class="vf-card__link" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?>
                <svg
                        aria-hidden="true" class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end"
                        width="1em"
                        height="1em" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                            fill="currentColor" fill-rule="nonzero"></path>
                </svg>
            </a></h3>
        <p class="vf-card__text"><?php echo get_the_excerpt(); ?></p>
        <div class="vf-links vf-links--tight vf-links__list--s vf-links__list--secondary">
            <?php
            $categories = get_field('art_topics');
            if($categories){
                sis_printTagsWithBeforeAndAfter('<span class="vf-list__item">', $categories, '</span>');
            }
            ?>
        </div>
        <p class="wpml-ls-statics-post_translations wpml-ls">
            <?php
            sis_articleLanguageSwitcherInLoop();
            ?>
        </p>
    </div>
</article>

