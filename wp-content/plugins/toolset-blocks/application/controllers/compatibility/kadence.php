<?php

namespace OTGS\Toolset\Views\Controller\Compatibility;

/**
 * Handles the compatibility between Views and the Kadence Theme.
 *
 * @since 3.2.0
 */
class Kadence extends Base {

	/**
	 * Initiliazes the Kadence Theme compatibility layer.
	 */
	public function initialize() {
		$this->init_hooks();
	}

	/**
	 * Initiliazes the hooks for the Kadence Theme compatibility.
	 */
	private function init_hooks() {
		add_action( 'wpv_action_after_archive_set', array( $this, 'disable_grid_on_assigned_archive' ) );
	}

	/**
	 * Disable the grid CSS classes in archives which have a WPA assigned.
	 *
	 * @param null|int $wpa_id
	 */
	public function disable_grid_on_assigned_archive( $wpa_id ) {
		if ( null === $wpa_id ) {
			return;
		}

		if ( 0 === $wpa_id ) {
			return;
		}

		add_filter( 'kadence_archive_container_classes', array( $this, 'filter_out_grid_classes' ) );
	}

	/**
	 * Remove classes sarting with grid- prefixes.
	 *
	 * @param string[] $classnames
	 * @return string[]
	 */
	public function filter_out_grid_classes( $classnames ) {
		$filtred_classnames = array_filter( $classnames, function( $v ) {
			return substr( $v, 0, 5 ) !== 'grid-';
		});
		return $filtred_classnames;
	}

}
