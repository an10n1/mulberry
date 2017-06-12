<?php

/*
Template Name: Blog
*/

/**
 * @package Mulberry
 */

get_header(); ?>

  <div id="primary" class="content-area l-blog">
    <div id="content" class="site-content container" role="main">
		  <div class="row">
        <div class="col-md-12">
	        <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' / '); ?>
        </div>
      </div>

      <div class="row">

        <div class="col-md-3">
          <div class="blog-right-sidebar" >
            <div class="blog-category-block">
              <div class="title-sidebar-subblock">
                <h4 class="text-sidebar-subblock">Категории</h4>
              </div>
              <div class="category-list">
                <ul>
                  <?php $categories = get_categories(array(
                    'orderby' => 'name',
                    'order' => 'ASC'
                  ));
                  foreach( $categories as $category ){
                    echo '<li><a href="' . get_category_link( $category->term_id ) . '" class="blog-link-category" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.' <span class="cat-count">('.$category->count.')</span></a>'.'</li>';
                  } ?>
                </ul>
              </div>
            </div>

            <div class="blog-random-post-block">

              <div class="title-sidebar-subblock">
                <h4 class="text-sidebar-subblock">Рекомендуемые статьи</h4>
              </div>
              <ul>
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
                echo '<li>';

                if (class_exists('MultiPostThumbnails')) :
                  MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'secondary-image');
                else:
                    echo '<img height="80" width="80" alt="empty" />';
                endif;

                echo '<span><a href="'.get_permalink().'" class="blog-random-link" title="'.the_title('','',false).'">'.the_title('','',false).'</a>';
                the_date('Y-m-d', '<span class="post-date">', '</span>');

                echo '</span></li>';
              endwhile;
              ?>
              </ul>
            </div>

          </div>
        </div>

        <div class="col-md-8 col-md-push-1">
          <?php
          $idObj = get_category_by_slug('blog');
          $id = $idObj->term_id;
          $thumbFlag = false;

          $posts = get_posts ("category=" . $id);

          if ($posts) : ?>
            <?php foreach ($posts as $post) : setup_postdata ($post); ?>
                <div class="thumbnail">
                  <div class="row">
                    <?php if (get_the_post_thumbnail( $id, 'small')): ?>
                      <div class="col-md-6">
                        <?php
                        $thumbFlag = true;
                        echo get_the_post_thumbnail( $id, 'small'); ?>
                      </div>
                    <?php endif ?>
                    <div class="<?php if($thumbFlag){ echo 'col-md-6'; }else{ echo 'col-md-12'; }; ?>">
                      <div class="caption">
                        <?php the_date('Y-m-d', '<span class="post-date">', '</span>'); ?>
                        <h3><?php the_title(); ?></h3>
                        <p><?php the_content(); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              <?php
            endforeach;
            wp_reset_postdata();
            ?>
          <?php endif; ?>
        </div>

      </div>
    </div><!-- #content -->
  </div><!-- #primary -->

<?php
get_footer();