<?php
/**
 * Pagina para mostrar la categoria Profesores y Subcategorias (Master, PDP'S, Cursos Superiores)
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

				<h1><?php
					printf( __( 'Category Archives: %s', 'twentyten' ), '' . single_cat_title( '', false ) . '' );
				?></h1>
				<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo '' . $category_description . '';

				/* Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				get_template_part( 'loop', 'category' );
				?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>