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

<?php include(locate_template('partials/vf-archive-filters.php', false, false)); ?>

