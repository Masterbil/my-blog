<?php
/**
 * The default template for displaying content for the jetpack portfolio
 *
 * Used for both single and index/archive/search
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */
 
$stainedglass_project = implode(stainedglass_get_curr_tax_ids('jetpack-portfolio-type'), ' ');
$stainedglass_tags = implode(stainedglass_get_curr_tax_ids('jetpack-portfolio-tag'), ' ');
?>
<div class="content-container jetpack-nav <?php echo esc_attr( $stainedglass_project.' '.$stainedglass_tags ); ?>">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
		
			<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
				<div class="element effect-1">
					<div class="entry-thumbnail">
						<?php the_post_thumbnail(); ?>
					</div><!-- .entry-thumbnail -->
																		
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="link-hover" rel="bookmark">
						<span class="link-button">
							<?php esc_html_e('Read more..', 'stainedglass'); ?>
						</span>
					</a>
						
				</div><!-- .element -->
			<?php endif;
			
			the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
			
			?>
			
		</header><!-- .entry-header -->

		<?php if( 'excerpt' == stainedglass_get_theme_mod('portfolio_style') ) : ?>
		
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
			
		<?php elseif( 'content' == stainedglass_get_theme_mod('portfolio_style') ) : ?>
		
			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
		
		<?php endif; ?>
		
		<footer class="entry-meta">
			
			<span class="project" title="<?php echo esc_attr(implode(stainedglass_get_curr_tax_names('jetpack-portfolio-type'), ', ')); ?>">
				<?php echo get_the_term_list( get_the_ID(), 'jetpack-portfolio-type'); ?>
			</span><!-- .project -->
			
			<span class="tag" title="<?php echo esc_attr(implode(stainedglass_get_curr_tax_names('jetpack-portfolio-tag'), ', ')); ?>">
			
			</span> <!-- .tags -->
			
			
			<?php edit_post_link( __( 'Edit', 'stainedglass' ), '<span title="'.__( 'Edit', 'stainedglass' ).'" class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
		
	</article><!-- #post -->
</div><!-- .content-container -->