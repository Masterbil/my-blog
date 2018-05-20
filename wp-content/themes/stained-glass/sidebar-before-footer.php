<?php
/**
 * The sidebar containing the before footer widget area.
 *
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */

$stainedglass_curr_slug = stainedglass_get_sidebar_slug();
$hook_name = 'stainedglass_empty_sidebar_before_footer-'.$stainedglass_curr_slug;
global $wp_filter;
if( ! isset( $wp_filter[ $hook_name ] ) && ! is_active_sidebar( 'sidebar-before-footer'.'-'.$stainedglass_curr_slug ) )
	return;
?>

<div class="sidebar-wrap">
	<div class="sidebar-before-footer wide">
		<div class="widget-area">
			<?php if ( is_active_sidebar( 'sidebar-before-footer'.'-'.$stainedglass_curr_slug ) ) : ?>
			
					<?php dynamic_sidebar( 'sidebar-before-footer'.'-'.$stainedglass_curr_slug ); ?>

			<?php else : ?>

					<?php do_action( $hook_name ) ?>
			
			<?php endif; ?>
		</div><!-- .widget-area -->
	</div><!-- .sidebar-before-footer .wide -->
</div><!-- .sidebar-wrap -->