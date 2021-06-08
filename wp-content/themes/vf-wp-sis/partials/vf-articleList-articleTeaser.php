<?php
$art_editor_tags = get_field('art_editor_tags');
$art_issue = get_field('art_issue');
$art_ages = get_field('art_ages');
?>
<article class="vf-summary vf-summary--news">
    <span class="vf-summary__date"><?php the_date(); ?> | <?php sis_printSingleTag($art_issue); ?></span>
    <!--img class="vf-summary__image"
         src="https://www.scienceinschool.org/sites/default/files/articleContentImages/52/TeaTime/Slider.png"
         alt="News image alt" loading="lazy"-->
    <?php the_post_thumbnail('full', array('class' => 'vf-summary__image')); ?>
    <h3 class="vf-summary__title">
        <a href="<?php the_permalink(); ?>" class="vf-summary__link">
            <?php the_title(); ?>
        </a>
    </h3>
    <p class="vf-summary__text">
        <?php echo get_the_excerpt(); ?>
    </p>



    <p class="vf-summary__source">
        Ages: <?php sis_printTags($art_ages); ?>; Keywords: <?php sis_printTags($art_editor_tags); ?>
        <br/>
        <?php sis_articleLanguageSwitcherInLoopWithLanguageNames(); ?>
        <!--gb,es-->

    </p>
    <p class="vf-summary__text">

    </p>
    <!--<p class="vf-summary__text">
      Type: teach,article
    </p>-->
</article>
