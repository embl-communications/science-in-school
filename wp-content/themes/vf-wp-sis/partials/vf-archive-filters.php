<!-- filters -->
<fieldset class="vf-form__fieldset vf-stack vf-stack--400">
    <legend class="vf-form__legend">Type</legend>
    <?php
        $articleTypeGetParam = get_query_var('sis-article-types');

        $articleTypesArray = sis_getArticleTypesArray();
    ?>

    <div class="vf-form__item vf-form__item--checkbox">
        <input type="checkbox" name="filter-article-types" value="teach"
               <?php if($articleTypeGetParam == 'teach'){ echo ' checked="checked"  '; } ?>
               id="id-<?php echo $articleTypesArray['TEACH'];?>" class="vf-form__checkbox">
        <label for="id-<?php echo $articleTypesArray['TEACH'];?>" class="vf-form__label">Teach</label>
    </div>
    <div class="vf-form__item vf-form__item--checkbox">
        <input type="checkbox" name="filter-article-types" value="understand"
                <?php if($articleTypeGetParam == 'understand'){ echo ' checked="checked"  '; } ?>
               id="id-<?php echo $articleTypesArray['UNDERSTAND'];?>" class="vf-form__checkbox">
        <label for="id-<?php echo $articleTypesArray['UNDERSTAND'];?>" class="vf-form__label">Understand</label>
    </div>
    <div class="vf-form__item vf-form__item--checkbox">
        <input type="checkbox" name="filter-article-types" value="inspire"
                <?php if($articleTypeGetParam == 'inspire'){ echo ' checked="checked"  '; } ?>
               id="id-<?php echo $articleTypesArray['INSPIRE'];?>" class="vf-form__checkbox">
        <label for="id-<?php echo $articleTypesArray['INSPIRE'];?>" class="vf-form__label">Inspire</label>
    </div>
</fieldset>

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
    $categoryTerms = get_terms('sis-categories', array('hide-empty' => true));
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
    <label class="vf-form__label" for="vf-form__select">Issue</label>
    <select class="vf-form__select" name="filter-issues" id="vf-form__select">
        <option value="any" selected>Any</option>
        <?php
        $issuesGetParamArrayIds = sis_getTermIdsFromGetParam('sis-issues');
        $issueTerms = get_terms('sis-issues', array('hide-empty' => true));
        foreach($issueTerms as $singleIssueTerm){
        ?>
            <option
                <?php if(in_array($singleIssueTerm->term_id, $issuesGetParamArrayIds)){ echo ' selected="selected"'; } ?>
                    value="<?php echo $singleIssueTerm->slug; ?>"><?php echo $singleIssueTerm->name; ?></option>
        <?php
        }
        ?>
    </select>
</div>

<div class="vf-form__item vf-stack">
    <label class="vf-form__label" for="vf-form__select">Language</label>
    <select class="vf-form__select" id="vf-form__select">
        <option value="any" selected>Any</option>
        <?php
        $languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0&orderby=code' );
        foreach($languages as $singleLanguage){
        ?>
            <option value="<?php echo $singleLanguage['language_code']; ?>"><?php echo $singleLanguage['native_name']; ?></option>

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
</fieldset>

<?php
    $refreshLink = '/';

?>
<a href="<?php echo $refreshLink; ?>" class="vf-button vf-button--primary">Refresh</a>
