<?php
/**
 * The template for displaying the header
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
			<!-- Header -->
			<?php $defaults = stainedglass_get_defaults(); ?>

			<header id="masthead" class="site-header" role="banner">	

				<div class="top-menu">
					<div id="sg-site-header" class="sg-site-header sticky-menu">
						<?php if ( '' != stainedglass_get_theme_mod( 'logotype_url' ) ) : ?>
							<div class="logo-block">
								<a class="logo-section" href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
									<img src='<?php echo esc_url( stainedglass_get_theme_mod( 'logotype_url' ) ); ?>' class="logo" alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
								</a><!-- .logo-section -->
							</div><!-- .logo-block -->
						<?php endif; ?>
						
						<div class="menu-top">
							<!-- First Top Menu -->		
							<div class="nav-container top-1-navigation">						
								<?php if ( stainedglass_get_theme_mod( 'is_show_top_menu' ) == '1' ) : ?>
									<nav class="horisontal-navigation menu-1" role="navigation">
										<span class="toggle"><span class="menu-toggle"></span></span>
										<?php wp_nav_menu( array( 'theme_location' => 'top1', 'menu_class' => 'nav-horizontal' ) ); ?>
									</nav><!-- .menu-1 .horisontal-navigation -->
								<?php endif; ?>
								<div class="clear"></div>
							</div><!-- .top-1-navigation .nav-container -->

							<!-- Second Top Menu -->	
							<?php if ( '1' == stainedglass_get_theme_mod( 'is_show_secont_top_menu') ) : ?>

								<div class="nav-container top-navigation">
									<nav class="horisontal-navigation menu-2" role="navigation">
										<span class="toggle"><span class="menu-toggle"></span></span>
										<?php wp_nav_menu( array( 'theme_location' => 'top2', 'menu_class' => 'nav-horizontal' ) ); ?>
									</nav><!-- .menu-2 .horisontal-navigation -->
									<div class="clear"></div>
								</div><!-- .top-navigation.nav-container -->
								
							<?php endif; ?>
						</div><!-- .menu-top  -->
					</div><!-- .sg-site-header -->
				</div><!-- .top-menu -->
				
				<!-- Banner -->
				<?php if ( get_header_image() 
							&& ( get_theme_mod( 'is_header_on_front_page_only', $defaults['is_header_on_front_page_only'] ) != '1' || is_front_page())) : ?>		
			
					<div class="image-container">
						<div class="image-wrapper">
						
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<img src="<?php header_image(); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
							</a>				

							<div class="element-wrap">
							
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
								<!-- Dscription -->
								<h2 class="site-description"><?php echo bloginfo( 'description' ); ?></h2>
								
							</div><!-- .element-wrap -->
					
						</div>
					</div>
					
				<?php 
				endif;?>
			</header><!-- #masthead -->
			<div class="sg-header-area">
				<div class="header-wrap">
				
					<?php get_sidebar('top'); ?>
				
				</div><!-- .header-wrap -->
			</div><!-- .sg-header-area -->

		<div class="main-area">