<?php
/**
 * Шаблон рубрики (category.php)
 * @package WordPress
 * @subpackage Mulberry
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content archive container" role="main">
      <div class="row">
        <div class="col-md-12">
          <h3>Категории</h3>
          <ul>
	        <?php $categories = get_categories(array(
		        'orderby' => 'name',
		        'order' => 'ASC'
	        ));
	        foreach( $categories as $category ){
		        echo '<li><a href="' . str_replace('/category/', '/', get_category_link( $category->term_id ) ) . '" class="blog-link-category" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.' <span class="cat-count">('.$category->count.')</span></a></li>';
	        } ?>
          </ul>
        </div>
      </div>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>