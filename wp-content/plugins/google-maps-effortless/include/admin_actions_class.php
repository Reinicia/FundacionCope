<?php

/***********************************************************************
* Class: EGM_Admin_Actions
*
* The action hooks and helpers.
*
* The methods in here are normally called from an action hook that is
* called via the WordPress action stack.  
* 
* See http://codex.wordpress.org/Plugin_API/Action_Reference
*
************************************************************************/

if (! class_exists('EGM_Admin_Actions')) {
    class EGM_Admin_Actions {
        
        /******************************
         * PUBLIC PROPERTIES & METHODS
         ******************************/
        
        /*************************************
         * The Constructor
         */
        function __construct($params) {
        } 
        
        
        function admin_init() {
            global $egm_plugin;
    
            // Then add our sections
            //
            $egm_plugin->settings->add_section(
                array(
                    'name'              => __('Info', EGM_PREFIX),
                    'description'       => __(
                        $egm_plugin->helper->get_string_from_phpexec(EGM_PLUGINDIR.'how_to_use.txt'),EGM_PREFIX),
                    'start_collapsed'   => false,
                )
            );
            
            // Then add our sections
            //
            $egm_plugin->settings->add_section(
                array(
                    'name'              => __('General Settings', EGM_PREFIX),
                    'description'       => __(
                        $egm_plugin->helper->get_string_from_phpexec(EGM_PLUGINDIR.'general_settings.txt'),EGM_PREFIX),
                    'start_collapsed'   => false,
                )
            );        
            
            $egm_plugin->settings->add_item(
                    __('General Settings', EGM_PREFIX), 
                    __('Google API Key', EGM_PREFIX), 
                    'api_key', 
                    'text', 
                    false,
                    __('Your Google API Key. This is optional.', EGM_PREFIX)
           );
            $egm_plugin->settings->add_item(
                    __('General Settings', EGM_PREFIX), 
                    __('Map Size', EGM_PREFIX), 
                    'size', 
                    'text', 
                    false,
                    __('The default size of the map(s).  If not set it will be 100%x400.', EGM_PREFIX)
           );
	   $egm_plugin->settings->add_item(
	   	   __('General Settings', EGM_PREFIX),
	   	   __('Default View', EGM_PREFIX),
	   	   'view',
	   	   'list',
	   	   false,
	   	   __('The type of map to display.', EGM_PREFIX),
	   	   array(
	   	   	   'Terrain View' => 'terrain',
	   	   	   'Road View' => 'roadmap',
	   	   	   'Satellite View' => 'satellite',
	   	   	   'Hybrid View' => 'hybrid'
	   	   )
	   );
	   $egm_plugin->settings->add_item(
	   	   __('General Settings', EGM_PREFIX),
	   	   __('Default Address', EGM_PREFIX),
	   	   'address',
	   	   'text',
	   	   false,
	   	   __('The default address.', EGM_PREFIX),
	   	   '359 Wando Place Drive, Suite D, Mount Pleasant, SC 29464'
	   );
	   	$egm_plugin->settings->add_item(
            __('General Settings', EGM_PREFIX),
            __('Use Location Sensor', EGM_PREFIX),
            'useSensor',
            'checkbox',
            false,
            __("Use the user's Location Sensor (if available) and offer directions to your location")
        );
        }
        
        /*************************************
         * method: admin_print_styles
         */
        function admin_print_styles() {
            if ( file_exists(EGM_PLUGINDIR.'css/admin.css')) {
                wp_enqueue_style('csl_egm_admin_css', EGM_PLUGINURL .'/css/admin.css'); 
            }               
        } 
    }
}        
     

