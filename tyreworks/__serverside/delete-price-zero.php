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
send_email('starting the massive delete price 0 via cron', $current_date);

$orderby = 'title';
$order = 'desc';
$per_page = '100000';

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
		'key' => '_regular_price',
		'value' => array('0', '10'),
		'compare' => 'IN'
		)
	)
); 

ob_start();

$products = new WP_Query( $args );


$x=0;
foreach ($products->posts as $post){
	wp_delete_post( $post->ID, true );
}

echo $x;
wp_reset_postdata();

send_email('ending the massive delete price 0 via cron', '...');

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