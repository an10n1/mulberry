<?php
/**
 * Simple Masonry Gallery
 * 
 * @package    Simple Masonry Gallery
 * @subpackage SimpleMasonryAdmin Management screen
    Copyright (c) 2014- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; version 2 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class SimpleMasonryAdmin {

	/* ==================================================
	 * Add a "Settings" link to the plugins page
	 * @since	1.0
	 */
	function settings_link( $links, $file ) {
		static $this_plugin;
		if ( empty($this_plugin) ) {
			$this_plugin = SIMPLEMASONRY_PLUGIN_BASE_FILE;
		}
		if ( $file == $this_plugin ) {
			$links[] = '<a href="'.admin_url('options-general.php?page=simplemasonry').'">'.__( 'Settings').'</a>';
		}
			return $links;
	}

	/* ==================================================
	 * Settings page
	 * @since	1.0
	 */
	function plugin_menu() {
		add_options_page( 'Simple Masonry Gallery Options', 'Simple Masonry Gallery', 'manage_options', 'simplemasonry', array($this, 'plugin_options') );
	}

	/* ==================================================
	 * Settings page
	 * @since	1.0
	 */
	function plugin_options() {

		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		?>

		<div class="wrap">
		<h2>Simple Masonry Gallery</h2>
			<?php
			$screenshot_html = '<a href="'.__('https://wordpress.org/plugins/simple-masonry-gallery/screenshots/', 'simple-masonry-gallery').'" target="_blank" style="text-decoration: none; word-break: break-all;">'.__('Screenshots', 'simple-masonry-gallery').'</a>';
			$width_html = '<code>width</code>';
			$margin_html = '<code>margin</code>';
			$padding_html = '<code>padding</code>';
			$plugin_datas = get_file_data( SIMPLEMASONRY_PLUGIN_BASE_DIR.'/simplemasonry.php', array('version' => 'Version') );
			$plugin_version = __('Version:').' '.$plugin_datas['version'];
			?>
			<h4 style="margin: 5px; padding: 5px;">
			<?php echo $plugin_version; ?> |
			<a style="text-decoration: none;" href="https://wordpress.org/support/plugin/simple-masonry-gallery" target="_blank"><?php _e('Support Forums') ?></a> |
			<a style="text-decoration: none;" href="https://wordpress.org/support/view/plugin-reviews/simple-masonry-gallery" target="_blank"><?php _e('Reviews', 'simple-masonry-gallery') ?></a>
			</h4>
			<div style="width: 250px; height: 180px; margin: 5px; padding: 5px; border: #CCC 2px solid;">
			<h3><?php _e('Please make a donation if you like my work or would like to further the development of this plugin.', 'simple-masonry-gallery'); ?></h3>
			<div style="text-align: right; margin: 5px; padding: 5px;"><span style="padding: 3px; color: #ffffff; background-color: #008000">Plugin Author</span> <span style="font-weight: bold;">Katsushi Kawamori</span></div>
	<a style="margin: 5px; padding: 5px;" href='https://pledgie.com/campaigns/28307' target="_blank"><img alt='Click here to lend your support to: Various Plugins for WordPress and make a donation at pledgie.com !' src='https://pledgie.com/campaigns/28307.png?skin_name=chrome' border='0' ></a>
			</div>

			<hr>

			<h2 style="margin: 0px 10px;"><?php _e('Settings'); ?>(<?php echo $screenshot_html; ?>)</h2>
			<li style="margin: 0px 40px;">
			<h3><?php _e('Write a Shortcode. The following text field. Enclose image tags and gallery shortcode.', 'simple-masonry-gallery'); ?></h3>
			<h3><?php _e('example:'); ?></h3>
			<h3><code>&#91simplemasonrygallery&#93&lt;a href="http://blog3.localhost.localdomain/wp-content/uploads/sites/8/2017/01/f8e6a6a7.jpg"&gt;&lt;img src="http://blog3.localhost.localdomain/wp-content/uploads/sites/8/2017/01/f8e6a6a7.jpg" alt="" width="1000" height="626" class="alignnone size-full wp-image-275" /&gt;&lt;/a&gt;
&lt;a href="http://blog3.localhost.localdomain/wp-content/uploads/sites/8/2017/01/f878ff71.jpg"&gt;&lt;img src="http://blog3.localhost.localdomain/wp-content/uploads/sites/8/2017/01/f878ff71.jpg" alt="" width="1000" height="666" class="alignnone size-full wp-image-274" /&gt;&lt;/a&gt;&#91gallery size="full" ids="273,272,271,270"&#93&#91/simplemasonrygallery&#93</code></h3>
			</li>
			<li style="margin: 0px 40px;">
			<h3><?php _e('Write a Shortcode. The following template. Enclose image tags and gallery shortcode.', 'simple-masonry-gallery'); ?></h3>
			<h3><?php _e('example:'); ?></h3>
			<h3><code>&lt;?php echo do_shortcode('&#91simplemasonrygallery width=50&#93&#91gallery link="none" size="full" ids="271,270,269,268"&#93&#91/simplemasonrygallery&#93'); ?&gt;</code></h3>
			</h3>
			</li>
			<li style="margin: 0px 40px;">
			<h3><?php _e('"Simple Masonry Gallery" activation, you to include additional buttons for Shortcode in the Text (HTML) mode of the WordPress editor.', 'simple-masonry-gallery'); ?>
			</h3>
			</li>
			<li style="margin: 0px 40px;">
			<h3><?php _e('Within the Shortcode, it is possible to describe multiple galleries and multiple media.', 'simple-masonry-gallery'); ?>
			</h3>
			</li>
			<li style="margin: 0px 40px;">
			<h3><?php _e('The shortcode attributes are as follows.', 'simple-masonry-gallery'); ?>
			<h3><?php echo sprintf(__('%1$s : Specify the column width.', 'simple-masonry-gallery'), $width_html); ?></h3>
			<h3 style="padding: 0px 40px;"><?php echo sprintf(__('If not specified, the default value is applied. The default value is %1$d(px).', 'simple-masonry-gallery'), 100); ?></h3>
			<h3><?php echo sprintf(__('%1$s : Specify the margin between images.', 'simple-masonry-gallery'), $margin_html); ?></h3>
			<h3 style="padding: 0px 40px;"><?php echo sprintf(__('If not specified, the default value is applied. The default value is %1$d(px).', 'simple-masonry-gallery'), 1); ?></h3>
			<h3><?php echo sprintf(__('%1$s : Specify the padding between images.', 'simple-masonry-gallery'), $padding_html); ?></h3>
			<h3 style="padding: 0px 40px;"><?php echo sprintf(__('If not specified, the default value is applied. The default value is %1$d(px).', 'simple-masonry-gallery'), 1); ?></h3>
			<h3><?php _e('You can specify it like CSS.', 'simple-masonry-gallery'); ?></h3>
			<h3><?php _e('example:'); ?></h3>
			<h3><code>&#91simplemasonrygallery width=50 margin=2 padding=2&#93&#91gallery link="none" size="full" ids="271,270,269,268"&#93&#91/simplemasonrygallery&#93</code></h3>
			<h3><code>&#91simplemasonrygallery width=150 margin="2px 1px 3px 0" padding="0 1px 0"&#93&#91gallery link="none" size="full" ids="271,270,269,268"&#93&#91/simplemasonrygallery&#93</code></h3>
			</li>
		</div>

		<?php
	}

	/* ==================================================
	 * Add Quick Tag
	 * @since	5.02
	 */
	function simplemasonry_add_quicktags() {
		if (wp_script_is('quicktags')){
	?>
		<script type="text/javascript">
			QTags.addButton( 'simplemasonrygallery', 'simplemasonrygallery', '[simplemasonrygallery]', '[/simplemasonrygallery]' );
		</script>
	<?php
		}
	}

}

?>