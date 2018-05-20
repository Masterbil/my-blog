<?php
/**
 * The sidebar containing the top widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 */
 
$stainedglass_curr_slug = stainedglass_get_sidebar_slug();
$hook_name = 'stainedglass_empty_sidebar_top-'.$stainedglass_curr_slug;
global $wp_filter;
if( ! isset( $wp_filter[ $hook_name ] ) && ! is_active_sidebar( 'sidebar-top'.'-'.$stainedglass_curr_slug ) )
	return;
?>

<div id="sidebar-1" class="sidebar-top-full wide">
	<div class="widget-area">
			<?php if ( is_active_sidebar( 'sidebar-top'.'-'.$stainedglass_curr_slug ) ) : ?>
			
					<?php dynamic_sidebar( 'sidebar-top'.'-'.$stainedglass_curr_slug ); ?>

			<?php else : ?>

					<?php do_action( $hook_name ); ?>
			
			<?php endif; ?>
	</div><!-- .widget-area -->
</div><!-- .sidebar-top-full -->
