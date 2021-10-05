<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('VF_Widget_Sis_Info_Box') ) :

class VF_Widget_Sis_Info_Box extends WP_Widget {

  public function __construct() {
    parent::__construct(
      'vf_widget_sis_info_box',
      __('SiS Info box (deprecated)', 'vfwp')
    );
  }

  /**
   * Render the plugin using the widget ACF data
   */
  public function widget($args, $instance) {

    
// widget ID with prefix for use in ACF API functions
$widget_id = 'widget_' . $args['widget_id'];

$heading = get_field('heading', $widget_id);
$text = get_field('text', $widget_id);
$text = wpautop($text);
$text = str_replace('<p>', '<p class="vf-box__text">', $text);
$link = get_field('link', $widget_id);


$style = get_field('style', $widget_id);

if (is_array($style)) {
  $style = $style[0];
}

$classes = "vf-box sis-info-box";

if ($link) {
  $classes .= " vf-box--is-link";
}

if ($style === 'safety') {
$classes .= " sis-info-box--{$style}";
}

?>

<div class="<?php echo esc_attr($classes); ?>">
  <?php if (! empty($heading)) { ?>
    <h3 class="vf-box__heading">
      <?php } if ($link) { ?>
        <a class="vf-box__link" href="<?php echo esc_url($link['url']); ?>">
          <?php } ?>
          <?php echo esc_html($heading); ?>
        <?php if ($link) { ?>
        </a>
        <?php }  ?>
      <?php if (! empty($heading)) { ?>
    </h3> 
      <?php } ?>
  <?php echo ($text); ?>
</div>

<?php
  }

  public function form($instance) {
    // Do nothing...
  }

} // VF_Widget_Sis_Info_Box

endif;

/**
 * Register Box Widget
 */
function register_sis_info_box_widget()
{
  register_widget( 'VF_Widget_Sis_Info_Box' );
}
add_action( 'widgets_init', 'register_sis_info_box_widget' ); ?>
