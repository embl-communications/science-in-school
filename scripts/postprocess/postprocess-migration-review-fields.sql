-- Postprocessing for custom fields

-- Rename post types: "post" to "sis-article", "issue" to "sis-issue"
UPDATE `wp_posts` SET `post_type`='sis-article' WHERE `post_type`='post';
UPDATE `wp_posts` SET `post_type`='sis-issue' WHERE `post_type`='issue';


--  Insert Custom Fields for "migrated from drupal" and for "reviewed after migration"
REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'iss_migrated_from_drupal', 1  FROM `wp_posts` WHERE `post_type` IN ('sis-issue');
REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'art_migrated_from_drupal', 1  FROM `wp_posts` WHERE `post_type` IN ('sis-article');

REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'iss_reviewed_after_migration_from_drupal', 0  FROM `wp_posts` WHERE `post_type` IN ('sis-issue');
REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'art_reviewed_after_migration_from_drupal', 0  FROM `wp_posts` WHERE `post_type` IN ('sis-article');

-- Insert custom fields for taxonomies for sis-issues:
REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'iss_issue', 0  FROM `wp_posts` WHERE `post_type` IN ('sis-issue');


-- Insert custom fields for taxonomies for sis-articles:
REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'art_editor_tags', 0  FROM `wp_posts` WHERE `post_type` IN ('sis-article');

REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'art_reviewer_tags', 0  FROM `wp_posts` WHERE `post_type` IN ('sis-article');

REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'art_ages', 0  FROM `wp_posts` WHERE `post_type` IN ('sis-article');

REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'art_institutions', 0  FROM `wp_posts` WHERE `post_type` IN ('sis-article');

REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'art_issue', 0  FROM `wp_posts` WHERE `post_type` IN ('sis-article');

REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'art_article_type', 0  FROM `wp_posts` WHERE `post_type` IN ('sis-article');

REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'art_topics', 0  FROM `wp_posts` WHERE `post_type` IN ('sis-article');

REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'art_series', 0  FROM `wp_posts` WHERE `post_type` IN ('sis-article');

REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'art_license', 0  FROM `wp_posts` WHERE `post_type` IN ('sis-article');



-- Rename field names for SIS issues
-- DONE -- iss_web_only: true/false
-- DONE -- iss_cover_image: image
-- DONE -- iss_issue: one taxonomy, must be added
-- DONE -- iss_pdf: file
-- DONE MANUALLY -- iss_articles: Relationship, do be done manually
-- DONE MANUALLY -- iss_previous_issue: Relationship, do be done manually
-- DONE MANUALLY -- iss_next_issue: Relationship, do be done manually
-- DONE -- iss_show_banner: true/false
-- DONE -- iss_migrated_from_drupal: true/false, new field
-- DONE -- iss_reviewed_after_migration_from_drupal: true/false, new field

-- wpcf-web_only
-- iss_web_only
UPDATE `wp_postmeta` SET `meta_key`='iss_web_only'
WHERE `meta_key`='wpcf-web_only' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-issue');

-- wpcf-cover_image
-- iss_cover_image
UPDATE `wp_postmeta` SET `meta_key`='iss_cover_image'
WHERE `meta_key`='wpcf-cover_image' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-issue');

-- wpcf-pdf_file
-- iss_pdf_file
UPDATE `wp_postmeta` SET `meta_key`='iss_pdf'
WHERE `meta_key`='wpcf-pdf_file' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-issue');

-- wpcf-show_banner
-- iss_show_banner
UPDATE `wp_postmeta` SET `meta_key`='iss_show_banner'
WHERE `meta_key`='wpcf-show_banner' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-issue');



-- Rename field names for SIS articles
-- DONE -- art_author_name: text
-- DONE -- art_editor_tags: multiple taxonomy
-- DONE -- art_slider_exclude: true/false
-- DONE -- art_eonly_article: true/false
-- DONE -- art_reviewer_tags: multiple taxonomy
-- DONE -- art_ages: multiple taxonomy
-- DONE -- art_institutions: multiple taxonomy
-- DONE -- art_issue: one taxonomy
-- DONE -- art_article_type: one taxonomy
-- DONE -- art_topics: multiple taxonomy
-- DONE -- art_series: multiple taxonomy
-- DONE -- art_license: one taxonomy
-- DONE -- art_license_freetext: text
-- DONE -- art_references: wysiwyg
-- DONE -- art_web_references: wysiwyg
-- DONE -- art_resources: wysiwyg
-- DONE -- art_authors: wysiwyg
-- DONE -- art_referee: wysiwyg
-- DONE -- art_review: wysiwyg
-- DONE -- art_slider_image: image
-- DONE -- art_teaser_image: image
-- DONE -- art_pdf: file
-- DONE -- art_materials: multiple files, handle with different script and REPEATER field in WP Core
-- DONE -- iss_migrated_from_drupal: true/false, new field
-- DONE -- iss_reviewed_after_migration_from_drupal: true/false, new field


-- wpcf-author_name
-- art_author_name
UPDATE `wp_postmeta` SET `meta_key`='art_author_name'
WHERE `meta_key`='wpcf-author_name' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-article');

-- wpcf-slider_exclude
-- art_slider_exclude
UPDATE `wp_postmeta` SET `meta_key`='art_slider_exclude'
WHERE `meta_key`='wpcf-slider_exclude' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-article');

-- wpcf-e_only_article
-- art_eonly_article
UPDATE `wp_postmeta` SET `meta_key`='art_eonly_article'
WHERE `meta_key`='wpcf-e_only_article' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-article');

-- wpcf-license_freetext
-- art_license_freetext
UPDATE `wp_postmeta` SET `meta_key`='art_license_freetext'
WHERE `meta_key`='wpcf-license_freetext' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-article');

-- wpcf-references
-- art_references
UPDATE `wp_postmeta` SET `meta_key`='art_references'
WHERE `meta_key`='wpcf-references' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-article');

-- wpcf-web_references
-- art_web_references
UPDATE `wp_postmeta` SET `meta_key`='art_web_references'
WHERE `meta_key`='wpcf-web_references' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-article');

-- wpcf-resources
-- art_resources
UPDATE `wp_postmeta` SET `meta_key`='art_resources'
WHERE `meta_key`='wpcf-resources' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-article');

-- wpcf-authors
-- art_authors
UPDATE `wp_postmeta` SET `meta_key`='art_authors'
WHERE `meta_key`='wpcf-authors' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-article');

-- wpcf-referee
-- art_referee
UPDATE `wp_postmeta` SET `meta_key`='art_referee'
WHERE `meta_key`='wpcf-referee' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-article');

-- wpcf-review
-- art_review
UPDATE `wp_postmeta` SET `meta_key`='art_review'
WHERE `meta_key`='wpcf-review' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-article');

-- wpcf-slider_image
-- art_slider_image
UPDATE `wp_postmeta` SET `meta_key`='art_slider_image'
WHERE `meta_key`='wpcf-slider_image' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-article');

-- wpcf-image
-- art_teaser_image
UPDATE `wp_postmeta` SET `meta_key`='art_teaser_image'
WHERE `meta_key`='wpcf-image' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-article');

-- wpcf-pdf_file
-- art_pdf
UPDATE `wp_postmeta` SET `meta_key`='art_pdf'
WHERE `meta_key`='wpcf-pdf_file' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-article');














