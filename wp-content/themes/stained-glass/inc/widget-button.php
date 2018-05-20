<?php
/**
 * Widget Recent Posts
 * @since Stained Glass 1.0.0
 */
class stainedglass_widget_button extends WP_Widget {

	/**
	 * Widget constructor
	 *
	 * @since Stained Glass 1.0.0
	 *
	*/
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'stainedglass_widget_button',
		'description' => __('Display Buttons', 'stainedglass' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 200,
		'id_base' => 'stainedglass_widget_button');

		/* Create the widget. */		
		parent::__construct( 'stainedglass_widget_button', __( 'GL Buttons (GLASS)', 'stainedglass' ), $widget_ops, $control_ops );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}
	
	/**
	 * Widget styles
	 *
	 * @since Stained Glass 1.0.0
	 *
	*/
	public function enqueue_styles() {
		wp_enqueue_style( 'stainedglass-button', get_template_directory_uri() . '/inc/css/button.css');
	}

	/**
	 * Widget output
	 *
	 * @since Stained Glass 1.0.0
	 *
	*/
	function widget( $args, $instance ) {
	
		$instance = wp_parse_args( (array) $instance, $this->defaults() );	
		$instance = wp_parse_args( (array) $instance, $this->defaults_for_count($instance, $instance['count']) ); 

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		
		echo $args['before_widget'];

		//print the widget for the sidebar
		?>
		<div class="stainedglass-button">
		<?php
				
			if( trim( '' !== $title) ) echo $args['before_title'].esc_html($title).$args['after_title'];
			
			for( $i = 0; $i < $instance['count']; $i++) {
			?>
				<a class="stainedglass-link" href="<?php echo esc_attr( $instance['link_'.$i]); ?>"><?php echo esc_html( $instance['caption_'.$i]); ?></a>
			<?php	
			}			
		?>
		</div><!-- .stainedglass-button -->
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Data validation
	 *
	 * @since Stained Glass 1.0.0
	 *
	 * @param array $new_instance Array of widget options.
	 * @param array $old_instance Array of old widget options.
	*/
	function update( $new_instance, $old_instance ) {
		// Save widget options
		$tags = array(
			'a' => array(
				'href' => array(),
				'title' => array()
			),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
		);
		$instance['title_0'] = wp_kses($new_instance['title'], $tags);
		$instance['caption_0'] = wp_kses($new_instance['caption_0'], $tags);
		$instance['count'] = absint($new_instance['count'] );
		$instance['link_0'] = esc_url_raw( $new_instance['link_0'] );

		
		for( $i = 0; $i < $instance['count']; $i++ ) {
			$instance['link_'.$i] = esc_url_raw($new_instance['link_'.$i]);
			$instance['caption_'.$i] = wp_kses($new_instance['caption_'.$i], $tags); 
		}
		
		return $instance;
	}

	/**
	 * Widget form
	 *
	 * @since Stained Glass 1.0.0
	 *
	 * @param array $instance Array of widget options.
	*/
	function form( $instance ) {
		// Set up some default widget settings. 
		$instance = wp_parse_args( (array) $instance, $this->defaults() );
		$instance = wp_parse_args( (array) $instance, $this->defaults_for_count($instance, $instance['count']) ); 
	
	   stainedglass_echo_input_text( $this, 'title', $instance, __( 'Title: ', 'stainedglass' )); 

		for( $i = 0; $i < $instance['count']; $i++) {
			?> 
			<hr>
			<hr>
			<p style="font-size: 30px; color: red; "> 
				<?php 
					esc_html_e('Button ', 'stainedglass'); 
					echo ($i + 1); 
				?>
			</p>
			<hr>
			<hr>

			<?php 
			stainedglass_echo_input_text( $this, 'link_'.$i, $instance, __( 'URL: ', 'stainedglass' ));
			stainedglass_echo_input_text( $this, 'caption_'.$i, $instance, __( 'Caption', 'stainedglass'));
		}
	   stainedglass_echo_input_text( $this, 'count', $instance, __( 'Count: ', 'stainedglass' )); 	
}

	/**
	 * Return array Defaults
	 *
	 * @since Stained Glass 1.0.0
	 */
	function defaults(){
	
		// Set up some default widget settings. 
		$defaults = array('title' => '',
						  'count' => '1',
						  'link_0' => '#',
						  'caption_0' => __('More Info', 'stainedglass'),
						);
		
		return $defaults;
	}

	/**
	 * Return array Defaults for 1+n buttons
	 *
	 * @since Stained Glass 1.0.0
	 *
	 * @param int $count count of fields
	 */
	function defaults_for_count( $instance, $count ){
	
		$defaults = array();
		for( $i = 1; $i < $count; $i++ ) {
			$defaults['link_'.$i] = '#'; 
			$defaults['caption_'.$i] = __('Read more...', 'stainedglass');
		}
		
		return $defaults;
	}	
}
/**
 * Register widget
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_register_button_widget() {
	register_widget( 'stainedglass_widget_button' );
}
add_action( 'widgets_init', 'stainedglass_register_button_widget' );