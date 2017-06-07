<?php get_header(); ?>

<article class="single-post post no-result 404 clearfix">
	<div class="container"> 

		<div class="error-page">
			
			<div class="error-header text-center">
				<h2><?php esc_html_e( 'Sorry, page not found.', 'unar' ); ?></h2>
				<p><?php esc_html_e( 'The page you are looking for is no longer available or has been moved.', 'unar' ); ?></p>
			</div><!-- end error-header -->

			<div class="various-content">

				<div class="var-section">
					<h4><?php esc_html_e( 'Search the site', 'unar' ); ?></h4>
					
					<?php get_search_form(); ?>
				</div><!-- end var-section -->

				<div class="var-section">
					<h4><?php esc_html_e( 'Latest Article', 'unar' ); ?></h4>
					<ul>
						<?php 
				    		query_posts('post_type=post&posts_per_page='); 
				    		if( have_posts() ) : while ( have_posts() ): the_post(); 
				    	?>
				    	
					    	  <li>
					    	    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					    	  </li>
				    	  
				    	<?php 
				    		endwhile; 
				    		endif; 
				    		wp_reset_query(); 
				    	?>
					</ul>
				</div><!-- end var-section -->

			</div><!-- end various-content -->

		</div><!-- end error-page -->

	</div><!-- post-content -->
</article><!-- #post-0 .post .no-result .not-found -->

<?php get_footer();