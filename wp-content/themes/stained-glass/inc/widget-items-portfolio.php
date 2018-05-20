<?php
/**
 * Add a widget for displaying portfolio items
 *
 * @since Stained Glass 1.0.0
 */
 
class stainedglass_items_portfolio extends WP_Widget {
	/**
	 * Widget constructor
	 *
	 * @since Stained Glass 1.0.0
	 *
	*/
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'stainedglass_items_portfolio',
		'description' => __('Display Items from Portfolio.', 'stainedglass' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 250,
		'id_base' => 'stainedglass_items_portfolio_widget');


		/* Create the widget. */		
		parent::__construct( 'stainedglass_items_portfolio_widget', __( 'GL Items from Portfolio (GLASS)', 'stainedglass' ), $widget_ops, $control_ops );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}
	/* enqueue widget styles */
	public function enqueue_styles() {
		wp_enqueue_style( 'stainedglass-image', get_template_directory_uri() . '/inc/css/image.css');
		wp_enqueue_script( 'stainedglass-image-script', get_template_directory_uri() . '/inc/js/image-widget.js', array('jquery'), '20151012', true );
	}

	/* enqueue widget scripts */
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
		preg_match_all('!\d+!', $instance['columns'], $matches);
		$width = $this->get_width($sidebar_id, absint(implode(' ', $matches[0])), $instance['padding_right'], $instance['padding_left']);

		global $post;
		$not_in = array();
		if( is_singular() ) {
			$not_in []= $post->ID;
		}
		$not_in = array_merge ( $not_in, get_option( 'sticky_posts' ) );
		$args = array();
		$tax = 'jetpack-portfolio-type';
		if( '0' != $instance['jetpack-portfolio-type'] ) {
			$args =  array(
				array(
					'taxonomy' => $tax,
					'terms'    => array( $instance['jetpack-portfolio-type'] ),
					'field'    => 'term_id',
					'operator' => 'IN',
				),
			);
		}
		
		$query = new WP_Query( array(
			'order'          => 'DESC',
			'posts_per_page' => $instance['count'],
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'post__not_in'   => $not_in,
			'post_type'		 => 'jetpack-portfolio',
			'tax_query'      => $args,
		) );


		if ( $query->have_posts() ) :
					
			$tmp_content_width = $GLOBALS['content_width'];
			$GLOBALS['content_width'] = $width;

			//print the widget for the sidebar
			echo $before_widget;
			if( '' !== trim($instance['title'])) echo $before_title.esc_html($instance['title']).$after_title;
			
			$pos_class = '';
			if( 0 != $instance['is_has_description'] ) {
				$pos_class = (($instance['is_right']) == 1 ? ' right' : ' left');
			}
			
			?>
			<div class="main-wrapper-image <?php echo $pos_class;?>" style="padding:<?php echo esc_attr( $instance['padding_top']);?>px <?php echo esc_attr( $instance['padding_right']);?>% <?php echo esc_attr( $instance['padding_bottom'])?>px <?php echo esc_attr( $instance['padding_left'])?>%">
				<?php if( 0 != $instance['is_has_description'] && '0' != $instance['jetpack-portfolio-type'] ) : ?>
				
				<div class="description">
					<article>
						<header>
							<h3 class="main-title"><?php echo esc_html( get_term( $instance['jetpack-portfolio-type'], $tax )->name);?></h3>
						</header><!-- header -->
						<p><?php echo term_description( $instance['jetpack-portfolio-type'], $tax ) ?></p>
						<a href="<?php echo esc_url( get_term_link( $instance['jetpack-portfolio-type'], $tax ) ); ?>" class="link" rel="bookmark"><?php _e('Open Archive', 'stainedglass'); ?></a>
					</article> <!-- article -->
				</div> <!-- .description -->
				
				<?php endif; ?>

				<div class="wrapper-image <?php echo esc_attr($instance['columns']).( $instance['is_step'] ? ' step' : ' all' ).( $instance['is_margin_0'] ? ' margin-0' : '' );?>">
					
					<?php
					while (  $query->have_posts() ) :
						 $query->the_post();
					?>
						
						<div class="element <?php echo esc_attr($instance['effect_id']).( $instance['is_animate_once'] ? ' once' : '' ).( $instance['is_animate'] ? ' animate' : '' ).( $instance['is_zoom'] ? ' zoom' : '' );?>">
							<article>			
					
							<?php 
								if( has_post_thumbnail() && ! post_password_required() ) :
								
									$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $instance['image_size'] );	
								?>

									<img class="image-item" src="<?php echo esc_url( $image[0] );?>" alt="<?php the_title();?>"/>
									
								<?php
								else :
								?>	
									<div class="entry-thumbnail" style="background-image: url( <?php echo stainedglass_get_theme_mod('empty_image'); ?>)">																
									</div>
								<?php endif; ?>

								<div class="hover">
								
									<header>
									
										<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

									</header><!-- header -->
									
									<p><?php stainedglass_the_excerpt(); ?></p>
									
									<?php if ( 1 == $instance['is_link'] ) : ?>
																
										<a href="<?php echo esc_url( get_permalink() ); ?>" class="link" rel="bookmark"><?php echo esc_html( $instance['link_caption']); ?></a>
								
									<?php endif; ?>
									
								</div><!-- .hover -->
								
							</article>
						</div><!-- .element -->
								
					<?php
										
					endwhile; 
					
					$GLOBALS['content_width'] = $tmp_content_width;
					wp_reset_postdata();
					
				?>
				</div><!-- .wrapper -->
				<div class="hide-element"></div>
			</div><!-- .main-wrapper -->
			<?php
			echo $after_widget;	
	
		endif; 
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
		
		$instance['count'] = absint($new_instance['count']);
		$instance['count'] = ($new_instance['count'] > 0 ? $new_instance['count'] : 1);
		
		$instance['title'] = esc_html($new_instance['title']); 
		$instance['jetpack-portfolio-type'] = absint($new_instance['jetpack-portfolio-type']); 
		$possible_values = array('column-1', 'column-2', 'column-3', 'column-4');	
		$instance['columns'] = ( in_array( $new_instance['columns'], $possible_values ) ? $new_instance['columns'] : 'column-1');
		
		$possible_values = array('post-thumbnail', 'thumbnail', 'large', 'full');	
		$instance['image_size'] = ( in_array( $new_instance['image_size'], $possible_values ) ? $new_instance['image_size'] : 'post-thumbnail');
				
		if( isset($new_instance['is_step']) )
			$instance['is_step'] = 1;	
		if( isset($new_instance['is_has_description']))
			$instance['is_has_description'] = 1;		
		if( isset($new_instance['is_right']))
			$instance['is_right'] = 1;	
		if( isset($new_instance['is_margin_0']) )
			$instance['is_margin_0'] = 1;

		$instance['padding_right'] = 0;
		$instance['padding_left'] = 0;

		$instance['padding_top'] = ( 1 == $new_instance['is_margin_0'] ? 0 : 20);
		$instance['padding_bottom'] = ( 1 == $new_instance['is_margin_0'] ? 0 : 20);
	
		$possible_values = array('effect-1', 'effect-2', 'effect-3', 'effect-4', 'effect-5', 'effect-6', 'effect-7', 'effect-8', 'effect-9', 'effect-10', 'effect-11', 'effect-12', 'effect-14', 'effect-15', 'effect-16');	
		$instance['effect_id'] = ( in_array( $new_instance['effect_id'], $possible_values ) ? $new_instance['effect_id'] : 'effect-1');

		if( isset($new_instance['is_zoom']) )
			$instance['is_zoom'] = 1;
		if( isset($new_instance['is_animate']) )
			$instance['is_animate'] = 1;
		if( isset($new_instance['is_animate_once']) )
			$instance['is_animate_once'] = 1;
		if( isset($new_instance['is_link']) )
			$instance['is_link'] = 1;
		
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
		// Output admin widget options form
		// Set up some default widget settings. 
						
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) ); 
		
		stainedglass_echo_input_text( $this, 'title', $instance, __( 'Title: ', 'stainedglass' ), 0);
		
		$tax = 'jetpack-portfolio-type';
			
		$terms = get_terms( $tax );
								
		if ( $terms && ! is_wp_error( $terms ) ) : 

			esc_html_e('Category:', 'stainedglass'); ?>
			<select id="<?php echo $this->get_field_id('jetpack-portfolio-type'); ?>" name="<?php echo $this->get_field_name('jetpack-portfolio-type'); ?>" style="width:100%;">
				<option value="0"><?php esc_html_e('Any', 'stainedglass'); ?></option>
			<?php 

				foreach ( $terms as $term ) :
					echo '<option value="'.esc_attr($term->term_id).'" ';
					selected( $instance['jetpack-portfolio-type'], $term->term_id  );
					echo '>'.esc_html($term->name).'</option>';
				endforeach;
			?>
			</select>
			
		<?php endif;
		
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
		
		stainedglass_echo_input_checkbox( $this, 'is_step', $instance, __( 'Step Animation', 'stainedglass'));
		stainedglass_echo_input_checkbox( $this, 'is_margin_0', $instance, __( 'No Margins', 'stainedglass'));
		
		stainedglass_echo_input_checkbox( $this, 'is_zoom', $instance, __( 'Transparent', 'stainedglass'));
		stainedglass_echo_input_checkbox( $this, 'is_animate', $instance, __( 'Animate', 'stainedglass'));
		stainedglass_echo_input_checkbox( $this, 'is_animate_once', $instance, __( 'Once', 'stainedglass'));
		stainedglass_echo_input_checkbox( $this, 'is_link', $instance, __( 'Display Button', 'stainedglass'));
		
		stainedglass_echo_input_checkbox( $this, 'is_has_description', $instance, __( 'Display description block', 'stainedglass'));
		
		if( 0 != $instance['is_has_description'] ) {
			stainedglass_echo_input_checkbox( $this, 'is_right', $instance, __( 'Right', 'stainedglass'));
		}
		
		stainedglass_echo_input_hover_style( $this, 'effect_id', $instance);

		stainedglass_echo_input_text( $this, 'count', $instance, __( 'Count: ', 'stainedglass' ), 0);
		
	}
	
	/**
	 * Return array Defaults
	 *
	 * @since Stained Glass 1.0.0
	 */
	function defaults( $instance ){
	
		$defaults = array('title' => __( 'Recent projects', 'stainedglass' ),
						  'jetpack-portfolio-type'   => '0',	
						  'count'   => '4',	
						  'columns'   => 'column-4',
						  'image_size'   => 'post-thumbnail',							  
						  'is_step'   => '',
						  'is_margin_0'   => '',
						  'effect_id'   => 'effect-1',
						  'is_animate'   => '',
						  'is_zoom'   => '',
						  'is_animate_once'   => ($instance == null ? 1 : ''),
						  'link_caption'   => __('More Info', 'stainedglass'),
						  'padding_right'   => '0',
						  'padding_left'   => '0',
						  'padding_top'   => '20',
						  'padding_bottom'   => '20',
						  'is_has_description'   => 0,
						  'is_right'   => '',
						  'is_link' => ($instance == null ? 1 : ''),
						);
		
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
/* Register widget 
 *
 * @since Stained Glass 1.0.0
 *
 */
function stainedglass_register_items_portfolio_widgets() {
	register_widget( 'stainedglass_items_portfolio' );
}
add_action( 'widgets_init', 'stainedglass_register_items_portfolio_widgets' );
