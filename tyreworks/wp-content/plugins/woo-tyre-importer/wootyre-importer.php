<?php /*
    Plugin Name: Woo Tyre Importer
    Plugin URI: http://tyreworks.co.uk
    Description: CSV import utility for WooCommerce
    Version: 1.0
    Author: Daniel Oraca
    Author URI: 
    Text Domain: wootyre-importer
    Domain Path: /languages/
*/

    class Wootyre_Importer {
        
        public function __construct() {
            add_action( 'init', array( 'Wootyre_Importer', 'translations' ), 1 );
            add_action('admin_menu', array('Wootyre_Importer', 'admin_menu'));
            add_action('wp_ajax_wootyre-importer-ajax', array('Wootyre_Importer', 'render_ajax_action'));
			add_action('wp_ajax_wootyre-importer-check-duplicate', array('Wootyre_Importer', 'render_ajax_action_check_duplicate'));
        }

        public function translations() {
            load_plugin_textdomain( 'wootyre-importer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }

        public function admin_menu() {
            add_management_page( __( 'WooTYRE Product Importer', 'wootyre-importer' ), __( 'WooTyre Importer', 'wootyre-importer' ), 'manage_options', 'wootyre-importer', array('Wootyre_Importer', 'render_admin_action'));
        }
        
        public function render_admin_action() {
            $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'upload';
            require_once(plugin_dir_path(__FILE__).'wootyre-importer-common.php');
            require_once(plugin_dir_path(__FILE__)."wootyre-importer-{$action}.php");
        }
        
        public function render_ajax_action() {
            require_once(plugin_dir_path(__FILE__)."wootyre-importer-ajax.php");
            die(); // this is required to return a proper result
        }

		public function render_ajax_action_check_duplicate(){
			require_once(plugin_dir_path(__FILE__)."check_duplicate.php");
			die();
		}
    }
    
    $Wootyre_importer = new Wootyre_Importer();
