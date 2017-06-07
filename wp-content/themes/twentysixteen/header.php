<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous">
  <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g="
      crossorigin="anonymous"></script>
  <script
      src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
      integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
      crossorigin="anonymous"></script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <nav class="static-nav">
          <div class="float-left">
            <img src="#" alt="Logo">
          </div>
          <div class="float-right">
            <ul>
              <li>1</li>
              <li>2</li>
              <li>3</li>
            </ul>
          </div>
        </nav>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav id="site-navigation" class="main-navigation navbar navbar-default" role="navigation"
               aria-label="<?php esc_attr_e( 'Primary Menu', 'twentysixteen' ); ?>">
			  <?php
			  wp_nav_menu( array(
				  'theme_location'  => 'primary',
				  'menu'            => 'primary',
				  'container'       => 'div',
				  'container_class' => 'collapse navbar-collapse',
				  'container_id'    => 'bs-example-navbar-collapse-1',
				  'menu_class'      => 'nav navbar-nav',
				  'menu_id'         => '',
				  'echo'            => true,
				  'fallback_cb'     => 'wp_page_menu',
				  'before'          => '',
				  'after'           => '',
				  'link_before'     => '',
				  'link_after'      => '',
				  'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				  'depth'           => 0,
				  'walker'          => '',
			  ) );
			  ?>
          </nav>
        </div>
      </div>
    </div>
  </div>
</header>

<div id="content" class="site-content">
