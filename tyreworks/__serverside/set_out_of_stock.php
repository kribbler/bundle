<?php
$info = getdate();
$date = $info['mday'];
$month = $info['mon'];
$year = $info['year'];
$hour = $info['hours'];
$min = $info['minutes'];
$sec = $info['seconds'];

ini_set("max_execution_time",0);
ini_set('memory_limit', '-1');
include_once '../wp-config.php';

$current_date = "$date/$month/$year == $hour:$min:$sec";
send_email('starting out of stock via cron', $current_date);

$orderby = 'title';
$order = 'asc';
$per_page = '100000';
global $product;










$ordering_args = $woocommerce->query->get_catalog_ordering_args( $orderby, $order );

	$args = array(
	'post_type'	=> 'product',
	'post_status' => 'publish',
	'ignore_sticky_posts'	=> 1,
	'orderby' => $ordering_args['orderby'],
	'order' => $ordering_args['order'],
	'posts_per_page' => $per_page,
	
	'meta_query' => array(
		array(
		'key' => '_stock_status',
		'value' => array('instock'),
		'compare' => 'IN'
		)
	)
); 

ob_start();

$products = new WP_Query( $args );


$x=0;
foreach ($products->posts as $post){
	$_pf = new WC_Product_Factory();  
	$product = $_pf->get_product($post->ID);
	
	$args = array(
		'post_type'     => 'product_variation',
		'post_status'   => array( 'private', 'publish' ),
		'numberposts'   => -1,
		'orderby'       => 'menu_order',
		'order'         => 'asc',
		'post_parent'   => $product->id // $post->ID 
	);
	$variations = get_posts( $args ); 
	//echo "<pre>"; print_r($variations); echo "</pre>"; 

	$outofstock = 0;
	foreach ($variations as $key => $value) {
		$stock = get_post_meta( $value->ID, '_stock', true );
		if ($stock == 0) $outofstock ++;
	}

	if ($outofstock == 2) {
		$x = update_metadata('post', $product->id, '_stock_status', 'outofstock');
	}
}

echo $x;
wp_reset_postdata();

send_email('ending out of stock via cron', '...');

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