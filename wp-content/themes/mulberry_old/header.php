<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> > <!--<![endif]-->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<!--[if ie]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
	


<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<?php wp_head(); ?>

</head>

<body <?php body_class() ;?>>

<div id="preloader">
	<div id="status">&nbsp;</div>
</div>

<div id="main-wrapper" class="clearfix">
<?php
$logo_id    = get_theme_mod( 'custom_logo' );
$logo_image = wp_get_attachment_image_src( $logo_id, 'full' );
?>
<!-- Start of Header -->
<header id="header" class="site-header clearfix">
	<div class="container">
	
		<div class="logo">
			<?php if ( ! empty( $logo_image ) ) { ?>
        	<div class="logo-image">
				<?php echo '<a href="' . esc_url( home_url() ) . '"><img src="' . esc_url( $logo_image[0] ) . '" /></a>'; ?>
			</div>
			<?php }
			else { ?>
			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="header-logo"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
			</h1>
			<?php } ?>
		</div>

		<!-- Start of Menu  -->
		 <button id="menu-icon" class="burger">
			<i class="fa fa-bars open" aria-hidden="true"></i>
			<i class="fa fa-times btn-close" aria-hidden="true"></i>
		</button>

		<?php if ( ! empty( $logo_image ) ) { ?>
		<nav id="main-menu" class="menu logo-inserted">
		<?php }
		else { ?>
		<nav id="main-menu" class="menu">
		<?php } ?>
			<?php unar_top_nav_menu(); ?>
		</nav>
		<!-- End of Menu  -->

	</div>
	<!-- container -->
</header>
<!-- End of Header -->


