<?php

/*
Template Name: Coast
*/

/**
 * @package Mulberry
 */

get_header(); ?>

  <div id="primary" class="content-area l-coast">
    <div id="content" class="site-content container" role="main">
		<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' | '); ?>

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;

		?>
    </div><!-- #content -->
  </div><!-- #primary -->


<?php
get_footer();