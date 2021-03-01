<?php

namespace OTGS\Toolset\Views\Controller\Compatibility\BlockPlugin;

/**
 * Handles the compatibility between Views and Kadence blocks.
 */
class KadenceCompatibility extends BlockPluginCompatibility {
	const BLOCK_NAMESPACE = 'kadence';

	/**
	 * Initializes the Kadence blocks integration.
	 */
	public function initialize() {
		$this->init_hooks();
	}

	/**
	 * Initializes the hooks for the Kadence integration.
	 */
	private function init_hooks() {
		// Adjusts the blocks' output and the relevant styles for those that have Dynamic Sources integrated, when inside a View.
		add_filter( 'kadence_blocks_frontend_build_css', array( $this, 'maybe_capture_block_id_for_css_generation' ), 10, 2 );
		add_filter( 'render_block', array( $this, 'maybe_capture_block_id_for_css_generation_on_block_rendering' ), 10, 2 );

		add_filter( 'wpv_filter_view_loop_item_output', array( $this, 'adjust_classes_in_view_loop_item_and_generate_proper_styles' ), 10, 3 );
		add_filter( 'wpv_view_pre_do_blocks_view_layout_meta_html', array( $this, 'capture_view_template' ), 10, 2 );

		add_action( 'wpv_action_before_doing_blocks_for_styles_collection', array( $this, 'force_style_inline_css_rendering_in_content' ) );
	}

	/**
	 * On block rendering, it adjusts the block ID for CSS generation by adding the post ID to the end of the unique block identifier.
	 *
	 * @param string $block_content
	 * @param array  $parsed_block
	 *
	 * @return mixed
	 */
	public function maybe_capture_block_id_for_css_generation_on_block_rendering( $block_content, $parsed_block ) {
		$this->maybe_capture_block_id_for_css_generation( $parsed_block );
		return $block_content;
	}


	/**
	 * Adjusts the block ID for CSS generation by adding the post ID to the end of the unique block identifier.
	 *
	 * @param array $block
	 *
	 * @return array
	 */
	public function maybe_capture_block_id_for_css_generation( $block ) {
		if (
			! isset( $block['blockName'] ) ||
			! isset( $block['attrs'] ) ||
			! is_array( $block['attrs'] )
		) {
			return $block;
		}

		$block_name = $block['blockName'];
		$block_attributes = $block['attrs'];

		if ( ! $this->is_block_from_compatible_plugin( $block_name ) ) {
			return $block;
		}

		$block_integration_info = apply_filters( 'toolset/dynamic_sources/filters/third_party_block_integration_info', array(), $block_name );

		if (
			! $block_integration_info ||
			! array_key_exists( 'uniqueID', $block_attributes )
		) {
			return $block;
		}

		if ( ! in_array( $block_attributes['uniqueID'], $this->original_block_id_array, true ) ) {
			array_push( $this->original_block_id_array, $block_attributes['uniqueID'] );
		}

		return $block;
	}

	/**
	 * Adjusts the loop item output to have proper classes (modified to include the post ID) for the blocks' output as well
	 * as prepends the loop item output with the proper styles for the modified classes.
	 *
	 * @param string   $loop_item_output
	 * @param int      $index
	 * @param \WP_Post $post
	 *
	 * @return string
	 */
	public function adjust_classes_in_view_loop_item_and_generate_proper_styles( $loop_item_output, $index, $post ) {
		if ( ! $this->has_block_from_compatible_plugin( $this->template_content ) ) {
			return $loop_item_output;
		}

		foreach ( $this->original_block_id_array as $block_id ) {
			$search_for_block_id = $block_id;
			$replace_with_modified_block_id = $block_id . '_' . $post->ID;

			$loop_item_output = str_replace( $search_for_block_id, $replace_with_modified_block_id, $loop_item_output );
		}

		return $loop_item_output;
	}

	/**
	 * Forces inline CSS styles for blocks to be rendered in content instead of been enqueued as a style.
	 */
	public function force_style_inline_css_rendering_in_content() {
		add_filter( 'kadence_blocks_force_render_inline_css_in_content', '__return_true' );
	}
}
