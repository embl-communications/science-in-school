<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-post">

    <?php
    $title = esc_html(get_the_title());

    $art_author_name = get_field('art_author_name');
    $art_editor_tags = get_field('art_editor_tags');
    $art_slider_exclude = get_field('art_slider_exclude');
    $art_eonly_article = get_field('art_eonly_article');
    $art_reviewer_tags = get_field('art_reviewer_tags');
    $art_ages = get_field('art_ages');
    $art_institutions = get_field('art_institutions');
    $art_issue = get_field('art_issue');
    $art_article_type = get_field('art_article_type');
    $art_topics = get_field('art_topics');
    $art_series = get_field('art_series');
    $art_license = get_field('art_license');
    $art_license_freetext = get_field('art_license_freetext');
    $art_references = get_field('art_references');
    $art_web_references = get_field('art_web_references');
    $art_resources = get_field('art_resources');
    $art_authors = get_field('art_authors');
    $art_referee = get_field('art_referee');
    $art_review = get_field('art_review');
    $art_slider_image = get_field('art_slider_image');
    $art_teaser_image = get_field('art_teaser_image');
    $art_pdf = get_field('art_pdf');
    $art_materials = get_field('art_materials');
    $art_migrated_from_drupal = get_field('art_migrated_from_drupal');
    $art_reviewed_after_migration_from_drupal = get_field('art_reviewed_after_migration_from_drupal');
    ?>


    <!-- https://www.scienceinschool.org/content/astrofarmer-how-grow-plants-space -->
    <nav class="vf-breadcrumbs" aria-label="Breadcrumb">
        <ul class="vf-breadcrumbs__list | vf-list vf-list--inline">
            <li class="vf-breadcrumbs__item">
                <a href="JavaScript:Void(0);" class="vf-breadcrumbs__link">Explore</a>
            </li>
            <li class="vf-breadcrumbs__item">
                <a href="JavaScript:Void(0);" class="vf-breadcrumbs__link">Topics</a>
            </li>
            <li class="vf-breadcrumbs__item" aria-current="location">
                Centre
            </li>
        </ul>
        <span class="vf-breadcrumbs__heading">Related:</span>
        <ul class="vf-breadcrumbs__list vf-breadcrumbs__list--related | vf-list vf-list--inline">
            <li class="vf-breadcrumbs__item">
                <a href="JavaScript:Void(0);" class="vf-breadcrumbs__link">Chemistry</a>
            </li>
        </ul>
    </nav>
    <br/>
    <br/>
    <!--  -->
    <section class="embl-grid embl-grid--has-centered-content" id="an-id-for-anchor">
        <div>
            <a href="JavaScript:Void(0);"
               class="vf-badge vf-badge--primary vf-badge--phases | vf-badge--intro">Teach<br/> article</a>


        </div>
        <div class="vf-stack">
            <h1 class="vf-intro__heading"><?php the_title(); ?></h1>
            <p class="vf-lede"><?php echo get_the_excerpt(); ?></p>

        </div>
    </section>
    <div class="embl-grid embl-grid--has-centered-content">
        <div>
            <aside class="vf-article-meta-information">
                <div class="vf-meta__details">
                    <p class="vf-meta__topics">Ages: <?php sis_printTags($art_ages); ?></p>
                    <p class="vf-meta__topics">Keywords: <?php sis_printTags($art_editor_tags); ?></p>
                </div>
                <div class="vf-meta__details">
                    <p class="vf-meta__date"><?php the_date(); ?></p>
                    <p class="vf-meta__topics">
                        <a href="JavaScript:Void(0);" class="vf-link"><?php sis_printSingleTag($art_issue); ?></a>
                </div>
                <div class="vf-links vf-links--tight vf-links__list--s">
                    <p class="vf-links__heading">Available languages</p>
                    <?php sis_articleLanguageSwitcher(); ?>
                </div>
                <div class="vf-links vf-links--tight vf-links__list--s">
                    <p class="vf-links__heading">On this page</p>
                    <ul class="vf-links__list vf-links__list--secondary | vf-list">
                        <li class="vf-list__item">
                            <a class="vf-list__link" href="JavaScript:Void(0);">Activity 1: Do plants need light?</a>
                        </li>
                        <li class="vf-list__item">
                            <a class="vf-list__link" href="JavaScript:Void(0);">Activity 2: Do plants need soil?</a>
                        </li>
                        <li class="vf-list__item">
                            <a class="vf-list__link" href="JavaScript:Void(0);">Resources</a>
                        </li>
                        <li class="vf-list__item">
                            <a class="vf-list__link" href="JavaScript:Void(0);">Download</a>
                        </li>
                        <li class="vf-list__item">
                            <a class="vf-list__link" href="JavaScript:Void(0);">Related articles</a>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
        <div class="vf-content">
            <div class="vf-author | vf-article-meta-info__author">
                <p class="">
                    <strong>Authors:</strong>
                    <?php echo $art_author_name; ?>
                    <br/>
                    <strong>Translators:</strong>
                    <?php //TODO echo $art_author_name; ?>
                </p>
            </div>

            <?php the_content(); ?>


            <h3>Download</h3>
            <p><a href="<?php sis_printArticlePDFLink($art_pdf); ?>" class="vf-button vf-button--primary">Download this article as a PDF</a></p>

            <h3>Acknowledgements</h3>
            <p>The authors would like to thank Monica Talevi, Christina Toldbo and all their team members at the ESA
                Education office who contributed to the development of these activities. Their thanks also go to ESA
                scientist Christel Paille for reviewing the educational activities and providing constructive and
                valuable comments.</p>

            <?php sis_printFieldWithHeader('<h3>Resources</h3>', $art_resources); ?>

            <?php sis_printFieldWithHeader('<h3>References</h3>',$art_references); ?>

            <?php sis_printFieldWithHeader('<h3>Web References</h3>', $art_web_references); ?>

            <?php sis_printTagsWithHeader('<h3>Institution</h3>',$art_institutions); ?>

            <?php sis_printFieldWithHeader('<h3>Author</h3>', $art_authors); ?>

            <?php sis_printSingleTag($art_license); ?>
            <?php echo $art_license_freetext; ?>
            <img src="https://mirrors.creativecommons.org/presskit/icons/cc.svg" alt="CC"/>
            <img src="https://mirrors.creativecommons.org/presskit/icons/by.svg" alt="BY"/>
        </div>
    </div>

    <?php include(locate_template('partials/vf-sub-relatedArticles.php', false, false)); ?>

    <?php include(locate_template('partials/vf-sub-newsletter.php', false, false)); ?>

</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
