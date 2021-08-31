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
    $art_pdf = get_field('art_pdf');
    $art_materials = get_field('art_materials');
    $art_migrated_from_drupal = get_field('art_migrated_from_drupal');
    $art_reviewed_after_migration_from_drupal = get_field('art_reviewed_after_migration_from_drupal');

    $art_translator_name = get_field('art_translator_name');
    $art_acknowledgements = get_field('art_acknowledgements');
    ?>

    <br/>
    <br/>

    <section class="embl-grid embl-grid--has-centered-content" id="an-id-for-anchor">
        <div>
        </div>
        <div class="vf-stack">
            <h1 class="vf-intro__heading vf-intro__heading--has-tag">
                <?php echo get_the_title(); ?>
                <?php
                $articleType = get_field('art_article_type');
                $articleTypesArray = sis_getArticleTypesArray();
                if($articleType == $articleTypesArray['UNDERSTAND']){
                    ?>
                    <a href="/?sis-article-types=understand"
                    class="vf-badge sis-badge--understand">Understand article</a>
                    <?php
                } else if($articleType == $articleTypesArray['INSPIRE']){
                    ?>
                    <a href="/?sis-article-types=inspire"
                    class="vf-badge sis-badge--inspire">Inspire article</a>
                    <?php
                } else if($articleType == $articleTypesArray['TEACH']){
                    ?>
                    <a href="/?sis-article-types=teach"
                    class="vf-badge sis-badge--teach">Teach article</a>
                    <?php
                } else if($articleType == $articleTypesArray['EDITORIAL']){
                    ?>
                    <a href="/?sis-article-types=editorial"
                    class="vf-badge sis-badge--editorial">Editorial article</a>
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
                    <p class="vf-meta__date"><?php the_date(); ?></p>
                    <p class="vf-meta__topics">
                        <a href="/issue/<?php sis_printSingleTagAsUrl($art_issue);?>" class="vf-link"><?php sis_printSingleTagWithAfter($art_issue, ''); ?></a>
                </div>
                <div class="vf-meta__details">
                    <?php sis_printTagsWithHeaderAndEnd('<p class="vf-meta__topics">Ages: ', $art_ages, '</p>'); ?>
                    <?php sis_printTagsWithHeaderAndEnd('<p class="vf-meta__topics">Topics: ', $art_topics, '</p>'); ?>
                    <?php sis_printTagsWithHeaderAndEnd('<p class="vf-meta__topics">Keywords: ', $art_editor_tags, '</p>'); ?>
                </div>
                <div class="vf-links vf-links--tight vf-links__list--s">
                    <p class="vf-links__heading">Available languages</p>
                    <?php sis_articleLanguageSwitcher(); ?>
                </div>
            </aside>
        </div>
        <div class="vf-content">
            <div class="vf-author | vf-article-meta-info__author">
                <p class="">
                    <?php
                        sis_printFieldWithHeader('<strong>Author(s): </strong>', $art_author_name);
                        ?>
                        <br/>
                    <?php
                       sis_printFieldWithHeader('<strong>Translator(s): </strong>', $art_translator_name);
                            ?>
                </p>
            </div>

            <div class="sis-box-acknowledgements">
                <?php sis_printFieldWithHeader('', $art_acknowledgements); ?>
            </div>

            <p class=""><strong><?php echo get_the_excerpt(); ?></strong></p>

            <?php the_content(); ?>

            <?php if(!empty($art_pdf)){ ?>
                <h3>Download</h3>
                <p><a href="<?php sis_printArticlePDFLink($art_pdf); ?>" class="vf-button vf-button--primary">Download this article as a PDF</a></p>
            <?php } ?>

            <?php sis_printFieldWithHeader('<h2>References</h2>',$art_references); ?>

            <?php sis_printFieldWithHeader('<h2>Web References</h2>', $art_web_references); ?>

            <?php sis_printFieldWithHeader('<h2>Resources</h2>', $art_resources); ?>

            <?php sis_printTagsWithHeader('<h2>Institution</h2>',$art_institutions); ?>

            <?php sis_printFieldWithHeaderClass('<h3>Author(s)</h3>', $art_authors, 'sis-author-box'); ?>

            <?php
            if($art_review != ''){
                print '<div class="sis-reviewer-box">';
                print '<h3>Review</h3>';
                print $art_review;

                if($art_referee != ''){
                    print '<br><div class=""sis-reviewer-name">' . $art_referee . '</div>';
                }
                print '</div><br/>';
            }
            ?>

            <?php
                if(!empty($art_license) || !empty($art_license_freetext)){
                    print '<br/><br/><h3>License</h3>';
                }
            ?>
            <?php
            if(!empty($art_license)) {
                $tag_license = get_term($art_license);
                echo '<div><a href="/copyright">' . $tag_license->name . '</a></div>';
            }
            ?>

            <div>
                <?php echo $art_license_freetext; ?>
            </div>
        </div>
        <?php
        if(is_array($art_materials) && count($art_materials) > 0){
        ?>
        <article class="sis-materials">
            <h3>Supporting materials</h3>
            <ul>
                <?php foreach($art_materials as $singleAddMat){
                ?>
                <li><a class="sis-materials--link sis-materials--link-pdf" target="_blank"
                       href="<?php echo $singleAddMat['art_single_material'];?>"><?php echo $singleAddMat['art_single_name'];?></a></li>
                <?php
                }
                ?>
            </ul>
        </article>
        <?php
        }
        ?>
    </div>


    <?php include(locate_template('partials/vf-front-newsletter.php', false, false)); ?>

</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
