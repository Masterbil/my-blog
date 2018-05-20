<?php
/**
 * The template for displaying Category pages
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */

get_header(); 
$stainedglass_layout = stainedglass_get_theme_mod( 'layout_portfolio' );
$stainedglass_layout_content = stainedglass_get_theme_mod( 'layout_portfolio_content' );
?>
<div class="main-wrapper <?php echo esc_attr(stainedglass_content_class( $stainedglass_layout_content ) ); ?> <?php echo esc_attr( $stainedglass_layout ); ?> ">

	<div class="site-content">
	<?php
		if ( have_posts() ) : ?>
		
			<header class="archive-header">
				<h1 class="archive-title"><?php _e( 'All Projects', 'stainedglass' ); ?></h1>
			</header><!-- .archive-header -->
		
			<div class="content"> 

		<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'content', 'jetpack-portfolio-archive' );
				
			endwhile; ?>
			</div><!-- .content -->
			<div class="clear"></div>
		
			<?php stainedglass_paging_nav();?>
			
			<div class="content-search">
				<?php do_action( 'stainedglass_after_content' ); ?>
			</div><!-- .content-search -->

			
		<?php else : ?>
			<div class="content"> 
			<?php 
				get_template_part( 'content', 'none' );
			?>
			
			</div><!-- .content -->
		<?php 
		endif;
?>
	</div><!-- .site-content -->
	<?php stainedglass_get_sidebar( stainedglass_get_theme_mod( 'layout_portfolio' ) ); ?>
</div> <!-- .main-wrapper -->

<?php
get_footer();