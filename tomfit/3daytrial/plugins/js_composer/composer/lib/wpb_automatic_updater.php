<?php
if(!class_exists('Plugin_Upgrader')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
}
if(!class_exists('WpbAutomaticUpdater')) {
    class WpbAutomaticUpdater extends Plugin_Upgrader {
        protected static function envatoDownloadPurchaseUrl($username, $api_key, $purchase_code) {
            return 'http://marketplace.envato.com/api/edge/'.rawurlencode($username).'/'.rawurlencode($api_key).'/download-purchase:'.rawurlencode($purchase_code).'.json';
        }
        protected function getDownloadUrl() {
            global $wp_filesystem;
            $this->skin->feedback('download_envato');
            $package_filename = 'js_composer.zip';
            $res = $this->fs_connect( array(WP_CONTENT_DIR) );
            if ( ! $res ) {
                return new WP_Error('no_credentials', __("Error! Can't connect to filesystem", 'js_composer'));
            }
            $username = WPBakeryVisualComposerSettings::get('envato_username');
            $api_key =  WPBakeryVisualComposerSettings::get('envato_api_key');
            $purchase_code =  WPBakeryVisualComposerSettings::get('js_composer_purchase_code');
            if(empty($username) || empty($api_key) || empty($purchase_code)) {
                return new WP_Error('no_credentials', __('Error! Envato username, api key and your purchase code are required for downloading updates from Envato marketplace for the Visual Composer. Visit <a href="'.admin_url('options-general.php?page=wpb_vc_settings&tab=updater').''.'">Settings</a> to fix.', 'js_composer'));
            }
            $json = wp_remote_get($this->envatoDownloadPurchaseUrl($username, $api_key, $purchase_code));
            $result = json_decode($json['body'], true);
            if(!isset($result['download-purchase']['download_url'])) {
                return new WP_Error('no_credentials', __('Error! Envato API error'.(isset($result['error']) ? ': '.$result['error'] : '.'), 'js_composer'));
            }
            $result['download-purchase']['download_url'];
            $download_file =  download_url($result['download-purchase']['download_url']);
            if(is_wp_error($download_file)) {
                return $download_file;
            }
            $upgrade_folder = $wp_filesystem->wp_content_dir() . 'upgrade_tmp/js_composer_envato_package';
            if (is_dir($upgrade_folder)) {
                $wp_filesystem->delete($upgrade_folder);
            }
            $result = unzip_file($download_file, $upgrade_folder);
            if($result && is_file($upgrade_folder.'/'.$package_filename)) {
                return $upgrade_folder.'/'.$package_filename;
            }
            return new WP_Error('no_credentials', __('Error on unzipping package', 'js_composer'));

        }
        function download_package($package) {
            $package = $this->getDownloadUrl();
            if(is_wp_error($package)) return $package;
            return parent::download_package($package);
        }

        function upgradeComposer() {
            global $wp_filesystem;
            $this->init();
            $this->upgrade_strings();
            $this->strings['download_envato'] = __('Downloading package from envato market...', 'js_composer');
            add_filter('upgrader_pre_install', array(&$this, 'deactivate_plugin_before_upgrade'), 10, 2);
            add_filter('upgrader_clear_destination', array(&$this, 'delete_old_plugin'), 10, 4);
            $this->run(array(
                'package' => 'js_composer',
                'destination' => WP_PLUGIN_DIR,
                'clear_destination' => true,
                'clear_working' => true,
                'hook_extra' => array(
                    'plugin' => 'js_composer'
                )
            ));

            // Cleanup our hooks, in case something else does a upgrade on this connection.
            remove_filter('upgrader_pre_install', array(&$this, 'deactivate_plugin_before_upgrade'));
            remove_filter('upgrader_clear_destination', array(&$this, 'delete_old_plugin'));

            if ( ! $this->result || is_wp_error($this->result) )
                return $this->result;

            if(is_dir($wp_filesystem->wp_content_dir() . 'upgrade_tmp/js_composer_envato_package')) {
                $wp_filesystem->delete($wp_filesystem->wp_content_dir() . 'upgrade_tmp/js_composer_envato_package', true);
            }
            // Force refresh of plugin update information
            delete_site_transient('update_plugins');
            wp_cache_delete( 'plugins', 'plugins' );
            return true;
        }
    }
}