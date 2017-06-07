<?php
	/*
		Template for the content meta
	*/
?>
<?php if(
	get_theme_mod('portfolio_post_show_date', '1') == '1' ||
	get_theme_mod('portfolio_post_show_category', '1') == '1'
) : ?>
<aside class="post-meta">
	<?php
		// Post Formats
		$post_format = '';?>

    <ul class="post-info">
      <?php if(get_post_format() != '') {
      echo '<li class="format gk-format-'. get_post_format(). '"></li>';
      } ?>

      <?php
        if ('post' == get_post_type()) {

            if(get_theme_mod('portfolio_post_show_date', '1') == '1') {
                $date_format = esc_html(get_the_date('M, j, Y'));

                if(get_theme_mod('portfolio_date_format', 'default') == 'wordpress') {
                    $date_format = get_the_date(get_option('date_format'));
                }

                $date = sprintf( '<li datetime="'. esc_attr(get_the_date('c')) . '">'. $date_format . $post_format .'</li>' );

                echo $date;
            }

            if(get_theme_mod('portfolio_post_show_category', '1') == '1') {
                // Translators: used between list items, there is a space after the comma.
                $categories_list = get_the_category_list(__( ', ', 'portfolio'));
                if ($categories_list) {
                    echo '<li class="post-categories"><img src="' . get_template_directory_uri() . '/img/new-design/category-icon.png">'  . __(' ', 'portfolio') . $categories_list . '</li>';
                }
            }
        }

        if(current_user_can('edit_posts') || current_user_can('edit_pages')) {
            edit_post_link(__('| Редактировать', 'portfolio'), '<li>', '</li>');
        }
      ?>

    </ul>

</aside><!-- .post-meta -->
<?php endif; ?>