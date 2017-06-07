<?php get_header();  ?>

	<div id="content-wrapper" class="container wrapper">
		<div class="row">
		
			<div class="top-meta clearfix">
				<div class="title-top">
					<h1 class="post-title entry-title" itemprop="headline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<div class="bord"></div>
				</div>
				
			</div>

			<div class="post-wrapper col-md-8 clearfix">

				<?php while ( have_posts() ) : the_post(); 
					get_template_part( 'inc/format/content', get_post_format() );
				endwhile; // end of the loop. ?>	

				<?php 
					unar_comment_reply(); 
					if ( comments_open() || '0' != get_comments_number() ) comments_template(); 
				?>
			
			</div><!-- wrapper -->

			<?php get_sidebar(); ?>

		</div>
	</div><!-- content-wrapper -->

<?php get_footer(); ?>