<?php
$registration_closing = get_field('vf_event_registration_closing');
$thumbnail_image = get_field('event_addon_thumbnail_image');
?>
<article class="vf-summary vf-summary--news">
    <span class="vf-summary__date"><?php sis_printFieldWithHeader('Deadline: ', $registration_closing); ?></span>
    <?php
    if (is_array($thumbnail_image) && array_key_exists('url', $thumbnail_image)) {
        ?>
        <img class="vf-summary__image"
             src="<?php echo $thumbnail_image['url']; ?>"
             loading="lazy">
        <?php
    }
    ?>
    <h3 class="vf-summary__title">
        <a href="<?php echo get_the_permalink(); ?>" class="vf-summary__link"><?php echo get_the_title(); ?></a>
    </h3>
    <p class="vf-summary__text">
        <?php echo get_the_excerpt(); ?>
        <br/><br/>
        <?php sis_printFieldWithHeader('Startdate (CET): ', get_field('vf_event_start_date')); ?>
        <br/>
        <?php sis_printFieldWithHeader('Starttime (CET): ', get_field('vf_event_start_time')); ?>

    </p>
</article>
