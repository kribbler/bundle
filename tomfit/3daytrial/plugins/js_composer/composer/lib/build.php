<?php
/**
 * WPBakery Visual Composer build plugin
 *
 * @package WPBakeryVisualComposer
 *
 */
if (!defined('ABSPATH')) die('-1');
if (!class_exists('WPBakeryVisualComposerSetup')) {
class WPBakeryVisualComposerSetup extends WPBakeryVisualComposerAbstract {
    protected $composer;
    protected $url = 'http://bit.ly/vcomposer';
    public function __construct() {
    }

    public function init($settings) {
        parent::init($settings);
        $this->composer = WPBakeryVisualComposer::getInstance();
        /**
         * initialize vc manager.
         */
        vc_mapper();
        $this->addAction('init', 'setUp');
    }
    
    public function setUp() {
        global $vc_as_theme;
        /**
         * load default shortcodes
         */
        if ( $vc_as_theme ) {
            $this->composer->setTheme();
            $this->setUpTheme();
            load_theme_textdomain('js_composer', locate_template(self::$config['APP_DIR'].'locale/'));
        } else {
            $this->composer->setPlugin();
            $this->setUpPlugin();
            load_plugin_textdomain( 'js_composer', false,  self::$config['APP_DIR'].'locale/' );
        }
        if ( function_exists( 'add_theme_support' ) ) {
            add_theme_support( 'post-thumbnails');
        }
        add_post_type_support( 'page', 'excerpt' );
        $this->composer->addFilter('the_excerpt', 'excerptFilter');
        $this->composer->addAction('wp_head', 'addMetaData');

    }
    public function addUpgradeMessageLink() {
        $username = WPBakeryVisualComposerSettings::get('envato_username');
        $api_key =  WPBakeryVisualComposerSettings::get('envato_api_key');
        $purchase_code =  WPBakeryVisualComposerSettings::get('js_composer_purchase_code');
        echo '<style type="text/css" media="all">tr#wpbakery-visual-composer + tr.plugin-update-tr a.thickbox + em { display: none; }</style>';
        if(empty($username) || empty($api_key) || empty($purchase_code)) {
            echo ' <a href="'.$this->url.'">'.__('Download new version from CodeCanyon.', 'js_composer').'</a>';
        } else {
            echo '<a href="'.wp_nonce_url( admin_url('options-general.php?page=wpb_vc_settings&vc_action=upgrade')).'">'.__('Update Visual Composer now.', 'js_composer').'</a>';
        }
    }
    public function setUpPlugin() {
        $this->composer->inlineEditor();
        if (!is_admin()) {
            $this->composer->addAction('wp_head', 'addPageCustomCss', 1000);
            $this->composer->addAction('wp_footer', 'addShortcodesCustomCss', 1000);
            $this->addAction('template_redirect', 'frontCss');
            $this->addAction('template_redirect', 'frontJsRegister');
            $this->addAction('wp_enqueue_scripts', 'frontendJsLoad');
            $this->composer->addAction( 'customize_controls_enqueue_scripts', 'customizeControlsFooterScripts', 0);
            $this->addFilter('the_content', 'fixPContent', 11); //If weight is higher then 11 it doesn work... why?
            $this->addFilter('body_class', 'jsComposerBodyClass');
            $this->addFilter('edit_post_link', 'createInlineEditorButton');
        }
    }

    public function fixPContent($content = null) {
        //$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
        $s = array(
                    '/'.preg_quote('</div>', '/').'[\s\n\f]*'.preg_quote('</p>', '/').'/i',
                    '/'.preg_quote('<p>', '/').'[\s\n\f]*'.preg_quote('<div ', '/').'/i',
                    '/'.preg_quote('<p>', '/').'[\s\n\f]*'.preg_quote('<section ', '/').'/i',
                    '/'.preg_quote('</section>', '/').'[\s\n\f]*'.preg_quote('</p>', '/').'/i'
                  );
        $r = array("</div>", "<div ", "<section ", "</section>");
        $content = preg_replace($s, $r, $content);
        return $content;
    }
    public function frontendJsLoad() {
        wp_enqueue_script( 'jquery' );
    }

    public function frontCss() {
        //wp_register_style( 'bootstrap', $this->composer->assetURL( 'bootstrap/css/bootstrap.css' ), false, WPB_VC_VERSION, 'screen' );
        //wp_register_style( 'ui-custom-theme', $this->composer->assetURL( 'css/ui-custom-theme/jquery-ui-' . WPB_JQUERY_UI_VERSION . '.custom.css' ), false, WPB_VC_VERSION, 'screen');
        wp_register_style( 'flexslider', $this->composer->assetURL( 'lib/flexslider/flexslider.css' ), false, WPB_VC_VERSION, 'screen' );
        wp_register_style( 'nivo-slider-css', $this->composer->assetURL( 'lib/nivoslider/nivo-slider.css' ), false, WPB_VC_VERSION, 'screen' );
        wp_register_style( 'nivo-slider-theme', $this->composer->assetURL( 'lib/nivoslider/themes/default/default.css' ), array('nivo-slider-css'), WPB_VC_VERSION, 'screen' );
        wp_register_style( 'prettyphoto', $this->composer->assetURL( 'lib/prettyphoto/css/prettyPhoto.css' ), false, WPB_VC_VERSION, 'screen' );
        wp_register_style( 'isotope-css', $this->composer->assetURL( 'css/isotope.css' ), false, WPB_VC_VERSION, 'all' );

        $front_css_file = $this->composer->assetURL( 'css/js_composer_front.css' );
        $upload_dir = wp_upload_dir();
        $custom_front_css_file = $upload_dir['basedir'].$this->composer->uploadDir().'/js_composer_front_custom.css';
        if ( WPBakeryVisualComposerSettings::get('use_custom') == '1' && is_file($custom_front_css_file)) {
            $front_css_file = WPBakeryVisualComposerSettings::uploadURL().'/js_composer_front_custom.css';
        }
        wp_register_style( 'js_composer_front', $front_css_file, false, WPB_VC_VERSION, 'all' );
        if(is_file($upload_dir['basedir'].$this->composer->uploadDir().'/custom.css')) {
            wp_register_style( 'js_composer_custom_css', WPBakeryVisualComposerSettings::uploadURL().'/custom.css', array('js_composer_front'), WPB_VC_VERSION, 'screen' );
        }
    }

    public function frontJsRegister() {
        wp_register_script( 'jquery_ui_tabs_rotate', $this->composer->assetURL( 'lib/jquery-ui-tabs-rotate/jquery-ui-tabs-rotate.js' ), array( 'jquery', 'jquery-ui-tabs' ), WPB_VC_VERSION, true);
        wp_register_script( 'wpb_composer_front_js', $this->composer->assetURL( 'js/js_composer_front.js' ), array( 'jquery' ), WPB_VC_VERSION, true);

        wp_register_script( 'tweet', $this->composer->assetURL( 'lib/jquery.tweet/jquery.tweet.js' ), array( 'jquery' ), WPB_VC_VERSION, true);
        wp_register_script( 'isotope', $this->composer->assetURL( 'lib/isotope/jquery.isotope.min.js' ), array( 'jquery' ), WPB_VC_VERSION, true);
        wp_register_script( 'jcarousellite', $this->composer->assetURL( 'lib/jcarousellite/jcarousellite_1.0.1.min.js' ), array( 'jquery' ), WPB_VC_VERSION, true);

        wp_register_script( 'nivo-slider', $this->composer->assetURL( 'lib/nivoslider/jquery.nivo.slider.pack.js' ), array( 'jquery' ), WPB_VC_VERSION, true);
        wp_register_script( 'flexslider', $this->composer->assetURL( 'lib/flexslider/jquery.flexslider-min.js' ), array( 'jquery' ), WPB_VC_VERSION, true);
        wp_register_script( 'prettyphoto', $this->composer->assetURL( 'lib/prettyphoto/js/jquery.prettyPhoto.js' ), array( 'jquery' ), WPB_VC_VERSION, true);
        wp_register_script( 'waypoints', $this->composer->assetURL( 'lib/jquery-waypoints/waypoints.min.js' ), array( 'jquery' ), WPB_VC_VERSION, true);

        //wp_register_script( 'jcarousellite', $this->composer->assetURL( 'js/jcarousellite_1.0.1.min.js' ), array( 'jquery' ), WPB_VC_VERSION, true);
        //wp_register_script( 'anythingslider', $this->composer->assetURL( 'js/jquery.anythingslider.min.js' ), array( 'jquery' ), WPB_VC_VERSION, true);
    }

    public function setUpTheme() {
        $this->setUpPlugin();
    }


    public function jsComposerBodyClass($classes) {
        $classes[] = 'wpb-js-composer js-comp-ver-'.WPB_VC_VERSION;
        $disable_responsive = WPBakeryVisualComposerSettings::get('not_responsive_css');
        if($disable_responsive!=='1') $classes[] = 'vc_responsive';
        else $classes[] = 'vc_non_responsive';
        return $classes;
    }

    public function createInlineEditorButton($link) {
        return $link.$this->composer->inlineEditor()->renderEditButton();
    }

    // }}
}

/* Setup for admin */

class WPBakeryVisualComposerSetupAdmin extends WPBakeryVisualComposerSetup {
    public function __construct() {
        parent::__construct();
    }

    public function setupLicenseReminder() {
        $deactivation_key = $this->composer->getDeactivationLicense();
        if(empty($deactivation_key) && empty($_COOKIE['vchideactivationmsg']) && !$this->composer->settingsAsTheme() && !$this->composer->isNetworkPlugin()) {
            $this->addACtion('admin_notices', 'adminNoticeLicenseActivation');
        }
    }
    public function adminNoticeLicenseActivation() {
        update_option('wpb_js_composer_license_activation_notified', 'yes');
        echo '<div class="updated vc-license-activation-notice"><a id="vc-license-activation-close" class="vc-notice-close">×</a><p>'.sprintf(__('Hola! Please <a href="%s">activate your copy</a> of Visual Composer to receive automatic updates.', 'js_composer'), wp_nonce_url( admin_url('options-general.php?page=wpb_vc_settings&tab=updater'))).'</p></div>';
    }
    /**
     * @deprecated
     */
    public function setupNotifications() {
        // New version notification.
        $new_version = get_option('wpb_js_composer_show_new_version_message');
        if($new_version!==false && !empty($new_version) && $new_version != WPB_VC_VERSION) {
            $this->addACtion('admin_notices', 'adminNoticeNewVersion');
        }
    }
    /**
     * @deprecated
     */
    public function adminNoticeNewVersion() {
        $version = get_option('wpb_js_composer_show_new_version_message');
        if(!empty($version))
            echo '<div class="updated"><p>'.sprintf(__('There is a new version of Visual Composer available. <a href="http://bit.ly/vcomposer" target="_blank">Download version <b>%s</b></a>.', 'js_composer'), $version).'</p></div>';
    }
    public function showSettingsNotification() {
        $this->composer->settings->showNotification();
    }
    /* Setup plugin composer */

    public function setUpPlugin() {
        if(is_plugin_active_for_network('js_composer/js_composer.php') || is_network_only_plugin('js_composer/js_composer.php')) {
            $this->composer->setAsNetworkPlugin(true);
        }
    	global $current_user;
    	get_currentuserinfo();
    	
        /** @var $settings - get use group access rules */
        $settings = WPBakeryVisualComposerSettings::get('groups_access_rules');

        parent::setUpPlugin();
        $show = true;
        foreach($current_user->roles as $role) {
	        if(isset($settings[$role]['show']) && $settings[$role]['show']==='no') {
		        $show = false;
		        break;
	        }
        }
        if ($show) {
            $this->composer->addAction( 'edit_post', 'saveMetaBoxes' );
            $this->composer->addAction( 'wp_ajax_wpb_get_element_backend_html', 'elementBackendHtmlJavascript_callback' );
            $this->composer->addAction( 'wp_ajax_wpb_get_convert_elements_backend_html', 'Convert2NewVersionJavascript_callback' );
            $this->composer->addAction( 'wp_ajax_wpb_get_row_element_backend_html', 'elementRowBackendHtmlJavascript_callback' );
            $this->composer->addAction( 'wp_ajax_wpb_shortcodes_to_visualComposer', 'shortCodesVisualComposerJavascript_callback' );
            $this->composer->addAction( 'wp_ajax_wpb_single_image_src', 'singleImageSrcJavascript_callback' );
            $this->composer->addAction( 'wp_ajax_wpb_gallery_html', 'galleryHTMLJavascript_callback' );
            $this->composer->addAction( 'wp_ajax_wpb_get_loop_suggestion', 'getLoopSuggestionJavascript_callback' );
            $this->composer->addAction( 'wp_ajax_wpb_remove_settings_notification_element_css_class', 'removeSettingsNotificationJavascript_callback' );
            $this->composer->addAction( 'wp_ajax_wpb_image_url', 'getImageUrlByIdJavascript_callback' );
            /*
             * Create edit form html
             * @deprecated
             */
            $this->composer->addAction( 'wp_ajax_wpb_show_edit_form', 'showEditFormJavascript_callback' );
            $this->composer->addAction( 'wp_ajax_wpb_get_edit_form', 'getEditFormJavascript_callback' );

            $this->composer->addAction('wp_ajax_wpb_save_template', 'saveTemplateJavascript_callback');
            $this->composer->addAction('wp_ajax_wpb_load_template', 'loadTemplateJavascript_callback');
            $this->composer->addAction('wp_ajax_wpb_load_inline_template', 'loadInlineTemplateJavascript_callback');

            $this->composer->addAction('wp_ajax_wpb_load_template_shortcodes', 'loadTemplateShortcodesJavascript_callback');

            $this->composer->addAction('wp_ajax_wpb_delete_template', 'deleteTemplateJavascript_callback');
            $this->composer->addAction('wp_ajax_wpb_get_loop_settings', 'getLoopSettingsJavascript_callback');

            $this->composer->addAction('wp_ajax_wpb_activate_license', 'activateLicense');
            $this->composer->addAction('wp_ajax_wpb_deactivate_license', 'deactivateLicense');
            $this->composer->inlineEditor()->addAction('wp_ajax_vc_load_shortcode', 'loadShortcodes');
            $this->composer->inlineEditor()->addAction('wp_ajax_vc_show_edit_form', 'renderEditForm' );
            $this->composer->inlineEditor()->addAction('wp_ajax_vc_update_content', 'savePost');
            $this->composer->inlineEditor()->addAction('wp_ajax_vc_inline_template', 'renderTemplate');
            $this->composer->inlineEditor()->addAction( 'wp_ajax_vc_show_inline_edit_form', 'buildInlineEditForm' );
            $this->addAction( 'admin_init', 'jsComposerEditPage', 5 );
            $this->composer->inlineEditor()->addFilter('page_row_actions', 'renderRowAction');
            $this->composer->inlineEditor()->addFilter('post_row_actions', 'renderRowAction');
        }
        vc_automapper()->addAction('wp_ajax_vc_automapper', 'goAction');
        if(vc_is_inline()) {
            $this->composer->inlineEditor()->addFilter( 'vc_single_param_edit', 'changeEditFormFieldParams');
            $this->composer->inlineEditor()->addFilter( 'vc_edit_form_class', 'changeEditFormParams');
        }
        $this->composer->addAction( 'admin_init', 'renderInlineEditor' );
        // Add specific CSS class by filter
        $this->addFilter('body_class', 'jsComposerBodyClass');
        $this->addFilter( 'get_media_item_args', 'jsForceSend' );

        $this->addAction( 'admin_init', 'composerRedirect' );


        $this->addAction( 'admin_init', 'registerCss' );
        $this->addAction( 'admin_init', 'registerJavascript' );
        if($this->composer->isNetworkPlugin() && is_network_admin()) {
            $this->addAction( 'network_admin_menu', 'composerSettings' );
        }
        $this->addAction( 'admin_menu', 'composerSettings' );
        $this->addAction( 'admin_print_scripts-post.php', 'editScreen_js' );
        $this->addAction( 'admin_print_scripts-post-new.php', 'editScreen_js' );

        // Upgrade message in plugins list.
        if($this->composer->updaterDisabled()) return $this;

        $plugin_file_name = 'js_composer/js_composer.php';
        new WpbAutoUpdate (WPB_VC_VERSION, 'http://wpbakery.com/version/?'.time(), $plugin_file_name);
        $this->addAction('in_plugin_update_message-'.$plugin_file_name, 'addUpgradeMessageLink');

    }

    /*
     * Set up theme filters and actions
     *
     */
    public function setUpTheme() {
        $this->setUpPlugin();
        $this->addAction('admin_init', 'themeScreen_js');
    }


    public function jsForceSend($args) {
        $args['send'] = true;
        return $args;
    }

    public function themeScreen_js() {
        wp_enqueue_script('wpb_js_theme_admin');
    }

    public function editScreen_js($anyway = false) {
        if(in_array(get_post_type(), $this->composer->getPostTypes()) || $anyway) {
            $this->setupLicenseReminder();
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_style('farbtastic');
            wp_enqueue_style('ui-custom-theme');
            wp_enqueue_style('isotope-css');
            wp_enqueue_style('animate-css');
            wp_enqueue_style('js_composer');
            wp_enqueue_style('wpb_jscomposer_autosuggest');

            WPBakeryShortCode_Settings::enqueueCss();

            wp_enqueue_script('jquery-ui-tabs');
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('jquery-ui-droppable');
            wp_enqueue_script('jquery-ui-draggable');
            wp_enqueue_script('jquery-ui-accordion');
            wp_enqueue_script('jquery-ui-autocomplete');

            wp_enqueue_script('farbtastic');

            //MMM wp_enqueue_script('bootstrap-js');
            wp_enqueue_script('isotope');
            wp_enqueue_script('wpb_bootstrap_modals_js');
            wp_enqueue_script('wpb_scrollTo_js');
            wp_enqueue_script('wpb_php_js');
            // js composer js app {{
            // wpb_js_composer_js_sortable
            wp_enqueue_script('wpb_js_composer_js_sortable');
            wp_enqueue_script('wpb_json-js');


            wp_enqueue_script('wpb_js_composer_js_tools');
            wp_enqueue_script('wpb_js_composer_js_storage');
            wp_enqueue_script('wpb_js_composer_js_models');
            wp_enqueue_script('wpb_js_composer_js_view');
            wp_enqueue_script('wpb_js_composer_js_custom_views');

            wp_enqueue_script('wpb_js_composer_js_backbone');
            wp_enqueue_script('wpb_jscomposer_composer_js');
            wp_enqueue_script('wpb_jscomposer_shortcode_js');
            wp_enqueue_script('wpb_jscomposer_modal_js');
            wp_enqueue_script('wpb_jscomposer_templates_js');
            wp_enqueue_script('wpb_jscomposer_stage_js');
            wp_enqueue_script('wpb_jscomposer_layout_js');
            wp_enqueue_script('wpb_jscomposer_row_js');
            wp_enqueue_script('wpb_jscomposer_settings_js');
            wp_enqueue_script('wpb_jscomposer_media_editor_js');
            wp_enqueue_script('wpb_jscomposer_autosuggest_js');
            // }}
            wp_enqueue_script('wpb_js_composer_js');
            WPBakeryShortCode_Settings::enqueueJs();
        }
    }
    public function registerJavascript() {
        wp_register_script('isotope', $this->composer->assetURL( 'lib/isotope/jquery.isotope.min.js' ), array( 'jquery' ), WPB_VC_VERSION, true);
        wp_register_script('wpb_bootstrap_modals_js', $this->composer->assetURL( 'lib/bootstrap_modals/js/bootstrap.min.js' ), array('jquery'), WPB_VC_VERSION, true);
        wp_register_script('wpb_scrollTo_js', $this->composer->assetURL( 'lib/scrollTo/jquery.scrollTo.min.js' ), array('jquery'), WPB_VC_VERSION, true);
        wp_register_script('wpb_php_js', $this->composer->assetURL( 'lib/php.default/php.default.min.js' ), array('jquery'), WPB_VC_VERSION, true);
        wp_register_script('wpb_json-js', $this->composer->assetURL( 'lib/json-js/json2.js' ), false, WPB_VC_VERSION, true);
        wp_register_script('wpb_js_composer_js_tools', $this->composer->assetURL( 'js/backend/composer-tools.js' ), array('jquery', 'backbone', 'wpb_json-js'), WPB_VC_VERSION, true);
        wp_register_script('wpb_js_composer_js_atts', $this->composer->assetURL( 'js/backend/composer-atts.js' ), array('wpb_js_composer_js_tools'), WPB_VC_VERSION, true);
        wp_register_script('wpb_js_composer_js_storage', $this->composer->assetURL( 'js/backend/composer-storage.js' ), array('wpb_js_composer_js_atts'), WPB_VC_VERSION, true);
        wp_register_script('wpb_js_composer_js_models', $this->composer->assetURL( 'js/backend/composer-models.js' ), array('wpb_js_composer_js_storage'), WPB_VC_VERSION, true);
        wp_register_script('wpb_js_composer_js_view', $this->composer->assetURL( 'js/backend/composer-view.js' ), array('wpb_js_composer_js_models'), WPB_VC_VERSION, true);
        wp_register_script('wpb_js_composer_js_custom_views', $this->composer->assetURL( 'js/backend/composer-custom-views.js' ), array('wpb_js_composer_js_view'), WPB_VC_VERSION, true);
        wp_register_script('wpb_jscomposer_media_editor_js', $this->composer->assetURL( 'js/backend/media-editor.js' ), array('media-views', 'media-editor', 'mce-view', 'wpb_js_composer_js_view'), WPB_VC_VERSION, true);
        wp_register_script('wpb_jscomposer_autosuggest_js', $this->composer->assetURL( 'lib/autosuggest/jquery.autoSuggest.js' ), array('wpb_js_composer_js_view'), WPB_VC_VERSION, true);
        wp_register_script('wpb_jscomposer_teaser_js', WPBakeryVisualComposer::getInstance()->assetURL( 'js/backend/composer-teaser.js' ), array(), WPB_VC_VERSION, true);
        wp_localize_script( 'wpb_js_composer_js_view', 'i18nLocale', array(
            'add_remove_picture' => __( 'Add/remove picture', 'js_composer' ),
            'finish_adding_text' => __( 'Finish Adding Images', 'js_composer' ),
            'add_image' => __( 'Add Image', 'js_composer' ),
            'add_images' => __( 'Add Images', 'js_composer' ),
            'main_button_title' => __( 'Visual Composer', 'js_composer' ),
            'main_button_title_backend_editor' => __( 'BACKEND EDITOR', 'js_composer' ),
            'main_button_title_frontend_editor' => __( 'FRONTEND EDITOR', 'js_composer' ),
            'main_button_title_revert' => __( 'CLASSIC MODE', 'js_composer' ),
            'please_enter_templates_name' => __('Please enter template name', 'js_composer'),
            'confirm_deleting_template' => __('Confirm deleting "{template_name}" template, press Cancel to leave. This action cannot be undone.', 'js_composer'),
            'press_ok_to_delete_section' => __('Press OK to delete section, Cancel to leave', 'js_composer'),
            'drag_drop_me_in_column' => __('Drag and drop me in the column', 'js_composer'),
            'press_ok_to_delete_tab' => __('Press OK to delete "{tab_name}" tab, Cancel to leave', 'js_composer'),
            'slide' => __('Slide', 'js_composer'),
            'tab' => __('Tab', 'js_composer'),
            'section' => __('Section', 'js_composer'),
            'please_enter_new_tab_title' => __('Please enter new tab title', 'js_composer'),
            'press_ok_delete_section' => __('Press OK to delete "{tab_name}" section, Cancel to leave', 'js_composer'),
            'section_default_title' => __('Section', 'js_composer'),
            'please_enter_section_title' => __('Please enter new section title', 'js_composer'),
            'error_please_try_again' => __('Error. Please try again.', 'js_composer'),
            'if_close_data_lost' => __('If you close this window all shortcode settings will be lost. Close this window?', 'js_composer'),
            'header_select_element_type' => __('Select element type', 'js_composer'),
            'header_media_gallery' => __('Media gallery', 'js_composer'),
            'header_element_settings' => __('Element settings', 'js_composer'),
            'add_tab' => __('Add tab', 'js_composer'),
            'are_you_sure_convert_to_new_version' => __('Are you sure you want to convert to new version?', 'js_composer'),
            'loading' => __('Loading...', 'js_composer'),
            // Media editor
            'set_image' => __('Set Image', 'js_composer'),
            'are_you_sure_reset_css_classes' => __('Are you sure taht you want to remove all your data?', 'js_composer'),
            'loop_frame_title' => __('Loop settings'),
            'enter_custom_layout' => __('Enter custom layout for your row:', 'js_composer'),
            'wrong_cells_layout' => __('Wrong row layout format! Example: 1/2 + 1/2 or span6 + span6.', 'js_composer'),
            'row_background_color' => __('Row background color', 'js_composer'),
            'row_background_image' => __('Row background image', 'js_composer'),
            'guides_on' => __('Guides ON', 'js_composer'),
            'guides_off' => __('Guides OFF', 'js_composer'),
            'template_save' => __('New template successfully saved!', 'js_composer'),
            'template_added' => __('Template added to the page.', 'js_composer'),
            'template_is_empty' => __('Nothing to save. Template is empty.', 'js_composer'),
            'css_updated' => __('Page settings updated!', 'js_composer'),
            'update_all' => __('Update all', 'js_composer'),
            'confirm_to_leave' => __('The changes you made will be lost if you navigate away from this page.', 'js_composer'),
            'inline_element_saved' => __('%s saved!', 'js_composer'),
            'inline_element_deleted' => __('%s deleted!', 'js_composer'),
            'inline_element_cloned' => __('%s cloned. <a href="#" class="vc-edit-cloned" data-model-id="%s">Edit now?</a>', 'js_composer')
        ) );

        wp_register_script('wpb_js_theme_admin', $this->composer->assetURL( 'js/theme_admin.js' ), array('jquery'), WPB_VC_VERSION, true);
    }

    public function registerCss() {
        //MMM wp_register_style( 'bootstrap', $this->composer->assetURL( 'bootstrap/css/bootstrap.css' ), false, WPB_VC_VERSION, false );
        wp_register_style( 'bootstrap_modals', $this->composer->assetURL( 'lib/bootstrap_modals/css/bootstrap.modals.css' ), false, WPB_VC_VERSION, false );

        wp_register_style( 'ui-custom-theme', $this->composer->assetURL( 'css/ui-custom-theme/jquery-ui-' . WPB_JQUERY_UI_VERSION . '.custom.css' ), false, WPB_VC_VERSION, false );
        wp_register_style( 'isotope-css', $this->composer->assetURL( 'css/isotope.css' ), false, WPB_VC_VERSION, 'screen' );
        wp_register_style( 'animate-css', $this->composer->assetURL( 'css/animate.css' ), false, WPB_VC_VERSION, 'screen' );

        wp_register_style( 'js_composer', $this->composer->assetURL( 'css/js_composer.css' ), array('isotope-css', 'animate-css', 'bootstrap_modals'), WPB_VC_VERSION, false );
        wp_register_style( 'js_composer_settings', $this->composer->assetURL( 'css/js_composer_settings.css' ), false, WPB_VC_VERSION, false );
        wp_register_style( 'wpb_jscomposer_autosuggest', $this->composer->assetURL( 'lib/autosuggest/jquery.autoSuggest.css' ), false, WPB_VC_VERSION, false );

    }
    /* Call to generate main template editor */

    public function jsComposerEditPage() {
        $pt_array = $this->composer->getPostTypes();
        foreach ($pt_array as $pt) {
            add_meta_box( 'wpb_visual_composer', __('Visual Composer', "js_composer"), Array($this->composer->getLayout(), 'output'), $pt, 'normal', 'high');
        }
    }

    /* Add option to Settings menu */
    public function composerSettings() {

        if(isset($this->composer->settings)) return $this->composer->settings;
        if ( current_user_can('manage_options') && $this->composer->isPlugin()) {
            $this->composer->settings = new WPBakeryVisualComposerSettings($this->composer);
            $this->composer->settings->init();
        } elseif($this->composer->isTheme() && current_user_can('edit_theme_options')) {
            $this->composer->settings = new WPBakeryVisualComposerSettings($this->composer);
            $this->composer->settings->init();
        } else {
            $this->composer->settings = false;
        }
        /*
         * Soon will be enabled.
         *
        if($this->composer->settings->requireNotification()) {
            $this->addAction('admin_notices', 'showSettingsNotification');
        }
        */
        return $this->composer->settings;
    }

    public function composerRedirect() {
        if ( get_option('wpb_js_composer_do_activation_redirect', false) ) {
            delete_option('wpb_js_composer_do_activation_redirect');
            wp_redirect(admin_url('options-general.php?page=wpb_vc_settings&build_css=1'));
        }
    }
}
}

