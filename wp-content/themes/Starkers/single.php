<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>
<div id="contenido">
	<div id="page">
		<div id="izq">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <h1 id="titulo-post"><?php the_title();?></h1>
        <div class="contenido-post"><?php the_content();?></div>
<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
        </div>
        <div id="dcha">
        	<?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>