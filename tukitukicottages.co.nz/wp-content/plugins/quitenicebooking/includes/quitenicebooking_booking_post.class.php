<?php
/**
 * Quitenicebooking_Booking_Post type class
 *
 * This class encapsulates the Booking post type
 *
 * @package quitenicebooking
 * @author Quite Nice Stuff
 * @copyright Copyright (c) 2013 Quite Nice Stuff
 * @link http://quitenicestuff.com
 * @version 2.5.0
 * @since 2.0.0
 */

class Quitenicebooking_Booking_Post {
	/**
	 * Properties ==============================================================
	 */
	
	/**
	 * @var array The global plugin settings
	 */
	public $settings;
	
	/**
	 * @var array The names of the meta fields attached to each Booking post
	 */
	public $meta_fields;
	
	/**
	 * @var array An array of booking collisions
	 */
	protected $collisions;
	
	/**
	 * @var array The meta extracted for a single post
	 */
	protected $post_meta;
	
	/**
	 * @var Quitenicebooking_Accommodation_Post An instance of the accommodation post class
	 */
	public $accommodation_post;

	/**
	 * @var Quitenicebooking_Premium_Booking_Block_Post_Type An instance of the blocking class
	 */
	public $booking_block;

	/**
	 * Constructor
	 *
	 * Registers post type, actions, filters, shortcodes, languages, scripts
	 *
	 * @params array $settings An array, required to have date_format and date_format_strings
	 */
	public function __construct() {
		// custom post type
		add_action('init', array($this, 'register_post_type'));
		// initialize the class
		add_action('init', array($this, 'init'));
		// hook meta boxes
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
		// hook save
		add_action('save_post', array($this, 'save_meta'));
		// hook delete
		add_action('delete_post', array($this, 'delete_meta'));
		// enqueue scripts
		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
		// instantite booking_block class, if available
		if (class_exists('Quitenicebooking_Premium_Booking_Block_Post_Type')) {
			$this->booking_block = new Quitenicebooking_Premium_Booking_Block_Post_Type();
		}
	}
	
	/**
	 * Initializes the class.  This should be called after $this->settings has been set
	 */
	public function init() {
		// initialize meta fields
		$this->meta_fields = array(
			'quitenicebooking_booking_id',				// int
			'quitenicebooking_guest_last_name',			// string
			'quitenicebooking_guest_first_name',		// string
			'quitenicebooking_guest_email',				// string
			'quitenicebooking_guest_details',			// json string
			'quitenicebooking_deposit_amount',			// float
			'quitenicebooking_deposit_paid',				// string (datetime)
			'quitenicebooking_total_price',				// float
			'quitenicebooking_special_requirements',		// string
			'quitenicebooking_deposit_method',
			'quitenicebooking_deposit_status'
		);
		
		if (is_object($this->booking_block)) {
			$this->booking_block->settings = $this->settings;
			$this->booking_block->accommodations = $this->accommodation_post->get_all_accommodations(TRUE);
		}

		if (class_exists('Quitenicebooking_Premium_Coupon_Post_Type')) {
			$this->meta_fields[] = 'quitenicebooking_coupon_codes';
		}

		// DEBUG
//		add_shortcode('booking_debug', array($this, 'booking_debug_shortcode'));
	}
	
	/**
	 * Enqueues scripts
	 */
	public function admin_enqueue_scripts() {
		global $post;
		if (is_object($post) && get_post_type($post->ID) == 'booking') {
			wp_enqueue_script('jquery-ui-datepicker');
			wp_register_script('quitenicebooking-booking-admin', QUITENICEBOOKING_URL.'assets/js/admin/booking_meta.js');
			wp_enqueue_script('quitenicebooking-booking-admin');
			// pass date format strings
			$beds = new Quitenicebooking_Beds();
			wp_localize_script('quitenicebooking-booking-admin', 'quitenicebooking', array(
				'date_format' => $this->settings['date_format_strings'][$this->settings['date_format']]['display'],
				'js_date_format' => $this->settings['date_format'],
				'all_rooms' => $this->get_all_rooms(TRUE),
				'bed_types' => $beds->keys['beds'],
				'num_rooms' => isset( $this->post_meta['quitenicebooking_num_rooms'] ) ? $this->post_meta['quitenicebooking_num_rooms'] : 0,
				'ajax_url' => admin_url( 'admin-ajax.php', isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://' ),
				'post_id' => $post->ID,
				'assets_url' => QUITENICEBOOKING_URL.'assets/'
			));
			wp_register_style('quitenicebooking-booking-admin', QUITENICEBOOKING_URL.'assets/css/admin/booking_meta.css');
			wp_enqueue_style('quitenicebooking-booking-admin');
		}
	}
	
	/**
	 * Registers the Booking post type
	 */
	public function register_post_type() {
		register_post_type('booking',
			array(
				'labels'		=> array(
					'name'			=> __('Bookings', 'quitenicebooking'),
					'singular_name'	=> __('Booking', 'quitenicebooking'),
					'add_new'		=> _x('Add New', 'booking', 'quitenicebooking'),
					'add_new_item'	=> __('Add New Booking', 'quitenicebooking'),
				),
				'public'		=> TRUE,
				'menu_icon'		=> 'dashicons-screenoptions',
				'menu_position'	=> 5, // below Posts
				'rewrite'		=> array(
					'slug'			=> __('booking', 'quitenicebooking'),
				),
				'supports'		=> array('title'),
			)
		);
	}

	/**
	 * Adds the Booking meta boxes
	 */
	public function add_meta_boxes() {
		$this->get_booking_meta();
		add_meta_box(
			'booking_details_meta', // id
			__('Booking Details', 'quitenicebooking'), // title
			array($this, 'show_details_meta_box'), // callback
			'booking', // post_type
			'normal' // context
		);
		add_meta_box(
			'booking_payment_meta', // id
			__('Payment Details', 'quitenicebooking'), // title
			array($this, 'show_payment_meta_box'), // callback
			'booking', // post_type
			'normal' // context
		);
		add_meta_box(
			'booking_rooms_meta', // id
			__('Rooms', 'quitenicebooking'), // title
			array($this, 'show_rooms_meta_box'), // callback
			'booking', // post_type
			'normal' // context
		);
	}
	
	/**
	 * Reads the Booking meta into $this->post_meta
	 * 
	 * @global WP_Post $post The WP post object
	 * @global WPDB $wpdb
	 */
	public function get_booking_meta() {
		global $post, $wpdb;
		$this->post_meta = get_post_meta($post->ID);
		// extract all values out of $this->post_meta so they're not in arrays
		foreach ($this->post_meta as &$p) {
			$p = $p[0];
		}
		unset($p);
		
		// get the room bookings from the database
		$room_bookings = $wpdb->get_results($wpdb->prepare(
			"SELECT * FROM {$wpdb->prefix}qns_bookings WHERE post_id = %d GROUP BY room_booking_id",
			$post->ID
		), ARRAY_A);
		// count number of rooms in booking
		$this->post_meta['quitenicebooking_num_rooms'] = count($room_bookings);
		
		// extract the room booking into variables
		for ($n = 1; $n <= count($room_bookings); $n ++) {
			$this->post_meta["quitenicebooking_room_booking_{$n}_checkin"] = date($this->settings['date_format_strings'][$this->settings['date_format']]['php_short'], strtotime($room_bookings[$n-1]['checkin']));
			$this->post_meta["quitenicebooking_room_booking_{$n}_checkout"] = date($this->settings['date_format_strings'][$this->settings['date_format']]['php_short'], strtotime($room_bookings[$n-1]['checkout']));
			$this->post_meta["quitenicebooking_room_booking_{$n}_type"] = $room_bookings[$n-1]['type'];
			$this->post_meta["quitenicebooking_room_booking_{$n}_bed"] = $room_bookings[$n-1]['bed'];
			$this->post_meta["quitenicebooking_room_booking_{$n}_adults"] = $room_bookings[$n-1]['adults'];
			$this->post_meta["quitenicebooking_room_booking_{$n}_children"] = $room_bookings[$n-1]['children'];
		}
	}
	
	/**
	 * Displays the Details meta box
	 */
	public function show_details_meta_box() {
		extract($this->post_meta, EXTR_OVERWRITE);
		$form_fields = Quitenicebooking_Utilities::decode_reservation_form($this->settings);
		include QUITENICEBOOKING_PATH.'views/admin/booking_details_meta.htm.php';
	}
	
	/**
	 * Displays the Payment meta box
	 */
	public function show_payment_meta_box() {
		$quitenicebooking_currency_unit = $this->settings['currency_unit'];
		if (class_exists('Quitenicebooking_Premium_Coupon_Post_Type')) {
			$quitenicebooking_coupons_enabled = TRUE;
		}
		extract($this->post_meta, EXTR_OVERWRITE);
		include QUITENICEBOOKING_PATH.'views/admin/booking_payment_meta.htm.php';
	}
	
	/**
	 * Displays the Rooms meta box
	 */
	public function show_rooms_meta_box() {
		$quitenicebooking_all_rooms = $this->get_all_rooms(TRUE);
		$quitenicebooking_beds = new Quitenicebooking_Beds();
		extract($this->post_meta, EXTR_OVERWRITE);
		include QUITENICEBOOKING_PATH.'views/admin/booking_rooms_meta.htm.php';
	}

	/**
	 * Get all rooms and consolidate if WPML is enabled
	 *
	 * @param boolean $strip Strip out extraneous data
	 * @return array An array of all rooms
	 */
	public function get_all_rooms($strip = FALSE) {
		$all_rooms = $this->accommodation_post->get_all_accommodations(TRUE);
		if ($strip) {
			// remove extraneous data to reduce payload size
			foreach ($all_rooms as &$room) {
				foreach ($room as $k => $r) {
					if (!preg_match('/^id$|^title$|(?:^quitenicebooking_beds_.+)/', $k)) {
						unset($room[$k]);
					}
				}
			}
			unset($room);
		}
		// consolidate all_rooms if WPML is enabled
		if (defined('ICL_SITEPRESS_VERSION')) {
			global $sitepress;
			foreach ($all_rooms as &$room) {
				// get the trid
				$trid = $sitepress->get_element_trid($room['id'], 'post_accommodation');
				// get all the translations
				$translations = $sitepress->get_element_translations($trid, 'post_accommodation');
				foreach ($translations as $t) {
					if (isset($all_rooms[$t->element_id]) && $room['id'] != $t->element_id) {
						// append the translated room's title to this room's title, and then remove it from the list
						$room['title'] .= ' ('.$all_rooms[$t->element_id]['title'].')';
						unset($all_rooms[$t->element_id]);
					}
				}
			}
			unset($room);
		}
		return $all_rooms;
	}
	
	/**
	 * Saves the Booking metadata
	 *
	 * @param int $post_id The ID of the post
	 * @global WPDB $wpdb
	 */
	public function save_meta($post_id) {
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		
		// check whether this is a booking post type
		if (!isset($_REQUEST['post_type']) || $_REQUEST['post_type'] != 'booking') {
			return;
		}
		
		// check permissions
		if (!current_user_can('edit_post', $post_id)) {
			return;
		}

		// check if it is submitted by quick edit form
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'inline-save') {
			return;
		}

		// TODO verify nonce
		
		// TODO field validation
		// if validation fails, set the publish status to "draft"
		
		// count the number of checkins
		$num_rooms = 0;
		foreach ($_REQUEST as $key => $value) {
			if (preg_match('/quitenicebooking_room_booking_\d+_checkin/', $key)) {
				$num_rooms ++;
			}
		}
		
		// convert date fields to unix
		for ($n = 1; $n <= $num_rooms; $n ++) {
			$_REQUEST["quitenicebooking_room_booking_{$n}_checkin"] = Quitenicebooking_Utilities::to_timestamp($_REQUEST["quitenicebooking_room_booking_{$n}_checkin"], $this->settings);
			$_REQUEST["quitenicebooking_room_booking_{$n}_checkout"] = Quitenicebooking_Utilities::to_timestamp($_REQUEST["quitenicebooking_room_booking_{$n}_checkout"], $this->settings);
			// TODO don't modify $_REQUEST...
		}
		
		// add/update metadata
		foreach ($this->meta_fields as $m) {
			if (isset($_REQUEST[$m])) {
				update_post_meta($post_id, $m, sanitize_text_field($_REQUEST[$m]));
			}
		}
		// add/update form fields
		// first check whether the post values are present
//		if (strpos(implode(array_keys($_REQUEST)), 'quitenicebooking_guest_details_') !== FALSE) {
		if (in_array('quitenicebooking_guest_fields', array_keys($_REQUEST))) {
			// form fields are wholly dependent on what's present in the form, since there could be orphaned values not in the current settings
			// read the configuration data
			$form_fields = json_decode(base64_decode($_REQUEST['quitenicebooking_guest_fields']), TRUE);
//			$form_fields = json_decode($this->settings['reservation_form'], TRUE);
			$guest_details = array();
			foreach ($form_fields as $key => $field) {
//				if (in_array($field['type'], array('guest_first_name', 'guest_last_name', 'guest_email'))) {
//					continue;
//				}
				$guest_details[$key]['label'] = $field['label'];
				$guest_details[$key]['value'] = $_REQUEST['quitenicebooking_guest_details_'.$key];
				$guest_details[$key]['type'] = $field['type'];
			}
			update_post_meta($post_id, 'quitenicebooking_guest_details', json_encode($guest_details));
		}

		global $wpdb;
		// save rooms to table
		// first, delete all existing rooms for this post
		$wpdb->delete("{$wpdb->prefix}qns_bookings", array(
			'post_id' => $post_id
		));
		// insert each room
		for ($n = 1; $n <= $num_rooms; $n ++) {
			if (defined('ICL_SITEPRESS_VERSION')) {
				global $sitepress;
				// get the trid (group) of the accommodation
				$trid = $sitepress->get_element_trid($_REQUEST["quitenicebooking_room_booking_{$n}_type"], 'post_accommodation');
				// find all translations of the accommodation
				$accommodation_translations = $sitepress->get_element_translations($trid, 'post_accommodation');
				// add a db row for each of the translations
				foreach ($accommodation_translations as $at) {
					$wpdb->insert("{$wpdb->prefix}qns_bookings", array(
						'post_id' => $post_id,
						'room_booking_id' => $n,
						'checkin' => date('Y-m-d H:i:s', $_REQUEST["quitenicebooking_room_booking_{$n}_checkin"]),
						'checkout' => date('Y-m-d H:i:s', $_REQUEST["quitenicebooking_room_booking_{$n}_checkout"]),
						'type' => $at->element_id,
						'bed' => $_REQUEST["quitenicebooking_room_booking_{$n}_bed"],
						'adults' => $_REQUEST["quitenicebooking_room_booking_{$n}_adults"],
						'children' => $_REQUEST["quitenicebooking_room_booking_{$n}_children"]
					));
				}
			} else {
				$wpdb->insert("{$wpdb->prefix}qns_bookings", array(
					'post_id' => $post_id,
					'room_booking_id' => $n,
					'checkin' => date('Y-m-d H:i:s', $_REQUEST["quitenicebooking_room_booking_{$n}_checkin"]),
					'checkout' => date('Y-m-d H:i:s', $_REQUEST["quitenicebooking_room_booking_{$n}_checkout"]),
					'type' => $_REQUEST["quitenicebooking_room_booking_{$n}_type"],
					'bed' => $_REQUEST["quitenicebooking_room_booking_{$n}_bed"],
					'adults' => $_REQUEST["quitenicebooking_room_booking_{$n}_adults"],
					'children' => $_REQUEST["quitenicebooking_room_booking_{$n}_children"]
				));
			}
		}
		
		// add the post_id as booking_id
		update_post_meta($post_id, 'quitenicebooking_booking_id', $post_id);

	}
	
	/**
	 * Deletes booking database row
	 * 
	 * @global WPDB $wpdb
	 */
	public function delete_meta( $post_id ) {
		global $wpdb;
		$wpdb->delete("{$wpdb->prefix}qns_bookings", array(
			'post_id' => $post_id
		));
	}
	
	/**
	 * Creates a temporary table to hold the existing and live bookings
	 * 
	 * @global WPDB $wpdb
	 */
	public function create_live_bookings_table() {
		global $wpdb;
		
		// the temporary table needs to have the INNER JOIN performed to exclude posts that aren't publihsed
		$wpdb->query(
"CREATE TEMPORARY TABLE IF NOT EXISTS {$wpdb->prefix}qns_live_bookings AS (
SELECT {$wpdb->prefix}qns_bookings.*
FROM {$wpdb->prefix}qns_bookings
INNER JOIN {$wpdb->posts} ON {$wpdb->prefix}qns_bookings.post_id = {$wpdb->posts}.ID
WHERE {$wpdb->posts}.post_status = 'publish'
);");
	}
	
	/**
	 * Adds a temporary booking to pivot table (not saved in main database)
	 *
	 * @param array $args An array of arguments, requiring:
	 *   ['checkin' => // int The checkin date, as a unix timestamp
	 *    'checkout' => // int The checkout date, as a unix timestamp
	 *    'type' => // string The room type
	 *    'bed' => // string The bed type
	 *    'adults' => // int Number of adults
	 *    'children' => // int Number of children
	 *   ]
	 * @global WPDB $wpdb
	 */
	public function add_live_booking($args) {
		global $wpdb;
		$wpdb->insert("{$wpdb->prefix}qns_live_bookings", array(
			'checkin' => date('Y-m-d H:i:s', $args['checkin']),
			'checkout' => date('Y-m-d H:i:s', $args['checkout']),
			'type' => $args['type'],
			'bed' => $args['bed'],
			'adults' => $args['adults'],
			'children' => $args['children'],
			'post_id' => 0,
			'room_booking_id' => 0
		));
	}
	
	/**
	 * Remove room bookings from the pivot table belonging to $post_id
	 * 
	 * The purpose of this function is for when an existing booking is being edited,
	 * its room bookings have to be unset, otherwise the availability checker will find
	 * its room bookings are already booked and the rooms unavailable
	 * 
	 * @param int $post_id
	 */
	public function remove_live_booking($post_id) {
		global $wpdb;
		$wpdb->delete("{$wpdb->prefix}qns_live_bookings", array(
			'post_id' => $post_id
		));
	}
	
	/**
	 * Debugging function to show the current live bookings table
	 * 
	 * @global WPDB $wpdb
	 */
	public function debug_show_live_bookings() {
		global $wpdb;
		return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}qns_live_bookings");
	}
	
	/**
	 * Debugging shortcode
	 */
	public function booking_debug_shortcode() {
//		$this->create_live_bookings_table();
//		echo '<pre>'; print_r($this->debug_show_live_bookings()); echo '</pre>';
	}
	
	/**
	 * Create a summary of collisions
	 * $this->collisions must already be called
	 *
	 * It's an array of this format:
	 * [ '{room_type}' (title of room) => array
	 *     [ 'max_room_usage' => int (maximum concurrent room usage)
	 *       'max_bed_usage_{bed_type}' => int (maximum concurrent bed usage)
	 *     ]
	 * ]
	 *
	 * @param int $checkin The checkin date, as a unix timestamp
	 * @param int $checkout The checkout date, as a unix timestamp
	 * @param array $room_types An array of room types to check for
	 * @global WPDB $wpdb
	 */
	public function make_collision_summary($checkin, $checkout, $room_types) {
		global $wpdb;
		$summary = array();
		
		foreach ($room_types as $room_type) {
			// 1. determining number of concurrent checkins for this room type
			// new room_type; initialize maximums to 0
			$summary[$room_type]['max_concurrent_rooms'] = 0;
			
			// 1.1. count checkins before or on the $checkin date
			// (note: checkouts are not counted because they should already be excluded)
			
			$today = $checkin;

			$checkincount = $wpdb->get_var($wpdb->prepare(
"SELECT
COUNT(*) as checkincount
FROM (SELECT * FROM {$wpdb->prefix}qns_live_bookings WHERE checkin < %s AND %s < checkout AND type = %d) AS collisions
WHERE
checkin <= %s",
				date('Y-m-d H:i:s', $checkout),
				date('Y-m-d H:i:s', $checkin),
				$room_type,
				date('Y-m-d H:i:s', $today)
			));
			
			$today_max_concurrent_rooms = $checkincount;

			if ($today_max_concurrent_rooms > $summary[$room_type]['max_concurrent_rooms']) {
				$summary[$room_type]['max_concurrent_rooms'] = $today_max_concurrent_rooms;
			}

			// 1.2. count checkins and checkouts for everyday until $checkout
			
			for ($today = $checkin + 86400; $today <= $checkout - 86400; $today += 86400) {
				$results = $wpdb->get_results($wpdb->prepare(
"SELECT
COUNT(CASE WHEN checkin = %s THEN 1 ELSE NULL END) AS checkincount,
COUNT(CASE WHEN checkout = %s THEN 1 ELSE NULL END) as checkoutcount
FROM
(SELECT * FROM {$wpdb->prefix}qns_live_bookings WHERE checkin < %s AND %s < checkout AND type = %d) AS collisions
WHERE
checkin = %s
OR
checkout = %s",
					date('Y-m-d H:i:s', $today),
					date('Y-m-d H:i:s', $today),
					date('Y-m-d H:i:s', $checkout),
					date('Y-m-d H:i:s', $checkin),
					$room_type,
					date('Y-m-d H:i:s', $today),
					date('Y-m-d H:i:s', $today)
				), ARRAY_A);

				$today_max_concurrent_rooms += $results[0]['checkincount'];
				$today_max_concurrent_rooms -= $results[0]['checkoutcount'];
				
				if ($today_max_concurrent_rooms > $summary[$room_type]['max_concurrent_rooms']) {
					$summary[$room_type]['max_concurrent_rooms'] = $today_max_concurrent_rooms;
				}
			}		
		}
		
		return $summary;
	}
	
}
