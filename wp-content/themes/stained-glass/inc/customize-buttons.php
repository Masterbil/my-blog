<?php
/**
 * Add new fields to customizer, create panel 'Info'
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since Stained Glass 1.0.0
 */
 
function stainedglass_customize_register_info( $wp_customize ) {

	class Stained_Glass_Customize_Button_Control extends WP_Customize_Control {
		public $type = 'button';
	 
		/**
		 * Render the control's content.
		 *
		 *
		 * @since Stained Glass 1.0.0
		 */
		public function render_content() {
			?>
			<form>
			<input type="button" value="<?php echo esc_attr( $this->label ); ?>" onclick="window.open('<?php echo esc_url( $this->value() ); ?>')" />
			</form>
			<?php
		}

	}	

	$defaults = stainedglass_get_defaults();
	
	$wp_customize->add_panel( 'info', array(
		'priority'       => 0,
		'title'          => __( 'Info', 'stainedglass' ),
		'description'    => __( 'Info and Links.', 'stainedglass' ),
	) );

	$section_priority = 10;
	
//New section in customizer: Support
	$wp_customize->add_section( 'support', array(
		'title'          => __( 'Support', 'stainedglass' ),
		'description'          => __( 'Got something to say? Need help?', 'stainedglass' ),
		'priority'       => $section_priority++,
		'panel'  => 'info',
	) );
	
	//New setting in section: Support button
	$wp_customize->add_setting( 'support_url', array(
		'type'			 => 'empty',
		'default'        => 'https://wordpress.org/support/theme/stained-glass',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_url'
	) );
	
	$wp_customize->add_control( new Stained_Glass_Customize_Button_Control( $wp_customize, 'support_url', array(
		'label'   => __( 'View Support forum', 'stainedglass' ),
		'description'   => __( 'View Support forum', 'stainedglass' ),
		'section' => 'support',
		'settings'   => 'support_url',
		'priority'   => 10,
	) ) );
	
	//New section in customizer: Rate
	$wp_customize->add_section( 'rate', array(
		'title'          => __( 'Rate on WordPress.org', 'stainedglass' ),
		'description'          => __( 'Rate this theme. It would help to improve it.', 'stainedglass' ),
		'priority'       => $section_priority++,
		'panel'  => 'info',
	) );
	
	//New setting in rate section: Rate button
	$wp_customize->add_setting( 'rate_url', array(
		'type'			 => 'empty',
		'default'        => 'https://wordpress.org/support/view/theme-reviews/stained-glass#postform',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_url'
	) );
	
	$wp_customize->add_control( new Stained_Glass_Customize_Button_Control( $wp_customize, 'rate_url', array(
		'label'   => __( 'Add your review', 'stainedglass' ),
		'description'   => __( 'Rate', 'stainedglass' ),
		'section' => 'rate',
		'settings'   => 'rate_url',
		'priority'   => 10,
	) ) );	
	
	//New section in customizer: Doc Url
	$wp_customize->add_section( 'docs', array(
		'title'          => __( 'How to use a theme', 'stainedglass' ),
		'description'          => __( 'Documentation.', 'stainedglass' ),
		'priority'       => $section_priority++,
		'panel'  => 'info',
	) );
	
	//New setting in rate section: Rate button
	$wp_customize->add_setting( 'doc_url', array(
		'type'			 => 'empty',
		'default'        => 'http://wpblogs.ru/themes/documentation-stained-glass/',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'stainedglass_sanitize_url'
	) );
	
	$wp_customize->add_control( new Stained_Glass_Customize_Button_Control( $wp_customize, 'doc_url', array(
		'label'   => __( 'How to use a theme', 'stainedglass' ),
		'description'   => __( 'Theme Documentation', 'stainedglass' ),
		'section' => 'docs',
		'settings'   => 'doc_url',
		'priority'   => 10,
	) ) );

}
add_action( 'customize_register', 'stainedglass_customize_register_info' );