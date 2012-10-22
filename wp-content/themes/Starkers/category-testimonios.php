<?php
/**
 * Pagina para mostrar la categoria testimonios
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */
get_header(); ?>
<div id="contenido">
	<div id="page">
		<div id="izq">
<?php
        global $paged;
		if( get_query_var( 'paged' ) )
			$my_page = get_query_var( 'paged' );
		else {
			if( get_query_var( 'page' ) )
			$my_page = get_query_var( 'page' );
		    else
			$my_page = 1;
		    set_query_var( 'paged', $my_page );
		    $paged = $my_page;
		}

// default loop here, if applicable, followed by wp_reset_query();
    
        $args = array(
	            'category_name'=>'testimonios',
                'posts_per_page' => 6,
	            'paged' => $my_page
        );
	    $first_query = new WP_Query($args); // exclude category
        while($first_query->have_posts()) : $first_query->the_post();	
?>		
        <div class="testimonios">
           <img class="img_testimonios" alt="<?php the_field('nombre_y_apellidos'); ?>" src="<?php the_field('foto_alumno'); ?>"/>
           <div class="testimonios_cuerpo">
           		<h6><b><?php the_field('nombre_y_apellidos'); ?></b></h6>
           		<h6><?php the_field('master_cursado'); ?></h6>
<?php if (function_exists("insert_audio_player")) {  
               insert_audio_player("[audio:".the_field('fichero_de_audio_ivoox')."]");  
} ?>  
           		<!--<p class="clear"><?php the_field('entradilla'); ?></p>-->
           	</div>
        </div>	
<?php
        endwhile;
		wp_pagenavi(array( 'query' => $first_query ));
        wp_reset_query();
?>

        </div>
        <div id="dcha">
        	<?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>