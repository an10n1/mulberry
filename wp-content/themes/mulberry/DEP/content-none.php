<?php
/**
 * The template for displaying a "No posts found" message
 */
?>

<header class="page-header">
	<h1 class="page-title"><?php _e('Нет новых новостей!', 'portfolio'); ?></h1>
</header>

<!--<div class="page-content">
	<?php if (is_home() && current_user_can('publish_posts')) : ?>

	<p><?php printf(__(' ', 'portfolio' ), admin_url( 'post-new.php')); ?></p>

	<?php elseif (is_search()) : ?>

	<p><?php _e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'portfolio'); ?></p>
	<?php get_search_form(); ?>

	<?php else : ?>

	<p><?php _e('Прошу воспользоваться поиском.', 'portfolio'); ?></p>
	<?php get_search_form(); ?>

	<?php endif; ?>-->
</div><!-- .page-content -->
