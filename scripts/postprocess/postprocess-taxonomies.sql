-- Rename all taxonomies
UPDATE `wp_term_taxonomy` SET  `taxonomy`='sis-ages' WHERE `taxonomy`= 'ages';

UPDATE `wp_term_taxonomy` SET  `taxonomy`='sis-editor-tags' WHERE `taxonomy`= 'editor_tags';

UPDATE `wp_term_taxonomy` SET  `taxonomy`='sis-reviewer-tags' WHERE `taxonomy`= 'post_tag';

UPDATE `wp_term_taxonomy` SET  `taxonomy`='sis-institutions' WHERE `taxonomy`= 'institutions';

UPDATE `wp_term_taxonomy` SET  `taxonomy`='sis-series' WHERE `taxonomy`= 'series';

UPDATE `wp_term_taxonomy` SET  `taxonomy`='sis-issues' WHERE `taxonomy`= 'issues';

UPDATE `wp_term_taxonomy` SET  `taxonomy`='sis-license' WHERE `taxonomy`= 'license';

UPDATE `wp_term_taxonomy` SET  `taxonomy`='sis-article-types' WHERE `taxonomy`= 'article_types';

UPDATE `wp_term_taxonomy` SET  `taxonomy`='sis-categories' WHERE `taxonomy`= 'category';




