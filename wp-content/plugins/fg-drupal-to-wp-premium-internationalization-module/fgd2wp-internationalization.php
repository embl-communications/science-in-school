<?php
/**
 * Plugin Name: FG Drupal to WordPress Premium Internationalization module
 * Depends:		FG Drupal to WordPress Premium
 * Depends:		WPML Multilingual CMS
 * Plugin Uri:  https://www.fredericgilles.net/fg-drupal-to-wordpress/
 * Description: A plugin to migrate Drupal translations to WPML (WordPress)
 * 				Needs «FG Drupal to WordPress Premium» and WPML plugins to work
 * Version:     1.3.1
 * Author:      Frédéric GILLES
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

add_action( 'admin_init', 'fgd2wp_internationalization_test_requirements' );

if ( !function_exists( 'fgd2wp_internationalization_test_requirements' ) ) {
	function fgd2wp_internationalization_test_requirements() {
		new fgd2wp_internationalization_requirements();
	}
}

if ( !class_exists('fgd2wp_internationalization_requirements', false) ) {
	class fgd2wp_internationalization_requirements {
		private $parent_plugin = 'fg-drupal-to-wp-premium/fg-drupal-to-wp-premium.php';
		private $required_premium_version = '2.34.0';

		public function __construct() {
			load_plugin_textdomain( 'fgd2wp_internationalization', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
			if ( !is_plugin_active($this->parent_plugin) ) {
				add_action( 'admin_notices', array($this, 'fgd2wp_internationalization_error') );
			} else {
				$plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $this->parent_plugin);
				if ( !$plugin_data or version_compare($plugin_data['Version'], $this->required_premium_version, '<') ) {
					add_action( 'admin_notices', array($this, 'fgd2wp_internationalization_version_error') );
				}
			}
		}
		
		/**
		 * Print an error message if the Premium plugin is not activated
		 */
		function fgd2wp_internationalization_error() {
			echo '<div class="error"><p>[fgd2wp_internationalization] '.__('The Internationalization module needs the «FG Drupal to WordPress Premium» plugin to work. Please install and activate <strong>FG Drupal to WordPress Premium</strong>.', 'fgd2wp_internationalization').'<br /><a href="https://www.fredericgilles.net/fg-drupal-to-wordpress/" target="_blank">https://www.fredericgilles.net/fg-drupal-to-wordpress/</a></p></div>';
		}
		
		/**
		 * Print an error message if the Premium plugin is not at the required version
		 */
		function fgd2wp_internationalization_version_error() {
			printf('<div class="error"><p>[fgd2wp_internationalization] '.__('The Internationalization module needs at least the <strong>version %s</strong> of the «FG Drupal to WordPress Premium» plugin to work. Please install and activate <strong>FG Drupal to WordPress Premium</strong> at least the <strong>version %s</strong>.', 'fgd2wp_internationalization').'<br /><a href="https://www.fredericgilles.net/fg-drupal-to-wordpress/" target="_blank">https://www.fredericgilles.net/fg-drupal-to-wordpress/</a></p></div>', $this->required_premium_version, $this->required_premium_version);
		}
	}
}

if ( !defined('WP_LOAD_IMPORTERS') && !defined('DOING_AJAX') && !defined('DOING_CRON') && !defined('WP_CLI') ) {
	return;
}

add_action( 'plugins_loaded', 'fgd2wp_internationalization_load', 25 );

if ( !function_exists( 'fgd2wp_internationalization_load' ) ) {
	function fgd2wp_internationalization_load() {
		if ( !defined('FGD2WPP_LOADED') ) return;

		load_plugin_textdomain( 'fgd2wp_internationalization', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		
		global $fgd2wpp;
		new fgd2wp_internationalization($fgd2wpp);
	}
}

if ( !class_exists('fgd2wp_internationalization', false) ) {
	class fgd2wp_internationalization {
		
		public $translations_count = 0;
		private $default_language = '';
		
		/**
		 * Sets up the plugin
		 *
		 */
		public function __construct($plugin) {
			
			$this->plugin = $plugin;
			
			if ( !class_exists('SitePress', false) ) {
				$this->plugin->display_admin_error(sprintf(__('Error: <a href="%s" target="_blank">WPML</a> must be installed and activated to import the translations.', __CLASS__), 'https://www.fredericgilles.net/wpml'));
				return;
			}
			
			add_action( 'fgd2wp_post_empty_database', array($this, 'empty_wpml_translations'), 10, 1 );
			add_action( 'fgd2wp_pre_import', array($this, 'deactivate_terms_filter') );
			add_action( 'fgd2wp_pre_import', array($this, 'set_default_language') );
			
			add_filter( 'fgd2wp_get_nodes_add_extra_cols', array($this, 'add_language_in_nodes_query'), 10, 1 );
			add_filter( 'fgd2wp_get_node_terms_ids', array($this, 'get_translated_terms_ids'), 99, 3 );
			add_action( 'fgd2wp_post_insert_post', array($this, 'update_post_language'), 99, 3 );
			add_action( 'fgd2wp_post_import_post', array($this, 'import_post_translations'), 99, 5 );
			
			add_filter( 'fgd2wp_get_data_field_extra_criteria', array($this, 'add_extra_criteria_in_data_field_query'), 10, 2 );
			
			add_action( 'fgd2wp_pre_insert_taxonomy_term', array($this, 'pre_insert_taxonomy_term'), 99, 2 );
			add_action( 'fgd2wp_post_insert_taxonomy_term', array($this, 'update_term_language'), 98, 3 ); // Translate Drupal option
			add_action( 'fgd2wp_post_insert_taxonomy_term', array($this, 'import_term_translations'), 99, 3 );
			add_filter( 'fgd2wp_get_taxonomy_term_id', array($this, 'add_language_in_term_id'), 10, 2 );
			add_filter( 'fgd2wp_get_terms_add_extra_cols', array($this, 'add_language_in_terms_query'), 10, 1 ); // Translate Drupal option
			
			add_action( 'fgd2wp_import_notices', array($this, 'display_translations_count') );
			add_filter( 'fgd2wp_pre_display_admin_page', array($this, 'process_admin_page'), 11, 1 );
		}

		/**
		 * Empty the WPML icl_translations table
		 * 
		 */
		public function empty_wpml_translations($action) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'icl_translations';
			if ( $action == 'all' ) {
				$wpdb->query("TRUNCATE $table_name");
				$this->plugin->display_admin_notice(__('Translations deleted', __CLASS__));
			}
			update_option('fgd2wp_last_wpml_translation_id', 0);
		}
		
		/**
		 * Deactivate the WPML term filters because it prevents the plugin to work
		 *
		 */
		public function deactivate_terms_filter() {
			global $sitepress;
			
			remove_filter('edit_term', array($sitepress, 'create_term'), 1);
			remove_filter('terms_clauses', array($sitepress, 'terms_clauses'), 10); // To get the terms in all languages
			remove_filter('get_term', array($sitepress, 'get_term_adjust_id'), 1); // To get the terms in all languages
		}
		
		/**
		 * Set the WPML default language
		 * 
		 * @since 1.1.0
		 * 
		 * @global type $sitepress
		 */
		public function set_default_language() {
			global $sitepress;
			
			$this->default_language = $sitepress->get_default_language();
		}
		
		/**
		 * Add the language in the term ID
		 * 
		 * @param int $term_id Term ID
		 * @param array $term Drupal term data
		 * @return int Term ID
		 */
		public function add_language_in_term_id($term_id, $term) {
			if ( !empty($term['language']) && ($term['language'] != 'und') ) {
				$term_id .= '-' . $term['language'];
			}
			return $term_id;
		}
		
		/**
		 * Add the language column in the terms query
		 * when the Translate option is selected on Drupal
		 *
		 * @param strings $cols Extra columns
		 * @return array Extra columns
		 */
		public function add_language_in_terms_query($cols) {
			if ( $this->plugin->column_exists('term_data', 'language') ) {
				// Drupal 6
				$cols .= ', t.language, t.trid';
			} elseif ( $this->plugin->column_exists('taxonomy_term_data', 'language') ) {
				// Drupal 7
				$cols .= ', t.language, t.i18n_tsid AS trid';
			} elseif ( $this->plugin->column_exists('taxonomy_term_field_data', 'langcode') ) {
				// Drupal 8
				$cols .= ', t.langcode AS language, t.tid AS trid';
			}
			return $cols;
		}
		
		/**
		 * Add the language column in the nodes query
		 *
		 * @param strings $cols Extra columns
		 * @return array Extra columns
		 */
		public function add_language_in_nodes_query($cols) {
			if ( version_compare($this->plugin->drupal_version, '8', '<') ) {
				$cols .= ', n.language, n.tnid';
			} else {
				// Version 8
				$cols .= ', n.langcode AS language, n.nid AS tnid';
			}
			return $cols;
		}
		
		/**
		 * Set the categories languages in WPML
		 * when the Translate option is selected on Drupal
		 *
		 * @param int $new_term_id WP term ID
		 * @param array $term Drupal term
		 * @param string $wp_taxonomy WP taxonomy
		 */
		public function update_term_language($new_term_id, $term, $wp_taxonomy) {
			if ( isset($term['language']) ) {
				$tsid = isset($term['trid'])? $term['trid']: '';
				$element_type = 'tax_' . $wp_taxonomy;
				$master_id = $this->get_master_id($new_term_id, $element_type, $tsid);
				$this->update_element_language($master_id, $new_term_id, $element_type, $term['language']);
			}
		}
		
		/**
		 * Modify the term slug if this is a translation
		 * 
		 * @since 1.0.3
		 * 
		 * @param array $args WP term data
		 * @param array $term Drupal term
		 * @return array WP term data
		 */
		public function pre_insert_taxonomy_term($args, $term) {
			if ( !empty($term['language']) && ($term['language'] != 'und') && ($term['language'] != $this->default_language) ) {
				$args['slug'] = sanitize_key($term['name']) . '-' . $term['language'];
			}
			return $args;
		}
		
		/**
		 * Import the term translations
		 * 
		 * @param int $new_term_id WP term ID
		 * @param array $term Drupal term
		 * @param string $wp_taxonomy WP taxonomy
		 */
		public function import_term_translations($new_term_id, $term, $wp_taxonomy) {
			$translations = array();
			$term_metakey = '_fgd2wp_old_taxonomy_id';
			$term_id = $term['tid'];
			
			if ( version_compare($this->plugin->drupal_version, '8', '>=') ) {
				$translations = $this->get_drupal8_term_translations($term_id);
			} else {
				$translations = $this->get_term_translations_from_locales($term_id);
			}
			
			foreach ( $translations as $language => $translation ) {
				if ( $language != $term['language'] ) { // Source language
					$translation_name = isset($translation['name'])? $translation['name'] : $term['name'];

					$args = array();
					// Description
					if ( isset($translation['description']) ) {
						$args['description'] = $translation['description'];
					}
					// Parent term
					$parent_id = isset($this->plugin->taxonomy_term_hierarchy[$term_id])? $this->plugin->taxonomy_term_hierarchy[$term_id]: 0;
					if ( ($parent_id != 0) && isset($this->plugin->imported_taxonomies[$parent_id . '-' . $language]) ) {
						$parent_tax_id = $this->plugin->imported_taxonomies[$parent_id . '-' . $language];
						$args['parent'] = $parent_tax_id;
					}
					// Hook before inserting the term
					$args = apply_filters('fgd2wp_pre_insert_taxonomy_term', $args, array('name' => $translation_name, 'language' => $language), $wp_taxonomy);

					$new_term = wp_insert_term($translation_name, $wp_taxonomy, $args);
					if ( !is_wp_error($new_term) ) {
						// Store the Drupal taxonomy term ID
						$this->plugin->imported_taxonomies[$term_id . '-' . $language] = $new_term['term_id'];
						add_term_meta($new_term['term_id'], $term_metakey, $term_id . '-' . $language, true);
						$element_type = 'tax_' . $wp_taxonomy;
						$this->update_element_language($new_term_id, $new_term['term_id'], $element_type, $language);
					}
				}
			}
		}
		
		/**
		 * Get the Drupal 8 term translations
		 * 
		 * @since 1.3.1
		 * 
		 * @param array $term_id Drupal term ID
		 * @return array Translations
		 */
		private function get_drupal8_term_translations($term_id) {
			$translations = array();
			$prefix = $this->plugin->plugin_options['prefix'];
			
			$sql = "
				SELECT t.name, t.description__value AS description, t.langcode AS language, t.tid AS trid
				FROM ${prefix}taxonomy_term_field_data t
				WHERE t.tid = '$term_id'
			";
			$result = $this->plugin->drupal_query($sql);
			foreach ( $result as $row ) {
				$translations[$row['language']] = $row;
			}
			return $translations;
		}
			
		/**
		 * Get the term translations from the Localize option on Drupal
		 * 
		 * @since 1.3.1
		 * 
		 * @param array $term_id Drupal term ID
		 * @return array Translations
		 */
		private function get_term_translations_from_locales($term_id) {
			$translations = array();
			
			// Get the term name translations
			$translation_names = $this->get_term_field_translations_from_locales($term_id, 'name');
			foreach ( $translation_names as $translation_name ) {
				$translations[$translation_name['language']]['name'] = $translation_name['translation'];
			}
			// Get the term description translations
			$translation_descriptions = $this->get_term_field_translations_from_locales($term_id, 'description');
			foreach ( $translation_descriptions as $translation_description ) {
				$translations[$translation_description['language']]['description'] = $translation_description['translation'];
			}
			return $translations;
		}

		/**
		 * Get the term translations from the Localize option on Drupal
		 * 
		 * @param array $term_id Drupal term ID
		 * @param string $field (name | description)
		 * @return array Term translations
		 */
		private function get_term_field_translations_from_locales($term_id, $field) {
			$translations = array();

			$prefix = $this->plugin->plugin_options['prefix'];
			
			if ( $this->plugin->table_exists('locales_target') ) {
				if ( version_compare($this->plugin->drupal_version, '7', '<') ) {
					$context_field = 'location';
				} else {
					$context_field = 'context';
				}

				$sql = "
					SELECT t.translation, t.language
					FROM ${prefix}locales_target t
					INNER JOIN ${prefix}locales_source s ON s.lid = t.lid
					WHERE s.${context_field} = 'term:$term_id:$field'
				";
				$translations = $this->plugin->drupal_query($sql);
			}
			return $translations;
		}
		
		/**
		 * Set the post language in WPML
		 *
		 * @param int $new_post_id WP Post ID
		 * @param array $post Post data
		 * @param string $post_type Post type
		 */
		public function update_post_language($new_post_id, $post, $post_type) {
			if ( isset($post['language']) ) {
				$tnid = isset($post['tnid'])? $post['tnid']: '';
				$element_type = 'post_' . $post_type;
				$master_id = $this->get_master_id($new_post_id, $element_type, $tnid);
				$this->update_element_language($master_id, $new_post_id, $element_type, $post['language']);
			}
		}
		
		/**
		 * Get the translated terms IDs
		 * 
		 * @param array $terms_ids Terms IDs
		 * @param array $node Drupal node
		 * @param array $terms Terms
		 * @return array Terms IDs
		 */
		public function get_translated_terms_ids($terms_ids, $node, $terms) {
			if ( !empty($terms_ids) ) {
				if ( isset($node['language']) && ($node['language'] != 'und') ) {
					$translated_terms_ids = array();
					foreach ( $terms as $term ) {
						$term_id = $term['tid'] . '-' . $node['language'];
						if ( isset($this->plugin->imported_taxonomies[$term_id]) ) {
							$translated_terms_ids[] = (int)$this->plugin->imported_taxonomies[$term_id];
						}
					}
					// Replace the terms ids by the translated terms ids
					if ( !empty($translated_terms_ids) ) {
						$terms_ids = $translated_terms_ids;
					}
				}
			}
			return $terms_ids;
		}
		
		/**
		 * Get the original (master) element ID
		 * 
		 * @since 2.3.0
		 * 
		 * @param int $element_id WP ID
		 * @param string $element_type post_post | post_page | post_nav_menu_item | tax_category | tax_post_tag | tax_nav_menu
		 * @param int $assoc_key Drupal association key
		 * @return int Master ID
		 */
		private function get_master_id($element_id, $element_type, $assoc_key) {
			$master_id = null;
			$meta_key = '_fgd2wp_translation_association_key';
			
			if ( !empty($assoc_key) ) {
				$is_taxonomy = (strpos($element_type, 'tax') === 0);
				
				if ( $is_taxonomy ) {
					// Try to find a term with the same association key
					$master_id = $this->plugin->get_wp_term_id_from_meta($meta_key, $assoc_key);
				} else {
					// Try to find a post with the same association key
					$master_id = $this->plugin->get_wp_post_id_from_meta($meta_key, $assoc_key);
				}
				if ( empty($master_id) ) {
					// Save the association key
					if ( $is_taxonomy ) {
						update_term_meta($element_id, $meta_key, $assoc_key);
					} else {
						update_post_meta($element_id, $meta_key, $assoc_key);
					}
				}
			}
			return $master_id;
		}
		
		/**
		 * Set the element language in WPML
		 *
		 * @since 2.3.0
		 * 
		 * @param int $element_id WP element ID
		 * @param int $translated_element_id Translated element ID
		 * @param string $element_type post_post | post_page | post_nav_menu_item | post_product | tax_category | tax_post_tag | tax_nav_menu | tax_product_cat | tax_brand
		 * @param string $language Language
		 */
		private function update_element_language($element_id, $translated_element_id, $element_type, $language) {
			global $sitepress;
			
			$trid = $sitepress->get_element_trid($element_id, $element_type);
			$this->update_wpml_language($translated_element_id, $element_type, $trid, $language);
		}
		
		/**
		 * Update the language (for posts, pages, categories, tags and navigation menus)
		 *
		 * @param int $element_id WP ID
		 * @param string $element_type post_post | post_page | post_nav_menu_item | post_product | tax_category | tax_post_tag | tax_nav_menu | tax_product_cat | tax_brand
		 * @param int $trid WPML translation ID
		 * @param string $language Language to set
		 */
		private function update_wpml_language($element_id, $element_type, $trid, $language) {
			global $sitepress;
			
			if ( !empty($language) && ($language != 'und') ) {
				$sitepress->set_element_language_details($element_id, $element_type, $trid, $language);
				if ( ($language != $this->default_language) ) {
					$this->translations_count++;
				}
			}
		}
		
		/**
		 * Add extra criteria in the data field query
		 * 
		 * @param string $extra_criteria Extra criteria
		 * @param array $node Node
		 * @return string Extra criteria
		 */
		public function add_extra_criteria_in_data_field_query($extra_criteria, $node) {
			if ( !empty($node['language']) && ($node['language'] != 'und') ) {
				if ( version_compare($this->plugin->drupal_version, '8', '>=') ) {
					// Version 8
					$extra_criteria = preg_replace("/langcode IN\('(.*?)'/", "langcode IN('" . $node['language'] . "'", $extra_criteria);
				} else if ( version_compare($this->plugin->drupal_version, '7', '>=') ) {
					// Version 7
					$extra_criteria = preg_replace("/language IN\('(.*?)'/", "language IN('" . $node['language'] . "'", $extra_criteria);
				}
			}
			return $extra_criteria;
		}
		
		/**
		 * Import the post translations
		 *
		 * @since 1.1.0
		 * 
		 * @param int $new_post_id WP Post ID
		 * @param array $node Post data
		 * @param string $content_type Content type (article, page)
		 * @param string $post_type Post type
		 * @param string $entity_type Entity type (node, media)
		 */
		public function import_post_translations($new_post_id, $node, $content_type, $post_type, $entity_type) {
			$titles = $this->get_title_translations($node['nid']);
			foreach ( $titles as $language => $title ) {
				if ( ($language != 'und') && ($language != $this->default_language) ) {
					// Import the translation
					$node['language'] = $language;
					$node['title'] = $title;
					$translated_post_id = $this->plugin->import_node($node, $content_type, $post_type, $entity_type);
					
					if ( $translated_post_id !== false ) {
						// Associate the translation to its original post
						$element_type = 'post_' . $post_type;
						$this->update_element_language($new_post_id, $translated_post_id, $element_type, $language);
					}
				}
			}
		}
		
		/**
		 * Get the title translations of the node
		 * 
		 * @since 1.1.0
		 * 
		 * @param int $nid Node ID
		 * @return array Titles translations
		 */
		private function get_title_translations($nid) {
			$titles = array();

			$prefix = $this->plugin->plugin_options['prefix'];
			$sql = '';
			
			if ( version_compare($this->plugin->drupal_version, '8', '>=') ) {
				// Drupal 8
				$sql = "
					SELECT t.title, t.langcode AS language
					FROM ${prefix}node_field_data t
					WHERE t.nid = '$nid'
				";
			} elseif ( $this->plugin->table_exists('field_data_title_field') ) {
				$sql = "
					SELECT t.title_field_value AS title, t.language
					FROM ${prefix}field_data_title_field t
					WHERE t.entity_id = '$nid'
				";
			}
			if ( !empty($sql) ) {
				$result = $this->plugin->drupal_query($sql);
				foreach ( $result as $row ) {
					$titles[$row['language']] = $row['title'];
				}
			}
			return $titles;
		}
		
		/**
		 * Display the number of imported translations
		 * 
		 */
		public function display_translations_count() {
			$this->plugin->display_admin_notice(sprintf(_n('%d multilanguage data imported to WPML', '%d multilanguage data imported to WPML', $this->translations_count, __CLASS__), $this->translations_count));
		}
		
		/**
		 * Add information to the admin page
		 * 
		 * @param array $data
		 * @return array
		 */
		public function process_admin_page($data) {
			$data['title'] .= ' ' . __('+ Internationalization module', __CLASS__);
			$data['description'] .= "<br />" . __('The Internationalization module will also import the multilanguage data to WPML.', __CLASS__);
			
			return $data;
		}
		
	}
}
