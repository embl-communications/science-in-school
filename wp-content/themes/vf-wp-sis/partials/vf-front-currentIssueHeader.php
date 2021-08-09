<!-- <style>
    /* fullbleed image */
    .vf-wp-sis .sis-u-background-current-issue {
        background: none !important;
    }

    .vf-wp-sis .sis-u-background-current-issue::before {
        background: url(<?php echo get_the_post_thumbnail_url(); ?>);
        background-position: 50%;
        background-size: cover;
    }
</style> --> 

    <article class="vf-box vf-box--is-link vf-box-theme--primary vf-box--normal">
        <h3 class="vf-box__heading"><a class="vf-box__link" href="<?php echo get_the_permalink(); ?>">Current issue</a></h3>
        <p class="vf-box__text">
            <?php echo get_the_title(); ?>
        </p>
        <p class="vf-box__text">
            <a class="vf-link" href="<?php echo get_the_permalink(); ?>">View the full issue</a>
        </p>
    </article>
