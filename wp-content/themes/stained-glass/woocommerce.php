<?php
/**
 * The template for displaying woocommerce archive pages.
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
 */
get_header(); 

global $woocommerce_loop;
$stainedglass_columns = 4;

if ( ! empty( $woocommerce_loop['columns'] ) )
	$stainedglass_columns = apply_filters( 'loop_shop_columns', 4 );
if ( is_singular() )
	$stainedglass_columns = 0;
?>

<div class="main-wrapper woo-shop full-width flex-layout-<?php echo esc_attr( $stainedglass_columns ); ?>">

	<div class="site-content"> 
		<div class="content"> 
			<?php if ( is_singular() ) : ?>
			<div class="content-container">
			<?php endif; ?>
	
					<?php woocommerce_breadcrumb(); ?>
					<?php woocommerce_content(); ?>
					<?php do_action( 'stainedglass_after_content' ); ?>	

			<?php if ( is_singular() ) : ?>
			</div><!-- .content-container -->
			<?php endif; ?>

		</div><!-- .content -->
		<div class="clear"></div>	
	</div><!-- .site-content -->

</div> <!-- .main-wrapper.woo-shop -->

<?php
get_footer();
