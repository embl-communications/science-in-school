<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('VF_Sis_Gutenberg_Settings') ) :

class VF_Sis_Gutenberg_Settings {

  function __construct() {
    add_action('acf/init', array($this, 'acf_init'));
  }

  /**
   * Action `acf/init`
   */
  function acf_init() {
  }

} // VF_Sis_Gutenberg_Settings

endif;

?>
