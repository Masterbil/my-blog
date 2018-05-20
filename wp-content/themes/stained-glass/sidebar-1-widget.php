<?php
/**
 * The sidebar containing the main widget area for the widget page
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */

global $stainedglass_curr_page_id;
$stainedglass_curr_slug = stainedglass_get_page_sidebar_slug( $stainedglass_curr_page_id );
$hook_name = 'stainedglass_empty_column_1-'.$stainedglass_curr_slug;

?>
<div class="sidebar-1">
	<div class="column small">		
		<div class="widget-area recurs">
		<?php if ( is_active_sidebar( 'column-1'.'-'.$stainedglass_curr_slug ) ) : ?>
		
				<?php dynamic_sidebar( 'column-1'.'-'.$stainedglass_curr_slug ); ?>

		<?php else : ?>

				<?php do_action( $hook_name ); ?>
		
		<?php endif; ?>
		</div><!-- .widget-area -->
	</div><!-- .column -->
</div><!-- .sidebar-1 -->