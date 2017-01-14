<?php
//custom post type - weekdays
function timetable_weekdays_init()
{
	$labels = array(
		'name' => _x('Timetable columns', 'post type general name', 'timetable'),
		'singular_name' => _x('Timetable Column', 'post type singular name', 'timetable'),
		'add_new' => _x('Add New', 'timetable_weekdays', 'timetable'),
		'add_new_item' => __('Add New Timetable Column', 'timetable'),
		'edit_item' => __('Edit Timetable Column', 'timetable'),
		'new_item' => __('New Timetable Column', 'timetable'),
		'all_items' => __('All Timetable Columns', 'timetable'),
		'view_item' => __('View Timetable Column', 'timetable'),
		'search_items' => __('Search Timetable Columns', 'timetable'),
		'not_found' =>  __('No timetable columns found', 'timetable'),
		'not_found_in_trash' => __('No timetable columns found in Trash', 'timetable'), 
		'parent_item_colon' => '',
		'menu_name' => __("Timetable columns", 'timetable')
	);
	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",  
		"menu_position" => 20,
		"hierarchical" => false,  
		"rewrite" => true,  
		"supports" => array("title", "page-attributes")
	);
	register_post_type("timetable_weekdays", $args);
}  
add_action("init", "timetable_weekdays_init"); 

//custom weekdays items list
function timetable_weekdays_edit_columns($columns)
{
	$columns = array(  
		"cb" => "<input type=\"checkbox\" />",  
		"title" => _x('Day name', 'post type singular name', 'timetable'),   
		"date" => __('Date', 'timetable')
	);    

	return $columns;  
}  
add_filter("manage_edit-timetable_weekdays_columns", "timetable_weekdays_edit_columns");
?>