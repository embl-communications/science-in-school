<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-post">

    <section class="vf-hero | vf-u-fullbleed" style="--vf-hero--bg-image: url('/wp-content/themes/vf-wp-sis/assets/images/header/h2-event.jpg');  --vf-hero--bg-image-size: auto 28.5rem">
        <div class="vf-hero__content | vf-box | vf-stack vf-stack--400">
            <h2 class="vf-hero__heading"><a class="vf-hero__heading_link" href="/events/">Events</a></h2>
        </div>
    </section>


<!-- Webinars -->

<?php
        $currentWebinars = get_field('current_webinars');
        $shownWebinars = array();
        if ($currentWebinars) { ?>
<section class="vf-news-container vf-news-container--featured | embl-grid">
    <div class="vf-section-header"><a class="vf-section-header__heading vf-section-header__heading--is-link"
            href="/webinars" id="section-sub-heading-link-text">Webinars <svg aria-hidden="true"
                class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                    fill="" fill-rule="nonzero"></path>
            </svg></a>
        <p class="vf-section-header__text">Find out about up-coming Science in School webinars,
            which are hosted by different EIROforum member institutions.</p>
    </div>
    <div class="vf-news-container__content vf-grid vf-grid__col-3">
        <?php
            $webinarsLoop = new WP_Query(
                array(
                    'post_type' => 'vf_event',
                    'post__in' => $currentWebinars,
                    'post_status' => 'publish'
                )
            );

            while ($webinarsLoop->have_posts()) : $webinarsLoop->the_post();
                $shownWebinars[] = get_the_ID();
                include(locate_template('partials/vf-front-webinarsSingleWebinar.php', false, false));
            endwhile;
            wp_reset_postdata();
        }
        
        else {
            $webinarsLoop = new WP_Query(
                array(
                    'post_type' => 'vf_event',
                    'posts_per_page' => 3,
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

            if ($webinarsLoop->have_posts()) { ?>
        <section class="vf-news-container vf-news-container--featured | embl-grid">
            <div class="vf-section-header"><a class="vf-section-header__heading vf-section-header__heading--is-link"
                    href="/webinars" id="section-sub-heading-link-text">Webinars <svg aria-hidden="true"
                        class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                            fill="" fill-rule="nonzero"></path>
                    </svg></a>
                <p class="vf-section-header__text">Find out about up-coming Science in School webinars,
                    which are hosted by different EIROforum member institutions.</p>
            </div>
            <div class="vf-news-container__content vf-grid vf-grid__col-3">
                <?php
                while ($webinarsLoop->have_posts()) {
                    $webinarsLoop->the_post();
                    include(locate_template('partials/vf-front-webinarsSingleWebinar.php', false, false));
            } 
                } 

            wp_reset_postdata();
        }

        ?>
            </div>
        </section>
          <?php  if ($webinarsLoop->have_posts()) { 
            echo '<hr class="vf-divider"' ; }?>


<!-- Upcoming events -->
<section class="vf-news-container vf-news-container--featured | embl-grid">
    <div class="vf-section-header"><a class="vf-section-header__heading vf-section-header__heading--is-link" href="/eiroforum-events" id="section-sub-heading-link-text">Teaching events  <svg aria-hidden="true" class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z" fill="" fill-rule="nonzero"></path>
            </svg></a>
        <p class="vf-section-header__text">Discover free events and activities offered by the EIROforum members and other non-profit groups.</p>
    </div>
    <div class="vf-news-container__content vf-grid vf-grid__col-3">
        <?php
        $currentEvents = get_field('current_events', 242783);
        $shownEvents = array();
        if ($currentEvents) {
            $eventsLoop = new WP_Query(
                array(
                    'post_type' => 'vf_event',
                    'post__in' => $currentEvents,
                    'post_status' => 'publish'
                )
            );

            while ($eventsLoop->have_posts()) : $eventsLoop->the_post();
                $shownEvents[] = get_the_ID();
                include(locate_template('partials/vf-front-eventsSingleEvent.php', false, false));
            endwhile;
            wp_reset_postdata();
        }
        
        else {
            $eventsLoop = new WP_Query(
                array(
                    'post_type' => 'vf_event',
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                    'post__not_in' => $shownEvents,
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

            if ($eventsLoop->have_posts()) {
                while ($eventsLoop->have_posts()) {
                    $eventsLoop->the_post();
                    include(locate_template('partials/vf-front-eventsSingleEvent.php', false, false));
                }
            } else {
                echo 'No upcoming events';
            }

            wp_reset_postdata();
        }

        ?>
    </div>
</section>



</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>

