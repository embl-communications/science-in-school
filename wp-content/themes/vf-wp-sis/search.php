<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-home">
    <?php include(locate_template('partials/vf-hero--as-promotion.php', false, false)); ?>

    <?php

$total_results = $wp_query->found_posts;

?>



<section class="embl-grid embl-grid--has-centered-content">
  <div></div>
  <div class="vf-content">

    <h1 class="vf-text-heading--1">Search</h1>

    <style>
    
    .vf-search--inline .vf-search__input {
      min-width: 300px;
    }
    .vf-search--inline .vf-form__select {
      padding: 8px 12px;
    }
    .vf-search--inline .vf-search__item:not(:first-child) {
      padding-left: 10px;
    }
    </style>
    <div>
    <form role="search" method="get" class="vf-form  | vf-search vf-search--inline" action="<?php echo esc_url(home_url('/')); ?>">
  <div class="vf-form__item | vf-search__item">
    <input type="search" class="vf-form__input | vf-search__input" value="<?php echo esc_attr(get_search_query()); ?>" name="s">
  </div>
  <div class="vf-form__item | vf-search__item">
          <label class="vf-form__label vf-u-sr-only | vf-search__label" for="vf-form__select">Category</label>
          <select class="vf-form__select" id="vf-form__select" name="post_type" value="post_type">
            <option value="all" selected="" >Everything</option>
          </select>
        </div>
  <input type="submit" class="vf-search__button | vf-button vf-button--primary vf-button--sm" value="<?php esc_attr_e('Search', 'vfwp'); ?>">
</form>

    </div>

  </div>
</section>


<?php
        if ( have_posts() ) {
          while ( have_posts() ) {
            the_post();
            include(locate_template('partials/vf-summary--news.php', false, false)); 
          }
        } else {
          echo '<p>', __('No posts found', 'vfwp'), '</p>';
        } ?>
  <div class="vf-grid"> <?php vf_pagination();?></div>


</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
