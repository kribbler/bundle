<?php
/**
 * Class for breadcrumbs generation.
 * 
 * @author kollega <oleg.kutcyna@gmail.com>
 * @version  1.1
 */
class ThemeBreadcrumbs
{
	/**
	 * Is category links should have title attribute.
	 * @var boolean
	 */
	public static $categories_allow_titles = true;

	/**
	 * Is breadcrumbs should be rendered on the home page?
	 * @var boolean
	 */
	public static $show_on_home = false;

	/**
	 * Is breadcrumbs should contain link to the home page?
	 * @var boolean
	 */
	public static $show_home_link = true;

	/**
	 * Text of the elements delimiter.
	 * @var string
	 */
	public static $elements_delimiter = '<li><span class="divider">//</span></li>';

	/**
	 * Returns html that represents breadcrumbs element.
	 * @return string
	 */
	public static function get_html()
	{
		if ($elements = self::get_breadcrumbs_elements()) {
			$liHtml = '';
			$lastElement = array_pop($elements);
			if ($elements) {
				$liHtml = '<li>' . join('</li>' . self::$elements_delimiter . '<li>', $elements) . '</li>';
				$liHtml .= self::$elements_delimiter;
			}
			$liHtml .= '<li class="active">' . $lastElement . '</li>';
			return '<ul class="breadcrumb container">'.$liHtml.'</ul>';
		}
		return '';
	}

	protected static function get_breadcrumbs_elements()
	{
		$elements = array();
		
		global $post;
		if (is_front_page()) { //is home page
			if (self::$show_on_home) {
				$elements[] = self::get_type_format('home');
			};
		} else {
			if (self::$show_home_link) {
				$elements[] = self::render_link(home_url('/'), self::get_type_format('home'), 'rel="v:url" property="v:title"');
			}
			if (!$post || is_404() ) {
				$elements[] = self::get_type_format('404');
				return $elements;
			}

			$parent_id = $post->post_parent;
			if ( is_home() ) { //is blog page
				if ( $blog_page_id = get_option( 'page_for_posts' ) ) {
					$elements[] = get_the_title( $blog_page_id );
				}
			} elseif ( is_category() ) {
				$own_category = get_category(get_query_var('cat'), false);
				if ($own_category->parent > 0) {
					if ($parent_categories = self::get_parent_categories($own_category->parent)) {
						$elements = array_merge($elements, $parent_categories);
					}
				}

				$elements[] =  sprintf(
					self::get_type_format('category'),
					single_cat_title('', false)
				);
			} elseif ( is_search() ) {
				$elements[] = sprintf(
					self::get_type_format('search'),
					get_search_query()
				);
			} elseif ( is_day() ) {
				$elements[] = self::render_link(
					get_year_link(get_the_time('Y')),
					get_the_time('Y')
				);

				$elements[] = self::render_link(
					get_month_link(get_the_time('Y'),get_the_time('m')),
					get_the_time('F')
				);

				$elements[] = get_the_time('d');
			} elseif ( is_month() ) {
				$elements[] = self::render_link(
					get_year_link(get_the_time('Y')),
					get_the_time('Y')
				);
				$elements[] = get_the_time('F');
			} elseif ( is_year() ) {
				$elements[] = get_the_time('Y');
			} elseif ( is_single() && !is_attachment() ) {
				if ( 'post' != get_post_type() ) {
					$typeName = get_post_type();
					$post_type = get_post_type_object($typeName);
					if ($archive_url = self::get_archive_url_for_post_type($typeName)) {
						$elements[] = self::render_link(
							$archive_url,
							$post_type->labels->singular_name
						);
					};

					if ($post_type->hierarchical && $parent_id) {
						if ($parent_elements = self::get_parent_elements($post)) {
							$elements = array_merge($elements, array_reverse($parent_elements));
						}
					}
				} else {
					/*if ($cat = get_the_category()) {
						if ($parent_categories = self::get_parent_categories($cat[0])) {
							$elements = array_merge($elements, $parent_categories);
						}
					}*/
					if ( $blog_page_id = get_option( 'page_for_posts' ) ) {
						$elements[] = self::render_link(
							get_page_link( $blog_page_id ),
							get_the_title( $blog_page_id )
						);
					}
				}
				$elements[] = get_the_title();
			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$elements[] = $post_type->labels->singular_name;
			} elseif ( is_attachment() ) {
				if ($parentPost = get_post($parent_id)) {
					if ($cat = get_the_category($parentPost->ID)) {
						if ($parent_categories = self::get_parent_categories($cat[0])) {
							$elements = array_merge($elements, $parent_categories);
						}
					}
				}
		
				$elements[] = self::render_link(get_permalink($parentPost), $parentPost->post_title);
				$elements[] = get_the_title();
			} elseif ( is_page() ) {
				if ($parent_id && ($parent_elements = self::get_parent_elements($post))) {
					$elements = array_merge($elements, array_reverse($parent_elements));
				}

				$elements[] = get_the_title();
			} elseif ( is_tag() ) {
				$elements[] = sprintf(
					self::get_type_format('tag'),
					single_tag_title('', false)
				);
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				$elements[] = sprintf(
					self::get_type_format('author'),
					$userdata->display_name
				);
			}
		}
		
		return $elements;
	}
	
	/**
	 * Returns archive url for specefied post type.
	 * @param  string $post_type
	 * @return string
	 */
	protected static function get_archive_url_for_post_type($post_type)
	{
		return get_post_type_archive_link($post_type);
	}

	/**
	 * Returns array of the link that represents parent categories.
	 * @param  string $category_id
	 * @return array
	 */
	public static function get_parent_categories($category_id)
	{
		$result = array();

		if ($categories_text = get_category_parents($category_id, TRUE, '=DEL=')) {
			$categories = explode('=DEL=', $categories_text);
			foreach ($categories as $cat_link) {
				if (!$cat_link) {
					continue;
				}
				if ( ! self::$categories_allow_titles) {
					$result[] = preg_replace('/ title="(.*?)"/', '', $cat_link);
				} else {
					$result[] = $cat_link;
				}
			}
		}

		return $result;
	}

	/**
	 * Returns array of the link that reprenets paren pages.
	 * @param  Post $page
	 * @return array
	 */
	protected static function get_parent_elements($page)
	{
		$result = array();
		$fronPageId = get_option('page_on_front');
		$cur_parent_id = $page->post_parent;
		if (!$cur_parent_id || $cur_parent_id == $fronPageId) {
			return $result;
		}

		while($cur_parent_id) {
			$page = get_post($cur_parent_id);
			if ($fronPageId != $cur_parent_id) {
				$result[] = self::render_link(
					get_permalink($cur_parent_id),
					get_the_title($cur_parent_id)
				);
			}
			$cur_parent_id = $page->post_parent;
		}

		return $result;
	}

	/**
	 * Returns formatting string for specefied type of string.
	 * @param  string $name type of the string
	 * @return string
	 */
	protected static function get_type_format($name)
	{
		$formats = array(
			'home' => __('Home', 'appic'),
			'category' => __('Category %s', 'appic'),
			'search' => __('Result search "%s"', 'appic'),
			'tag' => __('Tag "%s"', 'appic'),
			'author' => __('Author %s', 'appic'),
			'404' => __('Error 404', 'appic'),
		);

		return isset($formats[$name]) ? $formats[$name] : '%s';
	}

	/**
	 * Returns link html text.
	 * @param  string       $href       url address
	 * @param  string       $title      text of the link
	 * @param  string|array $attributes link attributes
	 * @return string
	 */
	protected static function render_link($href, $title, $attributes = null)
	{
		$attributesText = '';
		if ($attributes) {
			if (is_array($attributes)) {
				$parts = array();
				foreach ($attributes as $key => $value) {
					$parts[] = $key . '="'.$value.'"';
				}
				$attributesText = ' ' . join(' ', $parts);
			} else {
				$attributesText = ' ' . $attributes;
			}
		}

		return '<a href="' .$href. '"' . $attributesText .'>' . $title . '</a>';
	}
}
