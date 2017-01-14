<?php
function vc_map($attributes) {
  if( !isset($attributes['base']) ) {
    trigger_error(__("Wrong wpb_map object. Base attribute is required", 'js_composer'), E_USER_ERROR);
    die();
  }
  WPBMap::map($attributes['base'], $attributes);
}
/* Backwards compatibility  **/
function wpb_map($attributes) { vc_map($attributes); }


function vc_remove_element($shortcode) {
  WPBMap::dropShortcode($shortcode);
}
/* Backwards compatibility  **/
function wpb_remove($shortcode) { vc_remove_element($shortcode); }


function vc_add_param($shortcode, $attributes) {
  WPBMap::addParam($shortcode, $attributes);
}
/* Backwards compatibility  **/
function wpb_add_param($shortcode, $attributes) { vc_add_param($shortcode, $attributes); }

/**
 * Shorthand function for WPBMap::modify
 * @param $name
 * @param $setting
 * @param string $value
 * @return array|bool
 */
function vc_map_update($name = '', $setting = '', $value = '') {
    return WPBMap::modify($name, $setting, $value);
}

/**
 * Shorthand function for WPBMap::mutateParam
 * @param $name
 * @param array $attribute
 */
function vc_update_shortcode_param($name, $attribute = Array()) {
  return WPBMap::mutateParam($name, $attribute);
}
/**
 * Shorthand function for WPBMap::dropParam
 * @param $name
 * @param $attribute_name
 */
function vc_remove_param($name = '', $attribute_name = '') {
    return WPBMap::dropParam($name, $attribute_name);
}
function vc_mapper() {
  return VcMapper::getInstance();
}
/**
 * Sets plugin as theme plugin.
 * @param bool $disable_updater - If value is true disables auto updater options.
 */
function vc_set_as_theme($disable_updater = false) {

    $composer = WPBakeryVisualComposer::getInstance();
    $composer->setSettingsAsTheme();
    if($disable_updater) $composer->disableUpdater();
}

/**
 * Sets directory where Visual Composer should look for template files for content elements
 * @param string full directory path to new template directory with trailing slash
 */
function vc_set_template_dir($dir) {
    WPBakeryVisualComposer::setUserTemplate($dir);
}