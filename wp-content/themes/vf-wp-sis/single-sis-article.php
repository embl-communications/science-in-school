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

$art_author_name= get_field('art_author_name');
$art_editor_tags= get_field('art_editor_tags');
$art_slider_exclude= get_field('art_slider_exclude');
$art_eonly_article= get_field('art_eonly_article');
$art_reviewer_tags= get_field('art_reviewer_tags');
$art_ages= get_field('art_ages');
$art_institutions= get_field('art_institutions');
$art_issue= get_field('art_issue');
$art_article_type= get_field('art_article_type');
$art_topics= get_field('art_topics');
$art_series= get_field('art_series');
$art_license= get_field('art_license');
$art_license_freetext= get_field('art_license_freetext');
$art_references= get_field('art_references');
$art_web_references= get_field('art_web_references');
$art_resources= get_field('art_resources');
$art_authors= get_field('art_authors');
$art_referee= get_field('art_referee');
$art_review= get_field('art_review');
$art_slider_image= get_field('art_slider_image');
$art_teaser_image= get_field('art_teaser_image');
$art_pdf= get_field('art_pdf');
$art_materials= get_field('art_materials');
$art_migrated_from_drupal= get_field('art_migrated_from_drupal');
$art_reviewed_after_migration_from_drupal= get_field('art_reviewed_after_migration_from_drupal');
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


     <?php
     echo "<div><hr>post id: ";
     the_ID() . '<br/><br/></div>'; ?>

        <div>
            <?php
            echo "<div>Author Name: " . $art_author_name . '<br/><br/></div>';

            echo "<div>Editor tags: ";
            if(is_array($art_editor_tags)){
                foreach($art_editor_tags as $tagId){
                    $tag = get_term($tagId);
                    echo $tag->name . ' ';
                }
            }
            echo '<br/><br/></div>';

            echo "<div>Slider exclude: " . $art_slider_exclude. '<br/><br/></div>';

            echo "<div>E-Only Article " . $art_eonly_article. '<br/><br/></div>';

            echo "<div>Reviewer tags: ";
            if(is_array($art_reviewer_tags)) {
                foreach ($art_reviewer_tags as $tagId) {
                    $tag = get_term($tagId);
                    echo $tag->name . ' ';
                }
            }
            echo '<br/><br/></div>';

            echo "<div>Ages tags: ";
            if(is_array($art_ages)) {
                foreach ($art_ages as $tagId) {
                    $tag = get_term($tagId);
                    echo $tag->name . ' ';
                }
            }
            echo '<br/><br/></div>';

            echo "<div>Institutions tags: ";
            if(is_array($art_institutions)) {
                foreach ($art_institutions as $tagId) {
                    $tag = get_term($tagId);
                    echo $tag->name . ' ';
                }
            }
            echo '<br/><br/></div>';


            echo "<div>Issue: ";
            if(!empty($art_issue)){
                $tag = get_term($art_issue);
                echo $tag->name . ' ';
            }
            echo '<br/><br/></div>';

            echo "<div>Article type: ";
            if(!empty($art_article_type)){
                $tag = get_term($art_article_type);
                echo $tag->name . ' ';
            }
            echo '<br/><br/></div>';

            echo "<div>Topics tags: ";
            if(is_array($art_topics)) {
                foreach ($art_topics as $tagId) {
                    $tag = get_term($tagId);
                    echo $tag->name . ' ';
                }
            }
            echo '<br/><br/></div>';

            echo "<div>Series tags: ";
            if(is_array($art_series)) {
                foreach ($art_series as $tagId) {
                    $tag = get_term($tagId);
                    echo $tag->name . ' ';
                }
            }
            echo '<br/><br/></div>';

            echo "<div>License: ";
            if(!empty($art_license)){
                $tag = get_term($art_license);
                echo $tag->name . ' ';
            }
            echo '<br/><br/></div>';

            echo "<div>Licesense freetext: " . $art_license_freetext. '<br/><br/></div>';

            echo "<div>References: " . $art_references. '<br/><br/></div>';

            echo "<div>Web references: " . $art_web_references. '<br/><br/></div>';

            echo "<div>Resources: " . $art_resources. '<br/><br/></div>';

            echo "<div>Authors: " . $art_authors. '<br/><br/></div>';

            echo "<div>Referee: " . $art_referee. '<br/><br/></div>';

            echo "<div>Review: " . $art_review. '<br/><br/></div>';

            echo "<div>Slider Image: ";
            if(is_array($art_slider_image) && array_key_exists("url", $art_slider_image)){
                echo $art_slider_image['url'];
            }
            echo '<br/><br/></div>';

            echo "<div>Teaser Image: ";
            if(is_array($art_teaser_image) && array_key_exists("url", $art_teaser_image)){
                echo $art_teaser_image['url'];
            }
            echo '<br/><br/></div>';

            echo "<div>PDF: ";
            if(is_array($art_pdf) && array_key_exists("url", $art_pdf)){
                echo $art_pdf['url'];
            }
            echo '<br/><br/></div>';

            echo "<div>Materials: ";
            if(is_array($art_materials)){
                foreach($art_materials as $singleMat){
                    echo $singleMat['art_single_material'] . '<br/>';
                }
            }
            echo  '<br/><br/></div>';

            echo "<div>Migrated: " . $art_migrated_from_drupal. '<br/><br/></div>';

            echo "<div>Reviewed: " . $art_reviewed_after_migration_from_drupal. '<br/><br/></div>';


            ?>
        </div>

        <div>
            Issue:

            <?php
            if(!empty($art_issue)) {
                $pages = get_posts(
                    array(
                        'post_type' => 'sis-issue',
                        'numberposts' => 1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'sis-issues',
                                'field' => 'term_id',
                                'terms' => $art_issue, /// Where term_id of Term 1 is "1".
                                'include_children' => false
                            )
                        )
                    )
                );
            }
            ?>
            <ul>
                <?php foreach ( $pages as $post ) : setup_postdata( $post ); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
                <?php endforeach; // Term Post foreach ?>
            </ul>
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
