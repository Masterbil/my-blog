<?php
/**
 * Add a widget for displaying portfolio items
 *
 * @since Stained Glass 1.0.0
 */
 
class stainedglass_recent_portfolio extends WP_Widget {

	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'stainedglass_recent_portfolio',
		'description' => __('Display recent items from a Portfolio post type', 'stainedglass' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 200,
		'id_base' => 'stainedglass_recent_portfolio');

		/* Create the widget. */		
		
		parent::__construct( 'stainedglass_recent_portfolio', __( 'GL Portfolio Projects (5) (GLASS)', 'stainedglass' ), $widget_ops, $control_ops );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}
	
	public function enqueue_styles() {
		wp_enqueue_style( 'stainedglass-image', get_template_directory_uri() . '/inc/css/image.css');
		wp_enqueue_script( 'stainedglass-image-script', get_template_directory_uri() . '/inc/js/image-widget.js', array('jquery'), '20151012', true );
	}

	public function enqueue_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_media();

		wp_enqueue_script( 'stainedglass-upload-image', get_template_directory_uri() . '/inc/js/meta-box-image.js', array('jquery') );

	}

	function widget( $args, $instance ) {
		// Widget output
		extract($args);
		$sidebar_id = ( isset($args['id']) ? $args['id'] : '' );
		
		// Set up some default widget settings. 
						
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) );
		$width = $this->get_width($sidebar_id, 2);

		global $post;
		$not_in = array();
		if( is_singular() ) {
			$not_in []= $post->ID;
		}
		$not_in = array_merge ( $not_in, get_option( 'sticky_posts' ) );
		$args = array();
		$tax = 'jetpack-portfolio-type';
		
		if( '0' != $instance['project'] ) {
			$args =  array(
				array(
					'taxonomy' => $tax,
					'terms'    => array( $instance['project'] ),
					'field'    => 'term_id',
					'operator' => 'IN',
				),
			);
		}
		
		$query = new WP_Query( array(
			'order'          => 'DESC',
			'posts_per_page' => 5,
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
			
			$pos_class = ( 1== ($instance['is_right']) ? ' right' : ' left');
			
			?>
			<div class="main-wrapper-image stainedglass-recent-posts <?php echo $pos_class;?>">
				
				<?php $query->the_post(); ?>
				<div class="description posts column-1">
				
					<div class="element <?php echo esc_attr(($instance['effect_id']).( '1' == $instance['is_zoom'] ? ' zoom' : '' ));?>">
						<article>			
				
						<?php 
							if( has_post_thumbnail() && ! post_password_required() ) {
								$i = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $instance['image_size'] );
								$image = $i[0];
							}
							else {
								$image = stainedglass_get_theme_mod('empty_image');
							}

						 ?>
							<div class="entry-thumbnail" style="background-image:url('<?php echo $image; ?>')">	
							
							</div>

							<div class="hover">
							
								<header>
								<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

								</header><!-- header -->
								
								<p><?php stainedglass_the_excerpt(); ?></p>
															
								<a href="<?php echo esc_url( get_permalink() ); ?>" class="link" rel="bookmark"><?php echo esc_html( $instance['link_caption'] ); ?></a>
								
								<div class="project-list">
									<?php echo get_the_term_list( get_the_ID(), $tax); ?>
								</div><!-- .project-list -->
								
							</div><!-- .hover -->
							
						</article>
					</div><!-- .element -->

				</div> <!-- .description -->
				
				<div class="wrapper-image column-2 margin-0">
					
					<?php
					while ( $query->have_posts() ) :
						 $query->the_post();
					?>
						
						<div class="element <?php echo esc_attr(($instance['effect_id']).( '1' == $instance['is_zoom'] ? ' zoom' : '' ));?>">
							<article>			
					
							<?php 
								if( has_post_thumbnail() && ! post_password_required() ) {
									$i = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $instance['image_size'] );
									$image = $i[0];								
								}
								else {
									$image = stainedglass_get_theme_mod('empty_image');
								}

							 ?>
								<div class="entry-thumbnail" style="background-image:url('<?php echo $image; ?>')">	
								
								</div>

								<div class="hover">
								
									<header>
									
								<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

									</header><!-- header -->
									
									<p><?php stainedglass_the_excerpt(); ?></p>
																
									<a href="<?php echo esc_url( get_permalink() ); ?>" class="link" rel="bookmark"><?php echo esc_html( $instance['link_caption'] ); ?></a>
									
									<footer class="entry-meta">
										<?php if ( 'post' == get_post_type() ) : ?>

											<span class="post-date">
												<?php stainedglass_posted_on(); ?>
											</span>
											
										<?php endif; ?>
									</footer><!-- .entry-meta -->
									
									<?php if( '0' == $instance['project'] ) : ?>
									
										<div class="project-list">
											<?php echo get_the_term_list( get_the_ID(), $tax); ?>
										</div><!-- .project-list -->
										
									<?php endif; ?>
									
								</div><!-- .hover -->
								
							</article>
						</div><!-- .element -->
								
					<?php
										
					endwhile; 
					
					$GLOBALS['content_width'] = $tmp_content_width;
					wp_reset_postdata();
					
				?>
				</div><!-- .wrapper-image -->
			</div><!-- .main-wrapper -->
			<?php
			echo $after_widget;	
	
		endif; 
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		
		$new_instance['title'] = esc_html($new_instance['title']); 
		$new_instance['project'] = absint($new_instance['project']); 
		
		$possible_values = array('post-thumbnail', 'thumbnail', 'large', 'full');	
		$new_instance['image_size'] = ( in_array( $new_instance['image_size'], $possible_values ) ? $new_instance['image_size'] : 'post-thumbnail');			
	
		if( isset($new_instance['is_right']))
			$new_instance['is_right'] = 1;	
		if( isset($new_instance['is_zoom']) )
			$new_instance['is_zoom'] = 1;
			
		$new_instance['link_caption'] = esc_html($new_instance['link_caption']); 
		
		return $new_instance;
	}

	function form( $instance ) {
		// Output admin widget options form
		// Set up some default widget settings. 
						
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) ); 
		
		stainedglass_echo_input_text( $this, 'title', $instance, __( 'Title: ', 'stainedglass' ), 0);
		
		$tax = 'project';
			
		$terms = get_terms( $tax );
								
		if ( $terms && ! is_wp_error( $terms ) ) : 

			esc_html_e('project:', 'stainedglass'); ?>
			<select id="<?php echo $this->get_field_id('project'); ?>" name="<?php echo $this->get_field_name('project'); ?>" style="width:100%;">
				<option value="0"><?php esc_html_e('Any', 'stainedglass'); ?></option>
			<?php 

				foreach ( $terms as $term ) :
					echo '<option value="'.esc_attr($term->term_id).'" ';
					selected( $instance['project'], $term->term_id  );
					echo '>'.esc_html($term->name).'</option>';
				endforeach;
			?>
			</select>
			
		<?php endif;
		
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
		
		stainedglass_echo_input_checkbox( $this, 'is_zoom', $instance, __( 'Transparent', 'stainedglass'));
		stainedglass_echo_input_checkbox( $this, 'is_right', $instance, __( 'Right', 'stainedglass'));
		stainedglass_echo_input_text( $this, 'link_caption', $instance, __( 'Button Caption: ', 'stainedglass' ));

	}
	function echo_input_checkbox($name, $instance, $title) { ?>
		<p>
			<input type="checkbox" name="<?php echo $this->get_field_name( $name ); ?>" id="<?php echo $this->get_field_id( $name ); ?>"  value="1" <?php checked( $instance[$name], '1'); ?> />
			<label for="<?php echo $this->get_field_id( $name ); ?>"><?php echo esc_attr( $title ); ?></label>
		</p>
		<?php
	}
	function echo_input_hover_style($name, $instance) {
		esc_html_e('Hover Effect Style:', 'stainedglass'); ?>
		<select id="<?php echo $this->get_field_id($name); ?>" name="<?php echo $this->get_field_name($name); ?>" style="width:100%;">
		<?php 
			$styles=array( __('Caption (1)', 'stainedglass'), __('50% (2)', 'stainedglass'), __('Fast (3)', 'stainedglass'), 
			__('Slow (4)', 'stainedglass'), __('Side (5)', 'stainedglass'), __('Round (6)', 'stainedglass'), 
			__('Left To Right (7)', 'stainedglass'), __('Jump (8)', 'stainedglass'), __('Fly (9)', 'stainedglass'), __('Zoom In (10)', 'stainedglass'), __('Hovered (11)', 'stainedglass'), __('Wide Hover (12)', 'stainedglass'), __('Top (14)', 'stainedglass'), __('Right To Left (15)', 'stainedglass'), __('Bottom (16)', 'stainedglass'));
			$styles_ids=array('effect-1', 'effect-2', 'effect-3', 'effect-4', 'effect-5', 'effect-6', 'effect-7', 'effect-8', 'effect-9', 'effect-10', 'effect-11', 'effect-12', 'effect-14', 'effect-15', 'effect-16');

			for ($i=0; $i<15; $i++) {
				echo '<option value="'.esc_attr($styles_ids[$i]).'" ';
				selected( $instance[$name], $styles_ids[$i] );
				echo '>'.esc_html($styles[$i]).'</option>';
			}
		?>
		</select>
		<?php 
	}
	function echo_input_upload_id($name, $instance, $title) { ?>
			<hr>
			<?php echo wp_get_attachment_image($instance[$name]); ?>
			<br>
			
            <label for="<?php echo $this->get_field_id( $name ); ?>"><?php esc_html_e( 'Image Id:', 'stainedglass' ); ?></label>
            <input name="<?php echo $this->get_field_name( $name ); ?>" id="<?php echo $this->get_field_id( $name ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_attr($instance[$name]); ?>" />		
  		    <input id="<?php echo $this->get_field_id( $name ); ?>_b" class="upload_id_button button button-primary" type="button" value="<?php esc_html_e( 'Upload Image', 'stainedglass'); ?>" />
			<hr>
		<?php
	}
	
	function echo_input_upload($name, $instance, $title) { ?>
		<hr>
			<?php if(trim($instance[$name]) != '') : ?>
				<img src="<?php echo esc_url(($instance[$name])); ?>" style="max-width:100%;" alt="<?php esc_attr_e('Upload', 'stainedglass'); ?>" />
			<?php endif; ?>
			
			<br>
            <label for="<?php echo $this->get_field_id( $name ); ?>"><?php esc_html_e( 'Url:', 'stainedglass' ); ?></label>
            <input name="<?php echo $this->get_field_name( $name ); ?>" id="<?php echo $this->get_field_id( $name ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $instance[$name] ); ?>" />		
  		    <input id="<?php echo $this->get_field_id( $name ); ?>_b" class="upload_image_button button button-primary" type="button" value="<?php esc_html_e( 'Upload Image', 'stainedglass'); ?>" />
		<hr>
		<?php
	}
	function echo_input_text($name, $instance, $title) { ?>
		<p>
			<label for="<?php echo $this->get_field_id( $name );?>"><?php echo esc_html( $title ); ?></label>
			<br>
			<input size="34" type="text" name="<?php echo $this->get_field_name( $name ) ?>" id="<?php echo $this->get_field_id( $name ); ?>" value="<?php echo esc_html($instance[$name]); ?>" />		
		</p>
		<hr>
		<?php 
	}
	function echo_input_textarea($name, $instance, $title, $rows=10, $cols=30) { ?>
		<p>
			<label for="<?php echo $this->get_field_id( $name ); ?>"><?php echo esc_html( $title ); ?></label>
			<br>
			<textarea name="<?php echo $this->get_field_name( $name ) ?>" cols="<?php echo $cols;?>" rows="<?php echo $rows;?>" id="<?php echo $this->get_field_id( $name ); ?>"><?php echo esc_textarea($instance[$name]); ?></textarea>		
		</p>
		<?php
	}	
	
	/**
	 * Return array Defaults
	 *
	 * @since Stained Glass 1.0.0
	 */
	function defaults( $instance ){
	
		$defaults = array('title' => __('Recent projects', 'stainedglass'),
						  'project'   => '0',	
						  'image_size'   => 'post-thumbnail',							  
						  'effect_id'   => 'effect-1',
						  'is_zoom'   => '',
						  'is_right'   => '',
						  'link_caption'   => __('More Info', 'stainedglass'),
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
function stainedglass_register_recent_portfolio_widget() {
	register_widget( 'stainedglass_recent_portfolio' );
}
add_action( 'widgets_init', 'stainedglass_register_recent_portfolio_widget' );