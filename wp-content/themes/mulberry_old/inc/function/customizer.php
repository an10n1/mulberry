<?php 

/*
*
*	Theme Customizer Options
*	------------------------------------------------
*	Munding Framework
* 	Copyright Themes Awesome 2013 - http://www.themesawesome.com
*
*	unar_customize_register()
*	unar_customize_preview()
*
*/
	
if (!function_exists('unar_customize_register')) {
	function unar_customize_register($wp_customize) {
		
		$wp_customize->get_setting('blogname')->transport='postMessage';
		$wp_customize->get_setting('blogdescription')->transport='postMessage';
		$wp_customize->get_setting('header_textcolor')->transport='postMessage';

		// General Controls
		require_once get_template_directory() . '/inc/panels/general-options.php';

		// Extend Controls
		require_once get_template_directory() . '/inc/panels/extend-options.php';

	}
	add_action( 'customize_register', 'unar_customize_register' );
}

/**
*  Customizer Live Preview
*/
	function unar_customizer_live_preview() {
	wp_enqueue_script( 'unar-customizer',	get_template_directory_uri() .'/js/customizer.js', array( 'jquery','customize-preview' ), NULL, true);
	}
	add_action( 'customize_preview_init', 'unar_customizer_live_preview' );

/**
 *  Sanitize HTML
 */
if ( ! function_exists( 'unar_sanitize_html' ) ) {
	function unar_sanitize_html( $input ) {
		$input = force_balance_tags( $input );

		$allowed_html = array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
			),
			'br'     => array(),
			'em'     => array(),
			'img'    => array(
				'alt'    => array(),
				'src'    => array(),
				'srcset' => array(),
				'title'  => array(),
			),
			'strong' => array(),
		);
		$output       = wp_kses( $input, $allowed_html );

		return $output;
	}
}

if ( ! function_exists( 'unar_sanitize_select' ) ) {
	function unar_sanitize_select( $input ) {
		if ( is_numeric( $input ) ) {
			return intval( $input );
		}
	}
}