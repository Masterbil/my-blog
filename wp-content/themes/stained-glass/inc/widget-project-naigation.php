<?php
/**
 * Add a widget for displaying portfolio navigation-filter
 *
 * @since Stained Glass 1.0.0
 */
 
class stainedglass_portfolio_nav extends WP_Widget {
	/**
	 * Widget constructor
	 *
	 * @since Stained Glass 1.0.0
	 *
	*/
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'stainedglass_portfolio_nav',
		'description' => __('Display portfolio navigation on jetpack portfolio category/index page', 'stainedglass' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 200,
		'id_base' => 'stainedglass_portfolio_nav');

		/* Create the widget. */		
		parent::__construct( 'stainedglass_portfolio_nav', __( 'GL Portfolio Project Nav (GLASS)', 'stainedglass' ), $widget_ops, $control_ops );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

	}
	/**
	 * Widget styles
	 *
	 * @since Stained Glass 1.0.0
	 *
	*/
	public function enqueue_styles() {
		wp_enqueue_script( 'stainedglass-portfolio-nav', get_template_directory_uri() . '/inc/js/portfolio-nav.js', array('jquery') );
	}
	/**
	 * Widget output
	 *
	 * @since Stained Glass 1.0.0
	 *
	*/
	function widget( $args, $instance ) {
	
		$instance = wp_parse_args( (array) $instance, $this->defaults() );	
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$tax = 'jetpack-portfolio-type';
		
		//print the widget for the sidebar
		if ( have_posts() ) : 
		
		echo $args['before_widget'];

		?>
		<article>
			<header>
		<?php
		
			$tax_names = array();
		
			if(trim( '' !== $title)) echo $args['before_title'].esc_html($title).$args['after_title'];

			$tax_names = stainedglass_get_tax_ids( $tax ); 
			
			echo '<ul class="jetpack-widget-nav">';
			?>
			<li class="all current"><?php _e('All Projects', 'stainedglass') ?></li>
			<?php
			foreach( $tax_names as $id => $value ) { ?>
				 <li class="<?php echo esc_attr( $id ); ?>"><?php echo $value; ?></li>
			<?php
			}
			echo '</ul>';
									
		?>
			<header>
		<article>
		<?php
		echo $args['after_widget'];
		endif; // End check for posts.

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
		$instance['title'] = wp_kses($new_instance['title'], $tags);

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
	
	   stainedglass_echo_input_text( $this, 'title', $instance, __( 'Title: ', 'stainedglass' )); ?>
<?php
}

	/**
	 * Return array Defaults
	 *
	 * @since Stained Glass 1.0.0
	 */
	function defaults(){
	
		// Set up some default widget settings. 
		$defaults = array( 'title' => __( 'Projects', 'stainedglass' ), );
		
		return $defaults;
	}
	
}
/**
 * Register widget
 *
 * @since Stained Glass 1.0.0
 */
 function stainedglass_register_nav_widget() {
	register_widget( 'stainedglass_portfolio_nav' );
}
add_action( 'widgets_init', 'stainedglass_register_nav_widget' );