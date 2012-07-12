<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 * We filter the output of wp_title() a bit -- see
	 * twentyten_filter_wp_title() in functions.php.
	 */
	wp_title( '|', true, 'right' );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
    <div id="cabecera">
    	<!--Menu superior + redes sociales -->
    	<div id="sup">
	    	<ul>
	            <li><a title="Donde estamos" href="/donde-estamos">DONDE ESTAMOS</a><span> | </span></li>
	            <li><a href="">CONTACTO</a><span> | </span></li>
	            <li><a href="">SIGUENOS</a></li>
	            <li><a title="" href="/"><img src="/images/facebook.png" alt="" width="20" height="20" /></a></li>
	            <li><a title="" href="/"><img src="/images/twitter.png" alt="" width="20" height="20" /></a></li>
	        </ul>
        </div>
        <!-- Logo y Buscador -->
    	<div id="central">
    		<div id="logo">
    			<img src="/images/logocope.png" alt="" title=""/>
    		</div>
    		<div id="buscador">
    			<?php get_search_form(); ?>
    			<div id="informacion">
    				<img alt="Teléfono contacto" title="Telefono Contacto" src="/images/movil.png">
    				<span class="informate">LLAMANOS E INFORMATE:</span>
    				<span class="telf">913219386</span>
    			</div>
    		</div>
    	</div>
    	<br class="clear"/>
    	<div id="menu">
	    	<ul id="jMenu">
	    		<li class="first" >
					<a title="" href="/"><img src="/images/iconohome.png" alt="Home" title="Home" width="20" height="17" /></a>
				</li>
             	<li><a class="fNiv">CONOCENOS</a>
		    		<ul>
						<li class="arrow"></li>
						<li><a>Quienes somos</a></li>
						<li><a>Claustro</a></li>
						<li><a>Consejo Académico</a></li>
					</ul>
		    	</li>
		    	<li><a class="fNiv">MASTER RADIO</a></li>
		    	<li><a class="fNiv">PROGRAMAS</a>
		    		<ul>
						<li class="arrow"></li>
						<li><a>Masters</a></li>
						<li><a>Cursos Superiores</a></li>
						<li><a>PDP's</a></li>
					</ul>
		    	</li>
		    	<li><a class="fNiv">IN COMPANY</a></li>
		    	<li><a class="fNiv">PROFESORADO</a>
		    		<ul>
						<li class="arrow"></li>
						<li><a>Masters</a></li>
						<li><a>Cursos Superiores</a></li>
						<li><a>PDP's</a></li>
					</ul>
		    	</li>
		    	<li><a class="fNiv">ALUMNOS</a>
		    		<ul>
						<li class="arrow"></li>
						<li><a>Testimonios</a></li>
						<li><a>Antiguos alumnos</a></li>
						<li><a>Bolsa de trabajo</a></li>
					</ul>
		    	</li>
		    	<li><a href="/noticias" title="Noticias" class="fNiv">NOTICIAS</a></li>
		    	<li><a class="fNiv">CONTACTA</a></li>
			</ul>
		</div>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery("#jMenu").jMenu();
  })
</script>
    	<!--
    	<div id="menu">
    				<ul>
						<li class="first" >
							<a title="" href="/"><img src="/images/iconohome.png" alt="Home" title="Home" width="20" height="17" /></a>
						</li>
						<li class="first">
							<a href="">CONOCENOS</a><span></span>
							<ul>
								 <li><a href="#">Jubilaci&oacute;n</a></li>
								 <li><a href="#">Pensi&oacute;n</a></li>
								 <li><a href="#">Jubilaci&oacute;n por invalidez</a></li>
								 <li><a href="#">Jubilaci&oacute;n por edad avanzada</a></li>
							</ul>
						</li>
						<li>
							<a href="">MASTER RADIO</a><span></span>
						</li>
						<li>
							<a href="">PROGRAMAS</a><span></span>
						</li>
						<li>
							<a href="">PROFESORADO</a><span></span>
						</li>
						<li>
							<a href="">ADMISION</a><span></span>
						</li>
						<li>
							<a href="">ALUMNOS</a><span></span>
						</li>
						<li>
							<a href="">NOTICIAS</a><span></span>
						</li>
						<li>
							<a href="">CONTACTA</a><span></span>
						</li>
						<li>
							<a href="">FUNDACION COPE</a>
						</li>
					</ul>
    		
    	</div>
    	-->
    </div>