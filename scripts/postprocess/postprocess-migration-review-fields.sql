

-- Rename post types: "post" to "sis-article", "issue" to "sis-issue"
UPDATE `wp_posts` SET `post_type`='sis-article' WHERE `post_type`='post';
UPDATE `wp_posts` SET `post_type`='sis-issue' WHERE `post_type`='issue';


--  Insert Custom Fields for "migrated from drupal" and for "reviewed after migration"
REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'iss_migrated_from_drupal', 1  FROM `wp_posts` WHERE `post_type` IN ('sis-issue', 'sis-article');

REPLACE INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`)
SELECT ID, 'iss_reviewed_after_migration_from_drupal', 0  FROM `wp_posts` WHERE `post_type` IN ('sis-issue', 'sis-article');


-- Rename field names for SIS issues
UPDATE `wp_postmeta` SET `meta_key`='iss_cover_image'
WHERE `meta_key`='wpcf-cover_image' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-issue');

UPDATE `wp_postmeta` SET `meta_key`='iss_pdf_file'
WHERE `meta_key`='wpcf-pdf_file' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-issue');

UPDATE `wp_postmeta` SET `meta_key`='iss_show_banner'
WHERE `meta_key`='wpcf-show_banner' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-issue');

UPDATE `wp_postmeta` SET `meta_key`='iss_web_only'
WHERE `meta_key`='wpcf-web_only' AND `post_id` IN (SELECT `ID`FROM `wp_posts` WHERE `post_type` = 'sis-issue');


