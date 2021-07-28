<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('SIS_Info_Box') ) :

// sis-info-box

  require_once('widget.php');
class SIS_Info_Box extends VFWP_Block {

  public function __construct() {
    parent::__construct(__FILE__);
  }

  /**
   * Return the block name
   */
  static public function get_name() {
    return 'vfwp-sis-info-box';
  }

  /**
   * Return Gutenberg block registration configuration
   * https://www.advancedcustomfields.com/resources/acf_register_block_type/
   * https://developer.wordpress.org/block-editor/developers/block-api/block-registration/
   */
  public function get_config() {
    return array(
      'name'     => $this->get_name(),
      'title'    => 'SiS Info Box',
      'category' => 'vf/wp',
      'supports' => array(
        'align'           => false,
        'customClassName' => false
      )
    );
  }

} // SIS_Info_Box

// Initialize one instance
$SIS_Info_Box = new SIS_Info_Box();

endif; ?>
