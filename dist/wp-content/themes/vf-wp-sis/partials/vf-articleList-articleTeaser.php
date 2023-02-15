<?php
$art_editor_tags = get_field('art_editor_tags');
$art_issue = get_field('art_issue');
$art_ages = get_field('art_ages');
$art_article_type = get_field('art_article_type');
$art_topics = get_field('art_topics');
$art_pdf = get_field('art_pdf');
$art_teaser = get_field('art_teaser_text', false, false);

?>

<article class="sis-search-summary vf-summary vf-summary--news | vf-flag vf-flag--top vf-flag--400">
    <div class="vf-flag__media">
        <?php
                $articleTypesArray = sis_getArticleTypesArray();
                if(intval($art_article_type) == $articleTypesArray['UNDERSTAND']){
                    ?>
                    <a href="/?sis-article-types=understand" class="vf-badge sis-badge--understand">Understand</a>
                    <?php
                } else if(intval($art_article_type) ==  $articleTypesArray['INSPIRE']){
                    ?>
                    <a href="/?sis-article-types=inspire" class="vf-badge sis-badge--inspire">Inspire</a>
                    <?php
                } else if(intval($art_article_type) ==  $articleTypesArray['TEACH']){
                    ?>
                    <a href="/?sis-article-types=teach" class="vf-badge sis-badge--teach">Teach</a>
                    <?php
                } else if(intval($art_article_type) ==  $articleTypesArray['EDITORIAL']) {
                    ?>
                    <a href="/?sis-article-types=editorial" class="vf-badge sis-badge--editorial">Editorial</a>
                    <?php
                }
        ?>
        <?php the_post_thumbnail(array(238, 150), array('class' => 'sis-search-summary__image')); ?>
    </div>
    <div class="vf-flag__body">
        <span class="vf-summary__date"><time title="<?php the_time('c'); ?>"
            datetime="<?php the_time('c'); ?>"><?php the_time(get_option('date_format')); ?></time> | <?php sis_printSingleTag($art_issue); ?> <?php 
        // if(!empty($art_pdf)){ ?> 
    <!-- | <a class="vf-link" href="<?php // echo $art_pdf['url']; ?>">Download PDF</a>             -->
        <?php // } ?>
</span>
        <h3 class="vf-summary__title">
            <a href="<?php the_permalink(); ?>" class="vf-summary__link">
                <?php the_title(); ?>
            </a>
        </h3>
        <p class="vf-summary__text">
        <?php 
            if ($art_teaser) { ?>
            <?php echo strip_tags($art_teaser); ?>
            <?php }
            else  {?>
            <?php echo get_the_excerpt();?>
            <?php }  ?>        
        </p>
        <p class="vf-summary__source">
            <?php sis_printTagsWithHeaderAndEnd('Ages: ', $art_ages, '; <br/>'); ?>
            <?php sis_printTagsWithHeaderAndEnd('Topics: ', $art_topics, ' <br/>'); ?>
            <?php sis_articleLanguageSwitcherInLoop(); ?>
        </p>

    </div>
</article>
