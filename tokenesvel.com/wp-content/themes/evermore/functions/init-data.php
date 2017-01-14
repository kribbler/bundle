<?php
/**
 * This file includes the initialization data for:
 * - Theme options
 * - Custom pages (mosly used for sliders)
 * - Menus
 * - Post Data
 * - Locales and translation
 * - Update notifier
 */

global $pexeto;

/*******************************************************************************
 * INIT OPTIONS
 ******************************************************************************/

if ( !defined( 'PEXETO_OPTIONS_PATH' ) )
	define( 'PEXETO_OPTIONS_PATH', 'options/' );
if ( !defined( 'PEXETO_OPTIONS_KEY' ) )
	define( 'PEXETO_OPTIONS_KEY', PEXETO_SHORTNAME.'_options' );

add_action( 'admin_menu', 'pexeto_add_options_menu' );
add_action( 'init', 'pexeto_init_options', 11 );
add_action( 'admin_notices', 'pexeto_print_options_notices' );
add_action( 'admin_bar_menu', 'pexeto_add_admin_bar_options_link', 1000 );


if ( !function_exists( 'pexeto_init_options_manager' ) ) {

	/**
	 * Inits the Options Manager object. Loads it to the global
	 * $pexeto->options_manager.
	 */
	function pexeto_init_options_manager() {
		global $pexeto;

		$pexeto->options_manager = new PexetoOptionsManager(
			PEXETO_OPTIONS_KEY,
			PEXETO_THEMENAME,
			PEXETO_IMAGES_URL,
			PEXETO_VERSION );
		$pexeto->options = $pexeto->options_manager->get_options_obj();
	}
}

pexeto_init_options_manager();


if ( !function_exists( 'pexeto_add_options_menu' ) ) {

	/**
	 * Add the main theme options page to the menu.
	 */
	function pexeto_add_options_menu() {
		global $pexeto;

		add_menu_page(
			PEXETO_THEMENAME,
			PEXETO_THEMENAME,
			'edit_theme_options',
			PEXETO_OPTIONS_PAGE,
			array( $pexeto->options_manager, 'print_options_page' ),
			PEXETO_LIB_URL.'/images/pex_icon.png' );

		add_submenu_page(
			PEXETO_OPTIONS_PAGE,
			PEXETO_THEMENAME.' Options',
			PEXETO_THEMENAME.' Options',
			'edit_theme_options',
			PEXETO_OPTIONS_PAGE,
			array( $pexeto->options_manager, 'print_options_page' ) );
	}
}

if ( !function_exists( 'pexeto_add_admin_bar_options_link' ) ) {

	/**
	 * Adds a link to the Theme Options page in the admin bar.
	 */
	function pexeto_add_admin_bar_options_link() {
		if ( current_user_can( 'edit_theme_options' ) ) {
			global $wp_admin_bar;
			$wp_admin_bar->add_menu( array( 'id' => 'pexeto_options',
					'title' =>PEXETO_THEMENAME.' Options',
					'href' => admin_url( '?page=pexeto_options' ) ) );
		}
	}
}

if ( !function_exists( 'pexeto_init_options' ) ) {

	/**
	 * Inits the options functionality. Loads the options files which will load
	 * the option fields to the global $pexeto->options object.
	 */
	function pexeto_init_options() {
		global $pexeto;

		//load the files that contain the options
		$options_files=array( 'general', 'posts', 'sliders', 'styles',
			'media', 'translation', 'documentation' );
		foreach ( $options_files as $file ) {
			require_once PEXETO_OPTIONS_PATH.$file.'.php';
		}

		$pexeto->options->init();

	}
}


if ( !function_exists( 'pexeto_print_options_notices' ) ) {

	/**
	 * Prints the admin notices in the options page. Prints a notice when there
	 * is a new update of the theme available.
	 */
	function pexeto_print_options_notices() {
		global $pexeto;

		//print the update message if there is a new update available
		if ( isset( $_GET['page'] )
			&& $_GET['page']==PEXETO_OPTIONS_PAGE
			&& isset( $pexeto->update_notifier )
			&& $pexeto->update_notifier->is_new_version_available() ) {
			$pexeto->update_notifier->print_update_notification_message( true );
		}
	}
}

/*******************************************************************************
 * INIT CUSTOM PAGES
 * Custom pages are pages containing custom Pexeto functionality that allows you
 * easily add and manage custom post instances. For example, they are mostly used
 * for sliders where you can add quickly add images to the slider or create sets
 * of different sliders.
 ******************************************************************************/

//define the main constants that will be used
if ( !defined( 'PEXETO_NIVOSLIDER_POSTTYPE' ) )
	define( 'PEXETO_NIVOSLIDER_POSTTYPE', 'pexnivoslider' );
if ( !defined( 'PEXETO_CONTENTSLIDER_POSTTYPE' ) )
	define( 'PEXETO_CONTENTSLIDER_POSTTYPE', 'pexcontentslider' );
if ( !defined( 'PEXETO_THUMBSLIDER_POSTTYPE' ) )
	define( 'PEXETO_THUMBSLIDER_POSTTYPE', 'pexthumblider' );
if ( !defined( 'PEXETO_SERVICES_POSTTYPE' ) )
	define( 'PEXETO_SERVICES_POSTTYPE', 'pexservice' );
if ( !defined( 'PEXETO_SLIDER_TYPE' ) )
	define( 'PEXETO_SLIDER_TYPE', 'slider' );
if ( !defined( 'PEXETO_CUSTOM_PREFIX' ) )
	define( 'PEXETO_CUSTOM_PREFIX', PexetoCustomPageManager::custom_prefix );

if ( !function_exists( 'pexeto_define_custom_pages' ) ) {

	/**
	 * Defines all the custom pafes that will be used in the theme. Loads them
	 * into the global $pexeto->custom_pages.
	 */
	function pexeto_define_custom_pages() {
		global $pexeto;

		//define the custom pages - this is the main array that defines the structure of each of the custom pages
		$pexeto->custom_pages=array( PEXETO_NIVOSLIDER_POSTTYPE=>
			new PexetoCustomPage( PEXETO_NIVOSLIDER_POSTTYPE, array(
					array( 'id'=>'image_url', 'type'=>'upload', 'name'=>'Image URL', 'required'=>true ),
					array( 'id'=>'image_link', 'type'=>'text', 'name'=>'Image Link' ),
					array( 'id'=>'description', 'type'=>'textarea', 'name'=>'Image Description' )
				), 'Nivo Slider', true, PEXETO_OPTIONS_PAGE, 'image_url', PEXETO_SLIDER_TYPE, 'slider-nivo.php', true ),

			PEXETO_THUMBSLIDER_POSTTYPE=>
			new PexetoCustomPage( PEXETO_THUMBSLIDER_POSTTYPE, array(
					array( 'id'=>'image_url', 'type'=>'upload', 'name'=>'Image URL', 'required'=>true ),
					array( 'id'=>'image_link', 'type'=>'text', 'name'=>'Image Link' ),
					array( 'id'=>'description', 'type'=>'textarea', 'name'=>'Image Description' )
				), 'Thumbnail Slider', true, PEXETO_OPTIONS_PAGE, 'image_url', PEXETO_SLIDER_TYPE, 'slider-thumbnail.php', true ),

			PEXETO_CONTENTSLIDER_POSTTYPE=>
			new PexetoCustomPage( PEXETO_CONTENTSLIDER_POSTTYPE, array(
					array( 'id'=>'image_url', 'type'=>'upload', 'name'=>'Image URL', 'required'=>true ),
					array( 'id'=>'small_title', 'type'=>'text', 'name'=>'Small Title' ),
					array( 'id'=>'main_title', 'type'=>'text', 'name'=>'Main Title' ),
					array( 'id'=>'description', 'type'=>'textarea', 'name'=>'Description' ),
					array( 'id'=>'but_one_text', 'type'=>'text', 'name'=>'Button one text', 'two-column'=>'first' ),
					array( 'id'=>'but_one_link', 'type'=>'text', 'name'=>'Button one link', 'two-column'=>'last' ),
					array( 'id'=>'but_two_text', 'type'=>'text', 'name'=>'Button two text', 'two-column'=>'first' ),
					array( 'id'=>'but_two_link', 'type'=>'text', 'name'=>'Button two link', 'two-column'=>'last' )
				), 'Content Slider', true, PEXETO_OPTIONS_PAGE, 'image_url', PEXETO_SLIDER_TYPE, 'slider-content.php', true ),

			PEXETO_SERVICES_POSTTYPE=>
			new PexetoCustomPage( PEXETO_SERVICES_POSTTYPE, array(
					array( 'id'=>'box_title', 'type'=>'text', 'name'=>'Title', 'required'=>true ),
					array( 'id'=>'box_image', 'type'=>'upload', 'name'=>'Image URL' ),
					array( 'id'=>'box_link', 'type'=>'text', 'name'=>'Link' ),
					array( 'id'=>'box_desc', 'type'=>'textarea', 'name'=>'Description' )
				), 'Services Boxes', true, PEXETO_OPTIONS_PAGE, 'box_image', 'data', '', false, 'Services Box Set' ),
		);
	}
}

pexeto_define_custom_pages();


/*******************************************************************************
 * INIT MENUS
 ******************************************************************************/

add_action( 'init', 'pexeto_register_menus' );
add_theme_support( 'menus' );


if ( !function_exists( 'pexeto_register_menus' ) ) {
	/**
	 * Register the main menu for the theme.
	 */
	function pexeto_register_menus() {
		register_nav_menus(
			array(
				'pexeto_main_menu' => __( PEXETO_THEMENAME.' Theme Main Menu' ),
				'pexeto_footer_menu' => __( PEXETO_THEMENAME.' Theme Footer Menu' )
			) );
	}
}


if ( !function_exists( 'pexeto_no_menu' ) ) {
	/**
	 * Displays some directions in the main menu section when a menu has not be
	 * created and set.
	 */
	function pexeto_no_menu() {
		echo 'Go to Appearance &raquo; Menus to create and set a menu';
	}
}

if ( !function_exists( 'pexeto_no_footer_menu' ) ) {

	/**
	 * Callback for an empty footer menu. Does not display anything.
	 */
	function pexeto_no_footer_menu() {
		return;
	}
}


/*******************************************************************************
 * INIT POST DATA
 ******************************************************************************/

//add custom post formats support
add_theme_support( 'post-formats', array( 'gallery', 'video', 'aside', 'quote' ) );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
add_action( 'init', 'pexeto_set_image_sizes' , 12);
if ( ! isset( $content_width ) ) $content_width = 980;


if ( !function_exists( 'pexeto_set_image_sizes' ) ) {

	/**
	 * Sets the predefined image sizes for the theme that WordPress will crop
	 * the images to when uploading an image.
	 */
	function pexeto_set_image_sizes() {
		global $pexeto, $pexeto_content_sizes;

		$img_size = pexeto_option( 'blog_image_size' );
		$img_size_full = pexeto_option( 'full_blog_image_size' );

		//standard blog layout featured image size
		add_image_size(
			'post-box-img',
			$img_size['width'],
			$img_size['height'],
			true );

		//full-width blog layout featured image size
		add_image_size(
			'post-box-img-full',
			$img_size_full['width'],
			$img_size_full['height'],
			true );

		//static header image size
		add_image_size(
			'static-header-img',
			$pexeto_content_sizes['container'],
			$pexeto_content_sizes['header-height'],
			true );
	}
}


/*******************************************************************************
 * LOCALE AND TRANSLATION
 ******************************************************************************/

load_theme_textdomain( 'pexeto', get_template_directory() . '/lang' );


/*******************************************************************************
 * UPDATE NOTIFIER
 ******************************************************************************/

// Set the remote notifier XML file containing the latest version of the theme and changelog
if ( !defined( 'PEXETO_UPDATE_XML_FILE' ) )
	define( 'PEXETO_UPDATE_XML_FILE', 'http://pexeto.com/updates/evermore.xml' );
// Set the time interval for the remote XML cache in the database (21600 seconds = 6 hours)
if ( !defined( 'PEXETO_UPDATE_CACHE_INTERVAL' ) )
	define( 'PEXETO_UPDATE_CACHE_INTERVAL', 21600 );
if ( !defined( 'PEXETO_UPDATE_PAGE_NAME' ) )
	define( 'PEXETO_UPDATE_PAGE_NAME', 'pexeto_update' );

if ( !function_exists( 'pexeto_init_update_notfier' ) ) {
	function pexeto_init_update_notfier() {
		global $pagenow, $pexeto;
		if ( is_admin() && $pagenow!='update-core.php' ) {
			$pexeto->update_notifier = new PexetoUpdateNotifier(
				PEXETO_THEMENAME,
				PEXETO_SHORTNAME,
				PEXETO_UPDATE_XML_FILE,
				PEXETO_UPDATE_CACHE_INTERVAL,
				PEXETO_UPDATE_PAGE_NAME,
				admin_url().'admin.php?page='.PEXETO_OPTIONS_PAGE
			);
			$pexeto->update_notifier->init();
		}
	}
}

pexeto_init_update_notfier();
