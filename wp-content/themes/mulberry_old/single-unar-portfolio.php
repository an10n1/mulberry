<?php get_header(); ?>

<div id="content-wrapper" class="single-portfolio wrapper clearfix">

	<?php 
	if(class_exists('unar_extra_class')) {
		$unar_hero_image = get_post_meta( $post->ID, 'portfolio_hero_image', true );
		if(!empty($unar_hero_image)) { ?>
		<div class="single-portfolio-hero">
	    	<img src="<?php echo esc_url( $unar_hero_image ); ?>" alt="<?php esc_html_e( 'image-hero', 'unar' ); ?>">
	    </div>
	    <?php }
    }
    else {
	    if ( has_post_thumbnail()) { ?>
		<?php $unar_hero_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full'); ?>
		<div class="single-portfolio-hero">
	    	<img src="<?php echo esc_url( $unar_hero_image['0'] ); ?>" alt="<?php esc_html_e( 'image-hero', 'unar' ); ?>">
	    </div>
	    <?php } 
	} ?>

    <div class="container">
		<div class="row">

			<div class="content-area" id="primary">
				<div class="site-content" id="content">

					<?php while ( have_posts() ) : the_post(); 
					
						get_template_part( 'inc/format/content', 'portfolio' );

					endwhile; // end of the loop. ?>		

				</div><!-- end site-content -->
			</div><!-- end content-area -->

		</div>
	</div>
	<!-- container end -->

</div>

<?php get_footer(); ?>