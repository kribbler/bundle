<?php

ini_set("max_execution_time",0);
ini_set('memory_limit', '-1');
include_once '../wp-config.php';

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
	$x++;
}

echo $x;
wp_reset_postdata();