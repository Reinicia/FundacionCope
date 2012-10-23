<?php

function add_advanced_recent_posts_widget_stylesheet() {
		$plugin_dir = 'advanced-recent-posts-widget';
		if ( @file_exists( STYLESHEETPATH . '/advanced-recent-posts-widget.css' ) )
			$mycss_file = get_stylesheet_directory_uri() . '/advanced-recent-posts-widget.css';
		elseif ( @file_exists( TEMPLATEPATH . '/advanced-recent-posts-widget.css' ) )
			$mycss_file = get_template_directory_uri() . '/advanced-recent-posts-widget.css';
		else
			$mycss_file = plugins_url( 'css/advanced-recent-posts-widget.css',dirname(__FILE__) );
			
	    
	        wp_register_style( 'wp-advanced-rp-css', $mycss_file );
	        wp_enqueue_style( 'wp-advanced-rp-css' );
	   
}
add_action('wp_print_styles', 'add_advanced_recent_posts_widget_stylesheet');



?>