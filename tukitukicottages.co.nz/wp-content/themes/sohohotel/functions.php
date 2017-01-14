<?php

/* ------------------------------------------------
	Theme Setup
------------------------------------------------ */

if ( ! isset( $content_width ) ) $content_width = 640;

add_action( 'after_setup_theme', 'qns_setup' );

if ( ! function_exists( 'qns_setup' ) ):

function qns_setup() {

	add_theme_support( 'post-thumbnails' );
	
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
	        set_post_thumbnail_size( "100", "100" );  
	}

	if ( function_exists( 'add_image_size' ) ) {
		add_image_size( 'image-style1', 330, 220, true );
		add_image_size( 'image-style2', 65, 65, true );
		add_image_size( 'image-style3', 700, 480, true );
		add_image_size( 'image-style4', 140, 115, true );
		add_image_size( 'image-style5', 75, 75, true );
		add_image_size( 'image-style6', 60, 60, true );
		add_image_size( 'image-style7', 620, 275, true );
		add_image_size( 'image-style8', 450, 300, true );
	}
	
	add_theme_support( 'automatic-feed-links' );
	load_theme_textdomain( 'qns', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) ) require_once( $locale_file );

	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'qns' ),
	) );

}
endif;



/* ------------------------------------------------
	Required Plugins
------------------------------------------------ */

require_once ('includes/class-tgm-plugin-activation.php');
add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
function my_theme_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		
		/*array(
			'name'     				=> 'Contact Form 7', // The plugin name
			'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
			'source'   				=> get_stylesheet_directory() . '/inc/plugins/contact-form-7.3.3.3.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '3.3.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		
		array(
			'name'     				=> 'Regenerate Thumbnails', // The plugin name
			'slug'     				=> 'regenerate-thumbnails', // The plugin slug (typically the folder name)
			'source'   				=> get_stylesheet_directory() . '/inc/plugins/regenerate-thumbnails.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '2.2.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),*/
		
		array(
			'name'     				=> 'Quite Nice Booking', // The plugin name
			'slug'     				=> 'quitenicebooking', // The plugin slug (typically the folder name)
			'source'   				=> get_stylesheet_directory() . '/includes/plugins/quitenicebooking.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '2.5.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		)

	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'qns',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'qns' ),
			'menu_title'                       			=> __( 'Install Plugins', 'qns' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'qns' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'qns' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'qns' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'qns' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'qns' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}



/* ------------------------------------------------
	Comments Template
------------------------------------------------ */

if( ! function_exists( 'qns_comments' ) ) {
	function qns_comments($comment, $args, $depth) {
	   $path = get_template_directory_uri();
	   $GLOBALS['comment'] = $comment;
	   ?>
		
	<li <?php comment_class('comment-entry clearfix'); ?> id="comment-<?php comment_ID(); ?>">

		<!-- BEGIN .comment-left -->
		<div class="comment-left">
			<div class="comment-image">
				<?php echo get_avatar( $comment, 65 ); ?>
			</div>
		<!-- END .comment-left -->
		</div>

		<!-- BEGIN .comment-right -->
		<div class="comment-right">
					
			<p class="comment-info"><?php printf( __( '%s', 'qns' ), sprintf( '%s', get_comment_author_link() ) ); ?> 
				<span><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php printf( __( '%1$s at %2$s', 'qns' ), get_comment_date(),  get_comment_time() ); ?>
				</a></span>
			</p>
					
			<div class="comment-text">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="comment-moderation"><?php _e( 'Your comment is awaiting moderation.', 'qns' ); ?></p>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
					
			<p><span class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				<?php edit_comment_link( __( '(Edit)', 'qns' ), ' ' ); ?>
			</span></p>

		<!-- END .comment-right -->
		</div>		

	<?php }
}



/* ------------------------------------------------
   Options Panel
------------------------------------------------ */

require_once ('admin/index.php');



/* ------------------------------------------------
	Register Sidebars
------------------------------------------------ */

function qns_widgets_init() {

	// Area 1
	register_sidebar( array(
		'name' => __( 'Standard Page Sidebar', 'qns' ),
		'id' => 'primary-widget-area',
		'description' => __( 'Displayed in the sidebar of all pages except the homepage', 'qns' ),
		'before_widget' => '<div class="widget clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="title-style3">',
		'after_title' => '<span class="title-block"></span></h4>',
	) );
	
	// Area 5
	register_sidebar( array(
		'name' => __( 'Footer', 'qns' ),
		'id' => 'footer-widget-area',
		'description' => __( 'Displayed at the bottom of all pages', 'qns' ),
		'before_widget' => '<div class="one-fourth widget clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="title-style2">',
		'after_title' => '<span class="title-block"></span></h4>',
	) );

}

add_action( 'widgets_init', 'qns_widgets_init' );



/* ------------------------------------------------
	Register Menu
------------------------------------------------ */

if( !function_exists( 'qns_register_menu' ) ) {
	function qns_register_menu() {

		register_nav_menus(
		    array(
				'primary' => __( 'Primary Navigation','qns' ),
				'secondary' => __( 'Top Right Navigation','qns' ),
				'footer' => __( 'Footer Navigation','qns' )
		    )
		  );
		
	}

	add_action('init', 'qns_register_menu');
}



/* ------------------------------------------------
	Add Description Field to Menu
------------------------------------------------ */

class description_walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
      {
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names ) . '"';

           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

           $prepend = '<strong>';
           $append = '</strong>';
           $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

           if($depth != 0) {
				$description = $append = $prepend = "";
           }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID );
            $item_output .= $description.$args->link_after;
			$item_output .= $append;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
}



/* ------------------------------------------------
	Get Post Type
------------------------------------------------ */

function is_post_type($type){
    global $wp_query;
    if($type == get_post_type($wp_query->post->ID)) return true;
    return false;
}



/* ------------------------------------------------
   Register Dependant Javascript Files
------------------------------------------------ */

add_action('wp_enqueue_scripts', 'qns_load_js');

if( ! function_exists( 'qns_load_js' ) ) {
	function qns_load_js() {

		if ( is_admin() ) {
			
		}
		
		else {
			
			// Load JS		
			wp_register_script( 'google-map', 'http://maps.google.com/maps/api/js?sensor=false', array( 'jquery' ), '1', false );
			wp_register_script( 'google-map-header', get_template_directory_uri() . '/js/gmap.js', array( 'jquery' ), '1', true );
			wp_register_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '1.4.8', true );
			wp_register_script( 'prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array( 'jquery' ), '1.1.9', true );
			wp_register_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), '1.1.9', true );
			wp_register_script( 'selectivizr', get_template_directory_uri() . '/js/selectivizr-min.js', array( 'jquery' ), '1.0.2', true );
			wp_register_script( 'custom', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), '1', true );
			wp_enqueue_script( array( 'jquery-ui-core', 'superfish', 'prettyphoto', 'flexslider', 'google-map-header', 'google-map', 'custom' ) );
			
			// Load IE Stuff
			global $is_IE;
			if( $is_IE ) wp_enqueue_script( 'selectivizr' );
			if( is_single() ) wp_enqueue_script( 'comment-reply' );
			
			// Load CSS
			wp_enqueue_style('sohohotel-style', get_bloginfo('stylesheet_url'));
			
			// Load Colour CSS
			global $smof_data;
			
			if( $smof_data['colour_scheme'] == 'Gold & Black') {
				wp_enqueue_style('colour', get_template_directory_uri() .'/css/colours/goldblack.css');
			} elseif( $smof_data['colour_scheme'] == 'Cream & Green') {
				wp_enqueue_style('colour', get_template_directory_uri() .'/css/colours/creamgreen.css');
			} elseif( $smof_data['colour_scheme'] == 'Cream & Red') {
				wp_enqueue_style('colour', get_template_directory_uri() .'/css/colours/creamred.css');
			} elseif( $smof_data['colour_scheme'] == 'Blue & Black') {
				wp_enqueue_style('colour', get_template_directory_uri() .'/css/colours/blueblack.css');
			} else {
				wp_enqueue_style('colour', get_template_directory_uri() .'/css/colours/goldblack.css');
			}
			
			// Load Other CSS
			wp_enqueue_style('superfish', get_template_directory_uri() .'/css/superfish.css');
			wp_enqueue_style('prettyPhoto', get_template_directory_uri() .'/css/prettyPhoto.css');
			wp_enqueue_style('flexslider', get_template_directory_uri() .'/css/flexslider.css');
			wp_enqueue_style('responsive', get_template_directory_uri() .'/css/responsive.css');
			
		}
	}
}

if( !function_exists( 'custom_js' ) ) {

    function custom_js() {
		
		global $smof_data; //fetch options stored in $smof_data

		echo '<script type="text/javascript">';
		
		if ( ($smof_data['gmap-lat']) && ($smof_data['gmap-long']) ) {
			echo "var headerLat = " . $smof_data['gmap-lat'] . ";";
			echo "var headerLong = " . $smof_data['gmap-long'] . ";";
		} else {			
			echo "var headerLat = 51.523728;";
			echo "var headerLong = -0.079336;";
		}
		
		if ( $smof_data['gmap-content'] ) {
			// replace all newlines with <br />, and escape single quotes to prevent breaking Google maps
			$gmap_content = preg_replace(array('/\n/', '/\r/'), '<br />', $smof_data['gmap-content']);
			$gmap_content = preg_replace('/\'/', '\\\'', $gmap_content);
			echo "var googlemapMarker = '" . $gmap_content . "';";
		} else {			
			echo "var googlemapMarker = '<div class=\"gmap-content\"><h2>Soho Hotel</h2><p>1 Main Road, London, UK</p></div>';";
		}
		
		if ( $smof_data['slideshow_autoplay'] ) {
			echo "var slideshow_autoplay = 'true';";
		} else {			
			echo "var slideshow_autoplay = 'false';";
		}
		
		echo '</script>';
		
    }

}

add_action('wp_footer', 'custom_js');



/* ------------------------------------------------
   Enqueue Google Fonts
------------------------------------------------ */

add_action( 'wp_enqueue_scripts', 'qns_fonts' );

function qns_fonts() {
	$protocol = is_ssl() ? 'https' : 'http';
	wp_enqueue_style( 'qns-opensans', "$protocol://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic" );
	
	global $smof_data; //fetch options stored in $smof_data
	
	if ( !$smof_data['custom_font_code'] ) {
		wp_enqueue_style( 'qns-merriweather', "$protocol://fonts.googleapis.com/css?family=Merriweather:400,300,700,900' rel='stylesheet" );
	} else {
		echo $smof_data['custom_font_code'];
	}

}



function admin_style() {
	wp_enqueue_style('admin-css', get_template_directory_uri().'/css/admin.css');
}

add_action("admin_head", 'admin_style');


/* ------------------------------------------------
   Load Files
------------------------------------------------ */

// Post Types
include 'functions/post-types/testimonials.php';
include 'functions/post-types/events.php';
include 'functions/post-types/page.php';

// Shortcodes
include 'functions/shortcodes/accordion.php';
include 'functions/shortcodes/button.php';
include 'functions/shortcodes/columns.php';
include 'functions/shortcodes/dropcap.php';
include 'functions/shortcodes/gallery.php';
include 'functions/shortcodes/googlemap.php';
include 'functions/shortcodes/list.php';
include 'functions/shortcodes/message.php';
include 'functions/shortcodes/tabs.php';
include 'functions/shortcodes/title.php';
include 'functions/shortcodes/toggle.php';
include 'functions/shortcodes/video.php';
include 'functions/shortcodes/widget-slider.php';
include 'functions/shortcodes/home-gallery.php';
include 'functions/shortcodes/slideshow.php';

// Widgets
include 'functions/widgets/widget-flickr.php';
include 'functions/widgets/widget-social.php';
include 'functions/widgets/widget-recent-posts.php';
include 'functions/widgets/widget-contact.php';



/* ------------------------------------------------
	Custom CSS
------------------------------------------------ */

function custom_css() {
	
	global $smof_data; //fetch options stored in $smof_data
	
	// Set Font Family
	if ( !$smof_data['custom_font'] ) { 
		$custom_font = "'Merriweather', serif"; } 
	else { 
		$custom_font =  $smof_data['custom_font']; 
	}
	
	// Output Custom CSS
	$output = '<style type="text/css">
		h1, h2, h3, h4, h5, h6, #navigation li, .slider-caption p, .room-price-widget .from, .room-price-widget .price, .room-price-widget .price-detail, .step-icon, .step-title, .room-price .price span, .price-details .deposit, .price-details .total, .lightbox-title, table th, .mobile-menu-title {
		font-family: ' . $custom_font . ' !important;
	}
	
	' . $smof_data['custom_css'];

	if ( $smof_data['body_background'] and $smof_data['body_background_image'] ) {
		
		if ( $smof_data['background_repeat'] ) {
			$background_repeat = $smof_data['background_repeat'];
		}
		else {
			$background_repeat = 'repeat';
		}
		
		$output .= 'body {
			background: url(' . $smof_data['body_background_image'] . ') ' . $smof_data['body_background'] . ' fixed ' . $smof_data['background_repeat'] . ' !important;
		}';
	}
	
	elseif ( $smof_data['body_background'] ) { 
		$output .= 'body {
			background: url(' . get_template_directory_uri() . '/images/bg.png) ' . $smof_data['body_background'] . ' fixed !important;
		}';
	}
	
	elseif ( $smof_data['body_background_image'] ) { 
		$output .= 'body {
			background: url(' . $smof_data['body_background_image'] . ') fixed ' . $smof_data['background_repeat'] . ' !important;
		}';
	}

	if ( $smof_data['main_color'] ) { 
		$output .= '#navigation .current-menu-item,
		#navigation .current_page_item,
		#navigation li:hover,
		blockquote,
		.button1:hover,
		.button4:hover,
		.button5:hover,
		.button2,
		#submit,
		.button3,
		.button6,
		#footer .button1,
		.ui-tabs .ui-tabs-nav li.ui-state-active,
		.widget-reservation-box,
		.booking-side,
		.booking-main,
		#slider .home-reservation-box,
		#slider-full .home-reservation-box,
		#ui-datepicker-div,
		.pagination-wrapper .selected,
		.pagination-wrapper a:hover,
		.wp-pagenavi .current,
		.wp-pagenavi a:hover,
		.tagcloud a:hover,
		.nsu-submit:hover,
		#footer .nsu-submit,
		.nsu-submit:hover,
		#footer .nsu-submit {
			border-color: ' . $smof_data['main_color'] . ';
		}

		.title-block,
		.button1:hover,
		.button4:hover,
		.button5:hover,
		.button2,
		#submit,
		.button3,
		.button6,
		#footer .button1,
		.page-content table th,
		.event-month,
		.key-selected-icon,
		.dark-notice,
		.booking-main input[type="submit"],
		.home-reservation-box input[type="submit"],
		.widget-reservation-box input[type="submit"],
		.booking-side input[type="submit"],
		.ui-datepicker-calendar tbody tr td a:hover,
		#open_datepicker .ui-datepicker-calendar .dp-highlight .ui-state-default,
		.step-icon-current,
		.pagination-wrapper .selected,
		.pagination-wrapper a:hover,
		.wp-pagenavi .current,
		.wp-pagenavi a:hover,
		.tagcloud a:hover,
		a.button0,
		.more-link,
		.nsu-submit:hover,
		#footer .nsu-submit,
		.nsu-submit:hover,
		#footer .nsu-submit {
			background: ' . $smof_data['main_color'] . ';
		}

		.page-content p a,
		.page-content ol li a {
			color: ' . $smof_data['main_color'] . ';
		}

		.facebook-icon:hover,
		.twitter-icon:hover,
		.pinterest-icon:hover,
		.gplus-icon:hover,
		.linkedin-icon:hover,
		.yelp-icon:hover {
			background-color: ' . $smof_data['main_color'] . ';
		}
		
		.ui-datepicker-calendar tbody tr td.ui-datepicker-unselectable span {
			background: ' . $smof_data['main_color'] . ';
			color: #fff;
		}';
	
	}
	
	if ( $smof_data['main_colorrgba'] ) { 
		$output .= '.slider-caption p.colour-caption {
			background: ' . $smof_data['main_colorrgba'] . ';
		}';
	}

	if ( $smof_data['nav_footer_color'] ) { 
		$output .= '#topbar,
		#slider .home-reservation-box,
		#slider-full .home-reservation-box,
		#footer,
		.mobile-menu-title,
		.mobile-menu-inner,
		.dark-wrapper .text-slider ul li,
		.widget-reservation-box,
		.dark-wrapper,
		.booking-side,
		.booking-main,
		.price-details .deposit,
		.price-details .total,
		.price-details .total-only,
		#ui-datepicker-div,
		.step-icon,
		.lightbox-title,
		#language-selection li li a,
		.room-price-widget .from,
		.room-price-widget .price-detail,
		#lang_sel_footer {
			background: ' . $smof_data['nav_footer_color'] . ';
		}

		.gmap-button,
		.gmap-button:hover,
		.gmap-button-hover,
		.mobile-menu-button,
		.contact_details_list .phone_list:before,
		.contact_details_list .fax_list:before,
		.contact_details_list .email_list:before,
		.contact_details_list .address_list:before {
			background-color: ' . $smof_data['nav_footer_color'] . ';
		}

		.contact_details_list_dark .phone_list:before,
		.contact_details_list_dark .fax_list:before,
		.contact_details_list_dark .email_list:before {
			background-color: #fff !impoortant;
		}

		.ui-datepicker-calendar tbody tr td a,
		#open_datepicker .ui-datepicker-calendar .ui-datepicker-unselectable .ui-state-default,
		.ui-datepicker-calendar tbody tr td.ui-datepicker-unselectable span {
			border-color: ' . $smof_data['nav_footer_color'] . ';
		}';
	}

	if ( $smof_data['nav_footer_border'] ) { 
		$output .= '.dark-wrapper .blog-entry-inner h4 span,
		.dark-wrapper .event-entry-inner h4 span,
		.booking-side ul li span,
		.room-list-right .room-meta li span,
		.room-price .price,
		.price-breakdown-display span,
		.dark-wrapper .testimonial-author,
		.price-details .deposit,
		.price-details .total,
		.price-details .total-only,
		.contact_details_list_dark li strong,
		.room-price-widget .from,
		.room-price-widget .price-detail,
		#footer .tweets li span,
		#footer .tweets li a {
			color: ' . $smof_data['nav_footer_border'] . ';
		}

		.key-available-icon,
		.key-unavailable-icon,
		.price-details .total-line,
		.ui-datepicker-calendar tbody tr td a {
			background: ' . $smof_data['nav_footer_border'] . ';
		}

		.dark-wrapper .blog-entry-inner h4 span,
		.dark-wrapper .event-entry-inner h4 span,
		.room-list-wrapper .room-item,
		.price-breakdown-open,
		.dark-wrapper .title-style1,
		.space7,
		.space8,
		.booking-side ul li,
		.price-details,
		.ui-datepicker-calendar thead tr th,
		#language-selection li li a,
		.price-details .price-breakdown,
		#open_datepicker .ui-datepicker-group-first,
		.contact_details_list_dark li,
		.room-price-widget,
		.dark-wrapper .testimonial-wrapper,
		#footer-bottom,
		#lang_sel_footer {
			border-color: ' . $smof_data['nav_footer_border'] . ';
		}

		#footer-bottom ul li span {
			color: ' . $smof_data['nav_footer_border'] . ';
		}

		#language-selection li li a:hover {
			background: ' . $smof_data['nav_footer_border'] . ';
		}

		#open_datepicker .ui-datepicker-calendar .ui-datepicker-unselectable .ui-state-default {
			background: #292929;
			color: ' . $smof_data['nav_footer_border'] . ';
		}';
	}
	
	if ( $smof_data['dp_unavailable_background'] ) { 
		$output .= '.key-unavailable-icon, #open_datepicker .ui-datepicker-calendar .ui-datepicker-unselectable .ui-state-default, .ui-datepicker-calendar tbody tr td.ui-datepicker-unselectable span {
			background: ' . $smof_data['dp_unavailable_background'] . ';
		}';
	}
	
	if ( $smof_data['dp_unavailable_color'] ) { 
		$output .= '.key-unavailable-icon, #open_datepicker .ui-datepicker-calendar .ui-datepicker-unselectable .ui-state-default, .ui-datepicker-calendar tbody tr td.ui-datepicker-unselectable span {
			color: ' . $smof_data['dp_unavailable_color'] . ';
		}';
	}
	
	if ( $smof_data['dp_available_background'] ) { 
		$output .= '.key-available-icon, .ui-datepicker-calendar tbody tr td a, #open_datepicker .ui-datepicker-calendar a {
			background: ' . $smof_data['dp_available_background'] . ';
		}';
	}
	
	if ( $smof_data['dp_available_color'] ) { 
		$output .= '.key-available-icon, .ui-datepicker-calendar tbody tr td a, #open_datepicker .ui-datepicker-calendar a, #ui-datepicker-div a {
			color: ' . $smof_data['dp_available_color'] . ';
		}';
	}
	
	if ( $smof_data['dp_selected_background'] ) { 
		$output .= '.key-selected-icon, .ui-datepicker-calendar tbody tr td a:hover, #open_datepicker .ui-datepicker-calendar .dp-highlight .ui-state-default {
			background: ' . $smof_data['dp_selected_background'] . ';
		}';
	}
	
	if ( $smof_data['dp_selected_color'] ) { 
		$output .= '.key-selected-icon, .ui-datepicker-calendar tbody tr td a:hover, #open_datepicker .ui-datepicker-calendar .dp-highlight .ui-state-default,
		#ui-datepicker-div a:hover {
			color: ' . $smof_data['dp_selected_color'] . ';
		}';
	}	

	$output .= '</style>';
	
  return $output;
	
}



/* -------------------------------------------------------
	Remove width / height attributes from gallery images
------------------------------------------------------- */

add_filter('wp_get_attachment_link', 'remove_img_width_height', 10, 1);
add_filter('wp_get_attachment_image_attributes', 'remove_img_width_height', 10, 1);

function remove_img_width_height($html) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}



/* ------------------------------------------------
	Remove rel attribute from the category list
------------------------------------------------ */

function remove_category_list_rel($output)
{
  $output = str_replace(' rel="category"', '', $output);
  return $output;
}
add_filter('wp_list_categories', 'remove_category_list_rel');
add_filter('the_category', 'remove_category_list_rel');



/* -----------------------------------------------------
	Remove <p> / <br> tags from nested shortcode tags
----------------------------------------------------- */

add_filter('the_content', 'shortcode_fix');
function shortcode_fix($content)
{   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );

    $content = strtr($content, $array);

	return $content;
}



/* ------------------------------------------------
	Excerpt Length
------------------------------------------------ */

function print_excerpt($length) {
	global $post;
	$text = $post->post_excerpt;
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
	}
	$text = strip_shortcodes($text); 
	$text = strip_tags($text);

	$text = substr($text,0,$length);
	$excerpt = reverse_strrchr($text, '.', 1);
	if( $excerpt ) {
		echo apply_filters('the_excerpt',$excerpt);
	} else {
		echo apply_filters('the_excerpt',$text);
	}
}

function reverse_strrchr($haystack, $needle, $trail) {
    return strrpos($haystack, $needle) ? substr($haystack, 0, strrpos($haystack, $needle) + $trail) : false;
}



/* ------------------------------------------------
	Excerpt More Link
------------------------------------------------ */

function qns_continue_reading_link() {
		return '';
}

function qns_auto_excerpt_more( $more ) {
	return qns_continue_reading_link();
}
add_filter( 'excerpt_more', 'qns_auto_excerpt_more' );



/* ------------------------------------------------
	The Title
------------------------------------------------ */

function qns_filter_wp_title( $title, $separator ) {
	
	if ( is_feed() )
		return $title;

	global $paged, $page;

	if ( is_search() ) {
		$title = sprintf( __( 'Search results for %s', 'qns' ), '"' . get_search_query() . '"' );
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'qns' ), $paged );
		$title .= " $separator " . home_url( 'name', 'display' );
		return $title;
	}

	$title .= get_bloginfo( 'name', 'display' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'qns' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'qns_filter_wp_title', 10, 2 );



/* ------------------------------------------------
	Content ID/Class
------------------------------------------------ */

function content_id_class( $position ) {
	
	global $smof_data; //fetch options stored in $smof_data
	
	if ( $smof_data['sidebar_position'] ) { 
		
		$position = $smof_data['sidebar_position'];
		
		if ( $position == 'left' ) {
			$output = 'main-content right-main-content';
		} elseif ( $position == 'right' ) {
			$output = 'main-content left-main-content';
		} elseif ( $position == 'none' ) {
			$output = 'main-content full-width';
		}
	
	}

	else { 
		$output = 'main-content left-main-content';
	}
	
	return $output;

}



/* ------------------------------------------------
	Main Menu Fallback
------------------------------------------------ */

function wp_page_menu_qns() { ?>

<ul id="navigation">
	<?php wp_list_pages(array(
		'depth' => 2,
		'exclude' => '',
		'title_li' => '',
		'link_before'  => '<strong>',
		'link_after'   => '</strong>',
		'sort_column' => 'post_title',
		'sort_order' => 'ASC',
	)); ?>
</ul>

<?php }



/* ------------------------------------------------
	Mobile Main Menu Fallback
------------------------------------------------ */

function wp_page_mobile_menu_qns() { ?>

<ul id="mobile-menu">
	<?php wp_list_pages(array(
		'depth' => 2,
		'exclude' => '',
		'title_li' => '',
		'sort_column' => 'post_title',
		'sort_order' => 'ASC',
	)); ?>
</ul>

<?php }



/* ------------------------------------------------
	Password Protected Post Form
------------------------------------------------ */

add_filter( 'the_password_form', 'qns_password_form' );

function qns_password_form() {
	
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$form = '<div class="msg fail clearfix"><p class="nopassword">' . __( 'This post is password protected. To view it please enter your password below', 'qns' ) . '</p></div>
<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post"><label for="' . $label . '">' . __( 'Password', 'qns' ) . ' </label><input name="post_password" id="' . $label . '" class="text_input" type="password" size="20" /><div class="clearboth"></div><input id="submit" type="submit" value="' . esc_attr__( "Submit" ) . '" name="submit"></form>';
	return $form;
	
}



/* ------------------------------------------------
	Page Header
------------------------------------------------ */

function page_header( $url ) {
	
	global $smof_data;
	
	// If custom page header is set
	if ( $url != '' ) {
		$output = 'style="background:url(' . $url . ') #f4f4f4;"';
	}
	
	// If default page header is set and custom header is not set
	elseif ( $smof_data['page_header'] && $url == '' ) {
		$output = 'style="background:url(' . $smof_data['page_header'] . ') #f4f4f4;"';
	}

	else {
		$output = ' style="background:#f4f4f4;"';
	}
		
	return $output;
	
}



/* ------------------------------------------------
	Email Validation
------------------------------------------------ */

function valid_email($email) {
	
	$result = TRUE;
	
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) {
    	$result = FALSE;
	}
  	
	return $result;
	
}



/* ------------------------------------------------
	Add PrettyPhoto for Attached Images
------------------------------------------------ */

add_filter( 'wp_get_attachment_link', 'sant_prettyadd');
function sant_prettyadd ($content) {
     $content = preg_replace("/<a/","<a
rel=\"prettyPhoto[slides]\"",$content,1);
     return $content;
}



/* ------------------------------------------------
	Remove width/height dimensions from <img> tags
------------------------------------------------ */

add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
// CUSTOM ADMIN LOGIN HEADER LOGO
 
function my_custom_login_logo()
{
    echo '<style  type="text/css"> h1 a {  background-image:url(http://www.tukitukicottages.co.nz/wp-content/uploads/2014/01/TukiTukilogo.png)  !important; background-size: 293px 98px !important; width: 293px !important; height: 98px !important; } </style>';
}
add_action('login_head',  'my_custom_login_logo');

