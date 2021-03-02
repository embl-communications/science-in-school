<?php

/**
 * Media module
 *
 * @link       https://www.fredericgilles.net/fg-drupal-to-wp/
 * @since      2.13.0
 *
 * @package    FG_Drupal_to_WordPress_Premium
 * @subpackage FG_Drupal_to_WordPress_Premium/admin
 */

if ( !class_exists('FG_Drupal_to_WordPress_Media', false) ) {

	/**
	 * Media class
	 *
	 * @package    FG_Drupal_to_WordPress_Premium
	 * @subpackage FG_Drupal_to_WordPress_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Drupal_to_WordPress_Media {
		
		private $plugin;
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @param    object    $plugin       Admin plugin
		 */
		public function __construct( $plugin ) {

			$this->plugin = $plugin;
		}
		
		/**
		 * Import the Drupal Media media
		 * 
		 * @param string $content Content
		 * @return string Content
		 */
		public function import_media($content) {
			$matches = array();
			$matches2 = array();
			if ( preg_match_all('#<drupal-media (.*?)</drupal-media>#', $content, $matches) ) {
				foreach ( $matches[1] as $tag ) {
					if ( preg_match('/uuid="(.*?)"/', $tag, $matches2) ) {
						$uuid = $matches2[1];
						$media = $this->get_media($uuid);
						if ( !empty($media) ) {
							$value = implode("\n", $this->get_media_values($media));
							if ( !empty($value) ) {
								$content = preg_replace("#<drupal-media (.*?)uuid=\"$uuid\"(.*?)</drupal-media>#", $value, $content);
							}
						}
					}
				}
			}
			return $content;
		}
		
		/**
		 * Get the Media object
		 * 
		 * @param string $uuid UUID
		 * @return array Media data
		 */
		private function get_media($uuid) {
			$media = array();

			$prefix = $this->plugin->plugin_options['prefix'];
			if ( $this->plugin->table_exists('media') ) {
				$sql = "
					SELECT m.mid, m.bundle
					FROM ${prefix}media m
					WHERE m.uuid = '$uuid'
					LIMIT 1
				";
				$result = $this->plugin->drupal_query($sql);
				if ( count($result) > 0 ) {
					$media = $result[0];
				}
			}
			return $media;
		}
		
		/**
		 * Get the media value
		 * 
		 * @param array $media Media data
		 * @return array Values
		 */
		public function get_media_values($media) {
			$values = array();

			$prefix = $this->plugin->plugin_options['prefix'];
			$bundle = $media['bundle'];
			$mid = $media['mid'];
			if ( !empty($bundle) && !empty($mid) ) {
				$field_names = $this->get_media_field_names($bundle);
				foreach ( $field_names as $field_name ) {
					$table_name = 'media__' . $field_name;
					$value_field_name = $this->guess_column_name($table_name, $field_name);
					$target_field_name = $field_name . '_target_id';
					if ( !empty($value_field_name) ) {
						// Value field
						$sql = "
							SELECT m.$value_field_name AS value
							FROM ${prefix}$table_name m
							WHERE m.entity_id = '$mid'
							LIMIT 1
						";
						$result = $this->plugin->drupal_query($sql);
						if ( count($result) > 0 ) {
							$value = $result[0]['value'];
							if ( !empty($value) ) {
								if ( preg_match('/^http/', $value) ) {
									$value = "[embed]{$value}[/embed]"; // Embed hyperlinks
								}
								$values[] = $value;
							}
						}
					} elseif ( $this->plugin->column_exists($table_name, $target_field_name) ) {
						// Target ID field
						$extra_columns = array();
						switch ( $bundle ) {
							case 'image':
								$extra_columns = array('field_media_image_alt', 'field_media_image_title');
								break;
						}
						$extra_columns_str = implode(',', $extra_columns);
						$sql = "
							SELECT fm.filename, fm.uri, $extra_columns_str
							FROM ${prefix}$table_name m
							INNER JOIN ${prefix}file_managed fm ON fm.fid = m.$target_field_name
							WHERE m.entity_id = '$mid'
							LIMIT 1
						";
						$result = $this->plugin->drupal_query($sql);
						if ( count($result) > 0 ) {
							$uri = $this->plugin->get_path_from_uri($result[0]['uri']);
							switch ( $bundle ) {
								case 'image':
									$values[] = sprintf('<img src="%s" alt="%s" title="%s" />', $uri, $result[0]['field_media_image_alt'], $result[0]['field_media_image_title']);
									break;
								default:
									$values[] = $result[0]['uri'];
							}
						}
					}
				}
			}
			return $values;
		}
		
		/**
		 * Get the field names related to a bundle
		 * 
		 * @param string $bundle Bundle
		 * @return array Field names
		 */
		private function get_media_field_names($bundle) {
			$fields = array();
			$tables = $this->plugin->get_drupal_config_like("field.field.media.$bundle.%");
			foreach ( $tables as $table ) {
				if ( $table['bundle'] == $bundle ) {
					$fields[] = $table['field_name'];
				}
			}
			return $fields;
		}
		
		/**
		 * Guess the column name
		 * 
		 * @since 2.35.0
		 * 
		 * @param string $table_name Table name
		 * @param string $field_name Field name
		 * @return string Column name
		 */
		private function guess_column_name($table_name, $field_name) {
			$suffixes = array('_value', '_uri');
			foreach ( $suffixes as $suffix ) {
				$column = $field_name . $suffix;
				if ( $this->plugin->column_exists($table_name, $column) ) {
					return $column;
				}
			}
			return '';
		}
		
	}
}
