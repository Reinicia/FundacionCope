<?php

/***********************************************************************
* Class: EGM_UserInterface
*
* User Interface hooks and helpers.
*
* The shortcode and widget rendering.
*
************************************************************************/

if (! class_exists('EGM_UserInterface')) {
    class EGM_UserInterface {
        
        /******************************
         * PUBLIC PROPERTIES & METHODS
         ******************************/
        
        /*************************************
         * The Constructor
         */
        function __construct($params) {
        } 
        
        /*************************************
         * method: render_shortcode
         */
        function render_shortcode($params=null) {
            global $egm_plugin, $egmAttributes, $egmMaps, $egmIdCounter;
            
            $egm_plugin->shortcode_was_rendered = true;
            
            // stop at max maps
            //
            //$egmMaxMaps = get_option( "MaxMapsPerPage", 2);
            //if ($egmMaxMaps <= $egmIdCounter) return;
			
			$defView = $egm_plugin->settings->get_item('view');

            // Set the attributes, default or passed in shortcode
            //
            $defSize = $egm_plugin->settings->get_item('size','100%x400');
            $egmAttributes = shortcode_atts(
                array(
                    'address'   => $egm_plugin->settings->get_item('address'),
                    'size'      => ((trim($defSize)=='')?'100%x400':$defSize),
                    'theme'     => $egm_plugin->settings->get_item('theme'),
                    'zoom'      => '12',
                    'view'	=> ((trim($defView)=='')?'roadmap':$defView),
                    'disableUI' => $egm_plugin->settings->get_item('disableUI'),
                    'useSensor' => $egm_plugin->settings->get_item('useSensor'),
                    'name' => $egm_plugin->settings->get_item('address'),
                    ), 
                $params
                );
            
            // Size is the width x height, split it...
            //
            list($egmWidth,$egmHeight) = (split('x',$egmAttributes['size']));
            $egmWidth  = EGM_UserInterface::CheckDimensions($egmWidth);
            $egmHeight = EGM_UserInterface::CheckDimensions($egmHeight);
            
            //set the egmID
            //
            if (!isSet($egmIdCounter)) $egmIdCounter = 0;
            $egmID = $egmIdCounter++;
                   
            // Keep stuff in range
            //
            $egmZoom = EGM_UserInterface::manageZoom($egmAttributes['zoom']);

            // Prep our new stuff for passing to the script            
            $egmAttributes = array_merge($egmAttributes,
                array(
                    'width'     => $egmWidth,
                    'height'    => $egmHeight,
                    'zoom'      => $egmZoom,
                    'id'	=> $egmID,
                    )
                );
            
            //adds the map to the map list
            $egmMaps[] = $egmAttributes;
            
            // Lets get some variables into our script
            //
            wp_localize_script('effortless-gm','egmMaps',$egmMaps);
            
            // Render the map div
            //
            return '<div class="'.$egm_plugin->settings->get_item('theme').'" id="canvas'.$egmID.'" style="width:'.$egmWidth.'; height:'.$egmHeight.'"></div>';
            
        }
        
        /*************************************
         * private method: manageZoom
         *
         * Allow for certain keywords to be used on zoom:
         *      world = zoom way out
         *      street = moderate zoom
         *      house = tight zoom
         *
         */
        function manageZoom($value) {
            $newNumber = $value;
            switch ($value) {
                case 'world':
                    $newNumber = '1';                    
                    break;
                case 'country':
                    $newNumber='3';
                    break;                                        
                case 'region':
                    $newNumber='5';
                    break;                                        
                case 'state':
                    $newNumber='7';
                    break;                                        
                case 'county':
                    $newNumber='9';
                    break;                                        
                case 'street':
                    $newNumber='15';
                    break;                    
                case 'house':
                    $newNumber='18';
                    break;                    
            }
            return EGM_UserInterface::CleanNumber($newNumber,0,20);
        }
        
        
        /*************************************
         * private method: checkDimensions
         *
         * If the number has a % in it, keep that suffix, otherwise assume 'px'.
         *
         * Then make sure we strip out all non-digits from the string.
         *
         * Then we check bounds, 0 - 100 for % and 0 - 9999 for px.
         *
         */
        function checkDimensions($value) {
            $suffix = 
                (substr_compare($value, '%', -strlen('%'), strlen('%')) === 0) ? 
                    '%' : 
                    'px';
            $value = preg_replace('/\D/','',$value);
            
            if ($suffix == 'px') {
                $value = max(min($value,9999),0);
            } else {
                $value = max(min($value,100),0);
            }            
            return  $value . $suffix; 
        }
        
        /*************************************
         * private method: cleanNumber
         *
         * Make sure we strip out all non-digits from the string.
         *
         * Then we check bounds as noted.
         *
         */
        function cleanNumber($value,$min=0,$max=100) {
            $value = preg_replace('/\D/','',$value);
            return max(min($value,$max),$min);
        }        
    }
}        
     

