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
send_email('starting the massive delete via cron', $current_date);
//var_dump($current_date);die();

$orderby = 'title';
$order = 'desc';
$per_page = '100000';

$attribute = 'brand';
//$values = 'bike-torque-racing,bk-racing-wheels,black-eagle,blackstar,bosal,boss-wheels,breyton,bsa,bu,bwa-wheels,c-p-k,cgs-tyres-uk-ltd,competition-logistics-ltd,compomotive-wheels,dare-wheels,delta,demount-wheels,dezent-wheels,direct-remoulds,dorset-autospares,dotz-wheels,dymag-wheels,eltex-wheels,emr-wheels,eurocar-parts,europa,excel-wheels,excite-wheels,fondmetal-wheels,fox-wheels,fullrun,hatco-limited,hi-octane-wheels,hofmann,hoosier,itdn-re-charge,kevin-cooper-motor-factors,kirkby,league,lenso-wheels,lucas-sre,mangels-wheels,marshal,matrix-wheels,maxxis,mbd-group-limited,mille-miglia,misc,miscellaneous,monarch,motorparts-direct,motorwpi-remoulds,mvk-wheels,oe-wheels,overfinch-wheels,oz-racing,partco,pioneer,r-h-claydon,radius-wheels,remould,replica,rial-wheels,riken,rimini-wheels,rimstock-alloy-wheels,roadhog,roadhouse-wheels,rondel-wheels,rosava,scorpion,sime,smith-wheels,southern,sportiva,starco-gb-ltd,steel-wheels,technic,tms-ltd,trax,trident,tsw,tuberex,uk-parts-alliance,unidentified-stock,unipart,valbrem,viking,volkswagon-group-uk-limited,waw-wheels,wolfrace';
$values = 'unknown';

$ordering_args = $woocommerce->query->get_catalog_ordering_args( $orderby, $order );

	$args = array(
	'post_type'	=> 'product',
	'post_status' => 'publish',
	'ignore_sticky_posts'	=> 1,
	'orderby' => $ordering_args['orderby'],
	'order' => $ordering_args['order'],
	'posts_per_page' => $per_page,
	
	'tax_query' => array(
		array(
		'taxonomy' => 'pa_' . $attribute,
		'terms' => explode(",",$values),
		'field' => 'slug',
		'operator' => 'IN'
		)
	)
); 

ob_start();

$products = new WP_Query( $args );
echo count($products); 
foreach ($products->posts as $post){
	wp_delete_post( $post->ID, true );
}
wp_reset_postdata();
send_email('ending the massive delete via cron', '...');
die('done deleting ' . count($products->posts));

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