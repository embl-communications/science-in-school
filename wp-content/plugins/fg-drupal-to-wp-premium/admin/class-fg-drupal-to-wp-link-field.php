<?php

/**
 * Link Field module
 *
 * @link       https://www.fredericgilles.net/drupal-to-wordpress/
 * @since      1.8.0
 *
 * @package    FG_Drupal_to_WordPress_Premium
 * @subpackage FG_Drupal_to_WordPress_Premium/admin
 */

if ( !class_exists('FG_Drupal_to_WordPress_Link_Field', false) ) {

	/**
	 * Link Field class
	 *
	 * @package    FG_Drupal_to_WordPress_Premium
	 * @subpackage FG_Drupal_to_WordPress_Premium/admin
	 * @author     Frédéric GILLES
	 */
	class FG_Drupal_to_WordPress_Link_Field {

		/**
		 * Initialize the class and set its properties.
		 *
		 * @param    object    $plugin       Admin plugin
		 */
		public function __construct( $plugin ) {
			$this->plugin = $plugin;
		}
		
		/**
		 * Get the Link custom fields
		 * 
		 * @param array $custom_fields Custom fields
		 * @param string $field Field data
		 * @return array Custom fields
		 */
		public function get_link_custom_fields($custom_fields, $field) {
			if ( $field['module'] == 'link' ) {
				$link_fields = array(
					'url' => $field['field_name'] . '_uri',
					'title' => $field['field_name'] . '_title',
				);
				foreach ( $link_fields as $field_slug => $field_column_v8 ) {
					$new_field = $field;
					$new_field['field_group'] = ucfirst(str_replace('_', ' ', str_replace('field_', '', $field['field_name'])));
					$new_field['label'] = ucfirst(str_replace('_', ' ', $field_slug));
					$new_field['type'] = 'textfield';
					$new_field['description'] = '';
					if ( version_compare($this->plugin->drupal_version, '8', '<') ) {
						// Version 7
						$column_field = $field['columns'][$field_slug];
					} else {
						// Version 8
						$column_field = $field_column_v8;
					}
					$field_key = $field['field_name'] . '_' . $field_slug;
					$new_field['columns'] = array($field_key => $column_field);
					$custom_fields[$field_key] = $new_field;
				}
			}
			return $custom_fields;
		}
		
	}
}
