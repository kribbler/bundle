<?php
$service_username			= 'tyreworks';
$service_password			= '31072014';
$service_clientref			= 'test';
$service_clientdescription	= 'test';
$service_key1				= 'cw31tw14';
$service_version			= '0.31.test';

$data = array(); 


if ($_GET['vrm']){
	// start interrogating the web service
	
	$data['pa_width'] = '175';
	$data['pa_rimsize'] = '16';
	$data['pa_profile'] = '80';
	$data['pa_speed'] = 'n';
	$data['vrm'] = $_GET['vrm'];
	
	if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1xx'){
		$map_url = "http://localhost/tyreworks/wp-content/uploads/test1.xml";
	} else {
		//$map_url = "http://tyreworks.co.uk/test1.xml";
		//$x = download_page($map_url);
		//var_dump($x); die();
		/**
		 * bellow is the good service url
		 */
		$map_url = "http://www1.carwebuk.com";
		$map_url .= "/CarweBVRRB2Bproxy/carwebvrrwebservice.asmx/strB2BGetVehicleByVRM?";
		$map_url .= "strUserName=" . $service_username;
		$map_url .= "&strPassword=" . $service_password;
		$map_url .= "&strClientRef=" . $service_clientref;
		$map_url .= "&strClientDescription=" . $service_clientdescription;
		$map_url .= "&strKey1=" . $service_key1;
		$map_url .= "&strVRM=" . str_replace(" ", "", $_GET['vrm']);
		$map_url .= "&strVersion=" . $service_version;
		/*
		if ($_SERVER['REMOTE_ADDR'] == '83.103.200.163'){
			$map_url = 'http://innowllc.com/test1.xml';
		}*/
	}
	if (($response_xml_data = file_get_contents($map_url))===false){
	    echo "Error fetching XML\n";
	} else {
	   libxml_use_internal_errors(true);
	   //var_dump(file_get_contents($map_url));
	   $xml_data = simplexml_load_string($response_xml_data);
	   //var_dump($xml_data);
	   if (!$xml_data) {
	       echo "Error loading XML\n";
	       foreach(libxml_get_errors() as $error) {
	           echo "\t", $error->message;
	       }
	   } else {
	      $tyre_data = (array)$xml_data->DataArea->Vehicles->Vehicle->TyreData->TyreOption;
		  $name_data = (array)$xml_data->DataArea->Vehicles->Vehicle;
		  //var_dump($tyre_data);
		  //var_dump((array)$tyre_data->FRONT_Width);
		  $data['pa_width'] = $tyre_data['FRONT_Width'];
		  $data['pa_rimsize'] = str_replace("R", "", $tyre_data['FRONT_Rim']);
		  $data['pa_profile'] = $tyre_data['FRONT_Ratio'];
		  $data['pa_speed'] = strtolower($tyre_data['FRONT_SpeedRating']);
		  $data['tyres_for'] = $_GET['vrm'] . ', ' . $name_data['Combined_Make'] . ' ' . $name_data['Combined_Model']; 
		  //var_dump($data);
	   }
	}
}

function download_page($path){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$path);
	curl_setopt($ch, CURLOPT_FAILONERROR,1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	$retValue = curl_exec($ch);	
	var_dump($retValue);		 
	curl_close($ch);
	return $retValue;
}

echo json_encode($data);die();
