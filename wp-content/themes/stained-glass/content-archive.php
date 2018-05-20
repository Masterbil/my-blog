<?php
/**
 * The default template for displaying content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */
?>
<div class="content-container">

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
			<?php endif; ?>
			
			<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>

		</header><!-- .entry-header -->
		
		<?php if( 'excerpt' == stainedglass_get_theme_mod('single_style') ) : ?>
			
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
				
		<?php elseif( 'content' == stainedglass_get_theme_mod('single_style') ) : ?>
			
			<div class="entry-content">
				<?php the_content( __('<div class="meta-nav">Continue reading... &rarr;</div>', 'stainedglass' )); ?>
			</div><!-- .entry-content -->
			
		<?php endif; ?>
		
		<footer class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : ?>

				<span class="post-date">
					<?php stainedglass_posted_on(); ?>
				</span>
				
			<?php endif; ?>
			<?php edit_post_link( __( 'Edit', 'stainedglass' ), '<span title="'. esc_url( __( 'Edit', 'stainedglass' ) ) .'" class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
		
	</article><!-- #post -->
	
</div><!-- .content-container -->