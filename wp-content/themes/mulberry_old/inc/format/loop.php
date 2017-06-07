<article <?php post_class( 'post hentry wow fadeIn'); ?> data-wow-duration="2s" data-wow-delay="0.1s" data-wow-duration="2s" data-wow-delay="0.1s" itemprop="blogPost" itemscope="itemscope" itemtype="http://schema.org/BlogPosting">
<meta itemscope="" itemprop="mainEntityOfPage" itemtype="https://schema.org/WebPage" itemid="https://google.com/article">

<?php
$logo_id    = get_theme_mod( 'custom_logo' );
$logo_image = wp_get_attachment_image_src( $logo_id, 'full' );
?>
<div itemprop="publisher" itemscope="" itemtype="https://schema.org/Organization">
	<meta itemprop="name" content="<?php $unar_theme = wp_get_theme(); echo $unar_theme->get( 'Name' ); ?>">
	<?php if ( ! empty( $logo_image ) ) { 

	$logo_meta = wp_get_attachment_metadata( $logo_id );
  	$logo_width = $logo_meta["width"];
 	$logo_height = $logo_meta["height"]; ?>
	<div itemprop="logo" itemscope="" itemtype="https://schema.org/ImageObject">
		<meta itemprop="url" content="<?php echo esc_url( $logo_image[0] ); ?>">
        <?php echo '<meta itemprop="width" content="'.$logo_width.'"><meta itemprop="height" content="'.$logo_height.'">'; ?>
	</div>
	<?php } ?>
</div>

		<?php if ( has_post_thumbnail()) {
			$real_image = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src( $real_image, 'full'); 
			$image_meta = wp_get_attachment_metadata( $real_image );
			$image_width = $image_meta["width"];
			$image_height = $image_meta["height"];
		?>
		<div class="entry-media">

			<div class="post-thumb" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<img class="singleimg" src="<?php echo esc_url($image_url[0]) ?>">
				<meta itemprop="url" content="<?php echo esc_url( $image_url[0] ); ?>">
				<?php echo '<meta itemprop="width" content="'.$image_width.'"><meta itemprop="height" content="'.$image_height.'">'; ?>
			</a>
			</div><!-- post thumb -->
	
		</div><!-- end entry-media -->
		<?php } ?>


		
	<div class="post-content">
		
		<div class="post-date metadata">
		<time class="entry-date" datetime="<?php the_modified_date('Y-m-j'); ?>" itemprop="dateModified">
			<span class="date-number"><?php echo get_the_date('j'); ?></span>
			<span class="date-month"><?php echo get_the_date('M Y'); ?></span>
			<meta itemprop="datePublished" content="<?php echo get_the_date(); ?>">
		</time>
		</div>

		<h2 class="post-title entry-title" itemprop="headline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="bord"></div>

		<?php esc_html_e( 'By ', 'unar' ); ?>
		<span itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
			<span class="author vcard" itemprop="name">
				<?php echo get_the_author_meta( 'display_name' ); ?>
			</span>
		</span>
		<?php esc_html_e( '/ In ', 'unar' ); ?><?php the_category(', '); ?><?php esc_html_e( ' / ', 'unar' ); ?>

		<span class="comment-number">  <?php esc_html_e( 'Comments ', 'unar' ); ?> <?php comments_number( '0', '1', '%' ); ?></span>
			<div class="post-entry entry-content" itemprop="text">
				<?php the_excerpt(); ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="btn read-more"><?php esc_html_e( 'Read More ', 'unar' ); ?><i class="fa fa-arrow-right"></i></a>
			</div>

			
	</div><!-- post-content -->
</article><!-- .post-<?php the_ID(); ?> -->