<?php

/**
* Template Name: Search
*/


get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-search">

    <section class="embl-grid embl-grid--has-centered-content | vf-u-fullbleed vf-u-background-color-ui--grey--light vf-stack | vf-u-padding__bottom--600" id="searchContainer">
        <div></div>
        <div>
            <h1 class="vf-text vf-text-heading--1">Search</h1>
            <!-- <p class="vf-text-body">
                If you need a description about the service or context of the search.
            </p> -->
            <form action="#eventsFilter" onsubmit="return false;" style="display: flex; flex-direction: row;"
          class="vf-form vf-form--search vf-form--search--responsive | vf-sidebar vf-sidebar--end">
          <div class="vf-sidebar__inner" style="width: 100%;">
            <div class="vf-form__item">
            <legend class="vf-form__legend">Search term</legend>
              <label class="vf-form__label vf-u-sr-only | vf-search__label" for="search">Search</label>
              <input id="search" class="vf-form__input vf-form__input--filter | inputLive" data-jplist-control="textbox-filter"
                data-group="data-group-1" data-name="my-filter-1" data-path=".search-data" type="text" value=""
                placeholder="Search Science in School" data-clear-btn-id="name-clear-btn">
            </div>
            <div class="vf-form__item" style="min-width: 10rem;">
      <legend class="vf-form__legend">Language</legend>
      <select class="vf-form__select" id="selectLangForm">
  <option value="en">English</option>
  <?php
    $languages = apply_filters('wpml_active_languages', NULL, 'skip_missing=0&orderby=code');
    sort($languages);
    foreach($languages as $singleLanguage){
      if ($singleLanguage['language_code'] !== 'en') {
  ?>
        <option value="<?php echo $singleLanguage['language_code']; ?>"><?php echo $singleLanguage['native_name']; ?></option>
  <?php
      }
    }
  ?>
</select>
    </div>
    <div id="languageSpinnerWrapper">
      <div id="languageSpinner"></div>
    </div>
          </div>
        </form>

        <p class="textLoader | vf-u-margin__bottom--0 vf-u-margin__top--600" id="loading-placeholder"></p>
<p class="vf-text-body vf-text-body--2 | vf-u-text-color--grey--darkest | vf-u-margin__bottom--0 vf-u-margin__top--600" id="total-results-info" style="display: none;">Showing <span id="start-counter" class="counter-highlight"></span><span
            id="end-counter" class="counter-highlight"></span> results out of <span id="total-result"
            class="counter-highlight"></span></p>

        </div>
    </section>

    <section class="embl-grid">
        <div class="vf-stack vf-stack--800">
            <?php include(locate_template('partials/search-filter.php', false, false)); ?>
        </div>
        <div id="mainContainer">
        <!-- <div id="spinner-container">
    <div class="spinner"></div>
  </div> -->
        <div class="vf-stack" id="upcoming-events" data-jplist-group="data-group-1">
          <?php
         $forthcomingLoop = new WP_Query(array(
            'post_type' => 'sis-article',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'suppress_filters' => false,
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'sis-article-types',
                    'field' => 'slug',
                    'terms' => array('inspire', 'teach', 'understand'),
                ),
            ),
        ));
        $temp_query = $wp_query;
        $wp_query   = NULL;
        $wp_query   = $forthcomingLoop;
          $current_month = ""; ?>
          <?php while ($forthcomingLoop->have_posts()) : $forthcomingLoop->the_post();?>
          <?php
         include(locate_template('partials/vf-search-articleTeaser.php', false, false)); ?>
          <?php endwhile;?>
          <!-- no results control -->
          <article class="vf-summary" data-jplist-control="no-results" data-group="data-group-1" data-name="no-results">
            <p class="vf-summary__text">
              No results found
            </p>
          </article>
        </div>
        <nav id="paging-data" class="vf-pagination" aria-label="Pagination"  style="display: none;">
          <ul class="vf-pagination__list"></ul>
        </nav>

        </div>
    </section>


</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>

<style>




</style>

<script type="text/javascript">
  jplist.init({
    // deepLinking: true
  });


  document.addEventListener('DOMContentLoaded', function() {
  const selectLang = document.getElementById('selectLang');
  const selectIssue = document.getElementById('selectIssue');
  const searchBar = document.getElementById('search'); // Assuming there's a search bar with this ID
  const checkboxes = document.querySelectorAll('.vf-form__checkbox'); // Select all checkboxes with this class

  // Function to count the items based on the language code
  function countItemsByLanguageCode(languageCode) {
    if (languageCode === '0') {
      return document.querySelectorAll('article[data-jplist-item]').length; // Default count for "Any"
    }
    return document.querySelectorAll(`article[data-jplist-item] .wpml-ls-slot-post_translations span.${languageCode}`).length;
  }

  // Function to count the items based on the issue number
  function countItemsByIssue(issueClass) {
    if (issueClass === '0') {
      return document.querySelectorAll('article[data-jplist-item]').length; // Default count for "Any"
    }
    return document.querySelectorAll(`article[data-jplist-item] .vf-summary__date .${issueClass}`).length;
  }

  // Function to update the counts in the language select options
  function updateLanguageCounts() {
    const options = selectLang.options;
    for (let i = 0; i < options.length; i++) {
      const languageCode = options[i].value;
      const itemCount = countItemsByLanguageCode(languageCode);
      const nativeName = options[i].text.split(' (')[0]; // Remove previous count if present
      options[i].text = `${nativeName} (${itemCount})`;
    }
  }

  // Function to update the counts in the issue select options
  function updateIssueCounts() {
    const options = selectIssue.options;
    for (let i = 0; i < options.length; i++) {
      const issueClass = options[i].value;
      const itemCount = countItemsByIssue(issueClass);
      const issueName = options[i].text.split(' (')[0]; // Remove previous count if present
      options[i].text = `${issueName} (${itemCount})`;
    }
  }

  // Function to handle updates
  function handleUpdate() {
    updateLanguageCounts();
    updateIssueCounts();
  }

  // Attach event listeners to the select elements, the search bar, and the checkboxes
  selectLang.addEventListener('change', handleUpdate);
  selectIssue.addEventListener('change', handleUpdate);
  if (searchBar) {
    searchBar.addEventListener('input', handleUpdate); // Update counts when the search bar input changes
  }
  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', handleUpdate); // Update counts when any checkbox changes
  });

  // Initial update
  handleUpdate();
});




document.addEventListener("DOMContentLoaded", function() {
      var selectLangForm = document.getElementById("selectLangForm");
      var languageSpinnerWrapper = document.getElementById("languageSpinnerWrapper");

      var loadingPlaceholder = document.getElementById('loading-placeholder');
  var totalResultsInfo = document.getElementById('total-results-info');

  // Add textLoader class to the placeholder paragraph
  loadingPlaceholder.classList.add('textLoader');

  // Function to hide the placeholder and show the actual content
  function showContent() {
    loadingPlaceholder.style.display = 'none';
    totalResultsInfo.style.display = 'block';

    // Remove textLoader class from the placeholder paragraph
    loadingPlaceholder.classList.remove('textLoader');
  }

  // Wait for the entire window to load, which includes images, iframes, etc.
  window.onload = function() {
    showContent();
  };


      // Function to extract language code from the URL path
       // Function to extract language code from the URL path
  function getLanguageFromPath() {
    var path = window.location.pathname;
    var pathParts = path.split('/');
    if (pathParts.length > 1 && pathParts[1].length === 2) { // Assuming language code is 2 characters long
      return pathParts[1];
    }
    return null;
  }

  // Set the select value based on the URL path
  var selectedLanguage = getLanguageFromPath();
  if (selectedLanguage) {
    selectLangForm.value = selectedLanguage;
  }

  selectLangForm.addEventListener("change", function() {
    var selectedLanguage = this.value;

    // Show the spinner
    languageSpinnerWrapper.style.display = 'block';

    // Change the URL based on the selected language
    if (selectedLanguage !== "en") {
      var newPath = '/' + selectedLanguage + '/search-test';
      window.location.href = newPath;
    } else {
      var homeUrl = window.location.origin; // Get the home URL
      var newPath = homeUrl + '/search-test';
      window.location.href = newPath;
    }
  });
    });

//     const resetButton = document.getElementById('resetFilters');

// resetButton.addEventListener('click', function () {
//     // Reset all checkboxes
//     const checkboxes = document.querySelectorAll('.vf-form__checkbox');
//     checkboxes.forEach(function (checkbox) {
//         checkbox.checked = false;
//     });

//     // Reset select field
//     const selectField = document.querySelector('.issueLive');
//     selectField.value = '';

//     // Trigger jPList reset and refresh
//     jplist.resetControls();
//     jplist.refresh();

//     // Call additional functions
//     updatePaginationLinksOnDemand();
//     sortEvents();
//     showPageOnDemand(currentPageOnDemand);
// });

// // Initialize jPList
// jplist.init({

// });
</script>
<?php  include(locate_template('partials/search/pagination.php', false, false)); ?>
