<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>
<?php
global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

foreach($query_args as $key => $string) {
	$query_split = explode("=", $string);
	$search_query[$query_split[0]] = urldecode($query_split[1]);
} // foreach

$search_query['posts_per_page']=6;
$search = new WP_Query($search_query);
?>
<div id="contenido">
	<div id="page">
<?php if ( $search->have_posts() ) : ?>
	            <h1 class="title-page"><?php printf( __( 'Search Results for: %s', 'twentyten' ), '' . get_search_query() . '' ); ?></h1>
				<?php while ($search->have_posts()) : $search->the_post(); ?>
                      <div class="post-search" id="post-<?php the_ID(); ?>">
	                      <h2 id="post-search-title"><a class="search" href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		                  <div class="entrytext">
							  <?php the_excerpt() ?>
		                  </div>
                      </div>	
                <?php endwhile; ?>
<?php else : ?>
	            <h1 class="title-page"><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></h1>
<?php endif; 
      wp_pagenavi(array( 'query' => $search ));
      wp_reset_query();
?>
	</div>
</div>
<?php get_footer(); ?>
