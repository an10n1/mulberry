<?php
/**
 * Страница 404 ошибки (404.php)
 * @package WordPress
 * @subpackage Mulberry
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content container" role="main">
      <div class="row">
        <div class="col-md-12">
          <article id="post" <?php post_class(); ?>>
            <div>
              <header class="entry-header">
                <h1 class="entry-title"><span><?php _e('ERROR 404', 'portfolio'); ?></span></h1>
              </header>

              <div class="page-wrapper">
                <div class="page-content">
                  <h2><?php _e('This is somewhat embarrassing, isn&rsquo;t it?', 'portfolio'); ?></h2>
                  <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'portfolio'); ?></p>

			        <?php get_search_form(); ?>
                </div><!-- .page-content -->
              </div><!-- .page-wrapper -->
            </div>
          </article><!-- #post -->
        </div>
      </div>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>