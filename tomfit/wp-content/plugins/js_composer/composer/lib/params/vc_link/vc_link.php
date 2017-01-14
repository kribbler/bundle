<?php
function vc_vc_link_form_field($settings, $value) {
    $link = vc_build_link($value);
    return '<div class="vc-link">'
        .'<input name="'.$settings['param_name'].'" class="wpb_vc_param_value  '.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'.htmlentities($value).'" data-json="'.htmlentities(json_encode($link)).'" />'
        .'<a href="#" class="button vc-link-build '.$settings['param_name'].'_button">'.__('Select URL', 'js_composer').'</a> <span class="vc_link_label_title vc_link_label">'.__('Title', 'js_composer').':</span> <span class="title-label">'.$link['title'].'</span> <span class="vc_link_label">'.__('URL', 'js_composer').':</span> <span class="url-label">'.$link['url'].' '.$link['target'].'</span>'
        .'</div>';
}

function vc_build_link($value) {
    return vc_parse_multi_attribute($value, array('url' => '', 'title' => '', 'target' => ''));
}