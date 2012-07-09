<?php

/**
 * We need the generic WPCSL plugin class, since that is the
 * foundation of much of our plugin.  So here we make sure that it has
 * not already been loaded by another plugin that may also be
 * installed, and if not then we load it.
 */
if (defined('EGM_PLUGINDIR')) {
    if (class_exists('wpCSL_plugin__egm') === false) {
        require_once(EGM_PLUGINDIR.'WPCSL-generic/classes/CSL-plugin.php');
    }
    
    /**
     * This section defines the settings for the admin menu.
     */ 
    global $egm_plugin;
    $egm_plugin = new wpCSL_plugin__egm(
        array(
            'prefix'                => EGM_PREFIX,
            'name'                  => 'Effortless Google Maps',
            'sku'                   => 'EGMS',
            
            'url'                   => 'http://www.cybersprocket.com/products/effortless-google-maps/',            
            'support_url'           => 'http://www.cybersprocket.com/products/effortless-google-maps/',

            // Nag menu
            //
            'rate_url'              => 'http://wordpress.org/extend/plugins/google-maps-effortless/',
            'forum_url'             => 'http://redmine.cybersprocket.com/projects/commercial-products/boards/41',
            'version'               => '0.65',
            
            'basefile'              => EGM_BASENAME,
            'plugin_path'           => EGM_PLUGINDIR,
            'plugin_url'            => EGM_PLUGINURL,
            'cache_path'            => EGM_PLUGINDIR . 'cache',
            
            // We don't want default wpCSL objects, let's set our own
            //
            'use_obj_defaults'      => false,
            
            'cache_obj_name'        => 'none',
            'license_obj_name'      => 'none',            
            'products_obj_name'     => 'none',
            
            'helper_obj_name'       => 'default',
            'notifications_obj_name'=> 'default',
            'settings_obj_name'     => 'default',
            
            // Themes and CSS
            //
            'themes_obj_name'       => 'default',
            'themes_enabled'        => 'true',
            'css_prefix'            => 'csl_themes',
            'css_dir'               => EGM_PLUGINDIR . 'css/',
            'no_default_css'        => true,
            
            // Custom Config Settings
            //
            'display_settings_collapsed'=> false,
            'show_locale'               => false,            
            'uses_money'                => false,            
            'has_packages'              => false,            
            
            'driver_type'           => 'none',
            'driver_args'           => array(
                    'api_key'   => get_option(EGM_PREFIX.'-api_key'),
                    ),
        )
    );   
}    

