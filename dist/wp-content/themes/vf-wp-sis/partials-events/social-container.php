<section
  class="embl-grid vf-u-background-color-ui--off-white vf-u-fullbleed vf-u-padding__top--600 vf-u-padding__bottom--800 vf-u-margin__bottom--0">
  <div class="vf-section-header">
    <h2 class="vf-section-header__heading" id="section-sub-heading">
      Stay in touch
    </h2>
  </div>
  <div class="vf-grid vf-grid__col-3">
    <div class="vf-grid__col--span-2">
      <h4 class="vf-text vf-text-heading--4">What's new on our blog</h4>
      <?php
    $eventsloop = new WP_Query(array('posts_per_page' => 3 ));
    while ($eventsloop->have_posts()) : $eventsloop->the_post(); ?>
      <article class="vf-summary vf-summary--article | vf-u-margin__bottom--400">
        <h2 class="vf-summary__title">
          <a href="<?php the_permalink(); ?>" class="vf-summary__link"
            style="font-size: 19px;"><?php echo esc_html(get_the_title()); ?></a>
        </h2>
        <span class="vf-summary__meta">
          <time class="vf-summary__date" title="<?php the_time('c'); ?>" datetime="<?php the_time('c'); ?>"
            style="margin-left: 0px;"><?php the_time(get_option('date_format')); ?></time>
        </span>
      </article>
      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>

    </div>
    <div class="vf-social-links">
      <div>
        <svg aria-hidden="true" display="none" class="vf-icon-collection vf-icon-collection--social">
          <defs>
            <g id="vf-social--linkedin">
              <rect xmlns="http://www.w3.org/2000/svg" width="5" height="14" x="2" y="8.5" rx=".5" ry=".5" />
              <ellipse xmlns="http://www.w3.org/2000/svg" cx="4.48" cy="4" rx="2.48" ry="2.5" />
              <path xmlns="http://www.w3.org/2000/svg"
                d="M18.5,22.5h3A.5.5,0,0,0,22,22V13.6C22,9.83,19.87,8,16.89,8a4.21,4.21,0,0,0-3.17,1.27A.41.41,0,0,1,13,9a.5.5,0,0,0-.5-.5h-3A.5.5,0,0,0,9,9V22a.5.5,0,0,0,.5.5h3A.5.5,0,0,0,13,22V14.5a2.5,2.5,0,0,1,5,0V22A.5.5,0,0,0,18.5,22.5Z" />
            </g>
            <g id="vf-social--facebook">
              <path xmlns="http://www.w3.org/2000/svg"
                d="m18.14 7.17a.5.5 0 0 0 -.37-.17h-3.77v-1.41c0-.28.06-.6.51-.6h3a.44.44 0 0 0 .35-.15.5.5 0 0 0 .14-.34v-4a.5.5 0 0 0 -.5-.5h-4.33c-4.8 0-5.17 4.1-5.17 5.35v1.65h-2.5a.5.5 0 0 0 -.5.5v4a.5.5 0 0 0 .5.5h2.5v11.5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5v-11.5h3.35a.5.5 0 0 0 .5-.45l.42-4a.5.5 0 0 0 -.13-.38z" />
            </g>
            <g id="vf-social--twitter">
             <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
            </g>
            <g id="vf-social--youtube">
              <path xmlns="http://www.w3.org/2000/svg"
                d="M20.06,3.5H3.94A3.94,3.94,0,0,0,0,7.44v9.12A3.94,3.94,0,0,0,3.94,20.5H20.06A3.94,3.94,0,0,0,24,16.56V7.44A3.94,3.94,0,0,0,20.06,3.5ZM16.54,12,9.77,16.36A.5.5,0,0,1,9,15.94V7.28a.5.5,0,0,1,.77-.42l6.77,4.33a.5.5,0,0,1,0,.84Z" />
            </g>
            <g id="vf-social--instagram">
              <path xmlns="http://www.w3.org/2000/svg"
                d="M17.5,0H6.5A6.51,6.51,0,0,0,0,6.5v11A6.51,6.51,0,0,0,6.5,24h11A6.51,6.51,0,0,0,24,17.5V6.5A6.51,6.51,0,0,0,17.5,0ZM12,17.5A5.5,5.5,0,1,1,17.5,12,5.5,5.5,0,0,1,12,17.5Zm6.5-11A1.5,1.5,0,1,1,20,5,1.5,1.5,0,0,1,18.5,6.5Z" />
            </g>
          </defs>
        </svg>

        <h3 class="vf-social-links__heading">
          Follow EMBL Events
        </h3>
        <ul class="vf-social-links__list">
          <li class="vf-social-links__item">
            <a class="vf-social-links__link" href="https://twitter.com/emblevents" target=”_blank”>
              <span class="vf-u-sr-only">
                twitter
              </span>
              <svg aria-hidden="true" class="vf-icon vf-icon--social vf-icon--twitter" width="24" height="24"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" version="1.1" preserveAspectRatio="xMinYMin">
                <use xlink:href="#vf-social--twitter">
                </use>
              </svg>
            </a>
          </li>
          <li class="vf-social-links__item">
            <a class="vf-social-links__link" href="https://www.instagram.com/emblevents/" target=”_blank”>
              <span class="vf-u-sr-only">
                instagram
              </span>
              <svg aria-hidden="true" class="vf-icon vf-icon--social vf-icon--instagram" width="24" height="24"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" version="1.1" preserveAspectRatio="xMinYMin">
                <use xlink:href="#vf-social--instagram">
                </use>
              </svg>
            </a>
          </li>
          <li class="vf-social-links__item">
            <a class="vf-social-links__link" href="http://en-gb.facebook.com/EMBLEvents" target=”_blank”>
              <span class="vf-u-sr-only">
                facebook
              </span>
              <svg aria-hidden="true" class="vf-icon vf-icon--social vf-icon--facebook" width="24" height="24"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" version="1.1" preserveAspectRatio="xMinYMin">
                <use xlink:href="#vf-social--facebook">
                </use>
              </svg>
            </a>
          </li>
          <li class="vf-social-links__item">
            <a class="vf-social-links__link" href="https://www.linkedin.com/showcase/embl-events/" target=”_blank”>
              <span class="vf-u-sr-only">
                linkedin
              </span>
              <svg aria-hidden="true" class="vf-icon vf-icon--social vf-icon--linkedin" width="24" height="24"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" version="1.1" preserveAspectRatio="xMinYMin">
                <use xlink:href="#vf-social--linkedin">
                </use>
              </svg>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
