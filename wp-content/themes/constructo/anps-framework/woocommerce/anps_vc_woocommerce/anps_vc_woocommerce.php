<?php
/*
Plugin Name: WooCommerce shortcodes for Visual Composer
Plugin URI: http://www.anpsthemes.com
Description: A simple plugin that will activate WooCommerce shortcodes in your Visual Composer.
Author: Anpsthemes
Version: 1.2
Author URI: http://www.anpsthemes.com
*/
if(!defined('WPINC')) {
    die;
}
define("ANPS_PLUGIN_LANG", "vc_woo_shortcodes");
/* shortcodes */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
add_action("init", "init_shortcodes");
add_action("admin_init","init_style");

function init_shortcodes() {
    include_once 'shortcodes.php';
}
function init_style() {
    wp_enqueue_style( 'vc_icons', plugins_url("assets/css/vc_custom.css", __FILE__) );
}