<?php
/**
 * Pagina para mostrar la categoria Profesores y Subcategorias (Master, PDP'S, Cursos Superiores)
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
	            'category_name'=>'noticias',
                'posts_per_page' => 6,
	            'paged' => $my_page
        );
	    $first_query = new WP_Query($args); // exclude category
        while($first_query->have_posts()) : $first_query->the_post();	
?>		
        <h1 id="titulo-post"><?php the_title();?></h1>
        <?php the_excerpt();?>			
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