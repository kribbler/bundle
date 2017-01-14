<?php
function vc_options_form_field($settings, $value) {
    return '<div class="vc-options">'
        .'<input name="'.$settings['param_name'].'" class="wpb_vc_param_value  '.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'.$value.'"/>'
        .'<a href="#" class="button vc-options-edit '.$settings['param_name'].'_button">'.__('Manage options', 'js_composer').'</a>'
        .'</div><div class="vc-options-fields" data-settings="'.htmlspecialchars(json_encode($settings['options'])).'"><a href="#" class="button vc-close-button">'.__('Close', "js_composer").'</a></div>';
}
