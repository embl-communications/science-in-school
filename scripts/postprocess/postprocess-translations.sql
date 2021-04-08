-- Postprocessing for translations for articles and issues
DELETE FROM `wp_icl_translations` WHERE `element_type` = 'post_sis-article';
DELETE FROM `wp_icl_translations` WHERE `element_type` = 'post_sis-issue';

UPDATE `wp_icl_translations` SET `element_type` = 'post_sis-article' WHERE `element_type` = 'post_post';
UPDATE `wp_icl_translations` SET `element_type` = 'post_sis-issue' WHERE `element_type` = 'post_issue';

