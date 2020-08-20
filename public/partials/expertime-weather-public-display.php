<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/Salem-gg
 * @since      1.0.0
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/public/partials
 */
  get_header();
  do_shortcode("[render-expertime-weather]");
  get_footer();
?>
