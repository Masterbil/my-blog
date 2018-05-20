<?php
/**
 * Add new fields to customizer, create panel 'Other' and register postMessage support for site title and description for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since Stained Glass 1.0.0
 */
 
function stainedglass_customize_register_other( $wp_customize ) {

	$defaults = stainedglass_get_defaults();
	
	$wp_customize->add_panel( 'other', array(
		'priority'       => 7,
		'title'          => __( 'Customize Other Settings', 'stainedglass' ),
		'description'    => __( 'All other settings.', 'stainedglass' ),
	) );	
	
	$wp_customize->add_panel( 'background', array(
		'priority'       => 5,
		'title'          => __( 'Customize Background', 'stainedglass' ),
		'description'    => __( 'Background.', 'stainedglass' ),
	) );	
	
	$wp_customize->add_panel( 'navigation', array(
		'priority'       => 6,
		'title'          => __( 'Customize Menu', 'stainedglass' ),
		'description'    => __( 'Navigation settings.', 'stainedglass' ),
	) );
	
	$section_priority = 10;
	
//New section in customizer: Logotype
	$wp_customize->add_section( 'stainedglass_theme_logotype', array(
		'title'          => __( 'Logotype', 'stainedglass' ),
		'priority'       => $section_priority++,
		'panel'  => 'other',
	) );
	
//New setting in Logotype section: Logo Image
	$wp_customize->add_setting( 'logotype_url', array(
		'default'        => get_template_directory_uri().'/img/logo.png',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_url'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'logotype_url', array(
		'label'      => __('Logotype Image', 'stainedglass'),
		'section'    => 'stainedglass_theme_logotype',
		'settings'   => 'logotype_url',
		'priority'   => '1',
	) ) );
	
//New section in customizer: Fixed Background
	$wp_customize->add_section( 'column_background_url', array(
		'title'          => __( 'Fixed Background', 'stainedglass' ),
		'priority'       => 2,
		'panel'  => 'background',
	) );
//column background image
	$wp_customize->add_setting( 'column_background_url', array(
		'default'        => $defaults['column_background_url'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_background_url'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'column_background_url', array(
		'label'      => __('Site Background', 'stainedglass'),
		'section'    => 'column_background_url',
		'settings'   => 'column_background_url',
		'priority'   => 1,
	) ) );
	
//background position
	$wp_customize->add_setting( 'top', array(
		'default'        => $defaults['top'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_background_position'
	) );
	$wp_customize->add_control( 'top', array(
		'label'   => __( 'Vertical position', 'stainedglass' ),
		'section' => 'column_background_url',
		'settings'   => 'top',
		'type'       => 'select',
		'priority'   => 2,
		'choices'	 => array ('top' => __('Top', 'stainedglass'),
								'center' => __('Center', 'stainedglass'), 
								'bottom' => __('Bottom', 'stainedglass'))
	) );	

//New section in customizer: Navigation Options
	$wp_customize->add_section( 'stainedglass_nav_options', array(
		'title'          => __( 'Navigation menu settings', 'stainedglass' ),
		'priority'       => $section_priority++,
		'panel'  => 'navigation',
	) );	
	
//New setting in Navigation section: Switch On First Top Menu
	$wp_customize->add_setting( 'is_show_top_menu', array(
		'default'        => $defaults['is_show_top_menu'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'is_show_top_menu', array(
		'label'      => __( 'Switch On First Top Menu', 'stainedglass' ),
		'section'    => 'stainedglass_nav_options',
		'settings'   => 'is_show_top_menu',
		'type'       => 'checkbox',
		'priority'   => $section_priority++,
	) );
	
//New setting in Navigation section: Switch On Second Top Menu
	$wp_customize->add_setting( 'is_show_secont_top_menu', array(
		'default'        => $defaults['is_show_secont_top_menu'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'stainedglass_is_show_secont_top_menu', array(
		'label'      => __( 'Switch On Second Top Menu', 'stainedglass' ),
		'section'    => 'stainedglass_nav_options',
		'settings'   => 'is_show_secont_top_menu',
		'type'       => 'checkbox',
		'priority'       => 22,
	) );
	
//New setting in Navigation section: Switch On Footer Menu
	$wp_customize->add_setting( 'is_show_footer_menu', array(
		'default'        => $defaults['is_show_footer_menu'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'stainedglass_is_show_footer_menu', array(
		'label'      => __( 'Switch On Footer Menu', 'stainedglass' ),
		'section'    => 'stainedglass_nav_options',
		'settings'   => 'is_show_footer_menu',
		'type'       => 'checkbox',
		'priority'       => 23,
	) );
	
//New section in the customizer: Scroll To Top Button
	$wp_customize->add_section( 'stainedglass_scroll', array(
		'title'          => __( 'Scroll To Top Button', 'stainedglass' ),
		'priority'       => $section_priority++,
		'panel'  => 'other',
	) );
	
	$wp_customize->add_setting( 'scroll_button', array(
		'default'        => $defaults['scroll_button'],
		'capability'     => 'edit_theme_options',
		'transport'		 => 'refresh',
		'sanitize_callback' => 'stainedglass_sanitize_scroll_button'
	) );
	
	
	$wp_customize->add_control( 'scroll_button', array(
		'label'      => __( 'How to display the scroll to top button', 'stainedglass' ),
		'section'    => 'stainedglass_scroll',
		'settings'   => 'scroll_button',
		'type'       => 'select',
		'priority'   => 1,
		'choices'	 => array ('none' => __('None', 'stainedglass'),
								'right' => __('Right', 'stainedglass'), 
								'left' => __('Left', 'stainedglass'),
								'center' => __('Center', 'stainedglass'))
	) );
	
	$wp_customize->add_setting( 'scroll_animate', array(
		'default'        => $defaults['scroll_animate'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_scroll_effect'
	) );
	
	$wp_customize->add_control( 'scroll_animate', array(
		'label'      => __( 'How to animate the scroll to top button', 'stainedglass' ),
		'section'    => 'stainedglass_scroll',
		'settings'   => 'scroll_animate',
		'type'       => 'select',
		'priority'   => 1,
		'choices'	 => array ('none' => __('None', 'stainedglass'),
								'move' => __('Jump', 'stainedglass')), 
	) );
	
//New section in the customizer: Favicon
	$wp_customize->add_section( 'stainedglass_favicon', array(
		'title'          => __( 'Favicon', 'stainedglass' ),
		'description'    => __( 'You can select an Icon to be shown at the top of browser window by uploading from your computer. (Size: [16X16] px)', 'stainedglass' ),
		'priority'       => $section_priority++,
		'panel'  => 'other',
	) );
	
	$wp_customize->add_setting( 'favicon', array(
		'default'        => $defaults['favicon'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_url'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'favicon', array(
		'label'      => __('Favicon', 'stainedglass'),
		'section'    => 'stainedglass_favicon',
		'settings'   => 'favicon',
		'priority'   => '1',
	) ) );
		

	stainedglass_create_social_icons_section( $wp_customize );
	
	
	$wp_customize->add_setting( 'is_header_on_front_page_only', array(
		'default'        => $defaults['is_header_on_front_page_only'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_checkbox'
	) );
	

	$wp_customize->add_control( 'is_header_on_front_page_only', array(
		'label'      => __( 'Display Header Image on the Front Page only', 'stainedglass' ),
		'section'    => 'header_image',
		'settings'   => 'is_header_on_front_page_only',
		'type'       => 'checkbox',
		'priority'       => 40,
	) );	

}
add_action( 'customize_register', 'stainedglass_customize_register_other' );
/**
 * Create icon section in Customizer
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 *
 * @since Stained Glass 1.0.0
 */

function stainedglass_create_social_icons_section( $wp_customize ){
	$icons = stainedglass_social_icons();
	
//New section in customizer: Featured Image
	$wp_customize->add_section( 'stainedglass_icons', array(
		'title'          => __( 'Social Media Icons', 'stainedglass' ),
		'description'          => __( 'Add your Social Media Links', 'stainedglass' ),
		'priority'       => 101,
		'panel'  => 'other',
	) );
	
	$i = 0;
	foreach($icons as $id => $icon ) {
		$wp_customize->add_setting( $id, array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'stainedglass_sanitize_url'
		) );
		
		$wp_customize->add_control( 'stainedglass_icons_'.$id, array(
			'label'      => strtoupper($id),
			'section'    => 'stainedglass_icons',
			'settings'   => $id,
			'type'       => 'text',
			'priority'   => $i++,
		) );	
	}
}
/**
 * Return array Default Icons
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_social_icons(){
	$icons = array(
					'facebook' => '',
					'twitter' => '',
					'google' => '',
					'wordpress' => '',
					'blogger' => '',
					'yahoo' => '',
					'youtube' => '',
					'myspace' => '',
					'livejournal' => '',
					'linkedin' => '',
					'friendster' => '',
					'friendfeed' => '',
					'digg' => '',
					'delicious' => '',
					'aim' => '',
					'ask' => '',
					'buzz' => '',
					'tumblr' => '',		
					'flickr' => '',						
					'rss' => '',
				  );
	return apply_filters( 'stainedglass_icons', $icons);
}
