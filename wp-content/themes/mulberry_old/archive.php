<?php get_header();  ?>

	<div id="content-wrapper" class="container wrapper">
		<div class="row">

			<div class="post-wrapper col-md-8 clearfix">
				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); 
						get_template_part( 'inc/format/loop', get_post_format() );
					endwhile; ?>
					
					<?php else : ?>

					<?php get_template_part( 'inc/format/content', 'no-result' ); ?>

				<?php endif; ?>
		
				<?php unar_content_nav( 'nav-loop' ); ?>
			</div><!-- wrapper -->

			<?php get_sidebar(); ?>

		</div>
	</div><!-- content-wrapper -->

<?php get_footer(); ?>