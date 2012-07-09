<?php

if (! class_exists('EGM_Activate')) {
    class EGM_Activate {
        
        /******************************
         * PUBLIC PROPERTIES & METHODS
         ******************************/
        
        /*************************************
         * The Constructor
         */
        function __construct($params = null) {
            // Do the setting override or initial settings.
            //
            foreach ($params as $name => $value) {
                $this->$name = $value;
            }
        } 
        
        /* TEST FUNCTION */
        function testMe() {
            //:) does not exist
            if (get_option($this->plugin->prefix.'-lobby') == '') {
                update_option($this->plugin->prefix.'-lobby', 'Hello');
            }
            // ;) already exists
            update_option($this->plugin->prefix.'-lobby', 'PEANUTS');
        }
        
        /*************************************
         * Updates the plugin
         */
        function update($slplus_plugin, $old_version) {
            $updater = new EGM_Activate(array(
                'plugin' => $slplus_plugin,
                'old_version' => $old_version,
            ));
            $updater->testMe();
        }
    }
}