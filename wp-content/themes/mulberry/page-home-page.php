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
/*
	  $page_data = get_page_by_path( 'home-slider' );
	  $page_id   = $page_data->ID;
	  echo apply_filters( 'the_content', $page_data->post_content );

	  */?>
  </section>

  <section class="globalInfo">
    <div class="container">
      <div class="row">

        <div class="col-md-4">
          <div class="globalInfo-item">
            <img src="" alt="globalInfo">
            <p class="globalInfo-item--title">Бесплатная доставка</p>
            <p>на все заказы более чем 1000грн</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="globalInfo-item">
            <img src="" alt="globalInfo">
            <p class="globalInfo-item--title">Гарантия</p>
            <p>14 дней на всю нашу продукцию</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="globalInfo-item without-border">
            <img src="" alt="globalInfo">
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
        <div class="col-md-12">
	        <?php

	        $page_data = get_page_by_path( 'service' );
	        $page_id   = $page_data->ID;
	        echo '<h3>' . $page_data->post_title . '</h3>';
	        echo apply_filters( 'the_content', $page_data->post_content );


	        ?>
        </div>
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

          <a href="/about">Читать подробнее</a>
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
