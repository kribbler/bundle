<?php

$data = array(); 
if ($_GET['vrm']){
	// start interrogating the web service
	
	$data['pa_width'] = '175';
	$data['pa_rimsize'] = '16';
	$data['pa_profile'] = '80';
	$data['pa_speed'] = 'y';
	$data['vrm'] = $_GET['vrm'];
}

echo json_encode($data);die();
