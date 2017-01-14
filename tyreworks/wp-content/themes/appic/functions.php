<?php
define('PARENT_DIR', get_template_directory() );
define('PARENT_URL', get_template_directory_uri());

if ( !defined('THEME_IS_DEV_MODE') ) define('THEME_IS_DEV_MODE', false);

/**
 * Option name used for storing theme settings.
 * @see get_theme_option
 * @see init_theme_options
 */
if ( !defined('VP_OPTION_KEY') ) define('VP_OPTION_KEY', 'appic_theme_options');

if (!class_exists('ThemeFlags')) {
	class ThemeFlags
	{
		private static $flags = array(
			// if breadcrumbs should be hidden for current page
			'hide_breadcrumbs' => false,
			'theme_excerpt_more_link_fixed_mode' => false,
		);

		public static function get($keyName, $default = null)
		{
			return isset(self::$flags[$keyName]) ? self::$flags[$keyName] : $default;
		}

		public static function set($keyName, $value)
		{
			self::$flags[$keyName] = $value;
		}
	}
}

require_once PARENT_DIR . '/includes/components/ThemeShortcodesEscapeNL.php';
ThemeShortcodesEscapeNL::init();

// Shortcodes implementation
require_once PARENT_DIR . '/includes/shortcodes/shortcodes.php';
require_once PARENT_DIR . '/includes/shortcodes/tinymce/tinymce_shortcodes.php';

// Vafpress framework
require_once PARENT_DIR . '/framework/vafpress/bootstrap.php';

// Additional vafpress fields implementation
VP_AutoLoader::add_directories(PARENT_DIR .'/includes/vafpress-addon/classes', 'VP_');
VP_FileSystem::instance()->add_directories('views', PARENT_DIR .'/includes/vafpress-addon/views');

require_once PARENT_DIR . '/includes/metabox.php';

// Custom post types
require_once PARENT_DIR . '/includes/custom-post-types.php';

require_once PARENT_DIR . '/includes/components/JsClientScript.php';

#-----------------------------------------------------------------#
# Plugins
#-----------------------------------------------------------------#
require_once PARENT_DIR . '/includes/plugins.php';

// Contact Form 7 styling
function appic_custom_form_class_attr( $class ) {
	$class .= ' border-double messege-form text-center';
	return $class;
}
add_filter( 'wpcf7_form_class_attr', 'appic_custom_form_class_attr' );

if ( ! function_exists( 'aq_resize' ) ) {
	// Aqua Resizer for image cropping and resizing on the fly
	require_once PARENT_DIR . '/includes/aq_resizer.php';
}

// jquery.sharrre.js lib integration
require_once PARENT_DIR . '/includes/sharrre.php';

// Widgets registration
require_once PARENT_DIR . '/includes/widgets/accordion.php';
require_once PARENT_DIR . '/includes/widgets/news.php';
require_once PARENT_DIR . '/includes/widgets/button.php';
require_once PARENT_DIR . '/includes/widgets/popular_post.php';
require_once PARENT_DIR . '/includes/widgets/flickr.php';

// Make a Wordpress built-in Text widget process shortcodes
add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode', 11);

if ( ! isset( $content_width ) ) {
	$content_width = 770;
}

// automatic-feed-links
if ( version_compare( $wp_version, '3.0', '>=' ) ) {
	add_theme_support( 'automatic-feed-links' ); 
}

// Post thumbnails
add_theme_support('post-thumbnails');
add_image_size('blog-style', 630, 262, true);
add_image_size('blog-style-2', 620, 340, true);
add_image_size('single-post', 760, 300, true);
add_image_size('single-project', 760, 520, true);

// Sidebar initialisation
if ( function_exists('register_sidebar') ) {
	// Right Sidebar
	register_sidebar(array(
		'name'          => __('Sidebar', 'appic'),
		'id'            => 'sidebar',
		'description'   => __('Sidebar located on the right side of blog page.', 'appic'),
		'before_widget' => '<div id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="page-elements-title">',
		'after_title'   => '</h3>',
	));
	// Footer 1
	register_sidebar(array(
		'name'          => __('Footer 1', 'appic'),
		'id'            => 'footer-1',
		'description'   => __( 'Located in 1st column on 4-columns footer layout', 'appic'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	// Footer 2
	register_sidebar(array(
		'name'          => __('Footer 2', 'appic'),
		'id'            => 'footer-2',
		'description'   => __( 'Located in 2nd column on 4-columns footer layout', 'appic'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	// Footer 3
	register_sidebar(array(
		'name'          => __('Footer 3', 'appic'),
		'id'            => 'footer-3',
		'description'   => __( 'Located in 3rd column on 4-columns or 2nd on 3-columns footer layout', 'appic'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	// Footer 4
	register_sidebar(array(
		'name'          => __('Footer 4', 'appic'),
		'id'            => 'footer-4',
		'description'   => __( 'Located in 4th column on 4-columns or 3rd on 3-columns footer layout', 'appic'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	// Footer 1 & 2
	register_sidebar(array(
		'name'          => __('Footer 1 & 2', 'appic'),
		'id'            => 'footer-1_2',
		'description'   => __( 'This is a joined 1st and 2nd column that can be found on 3-columns footer layout', 'appic'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	// Sidebars used on the project details page (single-project.php)
	register_sidebar(array(
		'name'          => __('Single project left sidebar', 'appic'),
		'id'            => 'single_project_widget_left',
		'description'   => __('Sidebar located on the left side of the bottom of the project details page.', 'appic'),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	));
	register_sidebar(array(
		'name'          => __('Single project right sidebar', 'appic'),
		'id'            => 'single_project_widget_right',
		'description'   => __('Sidebar located on the right side of the bottom of the project details page.', 'appic'),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	));
}

#-----------------------------------------------------------------#
# Asserts registration
#-----------------------------------------------------------------#
function init_theme_asserts()
{
	wp_enqueue_style('theme-style', get_stylesheet_uri());
	wp_enqueue_style('bootstrap-font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
	
	wp_enqueue_style('theme-retina', PARENT_URL . '/css/retina.css');

	// Masonry
	wp_register_script('masonry', PARENT_URL . '/scripts/vendor/masonry.pkgd.min.js', array('jquery'));
	//wp_enqueue_script('masonry');

	wp_register_script('time_line', PARENT_URL . '/scripts/jquery.timelineG.js', array('jquery-ui-draggable','jquery-touch-punch'));
	//wp_enqueue_script('time_line');

	// Colorbox
	wp_register_script('colorbox', PARENT_URL . '/scripts/vendor/jquery.colorbox.js', array('jquery'));
	//wp_enqueue_script('colorbox');

	// Sharrre lib implementation
	wp_register_script('sharrre', PARENT_URL .'/scripts/vendor/jquery.sharrre.js',array('jquery'), '',true);

	if (THEME_IS_DEV_MODE) {
		// Event Drag
		wp_register_script('event_drag', PARENT_URL . '/scripts/vendor/jquery.event.drag-2.2.js', array('jquery'));
		wp_register_script('event_drop', PARENT_URL . '/scripts/vendor/jquery.event.drop-2.2.js', array('jquery'));

		// jQuery easing
		wp_register_script('easing', PARENT_URL . '/scripts/vendor/jquery.easing.1.3.js', array('jquery'));

		// BX Slider
		wp_register_script('bxslider', PARENT_URL . '/scripts/vendor/jquery.bxslider.js', array('easing','fitvids'));

		// Roundabout
		wp_register_script('roundabout', PARENT_URL . '/scripts/vendor/jquery.roundabout.js', array('easing', 'event_drag', 'event_drop'));

		// Bootstrap min
		wp_register_script('bootstrap_min', PARENT_URL . '/scripts/vendor/bootstrap.min.js', array('jquery'));
		wp_enqueue_script('bootstrap_min');

		// Modernizr with version Number at the end
		wp_register_script('modernizr', PARENT_URL . '/scripts/vendor/modernizr.custom.91224.js', array('jquery'));
		wp_enqueue_script('modernizr');

		// Mobile Select Menu
		wp_register_script('mobilemenu', PARENT_URL . '/scripts/vendor/jquery.mobile.menu.js', array('jquery'));
		wp_enqueue_script('mobilemenu');

		// Mobile Select Menu
		wp_register_script('mobilemenu_custom', PARENT_URL . '/scripts/vendor/jquery.mobile.customized.min.js', array('jquery'));
		wp_enqueue_script('mobilemenu_custom');

		// Knob
		wp_register_script('knob', PARENT_URL . '/scripts/vendor/jquery.knob.js', array('jquery'));
		wp_enqueue_script('knob');

		// Fitvids
		wp_register_script('fitvids', PARENT_URL . '/scripts/vendor/jquery.fitvids.js', array('jquery'));
		wp_enqueue_script('fitvids');

		//forms processing js
		wp_register_script('form', PARENT_URL . '/scripts/custom.form.js', array('jquery'));
		wp_enqueue_script('form');

		wp_register_script('custom', PARENT_URL . '/scripts/custom.js', array('jquery'));
		wp_enqueue_script('custom');
	} else {//pachages for the production mode
		$filesExtentions = SCRIPT_DEBUG ? '.js' : '.min.js';
		wp_register_script('custom-addons-full', PARENT_URL . '/scripts/custom-addons-full' . $filesExtentions, array('jquery'));
		wp_register_script('event_drag', '', array('custom-addons-full'));
		wp_register_script('event_drop', '', array('custom-addons-full'));
		wp_register_script('easing', '', array('custom-addons-full'));
		wp_register_script('bxslider', '', array('custom-addons-full'));
		wp_register_script('roundabout', '', array('custom-addons-full'));

		wp_enqueue_script('custom-full', PARENT_URL . '/scripts/custom-full' . $filesExtentions, array('jquery'));
		wp_register_script('fitvids', '', array('custom-full'));
	}
}
add_action('wp_enqueue_scripts', 'init_theme_asserts'); // Add Custom Scripts

// Add button TinyMCE panel
function appthemes_add_quicktags()
{
	if (wp_script_is('quicktags')) {
?>
	<script type="text/javascript">
		QTags.addButton('eg_hr', 'hr', '<hr />', '', 'h', 'Horisontal line', 201);
		QTags.addButton('eg_br', 'br', '<br />', '', 'br', 'Breack', 202);
		QTags.addButton('eg_p', 'p', '<p class="simple-text-14">', '', 'p', 'p without margin', 203);
		QTags.addButton('eg_pm', 'p-margin', '<p class="simple-text-14 text-image-bottom">', '', 'p-margin', 'p with margin', 204);
	</script>
<?php
	}
}
add_action('admin_print_footer_scripts', 'appthemes_add_quicktags'); //Add button <br />

if ( ! function_exists('appic_avatars') ) {
	function appic_avatars($avatar_defaults)
	{
		$myavatar1 = PARENT_URL . '/img/user-photo-2.jpg';
		$avatar_defaults[$myavatar1] = 'Appic avatar';
		return $avatar_defaults;
	}
}
add_filter( 'avatar_defaults', 'appic_avatars' );

#-----------------------------------------------------------------#
# Excerpt settings implementation
#-----------------------------------------------------------------#
if ( ! function_exists( 'theme_excerpt_more_link' ) ) {
	function theme_excerpt_more_link( $more = '...' )
	{
		$fixedMode = ThemeFlags::get( 'theme_excerpt_more_link_fixed_mode' );
		if ( $fixedMode ) {
			$more = $fixedMode;
		} else {
			if ( is_search() ) {
				return '<a href="' . get_permalink() . '" class="link-icon-arrow link-position"></a>';
			}
		}

		static $moreText;
		if ( null === $moreText ) {
			$moreText = get_theme_option( 'excerpt_text' );
		}

		$html = '';
		if ( ! $moreText || '[just-arrow]' == $more ) { //|| get_post_type() == 'project'
			$html = '<a href="'. get_permalink() . '" class="posts-arrow"></a>';
		} else {
			$html = '<a href="' . get_permalink() . '" class="link-button">' . $moreText . '<span class="link-arrow"></span></a>';
		}
		
		return $html;
	}
}
add_filter( 'excerpt_more', 'theme_excerpt_more_link' );


// Remove invalid tags
function remove_invalid_tags($str, $tags)
{
	foreach ($tags as $tag) {
		$str = preg_replace('#^<\/'.$tag.'>|<'.$tag.'>$#', '', trim($str));
	}
	return $str;
}

function do_excerpt($string, $word_limit)
{
	$words = explode(' ', $string, ($word_limit + 1));
	if (count($words) > $word_limit) {
		array_pop($words);
	}
	return implode(' ', $words);
}

if ( ! function_exists('theme_search_form') ) {
	function theme_search_form($form)
	{
		$form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
		<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="type your request" />
		<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
		</form>';
		return $form;
	}
}
add_filter('get_search_form', 'theme_search_form');

#-----------------------------------------------------------------#
# Breadcrumbs
#-----------------------------------------------------------------#
if ( ! function_exists('appic_breadcrumbs') ) {
	function appic_breadcrumbs()
	{
		if ( ! ThemeFlags::get('hide_breadcrumbs') ) {
			require_once PARENT_DIR . '/includes/components/ThemeBreadcrumbs.php';

			$html = ThemeBreadcrumbs::get_html();
			if ($html) {
				return '<div class="foto-pattern">' . $html . '</div>';
			}
		}

		return '';
	}
}

#-----------------------------------------------------------------#
# Pagination functions
#-----------------------------------------------------------------#
if ( ! function_exists( 'appic_pagenavi' ) ) {
	function appic_pagenavi($before='', $after='', $echo=true)
	{
		global $wp_query;
		
		$paged = isset($wp_query->query_vars['paged']) ? $wp_query->query_vars['paged'] : 1;
		if ($paged < 1) {
			$paged = 1;
		}
		
		if ($wp_query->max_num_pages < 2) {
			return '';
		}
		
		$big = 999999999; // need an unlikely integer
		$pa = paginate_links(array(
			'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
			'format' => '?paged=%#%',
			'current' => $paged,
			'total' => $wp_query->max_num_pages,
			'type' => 'array',
			'end_size' => 1,
			'mid_size' => 2,//1
			'prev_next' => false,
		));
		
		$end_page = $wp_query->max_num_pages;
		$prevPageLink = '';
		$nextPageLink = '';

		if ( $paged !=1 ) {
			$prevPageLink = '<li class="show-desktop"><a href="'.get_pagenum_link(($paged-1)).'">&nbsp;</a></li>';
		} elseif ($paged == 1) {
			$prevPageLink = '<li class="show-desktop disabled"><a href="javascript:void(0)">&nbsp;</a></li>';
		}

		if ($paged != $end_page) {
			$nextPageLink = '<li class="show-desktop"><a href="'.get_pagenum_link(($paged+1)).'" class="next-arrow">&nbsp;</a></li>';
		} elseif ($paged == $end_page) {
			$nextPageLink = '<li class="show-desktop disabled"><a href="javascript:void(0)" class="next-arrow">&nbsp;</a></li>';
		}

		$result = array(
			$prevPageLink
		);
		if (!empty($pa)) {
			foreach ($pa as $key => $value) {
				$result[] = '<li>' . $value . '</li>';
			}
		}
		$result[] = $nextPageLink;
	
		$liElementsHtml = join('', $result);
		$liElementsHtml = preg_replace('/<li><span class=\'page-numbers current\'>(\d{1,})<\/span><\/li>/', '<li class="active"><a href="#">${1}</a></li>', $liElementsHtml);
	
		$html = $before . "<div class='pagination'><ul>".$liElementsHtml."</ul></div>" . $after;
		if ($echo) {
			echo $html;
			return;
		}
		return $html;
	}
}

if ( ! function_exists( 'appic_posts_navigation' ) ) {
	function appic_posts_navigation($prevLabel = null, $nextLabel = null)
	{
		global $paged, $wp_query;

		if ($wp_query->max_num_pages < 2) {
			return '';
		};

		if (null == $prevLabel) {
			$prevLabel = __('prev', 'appic');
		}

		if (null == $nextLabel) {
			$nextLabel = __('next', 'appic');
		}

		if ($paged < 1) {
			$paged = 1;
		}
		$nextpage = $paged + 1;
		$max_page = $wp_query->max_num_pages;

		$prevLinkDisabledClass = !is_single() && $paged > 1 ? '' : ' disabled';
		$prevLinkHtml = '<li class="previous'.$prevLinkDisabledClass.'"><a href="' . ($prevLinkDisabledClass ? 'javascript:void(0)' : previous_posts( false )) . '"><span class="page-elements-title">'. $prevLabel .'</span></a></li>';

		$nextLinkDisabledClass = !is_single() && $nextpage <= $max_page ? '' : ' disabled';
		$nextLinkHtml = '<li class="next'.$nextLinkDisabledClass.'"><a href="' . ($nextLinkDisabledClass ? 'javascript:void(0)' : next_posts( $max_page, false )) . '"><span class="page-elements-title">'. $nextLabel .'</span></a></li>';

		return '<ul class="pager">' . $prevLinkHtml . $nextLinkHtml . '</ul>';
	}
}

/**
 * Renders/returns html for single post pagination.
 * If post content has <!--nextpage--> delimiters.
 * 
 * @param  boolean $echo is html should be outputed
 * @return string        returns html if $echo is false
 */
function appic_post_pagination($echo = true)
{
	$res = wp_link_pages(array(
		'before' => '',
		'after' => '',
		'separator' => "\n",
		'next_or_number' => 'number',
		'echo' => false,
	));

	$parts = explode("\n", $res);
	if (count($parts) < 2) {
		return '';
	}
	$parts[] = '';//to make last element empty, insteed of next link

	$html = '<div class="pagination"><ul><li>'.join('</li><li>', $parts).'</li></ul></div>';

	$html = preg_replace('/<li>(\d{1,})<\/li>/', '<li class="active"><a href="#">${1}</a></li>', $html);
	if ($echo) {
		echo $html;
		return;
	}
	return $html;
}

#-----------------------------------------------------------------#
# Theme settings functions
#-----------------------------------------------------------------#
/**
 * Returns theme option value.
 * @param  string $name option name
 * @return mixed
 */
function get_theme_option($name)
{
	return vp_option(VP_OPTION_KEY .'.'.$name);
}

function init_theme_options()
{
	$theme_options = new VP_Option(array(
		//'is_dev_mode'           => THEME_IS_DEV_MODE,
		'option_key'            => VP_OPTION_KEY,
		'page_slug'             => 'theme_options_page',
		'template'              => PARENT_DIR . '/options-vafpress.php',
		'menu_page'             => 'themes.php',
		'use_auto_group_naming' => true,
		'use_exim_menu'         => true,
		'minimum_role'          => 'edit_theme_options',
		'layout'                => 'fixed',
		'page_title'            => __('Theme Options', 'appic'),
		'menu_label'            => __('Theme Options', 'appic'),
	));
	// theme update notifier configuration
	if (is_super_admin() && get_theme_option('update_notifier')) {
		require_once PARENT_DIR . '/includes/components/ThemeUpdater.php';
		$themeUpdater = new ThemeUpdater(array(
			'themeName' => 'Appic',
			'themeId' => 'appic',
			'cachePrefix' => 'appic',
			'updatesFileUrl' => 'http://info.appic.softmanner.com/versions.json',
		));
	}

	// loading textdomain
	load_theme_textdomain( 'appic', dirname(__FILE__) . '/languages' );
}
// the safest hook to use, since Vafpress Framework may exists in Theme or Plugin
add_action('after_setup_theme', 'init_theme_options');

// action called after theme options saving event
function action_on_theme_options_save($settings)
{
	// regenerating custom css classes
	get_custom_css_blocks(true, $settings);

	// regenerating favicons html block
	get_favicons_html(true, $settings);
}
add_action('vp_option_set_after_save', 'action_on_theme_options_save');

if ( ! function_exists( 'get_custom_css_blocks' ) ) {
	/**
	 * Return text that contans <style> elements & <link> element that loads
	 * google web fonts required to apply changes made in the theme settings.
	 * @param  boolean $refreshCache [description]
	 * @param  assoc $themeOptions
	 * @return string
	 */
	function get_custom_css_blocks($refreshCache = false, $themeOptions = null)
	{
		$cacheId = 'appicCustomCssText';
		if ($refreshCache || false === ($result = get_transient($cacheId))) {
			if (null == $themeOptions) {
				$themeOptions = vp_option(VP_OPTION_KEY);
			}

			require_once PARENT_DIR . '/includes/components/AppicCssGenerator.php';
			$cssGenerator = new AppicCssGenerator();
			$result = $cssGenerator->generateCss($themeOptions);

			set_transient($cacheId, $result);
		}

		return $result;
	}
}

if (! function_exists('get_favicons_html') ) {
	/**
	 * Generates html for favicons based on the theme options.
	 * @param  boolean $refreshCache set to true if cache should be ignored
	 * @param assoc $themeOptions
	 * @return srting
	 */
	function get_favicons_html($refreshCache = false, $themeOptions = null)
	{
		$cacheId = 'appicFaviconsHtml';
		$cacheTime = 300; //5 minutes
		if ($refreshCache || false === ($result = get_transient($cacheId))) {
			if ($themeOptions) {
				$faviconUrl = !empty($themeOptions['favicon_ico']) ? $themeOptions['favicon_ico'] : '';
				$faviconPngUrl = !empty($themeOptions['favicon_png']) ? $themeOptions['favicon_png'] : '';
			} else {
				$faviconUrl = get_theme_option('favicon_ico');
				$faviconPngUrl = get_theme_option('favicon_png');
			}

			$lines = array();
			if($faviconUrl) {
				$lines[] = '<link rel="shortcut icon" href="'.$faviconUrl.'">';
			}
			if($faviconPngUrl) {
				$lines[] = '<link rel="apple-touch-icon" href="'.$faviconPngUrl.'">';
				$lines[] = '<link rel="apple-touch-icon" sizes="72x72" href="'.aq_resize($faviconPngUrl, 72, 72, true).'">';
				$lines[] = '<link rel="apple-touch-icon" sizes="114x114" href="'.aq_resize($faviconPngUrl, 114, 114, true).'">';
				$lines[] = '<link rel="apple-touch-icon" sizes="144x144" href="'.aq_resize($faviconPngUrl, 144, 144, true).'">';
			}

			$result = join("\n", $lines);
			set_transient($cacheId, $result, $cacheTime);
		}

		return $result;
	}
}
if (! function_exists('render_header_resources') ) {
	function render_header_resources()
	{
		// output favicons
		echo get_favicons_html();

		// output of the custom css & web fonts include
		echo get_custom_css_blocks();

		echo "<!-- HTML5 shim for IE backwards compatibility -->\n" .
			"<!--[if lt IE 9]>\n" .
				"<script src=\"http://html5shim.googlecode.com/svn/trunk/html5.js\"></script>\n" .
			"<![endif]-->\n";
	}
}
add_action( 'wp_head', 'render_header_resources' );


if (! function_exists('render_google_analytics_code') ) {
	// google analitics rendering
	function render_google_analytics_code($return = false)
	{
		$googleAnalytics = get_theme_option('google_analitycs_code');

		if ($return) {
			return $googleAnalytics;
		} else {
			echo $googleAnalytics;
		}
	}
}

/**
 * Updates post per page for projects query.
 * @param  object $wp_query
 * @return void
 */
function modify_projects_query( $wp_query )
{
	$qvar = $wp_query->query_vars;

	// to apply option 'posts_per_page' on the project category page
	if ( ! empty($qvar['project_category']) && empty($qvar['post_type']) ) {
		$qvar['post_type'] = 'project';
	}
	// ignoring all queries that not related on project query
	if ( empty($qvar['post_type']) || 'project' != $qvar['post_type'] ) {
		return;
	}
	// if page size already defined - ignoring such queries as well
	if ( ! empty($qvar['posts_per_page']) ) {
		return;
	}
	
	$pageSize = get_theme_option('project_per_page');
	if ($pageSize > 0) {
		$wp_query->query_vars['posts_per_page'] = $pageSize;
	}
}
add_filter( 'pre_get_posts', 'modify_projects_query' );

add_filter('widget_text', 'do_shortcode');

#-----------------------------------------------------------------#
# Custom menu
#-----------------------------------------------------------------#

add_theme_support('menus');

if(function_exists('register_nav_menus')) {
	// Register navigation
	register_nav_menus(array(
		'header-menu' => __('Header Menu', 'appic') //Main navigation
	));
}

if (! function_exists('theme_get_the_post_thumbnail') ) {
	/**
	 * Returns grey image in case if after import attachments have not been downloaded.
	 * @param  int    $postId
	 * @param  string $size
	 * @param  string $attr         that should be applied for the img tag
	 * @param  array  $undefinedSize size of the image that should be returned (used if $size is undefined)
	 * @return string
	 */
	function theme_get_the_post_thumbnail($postId = null, $size = 'full', array $attr = array(), array $undefinedSize = array(770, 514))
	{
		$result = null;

		if (null == $postId) {
			$postId = get_the_ID();
		}

		if( !has_post_thumbnail($postId) ){
			return '';
		}

		if ($postId) {
			$result = get_the_post_thumbnail($postId, $size, $attr);
		}

		if ($result) {
			return $result;
		}

		$sizeDetails = get_image_size_details($size);
		if ($sizeDetails) {
			$width = isset($sizeDetails['width']) ? $sizeDetails['width'] : null;
			$height = isset($sizeDetails['height']) ? $sizeDetails['height'] : null;
		} else {
			$width = isset($undefinedSize[0]) ? $undefinedSize[0] : null;
			$height = isset($undefinedSize[1]) ? $undefinedSize[1] : null;
		}

		if ( $width && $height ) {
			$imgSize = $width . "x" . $height;
			$class = !empty($attr['class']) ? ' class="'.$attr['class'].'"' : '';
			$result = '<img '.$class.' src="http://placehold.it/'.$imgSize.'">';
		} else {
			$result = '';
			//throw new Exception("Image size {$size} not defined.");
		}

		return $result;
	}
}

function get_image_size_details($size)
{
	if ( is_array( $size ) ) {
		return $size;
	}
	
	static $defaultSize = array(
		'thumbnail' => '',
		'medium' => '',
		'large' => '',
	);

	if ( isset( $defaultSize[$size] ) ) {
		if ( '' === $defaultSize[$size] ) {
			$width = get_option( $size . '_size_w' );
			$height = get_option ( $size . '_size_h' );
			$crop = get_option ( $size . '_crop' );
			
			if ( $width || $height ) {
				$defaultSize[$size] = array(
					'width' => $width,
					'height' => $height,
					'crop' => $crop,
				);
			} else {
				$defaultSize[$size] = null;
			}
		}
		return $defaultSize[$size];
	}
	
	global $_wp_additional_image_sizes;
	if ( isset( $_wp_additional_image_sizes[$size] ) ) {
		return $_wp_additional_image_sizes[$size];
	}

	return null;
}

if (class_exists('woocommerce')) {
	require_once PARENT_DIR . '/woocommerce/woocommerce.php';
}
