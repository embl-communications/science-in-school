<?php

/**
* Template Name: EIROforum events
*/

get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>

<section class="vf-hero | vf-u-fullbleed" style="--vf-hero--bg-image: url('/wp-content/themes/vf-wp-sis/assets/images/header/h2-event.jpg');  --vf-hero--bg-image-size: auto 28.5rem">
        <div class="vf-hero__content | vf-box | vf-stack vf-stack--400">
            <h2 class="vf-hero__heading"><a class="vf-hero__heading_link" href="/eiroforum-events">EIROforum events</a></h2>
            <p class="vf-hero__subheading">Discover teaching events and activities offered by the EIROforum member institutions.

</p>
        </div>
    </section>


    <?php the_content(); ?>

<div class="vf-grid | vf-grid__col-3 | vf-content">
    <div class="vf-grid__col--span-2">
<h2>Upcoming Events</h2>
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
            'value' => 'EIROforum',
            'compare' => '=',
          ) 
        )
    )
);

if ($webinarsLoop->have_posts()) {
    while ($webinarsLoop->have_posts()) {
        $webinarsLoop->the_post();
        include(locate_template('partials/vf-events-eiroforum.php', false, false));
        if (($webinarsLoop->current_post + 1) < ($webinarsLoop->post_count)) {
            echo '<hr class="vf-divider">';
         }

    }
} else {
    echo 'No upcoming events';
}

wp_reset_postdata();
?>
    </div>
    <div>
    </div>
</div>



<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>