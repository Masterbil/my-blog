<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */

?>	
		</div> <!-- .main-area -->
		
		<?php get_sidebar('before-footer'); ?>
		<footer id="colophon" class="site-footer">

			<?php if ( '1' == stainedglass_get_theme_mod( 'is_show_footer_menu') ) : ?>

				<div id="footer-navigation" class="nav-container">
					<nav id="menu-4" class="horisontal-navigation" role="navigation">
						<span class="toggle"><span class="menu-toggle"></span></span>
						<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'nav-horizontal' ) ); ?>
					</nav><!-- #menu-4 .horisontal-navigation -->
					<div class="clear"></div>
				</div><!-- #footer-navigation .nav-container -->
				
			<?php endif; 
			if ( ( ! is_front_page() || '1' == stainedglass_get_theme_mod( 'is_home_footer' )) && ! is_page_template( 'page-templates/no-content-footer.php' ) )
				get_sidebar('footer');
			do_action('stainedglass_site_info'); ?>

		</footer><!-- #colophon -->
	</div><!-- #page -->
	<div class="background-fixed"></div>
	<div class="hide-screen-fixed"></div>
	<?php wp_footer(); ?>
</body>
</html>