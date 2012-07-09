<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
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
<?php get_sidebar(); ?>
<?php get_footer(); ?>