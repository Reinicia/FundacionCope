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
	            'cat'=>34,
                'posts_per_page' => 9,
	            'paged' => $my_page
        );
	    $first_query = new WP_Query($args); // exclude category
        while($first_query->have_posts()) : $first_query->the_post();	
?>
       <div class="profes">
           <img class="img_profes" alt="<?php the_field('nombre_profesor'); ?>" src="<?php the_field('foto_profesor'); ?>"/>
           <h6><b><?php the_field('nombre_profesor'); ?></b></h6>
           <h6><?php the_field('cargo'); ?></h6>
           <a href="<?php the_field('url_linkedin'); ?>">
      			<img class="linkedin" src="http://www.linkedin.com/img/webpromo/btn_profile_bluetxt_80x15_es_ES.png?locale=" border="0" alt="Ver el perfil en LinkedIn">
           </a>
           <a class="enlace" title="<?php the_title();?>" href="<?php the_permalink();?>">+ Ver Más</a>
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
