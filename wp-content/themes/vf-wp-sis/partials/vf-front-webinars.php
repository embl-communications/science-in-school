<!-- Webinars -->
<section class="vf-news-container vf-news-container--featured | embl-grid">
    <div class="vf-section-header">
        <h2 class="vf-section-header__heading">Webinars</h2>
        <p class="vf-section-header__text">Summary of something about webinars at SiS.</p>
    </div>
    <div class="vf-news-container__content vf-grid">

        <?php
        $featureLoop = new WP_Query(
            array(
                'post_type' => 'vf_event',
                'posts_per_page' => 3,
                'post_status' => 'publish',
                'orderby' => 'rand',
                'order' => 'DESC'));

        while ($featureLoop->have_posts()) : $featureLoop->the_post();
            include(locate_template('partials/vf-front-webinarsSingleWebinar.php', false, false));
        endwhile;
        wp_reset_postdata();
        ?>

    </div>
</section>
