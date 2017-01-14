<?php
$start = microtime(true);

ini_set("max_execution_time",0);
ini_set('memory_limit', '-1');
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once '../wp-config.php';

global $wpdb;
	$query = "UPDATE `Tyres` SET `processed` = '0' WHERE 1=1 ";

	$wpdb->query($query);