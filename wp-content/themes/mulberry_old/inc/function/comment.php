<?php if ( ! function_exists( 'unar_comment' ) ) :

function unar_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
	default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="clearfix">
				<div class="avatar">
					<?php echo get_avatar( $comment, 50 ); ?>
				</div><!-- avatar -->
                
			</header>

			<div class="comment-content">
			<div class="meta-comment">
                <div class="comment-meta">
                <?php printf( __( '%s', 'unar' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
                <time datetime="<?php comment_time( 'c' ); ?>">
					<?php esc_html_e( ' - Posted ', 'unar' ); ?><?php printf( _x( '%1$s', '1: date', 'unar' ), get_comment_date()); ?>
				</time>
                </div><!-- .comment-author .vcard -->
                
				<?php if ( $comment->comment_approved == '0' ) : ?>
                	<div class="waiting-moderation">
					<em><?php esc_html_e( 'Your comment is awaiting moderation.', 'unar' ); ?></em>
					</div>
				<?php endif; ?>

                <div class="comment-action">
            	<span class="edit-comment-link"><?php edit_comment_link( esc_html__( 'Edit', 'unar' ), '<span class="edit-link">', '<span>' ); ?></span>
                
            	<span class="reply-container"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
                <span class="reply-icon"></span>
			</div><!-- .comment-action -->

                 </div><!-- meta comment -->

                 <?php comment_text(); ?>

                 </div>

			
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif;
