<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-post">

    <?php
    $title = esc_html(get_the_title());
    $title_pdf = strtolower($title);
    $title_pdf = str_replace(' ', '-', $title_pdf);
    $art_author_name = get_field('art_author_name');
    $art_editor_tags = get_field('art_editor_tags');
    $art_ages = get_field('art_ages');
    $art_institutions = get_field('art_institutions');
    $art_issue = get_field('art_issue');
    $art_article_type = get_field('art_article_type');
    $art_topics = get_field('art_topics');
    $art_series = get_field('art_series');
    $art_license = get_field('art_license');
    $art_license_freetext = get_field('art_license_freetext');
    $art_license_select = get_field('art_license_select');
    $art_references = get_field('art_references');
    $art_web_references = get_field('art_web_references');
    $art_resources = get_field('art_resources');
    $art_eiroforum_research = get_field('art_eiroforum_research');
    $art_authors = get_field('art_authors');
    $art_referee = get_field('art_referee');
    $art_review = get_field('art_review');
    $art_pdf = get_field('art_pdf');
    $art_teaser = get_field('art_teaser_text', false, false);
    $art_materials = get_field('art_materials');
    $art_migrated_from_drupal = get_field('art_migrated_from_drupal');
    $art_reviewed_after_migration_from_drupal = get_field('art_reviewed_after_migration_from_drupal');
    $art_links_to_ss = get_field('art_links_to_ss');

    $art_translator_name = get_field('art_translator_name');
    $art_translator_logo = get_field('art_translator_logo');
    $art_translator_link = get_field('art_translator_link');
    $art_acknowledgements = get_field('art_acknowledgements', false, false);

    $topic_terms = get_the_terms($post->ID, 'sis-categories');
    $keyword_terms = get_the_terms($post->ID, 'sis-editor-tags');
    $social_url = get_the_permalink();
    $post_language_details = apply_filters( 'wpml_post_language_details', NULL, $post->ID ) ;

    ?>


    <section class="embl-grid embl-grid--has-centered-content" id="an-id-for-anchor">
        <div>
        </div>
        <div class="">
        <?php include(locate_template('partials/breadcrumbs.php', false, false)); ?>

            <h1 class="vf-intro__heading vf-intro__heading--has-tag">
                <?php echo get_the_title(); ?>
                <?php
                $articleType = get_field('art_article_type');
                $articleTypesArray = sis_getArticleTypesArray();
                if($articleType == $articleTypesArray['UNDERSTAND']){
                    ?>
                <a href="/?sis-article-types=understand" class="vf-badge sis-badge--understand">Understand article</a>
                <?php
                } else if($articleType == $articleTypesArray['INSPIRE']){
                    ?>
                <a href="/?sis-article-types=inspire" class="vf-badge sis-badge--inspire">Inspire article</a>
                <?php
                } else if($articleType == $articleTypesArray['TEACH']){
                    ?>
                <a href="/?sis-article-types=teach" class="vf-badge sis-badge--teach">Teach article</a>
                <?php
                } else if($articleType == $articleTypesArray['EDITORIAL']){
                    ?>
                <a href="/?sis-article-types=editorial" class="vf-badge sis-badge--editorial">Editorial article</a>
                <?php
                }
                ?>
            </h1>
        </div>
    </section>
    <div class="embl-grid embl-grid--has-centered-content">
        <div>
            <aside class="vf-article-meta-information">
                <div class="vf-meta__details">
                    <p class="vf-meta__date" style="color: #000;"><?php the_date(); ?></p>
                    <p class="vf-meta__topics">
                        <a href="/issue/<?php sis_printSingleTagAsUrl($art_issue);?>"
                            class="vf-badge"><?php sis_printSingleTagWithAfter($art_issue, ''); ?></a>
                </div>
                <div class="vf-meta__details">
                    <?php sis_printTagsWithHeaderAndEnd('<p class="vf-meta__topics" style="margin-top: 0.5rem;"><span style="color: #000;">Ages:</span> ', $art_ages, '</p>'); ?>

                    <?php 
                // topics
                 if( $topic_terms ) {
                 echo '<p class="vf-meta__topics" style="margin-top: 1rem;"><span style="color: #000;">Topics: </span>';
                $topics_list = array(); 
                 foreach( $topic_terms as $term ) {
                  $topics_list[] = '<a class="' . esc_attr( $term->slug ) . '"style="color: #707372;" href="' . esc_url(get_term_link( $term )) . '">' . esc_html( $term->name ) . '</a>'; }
                  echo implode(', ', $topics_list);
                  echo '</p>'; }
                ?>
                    <?php 
                // keywords
                 if( $keyword_terms ) {
                 echo '<p class="vf-meta__topics" style="margin-top: 0.5rem;"><span style="color: #000;">Keywords: </span>';
                $keywords_list = array(); 
                 foreach( $keyword_terms as $term ) {
                  $keywords_list[] = '<a class="' . esc_attr( $term->slug ) . '"style="color: #707372;" href="' . esc_url(get_term_link( $term )) . '">' . esc_html( $term->name ) . '</a>'; }
                  echo implode(', ', $keywords_list);
                  echo '</p>'; }
                ?>
                </div>

                <div class="vf-links vf-links--tight vf-links__list--s">
                    <p class="vf-links__heading" style="margin-top: 1rem;">Available languages</p>
                    <?php sis_articleLanguageSwitcher(); ?>
                    <p class="vf-text-body vf-text-body--4">See all articles in <a class="vf-link"
                    href="https://www.scienceinschool.org/<?php echo $post_language_details['language_code']; ?>/?post_type=sis-article"><img
                    class="wpml-ls-flag"
                    src="https://www.scienceinschool.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/<?php echo $post_language_details['language_code']; ?>.png">
                    <?php echo $post_language_details['display_name']; ?> </a></p>
                
                </div>
            </aside>

        </div>
        <div class="vf-content">
            <div class="vf-author | vf-article-meta-info__author">
                <p>
                    <?php
                        sis_printFieldWithHeader('<strong>Author(s): </strong>', $art_author_name);
                        ?>
                    <br />
                    <?php
                       sis_printFieldWithHeader('<strong>Translator(s): </strong>', $art_translator_name); 
                    ?>

                    <?php if( !empty( $art_translator_logo ) ): ?>
                    <?php if (!empty ($art_translator_link)) { ?>
                    <a href="<?php echo esc_url($art_translator_link); ?>">
                        <?php }?>
                        <img style="height: 24px; vertical-align: middle;"
                            src="<?php echo esc_url($art_translator_logo['url']); ?>"
                            alt="<?php echo esc_attr($art_translator_logo['alt']); ?>" />
                        <?php if (!empty ($art_translator_link)) {
                    echo '</a>'; } ?>
                        <?php endif; ?>
                </p>
            </div>

            <?php if ($art_acknowledgements) { ?>
            <div class="sis-box-acknowledgements">
                <p><?php sis_printFieldWithHeader('', $art_acknowledgements); ?></p>
            </div>
            <?php } ?>

            <?php if($articleType != $articleTypesArray['EDITORIAL']) { 
                if ($art_teaser) { ?>
            <p style="font-size: 20px;"><strong><?php echo $art_teaser; ?></strong></p>
            <?php }
                else  {?>
            <p style="font-size: 20px;"><strong><?php echo get_the_excerpt();?></strong></p>
            <?php } } ?>

            <?php the_content(); ?>

            <hr class="vf-divider">
            <div class="vf-stack vf-stack--400">
                <?php sis_printFieldWithHeader('<h3>References</h3>',$art_references); ?>

                <?php sis_printFieldWithHeader('<h3>Web References</h3>', $art_web_references); ?>

                <?php sis_printFieldWithHeader('<h3>Resources</h3>', $art_resources); ?>

                <?php
            if($art_eiroforum_research != ''){
                print '<div class="sis-reviewer-box">';
                print '<h3>Cutting-edge science: related EIROforum research</h3>';
                print $art_eiroforum_research;
                print '</div>';
            }
            ?>
                <?php 
            if( $art_institutions ): ?>
                <h3>Institutions</h3>
                <?php foreach( $art_institutions as $term ): ?>
                <?php 
                $inst_image = get_field('institutions_taxonomy_image', $term, false); 
                $inst_url = get_field('institutions_taxonomy_url', $term, false); 
                if ($inst_image) {
                    $image = wp_get_attachment_image_src($inst_image, 'thumbnail');
                    echo '<a href="' . $inst_url . '"><img style="margin-top: 12px;" src="' . $image[0] . '"/></a>';
                }
                else {
                echo esc_html( $term->name ); }
             ?>

                <?php endforeach; ?>
                <?php endif; ?>

                <?php
            if($art_links_to_ss != ''){
                print '<div class="sis-reviewer-box">';
                print '<h3>Links to school science</h3>';
                print $art_links_to_ss;
                print '</div>';
            }
            ?>
                <?php sis_printFieldWithHeaderClass('<h3>Author(s)</h3>', $art_authors, 'sis-author-box'); ?>

                <?php
            if($art_review != ''){
                print '<div class="sis-reviewer-box">';
                print '<h3>Review</h3>';
                print $art_review;

                if($art_referee != ''){
                    print '<div class=""sis-reviewer-name">' . $art_referee . '</div>';
                }
                print '</div>';
            }
            ?>

                <?php
                if(!empty($art_license) || !empty($art_license_freetext)){
                    print '<h3>License</h3>';
                }
            ?>
                <?php
            if(!empty($art_license)) {
                $tag_license = get_term($art_license);
                echo '<div><a href="/copyright">' . $tag_license->name . '</a></div>';
            }
            ?>

                <div>
                    <?php
                if(!empty($art_license_freetext)) {
                echo $art_license_freetext; 
                } 
                else {
                    echo esc_html($art_license_select);
                }    
                ?>
                </div>
            </div>
        </div>
        <div class="vf-content">
            <?php
        if(is_array($art_materials) && count($art_materials) > 0){
        ?>
            <article class="sis-materials">
                <h3>Supporting materials</h3>
                <?php foreach($art_materials as $singleAddMat){
                ?>
                <p><a class="sis-materials--link sis-materials--link-pdf" target="_blank"
                        href="<?php echo $singleAddMat['art_single_material'];?>"><?php echo $singleAddMat['art_single_name'];?></a>
                </p>
                <?php
                }
                ?>
                </ul>
                <?php
        }
        ?>
                <?php if(!empty($art_pdf)){ ?>
                <h3>Download</h3>
                <p><a href="<?php sis_printArticlePDFLink($art_pdf); ?>"
                        class="vf-button vf-button--primary vf-button--sm"
                        data-vf-google-analytics-region="PDF-<?php echo $title_pdf; ?>">Download this article as a
                        PDF</a></p>
                <?php } ?>
                <hr class="vf-divider">

                <div class="social-box">

                    <?php include(locate_template('partials/social-icons.php', false, false)); ?>

                    <div class="vf-social-links | vf-u-margin__bottom--800">
                        <h3 class="vf-social-links__heading">
                            Share this article
                        </h3>
                        <ul class="vf-social-links__list">
                            <li class="vf-social-links__item">
                                <a class="vf-social-links__link"
                                    href="https://twitter.com/intent/tweet?text=<?php echo $title; ?>&amp;url=<?php echo $social_url; ?>&amp;via=embl">
                                    <span class="vf-u-sr-only">twitter</span>

                                    <svg aria-hidden="true" class="vf-icon vf-icon--social vf-icon--twitter" width="24"
                                        height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        preserveAspectRatio="xMinYMin">
                                        <use xlink:href="#vf-social--twitter"></use>
                                    </svg>
                                </a>
                            </li>
                            <li class="vf-social-links__item">

                                <a class="vf-social-links__link"
                                    href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $social_url; ?>">
                                    <span class="vf-u-sr-only">facebook</span>

                                    <svg aria-hidden="true" class="vf-icon vf-icon--social vf-icon--facebook" width="24"
                                        height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        preserveAspectRatio="xMinYMin">
                                        <use xlink:href="#vf-social--facebook"></use>
                                    </svg>
                                </a>
                            </li>
                            <li class="vf-social-links__item">
                                <a class="vf-social-links__link"
                                    href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $social_url; ?>&title=<?php echo $title; ?>">
                                    <span class="vf-u-sr-only">linkedin</span>

                                    <svg aria-hidden="true" class="vf-icon vf-icon--social vf-icon--linkedin" width="24"
                                        height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        preserveAspectRatio="xMinYMin">
                                        <use xlink:href="#vf-social--linkedin"></use>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="newsletterSignUp">
                <hr class="vf-divider">
                <h3 class="vf-text vf-text-heading--4 | newsletter-title">Subscribe to our <span
                        class="vf-u-text--nowrap">newsletter</span>
                </h3>
                <form class="vf-form vf-form--search vf-form--search--responsive | vf-sidebar vf-sidebar--end"
                    action="https://scienceinschool.us20.list-manage.com/subscribe/post?u=b07e55f20613237fa11593518&amp;id=3cd3d0c178"
                    method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate"
                    target="_blank" novalidate>
                    <div class="vf-sidebar__inner">
                        <div class="vf-form__item">
                            <label class="vf-form__label vf-u-sr-only | vf-search__label" for="searchitem">Subscribe to
                                our
                                newsletter</label>
                            <input type="search" name="EMAIL" placeholder="Enter your email" id="mce-EMAIL"
                                class="vf-form__input">
                            <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                            <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text"
                                    name="b_b07e55f20613237fa11593518_3cd3d0c178" tabindex="-1" value=""></div>
                        </div>
                        <div>
                        <button type="submit" value="Subscribe" id="mc-embedded-subscribe" name="subscribe"
                            class="vf-search__button | vf-button vf-button--primary vf-button--sm">
                            <span class="vf-button__text">Subscribe</span>

                            <svg class="vf-icon vf-icon--search-btn | vf-button__icon" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" version="1.1"
                                xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                viewBox="0 0 140 140" width="140" height="140">
                                <g transform="matrix(5.833333333333333,0,0,5.833333333333333,0,0)">
                                    <path
                                        d="M23.414,20.591l-4.645-4.645a10.256,10.256,0,1,0-2.828,2.829l4.645,4.644a2.025,2.025,0,0,0,2.828,0A2,2,0,0,0,23.414,20.591ZM10.25,3.005A7.25,7.25,0,1,1,3,10.255,7.258,7.258,0,0,1,10.25,3.005Z"
                                        fill="#FFFFFF" stroke="none" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="0"></path>
                                </g>
                            </svg>
                        </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <?php
        $relatedArticles = get_field('related_articles');
        $numberOfDisplayedArticles = 0;
        if ($relatedArticles) {
            $numberOfDisplayedArticles += count($relatedArticles);
            $relatedLoop = new WP_Query(
                array(
                    'post_type' => 'sis-article',
                    'post__in' => $relatedArticles,
                    'posts_per_page' => 3,
                    'orderby' => 'rand'
                    )
                ); ?>
    <section class="vf-card-container vf-card-container__col-3 vf-u-fullbleed | sis-u-background-dots"
        style="--vf-card__image--aspect-ratio: 16 / 9;">
        <div class="vf-card-container__inner">
            <div class="vf-section-header">
                <h2 class="vf-section-header__heading">Related articles</h2>
            </div>
            <?php
            while ($relatedLoop->have_posts()) : $relatedLoop->the_post();
            include(locate_template('partials/vf-front-featureArticleType.php', false, false));
        endwhile;
        wp_reset_postdata(); ?>

        </div>
    </section>
    <?php  } ?>

</main>
<style>
    .social-box .vf-icon {
        fill: #000 !important;
    }

    .social-box .vf-social-links__item {
        background: #fff
    }

    .sis-u-background-dots.vf-u-fullbleed::before {
        background-position-x: -500px !important;
    }
      @media (max-width: 1023px) {
        .newsletterSignUp {
          display: none;
        }
      }
</style>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>