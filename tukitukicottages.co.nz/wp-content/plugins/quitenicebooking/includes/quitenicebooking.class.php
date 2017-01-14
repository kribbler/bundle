<?php
/**
 * Quitenicebooking main (controller) class
 * 
 * @package quitenicebooking
 * @author Quite Nice Stuff
 * @copyright Copyright (c) 2013 Quite Nice Stuff
 * @link http://quitenicestuff.com
 * @version 2.5.2
 * @since 2.0.0
 */
class Quitenicebooking {
	/**
	 * Class properties ========================================================
	 */
	
	/**
	 * Accommodation custom post class
	 * @var Quitenicebooking_Accommodation_Post
	 */
	public $accommodation_post;
	
	/**
	 * Booking custom post class
	 * @var Quitenicebooking_Booking_Post
	 */
	public $booking_post;
	
	/**
	 * An array of settings from Quitenicebooking_Settings
	 * @var array
	 */
	public $settings;
	
	/**
	 * An instance of the Quitenicebooking_Settings class
	 * @var Quitenicebooking_Settings
	 */
	public $settings_class;
	
	/**
	 * Class methods ===========================================================
	 */
	
	/**
	 * Constructor
	 * 
	 * Adds hooks to initialize the class
	 */
	public function __construct() {
		// autoload classes when needed
		spl_autoload_register( array( $this, 'autoload' ) );
		
		// save activation errors
		add_action( 'activated_plugin' , array( $this, 'save_error' ) );
		
		// installation hook
		register_activation_hook( QUITENICEBOOKING_MAIN_FILE, array( 'Quitenicebooking_Settings', 'activate' ) );
		
		if ( get_option( 'quitenicebooking' ) === FALSE && get_option( 'qns_booking_booking1_url' ) !== FALSE) {
			// an old installation exists; plugin needs to be deactivated and reactivated
			add_action( 'admin_notices', array( 'Quitenicebooking_Settings', 'upgrade_notice_100' ) );
		} elseif ( get_option( 'quitenicebooking' ) !== FALSE ) {
			// continue to instantiate the class
			// detect need for backup before upgrade
			$get = filter_input_array( INPUT_GET );
			if ( Quitenicebooking_Settings::recommend_backup() === FALSE || ( isset( $get['upgrade'] ) && $get['upgrade'] == '1' ) ) {
				// upgrade hook
				add_action( 'admin_init', array( 'Quitenicebooking_Settings', 'upgrade' ) );

				// detect whether pages need to be created
				add_action( 'admin_init', array( $this, 'install_pages' ) );

				// sessions
				add_action( 'init', array( $this, 'qns_session_start' ), 1 );
				add_action( 'wp_logout', array( $this, 'qns_session_destroy' ) );
				add_action( 'wp_login', array( $this, 'qns_session_destroy' ) );

				// load languages
				add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );

				// initialization hook
				add_action( 'init', array( $this, 'init' ) );

				// add settings link to admin
				add_filter('plugin_action_links_'.plugin_basename(QUITENICEBOOKING_BASE), array($this, 'plugin_action_links'));

				// initialize widget
				add_action( 'widgets_init', array( $this, 'register_widget' ) );

				// register ajax scripts
				if ( is_admin() ) {
					add_action( 'wp_ajax_quitenicebooking_ajax_check_availability', array( $this, 'ajax_check_availability' ) );
					add_action( 'wp_ajax_nopriv_quitenicebooking_ajax_check_availability', array( $this, 'ajax_check_availability' ) );
				}
				add_action('wp_ajax_quitenicebooking_ajax_calendar_availability', array($this, 'ajax_calendar_availability'));
				add_action('wp_ajax_nopriv_quitenicebooking_ajax_calendar_availability', array($this, 'ajax_calendar_availability'));

				// instantiate custom post types
				$this->accommodation_post = new Quitenicebooking_Accommodation_Post();
				$this->booking_post = new Quitenicebooking_Booking_Post();				
			}
		}
		// load premium plugins
		if (class_exists('Quitenicebooking_Premium_Coupon_Post_Type')) {
			$this->coupon_class = new Quitenicebooking_Premium_Coupon_Post_Type();
		}
	}
	
	/**
	 * Class autoloader.  All class filenames should be lower case
	 * 
	 * @param string $class
	 */
	public function autoload( $class ) {
		$class = strtolower( $class );
		if ( strpos( $class, 'quitenicebooking' ) !== FALSE
			&& strpos( $class, 'quitenicebooking_premium' ) === FALSE ) {
			include_once dirname( __FILE__ ) . '/' . $class . '.class.php';
		}
	}
	
	/**
	 * Starts the PHP session
	 */
	public function qns_session_start() {
		if ( ! session_id() ) {
			session_start();
		}
	}
	
	/**
	 * Destroys the PHP session
	 */
	public function qns_session_destroy() {
		session_destroy();
	}
	
	/**
	 * Load language files
	 */
	public function plugins_loaded() {
		// localization
		load_plugin_textdomain( 'quitenicebooking', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/../languages/' );
	}
	
	/**
	 * Initialization
	 */
	public function init() {
		// instantiate settings class
		$this->settings_class = new Quitenicebooking_Settings();
		$this->settings_class->read_settings();
		$this->settings = $this->settings_class->settings;
		
		// pass settings to post types.  they will init() after $this->init() finishes
		$this->accommodation_post->settings = $this->settings;
		$this->booking_post->settings = $this->settings;
		$this->booking_post->accommodation_post = $this->accommodation_post;
		if (isset($this->coupon_class) && is_object($this->coupon_class)) {
			$this->coupon_class->settings = $this->settings;
		}
		
		// add shortcodes
		add_shortcode( 'booking_form', array( $this, 'booking_form_shortcode' ) );
		add_shortcode( 'booking_step_1', array( $this, 'booking_step_1_shortcode' ) );
		add_shortcode( 'booking_step_2', array( $this, 'booking_step_2_shortcode' ) );
		add_shortcode( 'booking_step_3', array( $this, 'booking_step_3_shortcode' ) );
		add_shortcode( 'booking_step_4', array( $this, 'booking_step_4_shortcode' ) );
		add_shortcode( 'payment_fail', array( $this, 'payment_fail_shortcode' ) );
		add_shortcode( 'payment_success', array( $this, 'payment_success_shortcode' ) );
		add_shortcode( 'accommodation', array( $this, 'accommodation_shortcode' ) );

		// legacy support for quitenicebooking 1.0
		add_shortcode( 'booking_step1', array( $this, 'booking_step_1_shortcode' ) );
		add_shortcode( 'booking_step2', array( $this, 'booking_step_2_shortcode' ) );
		add_shortcode( 'booking_step3', array( $this, 'booking_step_3_shortcode' ) );
		add_shortcode( 'booking_step4', array( $this, 'booking_step_4_shortcode' ) );
		add_shortcode( 'booking_fail', array( $this, 'payment_fail_shortcode' ) );
		add_shortcode( 'booking_success', array( $this, 'payment_success_shortcode' ) );
		
		// enqueue scripts for front-end
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		
		// validation
		add_action( 'template_redirect', array( $this, 'booking_steps_controller' ) );
		
		// set image size for accommodation admin slideshow thumbnail
		if ( function_exists( 'add_image_size' ) ) {
			add_image_size( 'image1', 72, 72, TRUE );
		}
		
		// debugging shortcode
//		 add_shortcode( 'debug', array( $this, 'debug') );
	}

	/**
	 * Adds settings link to admin
	 */
	public function plugin_action_links($links) {
		array_unshift($links, '<a href="http://themes.quitenicestuff.com/docs/sohohotelwp/">Docs</a>');
		array_unshift($links, '<a href="'.admin_url('admin.php?page=quitenicebooking_settings').'">Settings</a>');
		return $links;
	}
	
	/**
	 * Saves activation errors, if any, into options table
	 */
	public function save_error() {
		update_option( 'quitenicebooking_error', ob_get_contents() );
	}
	
	/**
	 * Enqueue scripts and styles
	 */
	public function enqueue_scripts() {
		// jquery ui
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-effects-pulsate' );
		
		// prettyphoto lightbox
		wp_register_script( 'prettyphoto', QUITENICEBOOKING_URL . 'assets/js/jquery.prettyPhoto.js' );
		wp_enqueue_script( 'prettyphoto' );
		wp_register_style( 'prettyphoto', QUITENICEBOOKING_URL . 'assets/css/prettyPhoto.css' );
		wp_enqueue_style( 'prettyphoto' );
		
		// include datepicker translations from separate file
		include dirname( __FILE__ ) . '/datepicker_translations.php';
		
		// the script file used by booking steps 1-3
		wp_register_script( 'quitenicebooking-settings', QUITENICEBOOKING_URL . 'assets/js/jquery-settings.js' );
		wp_enqueue_script( 'quitenicebooking-settings' );
		wp_localize_script( 'quitenicebooking-settings', 'quitenicebooking', array(
			'date_format'					=> $this->settings['date_format'],
			'validationerror_requiredfield'	=> __( 'Please fill out the required fields marked with *', 'quitenicebooking' ),
			'validationerror_email'			=> __( 'Please enter a valid email address', 'quitenicebooking' ),
			'validationerror_paymentmethod'	=> __( 'Please select a payment method', 'quitenicebooking' ),
			'validationerror_tos'			=> __( 'Please accept the terms and conditions', 'quitenicebooking' ),
			'input_checkin'					=> __( 'Check In', 'quitenicebooking' ),
			'input_checkout'				=> __( 'Check Out', 'quitenicebooking' ),
			'alert_select_dates'			=> __( 'Please Select Booking Dates', 'quitenicebooking' ),
			'alert_cannot_be_same_day'		=> __( 'Check In and Check Out Dates Cannot Be On The Same Day', 'quitenicebooking' ),
			'alert_checkin_before_checkout'	=> __( 'Check In Date Must Be Before Check Out Date', 'quitenicebooking' ),
			'alert_at_least_1_guest'		=> __( 'Please select at least 1 guest for Room', 'quitenicebooking' ),
			'alert_at_least_1_adult'		=> __( 'Booking must have at least 1 adult', 'quitenicebooking' ),
			'ajax_url'						=> admin_url( 'admin-ajax.php', isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://' ),
			'plugin_url'					=> QUITENICEBOOKING_URL,
		));
	}
	
	/**
	 * Detects whether pages are installed
	 * Prompt if they don't already exist
	 * Install if argument supplied
	 */
	public function install_pages() {
		// re-read the settings in case the upgrade procedure was automatically run
		$this->settings_class->read_settings();
		$this->settings = $this->settings_class->settings;
		// detect pages
		if ( empty( $this->settings['step_1_page_id'] ) && empty( $this->settings['step_2_page_id'] ) 
			&& empty ( $this->settings['step_3_page_id'] ) && empty( $this->settings['step_4_page_id'] )
			&& empty ( $this->settings['payment_success_page_id'] ) && empty( $this->settings['payment_fail_page_id'] )
			&& empty ( $this->settings['accommodation_page_id'] ) ) {
			// check whether to ignore the prompt
			Quitenicebooking_Settings::ignore_install_pages_notice();
			$current_user = wp_get_current_user();
			if ( ! get_user_meta( $current_user->ID, 'quitenicebooking_ignore_install_pages_notice', TRUE ) ) {
				// show prompt
				add_action( 'admin_notices', array( 'Quitenicebooking_Settings', 'install_pages_notice' ) );	
			}
			// else ignore prompt
			
			// check whether to install pages
			Quitenicebooking_Settings::install_pages();
		}
	}
	
	/**
	 * Widgets =================================================================
	 */
	
	/**
	 * Registers the reservation form widget
	 */
	public function register_widget() {
		include QUITENICEBOOKING_PATH . 'includes/quitenicebooking_reservation_form_widget.class.php';
		register_widget( 'Quitenicebooking_Reservation_Form_Widget' );
	}
	
	
	/**
	 * Redirection controller ==================================================
	 */
	
	/**
	 * Handles the incoming request
	 * Redirects it to the appropriate validation and processing functions
	 */
	public function booking_steps_controller() {
		if ( filter_input( INPUT_POST, 'booking_form_submit') !== NULL ) {
			$this->booking_form_validation( filter_input_array( INPUT_POST ) );
		} elseif ( filter_input( INPUT_POST, 'booking_step_1_submit') !== NULL ) {
			$this->booking_step_1_validation( filter_input_array( INPUT_POST ) );
		} elseif ( filter_input( INPUT_POST, 'booking_step_2_submit') !== NULL ) {
			$this->booking_step_2_validation( filter_input_array( INPUT_POST ) );
		} elseif ( filter_input( INPUT_POST, 'booking_step_3_submit') !== NULL ) {
			$this->booking_step_3_validation( filter_input_array( INPUT_POST ) );
		} elseif (filter_input(INPUT_POST, 'apply_coupon') !== NULL) {
			$this->booking_step_3_validation(filter_input_array(INPUT_POST));
		} elseif (filter_input(INPUT_POST, 'remove_coupon') !== NULL) {
			$this->booking_step_3_validation(filter_input_array(INPUT_POST));
		}
	}
		
	/**
	 * Shortcodes ==============================================================
	 */

	/**
	 * The booking form shortcode
	 *
	 * Shows the form on the homepage (used by Soho Hotel's template-homepage-*.php templates), and submits to step_1
	 */
	public function booking_form_shortcode() {
		return $this->view( 'views/booking_form.htm.php', $this->settings );
	}
	
	/**
	 * Step 1 shortcode
	 */
	public function booking_step_1_shortcode() {
		$booking = array();
		$errors = array();
		if ( isset( $_SESSION['booking'] ) ) {
			$booking = $_SESSION['booking'];
		}
		if ( isset( $_SESSION['errors'] ) ) {
			$errors = $_SESSION['errors'];
		}
		return $this->view( 'views/booking_step_1.htm.php', array_merge(
			$this->settings, $booking, array('errors' => $errors)
		) );
	}
	
	/**
	 * Step 2 shortcode
	 */
	public function booking_step_2_shortcode() {
		$data = array();
		$errors = array();
		if ( isset ( $_SESSION['data'] ) ) {
			$data = $_SESSION['data'];
			unset( $_SESSION['data'] );
		}
		if ( isset( $_SESSION['errors'] ) ) {
			$errors = $_SESSION['errors'];
			unset ( $_SESSION['errors'] );
		}
		// handle GET here
		// if $data is empty, load error page to redirect to step 1
		if ( count($data) == 0 ) {
			$data['errors'] = array( __( 'Please do not reload the page.  You will be redirected to the first booking step momentarily.', 'quitenicebooking' ) );
			$data['redirect'] = $this->settings['step_1_url'];
			return $this->view( 'views/error.htm.php', $data );
		} else {
			$data['beds'] = new Quitenicebooking_Beds();
			return $this->view( 'views/booking_step_2.htm.php', array_merge(
				$this->settings, $data, array('errors' => $errors)
			) );
		}
	}
	
	/**
	 * Step 3 shortcode
	 */
	public function booking_step_3_shortcode() {
		$data = array();
		$post = array(); // containing customer posted data
		$errors = array();
		if ( isset( $_SESSION['data'] ) ) {
			$data = $_SESSION['data'];
			unset( $_SESSION['data'] );
		}
		if ( isset( $_SESSION['post'] ) ) {
			$post = $_SESSION['post'];
			unset( $_SESSION['post'] );
		}
		if ( isset( $_SESSION['errors'] ) ) {
			$errors = $_SESSION['errors'];
			if (isset($data['errors'])) {
				$errors = array_merge($errors, $data['errors']);
			}
			unset ( $_SESSION['errors'] );
		}
		// handle GET here
		if ( ! isset( $_SESSION['booking'] ) || count( $_SESSION['booking'] ) == 0 || ! isset( $_SESSION['booking']['room_qty'] ) ) {
			$data['errors'] = array( __( 'Your session has expired.  You will be redirected to the first booking step momentarily.', 'quitenicebooking' ) );
			$data['redirect'] = $this->settings['step_1_url'];
			return $this->view( 'views/error.htm.php', $data );
		} elseif ( count($data) == 0 ) {
		// if $data is empty, load error page and redirect to step 1
			$data['errors'] = array( __( 'Please do not reload the page.  You will be redirected to the first booking step momentarily.', 'quitenicebooking' ) );
			$data['redirect'] = $this->settings['step_1_url'];
			return $this->view( 'views/error.htm.php', $data );
		} else {
			if (isset($this->coupon_class) && is_object($this->coupon_class)) {
				$data['coupons_enabled'] = TRUE;
			}
			$data['form_fields'] = Quitenicebooking_Utilities::decode_reservation_form($this->settings);
			return $this->view( 'views/booking_step_3.htm.php', array_merge(
				$this->settings, $data, $post, array('errors' => $errors)
			) );
		}
	}
	
	/**
	 * Step 4 shortcode
	 */
	public function booking_step_4_shortcode() {
		$data = array();
		if ( isset( $_SESSION['data'] ) ) {
			$data = $_SESSION['data'];
			unset( $_SESSION['data'] );
		}
		// handle GET here
		if ( ! isset( $_SESSION['booking'] ) || count( $_SESSION['booking'] ) == 0 || ! isset( $_SESSION['booking']['room_qty'] ) ) {
			$data['errors'] = array( __( 'Your session has expired.  You will be redirected to the first booking step momentarily.', 'quitenicebooking' ) );
			$data['redirect'] = $this->settings['step_1_url'];
			return $this->view( 'views/error.htm.php', $data );
		} elseif ( count($data) == 0 ) {
		// if $data is empty, load error page and redirect to step 1
			$data['errors'] = array(
				__( 'Please do not reload the page.  If you have already made a reservation, your reservation details have been emailed to you.', 'quitenicebooking' )
			);
			return $this->view( 'views/error.htm.php', $data );
		} else {
			// destroy the session
			session_unset();
			// check if there is a redirect to paypal
			if ( isset( $data['redirect'] ) ) {
				return $this->view( 'views/booking_step_4_redirect.htm.php', array_merge(
					$this->settings, $data )
				);
			}
			else {
				return $this->view( 'views/booking_step_4.htm.php', array_merge(
					$this->settings, $data )
				);
			}
		}
	}
	
	/**
	 * Payment success shortcode
	 * 
	 * Query string must include parameters 'booking_id' and 'key'
	 * @global wpdb $wpdb The wpdb object
	 */
	public function payment_success_shortcode() {
		global $wpdb;
		$get = filter_input_array( INPUT_GET );
		
		// verify arguments are set
		if (!isset($get['booking_id']) || !isset($get['key'])) {
			$data['errors'] = array($this->settings['payment_success_message']);
			return $this->view('views/payment_success_error.htm.php', array_merge($this->settings, $data));
		}
		// get the booking id and hash
		$booking_id = $get['booking_id'];
		$hash = $get['key'];
		// pull the booking info out of the database
		$query = new WP_Query(array(
			'post_type' => 'booking',
			'p' => $booking_id
		));
		// use wpdb to override WPML language
		$query = $wpdb->get_results($wpdb->prepare(
			"SELECT * FROM $wpdb->posts WHERE post_type = %s AND ID = %d",
			'booking',
			$booking_id
		));
		$query = (array) $query[0];
		if (count($query) > 0) {
			$post_meta = get_post_meta($booking_id);
			foreach ($post_meta as &$p) {
				$p = $p[0];
			}
			unset($p);
			
			if ($hash != substr(sha1('quitenicebooking'.$post_meta['quitenicebooking_guest_last_name'].$post_meta['quitenicebooking_guest_first_name']), 0, 6)) {
				$data['errors'] = array($this->settings['payment_success_message']);
			}
			
			$data['deposit'] = $post_meta['quitenicebooking_deposit_amount'];
			$data['total'] = $post_meta['quitenicebooking_total_price'];
			
			$booked_rooms = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}qns_bookings WHERE post_id = $booking_id", ARRAY_A);
			$num_rooms = $booked_rooms == NULL ? 0 : count($booked_rooms);
			$data['total_rooms'] = $num_rooms;
			
			$data['summary'] = array();
			$data['breakdown'] = array();
			$all_rooms = $this->accommodation_post->get_all_accommodations(TRUE);
			for ($n = 1; $n <= $num_rooms; $n ++) {
				$data['summary'][$n]['type'] = $all_rooms[$booked_rooms[$n-1]['type']]['title'];
				$data['summary'][$n]['checkin'] = substr(date($this->settings['date_format_strings'][$this->settings['date_format']]['php'], strtotime($booked_rooms[$n-1]['checkin'])), 0, -9);
				$data['summary'][$n]['checkout'] = substr(date($this->settings['date_format_strings'][$this->settings['date_format']]['php'], strtotime($booked_rooms[$n-1]['checkout'])), 0, -9);
				$data['summary'][$n]['guests'] = '';
				$data['summary'][$n]['guests'] .= !empty($booked_rooms[$n-1]['adults']) ? $booked_rooms[$n-1]['adults'].' '._n('Adult', 'Adults', $booked_rooms[$n-1]['adults'], 'quitenicebooking').', ' : '';
				$data['summary'][$n]['guests'] .= !empty($booked_rooms[$n-1]['children']) ? $booked_rooms[$n-1]['children'].' '._n('Child', 'Children', $booked_rooms[$n-1]['children'], 'quitenicebooking').', ' : '';
				$data['summary'][$n]['guests'] = substr($data['summary'][$n]['guests'], 0, -2);
				
				$data['breakdown'][] = $this->make_price_breakdown(
					$all_rooms[$booked_rooms[$n-1]['type']],
					array(
						'checkin' => substr(date($this->settings['date_format_strings'][$this->settings['date_format']]['php'], strtotime($booked_rooms[$n-1]['checkin'])), 0, -9),
						'checkout' => substr(date($this->settings['date_format_strings'][$this->settings['date_format']]['php'], strtotime($booked_rooms[$n-1]['checkout'])), 0, -9),
						'adults' => $booked_rooms[$n-1]['adults'],
						'children' => $booked_rooms[$n-1]['children'],
						'total_guests' => $booked_rooms[$n-1]['adults'] + $booked_rooms[$n-1]['children']
					)
				);
			}

			// put all the coupons in an array
			if (isset($this->coupon_class) && is_object($this->coupon_class)) {
				if (!empty($post_meta['quitenicebooking_coupon_codes'])) {
					$coupons = explode(', ', $post_meta['quitenicebooking_coupon_codes']);
					foreach ($coupons as $p) {
						$applied_coupons[] = $p;
					}
				}
			}

			$discount_amt = 0;
			// apply the coupons and collect errors for those that cannot be applied because of requirement checks
			if (isset($applied_coupons)) {
				// calculate total
				$total = 0;
				foreach ($data['breakdown'] as $b) {
					$total += $b['total'];
				}
				// iterate through the breakdown and apply the discount
				$discounts = array();
				$coupon_errors = array();
				$discount_amt = $this->coupon_class->apply_discount($applied_coupons, $data['breakdown'], $total, $discounts, $coupon_errors);
				$data['discounts'] = $discounts;
//				$data['errors'] = $coupon_errors;
				$data['applied_coupons'] = $applied_coupons;
			}

		} else {
			$data['errors'] = array($this->settings['payment_success_message']);
		}
		if (isset($data['errors'])) {
			return $this->view('views/payment_success_error.htm.php', array_merge($this->settings, $data));
		} else {
			return $this->view('views/payment_success.htm.php', array_merge($this->settings, $data));
		}
	}
	
	/**
	 * Payment fail shortcode
	 */
	public function payment_fail_shortcode() {
		return $this->view('views/payment_fail.htm.php', $this->settings );
	}
	
	/**
	 * Accommodation shortcode
	 */
	public function accommodation_shortcode() {
		$rooms = array();
		
		// setup the query here and collect the data into $rooms
		$query = new WP_Query(array(
			'post_type' => 'accommodation',
			'posts_per_page' => $this->settings['rooms_per_page'],
			'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
			'order' => isset($this->settings['rooms_order']) ? ($this->settings['rooms_order'] == 'newest' ? 'DESC' : 'ASC') : 'DESC',
		));
		
		$pagedata['max_num_pages'] = $query->max_num_pages;
		$pagedata['next_posts_link'] = get_next_posts_link(__('More rooms &rarr;', 'quitenicebooking'), $query->max_num_pages);
		$pagedata['previous_posts_link'] = get_previous_posts_link(__('&larr; More rooms', 'quitenicebooking'));
		$pagedata['query'] = $query; // for wp_pagenavi
		
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				// header: get the title, title attribute, post thumbnail, permalink
				$room['id'] = $query->post->ID;
				$room['title'] = get_the_title();
				$room['title_attribute'] = the_title_attribute(array('echo' => FALSE));
				$room['post_thumbnail'] = wp_get_attachment_image_src( get_post_thumbnail_id($query->post->ID), 'image-style3');
				$room['post_thumbnail'] = $room['post_thumbnail'][0];
				$room['permalink'] = get_permalink();
				
				// content: get the types of beds, max occupancy, room size, view, lowest of the adult weekday/weekend/room price
				$post_meta = get_post_meta($query->post->ID);
				// extract values out of arrays
				foreach ($post_meta as &$p) {
					$p = $p[0];
				}
				
				$beds = new Quitenicebooking_Beds();
				foreach ($beds->keys['beds'] as $bed => $def) {
					$room['beds_available'][$bed]['available'] = $post_meta[$def['meta_key']] > 0 ? TRUE : FALSE;
					$room['beds_available'][$bed]['description'] = $def['description'];
				}
				
				$room['max_occupancy'] = $post_meta['quitenicebooking_max_occupancy'];
				$room['room_size'] = $post_meta['quitenicebooking_room_size'];
				$room['room_view'] = $post_meta['quitenicebooking_room_view'];
				$room['num_bedrooms'] = $post_meta['quitenicebooking_num_bedrooms'];
				$room['base_price'] = $this->settings['entity_scheme'] == 'per_person' ? min($post_meta['quitenicebooking_price_per_adult_weekday'], $post_meta['quitenicebooking_price_per_adult_weekend']) : min($post_meta['quitenicebooking_price_per_room_weekday'], $post_meta['quitenicebooking_price_per_room_weekend']);

				// add to $rooms
				$rooms[] = $room;
				unset($room);
			}
		} else {
			$pagedata['errors'][] = __('No rooms have been added yet', 'quitenicebooking');
		}
		
		// pass the query data into the view
		return $this->view('views/accommodation.htm.php', array_merge(array('rooms' => $rooms), $this->settings, $pagedata));
	}
	
	/**
	 * Validation ==============================================================
	 */
	
	/**
	 * Booking form validation
	 * 
	 * This dummy validation method will simply send the user to step_1
	 */
	
	public function booking_form_validation( $post ) {
		// store the booking data into the session
		$_SESSION['booking'] = $post;
		// if submitted from single-accommodation
		wp_redirect( $this->settings['step_1_url'] ); exit;
	}
	
	/**
	 * Step 1 validation
	 * 
	 * Note: The validation method also performs redirection
	 * @param array $post The $_POST array
	 */
	public function booking_step_1_validation( $post ) {
		// array to collect errors
		$errors = array();
		
		// validate all required form fields to make sure they exist
		if ( ! isset( $post['room_all_checkin'] )
			|| ! isset( $post['room_all_checkout'] )
			|| ! isset( $post['room_qty'] )
			|| ! isset( $post['room_1_adults'] )
			|| ! isset( $post['room_1_children'] ) ) {
			$errors[] = __('Please fill in all the required fields', 'quitenicebooking');
		}
		
		// validate date
		// check for no values, default values, or invalid values
		// the above regex will cover all cases since it's looking for a specific date format
		if ( ! preg_match( $this->settings['date_format_strings'][ $this->settings['date_format'] ]['regex'], $post['room_all_checkin'] )
			|| ! preg_match( $this->settings['date_format_strings'][ $this->settings['date_format'] ]['regex'], $post['room_all_checkout'] ) ) {
			$errors[] = sprintf( __( 'Select booking dates. They must be in format %s', 'quitenicebooking' ), $this->settings['date_format_strings'][ $this->settings['date_format'] ]['display'] );
		} else {
			// check whether the checkout is the same as, or before the checkin
			// convert the times to unix and compare them
			$room_all_checkin = Quitenicebooking_Utilities::to_timestamp($post['room_all_checkin'], $this->settings);
			$room_all_checkout = Quitenicebooking_Utilities::to_timestamp($post['room_all_checkout'], $this->settings);
			
			if ( $room_all_checkin >= $room_all_checkout ) {
				$errors[] = __( 'Check out date must be after check in date', 'quitenicebooking' );
			}
		}
		// validate rooms
		// there must be at least 1 room
		if ( $post['room_qty'] < 1 ) {
			$errors[] = __( 'Select at least 1 room for this booking', 'quitenicebooking' );
		} else {
			// validate guests
			// each room must have at least 1 guest
			for ( $r = 1; $r <= $post['room_qty']; $r++ ) {
				if ( $post['room_'.$r.'_adults'] + $post['room_'.$r.'_children'] < 1 ) {
					$errors[] = sprintf( __( 'Select at least 1 guest for Room %d', 'quitenicebooking' ), $r );
				}
			}
			
			// entire booking must have at least 1 adult
			$total_adults = 0;
			for ( $r = 1; $r <= $post['room_qty']; $r++ ) {
				$total_adults += $post['room_'.$r.'_adults'];
			}
			if ($total_adults < 1) {
				$errors[] = __('Booking must have at least 1 adult', 'quitenicebooking');
			}
		}
		// store the booking data into the session
		$_SESSION['booking'] = $post;
		// redirect to the appropriate page
		if ( count( $errors ) > 0 ) {
			$_SESSION['errors'] = $errors;
			wp_redirect( $this->settings['step_1_url'] ); exit;
		} else {
			$this->booking_step_2_processing( $post );
		}
	}
	
	/**
	 * Step 2 validation
	 * @param array $post The filtered $_POST superglobal
	 */
	public function booking_step_2_validation( $post ) {
		// array to collect errors
		$errors = array();
		
		// determine which form is being submitted -- "edit reservation" or "select bed/room"
		// first, collect all $post keys into a string
		$post_keys = implode(' ', array_keys($post));
		// do a regex search
		$m = array();
		if ( preg_match( '/room_(\d+)_selection/', $post_keys, $m ) ) {
			// "select bed/room" being submitted
			// from "select bed/room" form: type=<id>&bed=<bed>
			$n = $m[1];
			$type = $post['room_'.$n.'_selection'];
			$t = array();
			if ( preg_match('/type=(.+)&bed=(.+)/', $post['room_'.$n.'_selection'], $t) ) {
				// validate id exists and is of type 'accommodation'
				if ( ! empty( $t[1] ) && get_post_type( $t[1] ) != 'accommodation' ) {
					$errors[] = __( 'Invalid room selected', 'quitenicebooking' );
				}
				if ( ! empty( $t[2] ) ) {
					// validate bed exists and is one of the defined, or 0 if room.  don't allow any other values
					$found = FALSE;
					$beds = new Quitenicebooking_Beds();
					foreach (array_keys($beds->keys['beds']) as $bed ) {
						if ( $t[2] == $bed ) {
							$found = TRUE;
							break;
						}
					}
					if ( $t[2] == '0' ) {
						// room selected
						$found = TRUE;
					}
					
					if ( ! $found ) {
						$errors[] = __( 'Invalid bed/room selected', 'quitenicebooking' );
					}
				}
			} else {
				// match failed, or editing previous selection
				if ( $post['room_'.$n.'_selection'] != '' ) {
					$errors[] = __( 'Invalid bed/room selection', 'quitenicebooking' );
				}
				// else, empty selection is valid, so don't do anything
			}
			
		} else {
			if ( preg_match( '/room_(\d+)_checkin/', $post_keys, $m ) ) {
				// "edit reservation" being submitted
				// $m[1] contains the substep (room) number, move it out to $n
				$n = $m[1];
				// validate required fields
				if ( ! isset( $post['room_'.$n.'_checkin'] )
					|| ! isset( $post['room_'.$n.'_checkout'] )
					|| ! isset( $post['room_'.$n.'_adults'] )
					|| ! isset( $post['room_'.$n.'_children'] ) ) {
					$errors[] = __('Please fill in all the required fields', 'quitenicebooking');
				}
				// validate dates
				// check for no values, default values, or invalid values
				if ( ! preg_match( $this->settings['date_format_strings'][ $this->settings['date_format'] ]['regex'], $post['room_'.$n.'_checkin'] )
					|| ! preg_match( $this->settings['date_format_strings'][ $this->settings['date_format'] ]['regex'], $post['room_'.$n.'_checkout'] ) ) {
					$errors[] = __( 'Please fill in all the required fields', 'quitenicebooking' );
				} else {
					// check whether checkout is the same as, or before the checkin
					// convert times to unix and compare them
					$checkin = Quitenicebooking_Utilities::to_timestamp($post['room_'.$n.'_checkin'], $this->settings);
					$checkout = Quitenicebooking_Utilities::to_timestamp($post['room_'.$n.'_checkout'], $this->settings);

					if ( $checkin >= $checkout ) {
						$errors[] = __( 'Check out date must be after check in date', 'quitenicebooking' );
					}	
				}
				
				// validate number of guests
				// adults + children >= 1
				if ( $post['room_'.$n.'_adults'] + $post['room_'.$n.'_children'] < 1 ) {
					$errors[] = __( 'Room must have at least 1 guest', 'quitenicebooking' );
				}
				
				// TODO
				// merge the booking with post and check for:
				// whether total adults < 1
				
			} else {
				// case where checkin is missing, or submission is simply unknown
				$errors[] = __( 'Please fill in all the required fields', 'quitenicebooking' );
			}
		} // end validation checks
		
		// if there were errors, put the errors array into the session
		// don't touch the $_SESSION booking data
		// don't do redirection here.  have the step_2_processing detect the presence of errors; if errors exist, ignore post
		if (count($errors) > 0) {
			$_SESSION['errors'] = $errors;
		}
		$this->booking_step_2_processing( $post );
	}
	
	/**
	 * Step 3 validation
	 * @param array $post The filtered $_POST superglobal
	 */
	public function booking_step_3_validation( $post ) {
		// array to collect errors
		$errors = array();
		
		foreach ( $post as $key => &$val ) {
			if (is_string($val)) {
				$val = trim($val);
			}
		}
		unset( $val );

		$missing_required_fields = FALSE;

		// skip form validation if coupon codes being applied
		if (!(isset($this->coupon_class) && is_object($this->coupon_class) && (isset($post['apply_coupon']) || isset($post['remove_coupon'])))) {

			// validate all required form fields to make sure they exist
			if (empty($post['guest_first_name'])
				|| empty($post['guest_last_name'])
				|| empty($post['guest_email']) ) {
				$missing_required_fields = TRUE;
			}
			$form_fields = Quitenicebooking_Utilities::decode_reservation_form($this->settings);
			foreach ($form_fields as $field) {
				if (!empty($field['required']) && empty($post['guest_details_'.$field['id']])) {
					$missing_required_fields = TRUE;
				}
			}

			if ($missing_required_fields) {
				$errors[] = __( 'Please fill in all the required fields', 'quitenicebooking' );
			}

			// validate email address
			if ( ! is_email( $post['guest_email'] ) ) {
				$errors[] = __( 'Please enter a valid email address', 'quitenicebooking' );
			}

			// validate a payment method has been chosen, if enabled
			if ( !empty($this->settings['deposit_type']) && ( ( !empty($this->settings['accept_paypal']) && !empty($this->settings['paypal_email_address']) ) || !empty($this->settings['accept_bank_transfer']) ) ) {
				if ( ! isset( $post['payment_method'] ) || $post['payment_method'] != 'paypal' && $post['payment_method'] != 'bank_transfer' ) {
					$errors[] = __( 'Please select a payment method', 'quitenicebooking' );
				}
			}
		
		}

		// validate coupon code
		if (isset($this->coupon_class) && is_object($this->coupon_class)) {
			// iterate through the posted coupons
			foreach ($post as $p => $v) {
				if (preg_match('/^coupon_code_\d+/', $p) && !empty($v)) {
					if (!empty($post['remove_coupon']) && $post['remove_coupon'] == $p) {
						// remove any coupons
						unset($post[$p]);
					} elseif (!$this->coupon_class->validate_coupon($v)) {
						$errors[] = __('The coupon code is not valid', 'quitenicebooking');
						unset($post[$p]);
					}
				}
			}
		}

		// if validation fails, go to step 3
		// if validation fails, or a coupon code is posted, go to step 3
		if (count($errors) > 0 || isset($post['apply_coupon']) || isset($post['remove_coupon'])) {
			$_SESSION['errors'] = $errors;
			$_SESSION['post'] = $post;
			$this->booking_step_3_processing($post);
		} else {
			// if validation succeeds, go to step 4
 			// merge the booking with post
			$_SESSION['booking'] = array_merge(isset($_SESSION['booking']) ? $_SESSION['booking'] : array(), $post);
			$this->booking_step_4_processing();
		}
	}
	
	/**
	 * Processing ==============================================================
	 */
	
	/**
	 * Step 2 processing
	 * @param array $post The filtered $_POST superglobal
	 */
	public function booking_step_2_processing( $post ) {
		// 1.
		// if the request came from step 1, clear the session data
		if (isset($post['booking_step_1_submit'])) {
			session_unset();
			unset($post['booking_step_1_submit']);
		}

		// 2A.
		// check if errors exist.  don't touch $post if errors exist
		if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
			$booking = isset($_SESSION['booking']) ? $_SESSION['booking'] : array();
		} else {
		// 2.
		// make an array that contains the accumulated booking request by
		// retrieving any booking data from $_SESSION and merging it with $_REQUEST, overwriting $_SESSION
			$booking = array_merge(isset($_SESSION['booking']) ? $_SESSION['booking'] : array(), $post);
		}
		
		// 3.
		// initialization from step 1
		// if $room_all_checkin and $room_all_checkout are set, assign them to all the rooms
		// but, do not overwrite if they don't already exist
		for ($n = 1; $n <= $booking['room_qty']; $n ++) {
			if (isset($booking['room_all_checkin'])) {
				if (!isset($booking['room_'.$n.'_checkin'])) {
					$booking['room_'.$n.'_checkin'] = $booking['room_all_checkin'];
				}
			}
			if (isset($booking['room_all_checkout'])) {
				if (!isset($booking['room_'.$n.'_checkout'])) {
					$booking['room_'.$n.'_checkout'] = $booking['room_all_checkout'];
				}
			}
		}

		// 4.
		// initialization from step 1, continued
		// prune room_n_adults and room_n_children to room_qty
		for ($n = $booking['room_qty'] + 1; $n <= $this->settings['max_rooms']; $n ++) {
			unset($booking['room_'.$n.'_adults']);
			unset($booking['room_'.$n.'_children']);
		}

		// 5.
		// now check how many rooms have been requested, and how many are done
		// put the rooms that need to be selected in $pending
		// put the rooms that have been booked in $live_bookings and $selected
		$pending = array();
		$selected = array();
		$live_bookings = array();
		for ($n = 1; $n <= $booking['room_qty']; $n ++) {
			if (!isset($booking['room_'.$n.'_selection']) || empty($booking['room_'.$n.'_selection'])) {
				$pending[] = $n;
			} else {
				$selected[] = $n;
				$m = array();
				// capture type into $m[1], bed into $m[2]
				// if selecting a room with no beds, $m[2] will be 0
				preg_match('/type=(.+)&bed=(.+)/', $booking['room_'.$n.'_selection'], $m);
				$live_bookings[$n]['checkin'] = $booking['room_'.$n.'_checkin'];
				$live_bookings[$n]['checkout'] = $booking['room_'.$n.'_checkout'];
				$live_bookings[$n]['type'] = $m[1];
				$live_bookings[$n]['bed'] = $m[2];
				$live_bookings[$n]['adults'] = $booking['room_'.$n.'_adults'];
				$live_bookings[$n]['children'] = $booking['room_'.$n.'_children'];
			}
		}
		
		// 6.A.
		// if there are no pending rooms left, go to step 3
		if (count($pending) == 0) {
			$_SESSION['booking'] = $booking;
			$this->booking_step_3_processing($post);
			// issue exit from step 3's redirect
		}

		// 6.
		// now check for availabilty for the first pending room
		$current_room['checkin'] = $booking['room_'.$pending[0].'_checkin'];
		$current_room['checkout'] = $booking['room_'.$pending[0].'_checkout'];
		$current_room['adults'] = $booking['room_'.$pending[0].'_adults'];
		$current_room['children'] = $booking['room_'.$pending[0].'_children'];
		$current_room['total_guests'] = $current_room['adults'] + $current_room['children'];

		$available_rooms = $this->booking_step_2_find_rooms($current_room['checkin'], $current_room['checkout'], $current_room['total_guests'], $live_bookings);

		// 7.
		// calculate price breakdown for each available room
		foreach ($available_rooms as &$available_room) {
			$available_room['price_breakdown'] = $this->make_price_breakdown($available_room, $current_room);
		}
		unset($available_room);

		// 8.
		// prepare a form to show available rooms for the first pending room
		$data['current_substep'] = $booking['room_qty'] - count($pending) + 1;
		$data['total_substeps'] = $booking['room_qty'];
		$data['room_number'] = count($pending) > 0 ? $pending[0] : NULL;
		$data['prev_room_number'] = count($selected) > 0 ? $selected[count($selected) - 1] : NULL;
		$data['room_'.$pending[0].'_checkin'] = $booking['room_'.$pending[0].'_checkin'];
		$data['room_'.$pending[0].'_checkout'] = $booking['room_'.$pending[0].'_checkout'];
		$data['room_'.$pending[0].'_adults'] = $booking['room_'.$pending[0].'_adults'];
		$data['room_'.$pending[0].'_children'] = $booking['room_'.$pending[0].'_children'];
		$data['available_rooms'] = $available_rooms;
		if ( isset( $booking['highlight'] ) && ! empty( $booking['highlight'] ) ) {
			// 8.A.
			// get the highlighted room, regardless of availability
			$data['highlight_room'] = $this->accommodation_post->get_single_accommodation( $booking['highlight'] );
			if ( count( $data['highlight_room'] ) > 0 ) {
				// allow the room to be displayed only if found/valid
				$data['highlight'] = $booking['highlight'];
			}
		}

		// 9.
		// update the booking in the $_SESSION
		$_SESSION['booking'] = $booking;

		// 10.
		// store the data into $_SESSION and redirect/GET step 2 url
		$_SESSION['data'] = $data;
		wp_redirect( $this->settings['step_2_url'] ); exit;
	}
	
	/**
	 * Step 2 processing -- find rooms
	 *
	 * @global $wpdb The wpdb object
	 * @param $checkin string The checkin date
	 * @param $checkout string The checkout date
	 * @param $totalguests int The total number of guests
	 * @param array $live_bookings An array of live bookings:
	 *   [ 0 => // int key
	 *     ['checkin' => // string The checkin date
	 *      'checkout' => // string The checkout date
	 *      'type' => // string The room type
	 *      'bed' => // string The bed type
	 *      'adults' => // int Number of adults
	 *      'children' => // int Number of children
	 *     ]
	 *   ]
	 * @return array An array of available rooms
	 */
	public function booking_step_2_find_rooms($checkin, $checkout, $total_guests, $live_bookings) {
		global $wpdb;

		// 1.
		// create a pivot table of the existing bookings
		$this->booking_post->create_live_bookings_table();
		
		// 2.
		// for each of the live bookings made, insert them into the pivot table
		for ($l = 1; $l <= count($live_bookings); $l ++) {
			// convert dates to unix time
			$live_bookings[$l]['checkin'] = Quitenicebooking_Utilities::to_timestamp($live_bookings[$l]['checkin'], $this->settings);
			$live_bookings[$l]['checkout'] = Quitenicebooking_Utilities::to_timestamp($live_bookings[$l]['checkout'], $this->settings);
			
			$this->booking_post->add_live_booking($live_bookings[$l]);
		}

		// 3.
		// bring all the accomodations into all_rooms
		// it's needed as an argument to the collision summary table
		// all_rooms is also needed later when the collisions are subtracted from it
		$all_rooms = $this->accommodation_post->get_all_accommodations();

		// 4.
		// get the collision summary table
		// convert all dates to unix time
		$datefrom = Quitenicebooking_Utilities::to_timestamp($checkin, $this->settings);
		$dateto = Quitenicebooking_Utilities::to_timestamp($checkout, $this->settings);
		
		$usage = $this->booking_post->make_collision_summary($datefrom, $dateto, array_keys($all_rooms));

		// 5.
		// now, to subtract the collision summary data from the accommodation data
		// interate through all_rooms, and delete any rooms where:
		// 1. total_guests > room_occupancy
		// 2. $usage > rooms_available
		// 3. blocked
		// for any rooms that don't get deleted, decrement the bed counter and room counter
		foreach ($all_rooms as $room => &$v) {
			// delete room if: 3. blocked
			if (is_object($this->booking_post->booking_block) && $this->booking_post->booking_block->is_blocked($datefrom, $dateto, $v['id'])) {
				unset($all_rooms[$room]);
			} elseif ($total_guests > $v['quitenicebooking_max_occupancy']) {
				// delete room if: 1. total_guests > room_occupancy
				unset($all_rooms[$room]);
			} elseif ($usage[$room]['max_concurrent_rooms'] >= $v['quitenicebooking_room_quantity']) {
				// delete room if: 2. $usage > rooms_available
				unset($all_rooms[$room]);
			} else {
				// retain room
				// decrement room counter
				$v['quitenicebooking_room_quantity'] -= $usage[$room]['max_concurrent_rooms'];
			}
		}
		unset($v);

		return $all_rooms;
	}

	/**
	 * Validate all requested rooms are available
	 *
	 * @global WPDB $wpdb
	 * @param array $live_bookings
	 * @return boolean TRUE if all are available, FALSE if any are not
	 */
	public function step_4_validate_rooms($live_bookings) {
		global $wpdb;
		
		// create live bookigns table
		$this->booking_post->create_live_bookings_table();
		// add live bookings
		foreach ($live_bookings as $l) {
			$this->booking_post->add_live_booking(array(
				'checkin' => Quitenicebooking_Utilities::to_timestamp($l['checkin'], $this->settings),
				'checkout' => Quitenicebooking_Utilities::to_timestamp($l['checkout'], $this->settings),
				'type' => $l['type'],
				'bed' => $l['bed'],
				'adults' => $l['adults'],
				'children' => $l['children']
			));
		}

		// get all accommodations
		$all_rooms = $this->accommodation_post->get_all_accommodations();
		// get collision summary for each room
		foreach ($live_bookings as $l) {
			// check if room is blocked
			if (is_object($this->booking_post->booking_block) && $this->booking_post->booking_block->is_blocked(Quitenicebooking_Utilities::to_timestamp($l['checkin'], $this->settings), Quitenicebooking_Utilities::to_timestamp($l['checkout'], $this->settings), $l['type'])) {
				return false;
			}
			$usage = $this->booking_post->make_collision_summary(
				Quitenicebooking_Utilities::to_timestamp($l['checkin'], $this->settings),
				Quitenicebooking_Utilities::to_timestamp($l['checkout'], $this->settings),
				array($l['type'])
			);
			
			// check if room is overbooked
			if ($usage[$l['type']]['max_concurrent_rooms'] > $all_rooms[$l['type']]['quitenicebooking_room_quantity']) {
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Generate a price breakdown
	 *
	 * @param	array	$room		The room to generate the breakdown for
	 * @param	array	$booking	A single booking for a single room
	 *	['checkin']		string		The checkin date string (not unix timestamp)
	 *	['checkout']	string		The checkout date string (not unix timestamp)
	 *	['adults']		int			The number of adults
	 *	['children']	int			The number of children
	 *	['total_guests']int			The total number of guests
	 * @return	array	The price breakdown
	 *	[$type]							array	The name of the room
	 *		['breakdown']				array	The breakdown
	 *			['day']					array	The day number (unix timestamp)
	 *				['date_string']		string	The long form of the date to be displayed
	 *				['price_string']	string	The price breakdown as a string
	 *				['subtotal']		float	The day's subtotal
	 *		['total']					float	The grand total for the room
	 */
	public function make_price_breakdown($room, $booking) {
		$breakdown = array();
		
		$breakdown['type'] = $room['title'];
		$breakdown['breakdown'] = array();
		
		// get unix timestamps
		$checkin = Quitenicebooking_Utilities::to_timestamp($booking['checkin'], $this->settings);
		$checkout = Quitenicebooking_Utilities::to_timestamp($booking['checkout'], $this->settings);
		
		$booking_price = $this->accommodation_post->calc_booking_price($checkin, $checkout, $room['id'], array('adults' => $booking['adults'], 'children' => $booking['children']));
		foreach ($booking_price['subtotals'] as $day => $subtotal) {
			/* translators: Date format in price breakdown, see http://codex.wordpress.org/Formatting_Date_and_Time */
			$breakdown['breakdown'][$day]['date_string'] = date_i18n(__('D jS F Y', 'quitenicebooking'), $day);
			$breakdown['breakdown'][$day]['subtotal'] = $subtotal;
			
			// create price string // TODO get name of entities and unit prices of entities
			$price_string = '';
			if ($booking['adults'] > 0) {
				$price_string .= $booking['adults'].' '._n('Adult', 'Adults', $booking['adults'], 'quitenicebooking').', ';
			}
			if ($booking['children'] > 0) {
				$price_string .= $booking['children'].' '._n('Child', 'Children', $booking['children'], 'quitenicebooking').', ';
			}
			
			$price_string = substr($price_string, 0, -2);
			$price_string .= ': '.Quitenicebooking_Utilities::format_price($subtotal, $this->settings);
			
			$breakdown['breakdown'][$day]['price_string'] = $price_string;
		}
		$breakdown['total'] = $booking_price['total'];

		return $breakdown;
	}
	
	/**
	 * Calculates the deposit for a booking
	 * 
	 * @param	array	$breakdown	A breakdown of the booking
	 *	[type]					int		The room type
	 *		['breakdown']		array	The breakdown
	 *			[day]			int		The unix timestamp
	 *				[subtotal]	float	The subtotal
	 * @param float $discount_amt The discount amount
	 * @return float The deposit amount
	 */
	public function calculate_deposit($breakdown, $discount_amt = 0) {
		// disabled
		if ($this->settings['deposit_type'] == ''
			|| ((empty($this->settings['accept_paypal']) || empty($this->settings['paypal_email_address'])) && empty($this->settings['accept_bank_transfer'])) ) {
			return 0;
		}
		
		// percentage
		if ($this->settings['deposit_type'] == 'percentage') {
			$total = 0;
			foreach ($breakdown as $b) {
				foreach ($b['breakdown'] as $d) {
					$total += $d['subtotal'];
				}
			}
			$total -= $discount_amt;
			return round(floatval($this->settings['deposit_percentage']) / 100 * $total, 0);
		}
		
		// flat
		if ($this->settings['deposit_type'] == 'flat') {
			return $this->settings['deposit_flat'];
		}
		
		// duration
		if ($this->settings['deposit_type'] == 'duration') {
			$total = 0;
			foreach ($breakdown as $b) {
				$day_count = 0;
				foreach ($b['breakdown'] as $d) {
					$total += $d['subtotal'];
					$day_count ++;
					if ($day_count >= $this->settings['deposit_duration']) {
						break;
					}
				}
			}
			return $total;
		}
		
	}
	
	/**
	 * Step 3 processing
	 *
	 * @param array $post The $_POST superglobal
	 */
	public function booking_step_3_processing($post) {
		// booking data should be all validated now.  don't merge it with $post
		$booking = $_SESSION['booking'];

		// put all the coupons in an array
		if (isset($this->coupon_class) && is_object($this->coupon_class)) {
			foreach ($post as $p => $v) {
				if (preg_match('/^coupon_code_\d+/', $p) && !empty($v)) {
					$applied_coupons[] = $v;
				}
			}
		}

		// put live booking into $live_bookings
		$live_booking = array();
		for ($n = 1; $n <= $booking['room_qty']; $n ++) {
			$m = array();
			preg_match('/type=(.+)&bed=(.+)/', $booking['room_'.$n.'_selection'], $m);
			$live_booking[$n]['checkin'] = $booking['room_'.$n.'_checkin'];
			$live_booking[$n]['checkout'] = $booking['room_'.$n.'_checkout'];
			$live_booking[$n]['type'] = $m[1];
			$live_booking[$n]['bed'] = $m[2];
			$live_booking[$n]['adults'] = $booking['room_'.$n.'_adults'];
			$live_booking[$n]['children'] = $booking['room_'.$n.'_children'];
			$live_booking[$n]['total_guests'] = $live_booking[$n]['adults'] + $live_booking[$n]['children'];
		}
		// get all rooms
		$all_rooms = $this->accommodation_post->get_all_accommodations();

		$breakdown = array();
		$total = 0;

		// foreach live booking, calculate
		foreach ($live_booking as $l) {
			$row = array();
			$row = $this->make_price_breakdown($all_rooms[$l['type']], $l);
			$total += $row['total'];
			$breakdown[] = $row;
		}

		$discount_amt = 0;
		// apply the coupons and collect errors for those that cannot be applied because of requirement checks
		if (isset($applied_coupons)) {
			// iterate through the breakdown and apply the discount
			$discounts = array();
			$coupon_errors = array();
			$discount_amt = $this->coupon_class->apply_discount($applied_coupons, $breakdown, $total, $discounts, $coupon_errors);
			$data['discounts'] = $discounts;
			$data['errors'] = $coupon_errors;
			$data['applied_coupons'] = $applied_coupons;
		}

		$data['breakdown'] = $breakdown;		
		$data['total'] = $total;
		$data['deposit'] = $this->calculate_deposit($breakdown, $discount_amt);
		$data['total_rooms'] = $booking['room_qty'];
		foreach ($live_booking as $l) {
			$row = array();
			$row['type'] = $all_rooms[$l['type']]['title'];
			$row['checkin'] = $l['checkin'];
			$row['checkout'] = $l['checkout'];
			$row['guests'] = !empty($l['adults']) ? $l['adults'].' '._n('Adult', 'Adults', $l['adults'], 'quitenicebooking').', ' : '';
			$row['guests'] .= !empty($l['children']) ? $l['children'].' '._n('Child', 'Children', $l['children'], 'quitenicebooking').', ' : '';
			$row['guests'] = substr($row['guests'], 0, -2);
			$data['summary'][] = $row;
		}

		$_SESSION['data'] = $data;
		wp_redirect( $this->settings['step_3_url'] ); exit;
	}
	
	/**
	 * Step 4 processing
	 * 
	 * @global WPDB $wpdb
	 */
	public function booking_step_4_processing() {
		if ( ! isset( $_SESSION['booking'] ) || count( $_SESSION['booking'] ) == 0 || ! isset( $_SESSION['booking']['room_qty'] ) ) {
			return;
		}

		$booking = $_SESSION['booking'];

		// put all the coupons in an array
		if (isset($this->coupon_class) && is_object($this->coupon_class)) {
			foreach ($booking as $p => $v) {
				if (preg_match('/^coupon_code_\d+/', $p) && !empty($v)) {
					$applied_coupons[] = $v;
				}
			}
		}

		// begin summary table
		$live_booking = array();
		for ($n = 1; $n <= $booking['room_qty']; $n ++) {
			$m = array();
			preg_match('/type=(.+)&bed=(.+)/', $booking['room_'.$n.'_selection'], $m);
			$live_booking[$n]['checkin'] = $booking['room_'.$n.'_checkin'];
			$live_booking[$n]['checkout'] = $booking['room_'.$n.'_checkout'];
			$live_booking[$n]['type'] = $m[1];
			$live_booking[$n]['bed'] = $m[2];
			$live_booking[$n]['adults'] = $booking['room_'.$n.'_adults'];
			$live_booking[$n]['children'] = $booking['room_'.$n.'_children'];
			$live_booking[$n]['total_guests'] = $live_booking[$n]['adults'] + $live_booking[$n]['children'];
		}
		
		// do the live check one last time, if there's an error (any rooms or beds returning false) popup an error message to go back to step 2
		$rooms_valid = $this->step_4_validate_rooms($live_booking);
		if (!$rooms_valid) {
			$errors[] = __('One or more of your requested rooms have become unavailable since the booking process began.  Please reselect your rooms.  We apologize for the inconvenience.', 'quitenicebooking');
			for ($n = 1; $n <= $booking['room_qty']; $n ++) {
				unset($booking["room_{$n}_selection"]);
			}
			if (isset($booking['guest_email'])) {
				// remove the email so that validation can kick in again at step 3
				unset($booking['guest_email']);
			}
			$_SESSION['booking'] = $booking;
			$_SESSION['errors'] = $errors;
			$this->booking_step_2_processing($_POST);
		}

		$all_rooms = $this->accommodation_post->get_all_accommodations();

		$breakdown = array();
		$total = 0;

		foreach ($live_booking as $l) {
			$row = array();
			$row = $this->make_price_breakdown($all_rooms[$l['type']], $l);
			$total += $row['total'];
			$breakdown[] = $row;
		}

		$discount_amt = 0;
		// apply the coupons and collect errors for those that cannot be applied because of requirement checks
		if (isset($applied_coupons)) {
			// iterate through the breakdown and apply the discount
			$discounts = array();
			$coupon_errors = array();
			$discount_amt = $this->coupon_class->apply_discount($applied_coupons, $breakdown, $total, $discounts, $coupon_errors);
			$data['discounts'] = $discounts;
//			$data['errors'] = $coupon_errors;
			$data['applied_coupons'] = $applied_coupons;
		}
		
		$data['breakdown'] = $breakdown;
		$data['total'] = $total;
		$data['deposit'] = $this->calculate_deposit($breakdown, $discount_amt);
		$data['total_rooms'] = $booking['room_qty'];
		$data['guest_first_name'] = $booking['guest_first_name'];
		$data['guest_last_name'] = $booking['guest_last_name'];
		$data['guest_email'] = $booking['guest_email'];
		foreach ($live_booking as $l) {
			$row = array();
			$row['type'] = $all_rooms[$l['type']]['title'];
			$row['checkin'] = $l['checkin'];
			$row['checkout'] = $l['checkout'];
			$row['guests'] = !empty($l['adults']) ? $l['adults'].' '._n('Adult', 'Adults', $l['adults'], 'quitenicebooking').', ' : '';
			$row['guests'] .= !empty($l['children']) ? $l['children'].' '._n('Child', 'Children', $l['children'], 'quitenicebooking').', ' : '';
			$row['guests'] = substr($row['guests'], 0, -2);
			$data['summary'][] = $row;
		}
		// end summary table

		// add booking
		if (empty($this->settings['disable_database'])) {

			// get the earliest and latest booking date
			$first_checkin = NULL;
			$last_checkout = NULL;
			foreach ($live_booking as $l) {
				if ($first_checkin === NULL || Quitenicebooking_Utilities::to_timestamp($l['checkin'], $this->settings) < $first_checkin) {
					$first_checkin = Quitenicebooking_Utilities::to_timestamp($l['checkin'], $this->settings);
				}
				if ($last_checkout === NULL || Quitenicebooking_Utilities::to_timestamp($l['checkout'], $this->settings) > $last_checkout) {
					$last_checkout = Quitenicebooking_Utilities::to_timestamp($l['checkout'], $this->settings);
				}
			}
			$first_checkin = substr(date($this->settings['date_format_strings'][$this->settings['date_format']]['php'], $first_checkin), 0, -9);
			$last_checkout = substr(date($this->settings['date_format_strings'][$this->settings['date_format']]['php'], $last_checkout), 0, -9);

			$post_id = wp_insert_post(array(
				'post_title' => sprintf(__('%d room booking for %s %s (%s - %s)', 'quitenicebooking'), $booking['room_qty'], $booking['guest_first_name'], $booking['guest_last_name'], $first_checkin, $last_checkout),
				'post_type' => 'booking',
				'post_status' => 'publish'
			));
			// booking id
			$data['booking_id'] = $post_id;
			add_post_meta($post_id, 'quitenicebooking_booking_id', $post_id);

			// guest details
			add_post_meta($post_id, 'quitenicebooking_guest_last_name', $booking['guest_last_name']);
			add_post_meta($post_id, 'quitenicebooking_guest_first_name', $booking['guest_first_name']);
			add_post_meta($post_id, 'quitenicebooking_guest_email', $booking['guest_email']);

			$form_fields = Quitenicebooking_Utilities::decode_reservation_form($this->settings);
			$guest_details = array();
			foreach ($form_fields as $field) {
				if (in_array($field['type'], array('guest_first_name', 'guest_last_name', 'guest_email'))) {
					continue;
				}
				$guest_details[$field['id']]['label'] = $field['label'];
				if (!empty($booking['guest_details_'.$field['id']])) {
					if (is_array($booking['guest_details_'.$field['id']])) {
						$guest_details[$field['id']]['value'] = implode(', ', $booking['guest_details_'.$field['id']]);
					} else {
						$guest_details[$field['id']]['value'] = $booking['guest_details_'.$field['id']];
					}
				} else {
					$guest_details[$field['id']]['value'] = '';
				}
				$guest_details[$field['id']]['type'] = $field['type'];
			}
			add_post_meta($post_id, 'quitenicebooking_guest_details', json_encode($guest_details));

			// booking details
			global $wpdb;
			for ($l = 1; $l <= count($live_booking); $l ++) {
				// if WPML is enabled, insert rows into database for the room type and all its translations
				if (defined('ICL_SITEPRESS_VERSION')) {
					global $sitepress;
					// get the trid (group) of the accommodation
					$trid = $sitepress->get_element_trid($live_booking[$l]['type'], 'post_accommodation');
					// find all translations of the accommodation
					$accommodation_translations = $sitepress->get_element_translations($trid, 'post_accommodation');
					// add a db row for each of the translations
					foreach ($accommodation_translations as $at) {
						$wpdb->insert("{$wpdb->prefix}qns_bookings", array(
							'post_id' => $post_id,
							'room_booking_id' => $l,
							'checkin' => date('Y-m-d H:i:s', Quitenicebooking_Utilities::to_timestamp($live_booking[$l]['checkin'], $this->settings)),
							'checkout' => date('Y-m-d H:i:s', Quitenicebooking_Utilities::to_timestamp($live_booking[$l]['checkout'], $this->settings)),
							'type' => $at->element_id,
							'bed' => $live_booking[$l]['bed'],
							'adults' => $live_booking[$l]['adults'],
							'children' => $live_booking[$l]['children']
						));
					}
				} else {
					// insert row into database
					$wpdb->insert("{$wpdb->prefix}qns_bookings", array(
						'post_id' => $post_id,
						'room_booking_id' => $l,
						'checkin' => date('Y-m-d H:i:s', Quitenicebooking_Utilities::to_timestamp($live_booking[$l]['checkin'], $this->settings)),
						'checkout' => date('Y-m-d H:i:s', Quitenicebooking_Utilities::to_timestamp($live_booking[$l]['checkout'], $this->settings)),
						'type' => $live_booking[$l]['type'],
						'bed' => $live_booking[$l]['bed'],
						'adults' => $live_booking[$l]['adults'],
						'children' => $live_booking[$l]['children']
					));
				}
			}

			// payment details
			add_post_meta($post_id, 'quitenicebooking_deposit_amount', $data['deposit']);
			add_post_meta($post_id, 'quitenicebooking_total_price', $data['total']);
			add_post_meta($post_id, 'quitenicebooking_deposit_method', isset($booking['payment_method']) ? $booking['payment_method'] : '');

			// coupon details
			if (isset($applied_coupons)) {
				add_post_meta($post_id, 'quitenicebooking_coupon_codes', implode(', ', $data['applied_coupons']));
				$this->coupon_class->use_coupons($data['applied_coupons']);
			}
		}
		// set post_id to 0 if database disabled
		if (!empty($this->settings['disable_database'])) {
			$post_id = 0;
		}
		// payment method
		$data['payment_method'] = isset($booking['payment_method']) ? $booking['payment_method'] : '';
		if (isset($booking['payment_method']) && $booking['payment_method'] == 'paypal') {
			$return_url = !empty($this->settings['payment_success_url']) ? $this->settings['payment_success_url'] : get_site_url();
			$hash = substr(sha1('quitenicebooking'.$booking['guest_last_name'].$booking['guest_first_name']), 0, 6);
			if (!empty($this->settings['payment_success_url'])) {
				if (strpos($this->settings['payment_success_url'], '?') !== FALSE) {
					// if permalink structure already contains a query string, append to it
					$return_url .= '&booking_id='.$post_id.'&key='.$hash;
				} else {
					// else, supply it as the first argument
					$return_url .= '?booking_id='.$post_id.'&key='.$hash;
				}
			}
			// build paypal query string
			$paypal_query_str = array(
				'business' => $this->settings['paypal_email_address'],
				'cmd' => '_xclick',
				'item_name' => get_bloginfo('name').' '.sprintf(__('Room deposit for %s %s (Booking ID: %s)'), $booking['guest_first_name'], $booking['guest_last_name'], $post_id),
				'amount' => $data['deposit'],
				'currency_code' => $this->settings['paypal_currency'],
				'no_shipping' => 1,
				'return' => $return_url,
				'cancel_return' => !empty($this->settings['payment_fail_url']) ? $this->settings['payment_fail_url'] : get_site_url(),
			);
			$data['redirect'] = 'https://www.paypal.com/cgi-bin/webscr?'.http_build_query($paypal_query_str);
		}

		// email guest
		$mailfrom = array('email' => !empty($this->settings['email_address']) ? $this->settings['email_address'] : get_bloginfo('admin_email'), 'name' => get_bloginfo('name'));
		$mailto = array('email' => $booking['guest_email']);
		$mailsubject = html_entity_decode(sprintf(__('%s booking confirmation', 'quitenicebooking'), get_bloginfo('name')));
		$mailmessage = $this->settings['email_message'];
		$mailmessage = preg_replace(
			array(
				'/\[CUSTOMER_FIRST_NAME\]/i',
				'/\[CUSTOMER_LAST_NAME\]/i',
				'/\[HOTEL_NAME\]/i'
			),
			array(
				$booking['guest_first_name'],
				$booking['guest_last_name'],
				get_bloginfo('name')
			),
			$mailmessage
		);
		// premium email
		$data['guest_details'] = $guest_details;
		if (class_exists('Quitenicebooking_Premium_Email_Templates')) {
			$premium_email = new Quitenicebooking_Premium_Email_Templates($this->settings);
			$mailbody = $premium_email->generate_email($data);
		} else {
			ob_start();
			include QUITENICEBOOKING_PATH.'views/mail_user.mail.php';
			$mailbody = ob_get_clean();
		}
		$mailerror = Quitenicebooking_Utilities::send_mail($mailfrom, $mailto, $mailsubject, $mailbody, $this->settings);

		// email admin
		$mailto = array('email' => !empty($this->settings['email_address']) ? $this->settings['email_address'] : get_bloginfo('admin_email'), 'name' => get_bloginfo('name'));
		$mailsubject = html_entity_decode(sprintf(__('New %d room booking for %s %s', 'quitenicebooking'), $booking['room_qty'], $booking['guest_first_name'], $booking['guest_last_name']));
		ob_start();
		include QUITENICEBOOKING_PATH.'views/mail_admin.mail.php';
		$mailbody = ob_get_clean();
		$mailerror = Quitenicebooking_Utilities::send_mail($mailfrom, $mailto, $mailsubject, $mailbody, $this->settings);

		if ($mailerror !== TRUE) {
			$data['errors'] = array(
				__( 'Your reservation has been made, but the system was unable to send out a confirmation email.  Please contact us for assistance.', 'quitenicebooking' ),
				sprintf( __( 'The error message was: %s', 'quitenicebooking' ), $mailerror )
			);
		}
		// store data in session
		$_SESSION['data'] = $data;
		// redirect to step 4
		wp_redirect( $this->settings['step_4_url'] ); exit;
	}
	
	/**
	 * Ajax availability checker for a single room
	 * 
	 * $post should contain:
	 * current_room = [ checkin, checkout, type, bed, adults, children ]
	 * (optional) checked_rooms = [ 1 => [ checkin, checkout, type, bed, adults, children ],
	 *                              2 => [ checkin, checkout, type, bed, adults, children ],
	 *                              n => [ ... ]
	 *                            ]
	 * post_id = post_id
	 * 
	 * checkin and checkout are in display format; they must be converted back into timestamps
	 */
	public function ajax_check_availability() {
		$post = filter_input_array( INPUT_POST );
		$found = TRUE;
		
		// 1. build pivot table
		$this->booking_post->create_live_bookings_table();
		// 1.A. remove bookings belonging to this post_id from pivot table
		$this->booking_post->remove_live_booking( $post['post_id'] );
		
		// 2. if checked_rooms exist, add as live booking
		if ( isset( $post['checked_rooms'] ) && count( $post['checked_rooms'] ) > 0 ) {
			// convert dates to unix time
			foreach ( $post['checked_rooms'] as $checked_room ) {
				$checked_room['checkin'] = Quitenicebooking_Utilities::to_timestamp($checked_room['checkin'], $this->settings);
				$checked_room['checkout'] = Quitenicebooking_Utilities::to_timestamp($checked_room['checkout'], $this->settings);
				$this->booking_post->add_live_booking($checked_room);
			}
		}
		// 3. get the requested room
		$this_room = $this->accommodation_post->get_single_accommodation($post['current_room']['type'], TRUE);
		// 4. make collision summary
		// convert dates to unix time
		$post['current_room']['checkin'] = Quitenicebooking_Utilities::to_timestamp($post['current_room']['checkin'], $this->settings);
		$post['current_room']['checkout'] = Quitenicebooking_Utilities::to_timestamp($post['current_room']['checkout'], $this->settings);
		$usage = $this->booking_post->make_collision_summary(
			$post['current_room']['checkin'],
			$post['current_room']['checkout'],
			array_keys($this_room)
		);

		// 5.A. check if room is blocked
		if (is_object($this->booking_post->booking_block) && $this->booking_post->booking_block->is_blocked($post['current_room']['checkin'], $post['current_room']['checkout'], $post['current_room']['type'])) {
			$found = 'room_blocked';
		}

		// 5. subtract collision summary from this_room
		// if total_guests > room_occupancy
		if ( $usage[ $post['current_room']['type'] ]['max_concurrent_rooms'] >= $this_room[ $post['current_room']['type'] ]['quitenicebooking_room_quantity']) {
			// if usage > rooms_available
			$found = 'room_qty';
		} elseif ( $post['current_room']['adults'] + $post['current_room']['children'] > $this_room[ $post['current_room']['type'] ]['quitenicebooking_max_occupancy'] ) {
			$found = 'guest_qty';
		}
		
		// return the result
		echo json_encode( $found );
		exit;
	}

	/**
	 * Ajax availability checker for Datepicker calendar
	 *
	 * $_GET should contain:
	 *		year = int
	 *		month = int
	 *		type = int (optional)
	 */
	public function ajax_calendar_availability() {
		$get = filter_input_array(INPUT_GET);

		$year = $get['year'];
		$month = $get['month'];
		$type = !empty($get['type']) ? $get['type'] : FALSE;

		// for each day in the month:
		// 1. build bookings table
		// 2. get all rooms
		// 3. get collisions
		// 4. subtract collisions from all rooms
		// 5. if no rooms available, append this day to the array

		$blocked_days = array();

		$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

		$temp = array();

		for ($day = 1; $day <= $days_in_month; $day ++) {
			$this->booking_post->create_live_bookings_table();

			if ($type === FALSE) {
				$all_rooms = $this->accommodation_post->get_all_accommodations();
			} else {
				$all_rooms = $this->accommodation_post->get_single_accommodation($type);
			}

			$usage = $this->booking_post->make_collision_summary(strtotime($year.'-'.$month.'-'.$day), strtotime($year.'-'.$month.'-'.($day+1)), array_keys($all_rooms));

			foreach ($all_rooms as $room => &$v) {
				if (is_object($this->booking_post->booking_block) && $this->booking_post->booking_block->is_blocked(strtotime($year.'-'.$month.'-'.$day), strtotime($year.'-'.$month.'-'.($day+1)), $v['id'])) {
					// remove blocked rooms
					unset($all_rooms[$room]);
				} elseif ($usage[$room]['max_concurrent_rooms'] >= $v['quitenicebooking_room_quantity']) {
					// remove fully booked rooms
					unset($all_rooms[$room]);
				}
			}
			unset($v);

			if (count($all_rooms) == 0) {
				// if there are no rooms left for the day
				$blocked_days[] = $day;
			}
		}
		echo json_encode($blocked_days);
		exit;
	}

	/**
	 * Utilities ===============================================================
	 */
	
	/**
	 * Renders a view
	 *
	 * @param string $template Path to the template
	 * @param array $data Any data that needs to be passed to the template
	 */
	protected function view($template, $data = NULL) {
		ob_start();
		if ( ! is_null( $data ) && count( $data ) > 0) {
			extract( $data, EXTR_PREFIX_ALL, 'quitenicebooking' );
		}
		include QUITENICEBOOKING_PATH . $template;
		return ob_get_clean();
	}
	
	/**
	 * Debugging methods =======================================================
	 */
	
	/**
	 * Prints out debugging information inside the content
	 * 
	 * @param type $content
	 * @return string
	 */
	public function debug( $content ) {
		ob_start();
		// insert debugging code here
		$out = ob_get_clean();
		return $content.$out;
	}
	
}
