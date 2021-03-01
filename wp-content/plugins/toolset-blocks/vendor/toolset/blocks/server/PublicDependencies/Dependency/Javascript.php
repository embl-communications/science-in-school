<?php
namespace ToolsetBlocks\PublicDependencies\Dependency;

/**
 * Loads frontend JS for blocks.
 *
 * @package ToolsetBlocks
 * @since 1.0.0
 */
class Javascript implements IContent {
	/** @var bool  */
	private $is_loaded = false;

	/**
	 * @param string $content
	 *
	 * @return bool
	 */
	public function is_required_for_content( $content ) {
		if ( $this->is_loaded ) {
			// No needed for a second load.
			return false;
		}

		if ( preg_match( '(data-countdown|data-shareurl|tb-progress-data|tb-repeating-field--carousel|tb-repeating-field--masonry|tb-container-parallax|tb-image-slider|tb-gallery)', $content ) === 1 ) {
			return true;
		}

		return false;
	}

	/**
	 * @return mixed
	 */
	public function load_dependencies() {
		$this->is_loaded = true;
		wp_enqueue_script(
			'tb-frontend-js',
			TB_URL . 'public/js/frontend.js',
			array( 'jquery', 'underscore', 'toolset-common-es-frontend' ),
			TB_VER
		);
	}

}
