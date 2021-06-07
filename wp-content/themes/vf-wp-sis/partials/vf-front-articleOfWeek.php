<?php
$articleOfWeek = get_field('articleofweek');
if($articleOfWeek){
    foreach ($articleOfWeek as $post) {
        setup_postdata($post);
?>
    <section class="vf-hero vf-hero--1200 | vf-u-fullbleed"
             style="--vf-hero--bg-image: url('<?php echo get_the_post_thumbnail_url(); ?>'); margin-bottom: 0;">
        <div class="vf-hero__content | vf-box | vf-stack vf-stack--400 ">
            <p class="vf-hero__kicker">Article of the week</p>
            <h2 class="vf-hero__heading">
                <a class="vf-hero__heading_link" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
            </h2>
            <p class="vf-hero__text"><?php echo get_the_excerpt(); ?></p>
            <a class="vf-hero__link" href="<?php echo get_the_permalink(); ?>">Read more
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                          fill="" fill-rule="nonzero"></path>
                </svg>
            </a>
        </div>
    </section>
<?php
        break;
    }
    wp_reset_postdata();
}
?>
