<div id="contenido">
	<div id="contenido_superior">
		<?php if (function_exists("easing_slider")){ easing_slider(); }; ?>
		<!-- Formulario de contacto -->
		<div id="contact_form">
			<H2 class="form-cabecera">¿Estás interesado?</H2>
			<p class="form-texto"><span>Recibe</span> más información sobre nuestros Masters, Cursos Superiores y PDP's.</p>
			<?php echo do_shortcode('[contact-form-7 id="55" title="Formulario de contacto 1"]');?>
		</div>
		<!-- Ahora sacamos los posts de una categoria que seran mostrados aqui -->
		<div class="limpia"></div>
		<script type="text/javascript">
           jQuery(function(){
  				jQuery('#slider1').bxSlider({
   					 displaySlideQty: 4,
    				 moveSlideQty: 1,
					 easing: 'easeInBack'
                });
           }); 
        </script>
        
        <div class="carousel">
        	<div class="bx-left">&nbsp;</div>
            <div class="bx-right">&nbsp;</div>
			<ul class="products-carousel" id="slider1">
<?php
	    $first_query = new WP_Query('cat=3'); // exclude category
        while($first_query->have_posts()) : $first_query->the_post();	
?>		
           <li class="item first">
				<div class="border"><a href="<?php the_permalink();?>" title="<?php the_field('titulo_carrousel');?>" class="product-image"><img alt="<?php the_field('titulo_carrousel');?>" src="<?php the_field('imagen_carrousel'); ?>"/></a>
					<h2 class="product-name"><a href="<?php the_permalink();?>" title="<?php the_field('titulo_carrousel');?>"><?php the_field('titulo_carrousel');?></a></h2>
					<p><?php the_excerpt(); ?></p>
				</div>
		   </li>
<?php
        endwhile;
        wp_reset_postdata();
?>
			</ul>
		</div>
		<div class="shadow">&nbsp;</div>
        <div class="limpia"></div>
		<!-- Fin del carrusel articulos de la categoria -->
		<div id="contenido_central">
			<div id="contenido_central_izq">
				<div id="contenido_central_azul">
<?php
	    $first_query = new WP_Query('cat=4&showposts=1'); // exclude category
        while($first_query->have_posts()) : $first_query->the_post();	
?>							
			    <h2><?php the_field('titulo_personalizado'); ?></h2>
			    <p><?php the_excerpt(); ?></p>
<?php
        endwhile;
        wp_reset_postdata();
?>				
                </div>
				<div id="contenido_central_blanco" style="padding-bottom:20px;">
					<h2 style="padding:5px 15px 0px 15px;">NOTICIAS NUNTII ESCUELA</h2>
<?php
	    $first_query = new WP_Query('cat=5&showposts=4'); // exclude category
        while($first_query->have_posts()) : $first_query->the_post();	
?>				
                    <div style="width:342px;height:100px;">			
					    <a href="<?php the_permalink();?>"><img style="float:left;margin:15px;" alt="" src="<?php the_field('imagen_noticia'); ?>"/></a>
					    <h1 style="font-size:12px;font-weight:bold;margin-top:15px;"><a href="<?php the_permalink();?>"><?php the_field('titulo_noticia'); ?></a></h1>
					    <p style="font-size:12px;margin-top:8px;color:#5561B0;"><?php the_field('resumen_noticia'); ?><a href="<?php the_permalink();?>" title="Mas informacion">Leer Más</a></p>
			        </div>
<?php
        endwhile;
        wp_reset_postdata();
?>		
                    <div style="width:342px;height:185px;">
						<img style="float:left;margin-top:20px;margin-right:15px;" src="/images/imgmicro.jpg" alt="" title=""/>
						<h2 style="margin-top:20px;">NUESTRO ARCHIVO SONORO</h2>
						<p>En ese apartado mostraremos el archivo sonoro de los trabajos realizados por los alumnos del Máster Universitario en Radio impartido por Nuntii Escuela.
		                </p>
				    </div>
				    <div style="margin-top:20px;">
				    	<h2 style="margin-left:15px;">CONOCE NUESTRA ESCUELA POR DENTRO</h2>
				    	<a href="galeria-de-fotos-nuntii-escuela"><img style="margin-left:15px;" alt="Fotos Escuela Nuntii" title="Fotos Escuela Nuntii" src="/images/galeria_home_1.jpg"/></a>
				    	<a href="galeria-de-fotos-nuntii-escuela"><img style="margin-left:15px;" alt="Fotos Escuela Nuntii" title="Fotos Escuela Nuntii" src="/images/galeria_home_2.jpg"/></a>
				    </div>
            	</div>					
			</div>
			<div id="contenido_central_derecho">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>