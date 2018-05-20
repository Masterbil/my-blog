<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */
get_header(); 
$stainedglass_layout = stainedglass_get_theme_mod('layout_portfolio_page');
?>
<div class="main-wrapper <?php echo esc_attr( $stainedglass_layout); ?> ">

	<div class="site-content"> 
			<?php
				if ( have_posts() ) : ?>
				
					<div class="content"> 

				<?php
					while ( have_posts() ) : the_post();

						get_template_part( 'content', 'jetpack-portfolio' );
						
					endwhile; ?>
					
					</div><!-- .content -->
					<div class="clear"></div>
				
				<?php

					stainedglass_post_nav();

					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;	
				
				else :  
				?>
					<div class="content"> 
					<?php 
						get_template_part( 'content', 'none' );
					?>
					
					</div><!-- .content -->
				<?php 
				endif;
?>
	</div><!-- .site-content -->
	<?php stainedglass_get_sidebar( stainedglass_get_theme_mod( 'layout_portfolio_page' ) ); ?>
</div> <!-- .main-wrapper -->
<?php
get_footer();
