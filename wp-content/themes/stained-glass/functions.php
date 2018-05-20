<?php
/**
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage stainedglass
 * @since Stained Glass 1.0.0
*/

/**
 * Set up the content width value.
 *
 * @since Stained Glass 1.0.0
 */

if ( ! isset( $stainedglass_sidebars ) ) {
	$stainedglass_sidebars = array();
}

if ( ! function_exists( 'stainedglass_setup' ) ) :

/**
 * stainedglass setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * @since Stained Glass 1.0.0
 */

function stainedglass_setup() {
	
	$defaults = stainedglass_get_defaults();
	
	global $stainedglass_sidebar_slug;
	$stainedglass_sidebar_slug = null;	
	
	global $stainedglass_page_sidebars;
	$stainedglass_page_sidebars = null;
	
	/* default values */
	global $stainedglass_defaults;
	$stainedglass_defaults = null;

	/* custom layouts */
	global $stainedglass_layout_class;
	$stainedglass_layout_class = new stainedglass_Layout_Class();	
	
	/* custom colors */
	global $stainedglass_colors_class;
	$stainedglass_colors_class = new stainedglass_Colors_Class();
	
	if ( get_theme_mod( 'is_show_top_menu', $defaults ['is_show_top_menu']) == '1' )
		register_nav_menu( 'top1', __( 'First Top Menu', 'stainedglass' ));
	if ( get_theme_mod( 'is_show_secont_top_menu', $defaults ['is_show_secont_top_menu']) == '1' )
		register_nav_menu( 'top2', __( 'Second Top Menu', 'stainedglass' ));
	if ( get_theme_mod( 'is_show_footer_menu', $defaults ['is_show_footer_menu']) == '1' )
		register_nav_menu( 'footer', __( 'Footer Menu', 'stainedglass' ));

	load_theme_textdomain( 'stainedglass', get_template_directory() . '/languages' );
	
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'custom-background', array(
		'default-color' => 'cccccc',
	) );

	add_theme_support( 'post-thumbnails' );
	
	set_post_thumbnail_size( stainedglass_get_theme_mod( 'post_thumbnail_size' ) , 9999 ); 
	
	$args = array(
		'default-image'          => get_template_directory_uri() . '/img/' . 'header.jpg',
		'header-text'            => true,
		'default-text-color'     => stainedglass_text_color(get_theme_mod('color_scheme'), $defaults ['color_scheme']),
		'width'                  => stainedglass_get_theme_mod('size_image'),
		'height'                 => stainedglass_get_theme_mod('size_image_height'),
		'flex-height'            => true,
		'flex-width'             => true,
	);
	add_theme_support( 'custom-header', $args );
	
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'caption'
	) );
	
	add_theme_support( 'title-tag' );
	
	/*
	 * Enable support for WooCommerce plugin.
	 */
	 
	add_theme_support( 'woocommerce' );
	
	/*
	 * Enable support for Jetpack Portfolio custom post type.
	 */
	 
	add_theme_support( 'jetpack-portfolio' );
	
	global $content_width;
	
	if ( ! isset( $content_width ) ) {
		$content_width = 1280;
	}

}
add_action( 'after_setup_theme', 'stainedglass_setup' );
endif;

if ( ! function_exists( '_wp_render_title_tag' ) ) :
/**
 *  Backwards compatibility for older versions (4.1)
 * 
 * @since Stained Glass 1.0.0
 */
	function stainedglass_render_title() {
	?>
		 <title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php
	}
	add_action( 'wp_head', 'stainedglass_render_title' );
	
/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Stained Glass 1.0.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function stainedglass_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'stainedglass' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'stainedglass_wp_title', 10, 2 );
	
endif;


/**
 * Load our special font CSS file.
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_custom_header_fonts() {
	$font_url = stainedglass_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'stainedglass-fonts', esc_url_raw( $font_url ), array(), null );
}
add_action( 'admin_print_styles-appearance_page_custom-header', 'stainedglass_custom_header_fonts' );

/**
 * Return the Google font stylesheet URL if available.
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_get_font_url() {
	$font_url = '';
	$font = str_replace( ' ', '+', stainedglass_get_theme_mod( 'body_font' ) );
	$heading_font = str_replace( ' ', '+', stainedglass_get_theme_mod( 'heading_font' ) );
	if ( '0' == $font && '0' == $heading_font) 
		return $font_url;
		
	if ( '0' != $font && '0' != $heading_font )
		$font .= '%7C' . $heading_font;

	/* translators: If there are characters in your language that are not supported
	 * by Open Sans fonts, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'stainedglass' ) ) {
		$subsets = 'latin,latin-ext';
		$family = $font . ':300,400';

		/* translators: To add an additional Open Sans character subset specific to your language,	
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Font: add new subset (greek, cyrillic, vietnamese)', 'stainedglass' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		}
		if ( 'greek' == $subset ) {
			$subsets .= ',greek,greek-ext';
		}
		elseif ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		$query_args = array(
			'family' => $family,
			'subset' => $subsets,
		);
		$font_url = "//fonts.googleapis.com/css?family=" . $family . '&' . $subsets;
		
	}

	return $font_url;
}
/**
 * Enqueue scripts and styles for front-end.
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_scripts_styles() {
	global $wp_styles;
	
	// Add Genericons font.
	wp_enqueue_style( 'stainedglass-genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '2015' );
	
	$font_url = stainedglass_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'stainedglass-fonts', esc_url_raw( $font_url ), array(), null );
		
	// Loads our main stylesheet.
	wp_enqueue_style( 'stainedglass-style', get_stylesheet_uri() );
			
	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'stainedglass-ie', get_template_directory_uri() . '/css/ie.css', array( 'stainedglass-style' ), '20141210' );
	$wp_styles->add_data( 'stainedglass-ie', 'conditional', 'lt IE 9' );
	
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
		
	// Adds JavaScript for handing the navigation menu and top sidebars hide-and-show behavior.
	wp_enqueue_script( 'stainedglass-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '201531', true );
	
	wp_enqueue_script( 'stainedglass-image-script', get_template_directory_uri() . '/inc/js/image-widget.js', array('jquery'), '2015', true );
}
add_action( 'wp_enqueue_scripts', 'stainedglass_scripts_styles' );
 
/**
 * Add Editor styles and fonts to Tiny MCE
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_add_editor_styles() {
	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css' ) );
	
	$font_url = stainedglass_get_font_url();
	if ( ! empty( $font_url ) )
		 add_editor_style( $font_url );
}
add_action( 'after_setup_theme', 'stainedglass_add_editor_styles' );

/**
 * Extend the default WordPress body classes.
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 *
 * @since Stained Glass 1.0.0
 */

function stainedglass_body_class( $classes ) {

	$background_color = get_background_color();
	$background_image = get_background_image();
	
	$defaults = stainedglass_get_defaults();
	
	if(stainedglass_get_theme_mod('image_style') == 'boxed'){
		$classes[] = 'boxed-image';
	}	
	if(stainedglass_get_theme_mod('content_style') == 'boxed'){
		$classes[] = 'boxed-content';
		$classes[] = 'boxed-header';
	}
	
	if ( empty( $background_image ) ) {
		if ( empty( $background_color ) )
			$classes[] = 'custom-background';
		elseif ( in_array( $background_color, array( 'ccc', 'cccccc' ) ) )
			$classes[] = 'custom-background';
	}
	
	// Enable custom class only if the header text enabled.
	if ( display_header_text() ) {
		$classes[] = 'header-text-is-on';
	}	
	
	if( is_front_page() && 'no_content' == stainedglass_get_theme_mod('front_page_style') && ! is_home() ) {
		$classes[] = 'no-content';
	}
	
	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'stainedglass-fonts', 'queue' ) )
		$classes[] = 'google-fonts-on';

	// Enable custom class only if the logotype is active.
	if ( get_theme_mod( 'logotype_url', $defaults['logotype_url'] ) != '' ) 
		$classes[] = 'logo-is-on';	

	return $classes;
}
add_filter( 'body_class', 'stainedglass_body_class' );

/**
 * Create not empty title
 *
 * @since Stained Glass 1.0.0
 *
 * @param string $title Default title text.
 * @param int $id.
 * @return string The filtered title.
 */
function stainedglass_title( $title, $id = null ) {

    if ( trim($title) == '' && (is_archive() || is_home() || is_search() ) ) {
        return ( esc_html( get_the_date() ) );
    }
	
    return $title;
}
add_filter( 'the_title', 'stainedglass_title', 10, 2 );

if ( ! function_exists( 'stainedglass_get_header' ) ) :

/**
 * Return default header image url
 *
 * @since Stained Glass 1.0.0
 *
 * @param string color_scheme color scheme.
 * @return string header url.
 */
function stainedglass_get_header( $color_scheme ) {

    return get_template_directory_uri() . '/img/' . 'header.jpg';
}

endif;

if ( ! function_exists( 'stainedglass_text_color' ) ) :

/**
 * Return default header text color
 *
 * @since Stained Glass 1.0.0
 *
 * @param string color_scheme color scheme.
 * @return string header url.
 */
function stainedglass_text_color( $color_scheme ) {

	switch ($color_scheme) {
		case '0':
			$text_color = '333333';
		break;
		default:
			$text_color = '333333';
		break;
	}

    return $text_color;
}

endif;

if ( ! function_exists( 'stainedglass_post_nav' ) ) :
/**
 * Display navigation to next/previous post.
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'stainedglass' ); ?></h1>
		<div class="nav-link">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'stainedglass' ) );
			else :
				$next = next_post_link( '%link ', __( '<span class="nav-next">%title &rarr;</span>', 'stainedglass' ) );
				if ( $next ) :
					previous_post_link( '%link', __( '<span class="nav-previous">&larr; %title</span>', 'stainedglass' ) );
					$next;
				else :
					previous_post_link( '%link', __( '<span class="nav-previous-one">&larr; %title</span>', 'stainedglass' ) );
				endif;
				
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<div class="clear"></div>
	<?php
}
endif;

if ( ! function_exists( 'stainedglass_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_paging_nav() {

	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&larr; Previous', 'stainedglass' ),
		'next_text' => __( 'Next &rarr;', 'stainedglass' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'stainedglass' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
	
}
endif;

if ( ! function_exists( 'stainedglass_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_the_attached_image() {
	$post                = get_post();

	$attachment_size     = apply_filters( 'stainedglass_attachment_size', array( 987, 9999 ) );
	$next_attachment_url = wp_get_attachment_url();

	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'stainedglass_posted_on' ) ) :
/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_posted_on() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		echo '<span class="featured-post"></span>';
	}

	// Set up and print post meta information.
	printf( '<span class="entry-date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span> <span class="byline"><span title="%5$s" class="author vcard"><a class="url fn n" href="%4$s" rel="author">%5$s</a></span></span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_date( '' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		get_the_author()
	);
	
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'stainedglass' ), __( '1 Comment', 'stainedglass' ), __( '% Comments', 'stainedglass' ) );
		echo '</span>';
	}
}
endif;


if ( ! function_exists( 'stainedglass_content_width' ) ) :
/**
 * Adjust content width in certain contexts.
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_content_width() {
	
	global $stainedglass_layout_class;
	global $content_width;
	
	$curr_layout = $stainedglass_layout_class->get_layout();
	$curr_content_layout = $stainedglass_layout_class->get_content_layout();
	$content_columns = preg_replace('/[^0-9]/','',$curr_content_layout);	
	$content_area_width = stainedglass_calc_content_width( $curr_layout );
	$content_width = stainedglass_calc_content_column_width ($content_area_width, $content_columns); 
//	echo $content_width;
}
add_action( 'template_redirect', 'stainedglass_content_width' );

endif;

if ( ! function_exists( 'stainedglass_calc_content_column_width' ) ) :
/**
 * Calculate width of the content area
 *
 * @param int width of content area.
 * @param int columns count.
 * @return int width of column.
 * @since Stained Glass 1.0.0
 */
function stainedglass_calc_content_column_width( $width, $columns ) {
	
	switch( $columns ) {
		case 1:
		break;	
		case 2:
			$width = $width/100*48;
		break;	
		case 3:
			$width = $width/100*30;
		break;	
		case 4:
			$width = $width/100*22;
		break;
	}
	$width = absint($width - $width/100*8); 
	
	return $width;
}
endif;

if ( ! function_exists( 'stainedglass_calc_content_width' ) ) :
/**
 * Calculate width of the content area
 *
 * @param string current layout.
 * @return int width of the content area.
 * @since Stained Glass 1.0.0
 */
function stainedglass_calc_content_width( $curr_layout ) {

	$content_width = (stainedglass_get_theme_mod( 'width_main_wrapper' ) > stainedglass_get_theme_mod( 'width_site' ) ? stainedglass_get_theme_mod( 'width_site' ) : stainedglass_get_theme_mod( 'width_main_wrapper' ) );
	$unit = stainedglass_get_theme_mod('unit');

	if( 'left-sidebar' == $curr_layout) {
		if(  0 == $unit ) {
			$content_width = $content_width - stainedglass_get_theme_mod('width_column_1_left') - 40;
		}
		else {
			$content_width = $content_width - $content_width/100*stainedglass_get_theme_mod('width_column_1_left_rate') - 40;
		}
	} 
	elseif( 'right-sidebar' == $curr_layout) {
		if(  0 == $unit ) {
			$content_width = $content_width - stainedglass_get_theme_mod('width_column_1_right') - 80;
		}
		else {
			$content_width = $content_width - $content_width/100*stainedglass_get_theme_mod('width_column_1_right_rate') - 40;
		}
	}
	elseif( 'two-sidebars' == $curr_layout) {
		if( 0 == $unit ) {
			$content_width = $content_width - stainedglass_get_theme_mod('width_column_1') - stainedglass_get_theme_mod('width_column_2') - 40;
		}
		else {
			$content_width = $content_width - $content_width/100*stainedglass_get_theme_mod('width_column_1_rate') - $content_width/100*stainedglass_get_theme_mod('width_column_2_rate') - 40;
		}
	}
	else {
		$content_width -= 40;
	}

	$content_width = absint($content_width);
	return $content_width;
}
endif;
 /**
 * Return array default theme options
 *
 * @since Stained Glass 1.0.0
 */
 
function stainedglass_get_defaults() {

	global $stainedglass_defaults;
	
	if(isset($stainedglass_defaults)) {
		return $stainedglass_defaults;
	}
	
	$defaults = array();
	$defaults['logotype_url'] =  esc_url( get_template_directory_uri() ) . '/img/logo.png';
	$defaults['is_show_top_menu'] = '';
	$defaults['is_show_secont_top_menu'] = '1';
	$defaults['is_show_footer_menu'] = '';
	$defaults['column_background_url'] = esc_url( get_template_directory_uri() ) .'/img/back-sidebar.png';	
	$defaults['post_thumbnail_size'] = '400';
	$defaults['width_content_no_sidebar'] = '1600';	
	$defaults['scroll_button'] = 'right';
	$defaults['scroll_animate'] = 'none';
	$defaults['favicon'] = '';
	$defaults['is_header_on_front_page_only'] = '1';
	$defaults['body_font'] = 'Open Sans';
	$defaults['heading_font'] = '0';
	$defaults['body_font_size'] = '16';
	$defaults['color_scheme'] = 0;
	$defaults['is_second_menu_on_front_page_only'] = '0';
	$defaults['is_text_on_front_page_only'] = '';
	$defaults['top'] = 'top';

	$defaults['front_page_style'] = '1';	
	$defaults['unit'] = 1;
	
	$defaults['width_site'] = '1600';
	$defaults['width_main_wrapper'] = '1600';
	$defaults['width_top_widget_area'] = '1600';
	
	/* Header Image size */
	$defaults['size_image'] = '1600';
	$defaults['size_image_height'] = '600';
	/* Header Image and top sidebar wrapper */
	$defaults['width_image'] = '1600';
	$defaults['width_content'] = '1600';
	
	$defaults['header_style'] = 'full-width';
	$defaults['image_style'] = 'full-width';
	$defaults['content_style'] = 'full-width';
	
	$defaults['width_column_1'] = '300';
	$defaults['width_column_1_left'] = '300';
	$defaults['width_column_1_right'] = '300';
	$defaults['width_column_2'] = '300';
	
	$defaults['width_column_1_rate'] = '30';
	$defaults['width_column_1_left_rate'] = '20';
	$defaults['width_column_1_right_rate'] = '30';
	$defaults['width_column_2_rate'] = '30';
	
	/* post: excerpt/content */
	$defaults['single_style'] = 'excerpt';
	$defaults['is_display_post_image'] = '1';
	$defaults['is_display_post_title'] = '1';
	$defaults['is_display_post_tags'] = '1';
	$defaults['is_display_post_cat'] = '1';

	/* page: excerpt/content */
	$defaults['page_style'] = 'excerpt';
	$defaults['is_display_page_image'] = '1';
	$defaults['is_display_page_title'] = '1';
	
	/* portfolio: excerpt/content */
	$defaults['portfolio_style'] = 'excerpt';
	$defaults['is_display_portfolio_image'] = '1';
	$defaults['is_display_portfolio_title'] = '1';
	$defaults['is_display_portfolio_tags'] = '1';
	$defaults['is_display_portfolio_project'] = '1';
	
	$defaults['empty_image'] = esc_url( get_template_directory_uri() ) . '/img/empty.png';;
	$defaults['footer_text'] = '<a href="' . esc_url( __( 'http://wordpress.org/', 'stainedglass' ) ) . '">' . __( 'Powered by WordPress', 'stainedglass' ). '</a>' . '<a href="' .  esc_url( __( 'http://wpblogs.ru/themes/blog/theme/stained-glass-multipurpose-wordpress-theme/' ), 'stainedglass') . '"> theme Stained Glass</a>';
	$defaults['is_home_footer'] = '';
	
	$defaults['width_mobile_switch'] = '960';
	$defaults['columns_direction'] = 'c_1_2';
	$defaults['is_mobile_column_1'] = '1';
	$defaults['is_mobile_column_2'] = '1';

/* declare theme sidebars */

	$defaults['theme_sidebars']['column-1']  = array (
													'title' => __( 'First column', 'stainedglass' ), 
													'is_checked' => '', 
													'is_constant' => '');
	$defaults['theme_sidebars']['column-2']  = array (
													'title' => __( 'Second column', 'stainedglass' ), 
													'is_checked' => '', 
													'is_constant' => '');
	$defaults['theme_sidebars']['sidebar-top']  = array (
													'title' => __( 'First Top Sidebar', 'stainedglass' ),
													'is_checked' => '',
													'is_constant' => '');	
	$defaults['theme_sidebars']['sidebar-before-footer']  = array (
													'title' => __( 'Before Footer Sidebar', 'stainedglass' ), 
													'is_checked' => '', 
													'is_constant' => '');
	$defaults['theme_sidebars']['sidebar-footer']  = array (
													'title' => __( 'Footer Sidebar', 'stainedglass' ), 
													'is_checked' => '', 
													'is_constant' => '1');

	/* order is important */
	$defaults['defined_sidebars']['static'] = array(
											'use' => '1',
											'callback' => '',
											'param' => '', 
											'title' => __( 'Static', 'stainedglass' ), 
											'sidebar-footer' => '1',
											);//Sidebars, visible on all posts and pages
	$defaults['defined_sidebars']['default'] = array(
											'use' => '1', 
											'callback' => '', 
											'param' => '', 
											'title' => __( 'Default', 'stainedglass' ),
											'sidebar-top' => '1', 
											'column-1' => '1', 
											'column-2' => '1',
											'sidebar-before-footer' => '1',
											);
	$defaults['defined_sidebars']['page404'] = array(
											'use' => '1', 
											'callback' => 'is_404', 
											'param' => '', 
											'title' => __( 'Page 404', 'stainedglass' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '1',
											'column-1' => '',
											'column-2' => '', 
											);
	$defaults['defined_sidebars']['page'] = array(
											'use' => '', 
											'callback' => 'is_page', 
											'param' => '', 
											'title' => __( 'Pages', 'stainedglass' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '1',
											'column-1' => '1',
											'column-2' => '1', 
											);
	$defaults['defined_sidebars']['archive'] = array(
											'use' => '', 
											'callback' => 'is_archive', 
											'param' => '', 
											'title' => __( 'Archive', 'stainedglass' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '1',
											'column-1' => '',
											'column-2' => '', 
										);

	$defaults['defined_sidebars']['portfolio-page'] = array(
											'use' => '1', 
											'callback' => 'stainedglass_is_portfolio_page', 
											'param' => '', 
											'title' => __( 'Portfolio (Page)', 'stainedglass' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '',
											'column-1' => '',
											'column-2' => '1', 
											);
	$defaults['defined_sidebars']['portfolio'] = array(
											'use' => '1', 
											'callback' => 'stainedglass_is_portfolio', 
											'param' => '', 
											'title' => __( 'Portfolio (Archive)', 'stainedglass' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '',
											'column-1' => '1',
											'column-2' => '', 
											);
	$defaults['defined_sidebars']['blog'] = array(
											'use' => '', 
											'callback' => 'is_home', 
											'param' => '', 
											'title' => __( 'Blog', 'stainedglass' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '1',
											'column-1' => '1',
											'column-2' => '1', 
											);
	$defaults['defined_sidebars']['home'] = array(
											'use' => '1', 
											'callback' => 'is_front_page', 
											'param' => '', 
											'title' => __( 'Home', 'stainedglass' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '1',
											'column-1' => '',
											'column-2' => '', 
											);

	$defaults['per_page_sidebars'] = array();

	
	return apply_filters( 'stainedglass_option_defaults', $defaults );
}

/**
 * Convert given sidebar id to id from $defaults array
 *
 * @param string $sidebar_id sidebar id with page slug.
 * @return string slug of current sidebar.
 * @since Stained Glass 1.0.0
 */
function stainedglass_san_sidebar_id( $sidebar_id ) {
	$defaults = stainedglass_get_defaults();

	foreach( $defaults['theme_sidebars'] as $id => $value ) {

		if( 0 == strrpos($sidebar_id, $id)) {
			return $id;
		}
	}
	 return false;
}

/**
 * Return width of sidebar
 *
 * @param string $sidebar_id slug of current sidebar with page prefix.
 * @return int max width of sidebar.
 * @since Stained Glass 1.0.0
 */
function stainedglass_get_sidebar_width( $sidebar_id ) {
	$defaults = stainedglass_get_defaults();
	$width = 1366;
	$sidebar_id = stainedglass_san_sidebar_id( $sidebar_id );
	if( false == $sidebar_id)
		return $width;
				
	switch ( $sidebar_id ) {
		case 'sidebar-top':
			$width = stainedglass_get_theme_mod('width_site');
		break;
		case 'sidebar-before-footer':
			$width = stainedglass_get_theme_mod('width_site');
		break;
		case 'sidebar-footer':
			$width = stainedglass_get_theme_mod('width_main_wrapper')/3;
		break;
		case 'column-1':
			$width = ($defaults['width_column_1'] > stainedglass_get_theme_mod('width_column_1_left') ? stainedglass_get_theme_mod('width_column_1') : stainedglass_get_theme_mod('width_column_1_left'));
		break;		
		case 'column-2':
			$width = (stainedglass_get_theme_mod('width_column_2') > stainedglass_get_theme_mod('width_column_1_right') ? stainedglass_get_theme_mod('width_column_2') : stainedglass_get_theme_mod('width_column_1_right'));
		break;		
	}
		
	return $width;
}

/**
 * Return prefix for content-xxx.php file
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_get_content_prefix() {
	
	$post_type = get_post_type();
	$post_prefix = '';
	if( 'post' == $post_type) {
		$post_prefix = get_post_format();
	} else {
		$post_prefix = $post_type.'-'; 
	}
	if( is_search() || is_archive() || is_home() ) {
		$name = $post_prefix . ( '' == $post_prefix ? '' : '-') . 'archive';
		
		$located = locate_template( $name . '.php' );
		
		if ( ! empty( $located ) ) {
			return $name;
		} else {
			return 'archive';
		}
	}
	return get_post_format();

}

/**
 * Check for 'flex' prefix 
 *
 * @layout string content layout
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_content_class( $layout_content ) {
	$is_flex = strrpos($layout_content, 'flex');
	$layout_content = ( false === $is_flex ? $layout_content : 'flex '.$layout_content );
	return $layout_content;
}

 /**
 * Print credit links and scroll to top button
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_site_info() {
	$text = stainedglass_get_theme_mod( 'footer_text' );
	if ( '' != $text ) :
?>
		<div class="site-info">
			<?php echo wp_kses( $text, array(
									'a' => array(
										'href' => array(),
										'title' => array()
									),
									'br' => array(),
									'em' => array(),
									'strong' => array(),
								)
								); ?>
		</div><!-- .site-info -->
	
	<?php endif; 
	
	if ( 'none' != stainedglass_get_theme_mod( 'scroll_button' ) ) : ?>
		<a href="#" class="scrollup <?php echo esc_attr( stainedglass_get_theme_mod( 'scroll_button' )).
			esc_attr( 'none' == stainedglass_get_theme_mod( 'scroll_animate' ) ? '' : ' ' . stainedglass_get_theme_mod( 'scroll_animate' ) ); ?>"></a>
	<?php endif;
}
add_action( 'stainedglass_site_info', 'stainedglass_site_info' );

/**
 * Print Favicon.
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_hook_favicon() {
	$defaults = stainedglass_get_defaults();
?>
	<?php if ( get_theme_mod( 'favicon', $defaults['favicon'] ) != '' ) : ?>
		<link rel="shortcut icon" href="<?php echo esc_url(get_theme_mod( 'favicon', $defaults['favicon'] )); ?>" />
	<?php endif;
}
add_action('wp_head', 'stainedglass_hook_favicon');

 /**
 * Retrieve the array of ids of all terms for the current archive page 
 *
 * @param string $tax, taxonomy name
 * @since Stained Glass 1.0.0
 */
function stainedglass_get_tax_ids( $tax ) {
	$tax_names = array();
	
	while ( have_posts() ) : the_post(); 
			
		$terms = get_the_terms( get_the_ID(), $tax );
								
		if ( $terms && ! is_wp_error( $terms ) ) : 

			foreach ( $terms as $id => $term ) {
				$tax_names[ $term->term_id ] = $term->name;
			}

		endif;
		
	endwhile; 
	
	rewind_posts();

	return array_unique( $tax_names );
}

 /**
 * Retrieve the array of ids of terms from the current page
 *
 * @param string $tax, taxonomy name
 * @since Stained Glass 1.0.0
 */
function stainedglass_get_curr_tax_ids( $tax ) {
	$tax_names = array();
		
	$terms = get_the_terms( get_the_ID(), $tax );
							
	if ( $terms && ! is_wp_error( $terms ) ) : 

		foreach ( $terms as $term ) {
			$tax_names[] = $term->term_id;
		}

	endif;
			
	return array_unique( $tax_names );
}

 /**
 * Retrieve the array of names of terms from the current page
 *
 * @param string $tax, taxonomy name
 * @since Stained Glass 1.0.0
 */
function stainedglass_get_curr_tax_names( $tax ) {
	$tax_names = array();
		
	$terms = get_the_terms( get_the_ID(), $tax );
							
	if ( $terms && ! is_wp_error( $terms ) ) : 

		foreach ( $terms as $term ) {
			$tax_names[] = $term->name;
		}

	endif;
			
	return array_unique( $tax_names );
}

/**
 * Add new wrapper for woocommerce pages.
 *
 * @since Stained Glass 1.0.0
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'stainedglass_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'stainedglass_wrapper_end', 10);

function stainedglass_wrapper_start() {
  echo '<div id="woocommerce-wrapper">';
}

function stainedglass_wrapper_end() {
  echo '</div>';
}

/**
 * Change related products number
 *
 * @since Stained Glass 1.0.0
 */
add_filter( 'woocommerce_output_related_products_args', 'stainedglass_related_products_args' );
function stainedglass_related_products_args( $args ) {

	$args['posts_per_page'] = 3;
	$args['columns'] = 3;
	return $args;
}

/**
 * Echo column sidebars
 *
 * @param string $layout current layout
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_get_sidebar( $layout ) {

	if ( 'two-sidebars' == $layout ) {
		get_sidebar();
	} elseif ( 'right-sidebar' == $layout ) {
		get_sidebar( '2' );
	} elseif ( 'left-sidebar' == $layout ) {
		get_sidebar( '1' );
	}
}

/**
 * Echo column sidebars in widget
 *
 * @param string $layout current layout
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_get_sidebar_widget( $layout ) {

	if ( 'two-sidebars' == $layout ) {
		get_template_part('sidebar-widget');
	} elseif ( 'right-sidebar' == $layout ) {
		get_template_part( 'sidebar-2-widget' );
	} elseif ( 'left-sidebar' == $layout ) {
		get_template_part( 'sidebar-1-widget' );
	}
}

/**
 * Set excerpt length to 30 words
 *
 * @param string $length current length 
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'stainedglass_custom_excerpt_length', 99999 );

/**
 * Return Trimmed excerpts
 *
 * @param int $charlength length of output
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_the_excerpt( $charlength = 200 ) {
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '[...]';
	} else {
		echo $excerpt;
	}
}

/**
 * Add widgets to the top sidebar on the home page
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_the_top_sidebar_widgets() {

	the_widget( 'stainedglass_items', 'title='.__('Our Services', 'stainedglass').
								'&count=3'.
								'&columns=column-3'.
								'&is_background='.
								'&is_margin_0=1'.
								'&is_animate='.
								'&is_animate_once=1'.
								'&is_step='.
								'&is_link_0=1'.
								'&is_link_1=1'.
								'&is_link_2=1'.
								'&effect_id_0=effect-1'.
								'&image_link_0=' . get_template_directory_uri() . '/img/' . '1.jpg' . ''.
								'&image_link_1=' . get_template_directory_uri() . '/img/' . '3.jpg' . ''.
								'&image_link_2=' . get_template_directory_uri() . '/img/' . '2.jpg' . ''.
								'&title_0='.__('Blog', 'stainedglass').'&text_0='.
								'&title_1='.__('Shop', 'stainedglass').
								'&title_2='.__('Portfolio', 'stainedglass').
								'&text_0='.__('Customize icon and link for your blog or any other page.', 'stainedglass').
								'&text_1='.__('Customize icon and link for your shop or any other page.', 'stainedglass').
								'&text_2='.__('Customize icon and link for your portfolio or any other page.', 'stainedglass')
		);

}
add_action('stainedglass_empty_sidebar_top-home', 'stainedglass_the_top_sidebar_widgets', 20);

/**
 * Add widgets to the before footer sidebar on the home page
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_the_footer_sidebar_widgets() {
			
	the_widget( 'WP_Widget_Search', 'title=' );

}
add_action('stainedglass_empty_sidebar_before_footer-home', 'stainedglass_the_footer_sidebar_widgets', 20);
/**
 * Add widgets to top sidebar on all pages
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_the_top_sidebar_default() {

	the_widget( 'WP_Widget_Search', 'title=' );

}
add_action('stainedglass_empty_sidebar_top-default', 'stainedglass_the_top_sidebar_default', 20);
add_action('stainedglass_empty_sidebar_top-portfolio-page', 'stainedglass_the_top_sidebar_default', 20);
add_action('stainedglass_empty_sidebar_top-portfolio', 'stainedglass_the_top_sidebar_default', 20);

/**
 * Add widgets to the right sidebar on all pages
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_right_sidebar_default() {

	the_widget( 'WP_Widget_Calendar',
					'title='.__('Calendar', 'stainedglass').
					'&sortby=post_modified');

	the_widget( 'stainedglass_items_category', 'title='.__('Recent Posts', 'stainedglass').
								'&count=8'.
								'&category=0'.
								'&columns=column-2'.
								'&is_background=1'.
								'&is_margin_0='.
								'&is_link=1'.
								'&effect_id_0=effect-1');
}
add_action('stainedglass_empty_column_2-default', 'stainedglass_right_sidebar_default', 20);

/**
 * Add widgets to the right sidebar on portfolio pages
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_right_sidebar_portfolio() {

	the_widget( 'stainedglass_items_portfolio', 'title='.__('Recent Projects', 'stainedglass').
								'&count=4'.
								'&jetpack-portfolio-type=0'.
								'&columns=column-2'.
								'&is_background=1'.
								'&is_margin_0='.
								'&is_link=1'.
								'&effect_id_0=effect-1');
}
add_action('stainedglass_empty_column_2-portfolio-page', 'stainedglass_right_sidebar_portfolio', 20);

/**
 * Add widgets to the 404 page
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_404_sidebar() {

	the_widget( 'stainedglass_image', 'is_background=1'.
								'&is_margin_0=1'.
								'&effect_id_0=effect-17'.
								'&image_link_0=' . get_template_directory_uri() . '/img/' . '404.png' . ''.
								'&title_0=' . __( '404 Page', 'stainedglass' ) .
								'&text_0=' . __( 'It looks like nothing was found at this location. Maybe try a search?', 'stainedglass' )
	);
	the_widget( 'WP_Widget_Search', 'title=' );

}
add_action('stainedglass_empty_sidebar_top-page404', 'stainedglass_404_sidebar', 20);

/**
 * Add widgets to the left sidebar on portfolio archive/index
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_left_sidebar_portfolio() {

	the_widget( 'stainedglass_portfolio_nav', 'title='.__('Projects', 'stainedglass') );
	the_widget( 'stainedglass_portfolio_tag_nav', 'title='.__('Tags', 'stainedglass') );
}
add_action('stainedglass_empty_column_1-portfolio', 'stainedglass_left_sidebar_portfolio', 20);


// Add custom widgets and customizer files
/* Insert Page */
require get_template_directory() . '/inc/widget-page.php';

/* portfolio */
if( class_exists('Jetpack') ) {

	require get_template_directory() . '/inc/widget-items-portfolio.php';
	require get_template_directory() . '/inc/widget-recent-portfolio.php';
	require get_template_directory() . '/inc/widget-tags-naigation.php';
	require get_template_directory() . '/inc/widget-project-naigation.php';

}

/* posts */
require get_template_directory() . '/inc/widget-items-category.php';

/* shop */
if ( class_exists( 'WooCommerce' ) ) {

	require get_template_directory() . '/inc/widget-items-products.php';

}

/* images */
require get_template_directory() . '/inc/widget-items.php';
require get_template_directory() . '/inc/widget-image.php';

/* layout */
require get_template_directory() . '/inc/widget-button.php';

require get_template_directory() . '/inc/widget-functions.php';

// Add custom social media icons widget.
require get_template_directory() . '/inc/social-media-widget.php';
// Add customize options.
require get_template_directory() . '/inc/customize.php';
// Add sidebar options.
require get_template_directory() . '/inc/customize-sidebars.php';
require get_template_directory() . '/inc/customize-layout.php';
require get_template_directory() . '/inc/customize-colors.php';
require get_template_directory() . '/inc/customize-mobile.php';
require get_template_directory() . '/inc/customize-fonts.php';
require get_template_directory() . '/inc/customize-other.php';
require get_template_directory() . '/inc/customize-buttons.php';