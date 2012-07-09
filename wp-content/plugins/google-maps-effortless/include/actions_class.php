<?php

/***********************************************************************
* Class: EGM_Actions
*
* The action hooks and helpers.
*
* The methods in here are normally called from an action hook that is
* called via the WordPress action stack.  
* 
* See http://codex.wordpress.org/Plugin_API/Action_Reference
*
************************************************************************/

if (! class_exists('EGM_Actions')) {
    class EGM_Actions {
        
        /******************************
         * PUBLIC PROPERTIES & METHODS
         ******************************/
        
        /*************************************
         * The Constructor
         */
        function __construct($params) {
        }
        
        /*************************************
         * method: wp_enqueue_scripts
         */
        function wp_enqueue_scripts() {
            global $egm_plugin;
            
            // If Google API Key Is Set, Pass It
            //
            $egmAPIKey = 'key=' . $egm_plugin->settings->get_item('api_key');
            if ($egmAPIKey == 'key=') {
                $egmAPIKey = '';
            }
            
            wp_register_script('google_maps',"http://maps.googleapis.com/maps/api/js?$egmAPIKey&sensor=true&hl=es");
            wp_register_script('effortless-gm',EGM_PLUGINURL . '/js/effortless-google-maps.js',array('jquery'));
        } 
        
        /*************************************
         * method: shutdown
         */
        function shutdown() {
            global $egm_plugin, $egmAttributes;
            
            // If we rendered a shortcode...
            //
            if ($egm_plugin->shortcode_was_rendered) {
                
                // Render Scripts
                //
                wp_enqueue_script('google_maps');    
                wp_enqueue_script('effortless-gm');
                
                // Render Styles
                //
                $egm_plugin->themes->assign_user_stylesheet($egmAttributes['theme']);                
                           
                // Force our scripts to load for badly behaved themes
                //
                wp_print_footer_scripts();                     
            }             
        } 
    }
}        
     

