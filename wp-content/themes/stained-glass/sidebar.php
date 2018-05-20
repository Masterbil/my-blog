<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */
 
$stainedglass_curr_slug = stainedglass_get_sidebar_slug();
$hook_name_1 = 'stainedglass_empty_column_1-'.$stainedglass_curr_slug;
$hook_name_2 = 'stainedglass_empty_column_2-'.$stainedglass_curr_slug;
?>

<div class="sidebar-1">
	<div class="column small">		
		<div class="widget-area">
			<?php 
			if ( is_active_sidebar( 'column-1'.'-'.$stainedglass_curr_slug  ) ) :
			
				dynamic_sidebar( 'column-1'.'-'.$stainedglass_curr_slug  );
				
			else :
				
				do_action( $hook_name_1 );

			endif;
			?>
		</div><!-- .widget-area -->
	</div><!-- .column -->
</div><!-- .sidebar-1 -->
	
<div class="sidebar-2">
	<div class="column small">
		<div class="widget-area">
			<?php if ( is_active_sidebar( 'column-2'.'-'.$stainedglass_curr_slug  ) ) :

				dynamic_sidebar( 'column-2'.'-'.$stainedglass_curr_slug  );
				
			else :
				
				do_action( $hook_name_2 );

			endif;
			?>	
		</div><!-- .widget-area -->
	</div><!-- .column -->
</div><!-- .sidebar-2 -->