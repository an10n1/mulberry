<?php 
$blogtime =  date_i18n( esc_html__( 'Y', 'unar' ) );

if ( current_user_can( 'edit_theme_options' ) ) {
	$footer_copyright  = get_theme_mod( 'unar_footer_copyright', sprintf(esc_html__( '&copy; Copyright %d. All Rights Reserved.', 'unar' ), $blogtime) );
} else {
	$footer_copyright  = get_theme_mod( 'unar_footer_copyright' );
}
$unar_theme = wp_get_theme(); 
?>
<footer id="footer" class="site-footer clearfix">
	<div class="footer-copyright">
		<div class="copyright">
			<span><?php echo unar_sanitize_html( $footer_copyright ); ?></span>
			<p class="copyright-footer text-center">
			<span data-customizer="copyright-credit"><a href="https://newsukraine.net" title="Последние новости и события дня в Украине и мире" target="_blank">Новости Украины</a> - <a href="<?php echo $unar_theme->get( 'ThemeURI' ); ?>" target="_blank"><?php echo $unar_theme->get( 'Name' ); ?></a></span>
			</p>
		</div>
	</div>
</footer><!-- #footer -->

</div>
<!-- #main-wrapper -->

<?php wp_footer(); ?>

</body>
</html>