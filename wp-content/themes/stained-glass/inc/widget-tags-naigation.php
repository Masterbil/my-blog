<?php
/**
 * Add a widget for displaying portfolio navigation-filter
 *
 * @since Stained Glass 1.0.0
 */
 
class stainedglass_portfolio_tag_nav extends WP_Widget {
	/**
	 * Widget constructor
	 *
	 * @since Stained Glass 1.0.0
	 *
	*/
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'stainedglass_portfolio_tag_nav',
		'description' => __('Display portfolio tags navigation on both jetpack portfolio index and archive pages', 'stainedglass' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 200,
		'id_base' => 'stainedglass_portfolio_tag_nav');

		/* Create the widget. */		
		parent::__construct( 'stainedglass_portfolio_tag_nav', __( 'GL Portfolio Tags Nav (GLASS)', 'stainedglass' ), $widget_ops, $control_ops );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

	}
	
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
	
		/* display widget on portfolio index and archive pages only */
		if( ! ('jetpack-portfolio' == get_post_type()) || is_singular('jetpack-portfolio'))
			return;
	
		$instance = wp_parse_args( (array) $instance, $this->defaults() );	
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$tax = 'jetpack-portfolio-tag';
		
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
			
			echo '<ul class="jetpack-widget-tag-nav">';
			?>
			<li class="all current"><?php _e('All Tags', 'stainedglass') ?></li>
			<?php
			foreach( $tax_names as $id => $value ) { ?>
				 <li class="<?php echo esc_attr( $id); ?>"><?php echo $value; ?></li>
			<?php
			}
			echo '</ul>';
									
		?>
			<header>
		<article>
		<?php echo $args['after_widget']; ?>
		<?php
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
		$instance['title'] = esc_html($new_instance['title']);
	
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
		$defaults = array('title' => __( 'Tags', 'stainedglass' ),
						);
		
		return $defaults;
	}

	function echo_input_text($name, $instance, $title, $isp = 1, $size = 20) { ?>
		<?php echo ($isp ? '<p>' : '');?>
			<label for="<?php echo $this->get_field_id( $name );?>"><?php echo esc_html($title); ?></label>
			<input size="<?php echo $size;?>" type="text" name="<?php echo $this->get_field_name( $name ) ?>" id="<?php echo $this->get_field_id( $name ); ?>" value="<?php echo esc_attr( $instance[$name]); ?>" />		
		<?php echo($isp ? '</p>' : '');?>
		<?php
	}		
}
/**
 * Register widget
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_register_tag_nav_widget() {
	register_widget( 'stainedglass_portfolio_tag_nav' );
}
add_action( 'widgets_init', 'stainedglass_register_tag_nav_widget' );