<?php
/**
 * Quitenicebooking_Settings class
 *
 * This class provides settings needed by the Quitenicebooking class
 * It interfaces with WP's Settings API
 * It handles all of the admin pages
 *
 * @package quitenicebooking
 * @author Quite Nice Stuff
 * @copyright Copyright (c) 2013 Quite Nice Stuff
 * @link http://quitenicestuff.com
 * @version 2.5.2
 * @since 2.0.0
 */

class Quitenicebooking_Settings {
	/* Class members ======================================================= */
	/**
	 * An array of settings
	 * @var array
	 */
	public $settings;
	
	/**
	 * A whitelist of allowed settings
	 * @var array
	 */
	public $allowed_settings;
	
	/**
	 * Constructor (should be called via init hook from Quitenicebooking class)
	 *
	 * Registers admin menu and settings
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_init', array( $this, 'run_maintenance' ) );
		if (is_admin()) {
			add_action('wp_ajax_quitenicebooking_maintenance_ajax', array( $this, 'maintenance_ajax') );
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
		}
		add_filter( 'pre_update_option_quitenicebooking', array( $this, 'save_tab_settings' ) );
		add_action( 'admin_notices', array( $this, 'settings_notices' ) );
		$this->allowed_settings = array(
			'email_address',
			'phone_number',
			'fax_number',
			'disable_database',
			'remove_children',
			'max_persons_in_form',
			'max_rooms',
			'rooms_per_page',
			'rooms_order',
			'date_format',
			'accommodation_page_id',
			'step_1_page_id',
			'step_2_page_id',
			'step_3_page_id',
			'step_4_page_id',
			'payment_success_page_id',
			'payment_fail_page_id',
			'currency_unit',
			'currency_unit_suffix',
			'deposit_type',
			'deposit_percentage',
			'deposit_flat',
			'deposit_duration',
			'accept_paypal',
			'paypal_email_address',
			'paypal_currency',
			'accept_bank_transfer',
			'bank_transfer_details',
			'booking_success_message',
			'payment_success_message',
			'payment_fail_message',
			'terms_and_conditions',
			'email_message',
			'enable_smtp',
			'smtp_host',
			'smtp_port',
			'smtp_encryption',
			'smtp_auth',
			'smtp_username',
			'smtp_password',
			'entity_scheme',
			'pricing_scheme',
			'multiroom_link',
			'uninstall_wipe',
			'email_user_template',
			'reservation_form'
		);
	}
	
	/**
	 * Reads the settings from the database and defines additional settings
	 */
	public function read_settings() {
		// read settings stored in options table
		$this->settings = get_option( 'quitenicebooking' );
		// define additional settings
		$this->settings[ 'paypal_currencies' ] = array(
			'AUD' => __( 'Australian Dollar', 'quitenicebooking' ),
			'BRL' => __( 'Brazilian Real', 'quitenicebooking' ),
			'CAD' => __( 'Canadian Dollar', 'quitenicebooking' ),
			'CZK' => __( 'Czech Koruna', 'quitenicebooking' ),
			'DKK' => __( 'Danish Krone', 'quitenicebooking' ),
			'EUR' => __( 'Euro', 'quitenicebooking' ),
			'HKD' => __( 'Hong Kong Dollars', 'quitenicebooking' ),
			'HUF' => __( 'Hungarian Forint', 'quitenicebooking' ),
			'ILS' => __( 'Israeli New Sheqel', 'quitenicebooking' ),
			'JPY' => __( 'Japanese Yen', 'quitenicebooking' ),
			'MYR' => __( 'Malaysian Ringgit', 'quitenicebooking' ),
			'MXN' => __( 'Mexican Peso', 'quitenicebooking' ),
			'NOK' => __( 'Norwegian Krone', 'quitenicebooking' ),
			'NZD' => __( 'New Zealand Dollar', 'quitenicebooking' ),
			'PHP' => __( 'Philippine Peso', 'quitenicebooking' ),
			'PLN' => __( 'Polish Zloty', 'quitenicebooking' ),
			'GBP' => __( 'Pound Sterling', 'quitenicebooking' ),
			'SGD' => __( 'Singapore Dollar', 'quitenicebooking' ),
			'SEK' => __( 'Swedish Krona', 'quitenicebooking' ),
			'CHF' => __( 'Swiss Franc', 'quitenicebooking' ),
			'TWD' => __( 'Taiwan New Dollar', 'quitenicebooking' ),
			'THB' => __( 'Thai Baht', 'quitenicebooking' ),
			'TRY' => __( 'Turkish Lira', 'quitenicebooking' ),
			'USD' => __( 'U.S. Dollars', 'quitenicebooking' )
		);
		$this->settings[ 'date_format_strings' ] = array(
			'dd/mm/yy' => array(
				'regex' => '/(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/(20)\d\d/',
				'php' => 'd/m/Y H:i:s',
				'php_short' => 'd/m/Y',
				'js' => 'dd/mm/yy',
				'display' => _x('DD/MM/YYYY', 'Do not replace slash', 'quitenicebooking')
			),
			'mm/dd/yy' => array(
				'regex' => '/(0[1-9]|1[012])\/(0[1-9]|[12][0-9]|3[01])\/(20)\d\d/',
				'php' => 'm/d/Y H:i:s',
				'php_short' => 'm/d/Y',
				'js' => 'mm/dd/yy',
				'display' => _x('MM/DD/YYYY', 'Do not replace slash', 'quitenicebooking')
			),
			'yy/mm/dd' => array(
				'regex' => '/(20)\d\d\/(0[1-9]|1[012])\/(0[1-9]|[12][0-9]|3[01])/',
				'php' => 'Y/m/d H:i:s',
				'php_short' => 'Y/m/d',
				'js' => 'yy/mm/dd',
				'display' => _x('YYYY/MM/DD', 'Do not replace slash', 'quitenicebooking')
			)
		);
		if (isset($_GET['upgrade']) && $_GET['upgrade'] == '1') {
			return;
		}
		// convert page_ids to urls
		$this->settings['step_1_url'] = get_permalink( $this->settings['step_1_page_id'] );
		$this->settings['step_2_url'] = get_permalink( $this->settings['step_2_page_id'] );
		$this->settings['step_3_url'] = get_permalink( $this->settings['step_3_page_id'] );
		$this->settings['step_4_url'] = get_permalink( $this->settings['step_4_page_id'] );
		$this->settings['accommodation_url'] = get_permalink( $this->settings['accommodation_page_id'] );
		$this->settings['payment_success_url'] = get_permalink( $this->settings['payment_success_page_id'] );
		$this->settings['payment_fail_url'] = get_permalink( $this->settings['payment_fail_page_id'] );
	}

	/**
	 * Administrative methods ==================================================
	 */
	
	/**
	 * Registers the admin menu
	 */
	public function register_admin_menu() {
		add_menu_page(
			'Quite Nice Booking',			// page <title>
			'QNS Booking',					// menu text
			'administrator',				// capability
			'quitenicebooking_settings',	// slug
			array( $this, 'admin_menu' )	// callback
		);
	}

	/**
	 * Displays the admin menu
	 */
	public function admin_menu() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You are not allowed to change this plugin\'s settings.', 'quitenicebooking' ) );
		}
		// get all the pages for the URL selection drop-down
		if (has_filter('get_pages')) {
			// WPML workaround to prevent drop-down from being blank
			remove_all_filters('get_pages');
		}
		$all_pages = get_pages();

		// instantiate the premium plugin
		if (class_exists('Quitenicebooking_Premium_Email_Templates')) {
			$html_email = new Quitenicebooking_Premium_Email_Templates($this->settings);
		}
		if (class_exists('Quitenicebooking_Premium_Reservation_Form')) {
			$reservation_form = new Quitenicebooking_Premium_Reservation_Form($this->settings);
		}

		ob_start();
		// load the specified tab
		$get = filter_input_array( INPUT_GET );
		$get['tab'] = !empty($get['tab']) ? $get['tab'] : 'general';
		$tab_includes = array(
			'general' => plugin_dir_path(__FILE__) . '../views/admin/admin_general.htm.php',
			'pages' => plugin_dir_path(__FILE__) . '../views/admin/admin_pages.htm.php',
			'payment' => plugin_dir_path(__FILE__) . '../views/admin/admin_payment.htm.php',
			'messages' => plugin_dir_path(__FILE__) . '../views/admin/admin_messages.htm.php',
			'email' => plugin_dir_path(__FILE__) . '../views/admin/admin_email.htm.php',
			'maintenance' => plugin_dir_path(__FILE__) . '../views/admin/admin_maintenance.htm.php'
		);
		if (has_filter('quitenicebooking_tab_includes')) {
			$tab_includes = apply_filters('quitenicebooking_tab_includes', $tab_includes);
		}
		if (empty($get['tab']) || !in_array($get['tab'], array_keys($tab_includes))) {
			include plugin_dir_path(__FILE__) . '../views/admin/admin_general.htm.php';
		} else {
			include $tab_includes[$get['tab']];
		}
		echo ob_get_clean();
	}

	/**
	 * Enqueues scripts for admin menu
	 */
	public function admin_enqueue_scripts() {
		$get = filter_input_array( INPUT_GET );
		if (isset($get['tab']) && $get['tab'] == 'maintenance') {
			wp_register_script('quitenicebooking-maintenance', QUITENICEBOOKING_URL . 'assets/js/admin/maintenance.js');
			wp_enqueue_script('quitenicebooking-maintenance');
			wp_localize_script('quitenicebooking-maintenance', 'quitenicebooking', array(
				'ajax_url' => admin_url('admin-ajax.php', isset($_SERVER['HTTPS']) ? 'https://' : 'http://')
			));
		}
	}
	
	/**
	 * Registers settings
	 */
	public function register_settings() {
		register_setting( 'quitenicebooking_settings', 'quitenicebooking', array( $this, 'sanitize_settings' ) );
	}
	
	/**
	 * Intercepts settings being saved
	 * 
	 * Otherwise, only the settings within this tab will be saved, wiping out the other tabs
	 */
	public function save_tab_settings($tab_settings) {
		$tab_settings = array_merge(get_option('quitenicebooking'), $tab_settings);
		return $tab_settings;
	}
	
	/**
	 * Sanitize the input
	 * 
	 * @param array $post The unsanitized input data
	 * @return array The sanitized input; a blank array if no input was sent
	 */
	public function sanitize_settings($post) {
		// because the settings are split into tabs, each field should be validated indepedently
		
		if ( !isset($post) ) {
			return array();
		}
		
		// trim all input
		foreach ($post as &$p) {
			$p = trim($p);
		}
		unset($p);

		$errors = array();
		
		// validate email address
		if ( isset( $post['email_address'] ) && strlen( $post['email_address'] ) > 0 ) {
			if ( ! is_email( $post['email_address'] ) ) {
				$post['email_address'] = $this->settings['email_address'];
				$errors[] = __( 'Please enter a valid email address', 'quitenicebooking' );
			}
		}
		
		// validate disable database
		if ( isset( $post['disable_database'] ) ) {
			if ( ! preg_match('/^1?$/', $post['disable_database'] ) ) {
				$post['disable_database'] = $this->settings['disable_database'];
			}
		}
		
		// validate entity scheme
		if ( isset( $post['entity_scheme' ] ) ) {
			if ( ! preg_match('/^per_person$|^per_room$/', $post['entity_scheme'] ) ) {
				$post['entity_scheme'] = $this->settings['entity_scheme'];
			}
		}
		
		// validate pricing scheme
		if (isset($post['pricing_scheme'])) {
			if (!preg_match('/^daily$|^weekly$|^monthly$/', $post['pricing_scheme'])) {
				$post['pricing_scheme'] = $this->settings['pricing_scheme'];
			}
		}
		
		// validate remove children
		if ( isset( $post['remove_children'] ) ) {
			if ( ! preg_match('/^1?$/', $post['remove_children'] ) ) {
				$post['remove_children'] = $this->settings['remove_children'];
			}
		}

		// validate multiroom link
		if ( isset( $post['multiroom_link'] ) ) {
			if ( ! preg_match('/^1?$/', $post['multiroom_link'] ) ) {
				$post['multiroom_link'] = $this->settings['multiroom_link'];
			}
		}
		
		// validate max persons in form
		if ( isset( $post['max_persons_in_form'] ) ) {
			if ( ! preg_match('/^\d+$/', $post['max_persons_in_form'] ) ) {
				$post['max_persons_in_form'] = $this->settings['max_persons_in_form'];
			}
		}
		
		// validate max rooms
		if ( isset( $post['max_rooms'] ) ) {
			if ( ! preg_match('/^\d+$/', $post['max_rooms'] ) ) {
				$post['max_rooms'] = $this->settings['max_rooms'];
			}
		}
		
		// validate rooms per page
		if ( isset( $post['rooms_per_page'] ) ) {
			if ( ! preg_match('/^\d+$/', $post['rooms_per_page'] ) ) {
				$post['rooms_per_page'] = $this->settings['rooms_per_page'];
			}
		}
		
		// validate rooms order
		if ( isset( $post['rooms_order'] ) ) {
			if ( ! preg_match('/^newest$|^oldest$/', $post['rooms_order'] ) ) {
				$post['rooms_order'] = $this->settings['rooms_order'];
			}
		}
		
		// validate date format
		if ( isset( $post['date_format'] ) ) {
			if ( ! preg_match('/^dd\/mm\/yy$|^mm\/dd\/yy$|^yy\/mm\/dd$/', $post['date_format'] ) ) {
				$post['date_format'] = $this->settings['date_format'];
			}
		}
		
		// validate page ids
		if ( isset( $post['accommodation_page_id'] ) ) {
			if ( ! preg_match('/^$|^\d+$/', $post['accommodation_page_id'] ) ) {
				$post['accommodation_page_id'] = $this->settings['accommodation_page_id'];
			}
		}
		if ( isset( $post['step_1_page_id'] ) ) {
			if ( ! preg_match('/^$|^\d+$/', $post['step_1_page_id'] ) ) {
				$post['step_1_page_id'] = $this->settings['step_1_page_id'];
			}
		}
		if ( isset( $post['step_2_page_id'] ) ) {
			if ( ! preg_match('/^$|^\d+$/', $post['step_2_page_id'] ) ) {
				$post['step_2_page_id'] = $this->settings['step_2_page_id'];
			}
		}
		if ( isset( $post['step_3_page_id'] ) ) {
			if ( ! preg_match('/^$|^\d+$/', $post['step_3_page_id'] ) ) {
				$post['step_3_page_id'] = $this->settings['step_3_page_id'];
			}
		}
		if ( isset( $post['step_4_page_id'] ) ) {
			if ( ! preg_match('/^$|^\d+$/', $post['step_4_page_id'] ) ) {
				$post['step_4_page_id'] = $this->settings['step_4_page_id'];
			}
		}
		if ( isset( $post['payment_success_page_id'] ) ) {
			if ( ! preg_match('/^$|^\d+$/', $post['payment_success_page_id'] ) ) {
				$post['payment_success_page_id'] = $this->settings['payment_success_page_id'];
			}
		}
		if ( isset( $post['payment_fail_page_id'] ) ) {
			if ( ! preg_match('/^$|^\d+$/', $post['payment_fail_page_id'] ) ) {
				$post['payment_fail_page_id'] = $this->settings['payment_fail_page_id'];
			}
		}
		
		// validate currency unit
		if ( isset( $post['currency_unit'] ) ) {
			if ( strlen( $post['currency_unit'] ) == 0 ) {
				$post['currency_unit'] = $this->settings['currency_unit'];
				$errors[] = __( 'Please enter a currency unit', 'quitenicebooking' );
			}
		}
		
		// validate booking success message
		if ( isset( $post['booking_success_message'] ) ) {
			if ( strlen( $post['booking_success_message'] ) == 0 ) {
				$post['booking_success_message'] = $this->settings['booking_success_message'];
				$errors[] = __( 'Please enter a booking success message', 'quitenicebooking' );
			}
		}
		
		// validate confirmation email
		if ( isset($post['email_message'] ) ) {
			if ( strlen( $post['email_message'] ) == 0 ) {
				$post['email_message'] = $this->settings['email_message'];
				$errors[] = __( 'Please enter a confirmation email message', 'quitenicebooking' );
			}
		}
		
		// validate deposit type
		if ( isset($post['deposit_type'] ) ) {
			if ( ! in_array( $post['deposit_type'], array( '', 'percentage', 'flat', 'duration' ) ) ) {
				$post['deposit_type'] = $this->settings['deposit_type'];
			}
			if ( $post['deposit_type'] == 'percentage' ) {
				// validate deposit percentage
				if ( ! preg_match( '/^(\.\d+|\d+\.?\d*)$/', $post['deposit_percentage'] ) || floatval( $post['deposit_percentage'] <= 0 ) ) {
					$post['deposit_type'] = $this->settings['deposit_type'];
					$post['deposit_percentage'] = $this->settings['deposit_percentage'];
					$errors[] = __( 'Please enter a valid deposit percentage', 'quitenicebooking' );
				}
			} elseif ( $post['deposit_type'] == 'flat' ) {
				if ( ! preg_match( '/^(\.\d+|\d+\.?\d*)$/', $post['deposit_flat'] ) || floatval( $post['deposit_flat'] ) <= 0 ) {
					$post['deposit_type'] = $this->settings['deposit_type'];
					$post['deposit_flat'] = $this->settings['deposit_flat'];
					$errors[] = __( 'Please enter a valid deposit price', 'quitenicebooking' );
				}
			} elseif ( $post['deposit_type'] == 'duration' ) {
				if ( !preg_match('/^\d+$/', $post['deposit_duration'] ) ) {
					$post['deposit_type'] = $this->settings['deposit_type'];
					$post['deposit_duration'] = $this->settings['deposit_duration'];
					$errors[] = __( 'Please select a valid deposit duration', 'quitenicebooking' );
				}
			}
		}
		// validate paypal
		if ( isset( $post['accept_paypal'] ) ) {
			if ( ! preg_match('/^1?$/', $post['accept_paypal'] ) ) {
				$post['accept_paypal'] = $this->settings['accept_paypal'];
			}
			if ( $post['accept_paypal'] == 1 ) {
				if ( ! is_email( $post['paypal_email_address'] ) ) {
					$post['accept_paypal'] = $this->settings['accept_paypal'];
					$post['paypal_email_address'] = $this->settings['paypal_email_address'];
					$errors[] = __( 'Please enter a valid Paypal email address', 'quitenicebooking' );
				}
			}
		}
		
		// validate bank transfer
		if ( isset( $post['accept_bank_transfer'] ) ) {
			if ( ! preg_match('/^1?$/', $post['accept_bank_transfer'] ) ) {
				$post['accept_bank_transfer'] = $this->settings['accept_bank_transfer'];
			}
			if ( $post['accept_bank_transfer'] == 1 ) {
				if ( strlen( $post['bank_transfer_details'] ) == 0 ) {
					$post['accept_bank_transfer'] = $this->settings['accept_bank_transfer'];
					$post['bank_transfer_details'] = $this->settings['bank_transfer_details'];
					$errors[] = __( 'Please enter bank transfer information', 'quitenicebooking' );
				}
			}
		}
		
		// validate smtp
		if ( isset( $post['enable_smtp'] ) && $post['enable_smtp'] == 1 ) {
			if ( strlen( $post['smtp_host'] ) == 0 ) {
				$post['enable_smtp'] = $this->settings['enable_smtp'];
				$post['smtp_host'] = $this->settings['smtp_host'];
				$errors[] = __( 'Please enter an SMTP host', 'quitenicebooking' );
			}
			if ( ! preg_match( '/^\d+$/', $post['smtp_port'] ) ) {
				$post['enable_smtp'] = $this->settings['enable_smtp'];
				$post['smtp_port'] = $this->settings['smtp_port'];
				$errors[] = __( 'Please enter a valid SMTP port number', 'quitenicebooking' );
			}
			// validate smtp auth
			if ( $post['smtp_auth'] == 1 ) {
				if ( strlen( $post['smtp_username'] ) == 0 ) {
					$post['enable_smtp'] = $this->settings['enable_smtp'];
					$post['smtp_auth'] = $this->settings['smtp_auth'];
					$post['smtp_username'] = $this->settings['smtp_username'];
					$errors[] = __( 'Please enter an SMTP username', 'quitenicebooking' );
				}
			}
		}

		// validate uninstall wipe
		if ( isset( $post['uninstall_wipe'] ) ) {
			if ( ! preg_match('/^1?$/', $post['uninstall_wipe'] ) ) {
				$post['uninstall_wipe'] = $this->settings['uninstall_wipe'];
			}
		}

		// validate premium
		if (class_exists('Quitenicebooking_Premium_Reservation_Form')) {
			$reservation_form = new Quitenicebooking_Premium_Reservation_Form($this->settings);
		}

		$post = apply_filters('quitenicebooking_premium_reservation_form_save', $post);
		
		if ( count( $errors ) > 0 ) {
			$errors = implode('<br>', $errors);
			add_settings_error( 'quitenicebooking', esc_attr( 'settings_updated' ), $errors, 'error' );
		} else {
			$settings_errors = get_settings_errors( 'quitenicebooking' );
			$add_error = TRUE;
			for ($i = 0; $i < count($settings_errors); $i ++) {
				if ($settings_errors[$i]['message'] == __('Backup restored', 'quitenicebooking') ) {
					$add_error = FALSE;
				}
			}
			if ( $add_error ) {
				add_settings_error( 'quitenicebooking', esc_attr( 'settings_updated' ), __( 'Settings saved', 'quitenicebooking'), 'updated' );
			}
		}
		
		return $post;
	}
	
	/**
	 * Intercepts requests and runs maintenance task requested
	 */
	public function run_maintenance() {
		$post = filter_input_array( INPUT_POST );
		// download JSON backup
		if ( isset( $post['quitenicebooking_download_backup'] ) ) {
			ob_start();
			header( 'Content-Type: text/json; charset=' . get_bloginfo( 'charset' ) );
			header( 'Content-Disposition: attachment; filename=' . sanitize_file_name( get_bloginfo( 'name' ) . '-' . date( 'Y-m-d' ) . '.json' ) ); 
			echo json_encode( get_option( 'quitenicebooking' ) );
			echo ob_get_clean();
			exit;
		}
		// restore a backup		
		if ( isset( $post['quitenicebooking_upload_backup'] ) ) {
			// 1. validate the upload
			if ( isset( $_FILES['quitenicebooking_upload_backup_file'] ) && $_FILES['quitenicebooking_upload_backup_file']['error'] != 0 ) {
				// upload error
				add_settings_error( 'quitenicebooking', esc_attr( 'settings_updated' ), __( 'Upload error', 'quitenicebooking'), 'error' );
				return;
			}
			$restore_file = file_get_contents( $_FILES['quitenicebooking_upload_backup_file']['tmp_name'] );
			if ( $restore_file === FALSE ) {
				// read error
				add_settings_error( 'quitenicebooking', esc_attr( 'settings_updated' ), __( 'Upload error', 'quitenicebooking'), 'error' );
				return;
			}
			$restore_data = json_decode( $restore_file, TRUE );
			if ( $restore_data === NULL ) {
				// parse error
				add_settings_error( 'quitenicebooking', esc_attr( 'settings_updated' ), __( 'The restoration file is in an invalid format', 'quitenicebooking'), 'error' );
				return;
			}
			// 2. extract the values
			// keep the values that are restorable, discard the ones that are not
			foreach ( $restore_data as $key => $val ) {
				if ( ! in_array( $key, $this->allowed_settings ) ) {
					unset( $restore_data[ $key ] );
				}
			}
			// 3. update database, force filters off
			// poke $_POST
			$_POST['quitenicebooking'] = $restore_data;
			add_settings_error( 'quitenicebooking', esc_attr( 'settings_updated' ), __( 'Backup restored', 'quitenicebooking' ), 'updated' );

		}
	}

	public function maintenance_ajax() {
		$post = filter_input_array(INPUT_POST);
		if (!isset($post['run'])) {
			exit;
		}
		if ($post['run'] == 'diagnostics') {
			echo $this->maintenance_diagnostics();
		} elseif ($post['run'] == 'reset') {
			echo $this->maintenance_reset();
		} elseif ($post['run'] == 'repair_settings') {
			echo $this->maintenance_repair_settings();
		} elseif ($post['run'] == 'repair_accommodations') {
			echo $this->maintenance_repair_accommodations();
		} elseif ($post['run'] == 'repair_bookings') {
			echo $this->maintenance_repair_bookings();
		}
		exit;
	}

	/**
	 * Prints diagnostic messages
	 * @global WPDB $wpdb
	 * @return string
	 */
	public function maintenance_diagnostics() {
		global $wpdb;
		ob_start();
?>PHP version: <?php echo phpversion().PHP_EOL; ?>
MySQL version: <?php echo $wpdb->get_var("SELECT VERSION() AS v").PHP_EOL; ?>
MySQL privileges: <?php echo PHP_EOL; $p = $wpdb->get_results("SHOW GRANTS FOR CURRENT_USER", ARRAY_A); foreach ($p as $pp) { foreach ($pp as $k => $v) { echo $k.' => '.$v.PHP_EOL; } } ; ?>
MySQL temporary tables: <?php $wpdb->query("CREATE TEMPORARY TABLE IF NOT EXISTS {$wpdb->prefix}temp (test varchar(255) NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8"); $wpdb->insert("{$wpdb->prefix}temp", array('test' => 'one')); $r = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}temp", ARRAY_A); if ($r[0]['test'] != 'one') { echo 'FAILED'; } else { echo 'OK'; } echo PHP_EOL; ?>
WP locale: <?php echo get_locale().PHP_EOL; ?>
Active theme: <?php $theme = wp_get_theme(); echo $theme->Name.PHP_EOL; ?>
Theme version: <?php echo $theme->Version.PHP_EOL; ?>
QNS Booking version: <?php echo QUITENICEBOOKING_VERSION.PHP_EOL; ?>
QNS Booking settings: <?php echo json_encode(get_option('quitenicebooking')).PHP_EOL; ?>
QNS Booking database records: <?php echo $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}qns_bookings").PHP_EOL; ?>
QNS Booking database dump: <?php echo json_encode($wpdb->get_results("SELECT * FROM {$wpdb->prefix}qns_bookings", ARRAY_A)).PHP_EOL; ?>
<?php
		return ob_get_clean();
	}

	/**
	 * Resets plugin settings to default
	 * @return string Success message
	 */
	public function maintenance_reset(){
		$settings = array(
			'email_address' => '',
			'phone_number' => '',
			'fax_number' => '',
			'accommodation_page_id' => '',
			'step_1_page_id' => '',
			'step_2_page_id' => '',
			'step_3_page_id' => '',
			'step_4_page_id' => '',
			'payment_success_page_id' => '',
			'payment_fail_page_id' => '',
			'currency_unit' => '$',
			'currency_unit_suffix' => '',
			'deposit_type' => 'percentage',
			'deposit_percentage' => 15,
			'deposit_flat' => '',
			'deposit_duration' => '',
			'accept_paypal' => '',
			'paypal_email_address' => '',
			'paypal_currency' => 'USD',
			'accept_bank_transfer' => '',
			'bank_transfer_details' => 'Bank name:
	Routing number:
	Account name:
	Account number:
	Additional instructions:',
			'remove_children' => '',
			'multiroom_link' => '',
			'max_persons_in_form' => 5,
			'max_rooms' => 5,
			'rooms_per_page' => 6,
			'rooms_order' => 'oldest',
			'date_format' => 'dd/mm/yy',
			'booking_success_message' => 'Details of your reservation have just been sent to you in a confirmation email; we look forward to seeing you soon. If you have any questions in the meantime, feel free to contact us.',
			'payment_success_message' => '',
			'payment_fail_message' => '',
			'terms_and_conditions' => '',
			'email_message' => 'Dear [CUSTOMER_FIRST_NAME] [CUSTOMER_LAST_NAME],

	Thank you choosing [HOTEL_NAME]! Your reservation has been accepted; details can be found below. We look forward to seeing you soon.

	Best regards,

	[HOTEL_NAME]',
			'disable_database' => '',
			'enable_smtp' => '',
			'smtp_host' => '',
			'smtp_port' => '',
			'smtp_encryption' => '',
			'smtp_auth' => '',
			'smtp_username' => '',
			'smtp_password' => '',
			'entity_scheme' => 'per_person',
			'pricing_scheme' => 'daily',
			'uninstall_wipe' => '',
			'reservation_form' => '[guest_first_name]
[guest_last_name]
[guest_email]
[text required id="phone" label="Telephone Number"]
[text required id="address_1" label="Address Line 1"]
[text id="address_2" label="Address Line 2"]
[text required id="city" label="City"]
[text required id="state" label="County/State/Province"]
[text required id="zip" label="ZIP/Postal Code"]
[text required id="country" label="Country"]
[textarea id="special_requirements" label="Special Requirements"]'
		);
		remove_all_filters('pre_update_option_quitenicebooking');
		$status = update_option('quitenicebooking', $settings);
		// clears user meta
		$current_user = wp_get_current_user();
		delete_user_meta( $current_user->ID, 'quitenicebooking_ignore_install_pages_notice' );
		if ($status) {
			return 'The plugin has been reset';
		} else {
			return 'Error resetting plugin';
		}
	}
	
	/**
	 * Repairs settings
	 * Discards old settings
	 * @param global WPDB $wpdb
	 * @return string Results message
	 */
	public function maintenance_repair_settings() {
		global $wpdb;
		$num_checked = 0;
		$num_repaired = 0;
		$num_discarded = 0;
		$settings = get_option('quitenicebooking');
		// things to check:
		$pages_to_check = array(
			'accommodation_page_id',
			'step_1_page_id',
			'step_2_page_id',
			'step_3_page_id',
			'step_4_page_id',
			'payment_success_page_id',
			'payment_fail_page_id'
		);
		$page_errors = '';
		// 1. orphaned page ids
		foreach ($pages_to_check as $p) {
			$pp = $wpdb->get_results($wpdb->prepare(
				"SELECT ID, post_status FROM {$wpdb->posts} WHERE ID = %d",
				$settings[$p]
			), ARRAY_A);
			if (count($pp) == 0) {
				$page_errors .= 'Warning: The page for '.$p.' is missing'.PHP_EOL;
				if ($settings[$p] != '') {
					$settings[$p] = '';
					$num_repaired ++;
				}
			} elseif ($pp[0]['post_status'] != 'publish') {
				$page_errors .= 'Warning: The page for '.$p.' is in "'.$pp[0]['post_status'].'" status'.PHP_EOL;
			}
		}

		$orphan_errors = '';
		// 2. orphaned options
		foreach ($settings as $key => $val) {
			$num_checked ++;
			if (!in_array($key, $this->allowed_settings)) {
				$orphan_errors .= 'Notice: Removing orphaned setting "'.$key.'"'.PHP_EOL;
				unset($settings[$key]);
				$num_discarded ++;
			}
		}
		// save
		remove_all_filters('pre_update_option_quitenicebooking');
		update_option('quitenicebooking', $settings);
		return $page_errors.$orphan_errors.$num_checked.' setting(s) checked; '.$num_repaired.' setting(s) repaired; '.$num_discarded.' orphaned setting(s) discarded';
	}

	/**
	 * Repairs accommodations
	 * Discards old and unused meta
	 * @global WPDB $wpdb
	 * @return string Results message
	 */
	public function maintenance_repair_accommodations() {
		global $wpdb;
		$num_repaired = 0;
		$num_checked = 0;
		$errors = '';
		// 1. manually instantiate the accommodation post class
		$accommodation_post_class = new Quitenicebooking_Accommodation_Post();
		$accommodation_post_class->settings = $this->settings;
		$accommodation_post_class->init();
		foreach (array_keys($accommodation_post_class->keys) as $key) {
			$valid_keys[] = $accommodation_post_class->keys[$key]['meta_key'];
		}
		$beds = new Quitenicebooking_Beds();
		$valid_keys[] = $beds->keys['disabled']['meta_key'];
		foreach (array_keys($beds->keys['beds']) as $key) {
			$valid_keys[] = $beds->keys['beds'][$key]['meta_key'];
		}
		$prices_class = 'Quitenicebooking_Prices_'.ucfirst($this->settings['pricing_scheme']);
		$prices = new $prices_class($this->settings['entity_scheme']);
		foreach (array_keys($prices->keys['composed']) as $key) {
			$valid_keys[] = $prices->keys['composed'][$key]['meta_key'];
		}
		$price_filters_active = FALSE;
		if (is_object($accommodation_post_class->price_filters_class) && get_class($accommodation_post_class->price_filters_class) == 'Quitenicebooking_Premium_Price_Filters') {
			$accommodation_post_class->price_filters_class->admin_init();
			$price_filters_active = TRUE;
		}

		// 2. get all post meta and check if they are in use
		$accommodation_post_ids = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'accommodation' AND post_status = 'publish'", ARRAY_A);
		foreach ($accommodation_post_ids as $id) {
			$meta = get_post_meta($id['ID']);
			$repaired = 0;
			foreach ($meta as $key => $val) {

				if (preg_match('/^quitenicebooking/', $key)) {

					if ($price_filters_active) {
						if (!in_array($key, array_merge($valid_keys, $accommodation_post_class->price_filters_class->get_dynamic_keys($id['ID'])))) {
							$errors .= 'Notice: Removing unused meta "'.$key.'" from accommodation ID '.$id['ID'].PHP_EOL;
							delete_post_meta($id['ID'], $key);
							$repaired = 1;
						}
					} elseif (!in_array($key, $valid_keys)) {
						$errors .= 'Notice: Removing unused meta "'.$key.'" from accommodation ID '.$id['ID'].PHP_EOL;
						delete_post_meta($id['ID'], $key);
						$repaired = 1;
					}
				} elseif (preg_match('/^qns/', $key)) {
					$errors .= 'Notice: Removing unused meta "'.$key.'" from accommodation ID '.$id['ID'].PHP_EOL;
					delete_post_meta($id['ID'], $key);
					$repaired = 1;
				}
			}

			$set_draft = FALSE;
			// check if prices are empty; set post to "draft" if so
			foreach (array_keys($prices->keys['composed']) as $key) {
				if (empty($meta[$prices->keys['composed'][$key]['meta_key']][0])) {
					$errors .= 'Warning: Price field "'.$key.'" is empty for accommodation ID '.$id['ID'].'. Changing this accommodation to "pending" status. Please edit it and fill in the price field(s)'.PHP_EOL;
					$set_draft = TRUE;
					$repaired = 1;
				}
			}
			if ($set_draft) {
				$wpdb->update(
					"{$wpdb->posts}",
					array('post_status' => 'pending'),
					array('ID' => $id['ID'])
				);
			}

			$num_checked ++;
			$num_repaired += $repaired;
		}
		return $errors.$num_checked.' accommodation post(s) checked; '.$num_repaired.' accommodation post(s) repaired';
	}

	/**
	 * Repairs bookings
	 * Discards old and unused meta
	 * Repairs database
	 * @global WPDB $wpdb
	 * @return string Results message
	 */
	public function maintenance_repair_bookings() {
		global $wpdb;
		$num_repaired = 0;
		$num_checked = 0;
		$errors = '';
		// 1. manually instantiate the booking post class
		$accommodation_post_class = new Quitenicebooking_Accommodation_Post();
		$accommodation_post_class->settings = $this->settings;
		$booking_post_class = new Quitenicebooking_Booking_Post();
		$booking_post_class->settings = $this->settings;
		$booking_post_class->accommodation_post = $accommodation_post_class;
		$booking_post_class->init();
		foreach ($booking_post_class->meta_fields as $key) {
			$valid_keys[] = $key; // TODO upgrade the booking class to use key => meta
		}
		// 2. get all post meta and check if they are in use
		$booking_post_ids = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'booking' AND post_status = 'publish'", ARRAY_A);
		foreach ($booking_post_ids as $id) {
			$meta = get_post_meta($id['ID']);

			$repaired = 0;
			foreach ($meta as $key => $val) {
				if (preg_match('/^quitenicebooking_/', $key)) {
					if (!in_array($key, $valid_keys)) {
						$errors .= 'Notice: Removing unused meta "'.$key.'" from booking ID '.$id['ID'].PHP_EOL;
						delete_post_meta($id['ID'], $key);
						$repaired = 1;
					}
				} elseif (preg_match('/^qns/', $key)) {
					$errors .= 'Notice: Removing unused meta "'.$key.'" from booking ID '.$id['ID'].PHP_EOL;
					$repaired = 1;

					delete_post_meta($id['ID'], $key);
				}
			}

			// 3.A. repair WPML bookings
			if (defined('ICL_SITEPRESS_VERSION')) {
				global $sitepress;
				// assuming the room_booking_ids are consistent
				$rows = $wpdb->get_results($wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}qns_bookings WHERE post_id = %d GROUP BY room_booking_id",
					$id['ID']
				), ARRAY_A);

				foreach ($rows as $row) {
					// get the trid of the accommodation
					$trid = $sitepress->get_element_trid($row['type'], 'post_accommodation');
					// find all translations of the accommodation
					$accommodation_translations = $sitepress->get_element_translations($trid, 'post_accommodation');
					// 1. check if the translated booking row exists.  if not, create it
					foreach ($accommodation_translations as $at) {
						$translated_row = $wpdb->get_results($wpdb->prepare(
							"SELECT * FROM {$wpdb->prefix}qns_bookings WHERE post_id = %d AND room_booking_id = %d AND type = %d",
							$id['ID'],
							$row['room_booking_id'],
							$at->element_id
						), ARRAY_A);
						if (count($translated_row) == 0) {
							$wpdb->insert("{$wpdb->prefix}qns_bookings", array(
								'post_id' => $id['ID'],
								'room_booking_id' => $row['room_booking_id'],
								'checkin' => $row['checkin'],
								'checkout' => $row['checkout'],
								'type' => $at->element_id,
								'bed' => $row['bed'],
								'adults' => $row['adults'],
								'children' => $row['children']
							));
							$errors .= 'Notice: Adding translated room '.$at->element_id.' for booking ID '.$id['ID'].', room booking ID '.$row['room_booking_id'].', type '.$row['type'].PHP_EOL;
							$repaired = 1;
						}
					}
					// 2. purge old translations
					// 2.1 get all room_booking_ids of this row
					$room_booking_rows = $wpdb->get_results($wpdb->prepare(
						"SELECT * FROM {$wpdb->prefix}qns_bookings WHERE post_id = %d AND room_booking_id = %d",
						$id['ID'],
						$row['room_booking_id']
					), ARRAY_A);
					// 2.2 iterate through each room_booking_id group and find orphaned rows
					foreach ($room_booking_rows as $rbr) {
						$rbr_trid = $sitepress->get_element_trid($rbr['type'], 'post_accommodation');
						if ($rbr_trid != $trid) {
							$wpdb->delete(
								"{$wpdb->prefix}qns_bookings",
								array(
									'id' => $rbr['id']
								)
							);
							$errors .= 'Notice: Removing orphaned translated room '.$rbr['type'].' for booking ID '.$id['ID'].', room booking ID '.$row['room_booking_id'].PHP_EOL;
							$repaired = 1;
						}
					}
				}

			} else {
			// 3. repair the database
				$rows = $wpdb->get_results($wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}qns_bookings WHERE post_id = %d",
					$id['ID']
				), ARRAY_A);
				for ($i = 1; $i <= count($rows); $i ++) {
					if ($rows[$i-1]['room_booking_id'] != $i) {
						$errors .= 'Notice: Repairing database inconsistency for booking ID '.$id['ID'].PHP_EOL;
						$wpdb->update(
							"{$wpdb->prefix}qns_bookings",
							array('room_booking_id' => $i),
							array('id' => $rows[$i-1]['id'])
						);
						$repaired = 1;
					}
				}
			}

			$num_checked ++;
			$num_repaired += $repaired;
		}
		
		

		return $errors.$num_checked.' booking post(s) checked; '.$num_repaired.' booking post(s) repaired';
	}

	/**
	 * Display custom messages when options.php is not in use
	 */
	public function settings_notices() {
		settings_errors( 'quitenicebooking' );
	}
	
	/**
	 * Activation and migration utilties =======================================
	 */
	
	/**
	 * Activates plugin
	 *
	 * On activation, check whether it has been previously installed, and whether it contains old data that needs to be migrated
	 * @global wpdb $wpdb The wpdb object
	 */
	public static function activate() {
		global $wpdb;
		$existing_settings = get_option('quitenicebooking');
		
		if ($existing_settings === FALSE) {
			// settings not found: either new installation, or upgrading from old data
			// looking for existing data
			$settings = array();
			if (get_option('qns_booking_booking1_url') !== FALSE) {
				// old data exists
				
				// convert old data to new format
				$settings['accommodation_page_id'] = url_to_postid(get_option('qns_booking_accomm_url'));
				$settings['step_1_page_id'] = url_to_postid(get_option('qns_booking_booking1_url'));
				$settings['step_2_page_id'] = url_to_postid(get_option('qns_booking_booking2_url'));
				$settings['step_3_page_id'] = url_to_postid(get_option('qns_booking_booking3_url'));
				$settings['step_4_page_id'] = url_to_postid(get_option('qns_booking_booking4_url'));
				$settings['payment_fail_page_id'] = url_to_postid(get_option('qns_booking_fail_url'));
				$settings['booking_success_message'] = get_option('qns_booking_success_msg');
				$settings['payment_success_page_id'] = url_to_postid(get_option('qns_booking_success_url'));
				$settings['terms_and_conditions'] = get_option('qns_booking_terms');
				$settings['currency_unit'] = get_option('qns_currency_unit');
				$settings['currency_unit_suffix'] = '';
				$settings['deposit_type'] = get_option('qns_deposit_percentage') == '0' ? '' : 'percentage';
				$settings['deposit_percentage'] = get_option('qns_deposit_percentage');
				$settings['deposit_flat'] = '';
				$settings['deposit_duration'] = '';
				$settings['email_address'] = get_option('qns_email_address');
				$settings['fax_number'] = get_option('qns_fax_number');
				$settings['payment_fail_message'] = get_option('qns_payment_fail_msg');
				$discard = get_option('qns_payment_method');
				$settings['payment_success_message'] = get_option('qns_payment_success_msg');
				$settings['paypal_email_address'] = get_option('qns_paypal_address');
				$settings['paypal_currency'] = get_option('qns_paypal_currency');
				$settings['accept_paypal'] = get_option('qns_paypal_deposit') == 'on' ? 1 : '';
				$settings['phone_number'] = get_option('qns_phone_number');
				$entity_scheme = get_option('qns_price_per_room') == 'on' ? 'per_room' : 'per_person'; // temporarily save out pricing scheme
				$settings['entity_scheme'] = $entity_scheme;
				$settings['pricing_scheme'] = 'daily';
				$discard = get_option('qns_price_per_room');
				$settings['disable_database'] = get_option('qns_record_booking') == 'on' ? 1 : '';
				$settings['remove_children'] = get_option('qns_remove_children') == 'on' ? 1 : '';
				$settings['multiroom_link'] = '';
				$settings['rooms_order'] = get_option('qns_rooms_order');
				$settings['rooms_per_page'] = get_option('qns_rooms_per_page');
				$settings['accept_bank_transfer'] = '';
				$settings['bank_transfer_details'] = 'Bank name:
Routing number:
Account name:
Account number:
Additional instructions:';
				$settings['max_persons_in_form'] = 5;
				$settings['max_rooms'] = 5;
				$settings['date_format'] = 'dd/mm/yy';
				$settings['email_message'] = 'Dear [CUSTOMER_FIRST_NAME] [CUSTOMER_LAST_NAME],

Thank you choosing [HOTEL_NAME]! Your reservation has been accepted; details can be found below. We look forward to seeing you soon.

Best regards,

[HOTEL_NAME]';
				$settings['uninstall_wipe'] = '';
				$settings['reservation_form'] = '[guest_first_name]
[guest_last_name]
[guest_email]
[text required id="phone" label="Telephone Number"]
[text required id="address_1" label="Address Line 1"]
[text id="address_2" label="Address Line 2"]
[text required id="city" label="City"]
[text required id="state" label="County/State/Province"]
[text required id="zip" label="ZIP/Postal Code"]
[text required id="country" label="Country"]
[textarea id="special_requirements" label="Special Requirements"]';
				
				// update option
				update_option('quitenicebooking', $settings);
				// delete old data
				delete_option('qns_booking_accomm_url');
				delete_option('qns_booking_booking1_url');
				delete_option('qns_booking_booking2_url');
				delete_option('qns_booking_booking3_url');
				delete_option('qns_booking_booking4_url');
				delete_option('qns_booking_fail_url');
				delete_option('qns_booking_success_msg');
				delete_option('qns_booking_success_url');
				delete_option('qns_booking_terms');
				delete_option('qns_currency_unit');
				delete_option('qns_deposit_percentage');
				delete_option('qns_email_address');
				delete_option('qns_fax_number');
				delete_option('qns_payment_fail_msg');
				delete_option('qns_payment_method');
				delete_option('qns_payment_success_msg');
				delete_option('qns_paypal_address');
				delete_option('qns_paypal_currency');
				delete_option('qns_paypal_deposit');
				delete_option('qns_phone_number');
				delete_option('qns_price_per_room');
				delete_option('qns_record_booking');
				delete_option('qns_remove_children');
				delete_option('qns_rooms_order');
				delete_option('qns_rooms_per_page');
				
				// 1. interate through accommodation posts
				// convert old meta to new meta
				$accommodation_posts = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_type = 'accommodation'");

				foreach ($accommodation_posts as $post) {
				    $post_id = $post->ID;
					// get old meta values
					$old_meta = get_post_meta($post_id);
					
					// rather than update the old meta (which makes it more complicated), insert the new meta and delete the old one

					// 1.1. room prices
					// clean up fields like prices containing commas
					if ($entity_scheme == 'per_person') {
						if (isset($old_meta['qns_price_adult_weekday'])) {
							update_post_meta($post_id, 'quitenicebooking_price_per_adult_weekday', floatval(preg_replace('/,/', '', $old_meta['qns_price_adult_weekday'][0])));
						}
						if (isset($old_meta['qns_price_adult_weekend'])) {
							update_post_meta($post_id, 'quitenicebooking_price_per_adult_weekend', floatval(preg_replace('/,/', '', $old_meta['qns_price_adult_weekend'][0])));
						}
						if (isset($old_meta['qns_price_child_weekday'])) {
							update_post_meta($post_id, 'quitenicebooking_price_per_child_weekday', floatval(preg_replace('/,/', '', $old_meta['qns_price_child_weekday'][0])));
						}
						if (isset($old_meta['qns_price_child_weekend'])) {
							update_post_meta($post_id, 'quitenicebooking_price_per_child_weekend', floatval(preg_replace('/,/', '', $old_meta['qns_price_child_weekend'][0])));
						}
					} else {
						// entity_scheme == 'per_room'
						if (isset($old_meta['qns_price_adult_weekday'])) {
							update_post_meta($post_id, 'quitenicebooking_price_per_room_weekday', floatval(preg_replace('/,/', '', $old_meta['qns_price_adult_weekday'][0])));
						}
						if (isset($old_meta['qns_price_adult_weekend'])) {
							update_post_meta($post_id, 'quitenicebooking_price_per_room_weekend', floatval(preg_replace('/,/', '', $old_meta['qns_price_adult_weekend'][0])));
						}
					}
					delete_post_meta($post_id, 'qns_price_adult_weekday');
					delete_post_meta($post_id, 'qns_price_adult_weekend');
					delete_post_meta($post_id, 'qns_price_child_weekday');
					delete_post_meta($post_id, 'qns_price_child_weekend');
					
					// 1.2. room stats (size, view, max occupancy)
					if (isset($old_meta['qns_room_size'])) {
						update_post_meta($post_id, 'quitenicebooking_room_size', $old_meta['qns_room_size'][0]);
						delete_post_meta($post_id, 'qns_room_size');
					}
					if (isset($old_meta['qns_room_view'])) {
						update_post_meta($post_id, 'quitenicebooking_room_view', $old_meta['qns_room_view'][0]);
						delete_post_meta($post_id, 'qns_room_view');
					}
					if (isset($old_meta['qns_max_occupancy'])) {
						update_post_meta($post_id, 'quitenicebooking_max_occupancy', intval($old_meta['qns_max_occupancy'][0]));
						delete_post_meta($post_id, 'qns_max_occupancy');
					}
					if (isset($old_meta['qns_num_bedrooms'])) {
						update_post_meta($post_id, 'quitenicebooking_num_bedrooms', intval($old_meta['qns_num_bedrooms'][0]));
						delete_post_meta($post_id, 'qns_num_bedrooms');
					}
					
					// 1.3. room and bed quantity: set number of beds available to number of rooms available
					if (isset($old_meta['qns_rooms_available'])) {
						$room_qty = intval($old_meta['qns_rooms_available'][0]);
						update_post_meta($post_id, 'quitenicebooking_room_quantity', $room_qty);
						delete_post_meta($post_id, 'qns_rooms_available');
					}
					if (isset($old_meta['qns_king_bed'])) {
						update_post_meta($post_id, 'quitenicebooking_beds_king', $old_meta['qns_king_bed'][0] == 'on' ? 1 : '');
						delete_post_meta($post_id, 'qns_king_bed');
					}
					if (isset($old_meta['qns_queen_bed'])) {
						update_post_meta($post_id, 'quitenicebooking_beds_queen', $old_meta['qns_queen_bed'][0] == 'on' ? 1 : '');
						delete_post_meta($post_id, 'qns_queen_bed');
					}
					if (isset($old_meta['qns_single_bed'])) {
						update_post_meta($post_id, 'quitenicebooking_beds_single', $old_meta['qns_single_bed'][0] == 'on' ? 1 : '');
						delete_post_meta($post_id, 'qns_single_bed');
					}
					if (isset($old_meta['qns_double_bed'])) {
						update_post_meta($post_id, 'quitenicebooking_beds_double', $old_meta['qns_double_bed'][0] == 'on' ? 1 : '');
						delete_post_meta($post_id, 'qns_double_bed');
					}
					if (isset($old_meta['qns_twin_bed'])) {
						update_post_meta($post_id, 'quitenicebooking_beds_twin', $old_meta['qns_twin_bed'][0] == 'on' ? 1 : '');
						delete_post_meta($post_id, 'qns_twin_bed');
					}
					
					// 1.4. tabs (1-5)
					if (isset($old_meta['qns_tab_one_title'])) {
						update_post_meta($post_id, 'quitenicebooking_tab_1_title', $old_meta['qns_tab_one_title'][0]);
						delete_post_meta($post_id, 'qns_tab_one_title');
					}
					if (isset($old_meta['qns_tab_one_content'])) {
						update_post_meta($post_id, 'quitenicebooking_tab_1_content', $old_meta['qns_tab_one_content'][0]);
						delete_post_meta($post_id, 'qns_tab_one_content');
					}
					if (isset($old_meta['qns_tab_two_title'])) {
						update_post_meta($post_id, 'quitenicebooking_tab_2_title', $old_meta['qns_tab_two_title'][0]);
						delete_post_meta($post_id, 'qns_tab_two_title');
					}
					if (isset($old_meta['qns_tab_two_content'])) {
						update_post_meta($post_id, 'quitenicebooking_tab_2_content', $old_meta['qns_tab_two_content'][0]);
						delete_post_meta($post_id, 'qns_tab_two_content');
					}
					if (isset($old_meta['qns_tab_three_title'])) {
						update_post_meta($post_id, 'quitenicebooking_tab_3_title', $old_meta['qns_tab_three_title'][0]);
						delete_post_meta($post_id, 'qns_tab_three_title');
					}
					if (isset($old_meta['qns_tab_three_content'])) {
						update_post_meta($post_id, 'quitenicebooking_tab_3_content', $old_meta['qns_tab_three_content'][0]);
						delete_post_meta($post_id, 'qns_tab_three_content');
					}
					if (isset($old_meta['qns_tab_four_title'])) {
						update_post_meta($post_id, 'quitenicebooking_tab_4_title', $old_meta['qns_tab_four_title'][0]);
						delete_post_meta($post_id, 'qns_tab_four_title');
					}
					if (isset($old_meta['qns_tab_four_content'])) {
						update_post_meta($post_id, 'quitenicebooking_tab_4_content', $old_meta['qns_tab_four_content'][0]);
						delete_post_meta($post_id, 'qns_tab_four_content');
					}
					if (isset($old_meta['qns_tab_five_title'])) {
						update_post_meta($post_id, 'quitenicebooking_tab_5_title', $old_meta['qns_tab_five_title'][0]);
						delete_post_meta($post_id, 'qns_tab_five_title');
					}
					if (isset($old_meta['qns_tab_five_content'])) {
						update_post_meta($post_id, 'quitenicebooking_tab_5_content', $old_meta['qns_tab_five_content'][0]);
						delete_post_meta($post_id, 'qns_tab_five_content');
					}
				}
				
				// 2. iterate through booking posts
				$booking_posts = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_type = 'booking'");
				
				// create the database table
				self::create_bookings_table();
				
				foreach ($booking_posts as $post) {
					$post_id = $post->ID;
					// get old meta values
					$old_meta = get_post_meta($post_id);
					
					// 2.1. booking id
					update_post_meta($post_id, 'quitenicebooking_booking_id', $post_id);
					if (isset($old_meta['qns_booking_id'])) {
						delete_post_meta($post_id, 'qns_booking_id');
					}
					
					// 2.2. customer info: last name, first name, email address, telephone number,
					// address 1, address 2, city, state, zip, country, special reqs
					if (isset($old_meta['qns_full_name'])) {
						$full_name = trim($old_meta['qns_full_name'][0]);
						$first_name = substr($full_name, 0, strrpos($full_name, ' '));
						if ($first_name == '') {
							$last_name = substr($full_name, strrpos($full_name, ' '));
						} else {
							$last_name = substr($full_name, strrpos($full_name, ' ')+1);
						}
						update_post_meta($post_id, 'quitenicebooking_guest_last_name', $last_name);
						update_post_meta($post_id, 'quitenicebooking_guest_first_name', $first_name);
						delete_post_meta($post_id, 'qns_full_name');
					}
					if (isset($old_meta['qns_email_address'])) {
						update_post_meta($post_id, 'quitenicebooking_guest_email', $old_meta['qns_email_address'][0]);
						delete_post_meta($post_id, 'qns_email_address');
					}
					$guest_details = array();
					if (isset($old_meta['qns_telephone_number'])) {
						$guest_details['phone']['label'] = 'Telephone Number';
						$guest_details['phone']['value'] = $old_meta['qns_telephone_number'][0];
						$guest_details['phone']['type'] = 'text';
						delete_post_meta($post_id, 'qns_telephone_number');
					}
					if (isset($old_meta['qns_address_line_1'])) {
						$guest_details['address_1']['label'] = 'Address Line 1';
						$guest_details['address_1']['value'] = $old_meta['qns_address_line_1'][0];
						$guest_details['address_1']['type'] = 'text';
						delete_post_meta($post_id, 'qns_address_line_1');
					}
					if (isset($old_meta['qns_address_line_2'])) {
						$guest_details['address_2']['label'] = 'Address Line 2';
						$guest_details['address_2']['value'] = $old_meta['qns_address_line_2'][0];
						$guest_details['address_2']['type'] = 'text';
						delete_post_meta($post_id, 'qns_address_line_2');
					}
					if (isset($old_meta['qns_city'])) {
						$guest_details['city']['label'] = 'City';
						$guest_details['city']['value'] = $old_meta['qns_city'][0];
						$guest_details['city']['type'] = 'text';
						delete_post_meta($post_id, 'qns_city');
					}
					if (isset($old_meta['qns_state_county'])) {
						$guest_details['state']['label'] = 'County/State/Province';
						$guest_details['state']['value'] = $old_meta['qns_state_county'][0];
						$guest_details['state']['type'] = 'text';
						delete_post_meta($post_id, 'qns_state_county');
					}
					if (isset($old_meta['qns_zip_postcode'])) {
						$guest_details['zip']['label'] = 'ZIP/Postal Code';
						$guest_details['zip']['value'] = $old_meta['qns_zip_postcode'][0];
						$guest_details['zip']['type'] = 'text';
						delete_post_meta($post_id, 'qns_zip_postcode');
					}
					if (isset($old_meta['qns_country'])) {
						$guest_details['country']['label'] = 'Country';
						$guest_details['country']['value'] = $old_meta['qns_country'][0];
						$guest_details['country']['type'] = 'text';
						delete_post_meta($post_id, 'qns_country');
					}
					if (isset($old_meta['qns_special_requirements'])) {
						$guest_details['special_requirements']['label'] = 'Special Requirements';
						$guest_details['special_requirements']['value'] = $old_meta['qns_special_requirements'][0];
						$guest_details['special_requirements']['type'] = 'textarea';
						delete_post_meta($post_id, 'qns_special_requirements');
					}
					update_post_meta($post->ID, 'quitenicebooking_guest_details', json_encode($guest_details));
					
					// 2.3. payment info: deposit amount, total quoted
					if (isset($old_meta['qns_deposit_amount'])) {
						update_post_meta($post_id, 'quitenicebooking_deposit_amount', floatval($old_meta['qns_deposit_amount'][0]));
						delete_post_meta($post_id, 'qns_deposit_amount');
					}
					if (isset($old_meta['qns_total_price_quoted'])) {
						update_post_meta($post_id, 'quitenicebooking_total_price', floatval($old_meta['qns_total_price_quoted'][0]));
						delete_post_meta($post_id, 'qns_total_price_quoted');
					}
					// discard the deposit paid field
					delete_post_meta($post_id, 'qns_deposit_paid');
					
					// 2.4. booking info, per room (up to 3): check in, check out, room type, bed type,
					// num adults, num children
					// convert dates from dd/mm/yyyy to unix timestamp
					foreach (range(1, 3) as $r) {
						if (!isset($old_meta['qns_check_in_date_'.$r])) {
							continue;
						}
						$row = array();
						$row['post_id'] = $post_id;
						$row['room_booking_id'] = $r;
						if (isset($old_meta['qns_check_in_date_'.$r])) {
							
							// date fix for < 5.3.0
							$version = explode('.', phpversion());
							// PHP >= 5.3.0
							if(((int)$version[0] >= 5 && (int)$version[1] >= 3 && (int)$version[2] >= 0)){
								$row['checkin'] = date('Y-m-d H:i:s', date_timestamp_get(date_create_from_format('d/m/Y H:i:s', $old_meta['qns_check_in_date_'.$r][0].' 00:00:00')));
							} else {
								// PHP < 5.3.0
								// all dates are in DD/MM/YYYY format
								$timestamp = $old_meta['qns_check_in_date_'.$r][0].' 00:00:00';
								$timestamp = str_replace('/', '-', $timestamp);
								$timestamp = strtotime($timestamp);
								$row['checkin'] = $timestamp;
							}
							
							delete_post_meta($post_id, 'qns_check_in_date_'.$r);
						}
						if (isset($old_meta['qns_check_out_date_'.$r])) {
							
							// date fix for < 5.3.0
							$version = explode('.', phpversion());
							if(((int)$version[0] >= 5 && (int)$version[1] >= 3 && (int)$version[2] >= 0)){
								$row['checkout'] = date('Y-m-d H:i:s', date_timestamp_get(date_create_from_format('d/m/Y H:i:s', $old_meta['qns_check_out_date_'.$r][0].' 00:00:00')));
							} else {
								// PHP < 5.3.0
								// all dates are in DD/MM/YYYY format
								$timestamp = $old_meta['qns_check_out_date_'.$r][0].' 00:00:00';
								$timestamp = str_replace('/', '-', $timestamp);
								$timestamp = strtotime($timestamp);
								$row['checkout'] = $timestamp;
							}
							
							delete_post_meta($post_id, 'qns_check_out_date_'.$r);
						}
						if (isset($old_meta['qns_room_id_'.$r])) {
							delete_post_meta($post_id, 'qns_room_name_'.$r);
							delete_post_meta($post_id, 'qns_room_id_'.$r);
							$row['type'] = $old_meta['qns_room_id_'.$r][0];
						}
						if (isset($old_meta['qns_bed_type_'.$r])) {
							switch ($old_meta['qns_bed_type_'.$r][0]) {
								case 'Select King Bed':
									$bed = 'king'; break;
								case 'Select Queen Bed':
									$bed = 'queen'; break;
								case 'Select Single Bed':
									$bed = 'single'; break;
								case 'Select Double Bed':
									$bed = 'double'; break;
								case 'Select Twin Beds':
									$bed = 'twin'; break;
								case 'Select Room':
									$bed = 0; break;
								default:
									$bed = 0;
							}
							$row['bed'] = $bed;
							delete_post_meta($post_id, 'qns_bed_type_'.$r);
						}
						if (isset($old_meta['qns_number_of_adults_'.$r])) {
							$row['adults'] = intval($old_meta['qns_number_of_adults_'.$r][0]);
							delete_post_meta($post_id, 'qns_number_of_adults_'.$r);
						}
						if (isset($old_meta['qns_number_of_children_'.$r])) {
							$row['children'] = intval($old_meta['qns_number_of_children_'.$r][0]);
							delete_post_meta($post_id, 'qns_number_of_children_'.$r);
						}
						$wpdb->insert("{$wpdb->prefix}qns_bookings", $row);
					}
					
				}
				
			} else {
				// new installation
				// populate the settings with some default values
				$settings = array(
					'email_address' => '',
					'phone_number' => '',
					'fax_number' => '',
					'accommodation_page_id' => '',
					'step_1_page_id' => '',
					'step_2_page_id' => '',
					'step_3_page_id' => '',
					'step_4_page_id' => '',
					'payment_success_page_id' => '',
					'payment_fail_page_id' => '',
					'currency_unit' => '$',
					'currency_unit_suffix' => '',
					'deposit_type' => 'percentage',
					'deposit_percentage' => 15,
					'deposit_flat' => '',
					'deposit_duration' => '',
					'accept_paypal' => '',
					'paypal_email_address' => '',
					'paypal_currency' => 'USD',
					'accept_bank_transfer' => '',
					'bank_transfer_details' => 'Bank name:
Routing number:
Account name:
Account number:
Additional instructions:',
					'remove_children' => '',
					'multiroom_link' => '',
					'max_persons_in_form' => 5,
					'max_rooms' => 5,
					'rooms_per_page' => 6,
					'rooms_order' => 'oldest',
					'date_format' => 'dd/mm/yy',
					'booking_success_message' => 'Details of your reservation have just been sent to you in a confirmation email; we look forward to seeing you soon. If you have any questions in the meantime, feel free to contact us.',
					'payment_success_message' => '',
					'payment_fail_message' => '',
					'terms_and_conditions' => '',
					'email_message' => 'Dear [CUSTOMER_FIRST_NAME] [CUSTOMER_LAST_NAME],

Thank you choosing [HOTEL_NAME]! Your reservation has been accepted; details can be found below. We look forward to seeing you soon.

Best regards,

[HOTEL_NAME]',
					'disable_database' => '',
					'enable_smtp' => '',
					'smtp_host' => '',
					'smtp_port' => '',
					'smtp_encryption' => '',
					'smtp_auth' => '',
					'smtp_username' => '',
					'smtp_password' => '',
					'entity_scheme' => 'per_person',
					'pricing_scheme' => 'daily',
					'uninstall_wipe' => '',
					'reservation_form' => '[guest_first_name]
[guest_last_name]
[guest_email]
[text required id="phone" label="Telephone Number"]
[text required id="address_1" label="Address Line 1"]
[text id="address_2" label="Address Line 2"]
[text required id="city" label="City"]
[text required id="state" label="County/State/Province"]
[text required id="zip" label="ZIP/Postal Code"]
[text required id="country" label="Country"]
[textarea id="special_requirements" label="Special Requirements"]'
				);
				update_option('quitenicebooking', $settings);
				
				// create the database table
				self::create_bookings_table();
			}
			// update the version number
			update_option('quitenicebooking_version', QUITENICEBOOKING_VERSION);
		}
	}
	
	/**
	 * Upgrades the plugin data
	 *
	 * Migrates plugin data from a previous version to the current one
	 * @global WPDB $wpdb The WPDB instance
	 */
	public static function upgrade() {
		$updated = FALSE;
		$version = get_option( 'quitenicebooking_version' );
		if ( $version >= 2.00 && $version < 2.20 ) {
			// migrate _urls to _page_ids
			$settings = get_option( 'quitenicebooking' );
			$settings['step_1_page_id'] = url_to_postid( $settings['step_1_url'] );
			$settings['step_2_page_id'] = url_to_postid( $settings['step_2_url'] );
			$settings['step_3_page_id'] = url_to_postid( $settings['step_3_url'] );
			$settings['step_4_page_id'] = url_to_postid( $settings['step_4_url'] );
			$settings['accommodation_page_id'] = url_to_postid( $settings['accommodation_url'] );
			$settings['payment_success_page_id'] = url_to_postid( $settings['payment_success_url'] );
			$settings['payment_fail_page_id'] = url_to_postid( $settings['payment_fail_url'] );
			unset( $settings['step_1_url'] );
			unset( $settings['step_2_url'] );
			unset( $settings['step_3_url'] );
			unset( $settings['step_4_url'] );
			unset( $settings['accommodation_url'] );
			unset( $settings['payment_success_url'] );
			unset( $settings['payment_fail_url'] );
			// save settings
			remove_all_filters('pre_update_option_quitenicebooking');
			update_option( 'quitenicebooking', $settings );
			$updated = TRUE;
		}
		if ( $version >= 2.00 && $version < 2.21 ) {
			// move pricing scheme back into settings
			// 1. make a tally of which scheme is used most; that will be the setting
			// in case of a tie, the per_person pricing takes priority
			global $wpdb;
			$per_person = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'quitenicebooking_pricing_scheme' AND meta_value = 'per_person'");
			$per_room = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'quitenicebooking_pricing_scheme' AND meta_value = 'per_room'");

			if ( count($per_person) >= count($per_room) ) {
				// 2. set scheme to 'per_person'
				$settings = get_option( 'quitenicebooking' );
				$settings['pricing_scheme'] = 'per_person';
				remove_all_filters('pre_update_option_quitenicebooking');
				update_option( 'quitenicebooking', $settings );
				$updated = TRUE;
				// 3. find all Accommodation posts where pricing scheme is set to 'per_room' and copy that value over to the 'per_person' fields
				foreach ( $per_room as $r ) {
					$r_meta = get_post_meta( $r->post_id );
					if ( empty( $r_meta['quitenicebooking_price_per_adult_weekday'][0] ) ) {
						update_post_meta( $r->post_id, 'quitenicebooking_price_per_adult_weekday', $r_meta['quitenicebooking_price_per_room_weekday'][0]);
					}
					if ( empty( $r_meta['quitenicebooking_price_per_adult_weekend'][0] ) ) {
						update_post_meta( $r->post_id, 'quitenicebooking_price_per_adult_weekend', $r_meta['quitenicebooking_price_per_room_weekend'][0]);
					}
					if ( empty( $r_meta['quitenicebooking_price_per_child_weekday'][0] ) ) {
						update_post_meta( $r->post_id, 'quitenicebooking_price_per_child_weekday', $r_meta['quitenicebooking_price_per_room_weekday'][0]);
					}
					if ( empty( $r_meta['quitenicebooking_price_per_child_weekend'][0] ) ) {
						update_post_meta( $r->post_id, 'quitenicebooking_price_per_child_weekend', $r_meta['quitenicebooking_price_per_room_weekend'][0]);
					}
				}
			} else {
				// 2. set scheme to 'per_room'
				$settings = get_option( 'quitenicebooking' );
				$settings['pricing_scheme'] = 'per_room';
				remove_all_filters('pre_update_option_quitenicebooking');
				update_option( 'quitenicebooking', $settings );
				$update = TRUE;
				// 3. find all Accommodation posts where pricing scheme is set to 'per_person' and copy the adult value over to the 'per_room' fields
				foreach ( $per_person as $p ) {
					$p_meta = get_post_meta( $p->post_id );
					if ( empty( $p_meta['quitenicebooking_price_per_room_weekday'][0] ) ) {
						update_post_meta( $p->post_id, 'quitenicebooking_price_per_room_weekday', $p_meta['quitenicebooking_price_per_adult_weekday'][0] );
					}
					if ( empty( $p_meta['quitenicebooking_price_per_room_weekend'][0] ) ) {
						update_post_meta( $p->post_id, 'quitenicebooking_price_per_room_weekend', $p_meta['quitenicebooking_price_per_adult_weekend'][0] );
					}
				}
			}
			// 4. delete pricing scheme meta
			foreach ( $per_room as $r ) {
				delete_post_meta( $r->post_id, 'quitenicebooking_pricing_scheme' );
			}
			foreach ( $per_person as $p ) {
				delete_post_meta( $p->post_id, 'quitenicebooking_pricing_scheme' );
			}
		}
		if ( $version >= 2.00 && $version < 2.30 ) {
			// create the bookings table
			self::create_bookings_table();
			
			// migrate all bookings meta to the table and delete the meta
			global $wpdb;
			// 1. get all booking ids
			$bookings = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_type = 'booking'");
			// 2. iterate through each booking id and extract its meta
			foreach ($bookings as $b) {
				$b_meta = get_post_meta($b->ID);
				// determine number of room bookings
				$num_rooms = 0;
				foreach ($b_meta as $key => $value) {
					if (preg_match('/quitenicebooking_room_booking_\d+_checkin/', $key)) {
						$num_rooms ++;
					}
				}
				for ($n = 1; $n <= $num_rooms; $n ++) {
					// 2.1. insert row
					$wpdb->insert("{$wpdb->prefix}qns_bookings", array(
						'post_id' => $b->ID,
						'room_booking_id' => $n,
						'checkin' => date('Y-m-d H:i:s', $b_meta["quitenicebooking_room_booking_{$n}_checkin"][0]),
						'checkout' => date('Y-m-d H:i:s', $b_meta["quitenicebooking_room_booking_{$n}_checkout"][0]),
						'type' => $b_meta["quitenicebooking_room_booking_{$n}_type"][0],
						'bed' => $b_meta["quitenicebooking_room_booking_{$n}_bed"][0],
						'adults' => $b_meta["quitenicebooking_room_booking_{$n}_adults"][0],
						'children' => $b_meta["quitenicebooking_room_booking_{$n}_children"][0],
					));
					// 2.2. delete meta
					delete_post_meta($b->ID, "quitenicebooking_room_booking_{$n}_checkin");
					delete_post_meta($b->ID, "quitenicebooking_room_booking_{$n}_checkout");
					delete_post_meta($b->ID, "quitenicebooking_room_booking_{$n}_type");
					delete_post_meta($b->ID, "quitenicebooking_room_booking_{$n}_bed");
					delete_post_meta($b->ID, "quitenicebooking_room_booking_{$n}_adults");
					delete_post_meta($b->ID, "quitenicebooking_room_booking_{$n}_children");
				}
				
			}
			$updated = TRUE;
		}
		if ( $version == 2.30 ) {
			// clean up a bug which merged the paypal currencies, bed types, date format strings, and booking urls into the settings
			$settings = get_option( 'quitenicebooking' );
			if ( isset( $settings['paypal_currencies'] ) ) { unset( $settings['paypal_currencies'] ); }
			if ( isset( $settings['bed_types'] ) ) { unset( $settings['bed_types'] ); }
			if ( isset( $settings['date_format_strings'] ) ) { unset( $settings['date_format_strings'] ); }
			if ( isset( $settings['step_1_url'] ) ) { unset( $settings['step_1_url'] ); }
			if ( isset( $settings['step_2_url'] ) ) { unset( $settings['step_2_url'] ); }
			if ( isset( $settings['step_3_url'] ) ) { unset( $settings['step_3_url'] ); }
			if ( isset( $settings['step_4_url'] ) ) { unset( $settings['step_4_url'] ); }
			if ( isset( $settings['accommodation_url'] ) ) { unset( $settings['accommodation_url'] ); }
			if ( isset( $settings['payment_success_url'] ) ) { unset( $settings['payment_success_url'] ); }
			if ( isset( $settings['payment_fail_url'] ) ) { unset( $settings['payment_fail_url'] ); }
			remove_all_filters('pre_update_option_quitenicebooking');
			update_option( 'quitenicebooking', $settings );
			$updated = TRUE;
		}
		if ( $version >= 2.00 && $version < 2.40 ) {
			// migrate deposit settings
			$settings = get_option( 'quitenicebooking' );
			if ( $settings['deposit_percentage'] == '0' ) {
				$settings['deposit_type'] = '';
			} else {
				$settings['deposit_type'] = 'percentage';
			}
			$settings['deposit_flat'] = '';
			$settings['deposit_duration'] = '';
			$settings['entity_scheme'] = $settings['pricing_scheme'];
			$settings['pricing_scheme'] = 'daily';
			
			remove_all_filters('pre_update_option_quitenicebooking');
			update_option( 'quitenicebooking', $settings );
			$updated = TRUE;
		}
		if ($version >= 2.00 && $version < 2.50) {
			// add the multiroom_link setting
			$settings = get_option('quitenicebooking');
			$settings['multiroom_link'] = '';
			$settings['uninstall_wipe'] = '';
			$settings['reservation_form'] = '[guest_first_name]
[guest_last_name]
[guest_email]
[text required id="phone" label="Telephone Number"]
[text required id="address_1" label="Address Line 1"]
[text id="address_2" label="Address Line 2"]
[text required id="city" label="City"]
[text required id="state" label="County/State/Province"]
[text required id="zip" label="ZIP/Postal Code"]
[text required id="country" label="Country"]
[textarea id="special_requirements" label="Special Requirements"]';
			$settings['currency_unit_suffix'] = '';
			remove_all_filters('pre_update_option_quitenicebooking');
			update_option('quitenicebooking', $settings);
			
			global $wpdb;
			$booking_posts = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_type = 'booking'");
			// upgrade guest info
			foreach ($booking_posts as $post) {
				$meta = get_post_meta($post->ID);
				// rename customer_first_name, customer_last_name, customer_email to guest_*
				update_post_meta($post->ID, 'quitenicebooking_guest_first_name', $meta['quitenicebooking_customer_first_name'][0]);
				update_post_meta($post->ID, 'quitenicebooking_guest_last_name', $meta['quitenicebooking_customer_last_name'][0]);
				update_post_meta($post->ID, 'quitenicebooking_guest_email', $meta['quitenicebooking_customer_email'][0]);
				delete_post_meta($post->ID, 'quitenicebooking_customer_first_name');
				delete_post_meta($post->ID, 'quitenicebooking_customer_last_name');
				delete_post_meta($post->ID, 'quitenicebooking_customer_email');

				// convert all previous booking guest details to new guest_details JSON format
				$guest_details = array();
				$guest_details['phone']['label'] = 'Telephone Number';
				$guest_details['phone']['value'] = $meta['quitenicebooking_customer_phone'][0];
				$guest_details['phone']['type'] = 'text';
				$guest_details['address_1']['label'] = 'Address Line 1';
				$guest_details['address_1']['value'] = $meta['quitenicebooking_customer_address_1'][0];
				$guest_details['address_1']['type'] = 'text';
				$guest_details['address_2']['label'] = 'Address Line 2';
				$guest_details['address_2']['value'] = $meta['quitenicebooking_customer_address_2'][0];
				$guest_details['address_2']['type'] = 'text';
				$guest_details['city']['label'] = 'City';
				$guest_details['city']['value'] = $meta['quitenicebooking_customer_address_city'][0];
				$guest_details['city']['type'] = 'text';
				$guest_details['state']['label'] = 'County/State/Province';
				$guest_details['state']['value'] = $meta['quitenicebooking_customer_address_state'][0];
				$guest_details['state']['type'] = 'text';
				$guest_details['zip']['label'] = 'ZIP/Postal Code';
				$guest_details['zip']['value'] = $meta['quitenicebooking_customer_address_zip'][0];
				$guest_details['zip']['type'] = 'text';
				$guest_details['country']['label'] = 'Country';
				$guest_details['country']['value'] = $meta['quitenicebooking_customer_address_country'][0];
				$guest_details['country']['type'] = 'text';
				$guest_details['special_requirements']['label'] = 'Special Requirements';
				$guest_details['special_requirements']['value'] = $meta['quitenicebooking_special_requirements'][0];
				$guest_details['special_requirements']['type'] = 'textarea';

				update_post_meta($post->ID, 'quitenicebooking_guest_details', json_encode($guest_details));
				delete_post_meta($post->ID, 'quitenicebooking_customer_phone');
				delete_post_meta($post->ID, 'quitenicebooking_customer_address_1');
				delete_post_meta($post->ID, 'quitenicebooking_customer_address_2');
				delete_post_meta($post->ID, 'quitenicebooking_customer_address_city');
				delete_post_meta($post->ID, 'quitenicebooking_customer_address_state');
				delete_post_meta($post->ID, 'quitenicebooking_customer_address_zip');
				delete_post_meta($post->ID, 'quitenicebooking_customer_address_country');
				delete_post_meta($post->ID, 'quitenicebooking_special_requirements');
			}

			$updated = TRUE;
		}
		if ($version == 2.50) {
			// fix "Address Line 2" being a required field
			$settings = get_option('quitenicebooking');
			$settings['reservation_form'] = str_replace('[text required id="address_2" label="Address Line 2"]', '[text id="address_2" label="Address Line 2"]', $settings['reservation_form']); 
			remove_all_filters('pre_update_option_quitenicebooking');
			update_option('quitenicebooking', $settings);
			$updated = TRUE;
		}
		
		if ( $updated || $version != QUITENICEBOOKING_VERSION ) {
			// update version number to current
			update_option( 'quitenicebooking_version', QUITENICEBOOKING_VERSION );
			// if the user is already on the settings page, redirect to prevent old settings from showing (otherwise they'll be blank)
			$get = filter_input_array( INPUT_GET );
			if ( isset($get['page']) && $get['page'] == 'quitenicebooking_settings' ) {
				wp_redirect( admin_url( 'admin.php?page=quitenicebooking_settings' ) );
			}
		}
	}
	
	/**
	 * Detects and recommends backup before upgrade
	 * 
	 * @return boolean TRUE if backup is recommended, false if not
	 */
	public static function recommend_backup() {
		$version = get_option( 'quitenicebooking_version' );
		if ( $version >= 2.00 && $version < 2.50 ) {
			add_action( 'admin_notices', array( 'Quitenicebooking_Settings', 'backup_notice' ) );
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Deactivates plugin
	 */
	public static function deactivate() {
		$current_user = wp_get_current_user();
		// remove the user preference to ignore installation notice
		delete_user_meta( $current_user->ID, 'quitenicebooking_ignore_install_pages_notice' );
	}
	
	/**
	 * Installs pages
	 */
	public static function install_pages() {
		$get = filter_input_array( INPUT_GET );
		// check to ensure we're inside this plugin's page
		if ( isset($get['page']) && $get['page'] == 'quitenicebooking_settings' ) {
			// check for install_pages query string
			if ( isset($get['install_pages']) && $get['install_pages'] == '1' ) {
				// install the pages and set their post IDs to the settings
				
				// first, get the current theme
				$soho_hotel = FALSE;
				$current_theme = wp_get_theme();
				if ( $current_theme->get( 'Name' ) == 'Soho Hotel' ) {
					$soho_hotel = TRUE;
				}
				
				// then, get the options
				$settings = get_option( 'quitenicebooking' );
				
				// insert booking pages and update the options
				$settings['step_1_page_id'] = self::install_page('Booking Step 1', '[booking_step_1]', $soho_hotel, 'page-templates/template-full-width.php');
				$settings['step_2_page_id'] = self::install_page('Booking Step 2', '[booking_step_2]', $soho_hotel, 'page-templates/template-full-width.php');
				$settings['step_3_page_id'] = self::install_page('Booking Step 3', '[booking_step_3]', $soho_hotel, 'page-templates/template-full-width.php');
				$settings['step_4_page_id'] = self::install_page('Booking Step 4', '[booking_step_4]', $soho_hotel, 'page-templates/template-full-width.php');
				// insert payment pages
				$settings['payment_success_page_id'] = self::install_page('Payment Successful', '[payment_success]', $soho_hotel, 'page-templates/template-full-width.php');
				$settings['payment_fail_page_id'] = self::install_page('Payment Failed', '[payment_fail]', $soho_hotel, 'page-templates/template-full-width.php');
				// insert accommodation page
				$settings['accommodation_page_id'] = self::install_page('Accommodations', '[accommodation]', $soho_hotel, 'page-templates/template-full-width.php');
				
				// update the options table
				update_option( 'quitenicebooking', $settings );
				
				// redirect to prevent the page from loading with the notices still in place and options not set
				wp_redirect( admin_url( 'admin.php?page=quitenicebooking_settings' ) );
			}
		}
	}
	
	/**
	 * Installs a page
	 * 
	 * @param string $title The page title
	 * @param string $content The page content
	 * @param boolean $addtemplate Whether to add template to post meta
	 * @param string $template The template to add to post meta
	 * @return int The page's post ID
	 */
	public static function install_page( $title, $content, $addtemplate, $template ) {
		$post_id = wp_insert_post(array(
			'post_title'	=> $title,
			'post_content'	=> $content,
			'post_type'		=> 'page',
			'post_status'	=> 'publish'
		));
		if ( $addtemplate ) {
			add_post_meta( $post_id, '_wp_page_template', $template );
		}
		return $post_id;
	}
	
	/**
	 * Creates the bookings table
	 * 
	 * @global WPDB $wpdb
	 */
	public static function create_bookings_table() {
		global $wpdb;
		$sql = "CREATE TABLE {$wpdb->prefix}qns_bookings (
id bigint(20) NOT NULL AUTO_INCREMENT,
post_id bigint(20) NOT NULL,
room_booking_id int(11) NOT NULL,
checkin datetime NOT NULL,
checkout datetime NOT NULL,
type bigint(20) NOT NULL,
bed varchar(255) NULL DEFAULT 0,
adults int(11) NULL DEFAULT 0,
children int(11) NULL DEFAULT 0,
PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		require_once ABSPATH . 'wp-admin/includes/upgrade.php' ;
		dbDelta( $sql );
	}
	
	/**
	 * Notices =================================================================
	 */
	
	/**
	 * Displays upgrade notice from 1.x to 2.x
	 */
	public static function upgrade_notice_100() {
		?>
		<div class="error">
			<p>Your QNS Booking plugin data needs to be upgraded to work with this version of the plugin. It is strongly recommended that you <a href="http://codex.wordpress.org/WordPress_Backups" target="_blank">back up your Wordpress installation</a> before upgrading.</p>
			<p>To proceed with the upgrade, please deactivate, then reactivate the plugin.</p>
			<p>1. Plugins &rarr; Installed Plugins &rarr; Quite Nice Booking &rarr; Deactivate<br>2. Plugins &rarr; Installed Plugins &rarr; Quite Nice Booking &rarr; Activate</p>
		</div>
		<?php
	}
	
	/**
	 * Displays upgrade notice
	 */
	public static function backup_notice() {
		?>
		<div class="error">
			<p>Your QNS Booking plugin data needs to be upgraded to work with this version of the plugin. It is strongly recommended that you <a href="http://codex.wordpress.org/WordPress_Backups" target="_blank">back up your Wordpress installation</a> before upgrading.</p>
			<p>
				<a class="button-primary" href="<?php echo add_query_arg( 'upgrade', '1', admin_url( 'admin.php?page=quitenicebooking_settings' ) ); ?>">Upgrade</a>
			</p>
		</div>
		<?php
	}
	
	/**
	 * Displays notice to install pages
	 */
	public static function install_pages_notice() {
		?>
		<div class="updated">
		<p>Welcome to QNS Booking. The plugin needs to install some pages before it can be used.</p>
		<p>
			<a class="button-primary" href="<?php echo add_query_arg( 'install_pages', '1', admin_url( 'admin.php?page=quitenicebooking_settings' ) ); ?>">Install pages</a>
			<a class="button" href="<?php echo add_query_arg( 'ignore_install_pages_notice', '1', admin_url( 'admin.php?page=quitenicebooking_settings' ) ); ?>">Skip installation</a>
		</p>
		</div>
		<?php
	}
	
	/**
	 * Ignore install page notice
	 * 
	 * @global WP_User $current_user
	 */
	public static function ignore_install_pages_notice() {
		$current_user = wp_get_current_user();
		// if user chooses to ignore the installation notice, add that to their meta
		$get = filter_input_array( INPUT_GET );
		if ( isset($get['page']) && $get['page'] == 'quitenicebooking_settings' ) {
			if ( isset($get['ignore_install_pages_notice']) && $get['ignore_install_pages_notice'] == '1' ) {
				add_user_meta( $current_user->ID, 'quitenicebooking_ignore_install_pages_notice', '1', TRUE);
			}
			// when the plugin deactivates, the meta is removed
		}
	}

}
