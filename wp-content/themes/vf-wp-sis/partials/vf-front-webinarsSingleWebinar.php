<?php
$registration_closing = get_field('vf_event_registration_closing');
?>
<article class="vf-summary vf-summary--news">
    <span class="vf-summary__date">8 to 12 years old | <?php sis_printFieldWithHeader('Deadline: ', $registration_closing);?></span>
    <img class="vf-summary__image"
         src="<?php echo get_the_post_thumbnail_url(); ?>"
         loading="lazy">
    <h3 class="vf-summary__title">
        <a href="<?php echo get_the_permalink(); ?>" class="vf-summary__link"><?php echo get_the_title(); ?></a>
    </h3>
    <p class="vf-summary__text">
        <?php echo get_the_excerpt(); ?>
    </p>
</article>

