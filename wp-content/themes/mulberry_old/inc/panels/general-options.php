<?php
// Set Panel ID
$panel_id = 'unar_panel_general';

// Set prefix
$prefix = 'unar';


// Change panel for Colors
$site_bg_color        = $wp_customize->get_section( 'colors' );
$site_bg_color->panel = $panel_id;
$site_bg_color->title = esc_html__( 'Background Color', 'unar' );
$site_bg_color->priority = 4;

// Change panel for Background Image
$site_bg_img        = $wp_customize->get_section( 'background_image' );
$site_bg_img->panel = $panel_id;
$site_bg_img->priority = 5;

// Change panel for Static Front Page
$site_title        = $wp_customize->get_section( 'static_front_page' );
$site_title->panel = $panel_id;

// Change Logo section
$site_logo              = $wp_customize->get_control( 'custom_logo' );
$site_logo->description = esc_html__( 'The site logo is used as a graphical representation of your company name. Recommended size: 105 (width) x 75 (height) pixels(px).', 'unar' );
$site_logo->label       = esc_html__( 'Site logo', 'unar' );
$site_logo->section     = $prefix . '_general_logo_section';
$site_logo->priority    = 1;

// Change site icon section
$site_icon           = $wp_customize->get_control( 'site_icon' );
$site_icon->section  = $prefix . '_general_logo_section';
$site_icon->priority = 2;

// Change panel for Static Front Page
$bocah        = $wp_customize->get_section( 'title_tagline' );
$bocah->panel = $panel_id;
$bocah->priority    = 1;

/***********************************************/
/************** GENERAL OPTIONS  ***************/
/***********************************************/


$wp_customize->add_panel( $panel_id, array(
	'priority'       => 1,
	'capability'     => 'edit_theme_options',
	'theme_supports' => '',
	'title'          => esc_html__( 'General Options', 'unar' ),
	'description'    => esc_html__( 'You can change the site layout in this area as well as your contact details (the ones displayed in the header & footer) ', 'unar' ),
) );

/***********************************************/
/*********** Logo section  ************/
/***********************************************/

$wp_customize->add_section( $prefix . '_general_logo_section', array(
	'title'    => esc_html__( 'Logo', 'unar' ),
	'priority' => 2,
	'panel'    => $panel_id,
) );


/***********************************************/
/************** Footer Details  ***************/
/***********************************************/
$wp_customize->add_section( $prefix . '_general_footer_section', array(
	'title'       => esc_html__( 'Footer Section', 'unar' ),
	'description' => esc_html__( 'Change the footer copyright and widgets area column.', 'unar' ),
	'priority'    => 3,
	'panel'       => $panel_id,
) );

/* Footer Copyright */
$wp_customize->add_setting( $prefix . '_footer_copyright', array(
	'sanitize_callback' => 'unar_sanitize_html',
	'default'           => esc_html__( '&copy; Copyright 2016. All Rights Reserved.', 'unar' ),
	'transport'         => 'postMessage',
) );

$wp_customize->add_control( $prefix . '_footer_copyright', array(
	'label'       => esc_html__( 'Footer Copyright', 'unar' ),
	'description' => esc_html__( 'Use this to display your company copyright message.', 'unar' ),
	'section'     => $prefix . '_general_footer_section',
	'priority'    => 2,
) );

$wp_customize->add_setting( $prefix . '_widget_select', array(
	'sanitize_callback' => 'unar_sanitize_select',
	'default'           => 1,
) );

$wp_customize->add_control( $prefix . '_widget_select', array(
	'label'         => esc_html__( 'Footer Widget Column', 'unar' ),
    'type'          => 'select',
    'section'     => $prefix . '_general_footer_section',
    'choices'       => array(
        1   => esc_html__( 'One Column', 'unar' ),
        2   => esc_html__( 'Two Column', 'unar' ),
        3   => esc_html__( 'Theree Column', 'unar' ),
        4   => esc_html__( 'Four Column', 'unar' ),
    ),
    'priority' => 8,
) );