<!-- Upcoming events -->
<section class="vf-news-container vf-news-container--featured | embl-grid">
    <div class="vf-section-header"><a class="vf-section-header__heading vf-section-header__heading--is-link" href="/events/" id="section-sub-heading-link-text">EIROforum events <svg aria-hidden="true" class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z" fill="" fill-rule="nonzero"></path>
            </svg></a>
        <p class="vf-section-header__text">Discover teaching events and activities offered by the EIROforum member institutions.</p>
    </div>
    <div class="vf-news-container__content vf-grid vf-grid__col-3">
        <?php
        $currentEvents = get_field('current_events');
        $numberOfCurrentEvents = 0;
        $shownEvents = array();
        if ($currentEvents) {
            $numberOfCurrentEvents += count($currentEvents);
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

        if($numberOfCurrentEvents < 3) {
            $eventsLoop = new WP_Query(
                array(
                    'post_type' => 'vf_event',
                    'posts_per_page' => 10,
                    'post_status' => 'publish',
                    'post__not_in' => $shownEvents,
                )
            );

            while ($eventsLoop->have_posts()) : $eventsLoop->the_post();
                $sis_event_type = get_field('sis_event_type');
                if($numberOfCurrentEvents < 3 && $sis_event_type != 'Webinar') {
                    $numberOfCurrentEvents++;
                    include(locate_template('partials/vf-front-eventsSingleEvent.php', false, false));
                }
            endwhile;
            wp_reset_postdata();
        }
        ?>
    </div>
</section>


