<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-post">

    <section class="vf-hero | vf-u-fullbleed" style=" --vf-hero--bg-image-size: auto 28.5rem">
        <div class="vf-hero__content | vf-box | vf-stack vf-stack--400">
            <!-- <p class="vf-hero__kicker"><a href="JavaScript:Void(0);">VF Hamburg</a> | Structural Biology</p> -->
            <h2 class="vf-hero__heading"><a class="vf-hero__heading_link" href="/events/">Events</a></h2>
            <p class="vf-hero__subheading"></p>
            <p class="vf-hero__text">Webinars and EIROforum events</p>
            <!--<a class="vf-hero__link" href="JavaScript:Void(0);">View the full PDF <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg">
              <path d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z" fill="" fill-rule="nonzero"></path>
            </svg>
            </a>-->
        </div>
    </section>


    <!-- Webinars -->
    <section class="vf-news-container vf-news-container--featured | embl-grid">
        <div class="vf-section-header"><a class="vf-section-header__heading vf-section-header__heading--is-link" href="/events/" id="section-sub-heading-link-text">Webinars <svg aria-hidden="true" class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z" fill="" fill-rule="nonzero"></path>
                </svg></a>
            <p class="vf-section-header__text">Summary of something about webinars at SiS.</p>
        </div>
        <div class="vf-news-container__content vf-grid vf-grid__col-3">
            <?php
            $numberOfCurrentWebinars = 0;
            $featureLoop = new WP_Query(
                array(
                    'post_type' => 'vf_event',
                    'posts_per_page' => 10,
                    'post_status' => 'publish',
                )
            );

            while ($featureLoop->have_posts()) : $featureLoop->the_post();
                $sis_event_type = get_field('sis_event_type');
                if($numberOfCurrentWebinars < 3 && $sis_event_type == 'Webinar') {
                    $numberOfCurrentWebinars++;
                    include(locate_template('partials/vf-front-webinarsSingleWebinar.php', false, false));
                }
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </section>


    <!-- Upcoming events -->
    <section class="vf-news-container vf-news-container--featured | embl-grid">
        <div class="vf-section-header"><a class="vf-section-header__heading vf-section-header__heading--is-link" href="/events/" id="section-sub-heading-link-text">EIROforum events <svg aria-hidden="true" class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z" fill="" fill-rule="nonzero"></path>
                </svg></a>
            <p class="vf-section-header__text">Hosted by EIROforum members.</p>
        </div>
        <div class="vf-news-container__content vf-grid vf-grid__col-3">
            <?php
            $numberOfCurrentEvents = 0;
            $featureLoop = new WP_Query(
                array(
                    'post_type' => 'vf_event',
                    'posts_per_page' => 10,
                    'post_status' => 'publish'
                )
            );

            while ($featureLoop->have_posts()) : $featureLoop->the_post();
                $sis_event_type = get_field('sis_event_type');
                if($numberOfCurrentEvents < 3 && $sis_event_type != 'Webinar') {
                    $numberOfCurrentEvents++;
                    include(locate_template('partials/vf-front-eventsSingleEvent.php', false, false));
                }
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </section>

</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>

