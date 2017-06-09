<?php
/**
 *
 * Portfolio functions and definitions
 *
 */

// loading the necessary elements
get_template_part( 'comments', 'template' );
get_template_part( 'theme', 'customizer' );
show_admin_bar( false );
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');

require_once ( get_stylesheet_directory() . '/theme-options.php' );

add_theme_support('post-thumbnails');

/**
 *
 * Functions used to generate post excerpt
 *
 * @return HTML output
 *
 **/

/**
 * Хлебные крошки для WordPress (breadcrumbs)
 *
 * @param  string [$sep  = '']      Разделитель. По умолчанию ' » '
 * @param  array  [$l10n = array()] Для локализации. См. переменную $default_l10n.
 * @param  array  [$args = array()] Опции. См. переменную $def_args
 * @return string Выводит на экран HTML код
 *
 * version 3.3.1
 */
function kama_breadcrumbs( $sep = ' » ', $l10n = array(), $args = array() ){
	$kb = new Kama_Breadcrumbs;
	echo $kb->get_crumbs( $sep, $l10n, $args );
}

class Kama_Breadcrumbs {

	public $arg;

	// Локализация
	static $l10n = array(
		'home'       => 'Главная',
		'paged'      => 'Страница %d',
		'_404'       => 'Ошибка 404',
		'search'     => 'Результаты поиска по запросу - <b>%s</b>',
		'author'     => 'Архив автора: <b>%s</b>',
		'year'       => 'Архив за <b>%d</b> год',
		'month'      => 'Архив за: <b>%s</b>',
		'day'        => '',
		'attachment' => 'Медиа: %s',
		'tag'        => 'Записи по метке: <b>%s</b>',
		'tax_tag'    => '%1$s из "%2$s" по тегу: <b>%3$s</b>',
		// tax_tag выведет: 'тип_записи из "название_таксы" по тегу: имя_термина'.
		// Если нужны отдельные холдеры, например только имя термина, пишем так: 'записи по тегу: %3$s'
	);

	// Параметры по умолчанию
	static $args = array(
		'on_front_page'   => true,  // выводить крошки на главной странице
		'show_post_title' => true,  // показывать ли название записи в конце (последний элемент). Для записей, страниц, вложений
		'show_term_title' => true,  // показывать ли название элемента таксономии в конце (последний элемент). Для меток, рубрик и других такс
		'title_patt'      => '<span class="kb_title">%s</span>', // шаблон для последнего заголовка. Если включено: show_post_title или show_term_title
		'last_sep'        => true,  // показывать последний разделитель, когда заголовок в конце не отображается
		'markup'          => 'schema.org', // 'markup' - микроразметка. Может быть: 'rdf.data-vocabulary.org', 'schema.org', '' - без микроразметки
		// или можно указать свой массив разметки:
		// array( 'wrappatt'=>'<div class="kama_breadcrumbs">%s</div>', 'linkpatt'=>'<a href="%s">%s</a>', 'sep_after'=>'', )
		'priority_tax'    => array('category'), // приоритетные таксономии, нужно когда запись в нескольких таксах
		'priority_terms'  => array(), // 'priority_terms' - приоритетные элементы таксономий, когда запись находится в нескольких элементах одной таксы одновременно.
		// Например: array( 'category'=>array(45,'term_name'), 'tax_name'=>array(1,2,'name') )
		// 'category' - такса для которой указываются приор. элементы: 45 - ID термина и 'term_name' - ярлык.
		// порядок 45 и 'term_name' имеет значение: чем раньше тем важнее. Все указанные термины важнее неуказанных...
		'nofollow' => false, // добавлять rel=nofollow к ссылкам?

		// служебные
		'sep'             => '',
		'linkpatt'        => '',
		'pg_end'          => '',
	);

	function get_crumbs( $sep, $l10n, $args ){
		global $post, $wp_query, $wp_post_types;

		self::$args['sep'] = $sep;

		// Фильтрует дефолты и сливает
		$loc = (object) array_merge( apply_filters('kama_breadcrumbs_default_loc', self::$l10n ), $l10n );
		$arg = (object) array_merge( apply_filters('kama_breadcrumbs_default_args', self::$args ), $args );

		$arg->sep = '<span class="kb_sep">'. $arg->sep .'</span>'; // дополним

		// упростим
		$sep = & $arg->sep;
		$this->arg = & $arg;

		// микроразметка ---
		if(1){
			$mark = & $arg->markup;

			// Разметка по умолчанию
			if( ! $mark ) $mark = array(
				'wrappatt'  => '<div class="kama_breadcrumbs">%s</div>',
				'linkpatt'  => '<a href="%s">%s</a>',
				'sep_after' => '',
			);
			// rdf
            elseif( $mark === 'rdf.data-vocabulary.org' ) $mark = array(
				'wrappatt'   => '<div class="kama_breadcrumbs" prefix="v: http://rdf.data-vocabulary.org/#">%s</div>',
				'linkpatt'   => '<span typeof="v:Breadcrumb"><a href="%s" rel="v:url" property="v:title">%s</a>',
				'sep_after'  => '</span>', // закрываем span после разделителя!
			);
			// schema.org
            elseif( $mark === 'schema.org' ) $mark = array(
				'wrappatt'   => '<div class="kama_breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">%s</div>',
				'linkpatt'   => '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="%s" itemprop="item"><span itemprop="name">%s</span></a></span>',
				'sep_after'  => '',
			);

            elseif( ! is_array($mark) )
				die( __CLASS__ .': "markup" parameter must be array...');

			$wrappatt  = $mark['wrappatt'];
			$arg->linkpatt  = $arg->nofollow ? str_replace('<a ','<a rel="nofollow"', $mark['linkpatt']) : $mark['linkpatt'];
			$arg->sep      .= $mark['sep_after']."\n";
		}

		$linkpatt = $arg->linkpatt; // упростим

		$q_obj = get_queried_object();

		// может это архив пустой таксы?
		$ptype = null;
		if( empty($post) ){
			if( isset($q_obj->taxonomy) )
				$ptype = & $wp_post_types[ get_taxonomy($q_obj->taxonomy)->object_type[0] ];
		}
		else $ptype = & $wp_post_types[ $post->post_type ];

		// paged
		$arg->pg_end = '';
		if( ($paged_num = get_query_var('paged')) || ($paged_num = get_query_var('page')) )
			$arg->pg_end = $sep . sprintf( $loc->paged, (int) $paged_num );

		$pg_end = $arg->pg_end; // упростим

		// ну, с богом...
		$out = '';

		if( is_front_page() ){
			return $arg->on_front_page ? sprintf( $wrappatt, ( $paged_num ? sprintf($linkpatt, get_home_url(), $loc->home) . $pg_end : $loc->home ) ) : '';
		}
		// страница записей, когда для главной установлена отдельная страница.
        elseif( is_home() ) {
			$out = $paged_num ? ( sprintf( $linkpatt, get_permalink($q_obj), esc_html($q_obj->post_title) ) . $pg_end ) : esc_html($q_obj->post_title);
		}
        elseif( is_404() ){
			$out = $loc->_404;
		}
        elseif( is_search() ){
			$out = sprintf( $loc->search, esc_html( $GLOBALS['s'] ) );
		}
        elseif( is_author() ){
			$tit = sprintf( $loc->author, esc_html($q_obj->display_name) );
			$out = ( $paged_num ? sprintf( $linkpatt, get_author_posts_url( $q_obj->ID, $q_obj->user_nicename ) . $pg_end, $tit ) : $tit );
		}
        elseif( is_year() || is_month() || is_day() ){
			$y_url  = get_year_link( $year = get_the_time('Y') );

			if( is_year() ){
				$tit = sprintf( $loc->year, $year );
				$out = ( $paged_num ? sprintf($linkpatt, $y_url, $tit) . $pg_end : $tit );
			}
			// month day
			else {
				$y_link = sprintf( $linkpatt, $y_url, $year);
				$m_url  = get_month_link( $year, get_the_time('m') );

				if( is_month() ){
					$tit = sprintf( $loc->month, get_the_time('F') );
					$out = $y_link . $sep . ( $paged_num ? sprintf( $linkpatt, $m_url, $tit ) . $pg_end : $tit );
				}
                elseif( is_day() ){
					$m_link = sprintf( $linkpatt, $m_url, get_the_time('F'));
					$out = $y_link . $sep . $m_link . $sep . get_the_time('l');
				}
			}
		}
		// Древовидные записи
        elseif( is_singular() && $ptype->hierarchical ){
			$out = $this->_add_title( $this->_page_crumbs($post), $post );
		}
		// Таксы, плоские записи и вложения
		else {
			$term = $q_obj; // таксономии

			// определяем термин для записей (включая вложения attachments)
			if( is_singular() ){
				// изменим $post, чтобы определить термин родителя вложения
				if( is_attachment() && $post->post_parent ){
					$save_post = $post; // сохраним
					$post = get_post($post->post_parent);
				}

				// учитывает если вложения прикрепляются к таксам древовидным - все бывает :)
				$taxonomies = get_object_taxonomies( $post->post_type );
				// оставим только древовидные и публичные, мало ли...
				$taxonomies = array_intersect( $taxonomies, get_taxonomies( array('hierarchical' => true, 'public' => true) ) );

				if( $taxonomies ){
					// сортируем по приоритету
					if( ! empty($arg->priority_tax) ){
						usort( $taxonomies, function($a,$b)use($arg){
							$a_index = array_search($a, $arg->priority_tax);
							if( $a_index === false ) $a_index = 9999999;

							$b_index = array_search($b, $arg->priority_tax);
							if( $b_index === false ) $b_index = 9999999;

							return ( $b_index === $a_index ) ? 0 : ( $b_index < $a_index ? 1 : -1 ); // меньше индекс - выше
						} );
					}

					// пробуем получить термины, в порядке приоритета такс
					foreach( $taxonomies as $taxname ){
						if( $terms = get_the_terms( $post->ID, $taxname ) ){
							// проверим приоритетные термины для таксы
							$prior_terms = & $arg->priority_terms[ $taxname ];
							if( $prior_terms && count($terms) > 2 ){
								foreach( (array) $prior_terms as $term_id ){
									$filter_field = is_numeric($term_id) ? 'term_id' : 'slug';
									$_terms = wp_list_filter( $terms, array($filter_field=>$term_id) );

									if( $_terms ){
										$term = array_shift( $_terms );
										break;
									}
								}
							}
							else
								$term = array_shift( $terms );

							break;
						}
					}
				}

				if( isset($save_post) ) $post = $save_post; // вернем обратно (для вложений)
			}

			// вывод

			// все виды записей с терминами или термины
			if( $term && isset($term->term_id) ){
				$term = apply_filters('kama_breadcrumbs_term', $term );

				// attachment
				if( is_attachment() ){
					if( ! $post->post_parent )
						$out = sprintf( $loc->attachment, esc_html($post->post_title) );
					else {
						if( ! $out = apply_filters('attachment_tax_crumbs', '', $term, $this ) ){
							$_crumbs    = $this->_tax_crumbs( $term, 'self' );
							$parent_tit = sprintf( $linkpatt, get_permalink($post->post_parent), get_the_title($post->post_parent) );
							$_out = implode( $sep, array($_crumbs, $parent_tit) );
							$out = $this->_add_title( $_out, $post );
						}
					}
				}
				// single
                elseif( is_single() ){
					if( ! $out = apply_filters('post_tax_crumbs', '', $term, $this ) ){
						$_crumbs = $this->_tax_crumbs( $term, 'self' );
						$out = $this->_add_title( $_crumbs, $post );
					}
				}
				// не древовидная такса (метки)
                elseif( ! is_taxonomy_hierarchical($term->taxonomy) ){
					// метка
					if( is_tag() )
						$out = $this->_add_title('', $term, sprintf( $loc->tag, esc_html($term->name) ) );
					// такса
                    elseif( is_tax() ){
						$post_label = $ptype->labels->name;
						$tax_label = $GLOBALS['wp_taxonomies'][ $term->taxonomy ]->labels->name;
						$out = $this->_add_title('', $term, sprintf( $loc->tax_tag, $post_label, $tax_label, esc_html($term->name) ) );
					}
				}
				// древовидная такса (рибрики)
				else {
					if( ! $out = apply_filters('term_tax_crumbs', '', $term, $this ) ){
						$_crumbs = $this->_tax_crumbs( $term, 'parent' );
						$out = $this->_add_title( $_crumbs, $term, esc_html($term->name) );
					}
				}
			}
			// влоежния от записи без терминов
            elseif( is_attachment() ){
				$parent = get_post($post->post_parent);
				$parent_link = sprintf( $linkpatt, get_permalink($parent), esc_html($parent->post_title) );
				$_out = $parent_link;

				// вложение от записи древовидного типа записи
				if( is_post_type_hierarchical($parent->post_type) ){
					$parent_crumbs = $this->_page_crumbs($parent);
					$_out = implode( $sep, array( $parent_crumbs, $parent_link ) );
				}

				$out = $this->_add_title( $_out, $post );
			}
			// записи без терминов
            elseif( is_singular() ){
				$out = $this->_add_title( '', $post );
			}
		}

		// замена ссылки на архивную страницу для типа записи
		$home_after = apply_filters('kama_breadcrumbs_home_after', '', $linkpatt, $sep, $ptype );

		if( '' === $home_after ){
			// Ссылка на архивную страницу типа записи для: отдельных страниц этого типа; архивов этого типа; таксономий связанных с этим типом.
			if( $ptype && $ptype->has_archive && ! in_array( $ptype->name, array('post','page','attachment') )
			    && ( is_post_type_archive() || is_singular() || (is_tax() && in_array($term->taxonomy, $ptype->taxonomies)) )
			){
				$pt_title = $ptype->labels->name;

				// первая страница архива типа записи
				if( is_post_type_archive() && ! $paged_num )
					$home_after = $pt_title;
				// singular, paged post_type_archive, tax
				else{
					$home_after = sprintf( $linkpatt, get_post_type_archive_link($ptype->name), $pt_title );

					$home_after .= ( ($paged_num && ! is_tax()) ? $pg_end : $sep ); // пагинация
				}
			}
		}

		$before_out = sprintf( $linkpatt, home_url(), $loc->home ) . ( $home_after ? $sep.$home_after : ($out ? $sep : '') );

		$out = apply_filters('kama_breadcrumbs_pre_out', $out, $sep, $loc, $arg );

		$out = sprintf( $wrappatt, $before_out . $out );

		return apply_filters('kama_breadcrumbs', $out, $sep, $loc, $arg );
	}

	function _page_crumbs( $post ){
		$parent = $post->post_parent;

		$crumbs = array();
		while( $parent ){
			$page = get_post( $parent );
			$crumbs[] = sprintf( $this->arg->linkpatt, get_permalink($page), esc_html($page->post_title) );
			$parent = $page->post_parent;
		}

		return implode( $this->arg->sep, array_reverse($crumbs) );
	}

	function _tax_crumbs( $term, $start_from = 'self' ){
		$termlinks = array();
		$term_id = ($start_from === 'parent') ? $term->parent : $term->term_id;
		while( $term_id ){
			$term       = get_term( $term_id, $term->taxonomy );
			$termlinks[] = sprintf( $this->arg->linkpatt, get_term_link($term), esc_html($term->name) );
			$term_id    = $term->parent;
		}

		if( $termlinks )
			return implode( $this->arg->sep, array_reverse($termlinks) ) /*. $this->arg->sep*/;
		return '';
	}

	// добалвяет заголовок к переданному тексту, с учетом всех опций. Добавляет разделитель в начало, если надо.
	function _add_title( $add_to, $obj, $term_title = '' ){
		$arg = & $this->arg; // упростим...
		$title = $term_title ? $term_title : esc_html($obj->post_title); // $term_title чиститься отдельно, теги моугт быть...
		$show_title = $term_title ? $arg->show_term_title : $arg->show_post_title;

		// пагинация
		if( $arg->pg_end ){
			$link = $term_title ? get_term_link($obj) : get_permalink($obj);
			$add_to .= ($add_to ? $arg->sep : '') . sprintf( $arg->linkpatt, $link, $title ) . $arg->pg_end;
		}
		// дополняем - ставим sep
        elseif( $add_to ){
			if( $show_title )
				$add_to .= $arg->sep . sprintf( $arg->title_patt, $title );
            elseif( $arg->last_sep )
				$add_to .= $arg->sep;
		}
		// sep будет потом...
        elseif( $show_title )
			$add_to = sprintf( $arg->title_patt, $title );

		return $add_to;
	}

}

if (class_exists('MultiPostThumbnails')) {

	new MultiPostThumbnails(array(
		'label' => 'Secondary Image',
		'id' => 'secondary-image',
		'post_type' => 'post'
	) );

}

if(!function_exists('portfolio_excerpt')) {
	function portfolio_excerpt($text) {
	    return $text . '&hellip;';
	}
}

add_filter( 'get_the_excerpt', 'portfolio_excerpt', 999 );

if(!function_exists('portfolio_excerpt_more')) {
	function portfolio_excerpt_more($text) {
	    return '';
	}
}

add_filter( 'excerpt_more', 'portfolio_excerpt_more', 999 );

if(!function_exists('portfolio_custom_excerpt_length')) {
	function portfolio_custom_excerpt_length( $length ) {
		return get_theme_mod('portfolio_excerpt_length', 16);
	}
}

add_filter( 'excerpt_length', 'portfolio_custom_excerpt_length', 999 );

if(!function_exists('portfolio_setup')) {
	/**
	 * Portfolio setup.
	 *
	 * Sets up theme defaults and registers the various WordPress features
	 *
	 * @uses load_theme_textdomain() For translation/localization support.
	 * @uses add_theme_support() To add support for automatic feed links, post
	 * formats, and post thumbnails.
	 * @uses register_nav_menu() To add support for a navigation menu.
	 *
	 *
	 * @return void
	 */
	function portfolio_setup() {
		global $content_width;

		if ( ! isset( $content_width ) ) $content_width = get_theme_mod('portfolio_content_width', 700);

		/*
		 * Makes Portfolio available for translation.
		 *
		 */
		load_theme_textdomain( 'portfolio', get_template_directory() . '/languages' );

		// Adds RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Switches default core markup for search form, comment form,
		 * and comments to output valid HTML5.
		 */
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

		/**
		 * Add support for the title-tag
		 *
		 * @since Portfolio 1.4
		 */
		add_theme_support( 'title-tag' );

		/*
		 * This theme supports all available post formats by default.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support('post-formats', array(
			'gallery', 'image', 'link', 'quote', 'video'
		));

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menu('primary', __('Navigation Menu', 'portfolio'));
		register_nav_menu('footer', __('Social Menu', 'portfolio'));

		/*
		 * This theme uses a custom image size for featured images, displayed on
		 * "standard" posts and pages.
		 */
		add_theme_support('post-thumbnails');

		// Support for custom background
		$args = array(
			'default-color' => 'f1f1f1',
			'wp-head-callback' => 'portfolio_custom_background_callback'
		);
		add_theme_support('custom-background', $args);

		// This theme uses its own gallery styles.
		add_filter('use_default_gallery_style', '__return_false');
	}
}

add_action('after_setup_theme', 'portfolio_setup');

if(!function_exists('portfolio_custom_background_callback')) {
	/**
	 * Modify the custom background head code
	 *
	 * @return void
	 */

	function portfolio_custom_background_callback() {
	    $background = get_background_image();
	    $color = get_background_color();
	    if ( ! $background && ! $color )
	        return;

	    $style = $color ? "background-color: #$color;" : '';

	    if ($background) {
	        $image = " background-image: url('$background');";

	        $repeat = get_theme_mod('background_repeat', 'repeat');
	        if (!in_array($repeat, array('no-repeat', 'repeat-x', 'repeat-y', 'repeat'))) {
	            $repeat = 'repeat';
	        }
	        $repeat = " background-repeat: $repeat;";

	        $position = get_theme_mod('background_position_x', 'left');
	        if (!in_array($position, array( 'center', 'right', 'left'))) {
	            $position = 'left';
	        }
	        $position = " background-position: top $position;";

	        $attachment = get_theme_mod( 'background_attachment', 'scroll' );
	        if (!in_array($attachment, array( 'fixed', 'scroll' ))) {
	            $attachment = 'scroll';
	        }
	        $attachment = " background-attachment: $attachment;";

	        $style .= $image . $repeat . $position . $attachment;
	    }
	?>
	<style type="text/css">
	body.custom-background #main { <?php echo trim( $style ); ?> }
	</style>
	<?php
	}
}

if(!function_exists('portfolio_add_editor_styles')) {
	/**
	 * Enqueue scripts for the back-end.
	 *
	 * @return void
	 */
	function portfolio_add_editor_styles() {
	    add_editor_style(array('editor.css', 'css/font.awesome.css', 'https://fonts.googleapis.com/css?family=Open+Sans'));
	}
}

add_action('init', 'portfolio_add_editor_styles');

if(!function_exists('portfolio_scripts')) {
	/**
	 * Enqueue scripts for the front end.
	 *
	 * @return void
	 */
	function portfolio_scripts() {
		/*
		 * Adds JavaScript to pages with the comment form to support
		 * sites with threaded comments (when in use).
		 */
		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Loads JavaScript file with functionality specific to Portfolio.
		wp_enqueue_script('portfolio-script', get_template_directory_uri() . '/js/functions.js', array('jquery'), '', true);

		// Loads JavaScript file for responsive video.
		//wp_enqueue_script('portfolio-video', get_template_directory_uri() . '/js/jquery.fitvids.js', false, false, true);
	}
}

add_action('wp_enqueue_scripts', 'portfolio_scripts');

if(!function_exists('portfolio_styles')) {
	/**
	 * Enqueue styles for the front end.
	 *
	 * @return void
	 */
	function portfolio_styles() {
		// Add normalize stylesheet.
		wp_enqueue_style('portfolio-normalize', get_template_directory_uri() . '/css/normalize.css', false);

		// Add Google font from the customizer
		wp_enqueue_style('portfolio-fonts', get_theme_mod('portfolio_google_font', 'http://fonts.googleapis.com/css?family=Open+Sans:700'), false);

		if(get_theme_mod('portfolio_google_font', 'http://fonts.googleapis.com/css?family=Open+Sans:700') != get_theme_mod('portfolio_body_google_font', 'http://fonts.googleapis.com/css?family=Open+Sans:400')) {
			wp_enqueue_style('portfolio-fonts-body', get_theme_mod('portfolio_body_google_font', 'http://fonts.googleapis.com/css?family=Open+Sans:400'), false);
		}

		// Font Awesome
		wp_enqueue_style('portfolio-font-awesome', get_template_directory_uri() . '/css/font.awesome.css', false, '4.0.3');

		// Loads our main stylesheet.
		wp_enqueue_style('portfolio-style', get_stylesheet_uri());

		// Loads the Internet Explorer specific stylesheet.
		wp_enqueue_style('portfolio-ie8', get_template_directory_uri() . '/css/ie8.css', array('portfolio-style'));
		wp_style_add_data('portfolio-ie8', 'conditional', 'lt IE 9');

		wp_enqueue_style('portfolio-ie9', get_template_directory_uri() . '/css/ie9.css', array('portfolio-style'));
		wp_style_add_data('portfolio-ie9', 'conditional', 'IE 9');
	}
}

add_action('wp_enqueue_scripts', 'portfolio_styles');

if(!function_exists('portfolio_widgets_init')) {
	/**
	 * Register widget area.
	 *
	 * @return void
	 */
	function portfolio_widgets_init() {
		register_sidebar(
		array(
			'name' => 'Боковая колонка', // название сайдбара
			'id' => 'true_side', // уникальный id
			'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
			'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
			'after_title' => '</h3>'
		)
	);
	}
}

add_action('widgets_init', 'portfolio_widgets_init');

if (!function_exists('portfolio_paging_nav')) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 *
	 * @return void
	 */
	function portfolio_paging_nav() {
		global $wp_query, $paged;

		//display number of current page
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 )
			return;
		?>
		<nav class="navigation paging-navigation" role="navigation">
				<div class="nav-links">

					<?php if (get_next_posts_link()) : ?>
						<div class="nav-previous"><?php next_posts_link( __( 'Предыдущая страница', 'portfolio' ) ); ?></div>
					<?php endif; ?>

					<span class="pagination-item"><?php _e( ' ', 'portfolio' )?> <?php echo $paged ?> <?php _e( ' из ', 'portfolio' )?> <?php echo $wp_query->max_num_pages ?></span>

					<?php if (get_previous_posts_link()) : ?>
						<div class="nav-next"><?php previous_posts_link( __( 'Следующая страница', 'portfolio' ) ); ?></div>
					<?php endif; ?>

				</div><!-- .nav-links -->
			</nav><!-- .navigation -->
		<?php
	}
}

if(!function_exists('portfolio_video_code')) {
	function portfolio_video_code() {
		$video_condition = stripos(get_the_content(), '</iframe>') !== FALSE || stripos(get_the_content(), '</video>') !== FALSE;

		if($video_condition) {
			$video_code = '';

			if(stripos(get_the_content(), '</iframe>') !== FALSE) {
				$start = stripos(get_the_content(), '<iframe');
				$len = strlen(substr(get_the_content(), $start, stripos(get_the_content(), '</iframe>', $start)));
				$video_code = substr(get_the_content(), $start, $len + 9);
			} elseif(stripos(get_the_content(), '</video>') !== FALSE) {
				$start = stripos(get_the_content(), '<video');
				$len = strlen(substr(get_the_content(), $start, stripos(get_the_content(), '</video>', $start)));
				$video_code = substr(get_the_content(), $start, $len + 8);
			}

			return $video_code;
		} else {
			return FALSE;
		}
	}
}


if (!function_exists('portfolio_the_attached_image')) {
	/**
	 * Print the attached image with a link to the next attached image.
	 *
	 * @since Portfolio 1.0
	 *
	 * @return void
	 */
	function portfolio_the_attached_image() {
		/**
		 * Filter the image attachment size to use.
		 *
		 * @since Portfolio 1.0
		 *
		 * @param array $size {
		 *     @type int The attachment height in pixels.
		 *     @type int The attachment width in pixels.
		 * }
		 */
		$attachment_size     = apply_filters( 'portfolio_attachment_size', array( 724, 724 ) );
		$next_attachment_url = wp_get_attachment_url();
		$post                = get_post();

		/*
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts(array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => -1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID'
		));

		// If there is more than 1 attachment in a gallery...
		if (count($attachment_ids) > 1) {
			foreach ($attachment_ids as $attachment_id) {
				if ($attachment_id == $post->ID) {
					$next_id = current($attachment_ids);
					break;
				}
			}

			// get the URL of the next image attachment...
			if ($next_id) {
				$next_attachment_url = get_attachment_link($next_id);
			} else { // or get the URL of the first image attachment.
				$next_attachment_url = get_attachment_link(array_shift($attachment_ids));
			}
		}

		printf('<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
			esc_url($next_attachment_url),
			the_title_attribute(array('echo' => false)),
			wp_get_attachment_image($post->ID, $attachment_size)
		);
	}
}

if(!function_exists('portfolio_social_button')) {
	/**
	 * Add Twitter & Facebook Sharing Icon to Posts
	 *
	 * @since Portfolio 1.0
	 *
	 * @param string $content Post content.
	 * @return string Post content with HTML output.
	 */
	function portfolio_social_button($content) {
		global $post;
		// get posts titles and permalinks
		$permalink = get_permalink($post->ID);
		$title = get_the_title();
		// add share button only on posts pages
		if(!is_feed() && !is_home() && !is_page() && get_theme_mod('portfolio_post_show_social', '1') == '1') {
			$content = $content . '<div class="gk-social-buttons">
			<span class="gk-social-label">'.__( 'Поделиться с друзьями:', 'portfolio' ).'</span>
			<a class="gk-social-twitter" href="http://twitter.com/share?text='.urlencode($title).'&amp;url='.urlencode($permalink).'"
	            onclick="window.open(this.href, \'twitter-share\', \'width=550,height=235\');return false;">
	            <span class="social__icon--hidden">Twitter</span>
	        </a>

			<a class="gk-social-vk" href="http://vk.com/share.php?url='.urlencode($permalink).'"
	           onclick="window.open(this.href, \'vk-share\', \'width=490,height=530\');return false;">
	            <span class="social__icon--hidden">VK</span>
	        </a>
				
			<a class="gk-social-fb" href="https://www.facebook.com/sharer/sharer.php?u='.urlencode($permalink).'"
			     onclick="window.open(this.href, \'facebook-share\',\'width=580,height=296\');return false;">
			    <span class="social-icon-hidden">Facebook</span>
			</a>
			
			<a class="gk-social-gplus" href="https://plus.google.com/share?url='.urlencode($permalink).'"
	           onclick="window.open(this.href, \'google-plus-share\', \'width=490,height=530\');return false;">
	            <span class="social__icon--hidden">Google+</span>
	        </a>
		</div>';
		}
		return $content;
	}
}

add_filter('the_content', 'portfolio_social_button');


if(get_theme_mod('portfolio_special_img_size', '0') == '1') {
	if(!function_exists('portfolio_image_sizes')) {
		/**
		 * Add dedicated portfolio image size
		 *
		 * @since Portfolio 1.3
		 *
		 * @param array $size dimensions of the image.
		 * @return array Array of the modified image dimensions
		 */
		function portfolio_image_sizes($sizes) {
			$addsizes = array(
				"gk-portfolio-size" => __( "Portfolio image", "portfolio")
			);
			$newsizes = array_merge($sizes, $addsizes);
			return $newsizes;
		}
	}

	add_image_size('gk-portfolio-size', get_theme_mod('portfolio_img_w', 300), get_theme_mod('portfolio_img_h', 400), get_theme_mod('portfolio_img_hard_crop', '1') == '1');
	add_filter('image_size_names_choose', 'portfolio_image_sizes');
}

if (!function_exists('_wp_render_title_tag')) {
    /**
     * Add backward compatibility for the title tag
     *
     * @since Portfolio 1.4
     */
    function theme_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
    add_action( 'wp_head', 'theme_slug_render_title' );
}

if (!function_exists('portfolio_filter_for_categories')) {
	function portfolio_filter_for_categories($query) {
	    if (
	    	get_theme_mod('portfolio_filter_categories', '') != '' &&
	    	$query->is_main_query() &&
	    	is_home()
	    ) {
	        $query->set('cat', get_theme_mod('portfolio_filtered_categories', ''));
	    }
	}

	add_action('pre_get_posts', 'portfolio_filter_for_categories');
}