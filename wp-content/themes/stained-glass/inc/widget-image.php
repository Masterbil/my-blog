<?php
/**
* Widget for displaying Image with caption, title and Link
*
* @since Stained Glass 1.0.0
*/
 
class stainedglass_image extends WP_Widget {

	/**
	 * Widget constructor
	 *
	 * @since Stained Glass 1.0.0
	 *
	*/
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'stainedglass_image',
		'description' => __('Display Custom Images with CSS3 hover effects.', 'stainedglass' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 250,
		'id_base' => 'stainedglass_image_widget');


		/* Create the widget. */		
		parent::__construct( 'stainedglass_image_widget', __( 'GL Images (GLASS)', 'stainedglass' ), $widget_ops, $control_ops );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}
	
	/**
	 * Widget styles
	 *
	 * @since Stained Glass 1.0.0
	 *
	*/
	public function enqueue_styles() {
		wp_enqueue_style( 'stainedglass-image', get_template_directory_uri() . '/inc/css/image.css');
		wp_enqueue_script( 'stainedglass-image-script', get_template_directory_uri() . '/inc/js/image-widget.js', array('jquery'), '20151012', true );
	}

	/**
	 * Widget scripts
	 *
	 * @since Stained Glass 1.0.0
	 *
	*/
	public function enqueue_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_media();

		wp_enqueue_script( 'stainedglass-upload-image', get_template_directory_uri() . '/inc/js/meta-box-image.js', array('jquery') );

	}

	/**
	 * Widget output
	 *
	 * @since Stained Glass 1.0.0
	 *
	*/
	function widget( $args, $instance ) {

		// Widget output
		extract($args);
		$sidebar_id = ( isset($args['id']) ? $args['id'] : '' );
		
		// Set up some default widget settings. 
						
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) );
		$instance = wp_parse_args( (array) $instance, $this->defaults_for_count($instance, $instance['count']) ); 
		preg_match_all('!\d+!', $instance['columns'], $matches);
		$width = $this->get_width($sidebar_id, absint(implode(' ', $matches[0])), $instance['padding_right'], $instance['padding_left']);
		$tags = array(
			'a' => array(
				'href' => array(),
				'title' => array()
			),
			'ul' => array(),
			'li' => array(),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
		);
		//print the widget for the sidebar
		echo $before_widget;
		if(trim($instance['title']) !== '') echo $before_title.esc_html($instance['title']).$after_title;
		
		$pos_class = '';
		if( 0 != $instance['is_has_description'] ) {
			$pos_class = (($instance['is_right']) == 1 ? ' right' : ' left');
		}
		
		?>
		<div class="main-wrapper-image <?php echo $pos_class;?>" style="padding:<?php echo esc_attr( $instance['padding_top']);?>px <?php echo esc_attr( $instance['padding_right']);?>% <?php echo esc_attr( $instance['padding_bottom'])?>px <?php echo esc_attr( $instance['padding_left'])?>%">
			<?php if( 0 != $instance['is_has_description']) : ?>
			
			<div class="description">
				<article>
					<header>
						<h3 class="main-title"><?php echo esc_html( $instance['main_title']);?></h3>
					</header>
					<p><?php echo wp_kses( $instance['main_description'], $tags );?></p>
				</article>
			</div> <!-- .description -->
			
			<?php endif; ?>

			<div class="wrapper-image <?php echo esc_attr($instance['columns']).( $instance['is_step'] ? ' step' : ' all' ).( $instance['is_hover_all'] ? ' hover-all' : '' ).( $instance['is_margin_0'] ? ' margin-0' : '' );?>">
				
				<?php 	
					for( $i = 0; $i < $instance['count']; $i++ ) {
					?>
					
						<div class="element <?php echo esc_attr( $instance['effect_id_'.$i]).( $instance['is_animate_once_'.$i] ? ' once' : '' ).( $instance['is_animate_'.$i] ? ' animate' : '' ).( $instance['is_zoom_'.$i] ? ' zoom' : '' );?>">
							<article>
								<?php if( isset( $instance['image_link_'.$i] ) ) : 
									
									if( 1 == $instance['is_background'] ) :  ?>
									
										<div class="entry-thumbnail" style="background-image:url('<?php echo esc_url($instance['image_link_'.$i]);?>')"></div>
									
									<?php else : ?>

										<img src="<?php echo esc_url($instance['image_link_'.$i]);?>" alt="<?php echo esc_attr( $instance['title_'.$i]);?>"/>
										
									<?php endif; ?>
								
								<?php else : ?>

									<?php echo wp_get_attachment_image($instance['image_'.$i], $instance['image_size']); ?>
								
								<?php endif; ?>
							
								<div class="hover">
								
									<header>
										<h2 class="entry-title"><?php echo esc_html( $instance['title_'.$i]);?></h2>
									</header><!-- header -->
									
									<p><?php echo wp_kses( $instance['text_'.$i], $tags );?></p>
									
									<?php if ( '' != $instance['is_link_'.$i] ) : ?>
									<a href="<?php echo esc_url($instance['link_'.$i]); ?>" class="link"><?php echo esc_html( $instance['link_caption_'.$i]); ?></a>
									<?php endif; ?>
									
								</div><!-- .hover -->
								
							</article>
						</div><!-- .element -->
							
					<?php } ?>
		
					<div class="clear"></div>
			</div><!-- .wrapper-image -->
			<div class="hide-element"></div>
		</div><!-- .main-wrapper -->
		<?php
		echo $after_widget;
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
			
		$tags = array(
			'a' => array(
				'href' => array(),
				'title' => array()
			),
			'ul' => array(),
			'li' => array(),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
		);
		// Save widget options
		
		$instance['count'] = absint($new_instance['count']);
		$instance['count'] = ( $instance['count'] > 0 ? $instance['count'] : 1 );
		
		$instance['title'] = esc_html($new_instance['title']); 
		$possible_values = array('column-1', 'column-2', 'column-3', 'column-4');	
		$instance['columns'] = ( in_array( $new_instance['columns'], $possible_values ) ? $new_instance['columns'] : 'column-1');
		
		$possible_values = array('post-thumbnail', 'thumbnail', 'large', 'full');	
		$instance['image_size'] = ( in_array( $new_instance['image_size'], $possible_values ) ? $new_instance['image_size'] : 'post-thumbnail');
		
		if( isset($new_instance['is_background']) )
			$instance['is_background'] = 1;			
		if( isset($new_instance['is_margin_0']) )
			$instance['is_margin_0'] = 1;		
		if( isset($new_instance['is_step']) )
			$instance['is_step'] = 1;
		if( isset($new_instance['is_hover_all']))
			$instance['is_hover_all'] = 1;		
		if( isset($new_instance['is_has_description']))
			$instance['is_has_description'] = 1;		
		if( isset($new_instance['is_right']))
			$instance['is_right'] = 1;	

		$instance['padding_right'] = 0;
		$instance['padding_left'] = 0;

		$instance['padding_top'] = ( 1 == $new_instance['is_margin_0'] ? 0 : 20);
		$instance['padding_bottom'] = ( 1 == $new_instance['is_margin_0'] ? 0 : 20);

		$instance['padding_top'] = absint($new_instance['padding_top']);
		$instance['padding_bottom'] = absint($new_instance['padding_bottom']);
	
		$instance['main_title'] = esc_html($new_instance['main_title']);
		$instance['main_description'] = wp_kses( $new_instance['main_description'], $tags );
		
		for( $i = 0; $i < $new_instance['count']; $i++ ) {
			$instance['title_'.$i] = esc_html($new_instance['title_'.$i]); 
			$instance['text_'.$i] = wp_kses( $new_instance['text_'.$i], $tags ); 
			$instance['image_'.$i] = absint($new_instance['image_'.$i]);
			$instance['link_'.$i] = esc_url_raw($new_instance['link_'.$i]);
			$img = wp_get_attachment_image_src( $new_instance['image_'.$i], $new_instance['image_size']);
			$instance['image_link_'.$i] = esc_url_raw($img[0]);
			$possible_values = array('effect-1', 
									'effect-2', 
									'effect-3', 
									'effect-4', 
									'effect-5', 
									'effect-6',
									'effect-7', 
									'effect-8', 
									'effect-9', 
									'effect-10', 
									'effect-11', 
									'effect-12', 
									'effect-14', 
									'effect-15', 
									'effect-16',
									'effect-17',
									'effect-18',
									'effect-19',
									'effect-20',
									);	
			$instance['effect_id_'.$i] = ( in_array( $new_instance['effect_id_'.$i], $possible_values ) ? $new_instance['effect_id_'.$i] : 'effect-1');
			if( isset($new_instance['is_animate_'.$i]) )
				$instance['is_animate_'.$i] = 1;
			if( isset($new_instance['is_animate_once_'.$i]) )
				$instance['is_animate_once'.$i] = 1;
			if( isset($new_instance['is_zoom_'.$i]) )
				$instance['is_zoom_'.$i] = 1;
			if( isset($new_instance['is_link_'.$i]) )
				$instance['is_link_'.$i] = 1;
			$instance['link_caption_'.$i] = esc_html($new_instance['link_caption_'.$i]); 
			
		}
		
		return $instance;
	}

	function form( $instance ) {
		// Output admin widget options form
		// Set up some default widget settings. 
						
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) ); 
		$instance = wp_parse_args( (array) $instance, $this->defaults_for_count($instance, $instance['count']) ); 
		
		stainedglass_echo_input_text( $this, 'title', $instance, __( 'Title: ', 'stainedglass' ), 0);
		
		esc_html_e('Columns:', 'stainedglass'); ?>
		<select id="<?php echo $this->get_field_id('columns'); ?>" name="<?php echo $this->get_field_name('columns'); ?>" style="width:100%;">
		<?php 
			$styles=array( __('1', 'stainedglass'), __('2', 'stainedglass'), __('3', 'stainedglass'), __('4', 'stainedglass'));
			$styles_ids=array('column-1', 'column-2', 'column-3', 'column-4');

			for ($i=0; $i<4; $i++) {
				echo '<option value="'.esc_attr($styles_ids[$i]).'" ';
				selected( $instance['columns'], $styles_ids[$i] );
				echo '>'.esc_html($styles[$i]).'</option>';
			}
		?>
		</select>
		
		<?php 
		esc_html_e('Image Size:', 'stainedglass'); ?>
		<select id="<?php echo $this->get_field_id('image_size'); ?>" name="<?php echo $this->get_field_name('image_size'); ?>" style="width:100%;">
		<?php 
			$styles=array( __('Post Thumbnail', 'stainedglass'), __('Thumbnail', 'stainedglass'), __('Large', 'stainedglass'), __('Full', 'stainedglass'));
			$styles_ids=array('post-thumbnail', 'thumbnail', 'large', 'full');

			foreach($styles as $i => $type) {
				echo '<option value="'.esc_attr($styles_ids[$i]).'" ';
				selected( $instance['image_size'], $styles_ids[$i] );
				echo '>'.esc_html($styles[$i]).'</option>';
			}
		?>
		</select>
		
		<?php 
		
		stainedglass_echo_input_text( $this, 'count', $instance, __( 'Number of Images (Press Apply): ', 'stainedglass' ), 0);
		
		stainedglass_echo_section_start( __( 'Main options', 'stainedglass' ), $this->get_field_id( 'is_background' ) );
		
		stainedglass_echo_input_checkbox( $this, 'is_background', $instance, __( 'Background Image', 'stainedglass'));
		stainedglass_echo_input_checkbox( $this, 'is_step', $instance, __( 'Step Animation', 'stainedglass'));
		stainedglass_echo_input_checkbox( $this, 'is_margin_0', $instance, __( 'No Margins', 'stainedglass'));
		
		if( $instance['is_has_description'] != 0 ) {
			stainedglass_echo_input_checkbox( $this, 'is_right', $instance, __( 'Right', 'stainedglass'));
			stainedglass_echo_input_text( $this, 'main_title', $instance, __( 'Main Title: ', 'stainedglass' ));
			stainedglass_echo_input_textarea( $this, 'main_description', $instance, __( 'Main Description: ', 'stainedglass' ) );
		}
		
		stainedglass_echo_section_end();
		
		?>
		<hr>
		<?php

		for( $i = 0; $i < $instance['count']; $i++) {
		
			stainedglass_echo_section_main_start( __( 'Image', 'stainedglass' ) . ' ' . ( $i + 1 ), $this->get_field_id( 'image_'.$i ) . $i );

			?> 
			<hr>
			<hr>
			<p style="font-size: 20px; color: red; "> 
				<?php 
					esc_html_e('Image ', 'stainedglass'); 
					echo ($i + 1); 
				?>
			</p>
			<hr>
			<hr>

			<?php 
			stainedglass_echo_input_upload_id( $this, 'image_'.$i, $instance, __( 'Image: ', 'stainedglass' ));
			stainedglass_echo_input_text( $this, 'title_'.$i, $instance, __( 'Header: ', 'stainedglass' ));
			stainedglass_echo_input_hover_style( $this, 'effect_id_'.$i, $instance);
			
				stainedglass_echo_section_start( __( 'More options', 'stainedglass' ), $this->get_field_id( 'text_'.$i ) . $i );

					stainedglass_echo_input_textarea( $this, 'text_'.$i, $instance, __( 'Text: ', 'stainedglass' ));
					stainedglass_echo_input_text( $this, 'link_'.$i, $instance, __( 'Link: ', 'stainedglass' ));
					stainedglass_echo_input_checkbox( $this, 'is_animate_'.$i, $instance, __( 'Animate', 'stainedglass'));
					stainedglass_echo_input_checkbox( $this, 'is_animate_once_'.$i, $instance, __( 'Once', 'stainedglass'));
					stainedglass_echo_input_checkbox( $this, 'is_zoom_'.$i, $instance, __( 'Transparent', 'stainedglass'));
					stainedglass_echo_input_checkbox( $this, 'is_link_'.$i, $instance, __( 'Display Link', 'stainedglass'));
					stainedglass_echo_input_text( $this, 'link_caption_'.$i, $instance, __( 'Button caption: ', 'stainedglass' ), 0);
				
				stainedglass_echo_section_end();
				
			stainedglass_echo_section_main_end();
		}
				
	}
	
	/**
	 * Return array Defaults
	 *
	 * @since Stained Glass 1.0.0
	 */
	function defaults( $instance ){
	
		$defaults = array('title' => __('Title', 'stainedglass'),
						  'count'   => '1',	
						  'columns'   => 'column-1',	
						  'image_size'   => 'post-thumbnail',	
						  'is_background'   => ( isset( $instance['title'] ) ? '' : 1 ),	
						  'is_step'   => '',
						  'is_hover_all'   => '',
						  'is_margin_0'   => ($instance == null ? 1 : ''),
						  'title_0'   => ( isset( $instance['title'] ) ? '' : 1 ),
						  'image_0'   => '',	
						  'text_0'   => '',	
						  'link_0'   => '#',	
						  'effect_id_0'   => 'effect-1',
						  'is_animate_0'   => '',
						  'is_animate_once_0'   => ( isset( $instance['title'] ) ? '' : 1 ),
						  'is_zoom_0'   => '',
						  'is_link_0'   => ( isset( $instance['title'] ) ? '' : 1 ),
						  'link_caption_0'   => __('Read more...', 'stainedglass'),
						  'padding_right'   => '0',
						  'padding_left'   => '0',
						  'padding_top'   => '0',
						  'padding_bottom'   => '0',
						  'is_has_description'   => 0,
						  'main_description'   => __( 'Description...', 'stainedglass' ),
						  'main_title'   => __( 'Title...', 'stainedglass' ),
						  'is_right'   => ( isset( $instance['title'] ) ? '' : 1 ),
						);
		
		return $defaults;
	}
	/**
	 * Return array Defaults
	 *
	 * @param int $count count of fields
	 * @since Stained Glass 1.0.0
	 */
	function defaults_for_count( $instance, $count ){
	
		$defaults = array();
		for( $i = 1; $i < $count; $i++ ) {
			$defaults['title_'.$i] = __('Title', 'stainedglass'); 
			$defaults['text_'.$i] = ''; 
			$defaults['link_'.$i] = ''; 
			$defaults['image_'.$i] = ''; 
			$defaults['effect_id_'.$i] = 'effect-1'; 
			$defaults['is_animate_'.$i] = ''; 
			$defaults['is_animate_once_'.$i] = ( ! isset($instance['effect_id_'.$i]) ? 1 : ''); 
			$defaults['is_zoom_'.$i] = ''; 
			$defaults['is_link_'.$i] = ( ! isset($instance['effect_id_'.$i]) ? 1 : '');
			$defaults['link_caption_'.$i] = __('Read more...', 'stainedglass');
		}
		
		return $defaults;
	}
	
	/* widget column width
	 * @param int $sidebar_id sidebar id.
	 * @param int $columns number of $columns.
	 * @param int $i1 widget left margin.
	 * @param int $i2 widget right margin.
	 * @return int width.
	 * @since Stained Glass 1.0.0
	 */
	function get_width( $sidebar_id, $columns, $i1 = 0, $i2 = 0 ) {	
		if($columns <= 0) $columns = 1;
		$width = stainedglass_get_sidebar_width($sidebar_id);
		$width = ($width - $width*$i1/100 - $width*$i2/100)/$columns;
		return $width;
	}
}
/**
 * Register widget
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_register_image_widgets() {
	register_widget( 'stainedglass_image' );
}
add_action( 'widgets_init', 'stainedglass_register_image_widgets' );
