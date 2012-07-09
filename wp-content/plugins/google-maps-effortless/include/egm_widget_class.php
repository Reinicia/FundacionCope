<?php

/***********************************************************************
* Class: egmWidget
*
* The custom egm widget.
*
* 
* See http://codex.wordpress.org/Widgets_API
*
************************************************************************/

class egmWidget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		EGM_PREFIX.'_widget', // Base ID
			__('Effortless Google Map',EGM_PREFIX), // Name
			array( 
			    'description' => __( 'Add a Google Map to any widget box location.', EGM_PREFIX ), 
			    ) 
		);
	}

 	public function form( $instance ) {
		print $this->formatFormEntry($instance, 'address' , __( 'Address:', EGM_PREFIX)   ,''); 
		print $this->formatFormEntry($instance, 'size'    , __( 'Size:', EGM_PREFIX)      ,''); 
		print $this->formatFormEntry($instance, 'zoom'    , __( 'Zoom:', EGM_PREFIX)      ,'');
    }

	public function update( $new_instance, $old_instance ) {
		
		return $new_instance;
	}

	public function widget( $args, $instance ) {
	    if (isset($instance['address']) && (trim($instance['address'])=='')) {
	        unset($instance['address']);
	    }
	    	
		print EGM_UserInterface::render_shortcode($instance);
	}
	
	private function formatFormEntry($instance, $id,$label,$default) {
	    $fldID = $this->get_field_id( $id );
	    $content= '<p>'.
            '<label for="'.$fldID.'">'.$label.'</label>'. 
            '<input class="widefat" type="text" '.  
                'id="'      .$fldID                                                     .'" '. 
                'name="'    .$this->get_field_name( $id )                               .'" '. 
                'value="'   .esc_attr( isset($instance[$id])?$instance[$id]:$default )  .'" '. 
                '/>'.
             '</p>';
        return $content;             
	}

}
