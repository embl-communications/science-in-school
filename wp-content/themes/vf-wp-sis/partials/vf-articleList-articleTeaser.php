<?php
$art_editor_tags = get_field('art_editor_tags');
$art_issue = get_field('art_issue');
$art_ages = get_field('art_ages');
$art_article_type = get_field('art_article_type');
$art_topics = get_field('art_topics');
?>
<article class="vf-summary vf-summary--news">
    <span class="vf-summary__date"><?php the_date(); ?> | <?php sis_printSingleTag($art_issue); ?></span>
    <?php the_post_thumbnail(array(238, 150), array('class' => 'vf-summary__image')); ?>
    <h3 class="vf-summary__title">
        <a href="<?php the_permalink(); ?>" class="vf-summary__link">
            <?php the_title(); ?>

            <?php
                if(isset($_GET['s'])){
                    $articleTypesArray = sis_getArticleTypesArray();
                    if(intval($art_article_type) == $articleTypesArray['UNDERSTAND']){
                        ?>
                        <a href="/?sis-article-types=understand" class="vf-badge vf-badge--secondary vf-badge--phases">Understand</a>
                        <?php
                    } else if(intval($art_article_type) ==  $articleTypesArray['INSPIRE']){
                        ?>
                        <a href="/?sis-article-types=inspire" class="vf-badge vf-badge--secondary vf-badge--phases">Inspire</a>
                        <?php
                    } else if(intval($art_article_type) ==  $articleTypesArray['TEACH']){
                        ?>
                        <a href="/?sis-article-types=teach" class="vf-badge vf-badge--secondary vf-badge--phases">Teach</a>
                        <?php
                    }
                }
            ?>
        </a>
    </h3>
    <p class="vf-summary__text">
        <?php echo get_the_excerpt(); ?>
    </p>



    <p class="vf-summary__source">
        <?php sis_printTagsWithHeaderAndEnd('Ages: ', $art_ages, '; <br/>'); ?>

        <?php sis_printTagsWithHeaderAndEnd('Topics: ', $art_topics, ' <br/>'); ?>

        <?php sis_articleLanguageSwitcherInLoopWithLanguageNames(); ?>
    </p>
    <p class="vf-summary__text">

    </p>
    <!--<p class="vf-summary__text">
      Type: teach,article
    </p>-->
</article>
