<?php
$start = microtime(true);

ini_set("max_execution_time",0);
ini_set('memory_limit', '-1');
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once '../wp-config.php';

$author_ID = 1;

send_email('starting the import via cron', 'done 40.000!');

$tyres = get_java_tyres(45000);
//pr($tyres);die();
foreach ($tyres as $tyre){
	if ($tyre['Tyre_Price'] > 0)
		import_tyre_to_woocommerce($tyre, $author_ID);
	//import_tyre_to_woocommerce($tyre, $author_ID);
}

//die('wtf!?');
send_email('import complete', 'done 40.000!');




/**
* functions::
*/

function import_tyre_to_woocommerce($product, $user_id){
	global $wpdb;
	//pr($product['Quantity']);die();
	$existing_post_query = array(
        'numberposts' => 1,
        'meta_key' => '_sku',
        'meta_query' => array(
            array(
                'key'=>'_sku',
                'value'=> $product['StockCode'] . '-'. sanitize_title($product['TyreDesc']),
                'compare' => '='
            )
        ),
        'post_type' => 'product');
    $existing_posts = get_posts($existing_post_query);
    
    if ($existing_posts){
    	$post_id = $existing_posts[0]->ID;
		mess_with_variations( $post_id, $product );	
    } else {
    	/** 
    	avoid importing new product!!!
		$post = array(
			'post_author' => $user_id,
			'post_content' => $product['TyreDesc'],
			'post_status' => "publish",
			'post_title' => $product['TyreDesc'],
			'post_parent' => '',
			'post_type' => "product",
		);
		
		//Create post
		$new_post_id = wp_insert_post( $post );
		set_product_category($product, $new_post_id);
		set_product_junk_meta($new_post_id, $product);

		mess_with_variations( $new_post_id, $product );		
		*/
	} 

	/**
	//this is to avoid importing of attributes
	$new_post_custom_fields = set_new_post_custom_fields($product);

	$existing_product_attributes = get_post_meta($post_id, '_product_attributes', true);
	if(is_array($existing_product_attributes)) {
		$max_position = 0;
		foreach($existing_product_attributes as $field_slug => $field_data) {
            $max_position = max(intval($field_data['position']), $max_position);
        }
        foreach($new_post_custom_fields as $field_slug => $field_data) {
            if(!array_key_exists($field_slug, $existing_product_attributes)) {
                $new_post_custom_fields[$field_slug]['position'] = ++$max_position;
            }
        }
        $new_post_custom_fields = array_merge($existing_product_attributes, $new_post_custom_fields);
	}
	
	update_post_meta($post_id, '_product_attributes', $new_post_custom_fields);	
	$new_post_terms = set_new_post_terms($product);

	foreach($new_post_terms as $tax => $term_ids) {
        wp_set_object_terms($post_id, $term_ids, $tax);
    }

    */

//echo 'new cf:::'; pr(get_post_meta($post_id, '_product_attributes', true));


	//die('hold on buster');
	//die();
}

function set_new_post_custom_fields($product){
	//pr($product);die('heeeelp ');
	$new_post_custom_fields = array();
	foreach ($product as $key => $value) {
		if ($key == 'Width'){
			$new_post_custom_fields['pa_width'] = Array(
	    		'name'=> 'pa_width',
	    		'value'=> $product['Width'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'ManufacturerName'){
			$new_post_custom_fields['pa_brand'] = Array(
	    		'name'=> 'pa_brand',
	    		'value'=> $product['ManufacturerName'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'Season'){
			$new_post_custom_fields['pa_season'] = Array(
	    		'name'=> 'pa_season',
	    		'value'=> $product['Season'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'Rim_Diameter'){
			$new_post_custom_fields['pa_rim-size'] = Array(
	    		'name'=> 'pa_rim-size',
	    		'value'=> $product['Rim_Diameter'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'Profile_Ratio'){
			$new_post_custom_fields['pa_profile'] = Array(
	    		'name'=> 'pa_profile',
	    		'value'=> $product['Profile_Ratio'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'LoadIndex_Speed'){
			$new_post_custom_fields['pa_speed'] = Array(
	    		'name'=> 'pa_speed',
	    		'value'=> $product['LoadIndex_Speed'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'TreadPattern'){
			$new_post_custom_fields['pa_tread-pattern'] = Array(
	    		'name'=> 'pa_tread-pattern',
	    		'value'=> $product['TreadPattern'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'ExtraLoad'){
			$new_post_custom_fields['pa_extraload'] = Array(
	    		'name'=> 'pa_extraload',
	    		'value'=> $product['ExtraLoad'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'RunFlat'){
			$new_post_custom_fields['pa_runflat'] = Array(
	    		'name'=> 'pa_runflat',
	    		'value'=> $product['RunFlat'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'TyreClass'){
			$new_post_custom_fields['pa_tyreclass'] = Array(
	    		'name'=> 'pa_tyreclass',
	    		'value'=> $product['TyreClass'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'rrc_Grade'){
			$new_post_custom_fields['pa_rrc-grade'] = Array(
	    		'name'=> 'pa_rrc-grade',
	    		'value'=> $product['rrc_Grade'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'WetGrip'){
			$new_post_custom_fields['pa_wetgrip'] = Array(
	    		'name'=> 'pa_wetgrip',
	    		'value'=> $product['WetGrip'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'WetGrip_Grade'){
			$new_post_custom_fields['pa_wetgrip-grade'] = Array(
	    		'name'=> 'pa_wetgrip-grade',
	    		'value'=> $product['WetGrip_Grade'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'NoiseDb'){
			$new_post_custom_fields['pa_noisedb'] = Array(
	    		'name'=> 'pa_noisedb',
	    		'value'=> $product['NoiseDb'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
		else if ($key == 'BarRating'){
			$new_post_custom_fields['pa_bar-rating'] = Array(
	    		'name'=> 'pa_bar-rating',
	    		'value'=> $product['BarRating'],
			    'is_visible' => '1',
			    'is_variation' => '0',
			    'is_taxonomy' => '1'
			);
		}
	}
	
	return $new_post_custom_fields;
}

function set_new_post_terms($product){
	$new_post_terms = array();
	$new_post_terms['pa_width'] = array(0 => '225x'); 

	foreach ($product as $key => $value) {
		if ($key == 'Width'){
			$new_post_terms['pa_width'] = array( 0 => $value );
		}
		else if ($key == 'ManufacturerName'){
			$new_post_terms['pa_brand'] = array( 0 => $value );
		}
		else if ($key == 'Season'){
	    	$new_post_terms['pa_season'] = array( 0 => $value );
		}
		else if ($key == 'Rim_Diameter'){
	    	$new_post_terms['pa_rim-size'] = array( 0 => $value );
		}
		else if ($key == 'Profile_Ratio'){
	    	$new_post_terms['pa_profile'] = array( 0 => $value );
		}
		else if ($key == 'LoadIndex_Speed'){
			$new_post_terms['pa_speed'] = array( 0 => $value );
		}
		else if ($key == 'TreadPattern'){
			$new_post_terms['pa_tread-pattern'] = array( 0 => $value );
		}
		else if ($key == 'ExtraLoad'){
			$new_post_terms['pa_extraload'] = array( 0 => $value );
		}
		else if ($key == 'RunFlat'){
			$new_post_terms['pa_runflat'] = array( 0 => $value );
		}
		else if ($key == 'TyreClass'){
			$new_post_terms['pa_tyreclass'] = array( 0 => $value );
		}
		else if ($key == 'rrc_Grade'){
			$new_post_terms['pa_rrc-grade'] = array( 0 => $value );
		}
		else if ($key == 'WetGrip'){
			$new_post_terms['pa_wetgrip'] = array( 0 => $value );
		}
		else if ($key == 'WetGrip_Grade'){
			$new_post_terms['pa_wetgrip-grade'] = array( 0 => $value );
		}
		else if ($key == 'NoiseDb'){
			$new_post_terms['pa_noisedb'] = array( 0 => $value );
		}
		else if ($key == 'BarRating'){
			$new_post_terms['pa_bar-rating'] = array( 0 => $value );
		}
	}
	return $new_post_terms;
}

function mess_with_variations($new_post_id, $product){
	global $wpdb;

	//start messing with variations
    wp_set_object_terms ($new_post_id,'variable','product_type');
    $avail_quantities = get_available_quantities( $product );
    
    wp_set_object_terms($new_post_id, $avail_quantities, 'pa_service');

    $thedata = Array(
    	'pa_service'=>Array(
			'name'=>'pa_service',
			'value'=>'',
			'is_visible' => '1',
			'is_variation' => '1',
			'is_taxonomy' => '1'
		)
	);

    /**
	update_post_meta( $new_post_id,'_product_attributes',$thedata);
	*/

	//now add quantity variations
	//add variations
	$i=1;
    while ($i<=2) {//while creates 2 posts:
    	$product_variation_title = 'Variation Service #' . $i . ' of 2 for '. $new_post_id . ' - ' . $product['TyreDesc'];
    	$existing_variation = get_page_by_title( $product_variation_title, OBJECT, 'product_variation' );
    	
    	if (!$existing_variation){
	    	$my_post = array(
	    		'post_title'=> $product_variation_title,
			    'post_name' => 'product-' . $new_post_id . '-variation-' . $i,
	    		'post_status' => 'publish',
	    		'post_parent' => $new_post_id,//post is a child post of product post
	    		'post_type' => 'product_variation',//set post type to product_variation
	    		'guid'=>home_url() . '/?product_variation=product-' . $new_post_id . '-variation-' . $i
	    	);
	    	$attID = wp_insert_post( $my_post );
	    }

	    //set IDs for product_variation posts:
	    $variation_id = $new_post_id + 1;
	    $variation_two = $variation_id + 1;

	    //Create 2xl variation for ea product_variation:
	    //update_post_meta($variation_id, 'attribute_pa_service', $product['Quantity'][0]['SiteName']);
	    update_post_meta($variation_id, 'attribute_pa_service', get_slug($product['Quantity'][0]['SiteName']));
	    update_post_meta($variation_id, '_price', $product['Tyre_Price']);
	    update_post_meta($variation_id, '_regular_price', $product['Tyre_Price']);
	    update_post_meta($variation_id, '_variation_price', $product['Tyre_Price']);
	    update_post_meta( $variation_id, '_stock_status', set_stock_status($product['Quantity'][0]['Qty']));
		update_post_meta( $variation_id, '_stock', $product['Quantity'][0]['Qty'] );
	    
	    //add size attributes to this variation:
    	wp_set_object_terms($variation_id, $avail_quantities, 'pa_service');
    	$thedata = Array('pa_service'=>Array(
    		'name'=> $product['Quantity'][0]['SiteName'],
    		'value'=>'',
		    'is_visible' => '1',
		    'is_variation' => '1',
		    'is_taxonomy' => '1'
    		)
    	);
    	/**
    	update_post_meta( $variation_id,'_product_attributes',$thedata);
		*/

	    //Create xl variation for ea product_variation:
	    //update_post_meta( $variation_two, 'attribute_pa_service', $product['Quantity'][1]['SiteName']);
	    update_post_meta( $variation_two, 'attribute_pa_service', get_slug( $product['Quantity'][1]['SiteName'] ));
	    update_post_meta( $variation_two, '_price', $product['Tyre_Price'] );
	    update_post_meta( $variation_two, '_regular_price', $product['Tyre_Price'] );
	    update_post_meta( $variation_two, '_variation_price', $product['Tyre_Price'] );
	    update_post_meta( $variation_two, '_stock_status', set_stock_status($product['Quantity'][1]['Qty']));
		update_post_meta( $variation_two, '_stock', $product['Quantity'][1]['Qty'] );

    	//add size attributes:
    	wp_set_object_terms($variation_two, $avail_quantities, 'pa_service');
    	$thedata = Array('pa_service'=>Array(
    		'name'=> $product['Quantity'][1]['SiteName'],
		    'value'=>'',
		    'is_visible' => '1',
		    'is_variation' => '1',
		    'is_taxonomy' => '1'
		    )
    	);
    	/**
    	update_post_meta( $variation_two,'_product_attributes',$thedata);
		*/

		$i++;
	}//end while i is less than or equal to 5(for 5 size variations)
	//pr($product); die();
	set_tyre_as_processed($product['TyreID']);
}

function set_tyre_as_processed($id){
	global $wpdb;
	$query = "UPDATE `Tyres` SET `processed` = '1' WHERE `Tyres`.`TyreID` = $id; ";
	//echo "<pre>"; var_dump($query); echo "</pre>";
	$wpdb->query($query);
	log_row($id);
}

function log_row($query){
	$myFile = "server.log";
	$fh = fopen($myFile, 'a') or die("can't open file");
	$stringData = date('Y-m-d h:i:s') . ' - ' . $query . "\n";
	fwrite($fh, $stringData);
	fclose($fh);
}
function get_slug($value){
	$service_name = get_term_by('name', $value, 'pa_service');
	return $service_name->slug;
}
function set_stock_status($nr){
	if ($nr > 0) {
		return "instock";
	} else {
		return "outofstock";
	}
}
function test_add_product(){
	$post = array(
	 'post_title'   => "Product with Variations2",
	 'post_content' => "product post content goes here...",
	 'post_status'  => "publish",
	 'post_excerpt' => "product excerpt content...",
	 'post_name'    => "test_prod_vars2", //name/slug
	 'post_type'    => "product"
	 );

	$new_post_id = wp_insert_post( $post, $wp_error );

	wp_set_object_terms ($new_post_id,'variable','product_type');
	wp_set_object_terms( $new_post_id, "Tyres", 'product_cat');

	$avail_attributes = array(
		'CONTINENTAL',
		'pirelli'
	);
	wp_set_object_terms($new_post_id, $avail_attributes, 'pa_brand');

	$thedata = Array('pa_brand'=>Array(
	'name'=>'pa_brand',
	'value'=>'',
	'is_visible' => '1',
	'is_variation' => '1',
	'is_taxonomy' => '1'
	));

	update_post_meta( $new_post_id,'_product_attributes',$thedata);

	update_post_meta( $new_post_id, '_stock_status', 'instock');
	update_post_meta( $new_post_id, '_weight', "0.06" );
	update_post_meta( $new_post_id, '_sku', "skutest1");
	update_post_meta( $new_post_id, '_stock', "100" );
	update_post_meta( $new_post_id, '_visibility', 'visible' );

	//add variations
	$i=1;
    while ($i<=2) {//while creates 2 posts:
    $my_post = array(
    'post_title'=> 'Variation #' . $i . ' of 5 for prdct#'. $new_post_id,
    'post_name' => 'product-' . $new_post_id . '-variation-' . $i,
    'post_status' => 'publish',
    'post_parent' => $new_post_id,//post is a child post of product post
    'post_type' => 'product_variation',//set post type to product_variation
    'guid'=>home_url() . '/?product_variation=product-' . $new_post_id . '-variation-' . $i
    );

    //Insert ea. post/variation into database:
    $attID = wp_insert_post( $my_post );

    //set IDs for product_variation posts:
    $variation_id = $new_post_id + 1;
    $variation_two = $variation_id + 1;

    //Create 2xl variation for ea product_variation:
    update_post_meta($variation_id, 'attribute_pa_brand', 'CONTINENTAL');
    update_post_meta($variation_id, '_price', 21.99);
    update_post_meta($variation_id, '_regular_price', '21.99');
    //add size attributes to this variation:
    wp_set_object_terms($variation_id, $avail_attributes, 'pa_brand');
    $thedata = Array('pa_brand'=>Array(
    'name'=>'CONTINENTAL',
    'value'=>'',
    'is_visible' => '1',
    'is_variation' => '1',
    'is_taxonomy' => '1'
    ));
    update_post_meta( $variation_id,'_product_attributes',$thedata);

    //Create xl variation for ea product_variation:
    update_post_meta( $variation_two, 'attribute_pa_brand', 'pirelli');
    update_post_meta( $variation_two, '_price', 20.99 );
    update_post_meta( $variation_two, '_regular_price', '20.99');
    //add size attributes:
    wp_set_object_terms($variation_two, $avail_attributes, 'pa_brand');
    $thedata = Array('pa_brand'=>Array(
    'name'=>'pirelli',
    'value'=>'',
    'is_visible' => '1',
    'is_variation' => '1',
    'is_taxonomy' => '1'
    ));
    update_post_meta( $variation_two,'_product_attributes',$thedata);

	$i++;
	}//end while i is less than or equal to 5(for 5 size variations)

    echo 'done?!?!'; die();
}

function get_available_quantities($product){
	$quantities = array();
	foreach ($product['Quantity'] as $quantity){
		$quantities[] = $quantity['SiteName'];
	}
	return $quantities;
}

function set_product_junk_meta($post_id, $product){
	//update_post_meta( $post_id, '_visibility', 'visible' );
	//update_post_meta( $post_id, '_stock_status', 'instock');
	update_post_meta( $post_id, '_regular_price', $product['Tyre_Price'] );
	update_post_meta( $post_id, '_sale_price', $product['Tyre_Price'] );
	update_post_meta( $post_id, '_price', $product['Tyre_Price'] );
	update_post_meta( $post_id, '_featured', "no" );
	update_post_meta( $post_id, '_weight', "" );
	update_post_meta( $post_id, '_length', "" );
	update_post_meta( $post_id, '_width', "" );
	update_post_meta( $post_id, '_height', "" );
	update_post_meta($post_id, '_sku', $product['StockCode'] . '-'. sanitize_title($product['TyreDesc']));
	update_post_meta( $post_id, '_product_attributes', array());
	//update_post_meta( $post_id, '_manage_stock', "no" );

	if ($product['Tyre_Price']){
		update_post_meta( $post_id, '_visibility', 'visible' );
	} else {
		update_post_meta( $post_id, '_visibility', 'hidden' );
	}
	//update_post_meta( $post_id, '_stock', "" );
}
function set_product_category($product, $post_id){
	if (stristr($product['TyreDesc'], 'batter')){
		$category = 'Batteries';
	} else {
		$category = "Tyres";
	}
	$term = term_exists($category, 'product_cat');
	wp_set_object_terms($post_id, $category, 'product_cat');
}

function get_java_tyres($limit){
	global $wpdb;
	$query = "SELECT * FROM Tyres WHERE processed = 0 ORDER BY TyreID DESC LIMIT $limit";
	$results = $wpdb->get_results($query, 'ARRAY_A');
	foreach ($results as $key => $value){

		$results[$key]['Tyre_Price'] = get_tyre_price($value['TyreID']);
		$results[$key]['Quantity'] = get_tyre_quantity($value['TyreID']);

		/** 
		bellow is to avoid importing batteries
		*/
		if (stristr($results[$key]['TyreDesc'], 'batter')) {
			unset($results[$key]);
		}
		
		/*
		$results[$key]['Manufacturer_title'] = get_attribute_name(
			$value,
			"Manufacturers",
			"ManufacturerID",
			"ManufacturerName"
		);*/

	}
	return $results;
}

function get_tyre_quantity($tyre_id){
	global $wpdb;

	$query = "SELECT SiteID, Qty FROM Quantity WHERE TyreID = $tyre_id";
	$results = $wpdb->get_results($query, 'ARRAY_A');
	if ($results){
		foreach ($results as $key => $value){
			$query = "SELECT SiteName FROM Sites WHERE SiteID = " . $value['SiteID'] . " LIMIT 1";
			$res = $wpdb->get_results($query, 'ARRAY_A');
			if ($res){
				$results[$key]['SiteName'] = trim($res[0]['SiteName']);
			} 
		}
	}
	return $results;
}

function get_tyre_price($tyre_id){
	global $wpdb;
	$ret = NULL;

	$query = "SELECT Cost FROM Prices WHERE TyreID = $tyre_id";
	$results = $wpdb->get_results($query, 'ARRAY_A');
	if ($results){
		$ret = trim($results[0]['Cost']);
		if ($ret <= 20) $ret = $ret + 10;
		else if ($ret <= 29) $ret = $ret + 16;
		else if ($ret <= 40) $ret = $ret + 19;
		else if ($ret <= 60) $ret = $ret + 20;
		else if ($ret <= 80) $ret = $ret + 22;
		else $ret = $ret + 25;
	}
	return $ret;
}

function get_attribute_name($value, $table, $index, $field){
	global $wpdb;
	$ret = NULL;
	$query = "SELECT $field FROM $table WHERE $index = " . $value[$index];
	$results = $wpdb->get_results($query, 'ARRAY_A');
	if ($results){
		$ret = trim($results[0][$field]);
	}
	return $ret;
}
function pr($s){
	echo "<pre>";
	var_dump($s);
	echo "</pre>";
}

$time_end = microtime(true);
$duration = ($time_end - $time_start);
$hours = (int)($duration/60/60);
$minutes = (int)($duration/60)-$hours*60;
$seconds = (int)$duration-$hours*60*60-$minutes*60;

echo 'Total Execution Time: '.$hours.':'.$minutes.':'.$seconds;

function send_email($subject, $body){
	$email = 'daniel.oraca@gmail.com';
	$headers = 'From: no-reply <no-reply@tyreworks.co.uk>' . "\r\n";
	ob_start();

	
	echo $body;
	
	$message = ob_get_contents();
	ob_end_clean();
	$x = wp_mail($email, $subject, $message, $headers);
	//var_dump($x);die();
}