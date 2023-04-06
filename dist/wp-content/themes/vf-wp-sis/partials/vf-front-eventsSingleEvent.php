<?php
$registration_closing = get_field('vf_event_registration_closing');
$thumbnail_image = get_field('event_addon_thumbnail_image');
$age_group = get_field('vf_event_age_group');
$has_page = get_field('vf_event_has_page');
$summary = get_field('vf_event_summary');
$event_date_text = get_field('vf_event_date_text');

?>
<article class="vf-summary vf-summary--news">
    <a href="<?php echo get_the_permalink(); ?>">
        <?php
    if (is_array($thumbnail_image) && array_key_exists('url', $thumbnail_image)) {
        ?>
        <img style="aspect-ratio: 8/4; max-width: unset;" class="vf-summary__image"
            src="<?php echo $thumbnail_image['url']; ?>" loading="lazy">
        <?php
    }
    ?>
    </a>
    <h3 class="vf-summary__title">
        <?php if ($has_page == 1) { ?>
        <a href="<?php echo get_the_permalink(); ?>" class="vf-summary__link">
            <?php } ?>
            <?php echo get_the_title(); ?>
            <?php if ($has_page == 1) { ?>
        </a>
        <?php } ?>
    </h3>
    <?php if (get_the_excerpt() !='') { ?>
    <p class="vf-summary__text">
        <?php
            echo get_the_excerpt();
            ?>
    </p>
    <?php } ?>
    <?php if ($age_group) { ?>
    <p class="vf-summary__meta | vf-u-margin__bottom--0">Ages: <span
            class="vf-u-text-color--grey"><?php echo $age_group; ?></span></p>
    <?php } ?>
    <?php if ($event_date_text) { ?>
    <p class="vf-summary__meta | vf-u-margin__bottom--0"><?php echo $event_date_text; ?> <span
            class="vf-u-text-color--grey"><?php sis_printFieldWithEnding('(CET)', get_field('vf_event_start_date') . ' '. get_field('vf_event_start_time')); ?></span>
    </p>
    <?php
        }
        if ($registration_closing) { ?>
    <p class="vf-summary__meta | vf-u-margin__bottom--200 vf-u-margin__top--0">Registration deadline: <span
            class="vf-u-text-color--grey"><?php echo $registration_closing; ?></span></p>
    <?php } ?>
</article>