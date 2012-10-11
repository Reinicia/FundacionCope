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
/**
 * Pagina para mostrar la categoria noticias
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
                'posts_per_page' => 1,
	            'paged' => $my_page
        );
	    var_dump($args);
	    $first_query = new WP_Query($args); // exclude category
	    var_dump($first_query); // exclude category
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