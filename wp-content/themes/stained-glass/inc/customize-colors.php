<?php
/**
 * Class to add custom colors controls
 *
 * @since Stained Glass 1.0.0
 */

class stainedglass_Colors_Class {

	private $colors = array();
	private $sections = array();
	private $color_schemes = array();
	private $color_scheme = null;
	
	function __construct() {
		$defaults = stainedglass_get_defaults();
	
		$this->color_scheme = $defaults['color_scheme'];
				
		$this->add_scheme(0, __('Main', 'stainedglass'));
		
		$section_id = 'main_colors';
		$section_priority = 10;
		$p = 0;
		
		$this->add_section($section_id, __('Main Colors', 'stainedglass'), __('Main website colors', 'stainedglass'), $section_priority++);

	/* colors */
	
		$i = 'site_name_back';
		
		$this->add_color($i, $section_id, __('Site Name and Description Background', 'stainedglass'), $p++, true);
		$this->set_color($i, 0, '#fff', 0.9);
		$this->set_color($i, 1, '#fff', 0.9);
		$this->set_color($i, 2, '#fff', 0.9);
		
		$i = 'link_color';
		
		$this->add_color($i, $section_id, __('Link', 'stainedglass'), $p++, false);
		$this->set_color($i, 0, '#1e73be');
		$this->set_color($i, 1, '#1e73be');
		$this->set_color($i, 2, '#1e73be');
		
		$i = 'heading_color';
		
		$this->add_color($i, $section_id, __('H1-H6 heading', 'stainedglass'), $p++, false);
		$this->set_color($i, 0, '#a0a0a0');
		$this->set_color($i, 1, '#a0a0a0');
		$this->set_color($i, 2, '#3f3f3f');
		
		$i = 'heading_link';
		
		$this->add_color($i, $section_id, __('H1-H6 Link', 'stainedglass'), $p++, false);
		$this->set_color($i, 0, '#1e73be');	
		$this->set_color($i, 1, '#1e73be');	
		$this->set_color($i, 2, '#1e73be');	
		
		$i = 'description_color';
		
		$this->add_color($i, $section_id, __('Description', 'stainedglass'), $p++, false);
		$this->set_color($i, 0, '#ccc');	
		$this->set_color($i, 1, '#ccc');
		$this->set_color($i, 2, '#ccc');
		
		$i = 'hover_color';
		
		$this->add_color($i, $section_id, __('Link Hover', 'stainedglass'), $p++, false);
		$this->set_color($i, 0, '#a71fdd');
		$this->set_color($i, 1, '#a71fdd');
		$this->set_color($i, 2, '#a71fdd');

//section buttons
		$section_id = 'buttons';
		$p = 0;
		
		$this->add_section($section_id, __('Widget Buttons', 'stainedglass'), __('Colors for the Widget Buttons in the top and before footer sidebars', 'stainedglass'), $section_priority++);

		$i = 'buttons_color';

		$this->add_color($i, $section_id, __('Background', 'stainedglass'), $p++, true);
		$this->set_color($i, 0, '#fff', 0.8);	
		$this->set_color($i, 1, '#112233', 0.7);
		$this->set_color($i, 2, '#112233', 0.7);
		
		$i = 'buttons_button';
				
		$this->add_color($i, $section_id, __('Button Color', 'stainedglass'), $p++, true);
		$this->set_color($i, 0, '#fff', 1);
		$this->set_color($i, 1, '#123', 1);
		$this->set_color($i, 2, '#123', 1);
		
		$i = 'buttons_link';

		$this->add_color($i, $section_id, __('Link', 'stainedglass'), $p++, false);
		$this->set_color($i, 0, '#000');
		$this->set_color($i, 1, '#fff');
		$this->set_color($i, 2, '#fff');
		
		$i = 'buttons_hover';

		$this->add_color($i, $section_id, __('Hover', 'stainedglass'), $p++, false, 'refresh');
		$this->set_color($i, 0, '#000');
		$this->set_color($i, 1, '#fff');
		$this->set_color($i, 2, '#fff');
		
		$i = 'buttons_border';

		$this->add_color($i, $section_id, __('Border', 'stainedglass'), $p++, true);
		$this->set_color($i, 0, '#ccc');
		$this->set_color($i, 1, '#fff');
		$this->set_color($i, 2, '#eeeeee');
		
		add_action( 'customize_register', array( $this, 'stainedglass_create_colors_controls' ), 21 );
		add_action( 'stainedglass_option_defaults', array( $this, 'stainedglass_add_defaults' ) );

	}
	
	public function add_section($name, $title, $description, $priority, $panel = 'custom_colors') {
	
		$this->sections[$name]['title'] = $title;
		$this->sections[$name]['description'] = $description;
		$this->sections[$name]['priority'] = $priority;
		$this->sections[$name]['panel'] = $panel;
		
	}

	// Set color properties
	public function add_color($name, $section, $title, $priority, $is_has_opacity = false, $transport = 'postMessage') {
	
		$this->colors[$name]['section'] = $section;
		$this->colors[$name]['val'] = '';
		$this->colors[$name]['text'] = $title;
		$this->colors[$name]['priority'] = $priority;
		$this->colors[$name]['is_has_opacity'] = $is_has_opacity;
		$this->colors[$name]['transport'] = $transport;
		
	}
	
	// Set color value and opacity for the color scheme
	public function set_color($name, $color_scheme, $color, $opacity = 1) {

		$this->colors[$name][$color_scheme]['def_val'] = $color;
		$this->colors[$name][$color_scheme]['def_op'] = $opacity;
		
	}
	
	// Return hex color value
	public function get_color( $name ) {

		$color = get_theme_mod($name, $this->colors[$name][get_theme_mod('color_scheme', $this->color_scheme)]['def_val']);
		
		if ( $this->colors[$name]['is_has_opacity'] ) {
			$opacity = get_theme_mod($name.'_opacity', $this->colors[$name][get_theme_mod('color_scheme', $this->color_scheme)]['def_op']);
			
			if ( 0 == $opacity ) {
				$color = 'transparent';
			}
			else if ( 1 != $opacity ) {
				$color = $this->hex_to_rgba($color, $opacity);
			}
		}
		
		return $color;
	}
	
	// Add new color scheme
	public function add_scheme( $id, $text) {
		$this->color_schemes[$id] = $text;
	}
	
	// Return color schemes
	public function get_schemes() {
		return $this->color_schemes;
	}
	
	// Add sections and controls to the Customizer
	public function stainedglass_create_colors_controls( $wp_customize ) {

		$wp_customize->add_panel( 'custom_colors', array(
			'priority'       => 3,
			'title'          => __( 'Customize Colors', 'stainedglass' ),
			'description'    => __( 'In this section you can change colors for different elements.', 'stainedglass' ),
		) );
	
	
		// Register Customizer sections
		foreach( $this->sections as $id => $section ) {
		
			$wp_customize->add_section( $id, array(
				'priority'       => $section['priority'],
				'title'          => $section['title'],
				'description'    => $section['description'],
				'panel'  => $section['panel'],
			) );
			
		}	
		// Register Customizer settings and controls
		foreach( $this->colors as $id => $colors ) {
			$p = $colors['priority'];
				
			$wp_customize->add_setting( $id, array(
				'default'        => $colors[get_theme_mod('color_scheme', $this->color_scheme)]['def_val'],
				'transport'		 => $colors['transport'],
				'capability'     => 'edit_theme_options',
				'sanitize_callback' => 'stainedglass_sanitize_hex_color'
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
				'label'   => $colors['text'],
				'section' => $colors['section'],
				'settings'   => $id,
				'priority' =>  $colors['priority'],
			) ) );
			
			if( $colors['is_has_opacity'] ) {
				$wp_customize->add_setting( $id.'_opacity', array(
					'default'        => $colors[get_theme_mod('color_scheme', $this->color_scheme)]['def_op'],
					'transport'		 => 'postMessage',
					'capability'     => 'edit_theme_options',
					'sanitize_callback' => 'stainedglass_sanitize_opacity'
				) );
				
				$wp_customize->add_control( $id.'_opacity', array(
					'label'      => __('Opacity for the ', 'stainedglass').$colors['text'],
					'section'    => $colors['section'],
					'settings'   => $id.'_opacity',
					'type'       => 'select',
					'priority'   => $colors['priority'],
					'choices'	 => array (
										   '0' => '0',
										   '0.1' => '0.1', 
										   '0.2' => '0.2', 
										   '0.3' => '0.3', 
										   '0.4' => '0.4', 
										   '0.5' => '0.5',
										   '0.6' => '0.6', 
										   '0.7' => '0.7',
										   '0.8' => '0.8',
										   '0.9' =>  '0.9',
										   '1' => '1')
				) );
				$wp_customize->add_setting( $id.'_opacity_range', array(
					'type'			 => 'empty',
					'default'        => 10*get_theme_mod($id.'_opacity', $colors[get_theme_mod('color_scheme', $this->color_scheme)]['def_op']),
					'capability'     => 'edit_theme_options',
					'transport'		 => 'postMessage',
					'sanitize_callback' => 'absint'
				) );

				$wp_customize->add_control( $id.'_opacity_range', array(
					'label'      => '',
					'section'    => $colors['section'],
					'settings'   => $id.'_opacity_range',
					'type'       => 'range',
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 10,
						'step'  => 1,),
						'priority' =>  $colors['priority'],
				));
			}
		}
	}
	
	/**
	 * Transform hex color to rgba
	 *
	 * @param string $color hex color. 
	 * @param int $opacity opacity. 
	 * @return string rgba color.
	 * @since Stained Glass 1.0.0
	 */
	function hex_to_rgba( $color, $opacity ) {

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
	/* Add values to defaults array */

	function stainedglass_add_defaults( $defaults ) {

		foreach( $this->colors as $id => $values ) {

			$defaults[ $id ] = $values[0]['def_val'];
			
		}

		return $defaults;
	}
}
/**
 * Return string Sanitized color scheme
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_sanitize_color_scheme( $value ) {
	global $stainedglass_colors_class;
	$defaults = stainedglass_get_defaults();
	$possible_values = $stainedglass_colors_class->get_schemes();
	return ( array_key_exists( $value, $possible_values ) ? $value : $defaults['color_scheme'] );
}