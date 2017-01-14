<?php
/**
 * Plugin Name: Quite Nice Booking
 * Plugin URI: http://quitenicestuff.com
 * Description: A simple hotel booking plugin
 * Version: 2.5.2
 * Author: Quite Nice Stuff
 * Author URI: http://quitenicestuff.com
 * Requires at least: 3.5
 * Tested up to: 3.8.0
 */

// define paths
// if the plugin is a symlink, plugins_url() will not work because __FILE__ resolves to the absolute path
$quitenicebooking_base = __FILE__;
if (isset($mu_plugin)) { // multisite installation
	$quitenicebooking_base = $mu_plugin;
}
if (isset($network_plugin)) { // multisite installation
	$quitenicebooking_base = $network_plugin;
}
if (isset($plugin)) { // standalone installation
	$quitenicebooking_base = $plugin;
}
define('QUITENICEBOOKING_BASE', $quitenicebooking_base);
define('QUITENICEBOOKING_PATH', plugin_dir_path($quitenicebooking_base));
define('QUITENICEBOOKING_URL', plugins_url('/', $quitenicebooking_base));
define('QUITENICEBOOKING_VERSION', '2.52');
define('QUITENICEBOOKING_MAIN_FILE', __FILE__);

require_once 'includes/quitenicebooking.class.php';
$quitenicebooking = new Quitenicebooking();
