<?php
global $wp;
$currentUrl = home_url( $wp->request );
// Get all "organiser" terms
$types_terms = get_terms(
    array(
      'taxonomy'   => 'sis-article-types',
      'hide_empty' => false,
    )
  );
  $types_terms = array_filter($types_terms, function($term) {
    return $term->slug !== 'editorials';
});
  
  // Get all "Location" terms
  $ages_terms = get_terms(
    array(
      'taxonomy'   => 'sis-ages',
      'hide_empty' => false,
    )
  );
  
    // Get all "Location" terms
    $topic_terms = get_terms(
        array(
          'taxonomy'   => 'sis-categories',
          'hide_empty' => false,
        )
      );
    // Get all "Location" terms
    $issues_terms = get_terms(
        array(
          'taxonomy'   => 'sis-issues',
          'hide_empty' => false,
        )
      );

      $currentYear = date("Y");

      $counterTyp = 1;
      $counterAge = 1;
      $counterTop = 1;
      $counterIss = 1;
      ?>
    <!-- <button type="button" id="resetFilters" class="vf-button vf-button--secondary">Reset</button> -->

<form class="vf-stack vf-stack-400 | vf-u-margin__bottom--800">
<fieldset class="vf-form__fieldset vf-stack vf-stack--400 | vf-u-margin__bottom--800" id="checkbox-filter-type">
    <legend class="vf-form__legend">Type</legend>
    <?php
    foreach($types_terms as $term) {
      ?>
    <div class="vf-form__item vf-form__item--checkbox">
      <input id="type-<?php echo $counterTyp; ?>" type="checkbox" data-jplist-control="checkbox-text-filter"
        data-path=".type" data-group="data-group-1" data-name="type" data-or="type"
        value="<?php echo esc_attr($term->name); ?>"
        data-id="type-<?php echo esc_attr($term->slug); ?>" class="vf-form__checkbox checkboxLive inputLive">
      <label for="type-<?php echo $counterTyp; ?>" class="vf-form__label"><?php echo esc_html($term->name); ?>
      &nbsp;<span class="filterCounter"
      data-jplist-control="counter"
      data-group="data-group-1"
      data-format="({count})"
      data-path=".type-<?php echo esc_attr($term->slug); ?>"
      data-mode="static"
      data-name="counter-type-<?php echo esc_attr($term->slug); ?>"
      data-filter-type="path"></span>
    </label>
    </div>
    <?php
      $counterTyp++;
    }

    ?>
  </fieldset>

<fieldset class="vf-form__fieldset vf-stack vf-stack--400 | vf-u-margin__bottom--800" id="checkbox-filter-age">
    <legend class="vf-form__legend">Age</legend>
    <?php
    foreach($ages_terms as $term) {
      ?>
    <div class="vf-form__item vf-form__item--checkbox">
      <input id="age-<?php echo $counterAge; ?>" type="checkbox" data-jplist-control="checkbox-text-filter"
        data-path=".age" data-group="data-group-1" data-name="age" data-or="age"
        value="<?php echo esc_attr($term->name); ?>"
        data-id="age-<?php echo esc_attr($term->slug); ?>" class="vf-form__checkbox checkboxLive inputLive">
      <label for="age-<?php echo $counterAge; ?>" class="vf-form__label"><?php echo esc_html($term->name); ?>
      &nbsp;<span 
      data-jplist-control="counter"
      data-group="data-group-1"
      data-format="({count})"
      data-path=".age-<?php echo esc_attr($term->slug); ?>"
      data-mode="static"
      data-name="counter-age-<?php echo esc_attr($term->slug); ?>"
      data-filter-age="path"></span>
    </label>
    </div>
    <?php
      $counterAge++;
    }

    ?>
  </fieldset>

<fieldset class="vf-form__fieldset vf-stack vf-stack--400 | vf-u-margin__bottom--800" id="checkbox-filter-topic">
    <legend class="vf-form__legend">Topic</legend>
    <?php
    foreach($topic_terms as $term) {
      ?>
    <div class="vf-form__item vf-form__item--checkbox">
      <input id="topic-<?php echo $counterTop; ?>" type="checkbox" data-jplist-control="checkbox-text-filter"
        data-path=".topic" data-group="data-group-1" data-name="topic" data-or="topic"
        value="<?php echo esc_attr($term->name); ?>"
        data-id="topic-<?php echo esc_attr($term->slug); ?>" class="vf-form__checkbox checkboxLive inputLive">
      <label for="topic-<?php echo $counterTop; ?>" class="vf-form__label"><?php echo esc_html($term->name); ?>
      &nbsp;<span 
      data-jplist-control="counter"
      data-group="data-group-1"
      data-format="({count})"
      data-path=".topic-<?php echo esc_attr($term->slug); ?>"
      data-mode="static"
      data-name="counter-topic-<?php echo esc_attr($term->slug); ?>"
      data-filter-topic="path"></span>
    </label>
    </div>
    <?php
      $counterTop++;
    }

    ?>
  </fieldset>

  <fieldset class="vf-form__fieldset vf-stack vf-stack--400">
  <legend class="vf-form__legend">Issue</legend>
  <div class="vf-form__item vf-stack">
    <select class="vf-form__select issueLive" id="selectIssue" data-jplist-control="select-filter" data-group="data-group-1" data-name="issue">
      <option value="0" data-path="default">All</option>
      <?php
        $issuesGetParamArrayIds = sis_getTermIdsFromGetParam('sis-issues');
        $issueParentTerms = get_terms('sis-issues', array('hide-empty' => true, 'parent' => 0));
        foreach($issueParentTerms as $singleIssueTerm){
          $terms = get_terms('sis-issues', array('hide-empty' => true, 'parent' => $singleIssueTerm->term_id));
          sort($terms);
          foreach ($terms as $term) {
      ?>
            <option data-path=".<?php echo esc_attr($term->slug); ?>" 
              
              value="<?php echo $term->slug; ?>"><?php echo $term->name; ?>
            </option>
      <?php
          } 
        }
      ?>
    </select>
  </div>
</fieldset>

<fieldset class="vf-form__fieldset vf-stack vf-stack--400" style="display: none;">
  <legend class="vf-form__legend">Language</legend>
  <div class="vf-form__item vf-stack">
    <select class="vf-form__select selectLive" id="selectLang" data-jplist-control="select-filter" data-group="data-group-1" data-name="lang">
      <option class="" value="0" data-path="default">Any</option>
      <?php
        $languages = apply_filters('wpml_active_languages', NULL, 'skip_missing=0&orderby=code');
        sort($languages);
        foreach($languages as $singleLanguage){
      ?>
            <option class="" data-path=".<?php echo $singleLanguage['language_code']; ?>"
              
              value="<?php echo $singleLanguage['language_code']; ?>"><?php echo $singleLanguage['native_name']; ?></option>
      <?php
        }
      ?>
    </select>
  </div>
</fieldset>



</form>