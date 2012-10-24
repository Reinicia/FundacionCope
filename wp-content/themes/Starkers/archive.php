<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>
<div id="contenido">
	<div id="page">
		<div id="izq">
	<?php if ( have_posts() ) : ?>
		    <h1>
<?php if ( is_day() ) : ?>
				<?php printf( __( 'Archivos Diarios: %s', 'twentyten' ), get_the_date() ); ?>
<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Archivos Mensuales: %s', 'twentyten' ), get_the_date('F Y') ); ?>
<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Archivos Anuales: %s', 'twentyten' ), get_the_date('Y') ); ?>
<?php else : ?>
				<?php _e( 'Archivos del Blog', 'twentyten' ); ?>
<?php endif; ?>
			</h1>
            <?php while ( have_posts() ) : the_post(); ?>
            <h2 id="titulo-post"><?php the_title();?></h2>
            <?php the_excerpt();?>			
		
     		<?php endwhile; ?>
   	<?php endif; ?>
        </div>
        <div id="dcha">
        	<?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>