<?php
/**
 * The template for displaying search results
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */

get_header(); 
$stainedglass_layout = stainedglass_get_theme_mod('layout_archive');
$stainedglass_layout_content = stainedglass_get_theme_mod('layout_archive_content');
?>
<div class="main-wrapper <?php echo esc_attr(stainedglass_content_class($stainedglass_layout_content)); ?> <?php echo esc_attr( $stainedglass_layout); ?> ">

	<div class="site-content">
			<?php
				if ( have_posts() ) : 
					?>
					<header class="archive-header">
						<h1 class="archive-title"><?php printf( __( 'Search results for: %s', 'stainedglass' ), esc_html( get_search_query().' ('.$wp_query->found_posts.')') ); ?></h1>
					</header><!-- .archive-header -->
				
					<div class="content"> 

				<?php
					while ( have_posts() ) : the_post();

						get_template_part( 'content', stainedglass_get_content_prefix() );
						
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
					<div class="clear"></div>
				<?php 
				endif;
?>
	</div><!-- .site-content -->
	<?php
	stainedglass_get_sidebar( stainedglass_get_theme_mod('layout_archive') );
	?>
</div> <!-- .main-wrapper -->

<?php
get_footer();