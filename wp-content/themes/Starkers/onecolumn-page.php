<?php
/**
 * Template Name: One column, no sidebar
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

<div id="contenido">
	<div id="page">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<h1 class="title-page"><?php the_title(); ?></h1>
				<div id="contenido_central">
				     <?php the_content(); ?>
				</div>
<?php endwhile; ?>
	</div>
</div>
<?php get_footer(); ?>