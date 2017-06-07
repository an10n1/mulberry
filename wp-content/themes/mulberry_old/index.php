<?php get_header();  ?>

	<div id="content-wrapper" class="container wrapper">
		<div class="row">

			<div class="post-wrapper col-md-8 clearfix">

				<?php while ( have_posts() ) : the_post(); 
					
					get_template_part('inc/format/loop', get_post_format());

				endwhile; // end of the loop. ?>	

				<?php unar_content_nav( 'nav-loop' ); ?>

			</div><!-- wrapper -->

			<?php get_sidebar(); ?>

		</div>
	</div><!-- content-wrapper -->

<?php get_footer(); ?>