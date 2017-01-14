<?php
/**
 * Quitenicebooking_Accommodation_Post type class
 *
 * This class encapsulates the Accommodation post type
 *
 * @package quitenicebooking
 * @author Quite Nice Stuff
 * @copyright Copyright (c) 2013 Quite Nice Stuff
 * @link http://quitenicestuff.com
 * @version 2.5.1
 * @since 2.0.0
 */

class Quitenicebooking_Accommodation_Post {
	/**
	 * Properties ==============================================================
	 */
	
	/**
	 * @var array The global plugin settings
	 */
	public $settings;
	
	/**
	 * @var array The meta extracted for a single post
	 */
	protected $post_meta;
	
	/**
	 * @var array Meta field definitions
	 */
	public $keys;
	
	/**
	 * @var Quitenicebooking_Premium_Price_Filters An instance of the price filters, if available
	 */
	public $price_filters_class;

	/**
	 * Constructor
	 *
	 * Registers post type, actions, filters, shortcodes, languages, scripts
	 */
	public function __construct() {
		// register custom post type
		add_action('init', array($this, 'register_post_type'));
		// initialize the class
		add_action('init', array($this, 'init'));
		// hook meta boxes
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'save_meta'));
		// add template
		add_filter('template_include', array($this, 'template_include'));
		// enqueue scripts
		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
	}
	
	/**
	 * Initializes the class.  This should be called after $this->settings has been set
	 */
	public function init() {
		// define the meta_keys that this post saves
		$this->keys = array();
		$this->keys['room_size']['meta_key'] = 'quitenicebooking_room_size';
		$this->keys['room_view']['meta_key'] = 'quitenicebooking_room_view';
		$this->keys['max_occupancy']['meta_key'] = 'quitenicebooking_max_occupancy';
		$this->keys['room_quantity']['meta_key'] = 'quitenicebooking_room_quantity';
		$this->keys['num_bedrooms']['meta_key'] = 'quitenicebooking_num_bedrooms';
		for ($t = 1; $t <= 5; $t ++) {
			$this->keys["tab_{$t}_title"]['meta_key'] = "quitenicebooking_tab_{$t}_title";
			$this->keys["tab_{$t}_content"]['meta_key'] = "quitenicebooking_tab_{$t}_content";
		}
		// instantiate price filters
		$this->price_filters_class = new Quitenicebooking_Price_Filters($this->settings);
	}
	
	/**
	 * Enqueues scripts
	 */
	public function admin_enqueue_scripts() {
		global $post;
		if (is_object($post) && get_post_type($post->ID) == 'accommodation') {
			wp_enqueue_script('jquery-ui-tabs');
			wp_register_script('quitenicebooking-accommodation-admin', QUITENICEBOOKING_URL.'assets/js/admin/accommodation_meta.js');
			wp_enqueue_script('quitenicebooking-accommodation-admin');
			wp_localize_script('quitenicebooking-accommodation-admin', 'quitenicebooking', array(
				'entity_scheme' => $this->settings['entity_scheme'],
				'date_format' => $this->settings['date_format_strings'][$this->settings['date_format']]['display'],
				'js_date_format' => $this->settings['date_format'],
				'currency_unit' => $this->settings['currency_unit']
			));
			wp_register_style('quitenicebooking-accommodation-admin', QUITENICEBOOKING_URL.'assets/css/admin/accommodation_meta.css');
			wp_enqueue_style('quitenicebooking-accommodation-admin');
		}
	}

	/**
	 * Registers the Accommodation post type
	 */
	public function register_post_type() {
		register_post_type('accommodation',
			array(
				'labels'		=> array(
					'name'			=> __('Accommodations', 'quitenicebooking'),
					'singular_name'	=> __('Accommodation', 'quitenicebooking'),
					'add_new'		=> _x('Add New', 'accommodation', 'quitenicebooking'),
					'add_new_item'	=> __('Add New Accommodation', 'quitenicebooking'),
				),
				'public'		=> TRUE,
				'menu_icon'		=> 'dashicons-admin-post',
				'menu_position'	=> 5, // below Posts
				'rewrite'		=> array(
					'slug'			=> __('accommodation', 'quitenicebooking'),
				),
				'supports'		=> array('title', 'editor', 'thumbnail'),
			)
		);
	}
	
	/**
	 * Adds the Accommodation meta boxes
	 */
	public function add_meta_boxes() {
		$this->get_accommodation_meta();
		global $post;
		
		add_meta_box(
			'accommodation_pricing_meta', // id
			__('Pricing Options', 'quitenicebooking'), // title
			array($this, 'show_pricing_meta_box'), // callback
			'accommodation', // post_type
			'normal' // context
		);
		do_action('quitenicebooking_add_price_filters_meta_box');
		add_meta_box(
			'accommodation_details_meta', // id
			__('Room Details', 'quitenicebooking'), // title
			array($this, 'show_details_meta_box'), // callback
			'accommodation', // post_type
			'normal' // context
		);
		add_meta_box(
			'accommodation_beds_meta', // id
			__('Bed Availability', 'quitenicebooking'), // title
			array($this, 'show_beds_meta_box'), // callback
			'accommodation', // post type
			'normal' // context
		);
		add_meta_box(
			'accommodation_tabs_meta', // id
			__('Tab Content', 'quitenicebooking'), // title
			array($this, 'show_tabs_meta_box'), // callback
			'accommodation', // post type
			'normal' // context
		);
		add_meta_box(
			'accommodation_slideshow_meta', // id
			__('Slideshow', 'quitenicebooking'), // title
			array($this, 'show_slideshow_meta_box'), // callback
			'accommodation', // post type
			'side' // context
		);

	}
	
	/**
	 * Reads the Accommodation meta into $this->post_meta
	 *
	 * @global $post The WP post object
	 */
	public function get_accommodation_meta() {
		global $post;
		$this->post_meta = get_post_meta($post->ID);
		// extract all values out of $this->post_meta so they're not in arrays
		foreach ($this->post_meta as &$p) {
			$p = $p[0];
		}
	}
	
	/**
	 * Displays the Pricing Options meta box
	 */
	public function show_pricing_meta_box() {
		$quitenicebooking_currency_unit = $this->settings['currency_unit'];
		$price_class = 'Quitenicebooking_Prices_'.ucfirst($this->settings['pricing_scheme']);
		$quitenicebooking_prices = new $price_class($this->settings['entity_scheme']);
		extract($this->post_meta, EXTR_OVERWRITE);
		include QUITENICEBOOKING_PATH.'views/admin/accommodation_pricing_meta.htm.php';
	}

	/**
	 * Displays the Room Details meta box
	 */
	public function show_details_meta_box() {
		extract($this->post_meta, EXTR_OVERWRITE);
		include QUITENICEBOOKING_PATH.'views/admin/accommodation_details_meta.htm.php';
	}
	
	/**
	 * Displays the Beds meta box
	 */
	public function show_beds_meta_box() {
		$quitenicebooking_beds = new Quitenicebooking_Beds();
		extract($this->post_meta, EXTR_OVERWRITE);
		include QUITENICEBOOKING_PATH.'views/admin/accommodation_beds_meta.htm.php';
	}

	/**
	 * Displays the Tab meta boxes
	 */
	public function show_tabs_meta_box() {
		extract($this->post_meta, EXTR_OVERWRITE);
		include QUITENICEBOOKING_PATH.'views/admin/accommodation_tab_meta.htm.php';
	}
	
	/**
	 * Displays the slideshow meta boxes
	 * 
	 * @global $post The WP post object
	 */
	public function show_slideshow_meta_box() {
		global $post;
		include QUITENICEBOOKING_PATH.'views/admin/accommodation_slideshow_meta.htm.php';
	}
	
	/**
	 * Saves the Accommodation metadata
	 *
	 * @param int $post_id The ID of the post
	 */
	public function save_meta($post_id) {
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		
		// check whether this is an accommodation post type
		if (!isset($_REQUEST['post_type']) || $_REQUEST['post_type'] != 'accommodation') {
			return;
		}
		
		// check permissions
		if (!current_user_can('edit_post', $post_id)) {
			return;
		}

		// TODO verify nonce
	
		// TODO field validation
		// if validation fails, set the publish status to "draft"
		
		// add/update defined metadata
		foreach ($this->keys as $key) {
			if (preg_match('/quitenicebooking_tab_\d+_content/', $key['meta_key']) !== FALSE
				&& isset($_REQUEST[$key['meta_key']])) {
				update_post_meta($post_id, $key['meta_key'], $_REQUEST[$key['meta_key']]);
			} else {
				if (isset($_REQUEST[$key['meta_key']])) {
					update_post_meta($post_id, $key['meta_key'], sanitize_text_field($_REQUEST[$key['meta_key']]));
				}
			}
		}
		// update slideshow images
		if ( isset($_REQUEST['slideshow_images']) ) {
			$attachment_ids = array_filter(explode(',', sanitize_text_field($_REQUEST['slideshow_images'] )));
			update_post_meta($post_id, '_slideshow_images', implode(',', $attachment_ids));
		}
		// update beds
		$quitenicebooking_beds = new Quitenicebooking_Beds();
		$quitenicebooking_beds->save_meta($post_id, filter_input_array(INPUT_POST));
		// update pricing
		$price_class = 'Quitenicebooking_Prices_'.ucfirst($this->settings['pricing_scheme']);
		$quitenicebooking_prices = new $price_class($this->settings['entity_scheme']);
		$quitenicebooking_prices->save_meta($post_id, filter_input_array(INPUT_POST));
		// update filters
//		if (is_object($this->price_filters_class) && get_class($this->price_filters_class) == 'Quitenicebooking_Price_Filters') {
			$this->price_filters_class->save_meta($post_id, filter_input_array(INPUT_POST));
//		}
	}
	
	/**
	 * Returns an array of all accommodations
	 *
	 * @global $wpdb The wpdb object
	 * @param boolean $bypass Bypass WP_Query and use $wpdb instead; used to override WPML query filter
	 * @return array An array of all accommodations
	 */
	public function get_all_accommodations($bypass = FALSE) {
		if (!$bypass) {
			$order = get_option('quitenicebooking');
			$order = $order['rooms_order'];
			$query = new WP_Query(array(
				'post_type' => 'accommodation',
				'order' => $order == 'newest' ? 'DESC' : 'ASC',
				'nopaging' => TRUE
			));
			$all = array();
			while ($query->have_posts()) {
				$query->the_post();
				$all[$query->post->ID]['id'] = $query->post->ID;
				$all[$query->post->ID]['title'] = get_the_title();
				$meta = get_post_meta($query->post->ID);
				foreach ($meta as $m => $v) {
					$all[$query->post->ID][$m] = $v[0];
				}
			}
			wp_reset_postdata();
			return $all;
		} else {
			global $wpdb;
			$posts = $wpdb->get_results("
	SELECT ID, post_title
	FROM $wpdb->posts
	WHERE post_type = 'accommodation'
	AND post_status = 'publish'
			");
			$all = array();
			foreach ($posts as $post) {
				$all[$post->ID]['id'] = $post->ID;
				$all[$post->ID]['title'] = $post->post_title;
				$meta = get_post_meta($post->ID);
				foreach ($meta as $m => $v) {
					$all[$post->ID][$m] = $v[0];
				}
			}

			return $all;
		}
	}
	
	/**
	 * Returns a single accommodation given its ID
	 * 
	 * @param int $id The ID of the accommodation
	 * @param boolean $bypass Whether to bypass WP_Query and use $wpdb instead; necessary for WPML
	 * @return array An array containing a single accommodation
	 */
	public function get_single_accommodation($postid, $bypass = FALSE) {
		if (!$bypass) {
			$query = new WP_Query(array(
				'post_type' => 'accommodation',
				'p' => $postid
			));
			$single = array();
			while ($query->have_posts()) {
				$query->the_post();
				$single[$query->post->ID]['id'] = $query->post->ID;
				$single[$query->post->ID]['title'] = get_the_title();
				$meta = get_post_meta($query->post->ID);
				foreach ($meta as $m => $v) {
					$single[$query->post->ID][$m] = $v[0];
				}
			}
			wp_reset_postdata();
			return $single;
		} else {
			global $wpdb;
			$meta = get_post_meta($postid);
			$single[$postid]['id'] = $postid;
			$single[$postid]['title'] = $wpdb->get_var($wpdb->prepare(
				"SELECT post_title FROM {$wpdb->posts} WHERE ID = %d",
				$postid
			));
			$meta = get_post_meta($postid);
			foreach ($meta as $m => $v) {
				$single[$postid][$m] = $v[0];
			}
			return $single;
		}
	}

	/**
	 * Adds the single-accommodation template
	 * 
	 * @param string $template The template file name
	 */
	public function template_include($template) {
		if (get_post_type(get_the_ID()) == 'accommodation' && is_single()) {
			return QUITENICEBOOKING_PATH.'templates/single-accommodation.php';
		}
		return $template;
	}
	
	/**
	 * Calculate the booking price
	 * 
	 * @param int $checkin The checkin date, as a unix timestamp
	 * @param int $checkout The checkout date, as a unix timestamp
	 * @param int $type The accommodation type (post ID)
	 * @param array $entity_args Arguments to pass to the entity class callback
	 * @return array The price of the booking
	 *		array(
	 *			'total' => total // (float) the total amount
	 *			'subtotals' => array( array( date, subtotal ) ) // an array of subtotals
	 *		)
	 */
	public function calc_booking_price($checkin, $checkout, $type, $entity_args) {
		$total = 0.0;
		// an array of subtotals: array(date, subtotal)
		$subtotals = array();
		// define the current day
		$today = $checkin;
		
		$price_class_name = 'Quitenicebooking_Prices_'.ucfirst($this->settings['pricing_scheme']);
		$price_class = new $price_class_name($this->settings['entity_scheme']);
		$price_class->load_prices($type);
		
		// 1. get the unit price of the $checkin date
		while ($today < $checkout) {
			// 2. advance the date until it is >= $checkout
			$subtotals[$today] = $price_class->calc_unit_price(
				$today,
				$entity_args
			);
			$total += $subtotals[$today];
			// advance to the next time unit
			$today = $price_class->next_unit($today);
		}
		return array('total' => $total, 'subtotals' => $subtotals);
	}
}
