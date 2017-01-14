<?php
/**
 * Uninstalls the plugin
 *
 * Deletes options, and optionally, deletes custom posts and drops bookings table
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

global $wpdb;

// check whether to wipe data during uninstall
$settings = get_option('quitenicebooking');
$wipe = !empty($settings['uninstall_wipe']) ? TRUE : FALSE;

// delete options
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE 'quitenicebooking%'");

// delete user meta
$user_ids = get_users(array('fields' => 'ID'));
foreach ($user_ids as $id) {
	delete_user_meta($id, 'quitenicebooking_ignore_install_pages_notice');	
}

if ($wipe) {
	// delete accommodations
	$accommodation_post_ids = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'accommodation'", ARRAY_A);
	foreach ($accommodation_post_ids as $id) {
		wp_delete_post($id['ID']);
	}

	// delete bookings
	$booking_post_ids = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'booking'", ARRAY_A);
	foreach ($booking_post_ids as $id) {
		wp_delete_post($id['ID']);
	}

	// drop bookings table
	$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}qns_bookings");
}
