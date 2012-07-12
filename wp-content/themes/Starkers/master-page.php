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
          		 jQuery("div.cont-central").hide();
          		 jQuery("div.cont-central").first().show();	
          		 jQuery('#nav > li > a').first().addClass('active'); 
          		 jQuery('#nav li div').first().addClass('flecha');
 				 jQuery('#nav > li > a').click(function(){
    			 if (jQuery(this).attr('class') != 'active'){
      					//jQuery('#nav li ul').slideUp();
      					//jQuery(this).next().slideToggle();
      					jQuery('#nav li a').removeClass('active');
      					jQuery(this).addClass('active');
      					jQuery('#nav li div').removeClass('flecha');
      					jQuery(this).next().addClass('flecha');
      					jQuery("div.cont-central").hide();
      					$valor = jQuery(this).attr('href');
      					jQuery($valor).show();	
    			}
  				});
			});
        </script>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
               
				<h1 class="title-page"><?php the_title(); ?></h1>
				<div id="izq">
			       <div id="navegacion">
				      <ul id="nav">
						  <li><a href="#cont1">Introducción</a><div></div>
						  </li>
						  <li><a href="#cont2">Programa</a><div></div>
						  </li>
						  <li><a href="#cont3">Profesorado</a><div></div>
						  </li>
						  <li><a href="#cont4">Prácticas</a><div></div>
						  </li>
						  <li><a href="#cont5">Solicitud de Información</a><div></div>
						  </li>
						  <li><a href="#cont6">Admisión</a><div></div>
						  </li>
		              </ul>
				    </div>
				    <div id="izq-central">
						<div class="cont-central" id="cont1"><?php the_field('introduccion');?></div>
						<div class="cont-central" id="cont2"><?php the_field('programa');?></div>
						<div class="cont-central" id="cont4"><?php the_field('practicas');?></div><br />
						<div class="cont-central" id="cont6"><?php the_field('admision');?></div>
						<div class="cont-central" id="cont3">				
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
                    	<div class="cont-central" id="cont5">
                    	<?php echo do_shortcode('[contact-form-7 id="85" title="Formulario Contacto Completo"]');?>
                        </div>
                   </div>
				</div>
<?php endwhile; ?>
        <div id="dcha">
        	<?php get_sidebar(); ?>
        </div>
	</div>
</div>
<?php get_footer(); ?>