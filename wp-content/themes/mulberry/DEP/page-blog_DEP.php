<?php

/*
*/

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Infinity
 */
get_header(); ?>
<header id="masthead" class="site-header" role="banner">
			<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<?php if(get_theme_mod('portfolio_logo', '') !== '') : ?>
					<img src="<?php echo get_theme_mod('portfolio_logo', ''); ?>" alt="<?php bloginfo( 'name' ); ?>" />
				<?php else: ?>
					<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
					<?php if(trim(get_bloginfo('description')) != '' || is_customize_preview()) : ?>
					<h2 class="site-description"><?php bloginfo('description'); ?></h2>
					<?php endif; ?>
				<?php endif; ?>
			</a>
			
			<?php if(get_theme_mod('portfolio_show_topbar_search', '') != '') : ?>
			<form role="search" method="get" class="search-topbar" action="<?php echo home_url( '/' ); ?>">
				<label>
					<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'portfolio' ); ?></span>
					<input type="search" class="search-topbar-field" placeholder="<?php echo esc_attr_x( 'Search �', 'placeholder', 'portfolio' ); ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'portfolio' ); ?>" />
				</label>
			</form>
			<?php endif; ?>
			
			<?php if(get_theme_mod('portfolio_show_topbar_social', '') != '') : ?>
			<?php wp_nav_menu(array('theme_location' => 'footer', 'menu_class' => 'social-menu-topbar')); ?>
			<?php endif; ?>
		</header><!-- #masthead -->
				
		<div id="main" class="site-main">
			<div id="page" class="hfeed site">
		
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
				</nav><!-- #site-navigation -->
