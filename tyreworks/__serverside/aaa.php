<?php
echo ';hee';
ini_set("max_execution_time",0);
ini_set('memory_limit', '-1');
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once '../wp-config.php';


$new_post_custom_fields[] = array(
	        //Make sure the 'name' is same as you have the attribute
	        'name' => 'pa_brand',
	        'value' => 'ANTERA',
	        'position' => 0,
	        'is_visible' => 1,
	        'is_variation' => 0,
	        'is_taxonomy' => 1
	    );
//pr($new_post_custom_fields);die();
add_post_meta(21805, '_product_attributes', $new_post_custom_fields, true) or die('error');
//die();

function pr($s){
	echo "<pre>";
	var_dump($s);
	echo "</pre>";
}