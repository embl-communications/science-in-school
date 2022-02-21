<?php

/**
* Template Name: Webinars
*/

get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>

<section class="vf-hero | vf-u-fullbleed" style="--vf-hero--bg-image: url('/wp-content/themes/vf-wp-sis/assets/images/header/h2-event.jpg');  --vf-hero--bg-image-size: auto 28.5rem">
        <div class="vf-hero__content | vf-box | vf-stack vf-stack--400">
            <h2 class="vf-hero__heading"><a class="vf-hero__heading_link" href="/webinars">Webinars</a></h2>
            <p class="vf-hero__subheading">Find out about up-coming Science in School webinars, which are hosted by different EIROforum member institutions.</p>
        </div>
    </section>


    <?php the_content(); ?>

<div class="vf-grid | vf-grid__col-3 | vf-content">
    <div class="vf-grid__col--span-2">
<h2>Upcoming Webinars</h2>
<?php
$webinarsLoop = new WP_Query(
    array(
        'post_type' => 'vf_event',
        'posts_per_page' => 20,
        'post_status' => 'publish',
        'post__not_in' => $shownWebinars,
        'order' => 'ASC', 
        'orderby' => 'meta_value_num',
        'meta_key' => 'vf_event_start_date', 
        'meta_query' => array(
          array(
            'key' => 'vf_event_start_date',
            'value' => $current_date,
            'compare' => '>=',
            'type' => 'numeric'
          ),
          array(
            'key' => 'vf_event_start_date',
            'value' => date('Ymd', strtotime('now')),
            'type' => 'numeric',
            'compare' => '>=',
          ),
          array (
            'key' => 'sis_event_type',
            'value' => 'Webinar',
            'compare' => '=',
          ) 
        )
    )
);

if ($webinarsLoop->have_posts()) {
    while ($webinarsLoop->have_posts()) {
        $webinarsLoop->the_post();
        include(locate_template('partials/vf-events-webinars.php', false, false));
        if (($webinarsLoop->current_post + 1) < ($webinarsLoop->post_count)) {
            echo '<hr class="vf-divider">';
         }

    }
} else {
    echo 'No upcoming webinars';
}

wp_reset_postdata();
?>
    </div>
    <div>
    <article class="vf-card vf-card--brand">


<div class="vf-card__content | vf-stack vf-stack--400"><h3 class="vf-card__heading"><a class="vf-card__link" href="https://www.youtube.com/playlist?list=PLw1HXxSSAlZ29ORil3nbRMoA823a7O7gj">Previous webinars<svg aria-hidden="true" class="vf-card__heading__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg"><path d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z" fill="currentColor" fill-rule="nonzero"></path></svg>
</a></h3><p class="vf-card__subheading">Some of the EIROforum webinars are recorded and can be watched later on our Youtube channel.</p>

</div>
</article>
    </div>
</div>



<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>