<?php get_header(); ?>

	<div id="content-wrapper" class="container wrapper">
		<div class="row">
			
			<?php 
			if(class_exists('unar_extra_class')) {
			$unar_show_title = get_post_meta( $post->ID, 'show_hide_title', true );
			if($unar_show_title == 'show') { ?>
			<div class="top-meta clearfix">
				<div class="title-top">
					<h3><?php the_title(); ?></h3>
					<div class="bord"></div>
				</div>
			</div>
			<?php }
			} ?>

			<div class="post-wrapper col-md-12 clearfix">

				<?php while ( have_posts() ) : the_post(); 
					get_template_part( 'inc/format/content', 'page' );
				endwhile; // end of the loop. ?>

				<?php 
					unar_comment_reply(); 
					if ( comments_open() || '0' != get_comments_number() ) comments_template(); 
				?>

			</div><!-- wrapper -->

		</div>
	</div><!-- content-wrapper -->

<?php get_footer(); ?>