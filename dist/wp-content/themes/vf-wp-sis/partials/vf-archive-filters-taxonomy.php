<!-- filters -->

<?php
$refreshLink = '?post_type=sis-article';

// Test if the query exists at the URL
if ( get_query_var('s') ) {
    $refreshLink .= '&s=' . get_query_var('s');
}

if ( get_query_var('sis-article-types') ) {
    $refreshLink .= '&sis-article-types=' . get_query_var('sis-article-types');
    print '<input id="type" type="hidden" name="sis-article-types" value="' . get_query_var('sis-article-types') . '">';
}

// Test if the query exists at the URL
if ( get_query_var('sis-ages') ) {
    $refreshLink .= '&sis-ages=' . get_query_var('sis-ages');
    print '<input type="hidden" name="sis-ages" value="' . get_query_var('sis-ages') . '">';
}

// Test if the query exists at the URL
if ( get_query_var('sis-categories') ) {
    $refreshLink .= '&sis-categories=' . get_query_var('sis-categories');
    print '<input type="hidden" name="sis-categories" value="' . get_query_var('sis-categories') . '">';
}

// Test if the query exists at the URL
if ( get_query_var('sis-issues') ) {
    $refreshLink .= '&sis-issues=' . get_query_var('sis-issues');
    print '<input type="hidden" name="sis-issues" value="' . get_query_var('sis-issues') . '">';
}

$currentUrl = home_url( $wp->request );
$matches = array();
preg_match('/\/(uk|tr|sv|sr|sq|sl|sk|ru|ro|pt-pt|pl|no|nl|mt|mk|lv|lt|it|hu|hr|gl|fr|fi|et|es|en|el|de|da|cs|ca|bg)\//', $currentUrl, $matches);
if($matches && is_array($matches) && count($matches) >= 1){
    $refreshLink = $matches[0] . $refreshLink;
} else {
    $refreshLink = '/' . $refreshLink;
}
?>
<a id="sis-id-refresh-link" href="<?php echo $refreshLink; ?>" class="vf-button vf-button--primary">Filter</a>

<?php
if(!empty(get_query_var('s'))){
?>
    <fieldset class="vf-form__fieldset vf-stack vf-stack--400">
        <legend class="vf-form__legend">Type</legend>
        <?php
        $articleTypeGetParam = '';
        // Test if the query exists at the URL
        if ( get_query_var('sis-article-types') ) {
            $articleTypeGetParam = get_query_var('sis-article-types');
        }
        $articleTypesArray = sis_getArticleTypesArray();
        ?>

        <div class="vf-form__item vf-form__item--checkbox">
            <input type="checkbox" name="filter-article-types" value="teach"
                <?php if(strpos($articleTypeGetParam,'teach') !== false ){ echo ' checked="checked"  '; } ?>
                   id="id-<?php echo $articleTypesArray['TEACH'];?>" class="vf-form__checkbox">
            <label for="id-<?php echo $articleTypesArray['TEACH'];?>" class="vf-form__label">Teach</label>
        </div>
        <div class="vf-form__item vf-form__item--checkbox">
            <input type="checkbox" name="filter-article-types" value="understand"
                <?php if(strpos($articleTypeGetParam,'understand') !== false ){ echo ' checked="checked"  '; } ?>
                   id="id-<?php echo $articleTypesArray['UNDERSTAND'];?>" class="vf-form__checkbox">
            <label for="id-<?php echo $articleTypesArray['UNDERSTAND'];?>" class="vf-form__label">Understand</label>
        </div>
        <div class="vf-form__item vf-form__item--checkbox">
            <input type="checkbox" name="filter-article-types" value="inspire"
                <?php if(strpos($articleTypeGetParam,'inspire') !== false ){ echo ' checked="checked"  '; } ?>
                   id="id-<?php echo $articleTypesArray['INSPIRE'];?>" class="vf-form__checkbox">
            <label for="id-<?php echo $articleTypesArray['INSPIRE'];?>" class="vf-form__label">Inspire</label>
        </div>
    </fieldset>
<?php
}
?>

<fieldset class="vf-form__fieldset vf-stack vf-stack--400">
    <legend class="vf-form__legend">Age group</legend>
    <?php
        $sisAgesGetParamArrayIds = sis_getTermIdsFromGetParam('sis-ages');
        $ageTerms = get_terms('sis-ages', array('hide-empty' => true));
        foreach($ageTerms as $singleAgeTerm){
            ?>
            <div class="vf-form__item vf-form__item--checkbox">
                <input type="checkbox" name="filter-ages" value="<?php echo $singleAgeTerm->slug; ?>"
                       <?php if(in_array($singleAgeTerm->term_id, $sisAgesGetParamArrayIds)){ echo ' checked="checked"'; } ?>
                       id="id-<?php echo $singleAgeTerm->term_id; ?>" class="vf-form__checkbox">
                <label for="id-<?php echo $singleAgeTerm->term_id; ?>"
                       class="vf-form__label"><?php echo $singleAgeTerm->name; ?></label>
            </div>
        <?php
        }
    ?>
</fieldset>


<fieldset class="vf-form__fieldset vf-stack vf-stack--400">
    <legend class="vf-form__legend">Topic</legend>
    <?php
    $categoriesGetParamArrayIds = sis_getTermIdsFromGetParam('sis-categories');
    $categoryTerms = get_terms('sis-categories', array('hide-empty' => true, 'exclude' => array(14, 22, 2)));
    foreach($categoryTerms as $singleCategoryTerm){
    ?>
        <div class="vf-form__item vf-form__item--checkbox">
            <input type="checkbox" name="filter-categories" value="<?php echo $singleCategoryTerm->slug; ?>"
                    <?php if(in_array($singleCategoryTerm->term_id, $categoriesGetParamArrayIds)){ echo ' checked="checked"'; } ?>
                   id="id-<?php echo $singleCategoryTerm->term_id; ?>" class="vf-form__checkbox">
            <label for="id-<?php echo $singleCategoryTerm->term_id; ?>"
                   class="vf-form__label"><?php echo $singleCategoryTerm->name; ?></label>
        </div>
        <?php
    }
    ?>
</fieldset>

<div class="vf-form__item vf-stack">
    <label class="vf-form__label" for="vf-form__select_issue">Issue</label>
    <select class="vf-form__select" name="filter-issues" id="vf-form__select_issue">
        <option value="any">Any</option>
        <?php
        $issuesGetParamArrayIds = sis_getTermIdsFromGetParam('sis-issues');
        $issueParentTerms = get_terms('sis-issues', array('hide-empty' => true, 'parent'   => 0));
        foreach($issueParentTerms as $singleIssueTerm){
        $terms = get_terms('sis-issues', array('hide-empty' => true, 'parent'   => $singleIssueTerm->term_id));
        sort($terms);
        foreach ( $terms as $term ) {
        ?>
            <option
                <?php if(in_array($term->term_id, $issuesGetParamArrayIds)){ echo ' selected="selected"'; } ?>
                    value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
        <?php
            } 
        }
        ?>
    </select>
</div>

<?php
global $wp;
$currentUrl = home_url( $wp->request );
?>
<div class="vf-form__item vf-stack">
    <label class="vf-form__label" for="vf-form__select_language">Language</label>
    <select class="vf-form__select" id="vf-form__select_language">
        <option value="any">Any</option>
        <?php
        $languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0&orderby=code' );
        sort($languages);
        foreach($languages as $singleLanguage){
        ?>
            <option
                <?php if(strpos($currentUrl, '/' . $singleLanguage['language_code'] . '/') > 0){ echo ' selected="selected"'; } ?>
                    value="<?php echo $singleLanguage['language_code']; ?>"><?php echo $singleLanguage['native_name']; ?></option>

        <?php
        }
        ?>
    </select>
</div>


<?php
    $sortOrderGetParam = get_query_var('sort-order');
    $sortOrder = 'DESC';
    if($sortOrderGetParam && $sortOrderGetParam == 'ASC'){
        $sortOrder = 'ASC';
        //add_filter('sis_archive_page_query', 'sis_archive_page_query_mod');
    }
?>
<!--
<fieldset class="vf-form__fieldset | vf-stack vf-stack--400">
    <legend class="vf-form__legend">Sort</legend>
    <div class="vf-form__item vf-form__item--radio">
        <input
                <?php if($sortOrder == 'DESC'){ echo ' checked="checked"'; } ?>
                type="radio" name="filter-sort-order" value="DESC" id="filter-sort-order-1" class="vf-form__radio">
        <label for="filter-sort-order-1" class="vf-form__label">Date, newest first</label>
    </div>
    <div class="vf-form__item vf-form__item--radio">
        <input
                <?php if($sortOrder == 'ASC'){ echo ' checked="checked"'; } ?>
                type="radio" name="filter-sort-order" value="ASC" id="filter-sort-order-2" class="vf-form__radio">
        <label for="filter-sort-order-2" class="vf-form__label">Date, oldest first</label>
    </div>
    <div class="vf-form__item vf-form__item--radio">
        <input
                type="radio" name="filter-sort-order" value="ASC" id="filter-sort-order-2" class="vf-form__radio">
        <label for="filter-sort-order-2" class="vf-form__label">Relevance</label>
    </div>
</fieldset>
-->

<a id="sis-id-refresh-link-bottom" href="<?php echo $refreshLink; ?>" class="vf-button vf-button--primary">Filter</a>


<script>
    window.addEventListener('load', function() {
        var funcClick = function () {
            var typeTerm = $('#type').val();

            var newUrl = '/?post_type=sis-article&sis-article-types=' + typeTerm;

            // searched subject
            var searchTerm = $('#searchitem').val();
            if(searchTerm){
                newUrl += '&s=' + searchTerm;
            }

            // article types
            var typesArray = [];
            $.each($("input[name='filter-article-types']:checked"), function(){
                typesArray.push($(this).val());
            });
            if(typesArray && typesArray.length > 0){
                newUrl += '&sis-article-types=' + typesArray.join();
                $("#id-sis-article-types").attr('value', typesArray.join());
            } else {
                $("#id-sis-article-types").attr('value', '');
            }

            // ages
            var agesArray = [];
            $.each($("input[name='filter-ages']:checked"), function(){
                agesArray.push($(this).val());
            });
            if(agesArray && agesArray.length > 0){
                newUrl += '&sis-ages=' + agesArray.join();
                $("#id-sis-ages").attr('value', agesArray.join());
            } else {
                $("#id-sis-ages").attr('value', '');
            }

            // categories
            var categoriesArray = [];
            $.each($("input[name='filter-categories']:checked"), function(){
                categoriesArray.push($(this).val());
            });
            if(categoriesArray && categoriesArray.length > 0){
                newUrl += '&sis-categories=' + categoriesArray.join();
                $("#id-sis-categories").attr('value', categoriesArray.join());
            } else {
                $("#id-sis-categories").attr('value', '');
            }

            // selected issue
            var selectedIssue = $('#vf-form__select_issue').children("option:selected").val();
            if(selectedIssue && selectedIssue != 'any'){
                newUrl += '&sis-issues=' + selectedIssue;
                $("#id-sis-issues").attr('value', selectedIssue);
            } else {
                $("#id-sis-issues").attr('value', '');
            }

            // selected language
            var selectedLanguage = $('#vf-form__select_language').children("option:selected").val();
            if(selectedLanguage && selectedLanguage != 'any' && selectedLanguage != 'en'){
                newUrl = '/' + selectedLanguage + newUrl;
                $('#sis-id-search-form').attr('action', '/' + selectedLanguage + '/');
            } else {
                $('#sis-id-search-form').attr('action', '/');
            }

            // set new url
            $('#sis-id-refresh-link').attr('href', newUrl);
            $('#sis-id-refresh-link-bottom').attr('href', newUrl);


        };
        jQuery('input').click(funcClick);
        jQuery('select').change(funcClick);
    });
</script>
