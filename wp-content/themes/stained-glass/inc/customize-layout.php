<?php
/**
 * Add new fields to customizer for the theme layout.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since Stained Glass 1.0.0
 */
 
add_action( 'customize_register', 'stainedglass_create_section_layout', 20 );

function stainedglass_create_section_layout( $wp_customize ) {
	$defaults = stainedglass_get_defaults();
		
	$wp_customize->add_panel( 'layout', array(
		'priority'       => 1,
		'title'          => __( 'Customize Layout', 'stainedglass' ),
		'description'    => __( 'In this section you can choose layout settings.', 'stainedglass' ),
	) );

	$section_priority = 10;
	$priority = 1;
	
	
	
//Featured Image

	$wp_customize->add_section( 'post_thumbnail_size', array(
		'priority'       => $section_priority++,
		'title'          => __( 'Featured Image', 'stainedglass' ),
		'description'    => __( 'Image Size', 'stainedglass' ),
		'panel'  => 'layout',
	) );	
	
	$wp_customize->add_setting( 'post_thumbnail_size', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['post_thumbnail_size'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'post_thumbnail_size', array(
		'label'      => __( 'Width of the Featured Image (Images should be updated with Regenerate Thumbnails plugin).', 'stainedglass' ),
		'section'    => 'post_thumbnail_size',
		'settings'   => 'post_thumbnail_size',
		'type'       => 'number',
		'priority'       => $priority++,
	) );

	
//Columns width

	$wp_customize->add_section( 'columns', array(
		'priority'       => $section_priority++,
		'title'          => __( 'Columns', 'stainedglass' ),
		'description'    => __( 'You can set the size of columns in this section', 'stainedglass' ),
		'panel'  => 'layout',
	) );	
	
	$wp_customize->add_setting( 'unit', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['unit'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'unit', array(
		'label'   => __( 'Unit', 'stainedglass' ),
		'section' => 'columns',
		'settings'   => 'unit',
		'type'       => 'select',
		'priority'   => $priority++,
		'choices'	 => array( __('%', 'stainedglass')),
	) );
	
//in %

	$wp_customize->add_setting( 'width_column_1_range_rate', array(
		'type'			 => 'empty',
		'default'        => stainedglass_get_theme_mod('width_column_1_rate'),
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'width_column_1_range_rate', array(
		'label'      => __( '(%)', 'stainedglass' ),
		'section'    => 'columns',
		'settings'   => 'width_column_1_range_rate',
		'type'       => 'range',
		'priority' => $priority++,
		'input_attrs' => array(
			'min'   => 10,
			'max'   => 50,
			'step'  => 1,
	) ));
	
	$wp_customize->add_setting( 'width_column_1_rate', array(
		'type'			 => 'theme_mod',
		'default'        => stainedglass_get_theme_mod('width_column_1_rate'),
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'stainedglass_sanitize_range_column_rate'
	) );
	
	$wp_customize->add_control( 'width_column_1_rate', array(
		'label'      => __( 'Width of the first column (two sidebars layout)', 'stainedglass' ),
		'section'    => 'columns',
		'settings'   => 'width_column_1_rate',
		'type'       => 'text',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'width_column_2_range_rate', array(
		'type'			 => 'empty',
		'default'        => stainedglass_get_theme_mod('width_column_2_rate'),
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'width_column_2_range_rate', array(
		'label'      => __( '(%)', 'stainedglass' ),
		'section'    => 'columns',
		'settings'   => 'width_column_2_range_rate',
		'type'       => 'range',
		'priority' => $priority++,
		'input_attrs' => array(
			'min'   => 10,
			'max'   => 50,
			'step'  => 1,
	) ));
	
	$wp_customize->add_setting( 'width_column_2_rate', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['width_column_2_rate'],
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'stainedglass_sanitize_range_column_rate'
	) );
	
	$wp_customize->add_control( 'width_column_2_rate', array(
		'label'      => __( 'Width of the second column (two sidebars layout)', 'stainedglass' ),
		'section'    => 'columns',
		'settings'   => 'width_column_2_rate',
		'type'       => 'text',
		'priority'       => $priority++,
	) );
	
	
	$wp_customize->add_setting( 'width_column_1_left_range_rate', array(
		'type'			 => 'empty',
		'default'        => stainedglass_get_theme_mod('width_column_1_left_rate'),
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'width_column_1_left_range_rate', array(
		'label'      => __( '(%)', 'stainedglass' ),
		'section'    => 'columns',
		'settings'   => 'width_column_1_left_range_rate',
		'type'       => 'range',
		'priority' => $priority++,
		'input_attrs' => array(
			'min'   => 10,
			'max'   => 50,
			'step'  => 1,
	) ));
	
	$wp_customize->add_setting( 'width_column_1_left_rate', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['width_column_1_left_rate'],
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'stainedglass_sanitize_range_column_rate'
	) );
	
	$wp_customize->add_control( 'width_column_1_left_rate', array(
		'label'      => __( 'Width of the first column (left sidebar layout)', 'stainedglass' ),
		'section'    => 'columns',
		'settings'   => 'width_column_1_left_rate',
		'type'       => 'text',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'width_column_1_right_range_rate', array(
		'type'			 => 'empty',
		'default'        => stainedglass_get_theme_mod('width_column_1_right_rate'),
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'width_column_1_right_range_rate', array(
		'label'      => __( '(%)', 'stainedglass' ),
		'section'    => 'columns',
		'settings'   => 'width_column_1_right_range_rate',
		'type'       => 'range',
		'priority' => $priority++,
		'input_attrs' => array(
			'min'   => 10,
			'max'   => 50,
			'step'  => 1,
	) ));
	
	$wp_customize->add_setting( 'width_column_1_right_rate', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['width_column_1_right_rate'],
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'stainedglass_sanitize_range_column_rate'
	) );
	
	$wp_customize->add_control( 'width_column_1_right_rate', array(
		'label'      => __( 'Width of the second column (right sidebar layout)', 'stainedglass' ),
		'section'    => 'columns',
		'settings'   => 'width_column_1_right_rate',
		'type'       => 'text',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'front_page_style', array(
		'default'        => $defaults['front_page_style'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'stainedglass_is_show_top_menu', array(
		'label'      => __( 'Check mark to display content on the static front page', 'stainedglass' ),
		'section'    => 'layout_home',
		'settings'   => 'front_page_style',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	

/* layout_post */

	$wp_customize->add_section( 'layout_post', array(
		'priority'       => $section_priority++,
		'title'          => __( 'Post', 'stainedglass' ),
		'description'    => __( 'Customize posts', 'stainedglass' ),
		'panel'  => 'layout',
	) );	
	
	$wp_customize->add_setting( 'single_style', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['single_style'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_display_choices'
	) );

	$wp_customize->add_control( 'single_style', array(
		'label'   => __( 'Post style', 'stainedglass' ),
		'section' => 'layout_blog',
		'settings'   => 'single_style',
		'type'       => 'select',
		'priority'   => $priority++,
		'choices'	 => stainedglass_display_choices(),
	) );
	
	$wp_customize->add_setting( 'is_display_post_image', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_post_image'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_post_image', array(
		'label'      => __( 'Display Featured Image', 'stainedglass' ),
		'section'    => 'layout_post',
		'settings'   => 'is_display_post_image',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_post_title', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_post_title'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_post_title', array(
		'label'      => __( 'Display Title', 'stainedglass' ),
		'section'    => 'layout_post',
		'settings'   => 'is_display_post_title',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_post_cat', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_post_cat'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_post_cat', array(
		'label'      => __( 'Display Category List', 'stainedglass' ),
		'section'    => 'layout_post',
		'settings'   => 'is_display_post_cat',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_post_tags', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_post_tags'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_post_tags', array(
		'label'      => __( 'Display Tag List', 'stainedglass' ),
		'section'    => 'layout_post',
		'settings'   => 'is_display_post_tags',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );

/* layout_page */
	
	$wp_customize->add_setting( 'page_style', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['page_style'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_display_choices'
	) );

	$wp_customize->add_control( 'page_style', array(
		'label'   => __( 'Page style', 'stainedglass' ),
		'section' => 'layout_blog',
		'settings'   => 'page_style',
		'type'       => 'select',
		'priority'   => $priority++,
		'choices'	 => stainedglass_display_choices(),
	) );
	
	$wp_customize->add_setting( 'is_display_page_image', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_page_image'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );
	
	$wp_customize->add_control( 'is_display_page_image', array(
		'label'      => __( 'Display Featured Image', 'stainedglass' ),
		'section'    => 'layout_page',
		'settings'   => 'is_display_page_image',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_page_title', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_page_title'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_page_title', array(
		'label'      => __( 'Display Title', 'stainedglass' ),
		'section'    => 'layout_page',
		'settings'   => 'is_display_page_title',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );


	/* layout_portfolio_page */

	$wp_customize->add_setting( 'portfolio_style', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['portfolio_style'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_display_choices'
	) );

	$wp_customize->add_control( 'portfolio_style', array(
		'label'   => __( 'Portfolio Archive/Index style', 'stainedglass' ),
		'section' => 'layout_portfolio',
		'settings'   => 'portfolio_style',
		'type'       => 'select',
		'priority'   => $priority++,
		'choices'	 => stainedglass_display_choices(),
	) );
	
	$wp_customize->add_setting( 'is_display_portfolio_image', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_portfolio_image'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_portfolio_image', array(
		'label'      => __( 'Display Featured Image', 'stainedglass' ),
		'section'    => 'layout_portfolio_page',
		'settings'   => 'is_display_portfolio_image',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_portfolio_title', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_portfolio_title'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_portfolio_title', array(
		'label'      => __( 'Display Title', 'stainedglass' ),
		'section'    => 'layout_portfolio_page',
		'settings'   => 'is_display_portfolio_title',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_portfolio_project', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_portfolio_project'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_portfolio_project', array(
		'label'      => __( 'Display Project', 'stainedglass' ),
		'section'    => 'layout_portfolio_page',
		'settings'   => 'is_display_portfolio_project',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_portfolio_tags', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_portfolio_tags'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_portfolio_tags', array(
		'label'      => __( 'Display Tag List', 'stainedglass' ),
		'section'    => 'layout_portfolio_page',
		'settings'   => 'is_display_portfolio_tags',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
}

/**
 * Return how to display content in archive
 *
 * @return array choices.
 * @since Stained Glass 1.0.0
 */
function stainedglass_display_choices() {
	return array ('excerpt' => __('Excerpt', 'stainedglass'),
			'content' => __('Content', 'stainedglass'),
			'none' => __('No Content', 'stainedglass'),
			);
}
/**
 * Sanitize display layouts
 *
 * @return array choices.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_display_choices( $value) {
	return ( array_key_exists( $value, stainedglass_display_choices() ) ? $value : 'none' );
}

/**
 * Return all possible layouts
 *
 * @return array choices.
 * @since Stained Glass 1.0.0
 */
function stainedglass_layout_choices() {
	$choices = array ('no-sidebar' => __('Full Width', 'stainedglass'),
			'left-sidebar' => __('Left Column', 'stainedglass'),
			'right-sidebar' => __('Right Column', 'stainedglass'),
			'two-sidebars' => __('Two Columns', 'stainedglass'));
			
	return apply_filters( 'stainedglass_layouts', $choices);
}

/**
 * Return all possible layouts
 *
 * @return array choices.
 * @since Stained Glass 1.0.0
 */
function stainedglass_layout_choices_content() {
	$choices = array ('default' => __('Default (1 column)', 'stainedglass'),
			'flex-layout-1' => __('1 column', 'stainedglass'),
			'flex-layout-2' => __('2 columns', 'stainedglass'),
			'flex-layout-3' => __('3 columns', 'stainedglass'),
			'flex-layout-4' => __('4 columns', 'stainedglass'));
			
	return apply_filters( 'stainedglass_layouts', $choices);
}
/**
 * Sanitize sidebar layouts
 *
 * @return array choices.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_layout_choices( $value) {
	return ( array_key_exists( $value, stainedglass_layout_choices() ) ? $value : 'no-columns' );
}

/**
 * Sanitize content layouts 
 *
 * @return array choices.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_layout_choices_content( $value) {
	return ( array_key_exists( $value, stainedglass_layout_choices_content() ) ? $value : 'no-columns' );
}
/**
 * Sanitize range.
 *
 * @param string $value Value to sanitize. 
 * @return int sanitized value.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_range_content( $value ) {
	$defaults = stainedglass_get_defaults();
	return stainedglass_sanitize_range($value, 600, 2200, $defaults['width_image']);
} 

/**
 * Sanitize range.
 *
 * @param string $value Value to sanitize. 
 * @return int sanitized value.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_range_image( $value ) {
	$defaults = stainedglass_get_defaults();
	return stainedglass_sanitize_range($value, 50, 2200, $defaults['width_image']);
} 
/**
 * Sanitize range.
 *
 * @param string $value Value to sanitize. 
 * @return int sanitized value.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_range_column( $value ) {
	$defaults = stainedglass_get_defaults();
	return stainedglass_sanitize_range($value, 90, 600, $defaults['width_column_1']);
}

/**
 * Sanitize range.
 *
 * @param string $value Value to sanitize. 
 * @return int sanitized value.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_range_column_rate( $value ) {
	$defaults = stainedglass_get_defaults();
	return stainedglass_sanitize_range($value, 10, 50, $defaults['width_column_1_rate']);
} 
/**
 * Sanitize range.
 *
 * @param string $value Value to sanitize. 
 * @return int sanitized value.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_range_width( $value ) {
	$defaults = stainedglass_get_defaults();
	return stainedglass_sanitize_range($value, 960, 2200, $defaults['width_site']);
} 
/**
 * Sanitize range.
 *
 * @param string $value Value to sanitize. 
 * @param int $min minimal value. 
 * @param int $max maximal value. 
 * @param int $def default value. 
 * @return int sanitized value.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_range( $value, $min, $max, $def ) {
	$x = absint( $value );
	return ( $x >= $min && $x <= $max ? $x : $def );
} 
/**
 * Return string Sanitized header style
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_header_style( $value ) {
	$defaults = stainedglass_get_defaults();
	$possible_values = array( 'boxed', 'full');
	return ( in_array( $value, $possible_values ) ? $value : $defaults['header_style'] );
}

/**
 * Class to store and create layouts for different types of pages
 *
 * @since Stained Glass 1.0.0
 */

class stainedglass_Layout_Class {

	private $layout = array();
	private $curr_layout = null;
	private $curr_content_layout = null;
	
	function __construct() {
		$i = 0;
	
		$this->layout[$i]['name'] = 'layout_home';
		$this->layout[$i]['callback'] = 'is_front_page';
		$this->layout[$i]['val'] = 'no-sidebar';
		$this->layout[$i]['is_has_content_section'] = false;
		$this->layout[$i]['content_val'] = 'flex-layout-1';
		$this->layout[$i]['text'] = __('Home', 'stainedglass');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_blog';
		$this->layout[$i]['callback'] = 'is_home';
		$this->layout[$i]['val'] = 'no-sidebar';
		$this->layout[$i]['is_has_content_section'] = true;
		$this->layout[$i]['content_val'] = 'flex-layout-3';
		$this->layout[$i]['text'] = __('Blog', 'stainedglass');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_page';
		$this->layout[$i]['callback'] = 'is_page';
		$this->layout[$i]['val'] = 'right-sidebar';
		$this->layout[$i]['is_has_content_section'] = false;
		$this->layout[$i]['content_val'] = 'flex-layout-1';
		$this->layout[$i]['text'] = __('Page', 'stainedglass');		
		
		$i++;
		$this->layout[$i]['name'] = 'layout_portfolio';
		$this->layout[$i]['callback'] = 'stainedglass_is_portfolio';
		$this->layout[$i]['val'] = 'left-sidebar';
		$this->layout[$i]['is_has_content_section'] = true;
		$this->layout[$i]['content_val'] = 'flex-layout-3';
		$this->layout[$i]['text'] = __('Portfolio (Archive)', 'stainedglass');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_portfolio_page';
		$this->layout[$i]['callback'] = 'stainedglass_is_portfolio_page';
		$this->layout[$i]['val'] = 'right-sidebar';
		$this->layout[$i]['is_has_content_section'] = false;
		$this->layout[$i]['content_val'] = '';
		$this->layout[$i]['text'] = __('Portfolio (Page)', 'stainedglass');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_archive';
		$this->layout[$i]['callback'] = 'is_archive';
		$this->layout[$i]['val'] = 'right-sidebar';
		$this->layout[$i]['is_has_content_section'] = true;
		$this->layout[$i]['content_val'] = 'flex-layout-3';
		$this->layout[$i]['text'] = __('Archive', 'stainedglass');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_default';
		$this->layout[$i]['callback'] = '';
		$this->layout[$i]['val'] = 'right-sidebar';
		$this->layout[$i]['is_has_content_section'] = false;
		$this->layout[$i]['content_val'] = 'flex-layout-1';
		$this->layout[$i]['text'] = __('Default', 'stainedglass');
		
		add_action( 'customize_register', array( $this, 'stainedglass_create_layout_controls' ), 21 );
		add_action( 'stainedglass_option_defaults', array( $this, 'stainedglass_add_defaults' ) );

	}
	
	/* Set current layouts into variables */
	
	function find_layout() {
		foreach( $this->layout as $id => $values ) {

		if( '' == $values['callback']) {
				$this->curr_layout = get_theme_mod($values['name'], $values['val']);
				$this->curr_content_layout = get_theme_mod($values['name'].'_content', $values['content_val']);
				break;
			}
			else if( call_user_func( $values['callback'] ) ) {
				$this->curr_layout = get_theme_mod($values['name'], $values['val']);
				$this->curr_content_layout = get_theme_mod($values['name'].'_content', $values['content_val']);
				break;
			}
			
		}
	}
	
	/* Return current layout */
	
	public function get_layout( ) {
		
		if( isset($this->curr_layout) )
			return $this->curr_layout;
	
		$this->find_layout();

		return $this->curr_layout;
	}
	
	/* Return current content layout */
	
	public function get_content_layout( ) {
		
		if( isset($this->curr_content_layout) )
			return $this->curr_content_layout;
		
		$this->find_layout();

		return $this->curr_layout;
	}
	
	/* Add values to defaults array */
	
	function stainedglass_add_defaults( $defaults ) {
	
		foreach( $this->layout as $id => $values ) {

			$defaults[ $values['name'] ] = $values['val'];
			$defaults[ $values['name'].'_content' ] = $values['content_val'];
			
		}

		return $defaults;
	}
	
	/* Create all sections and controls in the Customizer for layouts */
	
	function stainedglass_create_layout_controls( $wp_customize ) {
	
		$section_priority = 99; //add to the end of the layout panel
		
		foreach( $this->layout as $id => $values ) {
			$priority = 1;
			$section_priority++;
		
			$wp_customize->add_section( $values['name'], array(
				'priority'       => $section_priority,
				'title'          => $values['text'],
				'description'    => __( 'Layout settings for ', 'stainedglass' ).$values['text'],
				'panel'  => 'layout',
			) );	

			$wp_customize->add_setting( $values['name'], array(
				'type'			 => 'theme_mod',
				'default'        => $values['val'],
				'capability'     => 'edit_theme_options',
				'sanitize_callback' => 'stainedglass_sanitize_layout_choices'
			) );

			$wp_customize->add_control( $values['name'], array(
				'label'   => $values['text'].__( ' layout', 'stainedglass' ),
				'section' => $values['name'],
				'settings'   => $values['name'],
				'type'       => 'select',
				'priority'   => $priority++,
				'choices'	 => stainedglass_layout_choices(),
			) );
			
			if( $values['is_has_content_section'] ) {
			
				$wp_customize->add_setting( $values['name'].'_content', array(
					'type'			 => 'theme_mod',
					'default'        => $values['content_val'],
					'capability'     => 'edit_theme_options',
					'sanitize_callback' => 'stainedglass_sanitize_layout_choices_content'
				) );

				$wp_customize->add_control( $values['name'].'_content', array(
					'label'   =>  $values['text'].__( ' layout (content)', 'stainedglass' ),
					'section' => $values['name'],
					'settings'   => $values['name'].'_content',
					'type'       => 'select',
					'priority'   => $priority++,
					'choices'	 => stainedglass_layout_choices_content(),
				) );
			}
		}
	}
}