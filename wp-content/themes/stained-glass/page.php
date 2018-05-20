<?php
/**
 * The template for displaying all pages
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */

get_header(); 
?>
<div class="main-wrapper <?php echo esc_attr(stainedglass_get_theme_mod('layout_page') ); ?> ">

	<div class="site-content"> 
<?php
	if ( have_posts() ) : ?>
	
		<div class="content"> 

	<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'content', 'page' );	
			
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			
		endwhile; ?>
		
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
	stainedglass_get_sidebar( stainedglass_get_theme_mod('layout_page') );
	?>
</div> <!-- .main-wrapper -->

<?php
get_footer();
