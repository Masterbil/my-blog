<?php
/**
 * The sidebar containing the footer widget area
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */

$hook_name = 'stainedglass_empty_sidebar_footer';
global $wp_filter;
if( ! isset($wp_filter[$hook_name]) && ! is_active_sidebar( 'sidebar-footer') )
	return;
?>

<div class="sidebar-footer small">
	<div class="widget-area">
		<?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
		
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>

		<?php else : ?>

				<?php do_action( $hook_name ) ?>
		
		<?php endif; ?>
	</div><!-- .widget-area -->
</div><!-- <!-- .sidebar-footer -->