<!-- Featured articles -->


<?php
// LANGUAGE SELECTOR
// USAGE place this on the single.php, page.php, index.php etc... - inside the loop
// function wpml_content_languages($args)
// args: skip_missing, before, after
// defaults: skip_missing = 1, before =  __('This post is also available in: '), after = ''
function wpml_content_languages( $args = '' ) {
    $before = null;
    $after = null;
    $languages_items = array();

    parse_str( $args, $params );
    if(array_key_exists( 'before', $params)) {
        $before = $params['before'];
    }
    if(array_key_exists( 'after', $params)) {
        $after = $params['after'];
    }

    if ( function_exists( 'icl_get_languages' ) ) {
        $languages = icl_get_languages('skip_missing=1');
        if ( 1 < count( $languages ) ) {
            echo isset( $before ) ? esc_html( $before ) : esc_html__( 'This post is also available in: ', 'sitepress' );
            foreach ( $languages as $l ) {
                if ( ! $l['active'] ) {
                    $languages_items[] = '<a href="' . $l['url'] . '"><img class="wpml-ls-flag iclflag" src="'.$l['country_flag_url'].'" />' . $l['translated_name'] . '</a>';
                }
            }
            echo join( ', ', $languages_items );
            echo isset( $after ) ? esc_html( $after ) : '';
        }
    }
}
?>

<section class="vf-card-container | vf-u-fullbleed sis-u-background-dots" style="margin-top: 0 !important;">
    <div class="vf-card-container__inner">

        <?php
        $post = get_field('featured_article_understand');
        setup_postdata($post);
        ?>
        <article class="vf-card vf-card--brand vf-card--bordered">
            <span class="vf-badge vf-badge--secondary" style="color: #fff;">Understand</span>
            <?php the_post_thumbnail( 'full', array( 'class' => 'vf-card__image' ) ); ?>
            <div class="vf-card__content | vf-stack vf-stack--400">

                <h3 class="vf-card__heading"><a class="vf-card__link" href="<?php the_permalink(); ?>"><?php the_title(); ?>
                        <svg
                            aria-hidden="true" class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end"
                            width="1em"
                            height="1em" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                                fill="currentColor" fill-rule="nonzero"></path>
                        </svg>
                    </a></h3>

                <p class="vf-card__text"><?php the_excerpt(); ?></p>
                <div class="vf-links vf-links--tight vf-links__list--s vf-links__list--secondary">
                    <?php
                    $art_topics= get_field('art_topics');
                    if(is_array($art_topics)){
                        $first = true;
                        foreach($art_topics as $tagId){
                            if(!$first){
                                echo ', ';
                            } else {
                                $first = false;
                            }
                            $tag = get_term($tagId);
                            echo ' <a class="vf-list__item vf-list__link" href="3333">' . $tag->name . '</a>';
                        }
                    }
                    ?>
                </div>
                <?php
                wpml_content_languages();
                ?>
                <p class="wpml-ls-statics-post_translations wpml-ls">
          <span
              class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-post-translations"><a
                  href="https://dev-science-in-school.pantheonsite.io" class="wpml-ls-link"><img class="wpml-ls-flag"
                                                                                                 src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                                                                                                 alt="English"></a></span>
                    <span
                        class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-es wpml-ls-last-item wpml-ls-item-legacy-post-translations"><a
                            href="https://dev-science-in-school.pantheonsite.io/es/" class="wpml-ls-link"><img
                                class="wpml-ls-flag"
                                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/es.png"
                                alt="Spanish"></a></span>
                </p>
            </div>
        </article>
        <?php wp_reset_postdata(); ?>


        <?php
        $post = get_field('featured_article_inspire');
        setup_postdata($post);
        ?>
        <article class="vf-card vf-card--brand vf-card--bordered">
                <span class="vf-badge vf-badge--primary"
                      style="background: orange; border-color: orange;">Inspire</span>
            <?php the_post_thumbnail( 'full', array( 'class' => 'vf-card__image' ) ); ?>
            <div class="vf-card__content | vf-stack vf-stack--400">

                <h3 class="vf-card__heading"><a class="vf-card__link" href="<?php the_permalink(); ?>"><?php the_title(); ?>
                        <svg aria-hidden="true" class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end"
                             width="1em" height="1em" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                                fill="currentColor" fill-rule="nonzero"></path>
                        </svg>
                    </a></h3>

                <p class="vf-card__text"><?php the_excerpt(); ?></p>
                <div class="vf-links vf-links--tight vf-links__list--s vf-links__list--secondary">
                    <?php
                    $art_topics= get_field('art_topics');
                    if(is_array($art_topics)){
                        $first = true;
                        foreach($art_topics as $tagId){
                            if(!$first){
                                echo ', ';
                            } else {
                                $first = false;
                            }
                            $tag = get_term($tagId);
                            echo ' <a class="vf-list__item vf-list__link" href="3333">' . $tag->name . '</a>';
                        }
                    }
                    ?>
                </div>

                <?php
                wpml_content_languages();
                ?>

                <p class="wpml-ls-statics-post_translations wpml-ls">
          <span
              class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-post-translations"><a
                  href="https://dev-science-in-school.pantheonsite.io" class="wpml-ls-link"><img class="wpml-ls-flag"
                                                                                                 src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                                                                                                 alt="English"></a></span>
                    <span
                        class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-es wpml-ls-last-item wpml-ls-item-legacy-post-translations"><a
                            href="https://dev-science-in-school.pantheonsite.io/es/" class="wpml-ls-link"><img
                                class="wpml-ls-flag"
                                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/es.png"
                                alt="Spanish"></a></span>
                </p>
            </div>
        </article>
        <?php wp_reset_postdata(); ?>


        <?php
        $post = get_field('featured_article_teach');
        setup_postdata($post);
        ?>
        <article class="vf-card vf-card--brand vf-card--bordered">
            <span class="vf-badge vf-badge--primary">Teach</span>
            <?php the_post_thumbnail( 'full', array( 'class' => 'vf-card__image' ) ); ?>
            <div class="vf-card__content | vf-stack vf-stack--400">

                <h3 class="vf-card__heading"><a class="vf-card__link" href="<?php the_permalink(); ?>"><?php the_title(); ?>
                        <svg aria-hidden="true"
                             class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                                fill="currentColor" fill-rule="nonzero"></path>
                        </svg>
                    </a></h3>

                <p class="vf-card__text"><?php the_excerpt(); ?></p>


                <div class="vf-links vf-links--tight vf-links__list--s vf-links__list--secondary">
                    <?php
                    $art_topics= get_field('art_topics');
                    if(is_array($art_topics)){
                        $first = true;
                        foreach($art_topics as $tagId){
                            if(!$first){
                                echo ', ';
                            } else {
                                $first = false;
                            }
                            $tag = get_term($tagId);
                            echo ' <a class="vf-list__item vf-list__link" href="3333">' . $tag->name . '</a>';
                        }
                    }
                    ?>
                </div>

                <?php
                wpml_content_languages();
                ?>

                <p class="wpml-ls-statics-post_translations wpml-ls">
          <span
              class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-post-translations"><a
                  href="https://dev-science-in-school.pantheonsite.io" class="wpml-ls-link"><img class="wpml-ls-flag"
                                                                                                 src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                                                                                                 alt="English"></a></span>
                    <span
                        class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-es wpml-ls-last-item wpml-ls-item-legacy-post-translations"><a
                            href="https://dev-science-in-school.pantheonsite.io/es/" class="wpml-ls-link"><img
                                class="wpml-ls-flag"
                                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/es.png"
                                alt="Spanish"></a></span>
                </p>
            </div>
        </article>
        <?php wp_reset_postdata(); ?>


    </div>
</section>
