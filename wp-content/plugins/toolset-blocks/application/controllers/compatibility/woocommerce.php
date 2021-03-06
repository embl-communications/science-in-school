<?php

namespace OTGS\Toolset\Views\Controller\Compatibility;

use OTGS\Toolset\Views\Services\Bootstrap;
use OTGS\Toolset\Views\Services\QueryFilterService;

/**
 * Class WooCommerceCompatibility
 *
 * Handles the compatibility between Views and WooCommerce.
 *
 * @since Views 3.3 / Toolset Blocks 1.3
 */
class WooCommerceCompatibility extends Base {
	const RELATED_PRODUCTS_FILTER_AUTOGENERATED_KEY = 'related_products_filter_autogenerated';

	const UP_SELLS_PRODUCTS_FILTER_AUTOGENERATED_KEY = 'up_sells_products_filter_autogenerated';

	const CROSS_SELLS_PRODUCTS_FILTER_AUTOGENERATED_KEY = 'cross_sells_products_filter_autogenerated';

	const QUERY_FILTER_INJECTION_RELATIONSHIP_SLUG_RELATED = 'related';

	const QUERY_FILTER_INJECTION_RELATIONSHIP_SLUG_UP_SELLS = 'up-sells';

	const QUERY_FILTER_INJECTION_RELATIONSHIP_SLUG_CROSS_SELLS = 'cross-sells';

	const WC_UP_SELLS_POST_META = '_upsell_ids';

	const WC_CROSS_SELLS_POST_META = '_crosssell_ids';

	const TOP_CURRENT_POST = 'top_current_post';

	/**
	 * Product Taxonomy Filter View Settings (Category)
	 */
	const VIEW_SETTINGS_TAX_FILTER_TAX_PRODUCT_CAT_RELATIONSHIP = 'tax_product_cat_relationship';
	const VIEW_SETTINGS_TAX_FILTER_TAXONOMY_PRODUCT_CAT_ATTRIBUTE_OPERATOR = 'taxonomy-product_cat-attribute-operator';
	const VIEW_SETTINGS_TAX_FILTER_TAX_INPUT_PRODUCT_CAT = 'tax_input_product_cat';

	/**
	 * Product Taxonomy Filter View Settings (Tag)
	 */
	const VIEW_SETTINGS_TAX_FILTER_TAX_PRODUCT_TAG_RELATIONSHIP = 'tax_product_tag_relationship';
	const VIEW_SETTINGS_TAX_FILTER_TAXONOMY_PRODUCT_TAG_ATTRIBUTE_OPERATOR = 'taxonomy-product_tag-attribute-operator';
	const VIEW_SETTINGS_TAX_FILTER_TAX_INPUT_PRODUCT_TAG = 'tax_input_product_tag';

	/**
	 * Initializes the WooCommerce integration.
	 */
	public function initialize() {
		$this->init_hooks();
	}

	/**
	 * Initializes the hooks for the WooCommerce integration.
	 */
	private function init_hooks() {
		add_filter( 'wpv_filter_post_relationship_slugs_blacklist_for_automatic_query_filter_generation', array( $this, 'add_relationship_slugs_to_be_excluded' ) );

		add_filter( 'wpv_view_settings', array( $this, 'maybe_adjust_view_settings_for_query_filter_injection' ), 10, 2 );

		add_filter( 'wpv_filter_wpv_get_view_settings_for_query_filter_rendering', array( $this, 'maybe_adjust_view_settings_for_query_filter_injection' ), 10, 2 );

		add_filter( 'wpv_filter_wpv_get_view_settings', array( $this, 'maybe_adjust_view_settings_for_query_filter_injection' ), 10, 2 );

		add_filter( 'wpv_filter_maybe_hide_filter_title_controls', array( $this, 'maybe_hide_filter_title_controls' ), 10, 3 );

		add_filter( 'wpv_filter_query_filter_summary', array( $this, 'adjust_query_filter_summary' ), 10, 3 );

		add_filter( 'wpv_filter_query_filter_title', array( $this, 'adjust_query_filter_title' ), 10, 3 );
	}

	/**
	 * Adds the WooCommerce post relationship slugs to the blacklist to prevent handling the WooCommerce related query slugs
	 * as normal post relationship slugs during automatic query filter generation.
	 *
	 * @param array $slugs The array of blacklisted post relationship slugs.
	 *
	 * @return array
	 */
	public function add_relationship_slugs_to_be_excluded( $slugs ) {
		return array_merge(
			$slugs,
			array(
				self::QUERY_FILTER_INJECTION_RELATIONSHIP_SLUG_RELATED,
				self::QUERY_FILTER_INJECTION_RELATIONSHIP_SLUG_UP_SELLS,
				self::QUERY_FILTER_INJECTION_RELATIONSHIP_SLUG_CROSS_SELLS,
			)
		);
	}

	/**
	 * Adjusts the View's settings post meta to achieve automatic query filter generation for the WooCommerce Related
	 * Query Filters.
	 *
	 * @param array    $view_settings
	 * @param null|int $view_id
	 *
	 * @return array
	 */
	public function maybe_adjust_view_settings_for_query_filter_injection( $view_settings, $view_id = null ) {
		if ( ! $view_id ) {
			return $view_settings;
		}

		$view_data = get_post_meta( $view_id, Bootstrap::BLOCK_VIEW_DATA_POST_META_KEY, true );
		$allow_multiple_post_types = toolset_getnest( $view_data, array( 'content_selection', 'allowMultiplePostTypes' ), false );
		$post_type_relationship_slug = toolset_getnest( $view_data, array( 'content_selection', 'postTypeRelationship' ), QueryFilterService::QUERY_FILTER_INJECTION_RELATIONSHIP_SLUG_NOT_SET );

		if ( $allow_multiple_post_types ) {
			return $view_settings;
		}

		if ( self::QUERY_FILTER_INJECTION_RELATIONSHIP_SLUG_RELATED === $post_type_relationship_slug ) {
			$view_settings[ self::VIEW_SETTINGS_TAX_FILTER_TAX_PRODUCT_CAT_RELATIONSHIP ] = self::TOP_CURRENT_POST;
			$view_settings[ self::VIEW_SETTINGS_TAX_FILTER_TAXONOMY_PRODUCT_CAT_ATTRIBUTE_OPERATOR ] = 'IN';
			$view_settings[ self::VIEW_SETTINGS_TAX_FILTER_TAX_INPUT_PRODUCT_CAT ] = array();

			$view_settings[ self::VIEW_SETTINGS_TAX_FILTER_TAX_PRODUCT_TAG_RELATIONSHIP ] = self::TOP_CURRENT_POST;
			$view_settings[ self::VIEW_SETTINGS_TAX_FILTER_TAXONOMY_PRODUCT_TAG_ATTRIBUTE_OPERATOR ] = 'IN';
			$view_settings[ self::VIEW_SETTINGS_TAX_FILTER_TAX_INPUT_PRODUCT_TAG ] = array();

			$view_settings[ \WPV_View_Base::VIEW_SETTINGS_TAXONOMY_FILTER_TAXONOMY_RELATIONSHIP ] = 'OR';

			// Setting the following View Setting to true to mark that this query filter has been autogenerated, in order
			// to later adjust it's description and UI (remove "Edit" and "Delete" buttons).
			// Also this is going to be used to remove it from the list of offered query filters to be created.
			$view_settings[ self::RELATED_PRODUCTS_FILTER_AUTOGENERATED_KEY ] = true;
		}

		if (
			in_array(
				$post_type_relationship_slug,
				array( self::QUERY_FILTER_INJECTION_RELATIONSHIP_SLUG_UP_SELLS, self::QUERY_FILTER_INJECTION_RELATIONSHIP_SLUG_CROSS_SELLS ),
				true
			)
		) {
			$post = get_post();

			if ( ! $post ) {
				$post = get_post( toolset_getnest( $view_data, array( 'general', 'parent_post_id' ), 0 ) );
			}

			if ( ! $post ) {
				return $view_settings;
			}

			if ( \WPV_Content_Template_Embedded::POST_TYPE === $post->post_type ) {
				$ct_preview_post = absint( get_post_meta( $post->ID, \WPV_Content_Template_Embedded::CONTENT_TEMPLATE_PREVIEW_POST_META_KEY, true ) );
				$post = get_post( $ct_preview_post );
			}

			$meta_key = self::QUERY_FILTER_INJECTION_RELATIONSHIP_SLUG_CROSS_SELLS === $post_type_relationship_slug ?
				self::WC_CROSS_SELLS_POST_META :
				self::WC_UP_SELLS_POST_META;

			$up_cross_sells = get_post_meta( $post->ID, $meta_key, true );

			$view_settings[ \WPV_View_Base::VIEW_SETTINGS_ID_FILTER_ID_IN_OR_OUT ] = 'in';
			$view_settings[ \WPV_View_Base::VIEW_SETTINGS_ID_FILTER_ID_MODE ] = array( 'by_ids' );
			$view_settings[ \WPV_View_Base::VIEW_SETTINGS_ID_FILTER_POST_ID_IDS_LIST ] = is_array( $up_cross_sells ) && ! empty( $up_cross_sells ) ? implode( ',', $up_cross_sells ) : '0';

			$view_settings_key = self::QUERY_FILTER_INJECTION_RELATIONSHIP_SLUG_CROSS_SELLS === $post_type_relationship_slug ?
				self::CROSS_SELLS_PRODUCTS_FILTER_AUTOGENERATED_KEY :
				self::UP_SELLS_PRODUCTS_FILTER_AUTOGENERATED_KEY;

			// Setting the following View Setting to true to mark that this query filter has been autogenerated, in order
			// to later adjust it's description and UI (remove "Edit" and "Delete" buttons).
			// Also this is going to be used to remove it from the list of offered query filters to be created.
			$view_settings[ $view_settings_key ] = true;
		}

		return $view_settings;
	}

	/**
	 * Determines if the auto-generated Query Filter is a "Related products" filter.
	 *
	 * @param string $filter_type
	 * @param array  $view_settings
	 *
	 * @return bool
	 */
	private function is_autogenerated_filter_for_related_products( $filter_type, $view_settings ) {
		return \WPV_Taxonomy_Filter::FILTER_TYPE === $filter_type && toolset_getarr( $view_settings, self::RELATED_PRODUCTS_FILTER_AUTOGENERATED_KEY, false );
	}

	/**
	 * Determines if the auto-generated Query Filter is a "Upsells products" filter.
	 *
	 * @param string $filter_type
	 * @param array  $view_settings
	 *
	 * @return bool
	 */
	private function is_autogenerated_filter_for_up_sells_products( $filter_type, $view_settings ) {
		return \WPV_ID_Filter::FILTER_TYPE === $filter_type && toolset_getarr( $view_settings, self::UP_SELLS_PRODUCTS_FILTER_AUTOGENERATED_KEY, false );
	}

	/**
	 * Determines if the auto-generated Query Filter is a "Cross-sells products" filter.
	 *
	 * @param string $filter_type
	 * @param array  $view_settings
	 *
	 * @return bool
	 */
	private function is_autogenerated_filter_for_cross_sells_products( $filter_type, $view_settings ) {
		return \WPV_ID_Filter::FILTER_TYPE === $filter_type && toolset_getarr( $view_settings, self::CROSS_SELLS_PRODUCTS_FILTER_AUTOGENERATED_KEY, false );
	}

	/**
	 * Determines if the Query Filter title controls will be hidden or not.
	 *
	 * Used to hide the controls for auto-generated Query Filters for Views listing WooCommerce Products.
	 *
	 * @param bool   $hide_filter_title_controls
	 * @param string $filter_type
	 * @param array  $view_settings
	 *
	 * @return bool
	 */
	public function maybe_hide_filter_title_controls( $hide_filter_title_controls, $filter_type, $view_settings ) {
		if (
			$this->is_autogenerated_filter_for_up_sells_products( $filter_type, $view_settings ) ||
			$this->is_autogenerated_filter_for_cross_sells_products( $filter_type, $view_settings ) ||
			$this->is_autogenerated_filter_for_related_products( $filter_type, $view_settings )
		) {
			return true;
		}

		return $hide_filter_title_controls;
	}

	/**
	 * Adjusts the title for auto-generated Query Filters for Views listing WooCommerce Products.
	 *
	 * @param string $title
	 * @param string $filter_type
	 * @param array  $view_settings
	 *
	 * @return string
	 */
	public function adjust_query_filter_title( $title, $filter_type, $view_settings ) {
		if ( $this->is_autogenerated_filter_for_up_sells_products( $filter_type, $view_settings ) ) {
			return __( 'Upsells filter', 'wpv-views' );
		}

		if ( $this->is_autogenerated_filter_for_cross_sells_products( $filter_type, $view_settings ) ) {
			return __( 'Cross-sells filter', 'wpv-views' );
		}

		if ( $this->is_autogenerated_filter_for_related_products( $filter_type, $view_settings ) ) {
			return __( 'Related products filter', 'wpv-views' );
		}

		return $title;
	}

	/**
	 * Adjusts the summary for auto-generated Query Filters for Views listing WooCommerce Products.
	 *
	 * @param string $summary
	 * @param string $filter_type
	 * @param array  $view_settings
	 *
	 * @return string
	 */
	public function adjust_query_filter_summary( $summary, $filter_type, $view_settings ) {
		if ( $this->is_autogenerated_filter_for_up_sells_products( $filter_type, $view_settings ) ) {
			return __( 'Filters only products marked as Upsells for the current product.', 'wpv-views' );
		}

		if ( $this->is_autogenerated_filter_for_cross_sells_products( $filter_type, $view_settings ) ) {
			return __( 'Filters only products marked as Cross-sells for the current product.', 'wpv-views' );
		}

		if ( $this->is_autogenerated_filter_for_related_products( $filter_type, $view_settings ) ) {
			return __( 'Filters only products that are related (same category or tags) with the current product.', 'wpv-views' );
		}

		return $summary;
	}
}
