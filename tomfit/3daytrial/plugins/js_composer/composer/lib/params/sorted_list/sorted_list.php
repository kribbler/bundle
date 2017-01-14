<?php
function vc_sorted_list_form_field($settings, $value) {
    return '<div class="vc-sorted-list">'
        .'<input name="'.$settings['param_name'].'" class="wpb_vc_param_value  '.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'.$value.'" />'
        .'<div class="vc-sorted-list-toolbar">'.vc_sorted_list_parts_list($settings['options']).'</div>'
        .'<ul class="vc-sorted-list-container"></ul>'
        .'</div>';
}


function vc_sorted_list_parts_list($list) {
    $output = '';
    foreach($list as $control) {
        $output .= '<div class="vc-sorted-list-checkbox"><label><input type="checkbox" name="vc_sorted_list_element" value="'.$control[0].'" data-element="'.$control[0].'" data-subcontrol="'.(count($control) > 1 ? htmlspecialchars(json_encode(array_slice($control, 2))) : '').'"> <span>'.htmlspecialchars($control[1]).'</span></label></div>';
    }
    return $output;
}

function vc_sorted_list_parse_value($value) {
    $data = array();
    $split = preg_split('/\,/', $value);
    foreach($split as $v) {
        $v_split = array_map('rawurldecode', preg_split('/\|/', $v));
        if(count($v_split) > 0) $data[] = array($v_split[0], count($v_split)>1 ? array_slice($v_split, 1) : '');
    }
    return $data;
}