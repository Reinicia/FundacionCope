<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>
<div id="contenido">
	<div id="page">
<?php if ( have_posts() ) : ?>
	            <h1 class="title-page"><?php printf( __( 'Search Results for: %s', 'twentyten' ), '' . get_search_query() . '' ); ?></h1>
				<?php while (have_posts()) : the_post(); ?>
                      <div class="post-search" id="post-<?php the_ID(); ?>">
	                      <h2 id="post-search-title"><a class="search" href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		                  <div class="entrytext">
							  <?php the_excerpt() ?>
		                  </div>
                      </div>	
                <?php endwhile; ?>
<?php else : ?>
	            <h1 class="title-page"><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></h1>
<?php endif; ?>
	</div>
</div>
<?php get_footer(); ?>
