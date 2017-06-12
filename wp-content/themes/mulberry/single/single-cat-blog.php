<?php
/*
 * Template Name: Blog Single
 * Template Post Type: blog
 */

get_header(); ?>

<div class="single-post-content l-blog-single">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
	      <?php if ( function_exists( 'kama_breadcrumbs' ) ) {
		      kama_breadcrumbs( ' / ' );
	      } ?>
      </div>
    </div>

    <div class="row">

      <div class="col-md-12">
        <div class="single-post-main-content">
          <div id="primary" class="content-area">
            <div id="content" class="site-content" role="main">
              <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'content', get_post_format() ); ?>
              <?php endwhile; ?>
            </div><!-- #content -->
          </div><!-- #primary -->
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="blog-bottom-sidebar">
          <div class="blog-random-post-block">

            <div class="title-sidebar-subblock">
              <p class="text-sidebar-subblock">Рекомендуемые статьи</p>
            </div>
            <ul>
              <?php
              global $post;
              $postid = $post->ID;
              $args   = array(
                'orderby'      => 'rand',
                'showposts'    => 3,
                'post__not_in' => array( $postid )
              );
              query_posts( $args );
              while ( have_posts() ) : the_post();
                echo '<li><div class="post-wrap">';
	              if (class_exists('MultiPostThumbnails')) :
		              MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'secondary-image');

	              else:
                    echo '<img src="img/bg/empty.png" />';
	              endif;
                echo '<footer><a href="' . get_permalink() . '" class="blog-random-link" title="' . the_title( '', '', false ) . '">' . the_title( '', '', false ) . '</a>';
	              the_date('Y-m-d', '<span class="post-date">', '</span>');
	              echo '<a href="'.get_permalink().'" class="more-link">Читать далее >></a><div class="clear"></div>';
                echo '</footer></div></li>';
                endwhile;
              ?>
            </ul>
          </div>

        </div>
      </div>
    </div>
  </div>


  <div class="clear"></div>
</div>

<?php comments_template(); ?>

<?php wp_list_comments(); ?>

<?php comments_template(); ?>

<?php get_footer(); ?>
