<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */	
 
global $stainedglass_curr_page_id;
$stainedglass_curr_slug = stainedglass_get_page_sidebar_slug( $stainedglass_curr_page_id );
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
		<div class="widget-area recurs">
			<?php if ( is_active_sidebar( 'column-2'.'-'.$stainedglass_curr_slug  ) ) :

				dynamic_sidebar( 'column-2'.'-'.$stainedglass_curr_slug  );
				
			else :
				
				do_action( $hook_name_2 );

			endif;
			?>	
		</div><!-- .widget-area -->
	</div><!-- .column -->
</div><!-- .sidebar-2 -->