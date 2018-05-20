<?php
/**
 * The template for displaying front page
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */

get_header(); 
if( ! ( 'no_content' == stainedglass_get_theme_mod('front_page_style') && ! is_home()) ) :
	$stainedglass_layout = stainedglass_get_theme_mod('layout_home');
	if( is_home() )
		$stainedglass_layout_content = stainedglass_get_theme_mod('layout_blog_content');
	else 
		$stainedglass_layout_content = 'front_page';
	?>
	<div class="main-wrapper <?php echo esc_attr(stainedglass_content_class($stainedglass_layout_content)); ?> <?php echo esc_attr( $stainedglass_layout); ?> ">

		<div class="site-content"> 
		<?php
			if ( have_posts() ) : ?>
				<?php if ( is_home() ) : ?>
					<header class="archive-header">
						<h1 class="archive-title"><?php _e( 'Blog', 'stainedglass' ); ?></h1>
					</header><!-- .archive-header -->
				<?php endif; ?>
			
				<div class="content"> 

			<?php
				while ( have_posts() ) : the_post();

					if( is_page() ) :
						get_template_part( 'content', 'page' );
					else :
						get_template_part( 'content', stainedglass_get_content_prefix() );
					endif;
					
				endwhile; ?>
				
					<div class="content-search">
					<?php do_action( 'stainedglass_after_content' ); ?>
					</div><!-- .content-search -->
				</div><!-- .content -->
				<div class="clear"></div>
			
			<?php

				stainedglass_paging_nav();
				
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
	<?php
	stainedglass_get_sidebar( stainedglass_get_theme_mod( 'layout_home' ) );
	?>
	</div> <!-- .main-wrapper -->

	<?php
endif;
get_footer();