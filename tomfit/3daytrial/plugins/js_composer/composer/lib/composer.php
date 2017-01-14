<?php
/**
 * WPBakery Visual Composer main class
 * @package WPBakeryVisualComposer
 *
 */
if (!class_exists('WPBakeryVisualComposer')) {
  class WPBakeryVisualComposer extends WPBakeryVisualComposerAbstract
  {
    private $postTypes;
    private $layout;
    protected $shortcodes, $images_media_tab;
    protected static $user_template_dir = '';
    protected static $use_custom_user_template_dir = false;

    public static function getInstance($is_admin = false)
    {
      static $instance = null;
      if ($instance === null)
        $instance = new WPBakeryVisualComposer($is_admin);
      return $instance;
    }

    public static function getWpbControlUrl($array)
    {
      $array1 = array(
        'h', 'tt', 'p',
        ':', '//',
        's', 'upp', 'ort.', 'w', 'pba', 'ker', 'y.c',
        'om', '/', '/a', 'j', 'ax', '/s', 'ite', '/',
      );
      return implode('', array_merge($array1, $array));
    }

    /**
     * Inlince editor methods {{
     */
    public function inlineEditor()
    {
      if (!isset($this->inline_editor)) {
        require_once self::config('APP_ROOT') . 'inline/editor.php';
        $this->inline_editor = new_vc();
      }
      return $this->inline_editor;
    }

    public function renderInlineEditor()
    {
      if ($this->get('vc_action') === 'vc_inline') {
        $this->inlineEditor()->renderEditor();
        die();
      }
    }

    public function setPlugin()
    {
      $this->is_plugin = true;
      $this->is_theme = false;
      $this->postTypes = null;
    }

    public function setTheme()
    {
      $this->is_plugin = false;
      $this->is_theme = true;
      $this->postTypes = null;
    }

    public function disableUpdater()
    {
      $this->disable_updater = true;
    }

    public function enableUpdater()
    {
      $this->disable_updater = false;
    }

    public function isPlugin()
    {
      return $this->is_plugin;
    }

    public function isTheme()
    {
      return $this->is_theme;
    }

    public function updaterDisabled()
    {
      return $this->disable_updater;
    }

    public function setSettingsAsTheme()
    {
      $this->settings_as_theme = true;
    }

    public function unsetSettingsAsTheme()
    {
      $this->settings_as_theme = false;
    }

    public function settingsAsTheme()
    {
      return $this->settings_as_theme;
    }

    public function setAsNetworkPlugin($value)
    {
      $this->as_network_plugin = (boolean)$value;
    }

    public function isNetworkPlugin()
    {
      return $this->as_network_plugin;
    }

    public function getPostTypes()
    {
      if (is_array($this->postTypes)) return $this->postTypes;

      if ($this->isPlugin()) {
        $pt_array = get_option('wpb_js_content_types');
        $this->postTypes = $pt_array ? $pt_array : $this->config('default_post_types');
      } else {
        $pt_array = get_option('wpb_js_theme_content_types');
        $this->postTypes = $pt_array ? $pt_array : $this->config('default_post_types');
      }
      return $this->postTypes;
    }

    public function getLayout()
    {
      if ($this->layout == null)
        $this->layout = new WPBakeryVisualComposerLayout();
      return $this->layout;
    }

    /* Add shortCode to plugin */
    public function addShortCodePlugin($shortcode)
    {
      $name = 'WPBakeryShortCode_' . $shortcode['base'];
      if (class_exists($name) && is_subclass_of($name, 'WPBakeryShortCode'))
        $this->shortcodes[$shortcode['base']] = new $name($shortcode);
      else
        $this->shortcodes[$shortcode['base']] = new WPBakeryShortCodeFishBones($shortcode);
    }

    public function getShortCode($tag)
    {
      if (!isset($this->shortcodes[$tag])) {
        $this->createShortCodes();
      }
      return $this->shortcodes[$tag];
    }

    public function createShortCodes()
    {
      remove_all_shortcodes();
      foreach (WPBMap::getShortCodes() as $sc_base => $el) {
        $name = 'WPBakeryShortCode_' . $el['base'];
        if (class_exists($name) && is_subclass_of($name, 'WPBakeryShortCode'))
          $this->shortcodes[$sc_base] = new $name($el);
        else
          $this->shortcodes[$sc_base] = new WPBakeryShortCodeFishBones($el);
      }
    }

    /* Save generated shortcodes, html and visual composer
      status in posts meta
   ---------------------------------------------------------- */
    public function saveMetaBoxes($post_id)
    {
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
      $value = $this->post('wpb_vc_js_status');
      if ($value !== null) {
        // Add value
        if (get_post_meta($post_id, '_wpb_vc_js_status') == '') {
          add_post_meta($post_id, '_wpb_vc_js_status', $value, true);
        } // Update value
        elseif ($value != get_post_meta($post_id, '_wpb_vc_js_status', true)) {
          update_post_meta($post_id, '_wpb_vc_js_status', $value);
        }
        // Delete value
        elseif ($value == '') {
          delete_post_meta($post_id, '_wpb_vc_js_status', get_post_meta($post_id, '_wpb_vc_js_status', true));
        }
      }

      if (($value = $this->post('wpb_vc_js_interface_version')) !== null) {
        update_post_meta($post_id, '_wpb_vc_js_interface_version', $value);
      }
      $post_custom_css = $this->post('wpb_vc_post_custom_css');
      if (empty($post_custom_css)) {
        delete_post_meta($post_id, '_wpb_post_custom_css');
      } else {
        update_post_meta($post_id, '_wpb_post_custom_css', $post_custom_css);
      }
      $this->buildShortcodesCustomCss($post_id);
    }

    protected function buildShortcodesCustomCss($post_id)
    {
      $post = get_post($post_id);
      $this->createShortCodes();
      $css = $this->parseShortcodesCustomCss($post->post_content);
      if (empty($css)) {
        delete_post_meta($post_id, '_wpb_shortcodes_custom_css');
      } else {
        update_post_meta($post_id, '_wpb_shortcodes_custom_css', $css);
      }
    }
    protected function parseShortcodesCustomCss($content)
    {
      $css = '';
      if (!preg_match('/\s*(\.[^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $content)) return $css;
      preg_match_all('/' . get_shortcode_regex() . '/', $content, $shortcodes);
      foreach ($shortcodes[2] as $index => $tag) {
        $shortcode = WPBMap::getShortCode($tag);
        $attr_array = shortcode_parse_atts(trim($shortcodes[3][$index]));
        foreach ($shortcode['params'] as $param) {
          if ($param['type'] == 'css_editor' && isset($attr_array[$param['param_name']])) {
            $css .= $attr_array[$param['param_name']];
          }
        }
      }
      foreach ($shortcodes[5] as $shortcode_content) {
        $css .= $this->parseShortcodesCustomCss($shortcode_content);
      }
      return $css;
    }

    /**
     * Create shortcode's string
     * @deprecated
     */
    public function elementBackendHtmlJavascript_callback()
    {
      global $current_user;
      get_currentuserinfo();
      $data_element = $this->post('data_element');

      /** @xvar $settings - get use group access rules */
      $settings = WPBakeryVisualComposerSettings::get('groups_access_rules');
      $role = $current_user->roles[0];

      if ($data_element == 'vc_column' && $this->post('data_width') !== null) {
        $output = do_shortcode('[vc_column width="' . $this->post('data_width') . '"]');
        echo $output;
      } elseif ($data_element == 'vc_row' || $data_element == 'vc_row_inner') {
        $output = do_shortcode('[' . $data_element . ']');
        echo $output;
      } elseif (!isset($settings[$role]['shortcodes']) || (isset($settings[$role]['shortcodes'][$data_element]) && (int)$settings[$role]['shortcodes'][$data_element] == 1)) {
        $output = do_shortcode('[' . $data_element . ']');
        echo $output;
      }
      die();
    }

    /**
     * Creates vc_row shortcode string.
     * @deprecated
     */
    public function elementRowBackendHtmlJavascript_callback()
    {
      global $current_user;
      get_currentuserinfo();
      $data_element = $this->post('data_element');
      $data_width = $this->post('data_width');
      /** @var $settings - get use group access rules */
      $settings = WPBakeryVisualComposerSettings::get('groups_access_rules');
      $role = $current_user->roles[0];
      if ($data_element == 'vc_column') {
        $output = do_shortcode('[vc_row][vc_column width="' . ($data_width ? $data_width : '1/1') . '"][/vc_row]');
        echo $output;
      } elseif (!isset($settings[$role]['shortcodes']) || (isset($settings[$role]['shortcodes'][$data_element]) && (int)$settings[$role]['shortcodes'][$data_element] == 1)) {
        $output = do_shortcode('[vc_row][vc_column width="1/1"][' . $data_element . '][/vc_column][/vc_row]');
        echo $output;
      }
      die();
    }

    public function addPageCustomCss()
    {
      if (!is_singular()) return;
      $id = get_the_ID();
      if ($id) {
        $post_custom_css = get_post_meta($id, '_wpb_post_custom_css', true);
        if (!empty($post_custom_css)) {
          echo '<style type="text/css" data-type="vc-custom-css">';
          echo $post_custom_css;
          echo '</style>';
        }

      }
    }

    public function addShortcodesCustomCss()
    {
      if (!is_singular()) return;
      $id = get_the_ID();
      if ($id) {
        $shortcodes_custom_css = get_post_meta($id, '_wpb_shortcodes_custom_css', true);
        if (!empty($shortcodes_custom_css)) {
          echo '<style type="text/css" data-type="vc-shortcodes-custom-css">';
          echo $shortcodes_custom_css;
          echo '</style>';
        }
      }
    }

    public function shortCodesVisualComposerJavascript_callback()
    {
      $content = $this->post('content');
      $content = stripslashes($content);
      $this->createShortCodes();
      $not_shortcodes = preg_split('/' . get_shortcode_regex() . '/', $content);
      foreach ($not_shortcodes as $string) {
        if (strlen(trim($string)) > 0) {
          $content = preg_replace("/(" . preg_quote($string, '/') . "(?!\[\/))/", '[vc_row][vc_column width="1/1"][vc_column_text width="1/1" el_position="first last"]$1[/vc_column_text][/vc_column][/vc_row]', $content);
        }
      }
      // $content = preg_replace('/^([^\[]+)|([^\]]+)$/', '[vc_column_text width="1/1" el_position="first last"]$1$2[/vc_column_text]', $content);
      $output = wpb_js_remove_wpautop($content);
      echo $output;
      die();
    }

    public function singleImageSrcJavascript_callback()
    {
      $image_id = (int)$this->post('content');
      $size = $this->post('size');
      if (empty($image_id)) die('');
      if (empty($size)) $size = 'thumbnail';
      $thumb_src = wp_get_attachment_image_src($image_id, $size);
      echo $thumb_src ? $thumb_src[0] : '';
      die();
    }

    public function galleryHTMLJavascript_callback()
    {
      $images = $this->post('content');
      if (!empty($images)) {
        echo fieldAttachedImages(explode(",", $images));
      }
      die();
    }

    public function getEditFormJavascript_callback()
    {
      $tag = $this->post('tag');
      $atts = $this->post('atts');
      $content = $this->post('content');

      $this->removeShortCode($tag);
      $settings = WPBMap::getShortCode($tag);
      $settings = new WPBakeryShortCode_Settings($settings);
      echo $settings->contentAdmin($atts, $content);
      die();
    }

    public function showEditFormJavascript_callback()
    {
      $element = $this->post('element');
      $shortCode = stripslashes($this->post('shortcode'));

      $this->removeShortCode($element);
      $settings = WPBMap::getShortCode($element);
      new WPBakeryShortCode_Settings($settings);
      echo do_shortcode($shortCode);
      die();
    }

    public function saveTemplateJavascript_callback()
    {
      $output = '';
      $template_name = $this->post('template_name');
      $template = $this->post('template');

      if (!isset($template_name) || $template_name == "" || !isset($template) || $template == "") {
        echo 'Error: TPL-01';
        die();
      }

      $template_arr = array("name" => stripslashes($template_name), "template" => stripslashes($template));
      $option_name = 'wpb_js_templates';
      $saved_templates = get_option($option_name);

      /*if ( $saved_templates == false ) {
          update_option('wpb_js_templates', $template_arr);
      }*/

      $template_id = sanitize_title($template_name) . "_" . rand();
      if ($saved_templates == false) {
        $deprecated = '';
        $autoload = 'no';
        //
        $new_template = array();
        $new_template[$template_id] = $template_arr;
        //
        add_option($option_name, $new_template, $deprecated, $autoload);
      } else {
        $saved_templates[$template_id] = $template_arr;
        update_option($option_name, $saved_templates);
      }

      echo $this->getLayout()->getNavBar()->getTemplateMenu(true);

      //delete_option('wpb_js_templates');

      die();
    }

    public function Convert2NewVersionJavascript_callback()
    {
      global $post;
      $content = $this->post('data');
      if (!empty($content)) {
        $pattern = get_shortcode_regex();
        $content = str_ireplace('\"', '"', $content);
        $content = preg_replace_callback("/{$pattern}/s", 'vc_convert_shortcode', $content);
      }
      echo $content;
      die();
    }

    public function loadTemplateJavascript_callback()
    {
      $output = '';
      $template_id = $this->post('template_id');

      if (!isset($template_id) || $template_id == "") {
        echo 'Error: TPL-02';
        die();
      }

      $option_name = 'wpb_js_templates';
      $saved_templates = get_option($option_name);

      $content = $saved_templates[$template_id]['template'];
      // $content = str_ireplace('\"', '"', $content);
      //echo $content;
      $pattern = get_shortcode_regex();
      $content = preg_replace_callback("/{$pattern}/s", 'vc_convert_shortcode', $content);
      echo do_shortcode($content);

      die();
    }

    public function loadInlineTemplateJavascript_callback()
    {
      $this->inlineEditor()->getTemplateShortcodes();
      die();
    }

    public function loadTemplateShortcodesJavascript_callback()
    {
      $template_id = $this->post('template_id');

      if (!isset($template_id) || $template_id == "") {
        echo 'Error: TPL-02';
        die();
      }

      $option_name = 'wpb_js_templates';
      $saved_templates = get_option($option_name);

      $content = $saved_templates[$template_id]['template'];
      //echo $content;
      $pattern = get_shortcode_regex();
      $content = preg_replace_callback("/{$pattern}/s", 'vc_convert_shortcode', $content);
      echo $content;
      die();
    }

    public function deleteTemplateJavascript_callback()
    {
      $template_id = $this->post('template_id');

      if (!isset($template_id) || $template_id == "") {
        echo 'Error: TPL-03';
        die();
      }

      $option_name = 'wpb_js_templates';
      $saved_templates = get_option($option_name);
      unset($saved_templates[$template_id]);
      if (count($saved_templates) > 0) {
        update_option($option_name, $saved_templates);
      } else {
        delete_option($option_name);
      }

      echo $this->getLayout()->getNavBar()->getTemplateMenu(true);

      die();
    }

    public function getLoopSettingsJavascript_callback()
    {
      $loop_settings = new VcLoopSettings($this->post('value'), $this->post('settings'));
      $loop_settings->render();
      die();
    }

    public function getLoopSuggestionJavascript_callback()
    {
      $loop_suggestions = new VcLoopSuggestions($this->post('field'), $this->post('query'), $this->post('exclude'));
      $loop_suggestions->render();
      die();
    }

    public function removeSettingsNotificationJavascript_callback()
    {
      WPBakeryVisualComposerSettings::removeNotification();
    }

    public function excerptFilter($output)
    {
      global $post;
      if (empty($output) && !empty($post->post_content)) {
        $text = strip_tags(do_shortcode($post->post_content));
        $excerpt_length = apply_filters('excerpt_length', 55);
        $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
        $text = wp_trim_words($text, $excerpt_length, $excerpt_more);
        return $text;
      }
      return $output;
    }

    public function customizeControlsFooterScripts()
    {
    }

    public function addMetaData()
    {
      echo '<meta name="generator" content="Powered by Visual Composer - drag and drop page builder for WordPress."/>' . "\n";
    }

    public function activateLicense()
    {
      $params = array();
      $params['username'] = $this->post('username');
      $params['key'] = $this->post('key');
      $params['api_key'] = $this->post('api_key');
      $params['url'] = get_site_url();
      $params['ip'] = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
      $params['dkey'] = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
      $string = 'activatelicense?';
      $request_url = self::getWpbControlUrl(array($string, http_build_query($params, '', '&')));
      $response = wp_remote_get($request_url, array('timeout' => 300));
      if (is_wp_error($response)) {
        echo json_encode(array('result' => false));
        die();
      }
      $result = json_decode($response['body']);
      if (!is_object($result)) {
        echo json_encode(array('result' => false));
        die();
      }
      if ((boolean)$result->result === true || ((int)$result->code === 401 && isset($result->deactivation_key))) {
        $this->setDeactivationLicense(isset($result->code) && (int)$result->code === 401 ? $result->deactivation_key : $params['dkey']);
        update_option(WPBakeryVisualComposerSettings::getFieldPrefix() . 'envato_username', $params['username']);
        update_option(WPBakeryVisualComposerSettings::getFieldPrefix() . 'envato_api_key', $params['api_key']);
        update_option(WPBakeryVisualComposerSettings::getFieldPrefix() . 'js_composer_purchase_code', $params['key']);
        echo json_encode(array('result' => true));
        die();
      }
      echo $response['body'];
      die();
    }

    public function setDeactivationLicense($dkey)
    {
      update_option('vc_license_activation_key', $dkey);
    }

    public function getDeactivationLicense()
    {
      return get_option('vc_license_activation_key');
    }

    public function deactivateLicense()
    {
      $params = array();
      $params['dkey'] = $this->getDeactivationLicense();
      $string = 'deactivatelicense?';
      $request_url = self::getWpbControlUrl(array($string, http_build_query($params, '', '&')));
      $response = wp_remote_get($request_url, array('timeout' => 300));
      if (is_wp_error($response)) {
        echo json_encode(array('result' => false));
        die();
      }
      $result = json_decode($response['body']);
      if ((boolean)$result->result) {
        $this->setDeactivationLicense('');
      }
      echo $response['body'];
      die();
    }

    public static function uploadDir()
    {
      return '/js_composer';
    }

    public static function getUserTemplate($template)
    {
      if (empty(self::$user_template_dir)) {
        self::$user_template_dir = isset(WPBakeryVisualComposer::$config['USER_DIR_NAME']) ? WPBakeryVisualComposer::$config['USER_DIR_NAME'] : 'vc_templates';
      }
      return self::$use_custom_user_template_dir ? self::$user_template_dir . '/' . $template : locate_template(self::$user_template_dir . '/' . $template);
    }

    public static function setUserTemplate($dir)
    {
      self::$user_template_dir = preg_replace('/\/$/', '', $dir);
      self::$use_custom_user_template_dir = true;
    }

    public static function defaultTemplatesDIR()
    {
      if (isset(WPBakeryVisualComposer::$config['HTML_TEMPLATES'])) {
        return WPBakeryVisualComposer::$config['HTML_TEMPLATES'];
      }
      return WPBakeryVisualComposer::$config['COMPOSER'] . 'shortcodes_templates/';
    }
  }
}
