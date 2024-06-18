<?php
$art_editor_tags = get_field('art_editor_tags');
$art_issue = get_field('art_issue');
$art_ages = get_field('art_ages');
$art_article_type = get_field('art_article_type');
$art_topics = get_field('art_topics');
$art_pdf = get_field('art_pdf');
$art_teaser = get_field('art_teaser_text', false, false);
$title = esc_html(get_the_title());
$title_pdf = strtolower($title);
$title_pdf = str_replace(' ', '-', $title_pdf);
$excerpt = get_the_excerpt();

ob_start(); // Start output buffering
sis_printSingleTag($art_issue);
$tag = ob_get_clean(); // Get the buffered output and clean the buffer
$lowercase_tag = strtolower($tag);
$formatted_tag = str_replace(' ', '-', $lowercase_tag);
?>
<article class="sisArticle sis-search-summary vf-summary vf-summary--news | vf-flag vf-flag--top vf-flag--400" data-jplist-item>
    <div class="vf-flag__media">
        <?php
                $articleTypesArray = sis_getArticleTypesArray();
                if(intval($art_article_type) == $articleTypesArray['UNDERSTAND']){
                    ?>
                    <a href="/?sis-article-types=understand" class="vf-badge sis-badge--understand type type-understand">Understand</a>
                    <?php
                } else if(intval($art_article_type) ==  $articleTypesArray['INSPIRE']){
                    ?>
                    <a href="/?sis-article-types=inspire" class="vf-badge sis-badge--inspire type type-inspire">Inspire</a>
                    <?php
                } else if(intval($art_article_type) ==  $articleTypesArray['TEACH']){
                    ?>
                    <a href="/?sis-article-types=teach" class="vf-badge sis-badge--teach type type-teach">Teach</a>
                    <?php
                } else if(intval($art_article_type) ==  $articleTypesArray['EDITORIAL']) {
                    ?>
                    <a href="/?sis-article-types=editorial" class="vf-badge sis-badge--editorial type type-editorial">Editorial</a>
                    <?php
                }
        ?>
        <?php the_post_thumbnail(array(238, 150), array('class' => 'sis-search-summary__image')); ?>
    </div>
    <div class="vf-flag__body">
        <span class="vf-summary__date"><time title="<?php the_time('c'); ?>"
        data-eventtime="<?php the_time('Ymd'); ?>"><?php the_time(get_option('date_format')); ?></time> | <span class="issue <?php echo $formatted_tag;; ?>"><?php sis_printSingleTag($art_issue); ?></span> <?php 
        // if(!empty($art_pdf)){ ?> 
    <!-- | <a class="vf-link" href="<?php // echo $art_pdf['url']; ?>">Download PDF</a>             -->
        <?php // } ?>
</span>
        <h3 class="vf-summary__title | search-data">
            <a href="<?php the_permalink(); ?>" class="vf-summary__link">
                <?php the_title(); ?>
            </a>
        </h3>
        <p class="vf-summary__text | search-data">
        <?php 
            if ($art_teaser) { ?>
            <?php echo strip_tags($art_teaser); ?>
            <?php }
            else  { ?>
            <?php echo esc_html($excerpt);?>
            <?php }  ?>        
        </p>
        <p class="vf-summary__meta">
        <?php 
if (!empty($art_ages)) { ?>
    <span class="vf-u-text-color--ui--black">Ages: 
        <?php 
        if ($art_ages) {
            $ages_list = array(); 
            foreach ($art_ages as $term_id) {
                // Get the term object using the term ID
                $term = get_term($term_id);
                if ($term && !is_wp_error($term)) {
                    $ages_list[] = '<span style="color: #373a36;" class="age age-' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</span>';
                } else {
                    // Debugging output to help understand what is causing the issue
                    error_log('Failed to get term for ID: ' . print_r($term_id, true));
                }
            }
            echo implode(', ', $ages_list); 
        }
        ?>
    </span><br/>
<?php } ?>

<?php 
if (!empty($art_topics)) { ?>
    <span class="vf-u-text-color--ui--black">Topics: 
        <?php 
        if ($art_topics) {
            $topics_list = array(); 
            foreach ($art_topics as $term_id) {
                // Get the term object using the term ID
                $term = get_term($term_id);
                if ($term && !is_wp_error($term)) {
                    $topics_list[] = '<span style="color: #373a36;" class="topic topic-' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</span>';
                } else {
                    // Debugging output to help understand what is causing the issue
                    error_log('Failed to get term for ID: ' . print_r($term_id, true));
                }
            }
            echo implode(', ', $topics_list); 
        }
        ?>
    </span><br/>
<?php } ?>


            <?php sis_articleLanguageSwitcherInLoop(); ?>
        </p>

    </div>
</article>
