<?php
/**
 * Шаблон шапки (header.php)
 * @package WordPress
 * @subpackage Mulberry
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> lang="ru-RU">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
      <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>

  <link
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous">
  <script
      src="https://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
      crossorigin="anonymous"></script>
  <script
      src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
      integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
      crossorigin="anonymous"></script>

<!--	<link rel="stylesheet" href="--><?php //echo get_template_directory_uri(); ?><!--/style.css">-->

	
	<!--[if lt IE 9]>	
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->

  <script src="<?php echo get_template_directory_uri(); ?>/source/main.js"></script>
	
	<?php wp_head(); ?>
</head>


<body <?php body_class(); ?>>

<?php $options = get_option('sample_theme_options'); ?>

<div class="page-wrapper">
<div class="header-line"></div>
<header>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <nav class="static-nav">
          <div class="col-md-4">
            <a class="navbar-brand" href="<?php echo get_home_url(); ?>">
              <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="LOGO" />
            </a>
          </div>
          <div class="col-md-7 col-md-offset-1">
            <ul>
              <li class="col-md-3">
                <span class="brown-color">График работы </span>
                ПН-ВС <br>
                8:00 - 19:00
              </li>
              <li class="col-md-6">
                <span class="lighten-black">Свяжитесь с нами по email</span>
                <a class="email" href="mailto:<?= $options['emailtext']?>"><?= $options['emailtext']?></a>
              </li>
              <li class="col-md-3">
                <span class="brown-color">Звоните нам </span>
	              <span class="tel"><?= $options['phonetext1']; ?></span>
                <br>
                <span class="tel"><?= $options['phonetext2']; ?></span>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>
  </div>
  <div class="container-fluid nav-list-container">
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
