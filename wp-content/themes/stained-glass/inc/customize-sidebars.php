<?php
 /**
 * Add new fields to customizer, create panel 'sidebars'
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since Stained Glass 1.0.0
 */
add_action( 'customize_register', 'stainedglass_creare_section_sidebars', 11 );
function stainedglass_creare_section_sidebars( $wp_customize ) {
	$defaults = stainedglass_get_defaults();
	
	/* Create default, blog, home, page, shop sections for choosing custom sidebars for different types of pages */
	
	$wp_customize->add_panel( 'sidebars', array(
		'priority'       => 1,
		'title'          => __( 'Customize Sidebars', 'stainedglass' ),
		'description'    => __( 'In this section you can add or remove sidebars for particular pages.', 'stainedglass' ),
	) );	

	$section_priority = 10;

	foreach( $defaults['defined_sidebars'] as $sidebar_type_id => $sidebar_type) {
		if( 'static' == $sidebar_type_id )
			continue;
	
		$wp_customize->add_section( $sidebar_type_id, array(
			'priority'       => $section_priority++,
			'title'          => $sidebar_type['title'],
			'description'    => ($sidebar_type_id != 'default' ? __( 'You can add custom sidebars for the page(s) "', 'stainedglass' ) . $sidebar_type['title'] . __('" by selecting options in this section. Default sidebars won\'t be shown on this page(s).', 'stainedglass' ) 
														: __( 'Default sidebars for all pages, post and custom post types.', 'stainedglass' )),
			'panel'  => 'sidebars',
		) );	
	
		$priority = 1;
		
		$wp_customize->add_setting( $sidebar_type_id, array(
			'default'        => $sidebar_type['use'],
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'stainedglass_sanitize_checkbox'
		) );
		
		if( 'default' == $sidebar_type_id)
			$message = __( 'Register default sidebars for all pages', 'stainedglass');
		else
			$message = __( 'Override default sidebars by custom sidebars on ', 'stainedglass' ) . $sidebar_type['title'] . __( ' (must be checked). Please, choose sidebars which you want to use on this page.', 'stainedglass' );

		$wp_customize->add_control( $sidebar_type_id, array(
			'label'      => $message,
			'section'    => $sidebar_type_id,
			'settings'   => $sidebar_type_id,
			'type'       => 'checkbox',
			'priority'       => $priority++,
		) );
		
		foreach( $defaults['theme_sidebars'] as $slug => $sidebars ) {
			if($sidebars['is_constant'] != '1') {

				$wp_customize->add_setting( $slug.'_'.$sidebar_type_id, array(
					'type'			 => 'theme_mod',
					'default'        => $sidebar_type[$slug],
					'capability'     => 'edit_theme_options',
					'sanitize_callback' => 'stainedglass_sanitize_checkbox'
				) );

				$wp_customize->add_control( $slug.'_'.$sidebar_type_id, array(
					'label'      => $sidebars['title'],
					'section'    => $sidebar_type_id,
					'settings'   => $slug.'_'.$sidebar_type_id,
					'type'       => 'checkbox',
					'priority'       => $priority++,
				) );
			}
		}	
	}
	
}

/**
 * Register sidebars and widgetized areas.
 *
 * @since Stained Glass 1.0.0
 */
function stainedglass_widgets_init() {

	$defaults = stainedglass_get_defaults();
	
	// Register all sidebars
	foreach( $defaults['defined_sidebars'] as $slug => $defined_sidebars ) {
		foreach( $defaults['theme_sidebars'] as $id => $theme_sidebars ) {
			if( '1' == $theme_sidebars['is_constant'] )
				continue;
			//is this type of sidebars in use
			if( '1' != get_theme_mod($slug, $defined_sidebars['use'] ) )
				continue;

			$def = ( isset( $defined_sidebars[ $id ]) ? $defined_sidebars[ $id ] : '');
			
			$is_active = get_theme_mod( $id.'_'.$slug, 'empty' );
			if( 'empty' == $is_active ) 
				$is_active = $def;
			
			if( '1' == $is_active ) {
				register_sidebar( array(
					'name' => $defined_sidebars['title'].' '.$theme_sidebars['title'],
					'id' => $id.'-'.$slug,
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget' => "</aside>",
					'before_title' => '<h3 class="widget-title">',
					'after_title' => '</h3>',
				) );					
			}
		}
	}
	
	// register constant sidebars
	foreach( $defaults['theme_sidebars'] as $id => $theme_sidebars ) {
		if( '1' != $theme_sidebars['is_constant'] )
			continue;
		register_sidebar( array(
			'name' => $theme_sidebars['title'],
			'id' => $id,
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );					
	}
}
add_action( 'widgets_init', 'stainedglass_widgets_init' );

/**
 * Return sidebar slug for the current page
 *
 * @return string sidebar slug or null
 * @since Stained Glass 1.0.0
 */
function stainedglass_get_sidebar_slug() {
	global $stainedglass_sidebar_slug;
	if( isset($stainedglass_sidebar_slug) )
		return $stainedglass_sidebar_slug;

	$defaults = stainedglass_get_defaults();
		
	foreach( array_reverse( $defaults['defined_sidebars'] ) as $slug => $defined_sidebars ) {
	
		$def = $defined_sidebars['use'];
				
		$is_active_sidebar = get_theme_mod( $slug, '0' );
		
		if( '0' == $is_active_sidebar )
			$is_active_sidebar =  $def;
		
		if( '1' != $is_active_sidebar )
			continue;
			
		if( '' == $defined_sidebars['callback'] ) {
			$stainedglass_sidebar_slug = apply_filters( 'stainedglass_sidebar_slug', $slug );
			return $stainedglass_sidebar_slug;
		}
		
		if( call_user_func( $defined_sidebars['callback'], $defined_sidebars['param'] ) ) {
			$stainedglass_sidebar_slug = apply_filters( 'stainedglass_sidebar_slug', $slug );
			return $stainedglass_sidebar_slug;
		}
	}
	return apply_filters( 'stainedglass_sidebar_slug', null );
}

/**
 * Return sidebar slug for the page with given id
 *
 * @return string sidebar slug or null
 * @since Stained Glass 1.0.0
 */
function stainedglass_get_page_sidebar_slug( $page_id ) {

	$defaults = stainedglass_get_defaults();
	
	/* check for per page sidebars */
	
	$page_sidebars = ( array )get_theme_mod( 'page_sidebars', null );

	if( isset($page_sidebars[ $page_id ]) ) {
		$slug = 'page_'.$page_id;
		return $slug;
	}	
	else { 
	
	/* check for page sidebars */		
		$is_active_sidebar = get_theme_mod( 'page', 'empty' );
			if( 'empty' != $is_active_sidebar )
				$slug = 'page';			
			else
				$slug = 'default';
		
		return $slug;
	}
	
	return null;
}
/**
 * Check for WooCommerce pages.
 *
 * @return bool true on success
 * @since Stained Glass 1.0.0
 */
function stainedglass_is_shop() {
	if( function_exists('is_woocommerce') && is_woocommerce() && ( is_shop() || is_archive() ) )
		return true;
	return false;
}
/**
 * Check for WooCommerce pages.
 *
 * @return bool true on success
 * @since Stained Glass 1.0.0
 */
function stainedglass_is_shop_page() {
	if( function_exists('is_woocommerce') && is_woocommerce() )
		return true;
	return false;
}
/**
 * Check for both Jetpack's Portfolio archive/index page.
 *
 * @return bool true on success
 * @since Stained Glass 1.0.0
 */
function stainedglass_is_portfolio() {
	if( is_tax('jetpack-portfolio-type') || ('jetpack-portfolio' == get_post_type() && ! is_singular('jetpack-portfolio')) && ! is_search() )
		return true;
	return false;
}
/**
 * Check for Jetpack's Portfolio singular page.
 *
 * @return bool true on success
 * @since Stained Glass 1.0.0
 */
function stainedglass_is_portfolio_page() {

	if( is_singular('jetpack-portfolio') ) {
		return true;
	}
	return false;
}