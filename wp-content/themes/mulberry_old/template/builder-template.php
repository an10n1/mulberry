<?php get_header();
while ( have_posts() ) : the_post();
/*
Template Name: Page Builder Template
*/
?>

<!-- CONTENT WRAPPER
============================================= -->
<div id="content-wrapper" class="wrapper clearfix">
	<article id="page-<?php the_ID(); ?>" <?php post_class( 'page page-builder'); ?>>

		<?php $unar_show_title = get_post_meta( $post->ID, 'unar_show_hide_title', true );
			if($unar_show_title == 'show') { ?>
			<div class="top-meta clearfix">
				<div class="title-top">
					<h3><?php the_title(); ?></h3>
					<div class="bord"></div>
				</div>
			</div>
			<?php } ?>
		<div class="post-wrapper page-content clearfix">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- page-content --> 

	</article><!-- #page<?php the_ID(); ?> -->
</div>
<!-- #content-wrapper end -->

<?php
endwhile; 
get_footer(); ?>