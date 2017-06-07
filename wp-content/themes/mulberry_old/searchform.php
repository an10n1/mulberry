<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
<input type="search" class="field" name="s" value="<?php echo get_search_query(); ?>" id="s" placeholder="<?php esc_attr_e( 'Search this site', 'unar' ); ?>" />
<input type="submit" class="submit search-button" value="<?php esc_html_e( '&nbsp;', 'unar' ); ?>" />
</form>