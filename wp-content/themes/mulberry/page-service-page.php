<?php

/*
Template Name: Service
*/

/**
 * @package Mulberry
 */

get_header(); ?>

  <div id="primary" class="content-area l-service">
    <div id="content" class="site-content container" role="main">
	    <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' / '); ?>

	    <?php
	    $idObj = get_category_by_slug('service');
	    $id = $idObj->term_id;

	    $posts = get_posts ("category=" . $id . "&orderby=date&numberposts=9");

	    if ($posts) : ?>
		    <?php foreach ($posts as $post) : setup_postdata ($post); ?>

          <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
	            <?php echo get_the_post_thumbnail( $id, 'small'); ?>
              <div class="caption">
                <h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                <p><?php the_content(); ?></p>
              </div>
            </div>
          </div>
			    <?php
		    endforeach;
		    wp_reset_postdata();
		    ?>
	    <?php endif; ?>
    </div><!-- #content -->
  </div><!-- #primary -->

<?php
get_footer();