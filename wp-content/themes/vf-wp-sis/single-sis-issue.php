<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-home">
    <?php include(locate_template('partials/vf-hero--as-promotion.php', false, false)); ?>

<?php
  $title = esc_html(get_the_title());
  $user_id = get_the_author_meta('ID');
  get_header();

    $iss_web_only = get_field('iss_web_only');
    $iss_cover_image = get_field('iss_cover_image');
    $iss_issue = get_field('iss_issue');
    $iss_pdf = get_field('iss_pdf');
    $iss_articles = get_field('iss_articles');
    $iss_previous_issue = get_field('iss_previous_issue');
    $iss_next_issue = get_field('iss_next_issue');
    $iss_show_banner = get_field('iss_show_banner');
    $iss_migrated_from_drupal = get_field('iss_migrated_from_drupal');
    $iss_reviewed_after_migration_from_drupal = get_field('iss_reviewed_after_migration_from_drupal');

?>



<section class="embl-grid embl-grid--has-centered-content | vf-u-padding__top--200 | vf-u-margin__bottom--0">
 <div>
    <div class="vf-article-meta-information">
    <div class="vf-author | vf-article-meta-info__author">
    <p class="vf-author__name">
        <a class="vf-link" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a>
    </p>
        <a class="vf-author--avatar__link | vf-link" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
        <?php echo get_avatar( get_the_author_meta( 'ID' ), 48, '', '', array('class' => 'vf-author--avatar')); ?>
        </a>
    </div>
        <div class="vf-meta__details">
        <p class="vf-meta__date"><time title="<?php the_time('c'); ?>" datetime="<?php the_time('c'); ?>"><?php the_time(get_option('date_format')); ?></time></p>
        </div>
    </div>

 </div>
 <div class="vf-content | vf-u-padding__bottom--800">
  <h1 class="vf-text vf-text-heading--1"><?php the_title(); ?></h1>
  <p class="vf-lede | vf-u-padding__top--md | vf-u-padding__bottom--xxl">
      <?php echo get_post_meta($post->ID, 'ells_article_intro', true); ?>
    </p>
    <figure class="vf-figure">
      <?php the_post_thumbnail('full', array('class' => 'vf-figure__image')); ?>
      <figcaption class="vf-figure__caption">
        <?php echo wp_kses_post(get_post(get_post_thumbnail_id())->post_excerpt); ?>
      </figcaption>
    </figure>

    <?php the_content(); ?>

    <div>
        <?php
        echo "Web only: " . $iss_web_only . '<br/><br/>';
        echo "Cover image: " . $iss_cover_image . '<br/><br/>';

        echo "<div>Issue: ";
        if(!empty($iss_issue)){
            $tag = get_term($iss_issue);
            echo $tag->name . ' ';
        }
        echo '<br/><br/></div>';

        echo "PDF: " . $iss_pdf . '<br/><br/>';

        print '<br/><br/>';
        echo "Articles: ". '<br/><br/>';
        if(is_array($iss_articles)){
            foreach($iss_articles as $singleArticle){
                echo $singleArticle->post_title . '  ' . $singleArticle->ID . '<br/>';
            }
        }

        print '<br/><br/>';
        echo "Previous issue: " .  '<br/><br/>';
        if(is_array($iss_previous_issue)){
            foreach($iss_previous_issue as $singleArticle){
                echo $singleArticle->post_title . '  ' . $singleArticle->ID;

            }
        }

        print '<br/><br/>';
        echo "Next issue: " . '<br/><br/>';
        if(is_array($iss_next_issue)){
            foreach($iss_next_issue as $singleArticle){
                echo $singleArticle->post_title . '  ' . $singleArticle->ID;

            }
        }
        print '<br/><br/>';

        echo "Show banner: " . $iss_show_banner . '<br/><br/>';
        echo "Migrated from Drupal: " . $iss_migrated_from_drupal . '<br/><br/>';
        echo "Reviewed: " . $iss_reviewed_after_migration_from_drupal . '<br/><br/>';



        ?>
    </div>
 </div>


  <div class="social-media-block">
<div class='red'>

</div>
<?php include(locate_template('partials/social-icons.php', false, false)); ?>

<div class="vf-social-links | vf-u-margin__bottom--xxl">
  <h3 class="vf-social-links__heading">
    Share
  </h3>
  <ul class="vf-social-links__list">
    <li class="vf-social-links__item">
      <a class="vf-social-links__link"
        href="https://twitter.com/intent/tweet?text=<?php echo $title; ?>&amp;url=<?php echo $social_url; ?>&amp;via=embl">
        <span class="vf-u-sr-only">twitter</span>

        <svg aria-hidden="true" class="vf-icon vf-icon--social vf-icon--twitter" width="24" height="24"
          viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" version="1.1" preserveAspectRatio="xMinYMin">
          <use xlink:href="#vf-social--twitter"></use>
        </svg>
      </a>

    </li>
    <li class="vf-social-links__item">

      <a class="vf-social-links__link"
        href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $social_url; ?>">
        <span class="vf-u-sr-only">facebook</span>

        <svg aria-hidden="true" class="vf-icon vf-icon--social vf-icon--facebook" width="24" height="24"
          viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" version="1.1" preserveAspectRatio="xMinYMin">
          <use xlink:href="#vf-social--facebook"></use>
        </svg>
      </a>
    </li>

    <li class="vf-social-links__item">
      <a class="vf-social-links__link"
        href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $social_url; ?>&title=<?php echo $title; ?>">
        <span class="vf-u-sr-only">linkedin</span>

        <svg aria-hidden="true" class="vf-icon vf-icon--social vf-icon--linkedin" width="24" height="24"
          viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" version="1.1" preserveAspectRatio="xMinYMin">
          <use xlink:href="#vf-social--linkedin"></use>
        </svg>
      </a>
    </li>
  </ul>
</div>
</div>
</section>

<section class="vf-u-background-color-ui--off-white | vf-u-margin__bottom--100 | vf-u-padding__top--600 | vf-u-padding__bottom--400 | vf-u-fullbleed | category-more">
  <h3 class="vf-section-header__heading | vf-u-margin__bottom--400">Recent posts</h3>
  <div class="vf-grid vf-grid__col-3">
    <?php
      $args = array(
        'posts_per_page' => 3,
        'post__not_in'   => array( get_the_ID() ),
        'no_found_rows'  => true,
      );

      $cats = wp_get_post_terms( get_the_ID(), 'category' );
      $cats_ids = array();
      foreach( $cats as $related_cat ) {
        $cats_ids[] = $related_cat->term_id;
      }
      if ( ! empty( $cats_ids ) ) {
        $args['category__in'] = $cats_ids;
      }

      $query = new wp_query( $args );

      foreach( $query->posts as $post ) : setup_postdata( $post ); ?>

    <?php include(locate_template('partials/vf-card--article-more.php', false, false)); ?>
    <?php endforeach; wp_reset_postdata(); ?>
  </div>
</section>

</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
