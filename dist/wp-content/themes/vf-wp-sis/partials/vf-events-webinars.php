<?php
$registration_closing = get_field('vf_event_registration_closing');
$thumbnail_image = get_field('event_addon_thumbnail_image');
$age_group = get_field('vf_event_age_group');
$has_page = get_field('vf_event_has_page');
$summary = get_field('vf_event_summary');
?>

<article class="vf-summary vf-summary--news">

  <?php
    if (is_array($thumbnail_image) && array_key_exists('url', $thumbnail_image)) {
        ?>
        <img class="vf-summary__image"
             src="<?php echo $thumbnail_image['url']; ?>"
             loading="lazy">
             <?php
    }
    else { ?>
        <img class="vf-summary__image"
             src="http://scienceinschool.org.docker.localhost:57048/wp-content/uploads/2021/09/card_teach.jpg"
             loading="lazy">

   <?php }
    ?>
  <h3 class="vf-summary__title">
  <?php if ($has_page == 1) { ?>
    <a href="<?php echo get_the_permalink(); ?>" class="vf-summary__link">
    <?php } ?>
    <?php echo get_the_title(); ?>
    <?php if ($has_page == 1) { ?>
    </a>
    <?php } ?>
  </h3>
  <?php if ($summary) { ?>
  <p class="vf-summary__text">
    <?php echo $summary; ?>
  </p>
  <?php } ?>
  <?php if ($age_group) { ?>
  <p class="vf-summary__meta | vf-u-margin__bottom--200"><span>Ages </span><span class="vf-u-text-color--grey"><?php echo $age_group; ?></span></p>
  <?php } ?>
  <p class="vf-u-margin__bottom--200 vf-u-margin__top--0"><span style="color: #000; font-size: 16px; font-weight: 500;"><?php sis_printFieldWithEnding('(CET)', get_field('vf_event_start_date') . ' '. get_field('vf_event_start_time')); ?></span></p>
</article>
