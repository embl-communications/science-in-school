

-- Merge editor tags and reviewer tags
UPDATE `wp_term_taxonomy` SET  `taxonomy`='sis-editor-tags' WHERE `taxonomy`= 'sis-reviewer-tags';

-- Merge into article type inspire
UPDATE `wp_postmeta` SET `meta_value` = '2559' WHERE `meta_value` = '2541' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2559' WHERE `meta_value` = '2542' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2559' WHERE `meta_value` = '2545' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2559' WHERE `meta_value` = '2548' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2559' WHERE `meta_value` = '2549' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2559' WHERE `meta_value` = '2552' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2559' WHERE `meta_value` = '2554' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2559' WHERE `meta_value` = '2556' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2559' WHERE `meta_value` = '2561' AND `meta_key` = 'art_article_type';

-- Merge into article type teach
UPDATE `wp_postmeta` SET `meta_value` = '2560' WHERE `meta_value` = '2551' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2560' WHERE `meta_value` = '2555' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2560' WHERE `meta_value` = '2557' AND `meta_key` = 'art_article_type';

-- Merge into article type understand
UPDATE `wp_postmeta` SET `meta_value` = '2558' WHERE `meta_value` = '2543' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2558' WHERE `meta_value` = '2546' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2558' WHERE `meta_value` = '2547' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2558' WHERE `meta_value` = '2550' AND `meta_key` = 'art_article_type';
UPDATE `wp_postmeta` SET `meta_value` = '2558' WHERE `meta_value` = '2553' AND `meta_key` = 'art_article_type';

