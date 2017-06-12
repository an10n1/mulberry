<?php

/*
Template Name: Home
*/
/**
 * @package Mulberry
 */

get_header(); ?>

<div class="l-index">
  <section class="slider">
	  <?php

	  $page_data = get_page_by_path( 'home-slider' );
	  $page_id   = $page_data->ID;
	  echo apply_filters( 'the_content', $page_data->post_content );

	  ?>
  </section>

  <section class="globalInfo">
    <div class="container">
      <div class="row">

        <div class="col-sm-4">
          <div class="globalInfo-item">
            <img src="<?php echo get_template_directory_uri(); ?>/img/icons/home-i1.png" alt="globalInfo" />
            <p class="globalInfo-item--title">Бесплатная доставка</p>
            <p>на все заказы более чем 1000грн</p>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="globalInfo-item">
            <img src="<?php echo get_template_directory_uri(); ?>/img/icons/home-i2.png" alt="globalInfo" />
            <p class="globalInfo-item--title">Гарантия</p>
            <p>14 дней на всю нашу продукцию</p>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="globalInfo-item without-border">
            <img src="<?php echo get_template_directory_uri(); ?>/img/icons/home-i3.png" alt="globalInfo" />
            <p class="globalInfo-item--title">Персональный подход</p>
            <p>изготовленно более 500 заказов</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <section class="service">
    <div class="container">
      <div class="row">
	        <?php
          $idObj = get_category_by_slug('service');
          $id = $idObj->term_id;

          $posts = get_posts ("category=" . $id . "&orderby=date&numberposts=6");

	        if ($posts) : ?>
		        <?php foreach ($posts as $post) : setup_postdata ($post); ?>

              <div class="col-md-4 col-sm-6">
                <div class="jumbotron">
                  <h4><?php the_title(); ?></h4>
                  <?php
                    if (class_exists('MultiPostThumbnails')) :
                          MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'secondary-image');
                      endif;
                   ?>
                  <p><?php
	                  $mykey_values = get_post_custom_values( 'Service-short-description' );
	                  if($mykey_values){
	                    foreach ( $mykey_values as $key => $value ) {
		                    echo "$value";
	                    }
                    }else{
	                    echo '&nbsp;';
                    }?></p>
                </div>
              </div>

			        <?php
		        endforeach;
		        wp_reset_postdata();
		        ?>
	        <?php endif; ?>
        <a href="/service" class="service-more">Смотреть все услуги</a>
      </div>
    </div>
  </section>

  <section class="aboutPreview">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <?php

            $about_page_data = get_page_by_path( 'about' );
            $about_page_id   = $about_page_data->ID;
            $about_page_content = apply_filters( 'the_content', $about_page_data->post_content );
            $about_parts = get_extended( $about_page_content );

            echo '<h3>' . $about_page_data->post_title . '</h3>';
            echo $about_parts['main'];

          ?>

          <a href="/about" class="aboutPreview-more">Читать подробнее</a>
        </div>
        <div class="col-md-6">
	        <?php echo get_the_post_thumbnail( $about_page_id, 'large'); ?>
        </div>
      </div>
    </div>
  </section>

  <section class="confidence">
    <div class="container">
      <div class="col-md-12">
        <h3>Нам доверяют</h3>
	      <?php

	      $page_data = get_page_by_path( 'home' );
	      $page_id   = $page_data->ID;
	      echo apply_filters( 'the_content', $page_data->post_content );

	      ?>
      </div>
    </div>

  </section>
</div>

<?php
get_footer(); ?>
