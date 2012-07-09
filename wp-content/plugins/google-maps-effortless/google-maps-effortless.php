<?php
/*
Plugin Name: Effortless Google Maps
Plugin URI: http://www.cybersprocket.com/products/effortless-google-maps/
Description: Put Google Maps on any page or post with a simple shortcode or widget.   100% free premium plugin. 
Version: 0.65
Author: Cyber Sprocket Labs
Author URI: http://www.cybersprocket.com
License: GPL3

Copyright 2012  Cyber Sprocket Labs (info@cybersprocket.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/


// Globals
global $egm_plugin;

// Drive Path Defines 
//
if (defined('EGM_PLUGINDIR') === false) {
    define('EGM_PLUGINDIR', plugin_dir_path(__FILE__));
}
if (defined('EGM_ICONDIR') === false) {
    define('EGM_ICONDIR', EGM_PLUGINDIR . 'images/icons/');
}

// URL Defines
//
if (defined('EGM_PLUGINURL') === false) {
    define('EGM_PLUGINURL', plugins_url('',__FILE__));
}
if (defined('EGM_ICONURL') === false) {
    define('EGM_ICONURL', EGM_PLUGINURL . 'images/icons/');
}
if (defined('EGM_ADMINPAGE') === false) {
    define('EGM_ADMINPAGE', admin_url() . 'admin.php?page=' . EGM_PLUGINDIR );
}

// The relative path from the plugins directory
//
if (defined('EGM_BASENAME') === false) {
    define('EGM_BASENAME', plugin_basename(__FILE__));
}

// Our product prefix
//
if (defined('EGM_PREFIX') === false) {
    define('EGM_PREFIX', 'csl-egm');
}

// Include our needed files
//
include_once(EGM_PLUGINDIR . 'include/config.php'   );
require_once(EGM_PLUGINDIR . 'include/actions_class.php');
require_once(EGM_PLUGINDIR . 'include/admin_actions_class.php');
require_once(EGM_PLUGINDIR . 'include/ui_class.php');
require_once(EGM_PLUGINDIR . 'include/egm_widget_class.php');


// Regular Actions
//
add_action('wp_enqueue_scripts' ,array('EGM_Actions','wp_enqueue_scripts')      );
add_action( 'widgets_init', create_function( '', 'register_widget( "egmWidget" );' ) );
add_action('shutdown'           ,array('EGM_Actions','shutdown')                );

// Admin Actions
//
add_action('admin_init'         ,array('EGM_Admin_Actions','admin_init')        );
add_action('admin_print_styles' ,array('EGM_Admin_Actions','admin_print_styles'));

// Short Codes
//
add_shortcode('effortless-gm'   ,array('EGM_UserInterface','render_shortcode')  );
add_shortcode('EFFORTLESS-GM'   ,array('EGM_UserInterface','render_shortcode')  );
add_shortcode('Effortless-GM'   ,array('EGM_UserInterface','render_shortcode')  );

// Text Domains
//
load_plugin_textdomain(EGM_PREFIX, false, EGM_BASENAME . '/languages/');
