<?php
/**
 * Simple Masonry Gallery
 * 
 * @package    Simple Masonry Gallery
 * @subpackage SimpleMasonry Main Functions
/*  Copyright (c) 2014- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
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

class SimpleMasonry {

	public $simplemasonry_count;
	public $simplemasonry_atts;

	/* ==================================================
	* @param	string	$content
	* @param	string	$simplemasonry_id
	* @param	array	$atts
	* @return	string	$content
	* @since	1.0
	*/
	function add_img_tag($content, $simplemasonry_id) {

		remove_shortcode('gallery', 'gallery_shortcode');
		add_shortcode('gallery', array($this, 'simplemasonry_gallery_shortcode'));
		$gallery_code = NULL;
		$pattern_gallery = '/\[' . preg_quote('gallery ') . '[^\]]*\]/im';
		if ( !empty($content) && preg_match($pattern_gallery, $content) ) {
			preg_match_all($pattern_gallery, $content, $retgallery);
			foreach ( $retgallery as $ret=>$gals ) {
				foreach ( $gals as $gal ) {
					$gallery_code = do_shortcode($gal);
					$content = str_replace( $gal, $gallery_code, $content );
				}
			}
		}
		remove_shortcode('gallery', array($this, 'simplemasonry_gallery_shortcode'));
		add_shortcode('gallery', 'gallery_shortcode');

		$allowed_html = array(
			'a' => array(
				'href' => array (),
				'target' => array()
				),
			'img' => array()
		);
		wp_kses($content, $allowed_html);

		$content = str_replace('<br />', '', $content);
		$content = str_replace('<br>', '', $content);
		$content = str_replace('<p>', '', $content);
		$content = str_replace('</p>', '', $content);

		$img_code = NULL;
		if(preg_match_all("/<img(.+?)>/mis", $content, $result) !== false){
			if ( count($result[0]) > 0 ) {
		    	foreach ($result[0] as $value){
					$img_code = '<div class="simplemasonry-item-'.$simplemasonry_id.'">'.$value.'</div>';
					if ( !strpos($content, $img_code) ) {
						$content = str_replace($value, $img_code, $content);
					}
				}
			}
		}

		$content = '<div id="simplemasonry-container-'.$simplemasonry_id.'">'.$content.'</div>';

		return $content;

	}

	/**
	 * The Gallery shortcode.
	 *
	 * This implements the functionality of the Gallery Shortcode for displaying
	 * WordPress images on a post.
	 *
	 * @since 2.5.0
	 *
	 * @param array $attr {
	 *     Attributes of the gallery shortcode.
	 *
	 *     @type string $order      Order of the images in the gallery. Default 'ASC'. Accepts 'ASC', 'DESC'.
	 *     @type string $orderby    The field to use when ordering the images. Default 'menu_order ID'.
	 *                              Accepts any valid SQL ORDERBY statement.
	 *     @type int    $id         Post ID.
	 *     @type string $itemtag    HTML tag to use for each image in the gallery.
	 *                              Default 'dl', or 'figure' when the theme registers HTML5 gallery support.
	 *     @type string $icontag    HTML tag to use for each image's icon.
	 *                              Default 'dt', or 'div' when the theme registers HTML5 gallery support.
	 *     @type string $captiontag HTML tag to use for each image's caption.
	 *                              Default 'dd', or 'figcaption' when the theme registers HTML5 gallery support.
	 *     @type int    $columns    Number of columns of images to display. Default 3.
	 *     @type string $size       Size of the images to display. Default 'thumbnail'.
	 *     @type string $ids        A comma-separated list of IDs of attachments to display. Default empty.
	 *     @type string $include    A comma-separated list of IDs of attachments to include. Default empty.
	 *     @type string $exclude    A comma-separated list of IDs of attachments to exclude. Default empty.
	 *     @type string $link       What to link each image to. Default empty (links to the attachment page).
	 *                              Accepts 'file', 'none'.
	 * }
	 * @return string HTML content to display gallery.
	 */
	function simplemasonry_gallery_shortcode( $attr ) {

		$post = get_post();

		static $instance = 0;
		$instance++;

		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) )
				$attr['orderby'] = 'post__in';
			$attr['include'] = $attr['ids'];
		}

		/**
		 * Filter the default gallery shortcode output.
		 *
		 * If the filtered output isn't empty, it will be used instead of generating
		 * the default gallery template.
		 *
		 * @since 2.5.0
		 *
		 * @see gallery_shortcode()
		 *
		 * @param string $output The gallery output. Default empty.
		 * @param array  $attr   Attributes of the gallery shortcode.
		 */
		$output = apply_filters( 'post_gallery', '', $attr );
		if ( $output != '' )
			return $output;

		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] )
				unset( $attr['orderby'] );
		}

		$html5 = current_theme_supports( 'html5', 'gallery' );

		extract(shortcode_atts(array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post ? $post->ID : 0,
			'itemtag'    => $html5 ? 'figure'     : 'dl',
			'icontag'    => $html5 ? 'div'        : 'dt',
			'captiontag' => $html5 ? 'figcaption' : 'dd',
			'columns'    => 3,
			'size'       => 'full',
			'include'    => '',
			'exclude'    => '',
			'link'       => 'file'
		), $attr, 'gallery'));

		$id = intval($id);
		if ( 'RAND' == $order )
			$orderby = 'none';

		if ( !empty($include) ) {
			$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( !empty($exclude) ) {
			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		} else {
			$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}

		if ( empty($attachments) )
			return '';

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
			return $output;
		}

		$output = NULL;

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			if ( ! empty( $link ) && 'file' === $link )
				$image_output = wp_get_attachment_link( $id, $size, false, false );
			elseif ( ! empty( $link ) && 'none' === $link )
				$image_output = wp_get_attachment_image( $id, $size, false );
			else
				$image_output = wp_get_attachment_link( $id, $size, true, false );

			$image_meta  = wp_get_attachment_metadata( $id );

			$orientation = '';
			if ( isset( $image_meta['height'], $image_meta['width'] ) )
				$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

			$output .= $image_output;
		}

		return $output;

	}

	/* ==================================================
	* Load Script
	* @param	none
	* @since	5.11
	*/
	function load_frontend_scripts(){

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-masonry');

	}

	/* ==================================================
	* Load Localize Script and Style
	* @param	none
	* @since	6.00
	*/
	function load_localize_scripts_styles() {

		$localize_masonry_settings = array();
		wp_enqueue_script( 'simple-masonry-jquery', SIMPLEMASONRY_PLUGIN_URL.'/js/jquery.simplemasonry.js',array('jquery'));
		foreach($this->simplemasonry_atts as $key => $value) {
			// Script
			$localize_masonry_settings = array_merge($localize_masonry_settings, $value);
			// Style
			$width = $value['width'.$key];
			if ( !strpos($width, 'px') ) { $width = $width.'px'; }
			$margin = $this->margin_padding_replace( $value['margin'.$key] );
			$padding =  $this->margin_padding_replace( $value['padding'.$key] );
			$simplemasonry_id = $value['id'.$key];
			wp_enqueue_style( 'simple-masonry'.$simplemasonry_id,  SIMPLEMASONRY_PLUGIN_URL.'/css/simplemasonry.css' );
			$css = 	"#simplemasonry-container-".$simplemasonry_id."{ margin: 0 auto; padding: 0; }
					.simplemasonry-item-".$simplemasonry_id." { width: ".$width."; float: left; margin: ".$margin."; padding: ".$padding."; }
					.simplemasonry-item-".$simplemasonry_id." img{width:100%; max-width:100%; height:auto; margin:0;}";
			wp_add_inline_style( 'simple-masonry'.$simplemasonry_id, $css );
		}

		// Script
		$maxcount = array( 'maxcount' => $this->simplemasonry_count );
		$localize_masonry_settings = array_merge($localize_masonry_settings, $maxcount);
		wp_localize_script( 'simple-masonry-jquery', 'masonry_settings', $localize_masonry_settings );

	}

	/* ==================================================
	 * css margin padding replace
	 * @param	String	$str
	 * @return	String	$replace_str
	 * @since	6.04
	 */
	function margin_padding_replace( $str ) {

		$replace_str = NULL;
		$keywords = preg_split('/[\s]+/', $str, -1, PREG_SPLIT_NO_EMPTY);
		if ( $keywords ) {
			foreach( $keywords as $val ){
				if ( !strpos($val, 'px') && $val <> 0 ) { $val = $val.'px'; }
				$replace_str .= $val.' ';
			}
			$replace_str = rtrim($replace_str, ' ');
		} else {
			if ( !strpos($str, 'px') && $str <> 0 ) { $str = $str.'px'; }
			$replace_str = $str;
		}

		return $replace_str;

	}

	/* ==================================================
	 * Short code
	 * @param	Array	$atts
	 * @param	String	$content
	 * @return	String	$content
	 * @since	5.00
	 */
	function simplemasonrygallery_func( $atts, $content = NULL ) {

		extract(shortcode_atts(array(
			'width' => '',
			'margin' => '',
			'padding' => ''
		), $atts));
		if ( empty($atts['width']) ) {
			$atts['width'] = 100;
		}
		if ( !isset($atts['margin']) ) {
			$atts['margin'] = '1px';
		}
		if ( !isset($atts['padding']) ) {
			$atts['padding'] = '1px';
		}

		++$this->simplemasonry_count;
		$simplemasonry_id = get_the_ID().'-'.$this->simplemasonry_count;

		$content = $this->add_img_tag($content, $simplemasonry_id);

		$new_atts = array();
		foreach ( $atts as $key => $value ) {
			$new_atts[$key.$this->simplemasonry_count] = $value;
		}
		$id_count_tbl = array( 'id'.$this->simplemasonry_count => $simplemasonry_id );
		$this->simplemasonry_atts[$this->simplemasonry_count] = array_merge($new_atts, $id_count_tbl);

		return do_shortcode($content);

	}

}

?>