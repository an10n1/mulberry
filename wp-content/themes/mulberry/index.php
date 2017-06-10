<?php
/**
 * Главная страница (index.php)
 * @package WordPress
 * @subpackage Mulberry
 *
 * TODO
 */
get_header(); ?>

<div class="">
	<section class="banner advertiser-banner fix-adv-banner" style="padding: 200px 0 105px;background-image: url('<?php echo get_template_directory_uri(); ?>/img/new-design/blog-banner.jpg')">
		<div class="container">
			<p class="banner__tittle fix-adv-title">
				Будьте в курсе!
			</p>
		</div>
	</section>

  <section class="contact-form affil-fix-bg-color">
    <div class="container">
      <div class="row wrapper-form-block">
        <div  class="form-block col-md-5">
          <h1 style="line-height: 3;">Узнавай о новинках первым!</h1>
        </div>
        <div class="form-block col-md-7">
          <form action="<?php echo get_template_directory_uri(); ?>/formAdvertiser.php" method="post" class="affil-fix-form  adv-form-block">
            <input type="text" name = "name" class="contact-form__name affil-form-field" placeholder="Ваше имя" required>
            <input type="text" name = "email" class="contact-form__email affil-form-field" placeholder="Ваш Email" required>
            <input type="submit" class="button-grad" value="Подписаться">
          </form>
        </div>
      </div>
    </div>
  </section>

	<div id="primary2" class="content-area blog-main-content">
    <div class="container">
      <div class="row">
        <div class="col-md-9">
          <div id="content" class="site-content archive blog-left-content" role="main">
              <?php if ( have_posts() ) : ?>
                  <?php while ( have_posts() ) : the_post(); ?>
                      <?php get_template_part( 'content-archive', get_post_format() ); ?>
                  <?php endwhile; ?>
              <?php else : ?>
                  <?php get_template_part( 'content', 'none' ); ?>
              <?php endif; ?>
          </div><!-- #content -->
        </div>

        <div class="col-md-3">
          <div class="blog-right-sidebar">
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

            <div class="blog-social-block">
              <div class="title-sidebar-subblock">
                <p class="text-sidebar-subblock">Мы в соц сетях</p>
              </div>
              <div style="text-align: center">
                <a class="social-blog-links" href="https://www.facebook.com/Mulberry/">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/new-design/fb-opacity-icon.png">
                </a>
                <a class="social-blog-links" href="https://www.instagram.com/omnia_dg/">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/new-design/inst-opacity-icon.png">
                </a>
                <a class="social-blog-links" href="https://www.linkedin.com/company-beta/10793053/">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/new-design/in-opacity-icon.png">
                </a>
              </div>
            </div>

            <!--<div class="blog-small-banner">
              <img src="">
            </div>-->
          </div>

        </div>
      </div>
    </div>


		<div class="clear"></div>
		
		<?php /*portfolio_paging_nav(); */?>
	</div><!-- #primary -->
</div>
<?php get_footer(); ?>