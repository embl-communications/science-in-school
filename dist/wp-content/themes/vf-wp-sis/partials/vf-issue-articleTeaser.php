<?php
$art_editor_tags = get_field('art_editor_tags');
$art_issue = get_field('art_issue');
$art_ages = get_field('art_ages');
$art_pdf = get_field('art_pdf');
$art_teaser = get_field('art_teaser_text', false, false);
$title = esc_html(get_the_title());
$title_pdf = strtolower($title);
$title_pdf = str_replace(' ', '-', $title_pdf);

?>

    <?php
    $articleType = get_field('art_article_type');
    $articleTypesArray = sis_getArticleTypesArray();
    if($articleType == $articleTypesArray['UNDERSTAND']){
        $articleTypeLabel = 'Understand';
    } else if($articleType == $articleTypesArray['INSPIRE']){
        $articleTypeLabel = 'Inspire';
    } else if($articleType == $articleTypesArray['TEACH']) {
        $articleTypeLabel = 'Teach';
    } else if($articleType == $articleTypesArray['EDITORIAL']) {
        $articleTypeLabel = 'Editorial';
    }
    ?>

<article class="vf-card vf-card--brand vf-card--bordered  sis-article-<?php print strtolower($articleTypeLabel); ?>">
    <span class="vf-badge sis-badge--<?php print strtolower($articleTypeLabel); ?>"><?php print $articleTypeLabel; ?></span>
    <img src="<?php echo get_the_post_thumbnail_url(); ?>"
         alt="<?php echo get_the_post_thumbnail_caption(); ?>" class="vf-card__image" loading="lazy">
    <div class="vf-card__content | vf-stack vf-stack--400">
        <h3 class="vf-card__heading"><a class="vf-card__link" href="<?php the_permalink();?>"><?php echo get_the_title();?>
                <svg
                        aria-hidden="true" class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end"
                        width="1em"
                        height="1em" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                            fill="currentColor" fill-rule="nonzero"></path>
                </svg>
            </a></h3>
        <span class="vf-summary__date"><?php sis_printSingleTagWithHeader(get_the_date() . ' | ', $art_issue); ?></span>
        <p class="vf-card__text">
        <?php
            if ($art_teaser) { ?>
            <?php echo strip_tags($art_teaser); ?>
            <?php }
            else  {?>
            <?php echo get_the_excerpt();?>
            <?php }  ?>        </p>
        <p class="vf-summary__meta">
            <?php sis_printTagsWithHeaderAndEnd('<span class="vf-u-text-color--ui--black">Ages:</span> ', $art_ages, '</br> ');?>
            <?php sis_printTagsWithHeaderAndEnd('<span class="vf-u-text-color--ui--black">Keywords:</span> ', $art_editor_tags, '');?>
            <br/>
        </p>
        <p class="vf-card__text" style="margin-bottom: 2rem !important;">
         <?php sis_articleLanguageSwitcherInLoopIssue(); ?>
        </p>
    </div>
    <?php if(!empty($art_pdf)){ ?>
    <p class="vf-card__text vf-u-padding__left--400" style="position: absolute; bottom: 12px; "><a class="vf-card__link" href="<?php echo $art_pdf['url']; ?>" data-vf-google-analytics-region="PDF-<?php echo $title_pdf; ?>">Article PDF</a></p>            
        <?php } ?>
</article>
