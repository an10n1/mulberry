<article class="post hentry">

	<div class="single-portfolio-content col-md-8">
									
		<h4 class="project-detail-title"><?php esc_html_e( 'Project Description', 'unar' ); ?></h4>
		<div class="bord"></div>

		<div class="single-portfolio-details">
			<?php the_content(); ?>
		</div>

	</div>

	<div class="single-portfolio-info col-md-4">

		<div class="single-info-detail">
			<h4 class="project-detail-title"><?php esc_html_e( 'Project Detail', 'unar' ); ?></h4>
			<div class="bord"></div>
			
			<?php
			if(class_exists('unar_extra_class')) {

			$portfolio_author = get_post_meta( $post->ID, 'portfolio_author', true );
			if (!empty($portfolio_author)) { ?>
			<div class="single-portfolio-detail"><h6><?php esc_html_e( 'Author :', 'unar' ); ?></h6>
				<?php echo sanitize_text_field( $portfolio_author ); ?>			
			</div>
			<?php }

			$portfolio_date = get_post_meta( $post->ID, 'portfolio_date', true );
			if (!empty($portfolio_date)) { ?>
			<div class="single-portfolio-detail"><h6><?php esc_html_e( 'Date :', 'unar' ); ?></h6>
				<?php echo sanitize_text_field( $portfolio_date ); ?>	
			</div>
			<?php } ?>
			
			<div class="single-portfolio-detail"><h6><?php esc_html_e( 'Category :', 'unar' ); ?></h6>
				<?php unar_portfolio_category(); ?>
			</div>
			
			<?php 
			$portfolio_client = get_post_meta( $post->ID, 'portfolio_client', true );
			if (!empty($portfolio_client)) { ?>
			<div class="single-portfolio-detail"><h6><?php esc_html_e( 'Client :', 'unar' ); ?></h6>
				<?php echo sanitize_text_field( $portfolio_client ); ?>
			</div>
			<?php }
	 
			$portfolio_website = get_post_meta( $post->ID, 'portfolio_website', true );
			if (!empty($portfolio_website)) { ?>
			<div class="single-portfolio-detail"><h6><?php esc_html_e( 'Website :', 'unar' ); ?></h6>
				<a href="<?php echo esc_url( $portfolio_website ); ?>"><?php echo sanitize_text_field( $portfolio_website ); ?></a>
			</div>
			<?php }

			} ?>
		</div>
		<!-- single-info-detail end -->

	</div>
	<!-- single-portfolio-info end -->

</article><!-- end hentry -->