<?php
/**
 * Register postMessage support for site title and description for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since Stained Glass 1.0.0
 */
 
function stainedglass_customize_register( $wp_customize ) {	
	
//Sets postMessage support
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';	
	$wp_customize->get_section( 'colors' )->panel = 'custom_colors';	
	$wp_customize->get_section( 'colors' )->priority = '1';	
	$wp_customize->get_section( 'background_image' )->panel = 'background';	
	$wp_customize->get_section( 'background_image' )->priority = '10';
}
add_action( 'customize_register', 'stainedglass_customize_register' );

 /**
 * Add custom css styles for the Customizer screen.
 *
 * @since Stained Glass 1.0.3
*/
function stainedglass_customize_controls_enqueue_scripts() {
	wp_enqueue_style( 'stainedglass-customize-css', get_template_directory_uri() . '/inc/css/customize.css', array(), null );
	wp_enqueue_script( 'stainedglass-customize-control-js', get_template_directory_uri() . '/inc/js/customize.js', array( 'jquery' ), false, true );
}
add_action('customize_controls_enqueue_scripts', 'stainedglass_customize_controls_enqueue_scripts');
 
 /**
 * Add custom styles to the header.
 *
 * @since Stained Glass 1.0.0
*/
function stainedglass_hook_css() {
	$defaults = stainedglass_get_defaults();
	
	global $stainedglass_colors_class;
	$colors = $stainedglass_colors_class;
		
	$position = stainedglass_column_dir();
	$top = get_theme_mod('top', $defaults['top']);

?>

	<style type="text/css"> 	
		<?php if ( ! display_header_text() ) : ?>
			.site-title,
			.site-description {
				clip: rect(1px 1px 1px 1px); /* IE7 */
				clip: rect(1px, 1px, 1px, 1px);
				position: absolute;
			}
		<?php endif; ?>
		
		.wide .column-1 .element.effect-17 .entry-title,
		.wide .column-1 .element.effect-18 .entry-title, 
		.site-title a {
			color: #<?php echo esc_attr( get_header_textcolor() ); ?>;
		}
		
		.site-content {
			-ms-flex-order: <?php echo $position['content']; ?>;     
			-webkit-order: <?php echo $position['content']; ?>;     
			order: <?php echo $position['content']; ?>;
		}
		
		.sidebar-1 {
			-ms-flex-order: <?php echo $position['column-1']; ?>;     
			-webkit-order:  <?php echo $position['column-1']; ?>;  
			order:  <?php echo $position['column-1']; ?>;
		}

		.sidebar-2 {
			-ms-flex-order: <?php echo $position['column-2']; ?>; 
			-webkit-order:  <?php echo $position['column-2']; ?>;  
			order:  <?php echo $position['column-2']; ?>;
		}
		
		<?php if ( '1' != stainedglass_get_theme_mod( 'is_mobile_column_1' ) ) : ?>
			.sidebar-1 {
				display: none;
			}
		<?php endif;
		
		if ( '1' != stainedglass_get_theme_mod( 'is_mobile_column_2' ) ) : ?>
			.sidebar-2 {
				display: none;
			}
		<?php endif;  ?>
		
		@media screen and (min-width: 680px) {
			.site .content {
				font-size: <?php echo esc_attr(stainedglass_get_theme_mod( 'body_font_size' ) ); ?>px;
			}
		<?php 
			$font = stainedglass_get_theme_mod( 'body_font' );
			if ( '0' != $font ) :
			?>
				.site {
					font-family: '<?php echo esc_attr( $font ); ?>', sans-serif;
				}
				
			<?php
			endif;
			?>
			
		<?php 
			$heading_font = stainedglass_get_theme_mod( 'heading_font' );
			if ( '0' != $heading_font ) :
			?>
				.site h1,
				.site h2,
				.site h3,
				.site h4,
				.site h5,
				.site h6{
					font-family: '<?php echo esc_attr( $heading_font ); ?>', sans-serif;
				}
				
			<?php
			endif;
			?>
		}
		
		/* widget buttons */
		.widget.stainedglass_widget_button {
			background: <?php echo esc_attr( $colors->get_color('buttons_color')); ?>;
		}
		
		.widget.stainedglass_widget_button .stainedglass-link {
			background: <?php echo esc_attr( $colors->get_color('buttons_button')); ?>;
		}		
		
		.widget.stainedglass_widget_button a {
			color: <?php echo esc_attr( $colors->get_color('buttons_link')); ?>;
		}
		.widget.stainedglass_widget_button a:hover {
			color: <?php echo esc_attr( $colors->get_color('buttons_hover')); ?>;
		}
		.widget.stainedglass_widget_button .stainedglass-link {
			border-color: <?php echo esc_attr( $colors->get_color('buttons_border')); ?>;
		}
		.widget.stainedglass_widget_button .stainedglass-link:hover {
			box-shadow: 0 0 4px 4px <?php echo esc_attr( $colors->get_color('buttons_border')); ?>;
		}

		.element.effect-18 .hover,
		.element.effect-18 .entry-title,
		.element.effect-17 .hover,
		.element.effect-17 .entry-title,
		.site-title,
		.element-wrap {
			background: <?php echo esc_attr( $colors->get_color('site_name_back')); ?>;
		}		
		
		.widget.stainedglass_recent_posts .content article footer a,
		.content-container article .entry-content a,
		.comments-link a,
		.featured-post,
		.logged-in-as a,
		.site .edit-link,
		.jetpack-widget-tag-nav,
		.jetpack-widget-nav,
		.content footer a {
			color: <?php echo esc_attr( $colors->get_color('link_color')); ?>;
		}		
		
		.entry-header .entry-title a {
			color: <?php echo esc_attr( $colors->get_color('heading_link')); ?>;
		}
		
		a:hover,
		.widget.stainedglass_recent_posts .content article footer a:hover,
		.content-container .entry-content a:hover,
		.comments-link a:hover,
		.entry-meta a:hover,
		.site-title a:hover,
		.site .author.vcard a:hover,
		.entry-header .entry-title a:hover,
		.site .widget .entry-meta a:hover,
		.category-list a:hover {
			color: <?php echo esc_attr( $colors->get_color('hover_color')); ?>;
		}
				
		.wide .column-1 .element.effect-17 p,
		.wide .column-1 .element.effect-18 p,
		.site-description {
			color: <?php echo esc_attr( $colors->get_color('description_color')); ?>;
		}
		
		entry-header .entry-title a,
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			color: <?php echo esc_attr( $colors->get_color('heading_color')); ?>;
		}

		.background-fixed {
			bckground: repeat  <?php echo esc_attr($top); ?> center fixed;
			background-image: url(<?php echo esc_url(stainedglass_get_theme_mod('column_background_url')); ?>);		
		}
		
		.site-title h1 a {
			color: #<?php echo esc_attr( get_header_textcolor() ); ?>;

		}
		
		.site {		
			max-width: <?php echo esc_attr(get_theme_mod('width_site', $defaults['width_site'])); ?>px;
		}
		
		.main-wrapper {
			max-width: <?php echo esc_attr(stainedglass_get_theme_mod('width_main_wrapper')); ?>px;
		}	
		
		.site .wide .widget .widget-area .main-wrapper.no-sidebar,
		.main-wrapper.no-sidebar {
			max-width: <?php echo esc_attr(stainedglass_get_theme_mod('width_content_no_sidebar')); ?>px !important;
		}	
		
		.sidebar-before-footer,
		.header-wrap {
			max-width: <?php echo esc_attr(stainedglass_get_theme_mod('width_image')); ?>px;
		}
		
		@media screen and (min-width: <?php echo esc_attr(stainedglass_get_theme_mod('size_image')); ?>px) {
			.image-wrapper {
				max-width: <?php echo esc_attr(stainedglass_get_theme_mod('size_image')); ?>px;
			}
		}
				
		.sidebar-footer .widget-area,
		.wide .widget > input,
		.wide .widget > form,
		.sidebar-before-footer .widget > div,
		.sidebar-before-footer .widget-area .widget > ul,
		.sidebar-top-full .widget-area .widget > div,
		.sidebar-top-full .widget-area .widget > ul {
			max-width: <?php echo esc_attr(stainedglass_get_theme_mod('width_top_widget_area')); ?>px;
			margin-left: auto;
			margin-right: auto;
		}

		/* set width of column in px */
		@media screen and (min-width: <?php echo esc_attr(stainedglass_get_theme_mod('width_mobile_switch')); ?>px) {
	
			.content {
				-ms-flex-order: 1;     
				-webkit-order: 1;  
				order: 1;
			}

			.sidebar-1 {
				-ms-flex-order: 2;     
				-webkit-order: 2;  
				order: 2;
			}

			.sidebar-2 {
				-ms-flex-order: 3;     
				-webkit-order: 3;  
				order: 3;
			}
		
			.main-wrapper {
				-webkit-flex-flow: nowrap;
				-ms-flex-flow: nowrap;
				flex-flow: nowrap;
			}
			
			.sidebar-1,
			.sidebar-2 {
				display: block;
			}
	
			.sidebar-1 .column {
				padding: 0 20px 0 0;
			}
			
			.sidebar-2 .column {
				padding: 0 0 0 20px;
			}
				
			.site-content {
				-ms-flex-order: 2;     
				-webkit-order: 2;  
				order: 2;
			}
	
			.sidebar-1 {
				-ms-flex-order: 1;     
				-webkit-order: 1;  
				order: 1;
			}

			.sidebar-2 {
				-ms-flex-order: 3;     
				-webkit-order: 3;  
				order: 3;
			}
			
			
			.two-sidebars .sidebar-1 {
				width: <?php echo esc_attr(stainedglass_get_theme_mod('width_column_1_rate')); ?>%;
			}

			.two-sidebars .sidebar-2 {
				width: <?php echo esc_attr(stainedglass_get_theme_mod('width_column_2_rate')); ?>%;
			}
			.two-sidebars .site-content {
				width: <?php echo esc_attr(100 - stainedglass_get_theme_mod('width_column_2_rate') - stainedglass_get_theme_mod('width_column_1_rate')); ?>%;
			}
			
			.left-sidebar .sidebar-1 {
				width: <?php echo esc_attr(stainedglass_get_theme_mod('width_column_1_left_rate')); ?>%;
			}
			.left-sidebar .site-content {
				width: <?php echo esc_attr(100 - stainedglass_get_theme_mod('width_column_1_left_rate')); ?>%;
			}
			
			.right-sidebar .sidebar-2 {
				width: <?php echo esc_attr(stainedglass_get_theme_mod('width_column_1_right_rate')); ?>%;
			}	
			.right-sidebar .site-content {
				width: <?php echo esc_attr(100 - stainedglass_get_theme_mod('width_column_1_right_rate')); ?>%;
			}	
		
	 }

	</style>
	<?php
}
add_action('wp_head', 'stainedglass_hook_css');

/**
 * Theme mod with defaults
 *
 * @return string theme mod
 * @since Stained Glass 1.0.0
 */

function stainedglass_get_theme_mod( $name ) {
	$defaults = stainedglass_get_defaults();
	return apply_filters ( 'stainedglass_theme_mod', get_theme_mod( $name, $defaults[$name] ) );
}

/**
 * Transform hex color to rgba
 *
 * @param string $color hex color. 
 * @param int $opacity opacity. 
 * @return string rgba color.
 * @since Stained Glass 1.0.0
 */
function stainedglass_hex_to_rgba( $color, $opacity ) {

	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	$hex = array('ffffff');
	
	if ( 6 == strlen($color) ) {
			$hex = array( $color[0].$color[1], $color[2].$color[3], $color[4].$color[5] );
	} elseif ( 3 == strlen( $color ) ) {
			$hex = array( $color[0].$color[0], $color[1].$color[1], $color[2].$color[2] );
	}

	$rgb =  array_map('hexdec', $hex);

	return 'rgba('.implode(",",$rgb).','.$opacity.')';
}

/**
 * Return string Sanitized post thumbnail type
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_post_thumbnail( $value ) {
	$possible_values = array( 'large', 'big', 'small');
	return ( in_array( $value, $possible_values ) ? $value : 'big' );
}

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_customize_preview_js() {
	wp_enqueue_script( 'stainedglass-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), time().'sss', true );
}
add_action( 'customize_preview_init', 'stainedglass_customize_preview_js', 99 );

 /**
 * Sanitize bool value.
 *
 * @param string $value Value to sanitize. 
 * @return int 1 or 0.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_checkbox( $value ) {	
	return ( $value == '1' ? '1' : 0 );
} 
 /**
 * Sanitize url value.
 *
 * @param string $value Value to sanitize. 
 * @return string sanitizes url.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_url( $value ) {	
	return esc_url( $value );
}
 /**
 * Sanitize url value.
 *
 * @param string $value Value to sanitize. 
 * @return string sanitizes url.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_background_url( $value ) {	
	$value = esc_url( $value );
	return ( $value == '' ? 'none' : $value );
}
/**
 * Sanitize integer.
 *
 * @param string $value Value to sanitize. 
 * @return int sanitized value.
 * @uses absint()
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_int( $value ) {
	return absint( $value );
} 
/**
 * Sanitize text field.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @uses sanitize_text_field()
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_text( $value ) {
	return sanitize_text_field( $value );
}
/**
 * Sanitize hex color.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @uses sanitize_hex_color()
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_hex_color( $value ) {
	return sanitize_hex_color( $value );
}
/**
 * Sanitizehtext.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_kses( $value ) {
	return wp_kses( $value, array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			)
			);
}
/**
 * Sanitize hex color.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_content_width( $value ) {
	$value = absint($value);
	$value = ($value > 1349 ? 1349 : ($value < 500 ? 500 : $value));
	return $value;
}
/**
 * Sanitize scroll button.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_scroll_button( $value ) {
	$possible_values = array( 'none', 'right', 'left', 'center');
	return ( in_array( $value, $possible_values ) ? $value : 'right' );
}

/**
 * Sanitize scroll css3 effect.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_scroll_effect( $value ) {
	$possible_values = array( 'none', 'move');
	return ( in_array( $value, $possible_values ) ? $value : 'move' );
}
/**
 * Sanitize opacity.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_opacity( $value ) {
	$possible_values = array ( '0',
							   '0.1', 
							   '0.2', 
							   '0.3', 
							   '0.4', 
							   '0.5',
							   '0.6', 
							   '0.7',
							   '0.8',
							   '0.9',
							   '1');
	return ( in_array( $value, $possible_values ) ? $value : '0.3' );
}
/**
 * Return string Sanitized backgroind position
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_background_position( $value ) {
	$possible_values = array( 'top', 'center', 'bottom');
	return ( in_array( $value, $possible_values ) ? $value : 'top' );
}