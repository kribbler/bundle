<?php

if(!class_exists('NewVisualComposer')) {
Class NewVisualComposer extends WPBakeryVisualComposerAbstract {
    protected $dir;
    protected $tag_index = 1;
    protected $post_shortcodes = array();
    protected $template_content = '';
    protected static $enabled_inline = true;
    protected $settings = array(
        'assets_dir' => 'assets',
        'templates_dir' => 'templates',
        'template_extension' => 'tpl.php',
        'plugin_path' => 'js_composer/inline'
    );
    protected static $content_editor_id = 'content';
    protected static $content_editor_settings = array(
        'dfw' => true,
        'tabfocus_elements' => 'insert-media-button',
        'editor_height' => 360
    );
    protected static $brand_url = 'http://vc.wpbakery.com/?utm_campaign=VCplugin_header';
    public static function getInstance() {
        static $instance=null;
        if ($instance === null) $instance = new NewVisualComposer(dirname(__FILE__));
        return $instance;
    }
    function __construct($dir) {
        $this->dir = $dir;
        $this->base_url = plugin_basename($this->dir);
        $this->composer = WPBakeryVisualComposer::getInstance();
        $this->addAction( 'admin_bar_menu', "adminBarEditLink", 1000);

        $this->setPost();
        $this->initIfActive();
    }
    public static function inlineEnabled() {
        return self::$enabled_inline;
    }
    public static function  disableInline($disable = true) {
        self::$enabled_inline = !$disable;
    }
    protected function initIfActive() {
        vc_is_inline() && !defined('CONCATENATE_SCRIPTS') && define('CONCATENATE_SCRIPTS', false);
        if($this->get('vceditor')==='true'){
            $this->addFilter('the_content', 'addContentAnchor');
            do_action('vc_inline_editor_page_view');
            $this->addAction( 'wp_enqueue_scripts', 'loadIFrameJsCss');
        }
    }
    public function addContentAnchor($content = '') {
        return '<span id="vc-inline-anchor" style="display:none !important;"></span>'.$content;
    }
    public function changeEditFormFieldParams($param) {
        $css = $param['vc_single_param_edit_holder_class'];
        $index = array_search('vc_row-fluid', $css);
        if(isset($param['edit_field_class'])) {
            $new_css = $param['edit_field_class'];
        } else {
            switch($param['type']) {
                case 'attach_image':
                case 'attach_images':
                case 'textarea_html':
                    $new_css = 'col-md-12';
                    break;
                default:
                    $new_css = 'col-md-12';
            }
        }
        if($index === false ) {
            array_unshift($css, $new_css);
        } else {
            $css[$index] = $new_css . " vc-column";
        }

        $param['vc_single_param_edit_holder_class'] = $css;
        return $param;
    }
    public function changeEditFormParams($css_classes) {
        $css = 'row vc-row';
        $index = array_search('vc_span12', $css_classes);
        if($index === false) {
           array_unshift($css_classes, $css);
        } else {
           $css_classes[$index] = $css;
        }
        return $css_classes;
    }
    public static function getInlineUrl($url = '', $id = '') {
        $the_ID = (strlen($id) > 0 ? $id :get_the_ID());
        return admin_url().'edit.php?vc_action=vc_inline&post_id='.$the_ID.'&post_type='.get_post_type($the_ID).(strlen($url) > 0 ? '&url='.rawurlencode($url) : '');
    }
    function wrapperStart() {
        return '';
    }
    function wrapperEnd() {
        return '';
    }
    public static function setBrandUrl($url) {
        self::$brand_url = $url;
    }
    public static function getBrandUrl() {
        return self::$brand_url;
    }
    public static function shortcodesRegexp() {
        $tagnames = array_keys(WPBMap::getShortCodes());
        $tagregexp = join( '|', array_map('preg_quote', $tagnames) );
        // WARNING from shortcodes.php! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
        // Also, see shortcode_unautop() and shortcode.js.
        return
            '\\['                              // Opening bracket
            . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
            . "($tagregexp)"                     // 2: Shortcode name
            . '(?![\\w-])'                       // Not followed by word character or hyphen
            . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
            .     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
            .     '(?:'
            .         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
            .         '[^\\]\\/]*'               // Not a closing bracket or forward slash
            .     ')*?'
            . ')'
            . '(?:'
            .     '(\\/)'                        // 4: Self closing tag ...
            .     '\\]'                          // ... and closing bracket
            . '|'
            .     '\\]'                          // Closing bracket
            .     '(?:'
            .         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
            .             '[^\\[]*+'             // Not an opening bracket
            .             '(?:'
            .                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
            .                 '[^\\[]*+'         // Not an opening bracket
            .             ')*+'
            .         ')'
            .         '\\[\\/\\2\\]'             // Closing shortcode tag
            .     ')?'
            . ')'
            . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]

    }
    function setPost() {
        $this->post_id = $this->get('post_id');
        if($this->post('post_id')) $this->post_id = $this->post('post_id');
        if($this->post_id) $this->post = get_post($this->post_id);
        $this->post = get_post($this->post_id);
        $GLOBALS['post'] = $this->post;
    }
    function renderEditor() {
        global $wpVC_setup, $current_user;
        get_currentuserinfo();
        $this->current_user = $current_user;
        $this->post_url = get_permalink($this->post_id);
        if(!$this->inlineEnabled() || !current_user_can('edit_post', $this->post_id)) header('Location: '.$this->post_url);

        if(method_exists($wpVC_setup, 'registerCss')) $wpVC_setup->registerCss();
        if(method_exists($wpVC_setup, 'registerJavascript')) $wpVC_setup->registerJavascript();
        if($this->post && $this->post->post_status === 'auto-draft') {
            $post_data = array('ID' => $this->post_id, 'post_status' => 'draft'); // , 'post_title' => __('No title', 'js_composer')
            wp_update_post($post_data);
            $this->post->post_status = 'draft';
        }
        $this->addFilter('admin_body_class', 'filterAdminBodyClass');

        $this->post_type = get_post_type_object($this->post->post_type);
        $this->url = $this->post_url.(preg_match('/\?/', $this->post_url) ? '&' : '?').'vceditor=true';
        $this->enqueueAdmin();

        wp_enqueue_media( array( 'post' => $this->post_id ) );
        remove_all_actions( 'admin_notices', 3 );
        remove_all_actions( 'network_admin_notices', 3 );

        $this->nav_bar = new WPBakeryVisualComposerNavBar();
        $this->template_menu = new WPBakeryVisualComposerTemplate_r();

        $this->post_custom_css =  get_post_meta($this->post_id, '_wpb_post_custom_css', true);

        if(!defined('IFRAME_REQUEST')) define('IFRAME_REQUEST', true);

        do_action('vc_admin_inline_editor');

        $this->addFilter('admin_title', 'setEditorTitle');
        $this->navbar_buttons = apply_filters('vc_nav_front_controls', $this->getLeftButtons());

        $this->render('editor');
        die();
    }
    function getLeftButtons() {
        return array(
            array('add_element', '<li class="vc-show-mobile"><a href="#" class="vc_element_button" data-model-id="vc_element" id="vc-add-new-element" title="'.__('Add new element', 'js_composer').'"></a></li>'),
            // array('add_row', '<li><a href="#" class="vc_row_button" data-tag="vc_row" id="vc-add-new-row">'.__('Add row', 'js_composer').'</a></li>'),
            array('templates', '<li><a href="#" class="vc_templates_button"  id="vc-templates-editor-button" title="'.__('Templates', 'js_composer').'"></a></li>')
        );
    }
    function setEditorTitle($admin_title) {
        return sprintf(__('Edit %s with Visual Composer', 'js_composer'), $this->post_type->labels->singular_name);
    }
    function render($template) {
        $template = $this->template($template);
        require $template;
    }
    function assetUrl($asset_path) {
        return plugins_url( preg_replace('/\s/', '%20', $this->base_url. '/' . $this->settings['assets_dir'] .'/'. $asset_path));
    }
    function template($name) {
        return $this->dir.'/templates/'.$name.'.'.$this->settings['template_extension'];
    }
    function renderEditButton() {
        if($this->showButton()) {
            return ' <a href="'.self::getInlineUrl().'" id="vc-load-inline-editor" class="vc-inline-link">'.__('Edit with Visual Composer', 'js_composer').'</a>';
        }
    }
    function renderRowAction($actions) {
        $post = get_post();
        if($this->showButton($post->ID)) $actions['edit_vc'] = '<a href="' . $this->getInlineUrl('', $post->ID) . '">' . __( 'Edit with Visual Composer', 'js_composer' ) . '</a>';
        return $actions;
    }
    function showButton($post_id = null) {
        global $current_user;
        get_currentuserinfo();
        $show = true;

        if(!self::inlineEnabled() || !current_user_can('edit_post', $post_id)) return false;
        /** @var $settings - get use group access rules */

        $settings = WPBakeryVisualComposerSettings::get('groups_access_rules');
        foreach($current_user->roles as $role) {
            if(isset($settings[$role]['show']) && $settings[$role]['show']==='no') {
                $show = false;
                break;
            }
        }
        return $show && in_array(get_post_type(), $this->composer->getPostTypes());
    }
    function adminBarEditLink($wp_admin_bar) {
        global $wp_admin_bar;
        if(is_singular()) {
            if ($this->showButton(get_the_ID())) {
                $wp_admin_bar->add_menu( array(
                    // 'parent' => $root_menu,
                    'id' => 'vc-inline-admin-bar-link',
                    'title' => __('Edit with Visual Composer', "js_composer"),
                    'href' => self::getInlineUrl(),
                    'meta' => array('class' => 'vc-inline-link')
                ) );
            }
        }
    }
    function renderEditForm() {
        $this->addFilter('admin_body_class', 'filterAdminBodyClass');
        $this->enqueueAdmin();
        $this->render('edit_form');
        die();
    }
    function setTemplateContent($content) {
        $this->template_content = $content;
    }
    function getTemplateContent() {
        return apply_filters('vc_inline_template_content', $this->template_content);
    }
    function renderTemplate() {
        $this->template_id = $this->post('template_id');
        if(empty($this->template_id)) die('0');
        $option_name = 'wpb_js_templates';
        $saved_templates = get_option($option_name);
        $this->setTemplateContent($saved_templates[$this->template_id]['template']);
        $this->enqueueRequired();
        $this->render('template');
        die();
    }
    function renderTemplates() {
        $this->render('templates');
        die();
    }
    function loadTinyMceSettings() {
        if ( ! class_exists( '_WP_Editors' ) )
            require( ABSPATH . WPINC . '/class-wp-editor.php' );
        $set = _WP_Editors::parse_settings(self::$content_editor_id, self::$content_editor_settings);
        _WP_Editors::editor_settings(self::$content_editor_id, $set);
    }
    function loadIFrameJsCss() {
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-droppable');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('jquery-ui-autocomplete');
        wp_enqueue_script( 'wpb_composer_front_js' );
        wp_enqueue_style( 'js_composer_front' );
        wp_enqueue_style('vc_inline_css', $this->assetURL('css/inline.css'));
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('waypoints');
        wp_enqueue_script('wpb_scrollTo_js', $this->composer->assetURL( 'lib/scrollTo/jquery.scrollTo.min.js' ), array('jquery'), WPB_VC_VERSION, true);
        wp_enqueue_style('js_composer_custom_css');

        wp_enqueue_script('wpb_php_js', $this->composer->assetURL( 'lib/php.default/php.default.min.js' ), array('jquery'), WPB_VC_VERSION, true);
        wp_enqueue_script('vc_inline_iframe_js', $this->assetUrl('js/vc_loader.js'), array('jquery', 'jquery-ui-sortable', 'jquery-ui-draggable'), '1.0', true);
    }
    function loadShortcodes() {
        $shortcodes = (array)$this->post('shortcodes');
        $this->renderShortcodes($shortcodes);
        echo '<div data-type="files">';
        _print_styles();
        print_head_scripts();
        print_late_styles();
        print_footer_scripts();
        echo '</div>';
        die();
    }
    function fullUrl($s)
    {
        $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
        $sp = strtolower($s['SERVER_PROTOCOL']);
        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
        $port = $s['SERVER_PORT'];
        $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
        $host = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : $s['SERVER_NAME'];
        return $protocol . '://' . $host . $port . $s['REQUEST_URI'];
    }
    static function cleanStyle() {
        return '';
    }
    function enqueueRequired() {
        global $wpVC_setup;
        do_action('wp_enqueue_scripts');
        if(method_exists($wpVC_setup, 'frontCss')) $wpVC_setup->frontCss();
        if(method_exists($wpVC_setup, 'frontJsRegister')) $wpVC_setup->frontJsRegister();
    }
    function renderShortcodes($shortcodes) {
        $this->enqueueRequired();
        foreach($shortcodes as $shortcode) {
         if(isset($shortcode['id']) && isset($shortcode['string'])) {
             echo '<div data-type="element" data-model-id="'.$shortcode['id'].'">';
             $shortcode_settings = WPBMap::getShortCode($shortcode['tag']);
             $is_container = (isset($shortcode_settings['is_container']) && $shortcode_settings['is_container'] === true) || (isset($shortcode_settings['as_parent']) && $shortcode_settings['as_parent']!==false);
             if($is_container) $shortcode['string'] = preg_replace('/\]/', '][vc_container_anchor]', $shortcode['string'], 1);
             echo '<div class="vc-element"'.self::cleanStyle().' data-container="'.$is_container.'" data-model-id="'.$shortcode['id'].'">'.$this->wrapperStart().do_shortcode(stripslashes($shortcode['string'])).$this->wrapperEnd().'</div>';
             echo '</div>';
         }
        }
    }
    function filterAdminBodyClass($string) {
        return $string.(strlen($string)>0 ? ' ' : '').'vc-editor vc-inline-shortcode-edit-form';
    }
    function adminFile($path) {
        return ABSPATH.'wp-admin/'.$path;
    }
    function enqueueAdmin() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_style('farbtastic');
        wp_enqueue_style('ui-custom-theme');
        // wp_enqueue_style('isotope-css');
        wp_enqueue_style('animate-css');
        wp_enqueue_style('wpb_jscomposer_autosuggest');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-droppable');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('jquery-ui-autocomplete');
        wp_enqueue_script('vc_inline_bootstap_js', $this->composer->assetUrl('lib/bootstrap/js/bootstrap.min.js'), array('jquery'), '3.0.2',true);
        wp_enqueue_script('farbtastic');
        // wp_enqueue_script('isotope');
        wp_enqueue_script('wpb_scrollTo_js');
        wp_enqueue_script('wpb_php_js');
        wp_enqueue_script('wpb_js_composer_js_sortable');
        wp_enqueue_script('wpb_json-js');

        wp_enqueue_script('wpb_js_composer_js_tools');
        wp_enqueue_script('wpb_js_composer_js_atts');
        wp_enqueue_script('wpb_jscomposer_media_editor_js');
        wp_enqueue_script('wpb_jscomposer_autosuggest_js');
        wp_enqueue_script('vc_inline_shortcodes_builder_js', $this->assetUrl('js/lib/shortcodes_builder.js'), array('jquery', 'underscore', 'backbone', 'wpb_js_composer_js_tools'), '1', true);
        wp_enqueue_script('vc_inline_models_js', $this->assetUrl('js/lib/models.js'), array('vc_inline_shortcodes_builder_js'), '1', true);
        wp_enqueue_script('vc_inline_panels_js', $this->assetUrl('js/lib/panels.js'), array('vc_inline_models_js'), '1', true);
        wp_enqueue_script('vc_inline_js', $this->assetUrl('js/lib/vc.js'), array('vc_inline_panels_js'), '1', true);
        wp_enqueue_script('vc_inline_custom_view_js', $this->assetUrl('js/lib/custom_views.js'), array('vc_inline_shortcodes_builder_js', 'vc_inline_panels_js'), '1', true);
        wp_enqueue_script('vc_inline_build_js', $this->assetUrl('js/build.js'), array('vc_inline_custom_view_js'), '1', true);
        wp_enqueue_style('vc_inline_css', $this->assetUrl('css/js_composer.css'));
    }
    function buildEditForm() {
        $element = $this->get( 'element' );
        $shortCode = stripslashes($this->get( 'shortcode' ));
        WpbakeryShortcodeParams::setEnqueue(true);
        $this->removeShortCode($element);
        $settings = WPBMap::getShortCode($element);
        new WPBakeryShortCode_Settings($settings);
        return do_shortcode($shortCode);
    }
    public function buildInlineEditForm() {
        $elements = $this->post( 'elements' );
        if(sizeof($elements) > 1) {
            echo '<div class="vc-elements-settings-list">';
            foreach($elements as $element) {
                echo '<h3 class="handler">'.ucfirst($element['name']).' '.__('settings', 'js_composer').'</h3>';
                $this->outputShortcodeSettings($element);
            }
            echo '</div>';
            die();

        }
        if(sizeof($elements)==1) $this->outputShortcodeSettings($elements[0]);
        die();
    }
    function outputShortcodeSettings($element) {
        echo '<div class="vc-element-settings wpb-edit-form" data-id="'.$element['id'].'">';
        $shortCode = stripslashes($element['shortcode']);
        $this->removeShortCode($element['tag']);
        $settings = WPBMap::getShortCode($element['tag']);
        new WPBakeryShortCode_Settings($settings);
        echo do_shortcode($shortCode);
        echo '</div>';
    }
    function getPageShortcodes() {
        $post = get_post($this->post_id);
        $content = $post->post_content;
        $not_shortcodes = preg_split('/'.self::shortcodesRegexp().'/', $content);
        foreach($not_shortcodes as $string ) {
            if( strlen(trim($string))>0 ) {
                $content = preg_replace("/(".preg_quote($string, '/')."(?!\[\/))/", '[vc_row][vc_column width="1/1"][vc_column_text]$1[/vc_column_text][/vc_column][/vc_row]', $content);
            }
        }
        // $content = preg_replace('/^([^\[]+)|([^\]]+)$/', '[vc_column_text width="1/1" el_position="first last"]$1$2[/vc_column_text]', $content);
        // $output = wpb_js_remove_wpautop( $content );
        echo $this->parseShortcodesString($content);
    }
    function getTemplateShortcodes() {
        $template_id = $this->post( 'template_id' );

        if ( !isset($template_id) || $template_id == "" ) { echo 'Error: TPL-02'; die(); }

        $option_name = 'wpb_js_templates';
        $saved_templates = get_option($option_name);

        $content = isset($saved_templates[$template_id]) ? $saved_templates[$template_id]['template'] : '';
        echo $this->parseShortcodesString($content);
    }
    function parseShortcodesString($content ,$is_container = false, $parent_id = false) {
        $string = '';
        preg_match_all('/'.self::shortcodesRegexp().'/', $content, $found);
        if(count($found[2]) == 0 ) {
            return $is_container && strlen($content) > 0 ? $this->parseShortcodesString('[vc_column_text]'.$content.'[/vc_column_text]', false, $parent_id) : $content;
            return $content;
        }
        foreach($found[2] as $index => $s) {
            $id = md5(time().'-'.$this->tag_index++);
            $content = $found[5][$index];
            $shortcode = array('tag' => $s, 'attrs_query' => $found[3][$index], 'attrs' => shortcode_parse_atts($found[3][$index]), 'id' => $id, 'parent_id' => $parent_id);
            if(WPBMap::getParam($s, 'content')!==false) $shortcode['attrs']['content'] = $content;
            $this->post_shortcodes[] = $shortcode;
            $string .= $this->toString($shortcode, $content);
        }
        return $string;
    }
    function toString($shortcode, $content) {
        $shortcode_settings = WPBMap::getShortCode($shortcode['tag']);
        $is_container = (isset($shortcode_settings['is_container']) && $shortcode_settings['is_container'] === true) ||(isset($shortcode_settings['as_parent']) && $shortcode_settings['as_parent']!==false);
        return do_shortcode('<div class="vc-element" data-tag="'.$shortcode['tag'].'" data-model-id="'.$shortcode['id'].'"'.self::cleanStyle().'>'.$this->wrapperStart()
               .'['.$shortcode['tag'].' '.$shortcode['attrs_query'].']'.($is_container ? '[vc_container_anchor]' : '').$this->parseShortcodesString($content, $is_container, $shortcode['id']).'[/'.$shortcode['tag'].']'.$this->wrapperEnd().'</div>');
    }
    function savePost() {
        /*
        $content = stripslashes($this->post('content'));
        $post_id = $this->post('post_id');
        $post = get_post($post_id);
        // $post_type_object = get_post_type_object($post->post_type);
        $post_status = $this->post('post_status');
        $post_data = array('ID' => $post_id, 'post_content' => $content);
        if($post_status) $post_data['post_status'] =
        if($post_status && $post_status === 'publish') {
            $post_data['post_status'] = !current_user_can( $post_type_object->cap->publish_posts ) ? 'pending' : $post_status;
        }
        if(is_string($this->post('title'))) $post_data['post_title'] = $this->post('title');
        */
        // edit_post($_POST);
        $post_id = $this->post('post_ID');
        check_admin_referer('update-post_' . $post_id);
        $post_id = edit_post();
        // Session cookie flag that the post was saved
        if ( isset( $_COOKIE['wp-saving-post-' . $post_id] ) )
            setcookie( 'wp-saving-post-' . $post_id, 'saved' );
        // Post custom css settings.
        $post_custom_css = $this->post('post_custom_css');
        if(empty($post_custom_css)) {
            delete_post_meta( $post_id, '_wpb_post_custom_css');
        } else {
            update_post_meta( $post_id, '_wpb_post_custom_css', $post_custom_css );
        }
        echo true;
        die();
    }
 }
}

function vc_container_anchor() {
    return '<span class="vc-container-anchor"></span>';
}
add_shortcode('vc_container_anchor', 'vc_container_anchor');
if(!function_exists('new_vc')) {
    function new_vc() {
        return NewVisualComposer::getInstance();
    }
}
