<?php
/*
Plugin Name: Simple Masonry Gallery
Plugin URI: https://wordpress.org/plugins/simple-masonry-gallery/
Version: 6.04
Description: Add the effect of Masonry to image.
Author: Katsushi Kawamori
Author URI: http://riverforest-wp.info/
Text Domain: simple-masonry-gallery
Domain Path: /languages
*/

/*  Copyright (c) 2014- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; version 2 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

	load_plugin_textdomain('simple-masonry-gallery');
//	load_plugin_textdomain('simple-masonry-gallery', false, basename( dirname( __FILE__ ) ) . '/languages' );

	define("SIMPLEMASONRY_PLUGIN_BASE_FILE", plugin_basename(__FILE__));
	define("SIMPLEMASONRY_PLUGIN_BASE_DIR", dirname(__FILE__));
	define("SIMPLEMASONRY_PLUGIN_URL", plugins_url($path='',$scheme=null).'/simple-masonry-gallery');

	require_once( dirname( __FILE__ ) . '/req/SimpleMasonryAdmin.php' );
	$simplemasonryadmin = new SimpleMasonryAdmin();
	add_action( 'admin_menu', array($simplemasonryadmin, 'plugin_menu'));
	add_filter( 'plugin_action_links', array($simplemasonryadmin, 'settings_link'), 10, 2 );
	add_action( 'admin_print_footer_scripts', array($simplemasonryadmin, 'simplemasonry_add_quicktags'));
	unset($simplemasonryadmin);

	include_once( SIMPLEMASONRY_PLUGIN_BASE_DIR.'/inc/SimpleMasonry.php' );
	$simplemasonry = new SimpleMasonry();
	$simplemasonry->simplemasonry_count = 0;
	$simplemasonry->simplemasonry_atts = array();
	add_shortcode( 'simplemasonrygallery', array($simplemasonry, 'simplemasonrygallery_func') );
	add_action( 'wp_enqueue_scripts', array($simplemasonry, 'load_frontend_scripts' ) );
	add_action( 'wp_footer', array($simplemasonry, 'load_localize_scripts_styles') );
	unset($simplemasonry);

