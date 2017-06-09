<?php

/*
Template Name: Contacts
*/

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mulberry
 */

get_header(); ?>

<?php $options = get_option('sample_theme_options'); ?>

  <div id="primary" class="content-area l-contact">
    <div id="content" class="site-content container" role="main">
		<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' / '); ?>

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;

		?>
    </div><!-- #content -->
    
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <p>Адрес: <?= $options['addresstext']?></p>
          <p>Телефон:
            <span><?= $options['phonetext1']?></span><br>
            <span><?= $options['phonetext2']?></span><br>
            <span><?= $options['phonetext3']?></span>
          </p>
          <p>График работы: ПН-ВС 8:00-19:00</p>
          <p>Email: <a href="mailto:<?= $options['emailtext']?>"> <?= $options['emailtext']?></a></p>
        </div>
        <div class="col-md-6">
          <p>Форма обратной связи</p>
          <form role="form">
            <div class="form-group">
              <label for="name"><sub>*</sub>Ваше имя</label>
              <input type="text" class="form-control" id="name">
            </div>
            <div class="form-group">
              <label for="phone">Телефон</label>
              <input type="number" class="form-control" id="phone">
            </div>
            <div class="form-group">
              <label for="email"><sub>*</sub>Email</label>
              <input type="email" class="form-control" id="email">
            </div>
            <div class="form-group">
              <label for="msg"><sub>*</sub>Email</label>
              <textarea class="form-control" rows="3" id="msg"></textarea>
            </div>

            <button type="submit" class="btn btn-default">Отправить</button>
          </form>
        </div>
      </div>
    </div>
  </div><!-- #primary -->

  <div id="G_map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2677.6095892800126!2d35.10478881589258!3d47.84715627932188!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40dc66d5574bc109%3A0x844fd7c310a2b6d0!2z0LLRg9C70LjRhtGPINCf0LXRgNC10LzQvtCz0LgsIDIzLCDQl9Cw0L_QvtGA0ZbQttC20Y8sINCX0LDQv9C-0YDRltC30YzQutCwINC-0LHQu9Cw0YHRgtGM!5e0!3m2!1sru!2sua!4v1497000833147"
            width="100%"
            height="600"
            frameborder="0"
            style="border:0"
            allowfullscreen></iframe>
  </div>

<?php
get_footer();
