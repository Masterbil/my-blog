<?php
/**
 * Add panel mobile and new fields to customizer
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since Stained Glass 1.0.0
 */
 
function stainedglass_mobile_register( $wp_customize ) {

	$defaults = stainedglass_get_defaults();
	
	$wp_customize->add_panel( 'mobile', array(
		'priority'       => 4,
		'title'          => __( 'Customize Mobile Version', 'stainedglass' ),
		'description'    => __( 'Settings for mobile users.', 'stainedglass' ),
	) );

	$section_priority = 10;
	$priority = 1;
	
	$wp_customize->add_section( 'width_mobile_switch', array(
		'priority'       => $section_priority++,
		'title'          => __( 'Columns', 'stainedglass' ),
		'description'    => __( 'Settings for small screens', 'stainedglass' ),
		'panel'  => 'mobile',
	) );	
	
	$wp_customize->add_setting( 'width_mobile_switch', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['width_mobile_switch'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'width_mobile_switch', array(
		'label'      => __( 'Switch point', 'stainedglass' ),
		'section'    => 'width_mobile_switch',
		'settings'   => 'width_mobile_switch',
		'type'       => 'text',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_section( 'columns_direction', array(
		'priority'       => $section_priority++,
		'title'          => __( 'Order', 'stainedglass' ),
		'description'    => __( 'Order and visibility for columns on small screens', 'stainedglass' ),
		'panel'  => 'mobile',
	) );	
//columns direction
	$wp_customize->add_setting( 'columns_direction', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['columns_direction'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_content_column'
	) );

	$wp_customize->add_control( 'columns_direction', array(
		'label'   => __( 'Content and column-1, column-2 position for small screens', 'stainedglass' ),
		'section' => 'columns_direction',
		'settings'   => 'columns_direction',
		'type'       => 'select',
		'priority'   => $priority++,
		'choices'	 => array ('c_1_2' => __('Content-1-2', 'stainedglass'),
							   'c_2_1' => __('Content-2-1', 'stainedglass'),
							   '1_c_2' => __('1-Content-2', 'stainedglass'),
							   '2_c_1' => __('2-Content-1', 'stainedglass'),
							   '1_2_c' => __('1-2-Content', 'stainedglass'),
							   '2_1_c' => __('2-1-Content', 'stainedglass'),
								)
	) );
	
//columns visibility
	$wp_customize->add_setting( 'is_mobile_column_1', array(
		'default'        => $defaults['is_mobile_column_1'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'is_mobile_column_1', array(
		'label'      => __( 'Check mark to display first column on small screens', 'stainedglass' ),
		'section'    => 'columns_direction',
		'settings'   => 'is_mobile_column_1',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
//columns visibility
	$wp_customize->add_setting( 'is_mobile_column_2', array(
		'default'        => $defaults['is_mobile_column_2'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'is_mobile_column_2', array(
		'label'      => __( 'Check mark to display second column on small screens', 'stainedglass' ),
		'section'    => 'columns_direction',
		'settings'   => 'is_mobile_column_2',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
}
add_action( 'customize_register', 'stainedglass_mobile_register' );
/**
 * Sanitize content/column direction.
 *
 * @param string $value Value to sanitize. 
 * @return int sanitized value.
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_content_column( $value ) {
	$defaults = stainedglass_get_defaults();
	$possible_values = array ('c_1_2',
							   'c_2_1',
							   '1_c_2',
							   '2_c_1',
							   '1_2_c',
							   '2_1_c',
								);
	return ( in_array( $value, $possible_values ) ? $value : $defaults['columns_direction'] );
} 

/**
 * Return array column-content direction .
 *
 * @return array sanitized direction.
 * @since Stained Glass 1.0.0
 */
function stainedglass_column_dir() {
	$rez = array();
	switch ( stainedglass_get_theme_mod( 'columns_direction' ) ) {
		case 'c_1_2':
			$rez['content'] = 1;
			$rez['column-1'] = 2;
			$rez['column-2'] = 3;
		break;
		case '2_1_c':
			$rez['content'] = 3;
			$rez['column-1'] = 2;
			$rez['column-2'] = 1;
		break;
		case 'c_2_1':
			$rez['content'] = 1;
			$rez['column-1'] = 3;
			$rez['column-2'] = 2;
		break;
		case '1_c_2':
			$rez['content'] = 2;
			$rez['column-1'] = 1;
			$rez['column-2'] = 3;
		break;
		case '2_c_1':
			$rez['content'] = 2;
			$rez['column-1'] = 3;
			$rez['column-2'] = 1;
		break;
		case '1_2_c':
			$rez['content'] = 3;
			$rez['column-1'] = 1;
			$rez['column-2'] = 2;
		break;
	}
	return $rez;
} 