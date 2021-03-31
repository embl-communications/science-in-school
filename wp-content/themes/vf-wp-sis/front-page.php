<?php
  get_header();
  global $vf_theme;
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<!-- <?php include(locate_template('partials/vf-breadcrumb.php', false, false)); ?> -->
<?php include(locate_template('partials/vf-hero--as-promotion.php', false, false)); ?>

<!-- Featured -->
<section class="vf-card-container | vf-u-fullbleed sis-u-background-dots">
  <div class="vf-card-container__inner">
    <div class="vf-section-header">
      <a class="vf-section-header__heading vf-section-header__heading--is-link" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"
        id="section-link">Most recent <svg aria-hidden="true"
          class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em"
          xmlns="http://www.w3.org/2000/svg">
          <path
            d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
            fill="" fill-rule="nonzero"></path>
        </svg></a>
      <p class="vf-section-header__text">Our most recent content. (This is the most basic integration of the wordpress templating to show recently listed posts.)</p>
    </div>
    <!-- <div class="vf-section-header">
      <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"
        class="vf-section-header__heading vf-section-header__heading--is-link">Featured updates from ELLS<svg
          class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="24" height="24"
          xmlns="http://www.w3.org/2000/svg">
          <path
            d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
            fill="" fill-rule="nonzero"></path>
        </svg></a>
      <p class="vf-section-header__text"> <span class="vf-u-text--nowrap"> </span></p>
    </div> -->

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
          $languages = icl_get_languages( $args );
          if ( 1 < count( $languages ) ) {
            echo isset( $before ) ? esc_html( $before ) : esc_html__( 'This post is also available in: ', 'sitepress' );
            foreach ( $languages as $l ) {
              if ( ! $l['active'] ) {
                $languages_items[] = '<a href="' . $l['url'] . '">' . $l['translated_name'] . '</a>';
              }
            }
            echo join( ', ', $languages_items );
            echo isset( $after ) ? esc_html( $after ) : '';
          }
        }
      } 
    ?>


  <?php $mainloop = new WP_Query (array('posts_per_page' => 4)); 
    while ($mainloop->have_posts()) : $mainloop->the_post(); ?>
      <article class="vf-card vf-card--brand vf-card--bordered">
        <img src="<?php the_post_thumbnail_url( 'full' ); ?>"
          alt="<?php get_post_meta ( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true ); ?>" class="vf-card__image" loading="lazy">
        <div class="vf-card__content | vf-stack vf-stack--400">
          <h3 class="vf-card__heading"><a class="vf-card__link" href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?><svg
                aria-hidden="true" class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end" width="1em"
                height="1em" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                  fill="currentColor" fill-rule="nonzero"></path>
              </svg>
            </a></h3>

          <p class="vf-card__text"><?php echo get_the_excerpt(); ?></p>
          <div class="vf-links vf-links--tight vf-links__list--s vf-links__list--secondary">
            <a class="vf-list__item vf-list__link" href="3333">[tags to go here]</a>,
            <a class="vf-list__item vf-list__link" href="3333">Astronomy / space</a>,
            <a class="vf-list__item vf-list__link" href="3333">Chemistry</a>,
            <a class="vf-list__item vf-list__link" href="3333">Physics</a>
          </div>
          <!-- For now I don't think we'll need time
          <span class="vf-summary__date"><time class="vf-summary__date vf-u-text-color--grey" style="margin-left: 0;"
            title="<?php the_time('c'); ?>"
            datetime="<?php the_time('c'); ?>"><?php the_time(get_option('date_format')); ?></time></span> -->
          
          <?php
            wpml_content_languages();
          ?>
        </div>
      </article>
    <?php endwhile;?>
    <?php wp_reset_postdata(); ?>
  </div>
</section>


<!-- Featured (manual example) -->
<section class="vf-card-container | vf-u-fullbleed sis-u-background-dots">
  <div class="vf-card-container__inner">
    <div class="vf-section-header">
      <a class="vf-section-header__heading vf-section-header__heading--is-link" href="JavaScript:Void(0);"
        id="section-link">Featured articles <svg aria-hidden="true"
          class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em"
          xmlns="http://www.w3.org/2000/svg">
          <path
            d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
            fill="" fill-rule="nonzero"></path>
        </svg></a>
      <p class="vf-section-header__text">Some of our best and most popular content.</p>
    </div>
    <article class="vf-card vf-card--brand vf-card--bordered">
      <img src="https://www.scienceinschool.org/sites/default/files/teaserImage/issue37_stars_teaser.jpg"
        alt="Image alt text" class="vf-card__image" loading="lazy">
      <div class="vf-card__content | vf-stack vf-stack--400">

        <h3 class="vf-card__heading"><a class="vf-card__link" href="JavaScript:Void(0);">What are stars made of? <svg
              aria-hidden="true" class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end" width="1em"
              height="1em" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                fill="currentColor" fill-rule="nonzero"></path>
            </svg>
          </a></h3>

        <p class="vf-card__text">Find out how we know what the Sun (and stars) are made of.</p>
        <div class="vf-links vf-links--tight vf-links__list--s vf-links__list--secondary">
          <a class="vf-list__item vf-list__link" href="3333">All</a>,
          <a class="vf-list__item vf-list__link" href="3333">Astronomy / space</a>,
          <a class="vf-list__item vf-list__link" href="3333">Chemistry</a>,
          <a class="vf-list__item vf-list__link" href="3333">Physics</a>
        </div>
        <p class="wpml-ls-statics-post_translations wpml-ls">
          <span
            class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-post-translations"><a
              href="https://dev-science-in-school.pantheonsite.io" class="wpml-ls-link"><img class="wpml-ls-flag"
                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                alt="English"></a></span> <span
            class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-es wpml-ls-last-item wpml-ls-item-legacy-post-translations"><a
              href="https://dev-science-in-school.pantheonsite.io/es/" class="wpml-ls-link"><img class="wpml-ls-flag"
                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/es.png"
                alt="Spanish"></a></span>
        </p>
      </div>
    </article>
    <article class="vf-card vf-card--brand vf-card--bordered">
      <img src="https://www.scienceinschool.org/sites/default/files/teaserImage/issue35_luminescence_teaser.jpg"
        alt="Image alt text" class="vf-card__image" loading="lazy">
      <div class="vf-card__content | vf-stack vf-stack--400">

        <h3 class="vf-card__heading"><a class="vf-card__link" href="JavaScript:Void(0);">Living light: the chemistry of
            bioluminescence <svg aria-hidden="true" class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end"
              width="1em" height="1em" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                fill="currentColor" fill-rule="nonzero"></path>
            </svg>
          </a></h3>

        <p class="vf-card__text">Brighten up your chemistry lessons by looking at bioluminescence.</p>
        <div class="vf-links vf-links--tight vf-links__list--s vf-links__list--secondary">
          <a class="vf-list__item vf-list__link" href="3333">All</a>,
          <a class="vf-list__item vf-list__link" href="3333">Astronomy / space</a>,
          <a class="vf-list__item vf-list__link" href="3333">Chemistry</a>,
          <a class="vf-list__item vf-list__link" href="3333">Physics</a>
        </div>
        <p class="wpml-ls-statics-post_translations wpml-ls">
          <span
            class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-post-translations"><a
              href="https://dev-science-in-school.pantheonsite.io" class="wpml-ls-link"><img class="wpml-ls-flag"
                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                alt="English"></a></span> <span
            class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-es wpml-ls-last-item wpml-ls-item-legacy-post-translations"><a
              href="https://dev-science-in-school.pantheonsite.io/es/" class="wpml-ls-link"><img class="wpml-ls-flag"
                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/es.png"
                alt="Spanish"></a></span>
        </p>
      </div>
    </article>
    <article class="vf-card vf-card--brand vf-card--bordered">
      <img src="https://www.scienceinschool.org/sites/default/files/teaserImage/ells-resources-teaser.jpg"
        alt="Image alt text" class="vf-card__image" loading="lazy">
      <div class="vf-card__content | vf-stack vf-stack--400">

        <h3 class="vf-card__heading"><a class="vf-card__link" href="JavaScript:Void(0);">Science at home: distance
            learning with EMBL <svg aria-hidden="true"
              class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                fill="currentColor" fill-rule="nonzero"></path>
            </svg>
          </a></h3>

        <p class="vf-card__text">Explore the educational resources created by one of Europe’s leading laboratories, ...
        </p>
        <div class="vf-links vf-links--tight vf-links__list--s vf-links__list--secondary">
          <a class="vf-list__item vf-list__link" href="3333">All</a>,
          <a class="vf-list__item vf-list__link" href="3333">Astronomy / space</a>,
          <a class="vf-list__item vf-list__link" href="3333">Chemistry</a>,
          <a class="vf-list__item vf-list__link" href="3333">Physics</a>
        </div>
        <p class="wpml-ls-statics-post_translations wpml-ls">
          <span
            class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-post-translations"><a
              href="https://dev-science-in-school.pantheonsite.io" class="wpml-ls-link"><img class="wpml-ls-flag"
                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                alt="English"></a></span> <span
            class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-es wpml-ls-last-item wpml-ls-item-legacy-post-translations"><a
              href="https://dev-science-in-school.pantheonsite.io/es/" class="wpml-ls-link"><img class="wpml-ls-flag"
                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/es.png"
                alt="Spanish"></a></span>
        </p>
      </div>
    </article>
  </div>
</section>

<!-- Search -->
<div class="embl-grid embl-grid--has-centered-content vf-u-margin__bottom--0">
  <div class="vf-section-header"><a class="vf-section-header__heading vf-section-header__heading--is-link"
      href="JavaScript:Void(0);" id="section-sub-heading-link-text">Search and discover <svg aria-hidden="true"
        class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em"
        xmlns="http://www.w3.org/2000/svg">
        <path
          d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
          fill="" fill-rule="nonzero"></path>
      </svg></a>
    <!-- <p class="vf-section-header__subheading">News from EMBL’s six sites</p> -->
  </div>
  <div>
  </div>
  <div></div>
</div>
<div class="embl-grid embl-grid--has-centered-content">
  <div class="vf-section-header">
    <!-- <p class="vf-section-header__subheading">News from EMBL’s six sites</p> -->
    <p class="vf-section-header__text">We are the only teaching journal to cover all sciences and target the whole of
      Europe and beyond. We offer articles in more than 30 languages.</p>
  </div>
  <div>
    <form action="#" class="vf-form | vf-search vf-search--inline">
      <div class="vf-form__item | vf-search__item">
        <label class="vf-form__label vf-u-sr-only | vf-search__label" for="inlinesearchitem">Inline search</label>
        <input type="search" placeholder="Enter your search terms" id="inlinesearchitem"
          class="vf-form__input | vf-search__input">
      </div>
      <button type="submit" class="vf-search__button | vf-button vf-button--primary"> Search</button>
      <p class="vf-search__description">Examples: <a href="JavaScript:Void(0);" class="vf-link">fusion</a>, <a
          href="JavaScript:Void(0);" class="vf-link">life</a>. You can also use the <a href="JavaScript:Void(0);"
          class="vf-link">advanced search</a>.</p>
    </form>

    <section class="vf-grid vf-grid__col-2 | vf-u-margin__top--600">
      <article class="vf-card vf-card--brand vf-card--striped">
        <img
          src="https://acxngcvroo.cloudimg.io/v7/https://www.embl.org/files/wp-content/uploads/2020/04/SCHOOLS_1011_ells-learninglab_hd_01_Cool_500px.jpg"
          alt="Image alt text" class="vf-card__image" loading="lazy">
        <div class="vf-card__content | vf-stack vf-stack--400">
          <h3 class="vf-card__heading"><a class="vf-card__link" href="JavaScript:Void(0);">Understand <svg
                aria-hidden="true" class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end" width="1em"
                height="1em" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                  fill="currentColor" fill-rule="nonzero"></path>
              </svg>
            </a></h3>
          <!-- <p class="vf-card__subheading">With sub–heading</p> -->
          <p class="vf-card__text">Explore research and science topics</p>
        </div>
      </article>
      <article class="vf-card vf-card--brand vf-card--striped">
        <img
          src="https://acxngcvroo.cloudimg.io/v7/https://www.embl.org/files/wp-content/uploads/2020/04/SCHOOLS_1011_ells-learninglab_hd_01_Cool_500px.jpg"
          alt="Image alt text" class="vf-card__image" loading="lazy">
        <div class="vf-card__content | vf-stack vf-stack--400">
          <h3 class="vf-card__heading"><a class="vf-card__link" href="JavaScript:Void(0);">Inspire <svg
                aria-hidden="true" class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end" width="1em"
                height="1em" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                  fill="currentColor" fill-rule="nonzero"></path>
              </svg>
            </a></h3>
          <!-- <p class="vf-card__subheading">With sub–heading</p> -->
          <p class="vf-card__text">Discover people, events and resources</p>
        </div>
      </article>
      <article class="vf-card vf-card--brand vf-card--striped">
        <img
          src="https://acxngcvroo.cloudimg.io/v7/https://www.embl.org/files/wp-content/uploads/2020/04/SCHOOLS_1011_ells-learninglab_hd_01_Cool_500px.jpg"
          alt="Image alt text" class="vf-card__image" loading="lazy">
        <div class="vf-card__content | vf-stack vf-stack--400">
          <h3 class="vf-card__heading"><a class="vf-card__link" href="JavaScript:Void(0);">Teach <svg aria-hidden="true"
                class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                  fill="currentColor" fill-rule="nonzero"></path>
              </svg>
            </a></h3>
          <!-- <p class="vf-card__subheading">With sub–heading</p> -->
          <p class="vf-card__text">Resources for activities and projects</p>
        </div>
      </article>
      <article class="vf-card vf-card--brand vf-card--striped">
        <img
          src="https://acxngcvroo.cloudimg.io/v7/https://www.embl.org/files/wp-content/uploads/2020/04/SCHOOLS_1011_ells-learninglab_hd_01_Cool_500px.jpg"
          alt="Image alt text" class="vf-card__image" loading="lazy">
        <div class="vf-card__content | vf-stack vf-stack--400">
          <h3 class="vf-card__heading"><a class="vf-card__link" href="JavaScript:Void(0);">Read <svg aria-hidden="true"
                class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                  fill="currentColor" fill-rule="nonzero"></path>
              </svg>
            </a></h3>
          <!-- <p class="vf-card__subheading">With sub–heading</p> -->
          <p class="vf-card__text">All 51 of our issues are available for free</p>
        </div>
      </article>
    </section>
  </div>
  <div></div>
</div>


<!-- Featured (manual example) -->
<section class="vf-card-container | vf-u-fullbleed sis-u-background-dots">
  <div class="vf-card-container__inner">
    <div class="vf-section-header">
      <a class="vf-section-header__heading vf-section-header__heading--is-link" href="JavaScript:Void(0);"
        id="section-link">What's new <svg aria-hidden="true"
          class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em"
          xmlns="http://www.w3.org/2000/svg">
          <path
            d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
            fill="" fill-rule="nonzero"></path>
        </svg></a>
      <p class="vf-section-header__text">The latest uploaded articles.</p>
    </div>
    <article class="vf-card vf-card--brand vf-card--bordered">
      <img src="https://www.scienceinschool.org/sites/default/files/teaserImage/issue35_luminescence_teaser.jpg"
        alt="Image alt text" class="vf-card__image" loading="lazy">
      <div class="vf-card__content | vf-stack vf-stack--400">

        <h3 class="vf-card__heading"><a class="vf-card__link" href="JavaScript:Void(0);">Living light: the chemistry of
            bioluminescence <svg aria-hidden="true" class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end"
              width="1em" height="1em" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                fill="currentColor" fill-rule="nonzero"></path>
            </svg>
          </a></h3>

        <p class="vf-card__text">Brighten up your chemistry lessons by looking at bioluminescence.</p>
        <div class="vf-links vf-links--tight vf-links__list--s vf-links__list--secondary">
          <a class="vf-list__item vf-list__link" href="3333">All</a>,
          <a class="vf-list__item vf-list__link" href="3333">Astronomy / space</a>,
          <a class="vf-list__item vf-list__link" href="3333">Chemistry</a>,
          <a class="vf-list__item vf-list__link" href="3333">Physics</a>
        </div>
        <p class="wpml-ls-statics-post_translations wpml-ls">
          <span
            class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-post-translations"><a
              href="https://dev-science-in-school.pantheonsite.io" class="wpml-ls-link"><img class="wpml-ls-flag"
                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                alt="English"></a></span> <span
            class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-es wpml-ls-last-item wpml-ls-item-legacy-post-translations"><a
              href="https://dev-science-in-school.pantheonsite.io/es/" class="wpml-ls-link"><img class="wpml-ls-flag"
                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/es.png"
                alt="Spanish"></a></span>
        </p>
      </div>
    </article>
    <article class="vf-card vf-card--brand vf-card--bordered">
      <img src="https://www.scienceinschool.org/sites/default/files/teaserImage/issue37_stars_teaser.jpg"
        alt="Image alt text" class="vf-card__image" loading="lazy">
      <div class="vf-card__content | vf-stack vf-stack--400">

        <h3 class="vf-card__heading"><a class="vf-card__link" href="JavaScript:Void(0);">What are stars made of? <svg
              aria-hidden="true" class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end" width="1em"
              height="1em" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                fill="currentColor" fill-rule="nonzero"></path>
            </svg>
          </a></h3>

        <p class="vf-card__text">Find out how we know what the Sun (and stars) are made of.</p>
        <div class="vf-links vf-links--tight vf-links__list--s vf-links__list--secondary">
          <a class="vf-list__item vf-list__link" href="3333">All</a>,
          <a class="vf-list__item vf-list__link" href="3333">Astronomy / space</a>,
          <a class="vf-list__item vf-list__link" href="3333">Chemistry</a>,
          <a class="vf-list__item vf-list__link" href="3333">Physics</a>
        </div>
        <p class="wpml-ls-statics-post_translations wpml-ls">
          <span
            class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-post-translations"><a
              href="https://dev-science-in-school.pantheonsite.io" class="wpml-ls-link"><img class="wpml-ls-flag"
                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                alt="English"></a></span> <span
            class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-es wpml-ls-last-item wpml-ls-item-legacy-post-translations"><a
              href="https://dev-science-in-school.pantheonsite.io/es/" class="wpml-ls-link"><img class="wpml-ls-flag"
                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/es.png"
                alt="Spanish"></a></span>
        </p>
      </div>
    </article>
    <article class="vf-card vf-card--brand vf-card--bordered">
      <img src="https://www.scienceinschool.org/sites/default/files/teaserImage/ells-resources-teaser.jpg"
        alt="Image alt text" class="vf-card__image" loading="lazy">
      <div class="vf-card__content | vf-stack vf-stack--400">

        <h3 class="vf-card__heading"><a class="vf-card__link" href="JavaScript:Void(0);">Science at home: distance
            learning with EMBL <svg aria-hidden="true"
              class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                fill="currentColor" fill-rule="nonzero"></path>
            </svg>
          </a></h3>

        <p class="vf-card__text">Explore the educational resources created by one of Europe’s leading laboratories, ...
        </p>
        <div class="vf-links vf-links--tight vf-links__list--s vf-links__list--secondary">
          <a class="vf-list__item vf-list__link" href="3333">All</a>,
          <a class="vf-list__item vf-list__link" href="3333">Astronomy / space</a>,
          <a class="vf-list__item vf-list__link" href="3333">Chemistry</a>,
          <a class="vf-list__item vf-list__link" href="3333">Physics</a>
        </div>
        <p class="wpml-ls-statics-post_translations wpml-ls">
          <span
            class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-post-translations"><a
              href="https://dev-science-in-school.pantheonsite.io" class="wpml-ls-link"><img class="wpml-ls-flag"
                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                alt="English"></a></span> <span
            class="wpml-ls-slot-post_translations wpml-ls-item wpml-ls-item-es wpml-ls-last-item wpml-ls-item-legacy-post-translations"><a
              href="https://dev-science-in-school.pantheonsite.io/es/" class="wpml-ls-link"><img class="wpml-ls-flag"
                src="https://dev-science-in-school.pantheonsite.io/wp-content/plugins/sitepress-multilingual-cms/res/flags/es.png"
                alt="Spanish"></a></span>
        </p>
      </div>
    </article>
  </div>
</section>

<!-- Topic -->
<div class="embl-grid">
  <div class="vf-section-header">
    <p class="vf-section-header__subheading">Topics</p>
    <!-- <p class="vf-section-header__text"></p> -->
  </div>
  <section class="vf-grid vf-grid__col-3">
  <div class="vf-links">
      <h3 class="vf-links__heading">Recent research and science</h3>
      <ul class="vf-links__list | vf-list">
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">
            Astronomy / space
          </a>

        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">
            Biology
          </a>

        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">
            Chemistry
          </a>

        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">
            Earth science
          </a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Engineering</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">General science</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Health</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">History</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Mathematics</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Physics</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">News from the EIROs</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Science and society</a>
        </li>
      </ul>
    </div>
    <div class="vf-links">
      <h3 class="vf-links__heading">Activities and projects</h3>
      <ul class="vf-links__list | vf-list">
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">
            Astronomy / space
          </a>

        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">
            Biology
          </a>

        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">
            Chemistry
          </a>

        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">
            Earth science
          </a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Engineering</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">General science</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Health</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">History</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Mathematics</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Physics</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Science and society</a>
        </li>
      </ul>
    </div>
    <div class="vf-links">
      <h3 class="vf-links__heading">People, events and resources</h3>
      <ul class="vf-links__list | vf-list">
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Advertorials</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">General science</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Career focus</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Resource reviews</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Science and society</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Science miscellany</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Scientist profiles</a>
        </li>
        <li class="vf-list__item">
          <a class="vf-list__link" href="JavaScript:Void(0);">Teacher profiles</a>
        </li>
      </ul>
    </div>  
  </section>
</div>

<hr class="vf-divider" />

<?php the_content(); ?>

<!-- Team up -->
<!-- <div class="vf-u-fullbleed | vf-u-padding__top--500 vf-u-padding__bottom--600">
  <section>
    <h3 class="vf-text-heading--3">Team up with us</h3>
  </section>
  <section class="vf-grid vf-grid__col-4 | vf-u-margin__top--600">
    <div class="vf-box vf-box--is-link vf-box-theme--quinary vf-box--normal">
      <h3 class="vf-box__heading"><a class="vf-box__link" href="/training">Volunteer wit us</a></h3>
      <p class="vf-box__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
    </div>
  </section>
</div> -->

<?php include(locate_template('partials/vf-footer.php', false, false)); ?>