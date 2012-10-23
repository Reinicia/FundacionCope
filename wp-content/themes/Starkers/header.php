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
	            <li><a title="Donde estamos" href="/donde-estamos-nuntii-escuela-cope">DONDE ESTAMOS</a><span> | </span></li>
	            <li><a href="/contacta">CONTACTO</a><span> | </span></li>
	            <li></li>
	            <li><a title="Facebook Nuntii Escuela" href="http://facebook.com/NuntiiEscuelaDeComunicacionDeLaFundacionCope" target="_blank"><img src="/images/facebook.png" alt="" width="20" height="20" /></a></li>
	            <li><a title="Twitter de Nuntii Escuela" href="http://twitter.com/nuntiiescuela" target="_blank"><img src="/images/twitter.png" alt="" width="20" height="20" /></a></li>
	        </ul>
        </div>
        <!-- Logo y Buscador -->
    	<div id="central">
    		<div id="logo">
    			<a href="/"><img src="/images/logocope.png" alt="" title=""/></a>
    		</div>
    		<div id="buscador">
    			<?php get_search_form(); ?>
    			<div id="informacion">
    				<img alt="Teléfono contacto" title="Telefono Contacto" src="/images/movil.png">
    				<span class="informate">LLAMANOS E INFORMATE:</span>
    				<span class="telf">918 283 930</span>
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
						<li><a href="/conocenos" title="Conocenos Nuntii Escuela">Quienes somos</a></li>
						<li><a>Claustro</a></li>
						<li><a>Consejo Académico</a></li>
					</ul>
		    	</li>
		    	<li><a href="/master-de-radio-cope" title="Master de Radio Cope" class="fNiv">MASTER RADIO</a></li>
		    	<li><a class="fNiv">PROGRAMAS</a>
		    		<ul>
						<li class="arrow"></li>
						<li><a href="/master-de-radio-cope" title="Master de Radio Cope">Masters</a></li>
						<li><a>Cursos Superiores</a>
							<ul>
								<li>
									<a href="/curso-superior-periodismo-deportivo-cope" title="Curso Superior de Periodismo Deportivo">Curso Superior de Periodismo Deportivo</a>
								</li>
								<li>
									<a href="/curso-superior-radio-musical-fundacion-cope" title="Curso Superior de Radio Musical">Curso Superior de Radio Musical</a>
								</li>
							</ul>
						</li>
						<li><a>PDP's</a>
							<ul>
								<li>
									<a href="/curso-pdp-creacion-argumentacion-discursos" title="Curso de Creación y Argumentación de Discursos">Curso de Creación y Argumentación de Discursos</a>
								</li> 
								<li>
									<a href="/curso-oratoria-comunicacion-eficaz-fabrica-discursos" title="Curso de Oratoria y Comunicación Eficaz">Curso de Oratoria y Comunicación Eficaz</a>
								</li>
								<li>
									<a href="/curso-pdp-comunicacion-crisis-cope" title="Curso de Comunicación de Crisis">Curso de Comunicación de Crisis</a>
								</li>
								<li>
									<a href="/curso-pdp-venta-negociacion-comercial-cope" title="Curso de Venta y Negociación Comercial">Curso de Venta y Negociación Comercial</a>
								</li>
							</ul>
						</li>
					</ul>
		    	</li>
		    	<li><a class="fNiv">IN COMPANY</a></li>
		    	<li><a href="/profesores" class="fNiv">PROFESORADO</a>
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
						<li><a href="/testimonios">Testimonios</a></li>
						<!--<li><a>Antiguos alumnos</a></li>
						<li><a>Bolsa de trabajo</a></li>-->
					</ul>
		    	</li>
		    	<li><a href="/noticias" title="Noticias" class="fNiv">NOTICIAS</a></li>
		    	<li><a href="/contacta" class="fNiv">CONTACTA</a></li>
			</ul>
		</div>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery("#jMenu").jMenu();
  })
</script>
    </div>