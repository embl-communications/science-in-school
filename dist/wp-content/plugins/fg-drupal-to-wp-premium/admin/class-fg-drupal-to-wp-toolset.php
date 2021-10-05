<?php

/**
 * Toolset methods
 *
 * @link       https://www.fredericgilles.net/fg-drupal-to-wp/
 * @since      1.62.0
 *
 * @package    FG_Drupal_to_WordPress_Premium
 * @subpackage FG_Drupal_to_WordPress_Premium/admin
 */

if ( !class_exists('FG_Drupal_to_WordPress_Toolset', false) ) {

	/**
	 * Toolset class
	 *
	 * @package    FG_Drupal_to_WordPress_Premium
	 * @subpackage FG_Drupal_to_WordPress_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Drupal_to_WordPress_Toolset {
		
		private $plugin;
		public $wpcf_version = ''; // Toolset version
		private static $toolset_relationships = array(); // Toolset relationships
		
		/**
		 * Constructor
		 * 
		 * @since 1.62.0
		 */
		public function __construct($plugin) {
			$this->plugin = $plugin;
			$this->wpcf_version = get_option('wpcf-version');
		}
		
		/**
		 * Delete the Toolset data
		 * 
		 * @since 1.61.0
		 * 
		 * @global object $wpdb
		 */
		public function delete_toolset_data() {
			global $wpdb;
			
			$toolset_tables = array('toolset_associations', 'toolset_connected_elements', 'toolset_maps_address_cache', 'toolset_post_guid_id', 'toolset_relationships', 'toolset_type_sets');
			
			$wpdb->show_errors();
			$sql_queries = array();
			$sql_queries[] = "SET FOREIGN_KEY_CHECKS=0;";

			foreach ( $toolset_tables as $table ) {
				if ( !is_null($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}$table'")) ) { // If the table exists
					$sql_queries[] = "TRUNCATE {$wpdb->prefix}$table";
				}
			}
			$sql_queries[] = "SET FOREIGN_KEY_CHECKS=1;";

			// Execute SQL queries
			if ( count($sql_queries) > 2 ) {
				foreach ( $sql_queries as $sql ) {
					$wpdb->query($sql);
				}
			}
			$wpdb->hide_errors();
		}
		
		/**
		 * Create a field object using the WPCF structure
		 * 
		 * @since 1.47.0
		 * 
		 * @param string $field_slug Field slug
		 * @param array $field Field data
		 * @param string $meta_type Meta type (postmeta | termmeta | usermeta)
		 * @return array WPCF field
		 */
		public function create_wpcf_field($field_slug, $field, $meta_type) {
			$name = $field['label'];
			$module = isset($field['module'])? $field['module'] : '';
			// Map the custom field type
			$type = $this->plugin->map_custom_field_type($field['type'], $name, $module);
			$default_value = isset($field['default_value'][0]['value'])? $field['default_value'][0]['value']: '';
			$default_value = (string)$default_value;

			// Create the field
			$wpcf_field = array(
				$field_slug => array(
					'id' => $field_slug,
					'slug' => $field_slug,
					'type' => $type,
					'name' => $name,
					'description' => isset($field['description'])? $field['description'] : '',
					'data' => array(
						'slug-pre-save' => $field_slug,
 						'user_default_value' => $default_value,
						'repetitive' => isset($field['repetitive'])? $field['repetitive']: 0,
						'conditional_display' => array(
							'relation' => 'AND',
							'custom' => '',
						),
	                    'submit-key' => $field_slug,
						'disabled_by_type' => 0,
					),
					'meta_key' => 'wpcf-' . $field_slug,
					'meta_type' => $meta_type,
				),
			);

			// Datetime field
			if ( $field['type'] == 'datetime') {
				$wpcf_field[$field_slug]['data']['date_and_time'] = 'and_time';
			}
			
			// Checkbox field
			if ( $type == 'checkbox' ) {
				$wpcf_field[$field_slug]['data'] = array(
                    'slug-pre-save' => $field_slug,
                    'set_value' => 1,
                    'save_empty' => 'no',
                    'display' => 'db',
					'conditional_display' => array(
						'relation' => 'AND',
						'custom' => '',
					),
                    'submit-key' => $field_slug,
					'disabled_by_type' => 0,
				);
			}
			
			// Options for checkboxes and select box
			if ( in_array($type, array('checkboxes', 'radio', 'select')) ) {
				$default_id = '';
				if ( isset($field['options']) ) {
					foreach ( $field['options'] as $option_name => $option_value ) {
						$option_name = (string)$option_name;
						$wpcf_option_name = 'wpcf-fields-' . $type . '-option-' . md5($option_value) . '-1';
						$wpcf_option_value = array(
							'title'		=> $option_value,
						);
						if ( $type == 'checkboxes' ) {
							// Checkboxes
							$wpcf_option_value['set_value'] = $option_name;
							$wpcf_option_value['display'] = 'db';
							if ( $option_name == $default_value ) {
								$wpcf_option_value['checked'] = 1;
							}
						} else {
							// Select box or radio box
							$wpcf_option_value['value'] = $option_name;
							$wpcf_option_value['display_value'] = $option_name;
							if ( $option_name == $default_value ) {
								$default_id = $wpcf_option_name;
							}
						}
						$wpcf_field[$field_slug]['data']['options'][$wpcf_option_name] = $wpcf_option_value;
					}
					unset($wpcf_field[$field_slug]['data']['user_default_value']);
					unset($wpcf_field[$field_slug]['data']['repetitive']);
					if ( $type == 'checkboxes' ) {
						$wpcf_field[$field_slug]['data']['save_empty'] = 'no';
					} else {
						$wpcf_field[$field_slug]['data']['display'] = 'db';
					}
					// Default value
					if ( !empty($default_id) ) {
						$wpcf_field[$field_slug]['data']['options']['default'] = $default_id;
					}
				}
			}

			// Required field
			if ( isset($field['required']) && $field['required'] ) {
				$wpcf_field[$field_slug]['data']['validate']['required'] = array(
					'active' => 1,
					'value' => 'true',
					'message' => __('This field is required.', 'fgd2wpp'),
				);
			}
			
			$wpcf_field = apply_filters('fgd2wp_pre_register_wpcf_field', $wpcf_field);
			return $wpcf_field;
		}
		
		/**
		 * Register a builtin post type on Types
		 *
		 * @param string $post_type Post type slug
		 * @param string $singular Singular post type name
		 * @param string $plural Plural post type name
		 * @param string $description Post type description
		 * @param array $taxonomies Taxonomies for this post type
		 */
		public function register_builtin_post_type($post_type, $singular, $plural, $description, $taxonomies) {
			$wpcf_custom_types = get_option('wpcf-custom-types', array());
			if ( !is_array($wpcf_custom_types) ) {
				$wpcf_custom_types = array();
			}
			if ( empty($wpcf_custom_types) || !isset($wpcf_custom_types[$post_type]) ) {
				$taxonomies_array = array();
				// Add the post builtin taxonomies
				if ( $post_type == 'post' ) {
					$taxonomies_array['category'] = 1;
					$taxonomies_array['post_tag'] = 1;
				}
				foreach ( $taxonomies as $taxonomy ) {
					if ( $taxonomy != 'tags' ) {
						$taxonomies_array[$taxonomy] = 1;
					}
				}
				$wpcf_custom_type = array(
					$post_type => array(
						'wpcf-post-type' => $post_type,
						'icon' => 'admin-post',
						'labels' => array(
							'name' => $plural,
							'singular_name' => $singular,
						),
						'slug' => $post_type,
						'description' => $description,
						'public' => 'public',
						'menu_position' => 0,
						'taxonomies' => $taxonomies_array,
						'_builtin' => 1,
					),
				);
				$wpcf_custom_types = array_merge($wpcf_custom_types, $wpcf_custom_type);
				update_option('wpcf-custom-types', $wpcf_custom_types);
			}
		}
		
		/**
		 * Register a post type on Types
		 *
		 * @param string $post_type Post type slug
		 * @param string $singular Singular post type name
		 * @param string $plural Plural post type name
		 * @param string $description Post type description
		 * @param array $taxonomies Taxonomies for this post type
		 * @param array $parent_post_types Parent post types
		 */
		public function register_post_type($post_type, $singular, $plural, $description, $taxonomies, $parent_post_types=array()) {
			$wpcf_custom_types = get_option('wpcf-custom-types', array());
			if ( !is_array($wpcf_custom_types) ) {
				$wpcf_custom_types = array();
			}
			if ( is_numeric($post_type) ) {
				// The post type must not be entirely numeric
				$post_type = '_' . $post_type;
			}
			if ( empty($wpcf_custom_types) || !isset($wpcf_custom_types[$post_type]) ) {
				// Taxonomies
				$taxonomies_array = array();
				foreach ( $taxonomies as $taxonomy ) {
					$taxonomies_array[$taxonomy] = 1;
				}
				$wpcf_custom_type = array(
					$post_type => array(
						'labels' => array(
							'name' => $plural,
							'singular_name' => $singular,
							'add_new' => 'Add New',
							'add_new_item' => 'Add New %s',
							'edit_item' => 'Edit %s',
							'new_item' => 'New %s',
							'view_item' => 'View %s',
							'search_items' => 'Search %s',
							'not_found' => 'No %s found',
							'not_found_in_trash' => 'No %s found in Trash',
							'parent_item_colon' => 'Parent %s',
							'all_items' => '%s',
						),
						'slug' => $post_type,
						'description' => $description,
						'public' => 'public',
						'menu_position' => 0,
						'menu_icon' => '',
						'taxonomies' => $taxonomies_array,
						'supports' => array(
							'title' => 1,
							'editor' => 1,
							'thumbnail' => 1,
//							'custom-fields' => 1,
						),
						'rewrite' => array(
							'enabled' => 1,
							'custom' => 'normal',
							'slug' => '',
							'with_front' => 1,
							'feeds' => 1,
							'pages' => 1,
						),
						'has_archive' => 1,
						'show_in_menu' => 1,
						'show_in_menu_page' => '',
						'show_ui' => 1,
						'publicly_queryable' => 1,
						'can_export' => 1,
						'show_in_nav_menus' => 1,
						'query_var_enabled' => 1,
						'query_var' => '',
						'permalink_epmask' => 'EP_PERMALINK',
					),
				);
				
				if ( version_compare($this->wpcf_version, '3.0', '<') ) {
					// Toolset < 3.0
					// Parent post types
					$parent_post_types_array = array();
					foreach ( $parent_post_types as $parent_post_type ) {
						$parent_post_types_array[$parent_post_type] = 1;
					}
					if ( !empty($parent_post_types_array) ) {
						$wpcf_custom_type[$post_type]['post_relationship']['belongs'] = $parent_post_types_array;
					}
				}
				
				$wpcf_custom_types = array_merge($wpcf_custom_types, $wpcf_custom_type);
				update_option('wpcf-custom-types', $wpcf_custom_types);
				register_post_type($post_type, $wpcf_custom_type[$post_type]);
			}
		}
		
		/**
		 * Register the post types relations
		 * 
		 * @since 1.16.0
		 * 
		 * @param array $node_types_relations Node Types Relationships
		 */
		public function register_post_types_relations($node_types_relations) {
			if ( version_compare($this->wpcf_version, '3.0', '<') ) {
				
				// Toolset < 3.0
				$wpcf_relations = get_option('wpcf_post_relationship', array());
				foreach ( $node_types_relations as $child => $parents ) {
					foreach ( $parents as $parent ) {
						$wpcf_relations[$parent['post_type']][$child] = array();
					}
				}
				update_option('wpcf_post_relationship', $wpcf_relations);
			} else {
				
				// Toolset 3.0+
				$this->get_current_toolset_relationships();
				foreach ( $node_types_relations as $child => $parents ) {
					foreach ( $parents as $parent ) {
						$relationship_label = !empty($parent['label'])? $parent['label'] : $parent['post_type'];
						$relationship_slug = $this->normalize_slug($relationship_label . '-' . $child . '-' . $parent['post_type']);
						$this->add_toolset_relationship($relationship_slug, $child, $parent['post_type'], $relationship_label, $parent['cardinality'], 'wizard');
					}
				}
			}
		}
		
		/**
		 * Normalize the slug
		 * 
		 * @since 2.19.0
		 * 
		 * @param string $slug Slug
		 * @return string Slug
		 */
		public function normalize_slug($slug) {
			$slug = sanitize_key(FG_Drupal_to_WordPress_Tools::convert_to_latin($slug));
			return $slug;
		}
		
		/**
		 * Set the $toolset_relationships variable
		 */
		public function get_current_toolset_relationships() {
			self::$toolset_relationships = $this->get_toolset_relationships();
		}
		
		/**
		 * Get the Toolset relationships
		 * 
		 * @since 1.61.0
		 * 
		 * @global $wpdb
		 * @return array Relationships
		 */
		private function get_toolset_relationships() {
			global $wpdb;
			$relationships = array();
			
			$sql = "SELECT r.id, r.slug FROM {$wpdb->prefix}toolset_relationships r ORDER BY r.id";
			$result = $wpdb->get_results($sql, ARRAY_A);
			foreach ( $result as $row ) {
				$relationships[$row['slug']] = $row['id'];
			}
			return $relationships;
		}
		
		/**
		 * Add a Toolset association between two posts
		 * 
		 * @since 1.62.0
		 * 
		 * @param int $post_id Post ID
		 * @param int $parent_post_id Parent post ID
		 * @param string $wp_type WP type
		 * @param string $relationship_slug Relationship slug
		 * @return bool Success
		 */
		public function add_toolset_association($post_id, $parent_post_id, $wp_type, $relationship_slug) {
			$return = false;
			if ( empty($this->wpcf_version) || version_compare($this->wpcf_version, '3.0', '<') ) {
				// Toolset < 3.0
				if ( !empty($wp_type) ) {
					update_post_meta($post_id, '_wpcf_belongs_' . $wp_type . '_id', $parent_post_id);
					$return = true;
				}
			} else {

				// Toolset 3.0+
				if ( isset(self::$toolset_relationships[$relationship_slug]) && function_exists('toolset_connect_posts') ) {
					if ( preg_match('/-(.*)-(\1)$/', $relationship_slug) ) {
						// Prevent a Toolset bug: the relationship is inverted if the parent type is the same as the child type
						$result = toolset_connect_posts($relationship_slug, $post_id, $parent_post_id);
					} else {
						$result = toolset_connect_posts($relationship_slug, $parent_post_id, $post_id);
					}
					$return = $result['success'];
				}
			}
			return $return;
		}
		
		/**
		 * Add a Toolset relationship
		 * 
		 * @since 1.61.0
		 * 
		 * @global object $wpdb WPDB object
		 * @param string $slug Relationship slug
		 * @param string $child_post_type Child post type
		 * @param string $parent_post_type_and_label Parent post type
		 * @param string $relationship_label Relationship label
		 * @param int cardinality_parent_max Max cardinality for the parent (-1 for many-to-many relationship)
		 * @param string $origin wizard | repeatable_group
		 * @return int Relationship ID
		 */
		public function add_toolset_relationship($slug, $child_post_type, $parent_post_type, $relationship_label, $cardinality_parent_max, $origin) {
			global $wpdb;
			$relationship_id = 0;
			
			if ( isset(self::$toolset_relationships[$slug]) ) {
				// Relationship already exists
				$relationship_id = self::$toolset_relationships[$slug];
				
			} else {
				$table_name = $wpdb->prefix . 'toolset_relationships';

				$parent_type_set_id = $this->add_toolset_type_set($parent_post_type);
				$child_type_set_id = $this->add_toolset_type_set($child_post_type);

				$singular = preg_replace('/s$/', '', ucwords($relationship_label));

				$result = $wpdb->insert($table_name, array(
					'slug' => $slug,
					'display_name_plural' => $singular . 's',
					'display_name_singular' => $singular,
					'driver' => 'toolset',
					'parent_domain' => 'posts',
					'parent_types' => $parent_type_set_id,
					'child_domain' => 'posts',
					'child_types' => $child_type_set_id,
					'ownership' => 0,
					'cardinality_parent_max' => $cardinality_parent_max,
					'cardinality_parent_min' => 0,
					'cardinality_child_max' => -1,
					'cardinality_child_min' => 0,
					'is_distinct' => ($origin == 'repeatable_group')? 0 : 1,
					'origin' => $origin,
					'role_name_parent' => 'parent',
					'role_name_child' => 'child',
					'role_name_intermediary' => 'association',
					'role_label_parent_singular' => 'Parent',
					'role_label_child_singular' => 'Child',
					'role_label_parent_plural' => 'Parents',
					'role_label_child_plural' => 'Children',
					'needs_legacy_support' => 0,
					'is_active' => 1,
				));
				if ( !empty($result) ) {
					$relationship_id = $wpdb->insert_id;
					self::$toolset_relationships[$slug] = $relationship_id;
				}
			}
			return $relationship_id;
		}
		
		/**
		 * Add a Toolset type set
		 * 
		 * @since 1.61.0
		 * 
		 * @global object $wpdb WPDB object
		 * @param string $post_type Post type
		 * @return int Type set ID
		 */
		private function add_toolset_type_set($post_type) {
			global $wpdb;
			$type_set_id = 0;
			
			$table_name = $wpdb->prefix . 'toolset_type_sets';
			
			$sql = "SELECT MAX(`set_id`) FROM `$table_name`";
			$max = $wpdb->get_var($sql);
			
			$result = $wpdb->insert($table_name, array(
				'set_id' => $max + 1,
				'type' => substr($post_type, 0, 20), // the type is limited to 20 characters
			));
			if ( !empty($result) ) {
				$type_set_id = $wpdb->insert_id;
			}
			return $type_set_id;
		}
		
		/**
		 * Modify the post content or the post excerpt
		 * 
		 * @since 1.12.1
		 * 
		 * @param int $new_post_id WordPress post ID
		 * @param string $field post_content | post_excerpt
		 * @param array $field_values Field values
		 * @param date $date Node date
		 */
		public function add_custom_field_as_post_field($new_post_id, $field, $field_values, $date='') {
			if ( !empty($field_values) ) {
				if ( is_array($field_values[0]) ) {
					$value = implode("<br />\n", $field_values[0]);
				} else {
					$value = $field_values[0];
				}
				$value = $this->plugin->replace_media_shortcodes($value);
				$value = $this->plugin->replace_media_links($value, $date);
				$post = get_post($new_post_id, ARRAY_A);
				$value = $post[$field] . $value;
				wp_update_post(array(
					'ID' => $new_post_id,
					$field => $value,
				));
			}
		}
		
		/**
		 * Add a custom field value as a post meta
		 * 
		 * @since 1.40.0
		 * 
		 * @param int $new_post_id WordPress post ID
		 * @param string $custom_field_name Field name
		 * @param array $custom_field Field data
		 * @param array $custom_field_values Field values
		 * @param date $date Date
		 */
		public function add_custom_field_as_postmeta($new_post_id, $custom_field_name, $custom_field, $custom_field_values, $date='') {
			$metas = $this->convert_custom_field_to_metas($custom_field_name, $custom_field, $custom_field_values, 'post', $date, $new_post_id);
			foreach ( $metas as $meta ) {
				list($meta_key, $meta_value) = $meta;
				if ( is_scalar($meta_value) ) {
					$meta_value = addslashes($this->plugin->replace_media_shortcodes(stripslashes($meta_value)));
				}
				add_post_meta($new_post_id, 'wpcf-' . $meta_key, $meta_value);
			}
		}
		
		/**
		 * Add a custom field value as a term meta
		 * 
		 * @since 1.40.0
		 * 
		 * @param int $new_term_id WordPress term ID
		 * @param string $custom_field_name Field name
		 * @param array $custom_field Field data
		 * @param array $custom_field_values Field values
		 */
		public function add_custom_field_as_termmeta($new_term_id, $custom_field_name, $custom_field, $custom_field_values) {
			$metas = $this->convert_custom_field_to_metas($custom_field_name, $custom_field, $custom_field_values, 'term');
			foreach ( $metas as $meta ) {
				list($meta_key, $meta_value) = $meta;
				add_term_meta($new_term_id, 'wpcf-' . $meta_key, $meta_value);
			}
		}
		
		/**
		 * Add a custom field value as a user meta
		 * 
		 * @since 1.47.0
		 * 
		 * @param int $new_user_id WordPress user ID
		 * @param string $custom_field_name Field name
		 * @param array $custom_field Field data
		 * @param array $custom_field_values Field values
		 * @param date $date Date
		 */
		public function add_custom_field_as_usermeta($new_user_id, $custom_field_name, $custom_field, $custom_field_values, $date='') {
			$metas = $this->convert_custom_field_to_metas($custom_field_name, $custom_field, $custom_field_values, 'user', $date);
			foreach ( $metas as $meta ) {
				list($meta_key, $meta_value) = $meta;
				add_user_meta($new_user_id, 'wpcf-' . $meta_key, $meta_value);
			}
		}
		
		/**
		 * Convert a custom field value to a meta
		 * 
		 * @since 1.12.1
		 * 
		 * @param string $custom_field_name Field name
		 * @param array $custom_field Field data
		 * @param array $custom_field_values Field values
		 * @param string $entity_type Entity type (post, term, user)
		 * @param date $date Date
		 * @param int $new_post_id WordPress post ID
		 * @return array Meta data
		 */
		private function convert_custom_field_to_metas($custom_field_name, $custom_field, $custom_field_values, $entity_type, $date='', $new_post_id='') {
			$metas = array();
			$module = isset($custom_field['module'])? $custom_field['module'] : '';
			$custom_field_type = $this->plugin->map_custom_field_type($custom_field['type'], $custom_field['label'], $module);
			switch ( $custom_field_type ) {
				// Date
				case 'date':
				case 'datetime':
					foreach ( $custom_field_values as $custom_field_value ) {
						if ( is_array($custom_field_value) ) {
							foreach ( $custom_field_value as $subvalue ) {
								$metas[] = array($custom_field_name, $this->convert_to_timestamp($subvalue));
							}
						} else {
							$metas[] = array($custom_field_name, $this->convert_to_timestamp($custom_field_value));
						}
					}
					break;

				// Image
				case 'image':
				case 'file':
					if ( !$this->plugin->plugin_options['skip_media'] ) {
						foreach ( $custom_field_values as $file ) {
							// Import media
							$file_date = isset($file['timestamp'])? date('Y-m-d H:i:s', $file['timestamp']) : $date;
							$image_attributs = array(
								'image_alt' => $this->plugin->get_image_attributes($file, 'alt'),
								'description' => $this->plugin->get_image_attributes($file, 'description'),
							);
							$filename = preg_replace('/\..*$/', '', basename($file['filename']));
							$attachment_id = $this->plugin->import_media($filename, $this->plugin->get_path_from_uri($file['uri']), $file_date, $image_attributs);
							if ( $attachment_id ) {
								$this->plugin->media_count++;
								$attachment_url = wp_get_attachment_url($attachment_id);
								if ( !empty($attachment_url) ) {
									// Assign the media URL to the postmeta
									if ( !empty($new_post_id) ) {
										$set_featured_image = ($this->plugin->plugin_options['featured_image'] == 'featured') && !$this->plugin->thumbnail_is_set;
										$this->plugin->add_post_media($new_post_id, array('post_date' => $file_date), array($attachment_id), $set_featured_image); // Attach the media to the post
										$this->plugin->thumbnail_is_set = true;
									}
									// Set the field value
									$metas[] = array($custom_field_name, $attachment_url);
								}
							}
						}
					}
					break;

				// URL or embedded media
				case 'url':
				case 'embed':
					foreach ( $custom_field_values as $custom_field_value ) {
						if ( isset($custom_field_value['uri']) ) {
							$wpcf_value = $this->plugin->get_path_from_uri($custom_field_value['uri']);
						} else {
							if ( is_array($custom_field_value) ) {
								$wpcf_values = array();
								foreach ( $custom_field_value as $key => $value ) {
									if ( preg_match('/title$/', $key) ) {
										// Import the URL title in a separate field
										$metas[] = array($custom_field_name . '_title', $value);
									} else {
										$wpcf_values[$key] = $value;
									}
								}
								$wpcf_value = implode("<br />\n", $wpcf_values);
							} else {
								$wpcf_value = $custom_field_value;
							}
						}
						$metas[] = array($custom_field_name, $wpcf_value);
					}
					break;
					
				// Checkboxes
				case 'checkboxes':
					$options = $this->get_wpcf_options($custom_field_name, $entity_type);
					$wpcf_values = array();
					foreach ( $custom_field_values as $values ) {
						if ( is_array($values) ) {
							foreach ( $values as $value ) {
								if ( isset($options[$value]) ) {
									$wpcf_values[$options[$value]['key']] = $options[$value]['title'];
								}
							}
						}
					}
					$metas[] = array($custom_field_name, $wpcf_values);
					break;
				
				default:
					foreach ( $custom_field_values as $custom_field_value ) {
						if ( is_array($custom_field_value) ) {
							$wpcf_value = implode("<br />\n", $custom_field_value);
						} else {
							$wpcf_value = $custom_field_value;
						}
						$wpcf_value = $this->plugin->replace_media_links($wpcf_value, $date);
						
						$metas[] = array($custom_field_name, $wpcf_value);
					}
			}
			return $metas;
		}
		
		/**
		 * Convert a date to a timestamp
		 * 
		 * @since 1.72.0
		 * 
		 * @param mixed $date Date
		 * @return int Timestamp
		 */
		private function convert_to_timestamp($date) {
			if ( is_numeric($date) ) {
				$timestamp = $date;
			} else {
				$date = preg_replace('/-00/', '-01', $date); // For dates with month=00 or day=00
				$timestamp = strtotime($date);
			}
			return $timestamp;
		}
		
		/**
		 * Get the available options for a custom field
		 * 
		 * @param string $custom_field_name Custom field name
		 * @param string $entity_type Entity type (post, term, user)
		 * @return array Options
		 */
		public function get_wpcf_options($custom_field_name, $entity_type) {
			$wpcf_options = array();
			$option_name = ($entity_type == 'user')? 'wpcf-usermeta' : 'wpcf-fields';
			$wpcf_fields = get_option($option_name, array());
			if ( isset($wpcf_fields[$custom_field_name]['data']['options']) ) {
				foreach ($wpcf_fields[$custom_field_name]['data']['options'] as $key => $data ) {
					$value = '';
					if ( isset($data['set_value']) ) {
						$value = $data['set_value'];
					} elseif ( isset($data['value']) ) {
						$value = $data['value'];
					}
					if ( !empty($value) ) {
						$wpcf_options[$value] = array(
							'key' => $key,
							'title' => $data['title'],
						);
					}
				}
			}
			return $wpcf_options;
		}
		
	}
}
