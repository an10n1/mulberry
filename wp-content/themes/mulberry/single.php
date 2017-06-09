<?php
/**
 * Шаблон отдельной записи (single.php)
 * @package WordPress
 * @subpackage Mulberry
 */
get_header(); ?>

<?php //get_sidebar('sidebar'); ?>



	<div class="single-post-content">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
	        <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' / '); ?>
        </div>

        <div class="col-md-9">
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

        <div class="col-md-3">
          <div class="blog-right-sidebar" >
            <div class="blog-category-block">
              <div class="title-sidebar-subblock">
                <p class="text-sidebar-subblock">Категории</p>
              </div>
              <div class="category-list">
                <ul>
                    <?php $categories = get_categories(array(
                        'orderby' => 'name',
                        'order' => 'ASC'
                    ));
                    foreach( $categories as $category ){
                        echo '<a href="' . get_category_link( $category->term_id ) . '" class="blog-link-category" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a>'.'<br>';
                    } ?>
                </ul>
              </div>
            </div>

            <div class="blog-random-post-block">

              <div class="title-sidebar-subblock">
                <p class="text-sidebar-subblock">Рекомендуемые статьи</p>
              </div>
              <div style="padding-left: 10px">
                  <?php
                  global $post;
                  $postid = $post->ID;
                  $args = array(
                      'orderby' => 'rand',
                      'showposts'=>3,
                      'post__not_in'=>array($postid)
                  );
                  query_posts($args);
                  while (have_posts()) : the_post();
                      echo '<a href="'.get_permalink().'"class="blog-random-link" title="'.the_title('','',false).'">'.the_title('','',false).'</a><br>';
                  endwhile;
                  ?>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>


		<div class="clear"></div>
	</div>
	<?php comments_template(); ?>

	<?php wp_list_comments(); ?>

	<?php get_template_part( 'content', 'footer' ); ?>

	<?php comments_template(); ?>

<?php get_footer(); ?>
