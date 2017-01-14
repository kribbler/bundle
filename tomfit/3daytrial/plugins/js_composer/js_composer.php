<?php
/*
Plugin Name: WPBakery Visual Composer
Plugin URI: http://vc.wpbakery.com
Description: Drag and drop page builder for WordPress. Take full control over your WordPress site, build any layout you can imagine – no programming knowledge required.
Version: 4.1.2
Author: Michael M - WPBakery.com
Author URI: http://wpbakery.com
*/

// don't load directly

if (!defined('ABSPATH')) die('-1');

/**
 * Current plugin file directory.
 * var string
 */

$dir = dirname(__FILE__);

if (!defined('VC_THEME_DIR')) define('VC_THEME_DIR', get_theme_root());

global $vc_as_theme, $vc_is_inline, $vc_is_editor;
$vc_is_inline = $vc_is_editor = null;
$vc_as_theme = preg_match('/'.preg_quote(str_replace('\\','/',VC_THEME_DIR), '/').'/', str_replace('\\','/',$dir));
if( !$vc_as_theme && is_file(get_template_directory() . '/wpbakery/js_composer/js_composer.php') ) {
    // Load from theme
} else {
    // {{{ constants

    /**
     * Current visual composer version
     */

    if (!defined('WPB_VC_VERSION')) define('WPB_VC_VERSION', '4.1.2');

    /**
     * jQuery UI version
     */

    if (!defined('WPB_JQUERY_UI_VERSION')) define('WPB_JQUERY_UI_VERSION', 'less');

    // }}}

    /**
     * Define default settings for visual composer.
     *
     * APP_ROOT - plugin directory.
     * WP_ROOT - Wordpress application root directory.
     * APP_DIR - plugin directory name.
     * CONFIG - configuration directory.
     * ASSETS_DIR  - directory name for assets. Used from urls creating.
     * COMPOSER      => main visual composer directory.
     * COMPOSER_LIB  => libraries for composer.
     * SHORTCODES_LIB  => Shortcodes directory.
     *
     * @var array
     */
    global $composer_settings;
    if(!isset($composer_settings)) {

        $composer_settings = Array(
            'APP_ROOT'      => $dir . '/',
            'WP_ROOT'       => dirname( dirname( dirname( dirname($dir ) ) ) ). '/',
            'APP_DIR'       => basename( $dir ) . '/',
            'CONFIG'        => $dir . '/config/',
            'ASSETS_DIR'    => 'assets/',
            'COMPOSER'      => $dir . '/composer/',
            'COMPOSER_LIB'  => $dir . '/composer/lib/',
            'SHORTCODES_LIB'=> $dir . '/composer/lib/shortcodes/',
            'USER_DIR_NAME'      => 'vc_templates',
            /* Default post type where to activate visual composer meta box settings */
            'default_post_types' => Array('page')
        );
    }
    /**
     * Setup locale.
     */
    if($vc_as_theme) {
        load_theme_textdomain('js_composer', get_template_directory() . '/wpbakery/js_composer/theme_locale');
    } else {
        load_plugin_textdomain( 'js_composer', false,  $composer_settings['APP_DIR'].'locale/' );
    }
    /*
     * Here we include all useful files
     */

    require_once( $composer_settings['COMPOSER'] . 'include.php' );

    /*
     * Include visual composer builders.
     * class WPBakeryVisualComposerSetupAdmin - for admin panel
     * class WPBakeryVisualComposerSetup - for frontend
     */
    require_once( $composer_settings['COMPOSER_LIB'] . 'build.php' );
    /**
     * Setting file for layouts and shortcodes
     */

    require_once( $composer_settings['CONFIG'] . 'map.php' );


    /**
     * Initialize plugin depending on admin panel or public layout
     * @var object
     */
    global $wpVC_setup;
    $wpVC_setup = is_admin() ? new WPBakeryVisualComposerSetupAdmin() : new WPBakeryVisualComposerSetup();
    if(!$vc_as_theme) {
        $wpVC_setup->init($composer_settings);
    }
}
?>