<?php
/**
 * Template Name: Pagina Masters, no sidebar
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
		<script type="text/javascript">
           jQuery(document).ready(function () {
 				 jQuery('#nav > li > a').click(function(){
    			 if (jQuery(this).attr('class') != 'active'){
      					jQuery('#nav li ul').slideUp();
      					jQuery(this).next().slideToggle();
      					jQuery('#nav li a').removeClass('active');
      					jQuery(this).addClass('active');
    			}
  				});
			});
        </script>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<h1 class="title-page"><?php the_title(); ?></h1>
				<div id="contenido_central">
			       <div id="contenido_central_izq">
				     <?php the_content(); ?>
				   </div>
				</div>
				<div id="contenido_central_derecho">
					<div><?php the_field('introduccion');?></div>
					<div><?php the_field('programa');?></div>
					<div><?php the_field('practicas');?></div><br />
					<div><?php the_field('admision');?></div>
					<div>				
<?php $post_objects = get_field('profesores');
      
      if( $post_objects ): ?>
    <ul>
    <?php foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) ?>
        <?php setup_postdata($post); ?>
        <li>
           <img alt="" src="<?php the_field('foto_profesor'); ?>"/>
           <span><?php the_field('cargo'); ?></span>
           <p><?php the_content(); ?></p>
           <a href="<?php the_field('url_linkedin'); ?>">
      			<img src="http://www.linkedin.com/img/webpromo/btn_profile_bluetxt_80x15_es_ES.png?locale=" width="80" height="15" border="0" alt="Ver el perfil en LinkedIn">
           </a>
        </li>
    <?php endforeach; ?>
    </ul>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif;?>
                    </div>
                    <div>
                    	<?php echo do_shortcode('[contact-form-7 id="85" title="Formulario Contacto Completo"]');?>
                    </div>
				</div>
<?php endwhile; ?>
	</div>
</div>
<?php get_footer(); ?>