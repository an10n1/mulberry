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
	    <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' | '); ?>

      <div class="is-flex">

	    <?php
	    $idObj = get_category_by_slug('service');
	    $id = $idObj->term_id;

	    $posts = get_posts ("category=" . $id . "&orderby=date&numberposts=100");

	    if ($posts) : ?>
		    <?php foreach ($posts as $post) : setup_postdata ($post); ?>

          <div class="col-sm-6 col-md-4 is-flex-item">
            <div class="thumbnail">
              <h4><?php the_title(); ?></h4>
	            <?php echo get_the_post_thumbnail( $id, 'small'); ?>
              <div class="caption">
                <?php the_content(); ?>
              </div>

              <div class="clear"></div>
            </div>
          </div>
			    <?php
		    endforeach;
		    wp_reset_postdata();
		    ?>
	    <?php endif; ?>

      </div>
    </div><!-- #content -->
  </div><!-- #primary -->

<?php
get_footer();