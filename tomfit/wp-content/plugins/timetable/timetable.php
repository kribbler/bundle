<?php
/*
Plugin Name: Timetable Responsive Schedule For WordPress
Plugin URI: http://codecanyon.net/item/timetable-responsive-schedule-for-wordpress/7010836?ref=QuanticaLabs
Description: Timetable Responsive Schedule For WordPress is a powerful and easy-to-use schedule plugin for WordPress. It will help you to create a timetable view of your events in minutes. It is perfect for gym classes, school or kindergarten classes, medical departments, nightclubs, lesson plans, meal plans etc. It comes with Events Manager, Event Occurrences Shortcode, Timetable Shortcode Generator and Upcoming Events Widget.
Author: QuanticaLabs
Author URI: http://codecanyon.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs
Version: 2.6
*/

//translation
function timetable_load_textdomain()
{
	load_plugin_textdomain("timetable", false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'timetable_load_textdomain');
require_once("post-type-weekdays.php");
require_once("post-type-events.php");
require_once("widget-upcoming-events.php");
require_once("shortcodes.php");
//Template fallback
add_action("template_redirect", 'my_theme_redirect');

if(function_exists("register_sidebar"))
{
	register_sidebar(array(
		"id" => "sidebar-event",
		"name" => "Sidebar Event",
		'before_widget' => '<div id="%1$s" class="widget %2$s timetable_sidebar_box timetable_clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h5 class="box_header">',
		'after_title' => '</h5>'
	));
}

function my_theme_redirect() {
    global $wp;
    $plugindir = dirname( __FILE__ );

    //A Specific Custom Post Type
    if (isset($wp->query_vars["post_type"]) && $wp->query_vars["post_type"] == 'events') {
        $templatefilename = 'event-template.php';
        if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
            $return_template = TEMPLATEPATH . '/' . $templatefilename;
        } else {
            $return_template = $plugindir . '/' . $templatefilename;
        }
        do_theme_redirect($return_template);

    //A Custom Taxonomy Page
    }
}

function do_theme_redirect($url) {
    global $post, $wp_query;
    if (have_posts()) {
        include($url);
        die();
    } else {
        $wp_query->is_404 = true;
    }
}

//register event post thumbnail
add_theme_support("post-thumbnails");
add_image_size("event-post-thumb", 630, 300, true);
add_image_size("event-post-thumb-box", 300, 240, true);
function timetable_image_sizes($sizes)
{
	global $themename;
	$addsizes = array(
		"event-post-thumb" => __("Event post thumbnail", 'timetable'),
		"event-post-thumb-box" => __("Event post box thumbnail", 'timetable')
	);
	$newsizes = array_merge($sizes, $addsizes);
	return $newsizes;
}
add_filter("image_size_names_choose", "timetable_image_sizes");

//documentation link
function timetable_documentation_link($links) 
{ 
  $documentation_link = '<a href="' . plugins_url('documentation/index.html', __FILE__) . '" title="Documentation">Documentation</a>'; 
  array_unshift($links, $documentation_link); 
  return $links;
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'timetable_documentation_link');

//settings link
function timetable_settings_link($links) 
{ 
  $settings_link = '<a href="options-general.php?page=timetable_admin" title="Settings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links;
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'timetable_settings_link');

function timetable_enqueue_scripts()
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script("jquery-ba-bqq", plugins_url('js/jquery.ba-bbq.min.js', __FILE__), array("jquery"), false, true);
	wp_enqueue_script("jquery-carouFredSel", plugins_url('js/jquery.carouFredSel-6.2.1-packed.js', __FILE__), array("jquery"), false, true);
	wp_enqueue_script('timetable_main', plugins_url('js/timetable.js', __FILE__));
	wp_enqueue_style('timetable_sf_style', plugins_url('style/superfish.css', __FILE__));
	wp_enqueue_style('timetable_style', plugins_url('style/style.css', __FILE__));
	wp_enqueue_style('timetable_event_template', plugins_url('style/event_template.css', __FILE__));
	wp_enqueue_style('timetable_responsive_style', plugins_url('style/responsive.css', __FILE__));
	wp_enqueue_style('timetable_font_lato', 'http://fonts.googleapis.com/css?family=Lato:400,700');
}
add_action('wp_enqueue_scripts', 'timetable_enqueue_scripts');

//admin
if(is_admin())
{
	function timetable_admin_menu()
	{	
		$page = add_options_page('Timetable', 'Timetable', 'manage_options', 'timetable_admin', 'timetable_admin_page');
		add_action("admin_print_scripts-post-new.php", "timetable_admin_print_scripts");
		add_action("admin_print_scripts-post.php", "timetable_admin_print_scripts");
		add_action("admin_print_scripts-settings_page_timetable_admin", "timetable_admin_print_scripts");
		add_action("admin_print_scripts-widgets.php", "timetable_admin_print_scripts");
		add_action("admin_print_scripts", "timetable_admin_print_scripts_all");
	}
	add_action('admin_menu', 'timetable_admin_menu');

	function timetable_admin_init()
	{
		wp_register_script('timetable-colorpicker', plugins_url('admin/js/colorpicker.js', __FILE__));
		wp_register_script('timetable-zclip', plugins_url('admin/js/ZeroClipboard.min.js', __FILE__), array("jquery"));
		wp_register_script('timetable-admin', plugins_url('admin/js/timetable_admin.js', __FILE__), array("jquery", "timetable-zclip"));
		wp_register_style('timetable-colorpicker', plugins_url('admin/style/colorpicker.css', __FILE__));
		wp_register_style('timetable-admin', plugins_url('admin/style/style.css', __FILE__));
	}
	add_action('admin_init', 'timetable_admin_init');

	function timetable_admin_print_scripts()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('timetable-colorpicker');
		wp_enqueue_script('timetable-zclip');
		wp_enqueue_script('timetable-admin');
		wp_enqueue_style('timetable-colorpicker');
		$data = array(
			'img_url' => plugins_url("admin/images/", __FILE__),
			'js_url' => plugins_url("admin/js/", __FILE__)
		);
		//pass data to javascript
		$params = array(
			'l10n_print_after' => 'config = ' . json_encode($data) . ';'
		);
		wp_localize_script("timetable-admin", "config", $params);
	}
	
	function timetable_admin_print_scripts_all()
	{
		wp_enqueue_style('timetable-admin');
	}
	
	function timetable_ajax_get_font_subsets()
	{
		if($_POST["font"]!="")
		{
			$subsets = '';
			$fontExplode = explode(":", $_POST["font"]);
			//get google fonts
			$google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyB4_VClnbxilxqjZd7NbysoHwAXX1ZGdKQ';
			$fontsJson = wp_remote_retrieve_body(wp_remote_get($google_api_url, array('sslverify' => false )));
			$fontsArray = json_decode($fontsJson);
			$fontsCount = count($fontsArray->items);
			for($i=0; $i<$fontsCount; $i++)
			{
				if($fontsArray->items[$i]->family==$fontExplode[0])
				{
					for($j=0; $j<count($fontsArray->items[$i]->subsets); $j++)
					{
						$subsets .= '<option value="' . $fontsArray->items[$i]->subsets[$j] . '">' . $fontsArray->items[$i]->subsets[$j] . '</option>';
					}
					break;
				}
			}
			echo "timetable_start" . $subsets . "timetable_end";
		}
		exit();
	}
	add_action('wp_ajax_timetable_get_font_subsets', 'timetable_ajax_get_font_subsets');
	
	//add new mimes for upload dummy content files (code can be removed after dummy content import)
	function tt_custom_upload_files($mimes) 
	{
		$mimes = array_merge($mimes, array('xml' => 'application/xml'), array('json' => 'application/json'));
		return $mimes;
	}
	add_filter('upload_mimes', 'tt_custom_upload_files');
	
	function get_new_widget_name( $widget_name, $widget_index ) 
	{
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array( );
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;
		return $new_widget_name;
	}
	
	function tt_download_import_file($file)
	{	
		$url = "http://quanticalabs.com/wp_plugins/timetable/files/2014/02/" . $file["name"] . "." . $file["extension"];
		$attachment = get_page_by_title($file["name"], "OBJECT", "attachment");
		if($attachment!=null)
			$id = $attachment->ID;
		else
		{
			$tmp = download_url($url);
			$file_array = array(
				'name' => basename($url),
				'tmp_name' => $tmp
			);

			// Check for download errors
			if(is_wp_error($tmp)) 
			{
				@unlink($file_array['tmp_name']);
				return $tmp;
			}

			$id = media_handle_sideload($file_array, 0);
			// Check for handle sideload errors.
			if(is_wp_error($id))
			{
				@unlink($file_array['tmp_name']);
				return $id;
			}
		}
		return get_attached_file($id);
	}
	
	function timetable_import_dummy()
	{
		$result = array("info" => "");
		//import dummy content
		$fetch_attachments = true;
		$file = tt_download_import_file(array(
			"name" => "dummy-timetable",
			"extension" => "xml"
		));
		if(!is_wp_error($file))
			require_once 'importer/importer.php';
		else
		{
			$result["info"] .= __("Import file: dummy-timetable.xml not found! Please upload import file manually into Media library. You can find this file inside zip archive downloaded from CodeCanyon.", 'timetable');
			exit();
		}
		//widget import
		$response = array(
			'what' => 'widget_import_export',
			'action' => 'import_submit'
		);

		$widgets = isset( $_POST['widgets'] ) ? $_POST['widgets'] : false;
		$json_file = tt_download_import_file(array(
			"name" => "widget_data",
			"extension" => "json"
		));
		if(!is_wp_error($json_file))
		{
			$json_data = file_get_contents($json_file);
			$json_data = json_decode( $json_data, true );
			$sidebars_data = $json_data[0];
			$widget_data = $json_data[1];
			$current_sidebars = get_option( 'sidebars_widgets' );
			//remove inactive widgets
			$current_sidebars['wp_inactive_widgets'] = array();
			update_option('sidebars_widgets', $current_sidebars);
			$new_widgets = array( );
			foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

				foreach ( $import_widgets as $import_widget ) :
					//if the sidebar exists
					//if ( isset( $current_sidebars[$import_sidebar] ) ) :
						$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
						$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
						$current_widget_data = get_option( 'widget_' . $title );
						$new_widget_name = get_new_widget_name( $title, $index );
						$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

						if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
							while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
								$new_index++;
							}
						}
						$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
						if ( array_key_exists( $title, $new_widgets ) ) {
							$new_widgets[$title][$new_index] = $widget_data[$title][$index];
							$multiwidget = $new_widgets[$title]['_multiwidget'];
							unset( $new_widgets[$title]['_multiwidget'] );
							$new_widgets[$title]['_multiwidget'] = $multiwidget;
						} else {
							$current_widget_data[$new_index] = $widget_data[$title][$index];
							$current_multiwidget = $current_widget_data['_multiwidget'];
							$new_multiwidget = $widget_data[$title]['_multiwidget'];
							$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
							unset( $current_widget_data['_multiwidget'] );
							$current_widget_data['_multiwidget'] = $multiwidget;
							$new_widgets[$title] = $current_widget_data;
						}

					//endif;
				endforeach;
			endforeach;
			if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
				update_option( 'sidebars_widgets', $current_sidebars );

				foreach ( $new_widgets as $title => $content )
					update_option( 'widget_' . $title, $content );

			}
		}
		else
		{
			$result["info"] .= __("Widgets data file not found! Please upload widgets data file manually.", 'timetable');
			exit();
		}
		//import sample hours
		global $wpdb;
		$query = "INSERT INTO `" . $wpdb->prefix . "event_hours` (`event_hours_id`, `event_id`, `weekday_id`, `start`, `end`, `tooltip`, `before_hour_text`, `after_hour_text`, `category`) VALUES
			(242, 2146, 1217, '11:00:00', '13:00:00', 'Reaction time training with sparring partners.', 'Boxing class', 'Robert Bandana', ''),
			(247, 15, 1214, '15:00:00', '15:45:00', '', 'High impact', 'Mark Moreau', ''),
			(238, 2148, 1217, '17:00:00', '18:30:00', '', 'Advanced', 'Kevin Nomak', ''),
			(222, 2148, 1218, '15:00:00', '16:00:00', '', 'Beginners', 'Kevin Nomak', ''),
			(223, 2148, 1213, '15:00:00', '16:00:00', '', 'Intermediate', 'Kevin Nomak', ''),
			(244, 2144, 1217, '15:00:00', '16:00:00', 'Basic exercises for kids.', 'Preschool class', 'Emma Brown', ''),
			(183, 15, 2132, '16:00:00', '17:00:00', '', 'Low impact', 'Mark Moreau', ''),
			(184, 15, 1213, '16:00:00', '17:00:00', '', 'High impact', 'Trevor Smith', ''),
			(199, 2139, 1216, '07:00:00', '09:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', ''),
			(185, 15, 1214, '16:00:00', '17:00:00', '', 'Low impact', 'Mark Moreau', ''),
			(228, 2142, 1218, '13:00:00', '15:00:00', '', 'Body works', 'Kevin Nomak', ''),
			(239, 2148, 2132, '15:00:00', '16:00:00', 'Advanced stamina workout.', 'Advanced', 'Kevin Nomak', ''),
			(205, 2139, 1213, '07:00:00', '11:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', ''),
			(163, 2146, 1216, '14:00:00', '15:00:00', '', 'Thai boxing', 'Robert Bandana', ''),
			(156, 2146, 1213, '11:00:00', '13:00:00', '', 'MMA beginners', 'Robert Bandana', ''),
			(243, 2144, 1216, '15:00:00', '16:00:00', 'Basic exercises for kids.', 'Preschool class', 'Emma Brown', ''),
			(162, 2146, 1215, '14:00:00', '15:00:00', '', 'Thai boxing', 'Robert Bandana', ''),
			(190, 2142, 1213, '18:00:00', '19:30:00', '', 'Weightlifting', 'Kevin Nomak', ''),
			(141, 2144, 1216, '17:00:00', '18:30:00', '', 'Fitness and fun', 'Emma Brown', ''),
			(139, 2144, 1214, '17:00:00', '18:30:00', '', 'Zumba dance', 'Emma Brown', ''),
			(144, 2144, 1217, '17:00:00', '18:30:00', '', 'Fitness and fun', 'Emma Brown', ''),
			(164, 2148, 1214, '07:00:00', '09:00:00', '', 'Weightlifting', 'Kevin Nomak', ''),
			(193, 2148, 1215, '17:00:00', '18:30:00', '', 'Beginners', 'Kevin Nomak', ''),
			(231, 15, 1217, '16:00:00', '17:00:00', '', 'High impact', 'Trevor Smith', ''),
			(152, 2146, 1213, '13:00:00', '14:00:00', '', 'MMA all levels', 'Robert Bandana', ''),
			(153, 2146, 1217, '13:00:00', '14:00:00', '', 'MMA all levels', 'Robert Bandana', ''),
			(157, 2146, 2132, '11:00:00', '13:00:00', '', 'Boxing class', 'Robert Bandana', ''),
			(214, 2148, 1217, '14:00:00', '15:00:00', '', 'Weightlifting', 'Kevin Nomak', ''),
			(204, 2139, 2132, '07:00:00', '11:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', ''),
			(189, 2142, 2132, '18:00:00', '19:30:00', '', 'Weightlifting', 'Kevin Nomak', ''),
			(175, 2144, 1215, '17:00:00', '18:30:00', '', 'Advanced', 'Emma Brown', ''),
			(229, 2139, 1218, '07:00:00', '11:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', ''),
			(221, 2139, 1215, '07:00:00', '12:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', ''),
			(227, 2142, 1218, '11:00:00', '13:00:00', '', 'Weightlifting', 'Kevin Nomak', ''),
			(232, 2144, 1213, '08:00:00', '09:00:00', '', 'Advanced', 'Emma Brown', ''),
			(191, 2142, 1215, '12:30:00', '14:00:00', '', 'Weightlifting', 'Kevin Nomak', ''),
			(192, 2142, 1216, '12:30:00', '14:00:00', '', 'Weightlifting', 'Kevin Nomak', ''),
			(207, 2144, 1214, '11:00:00', '13:00:00', '', 'Beginners', 'Emma Brown', ''),
			(210, 2144, 2132, '08:00:00', '09:00:00', '', 'Beginners', 'Emma Brown', ''),
			(246, 2148, 1214, '13:00:00', '15:00:00', '', 'Beginners', 'Kevin Nomak', ''),
			(230, 2146, 1218, '16:00:00', '17:00:00', '', 'Thai boxing', 'Robert Bandana', ''),
			(315, 2159, 2132, '11:00:00', '12:45:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Beginner', ''),
			(329, 2164, 1214, '09:00:00', '10:30:00', 'Mixed Martial Arts training with Muay Thai and Thai Boxing.', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> Beginner', ''),
			(313, 2164, 2132, '09:00:00', '10:30:00', '', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> Beginner', ''),
			(331, 2177, 1215, '14:00:00', '17:00:00', 'Super stamina workout and weightlifting.', '', '<strong>Instructor:</strong> K. Nomak<br/>\r\n<strong>Room:</strong> 305A<br/>\r\n<strong>Level:</strong> All Levels', ''),
			(319, 2159, 1215, '11:00:00', '12:45:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Beginner', ''),
			(493, 2244, 2229, '16:00:00', '18:22:00', '', 'Horror', 'Free Entry<br/>\r\n142 min.', ''),
			(330, 2159, 1214, '11:00:00', '14:00:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Advanced', ''),
			(314, 2164, 1213, '11:00:00', '12:45:00', '', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> Intermediate', ''),
			(459, 2298, 2230, '12:30:00', '14:00:00', '', 'Catering', 'Free Entry<br/>\r\n90 min.', ''),
			(327, 2164, 1217, '09:00:00', '12:45:00', 'Mixed Martial Arts training with Muay Thai and Thai Boxing.', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> All Levels', ''),
			(473, 2243, 2227, '16:30:00', '17:56:00', '', 'Animation', 'Free Entry<br/>\r\n86 min.', ''),
			(323, 2177, 1217, '14:00:00', '18:00:00', '', '', '<strong>Instructor:</strong> K. Nomak<br/>\r\n<strong>Room:</strong> 305A<br/>\r\n<strong>Level:</strong> All Levels', ''),
			(325, 2164, 1215, '09:00:00', '10:30:00', '', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> Beginner', ''),
			(301, 2177, 1213, '13:00:00', '14:00:00', '', '', '<strong>Instructor:</strong> K. Nomak<br/>\r\n<strong>Room:</strong> 305A<br/>\r\n<strong>Level:</strong> All Levels', ''),
			(300, 2177, 2132, '13:00:00', '14:00:00', '', '', '<strong>Instructor:</strong> K. Nomak<br/>\r\n<strong>Room:</strong> 305A<br/>\r\n<strong>Level:</strong> All Levels', ''),
			(309, 2159, 2132, '15:00:00', '16:30:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Advanced', ''),
			(332, 2191, 1213, '09:00:00', '09:45:00', '', '', 'Class Leader<br/>Ann Smith', ''),
			(333, 2191, 1214, '10:00:00', '10:45:00', '', '', 'Class Leader<br/>Emma White', ''),
			(324, 2159, 1217, '13:00:00', '14:00:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> All Levels', ''),
			(310, 2159, 1213, '15:00:00', '16:30:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Advanced', ''),
			(417, 2242, 2229, '14:40:00', '16:30:00', '', 'Animation', 'G Rating<br/>\r\n110 min.', ''),
			(433, 2264, 2229, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', ''),
			(492, 2244, 2227, '14:00:00', '16:22:00', '', 'Horror', 'Free Entry<br/>\r\n142 min.', ''),
			(488, 2266, 2227, '09:00:00', '12:30:00', '', 'Concert', '$60 Entry<br/>\r\n210 min.<br/><br/>\r\nUnder 16''s to be accompanied by an adult.', ''),
			(467, 2239, 2231, '14:00:00', '16:15:00', '', 'Adventure', '$10 Entry<br/>\r\n135 min.', ''),
			(560, 2353, 2343, '11:30:00', '12:45:00', '', '', 'Performance', ''),
			(434, 2264, 2231, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', ''),
			(466, 2236, 2230, '14:00:00', '16:10:00', '', 'Thriller', 'Free Entry<br/>\r\n130 min.', ''),
			(460, 2298, 2231, '12:30:00', '14:00:00', '', 'Catering', 'Free Entry<br/>\r\n90 min.', ''),
			(479, 2310, 2231, '16:30:00', '18:30:00', '', 'Thriller', '$20 Entry<br/>\r\n120 min.', ''),
			(474, 2238, 2231, '09:00:00', '10:45:00', '', 'Action', 'Free Entry<br/>\r\n105 min.', ''),
			(458, 2298, 2229, '12:30:00', '14:00:00', '', 'Catering', 'Free Entry<br/>\r\n90 min.', ''),
			(435, 2264, 2232, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', ''),
			(477, 2245, 2232, '16:30:00', '17:56:00', '', 'Horror', '$10 Entry<br/>\r\n86 min.', ''),
			(438, 2264, 2227, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', ''),
			(471, 2243, 2231, '11:00:00', '12:26:00', '', 'Animation', 'Free Entry<br/>\r\n86 min.', ''),
			(448, 2234, 2230, '11:00:00', '12:25:00', '', 'Animation', 'Free Entry<br/>\r\n85 min.', ''),
			(496, 2237, 2229, '18:30:00', '20:10:00', '', 'Action', 'Free Entry<br/>\r\n100 min.', ''),
			(461, 2298, 2227, '12:30:00', '14:00:00', '', 'Catering', 'Free Entry<br/>\r\n90 min.', ''),
			(490, 2235, 2230, '09:00:00', '10:42:00', '', 'Comedy', 'Free Entry<br/>\r\n102 min.', ''),
			(436, 2264, 2230, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', ''),
			(476, 2245, 2232, '11:00:00', '12:26:00', '', 'Horror', '$10 Entry<br/>\r\n86 min.', ''),
			(485, 2241, 2232, '12:30:00', '16:30:00', '', 'Concert', '$50 ticket<br/>\r\n240 min.<br/><br/>\r\nWith special guest Kevin Numan and Markus Smith.', ''),
			(491, 2235, 2229, '14:00:00', '15:42:00', '', 'Comedy', 'Free Entry<br/>\r\n102 min.', ''),
			(486, 2240, 2229, '09:00:00', '12:10:00', '', 'Concert', '$50 ticket<br/>\r\n190 min.<br/><br/>\r\nWith special guest Kevin Numan and Markus Smith.', ''),
			(489, 2266, 2230, '16:30:00', '20:00:00', '', 'Concert', '$60 Entry<br/>\r\n210 min.<br/><br/>\r\nUnder 16''s to be accompanied by an adult.', ''),
			(495, 2237, 2232, '09:00:00', '10:40:00', '', 'Action', 'Free Entry<br/>\r\n100 min.', ''),
			(573, 2365, 2342, '09:00:00', '12:00:00', '', '', 'Registration and General Information', ''),
			(561, 2350, 2343, '12:45:00', '14:00:00', '', '', 'Performance', ''),
			(581, 2375, 2342, '16:30:00', '19:00:00', '', '', 'Conference Banquet With Closing Ceremony. John Williams Speech.', ''),
			(570, 2351, 2343, '15:30:00', '16:45:00', '', '', 'Performance', ''),
			(519, 2359, 2346, '12:00:00', '13:15:00', '', '', 'Screening', ''),
			(536, 2367, 2344, '12:00:00', '15:00:00', '', '', 'Display', ''),
			(537, 2366, 2344, '15:00:00', '17:30:00', '', '', 'Display', ''),
			(526, 2362, 2346, '10:00:00', '12:00:00', '', '', 'Screening', ''),
			(558, 2355, 2343, '09:00:00', '10:15:00', '', '', 'Performance', ''),
			(520, 2361, 2346, '13:15:00', '14:40:00', '', '', 'Screening', ''),
			(554, 2357, 2345, '13:30:00', '14:15:00', '', '', 'Panel with Josh Kowalsky', ''),
			(535, 2368, 2344, '09:00:00', '12:00:00', '', '', 'Display', ''),
			(556, 2374, 2342, '08:30:00', '09:00:00', '', '', '', ''),
			(564, 2363, 2345, '09:00:00', '10:15:00', '', '', 'Panel with Ann Perkins', ''),
			(572, 2352, 2346, '15:30:00', '17:15:00', '', '', 'Performance', ''),
			(566, 2358, 2345, '11:30:00', '13:30:00', '', '', 'Panel with Robin Watson, Chris Prochaska and Shawn Georges', ''),
			(562, 2364, 2347, '09:00:00', '12:30:00', '', '', 'Free Entry', ''),
			(551, 2373, 2347, '12:30:00', '16:30:00', '', '', 'Luch Menu', ''),
			(567, 2356, 2345, '14:15:00', '16:15:00', '', '', 'Panel with Helena Howington, Frank Kasper and John Williams ', ''),
			(559, 2354, 2343, '10:15:00', '11:30:00', '', '', 'Performance', ''),
			(565, 2360, 2345, '10:15:00', '11:30:00', '', '', 'Panel with Robin Landrum', ''),
			(576, 2365, 2342, '13:30:00', '15:00:00', '', '', 'Registration and General Information', ''),
			(588, 2367, 2344, '14:30:00', '15:00:00', '', 'Comments', 'Comments on Display Session', ''),
			(589, 2366, 2344, '17:00:00', '17:30:00', '', 'Comments', 'Comments on Display Session', ''),
			(587, 2368, 2344, '11:30:00', '12:00:00', '', 'Comments', 'Comments on Display Session', '');";
		$wpdb->query($query);
		
		if($result["info"]=="")
			$result["info"] = __("dummy-timetable.xml file content and widgets settings has been imported successfully!", 'timetable');
		echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
		exit();
	}
	add_action('wp_ajax_timetable_import_dummy', 'timetable_import_dummy');
	
	function timetable_admin_page()
	{
		//get events list
		$events_list = get_posts(array(
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_type' => 'events'
		));
		
		//get weekdays list
		$weekdays_list = get_posts(array(
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_type' => 'timetable_weekdays'
		));
		
		//get all hour categories
		global $wpdb;
		$query = "SELECT distinct(category) AS category FROM " . $wpdb->prefix . "event_hours AS t1
				LEFT JOIN {$wpdb->posts} AS t2 ON t1.event_id=t2.ID 
				WHERE 
				t2.post_type='events'
				AND t2.post_status='publish'
				AND category<>''";
		$hour_categories = $wpdb->get_results($query);
		//events string
		$events_string = "";
		$events_select_list = "";
		foreach($events_list as $event)
		{
			$events_select_list .= '<option value="' . urldecode($event->post_name) . '">' . $event->post_title . ' (id: ' . $event->ID . ')' . '</option>';
			$events_string .= $event->post_name . (end($events_list)!=$event ? "," : "");
		}
		//events categories string
		$events_categories_list = "";
		$events_categories = get_terms("events_category");
		foreach($events_categories as $events_category)
			$events_categories_list .= '<option value="' . urldecode(esc_attr($events_category->slug)) . '">' . $events_category->name . '</option>';
		//weekdays string
		$weekdays_string = "";
		$weekdays_select_list = "";
		foreach($weekdays_list as $weekday)
		{
			$weekdays_select_list .= '<option value="' . urldecode($weekday->post_name) . '">' . $weekday->post_title . ' (id: ' . $weekday->ID . ')' . '</option>';
			$weekdays_string .= $weekday->post_name . (end($weekdays_list)!=$weekday ? "," : "");
		}
		//get google fonts
		$google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyB4_VClnbxilxqjZd7NbysoHwAXX1ZGdKQ';
		$fontsJson = @wp_remote_retrieve_body(wp_remote_get($google_api_url, array('sslverify' => false )));
		$fontsArray = json_decode($fontsJson);

		//$fontsJson = file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyB4_VClnbxilxqjZd7NbysoHwAXX1ZGdKQ');
		//$fontsArray = json_decode($fontsJson);
		$fontsHtml = "";
		$fontsCount = count($fontsArray->items);
		for($i=0; $i<$fontsCount; $i++)
		{
			$variantsCount = count($fontsArray->items[$i]->variants);
			if($variantsCount>1)
			{
				for($j=0; $j<$variantsCount; $j++)
				{
					$fontsHtml .= '<option value="' . $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] . '">' . $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] . '</option>';
				}
			}
			else
			{
				$fontsHtml .= '<option value="' . $fontsArray->items[$i]->family . '">' . $fontsArray->items[$i]->family . '</option>';
			}
		}
		?>
		<div class="wrap">
			<h2><?php _e("Timetable Dummy Content", "timetable"); ?></h2>
		</div>
		<div>
			<input type="button" class="button" name="timetable_import_dummy" id="import_dummy" value="<?php _e('Import dummy content', 'timetable'); ?>" />
			<span class="spinner" style="float: none; margin-top: 4px;"></span>
			<img id="dummy_content_tick" src="<?php echo WP_PLUGIN_URL; ?>/timetable/admin/images/tick.png" />
			<div id="dummy_content_info"></div>
		</div>
		<div class="wrap">
			<h2><?php _e("Timetable Shortcode Generator", "timetable"); ?></h2>
		</div>
		<div class="timetable_shortcode_container">
			<input style="width: 630px;" type="text" class="regular-text tt_shortcode" value="[tt_timetable]" data-default="[tt_timetable]" name="shortcode">
			<a href="#" id="copy_to_clipboard1" class="button-primary"><?php _e("Copy to Clipboard", "timetable"); ?></a>
			<span class="copy_info"><?php _e("Shortcode has been copied to clipboard!", 'timetable'); ?></span>
		</div>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="timetable_settings">
			<div id="timetable_configuration_tabs">
				<ul class="nav-tabs">
					<li class="nav-tab">
						<a href="#tab-main">
							<?php _e('Main configuration', 'timetable'); ?>
						</a>
					</li>
					<li class="nav-tab">
						<a href="#tab-colors">
							<?php _e('Colors', 'timetable'); ?>
						</a>
					</li>
					<li class="nav-tab">
						<a href="#tab-fonts">
							<?php _e('Fonts', 'timetable'); ?>
						</a>
					</li>
					<li class="nav-tab">
						<a href="#tab-custom-css">
							<?php _e('Custom CSS', 'timetable'); ?>
						</a>
					</li>
				</ul>
				<div id="tab-main">
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label for="event">
										<?php _e("Events", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="event" id="event" multiple="multiple">
										<?php echo $events_select_list; ?>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Select the events that are to be displayed in timetable. Hold the CTRL key to select multiple items.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="event">
										<?php _e("Event categories", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="event_category" id="event_category" multiple="multiple">
										<?php echo $events_categories_list ?>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Select the events categories that are to be displayed in timetable. Hold the CTRL key to select multiple items.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="hour_category">
										<?php _e("Hour categories", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="hour_category" id="hour_category" multiple="multiple">
										<?php
										foreach($hour_categories as $hour_category)
											echo '<option value="' . $hour_category->category . '">' . $hour_category->category . '</option>';
										?>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Select the hour categories (if defined for existing event hours) for events that are to be displayed in timetable. Hold the CTRL key to select multiple items.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="weekdays">
										<?php _e("Columns", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="weekday" id="weekday" multiple="multiple">
										<?php echo $weekdays_select_list; ?>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Select the columns that are to be displayed in timetable. Hold the CTRL key to select multiple items.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="measure">
										<?php _e("Hour measure", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="measure" id="measure">
										<option value="1"><?php _e("Hour (1h)", "timetable"); ?></option>
										<option value="0.5"><?php _e("Half hour (30min)", "timetable"); ?></option>
										<option value="0.25"><?php _e("Quarter hour (15min)", "timetable"); ?></option>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Choose hour measure for event hours.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="filter_style">
										<?php _e("Filter style", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="filter_style" id="filter_style">
										<option value="dropdown_list"><?php _e("Dropdown list", "timetable"); ?></option>
										<option value="tabs"><?php _e("Tabs", "timetable"); ?></option>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Choose between dropdown menu and tabs for event filtering.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="filter_kind">
										<?php _e("Filter kind", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="filter_kind" id="filter_kind">
										<option value="event"><?php _e("By event", "timetable"); ?></option>
										<option value="event_category"><?php _e("By event category", "timetable"); ?></option>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Choose between filtering by events or events categories.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="filter_label">
										<?php _e("Filter label", "timetable"); ?>
									</label>
								</th>
								<td>
									<input type="text" class="regular-text" value="All Events" id="filter_label" name="filter_label">
								</td>
								<td>
									<span class="description"><?php _e("Specify text label for all events.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="time_format">
										<?php _e("Time format", "timetable"); ?>
									</label>
								</th>
								<td>
									<fieldset>
										<legend class="screen-reader-text"><span><?php _e("Time format", "timetable"); ?></span></legend>
										<label title="H.i">
											<input type="radio" checked="checked" value="H.i" name="time_format"> 
											<span>09.03</span>
										</label>
										<br>
										<label title="H:i">
											<input type="radio" value="H:i" name="time_format"> 
											<span>09:03</span>
										</label>
										<br>
										<label title="g:i a">
											<input type="radio" value="g:i a" name="time_format"> 
											<span>9:03 am</span>
										</label>
										<br>
										<label title="g:i A">
											<input type="radio" value="g:i A" name="time_format"> 
											<span>9:03 AM</span>
										</label>
										<br>
										<label>
											<input type="radio" value="custom" id="time_format_custom_radio" name="time_format"> 
											<?php _e("Custom: ", "timetable"); ?>
										</label>
										<input type="text" class="small-text" value="H.i" name="time_format_custom" id="time_format"> 
										<span class="example"> 9:03 am</span> 
										<span class="spinner"></span>
									</fieldset>
								</td>
								<td></td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="hide_hours_column">
										<?php _e("Hide first (hours) column", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="hide_hours_column" id="hide_hours_column">
										<option value="0"><?php _e("No", "timetable"); ?></option>
										<option value="1"><?php _e("Yes", "timetable"); ?></option>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Set to Yes to hide timetable column with hours.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="show_end_hour">
										<?php _e("Show end hour in first (hours) column", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="show_end_hour" id="show_end_hour">
										<option value="0"><?php _e("No", "timetable"); ?></option>
										<option value="1"><?php _e("Yes", "timetable"); ?></option>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Set to Yes to show both start and end hour in timetable column with hours.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="event_layout">
										<?php _e("Event block layout", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="event_layout" id="event_layout">
										<option value="1"><?php _e("Type 1", "timetable"); ?></option>
										<option value="2"><?php _e("Type 2", "timetable"); ?></option>
										<option value="3"><?php _e("Type 3", "timetable"); ?></option>
										<option value="4"><?php _e("Type 4", "timetable"); ?></option>
										<option value="5"><?php _e("Type 5", "timetable"); ?></option>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Select one of the available event block layouts.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="hide_empty">
										<?php _e("Hide empty rows", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="hide_empty" id="hide_empty">
										<option value="0"><?php _e("No", "timetable"); ?></option>
										<option value="1"><?php _e("Yes", "timetable"); ?></option>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Set to Yes to hide timetable rows without events.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="disable_event_url">
										<?php _e("Disable event url", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="disable_event_url" id="disable_event_url">
										<option value="0"><?php _e("No", "timetable"); ?></option>
										<option value="1"><?php _e("Yes", "timetable"); ?></option>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Set to Yes for nonclickable event blocks.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="text_align">
										<?php _e("Text align", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="text_align" id="text_align">
										<option value="center"><?php _e("center", "timetable"); ?></option>
										<option value="left"><?php _e("left", "timetable"); ?></option>
										<option value="right"><?php _e("right", "timetable"); ?></option>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Specify text align in timetable event block.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="row_height">
										<?php _e("Id", "timetable"); ?>
									</label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="id" name="id">
								</td>
								<td>
									<span class="description"><?php _e("Assign a unique identifier to a timetable if you use more than one table on a single page. Otherwise, leave this field blank.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="row_height">
										<?php _e("Row height (in px)", "timetable"); ?>
									</label>
								</th>
								<td>
									<input type="text" class="regular-text" value="31" id="row_height" name="row_height">
								</td>
								<td>
									<span class="description"><?php _e("Specify timetable row height in pixels.", 'timetable'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="responsive">
										<?php _e("Responsive", "timetable"); ?>
									</label>
								</th>
								<td>
									<select name="responsive" id="responsive">
										<option value="1"><?php _e("Yes", "timetable"); ?></option>
										<option value="0"><?php _e("No", "timetable"); ?></option>
									</select>
								</td>
								<td>
									<span class="description"><?php _e("Set to Yes to adjust timetable to mobile devices.", 'timetable'); ?></span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="tab-colors">
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row">
									<label for="box_bg_color">
										<?php _e('Timetable box background color', 'timetable'); ?>
									</label>
								</th>
								<td>
									<span class="color_preview" style="background-color: #00A27C"></span>
									<input class="regular-text color" type="text" id="box_bg_color" name="box_bg_color" value="00A27C" data-default-color="00A27C" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="box_hover_bg_color">
										<?php _e('Timetable box hover background color', 'timetable'); ?>
									</label>
								</th>
								<td>
									<span class="color_preview" style="background-color: #1F736A"></span>
									<input class="regular-text color" type="text" id="box_hover_bg_color" name="box_hover_bg_color" value="1F736A" data-default-color="1F736A" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="box_txt_color">
										<?php _e('Timetable box text color', 'timetable'); ?>
									</label>
								</th>
								<td>
									<span class="color_preview" style="background-color: #FFFFFF"></span>
									<input class="regular-text color" type="text" id="box_txt_color" name="box_txt_color" value="FFFFFF" data-default-color="FFFFFF" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="box_hover_txt_color">
										<?php _e('Timetable box hover text color', 'timetable'); ?>
									</label>
								</th>
								<td>
									<span class="color_preview" style="background-color: #FFFFFF"></span>
									<input class="regular-text color" type="text" id="box_hover_txt_color" name="box_hover_txt_color" value="FFFFFF" data-default-color="FFFFFF" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="box_hours_txt_color">
										<?php _e('Timetable box hours text color', 'timetable'); ?>
									</label>
								</th>
								<td>
									<span class="color_preview" style="background-color: #FFFFFF"></span>
									<input class="regular-text color" type="text" id="box_hours_txt_color" name="box_hours_txt_color" value="FFFFFF" data-default-color="FFFFFF" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="box_hours_hover_txt_color">
										<?php _e('Timetable box hours hover text color', 'timetable'); ?>
									</label>
								</th>
								<td>
									<span class="color_preview" style="background-color: #FFFFFF"></span>
									<input class="regular-text color" type="text" id="box_hours_hover_txt_color" name="box_hours_hover_txt_color" value="FFFFFF" data-default-color="FFFFFF" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="filter_color">
										<?php _e('Filter control background color', 'timetable'); ?>
									</label>
								</th>
								<td>
									<span class="color_preview" style="background-color: #00A27C"></span>
									<input class="regular-text color" type="text" id="filter_color" name="filter_color" value="00A27C" data-default-color="00A27C" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="row1_color">
										<?php _e('Row 1 style background color', 'timetable'); ?>
									</label>
								</th>
								<td>
									<span class="color_preview" style="background-color: #F0F0F0"></span>
									<input class="regular-text color" type="text" id="row1_color" name="row1_color" value="F0F0F0" data-default-color="F0F0F0" />
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="row2_color">
										<?php _e('Row 2 style background color', 'timetable'); ?>
									</label>
								</th>
								<td>
									<span class="color_preview" style="background-color: transparent"></span>
									<input class="regular-text color" type="text" id="row2_color" name="row2_color" value="" data-default-color="transparent" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="tab-fonts">
					<table class="form-table">
						<tbody>
							<!--<tr valign="top">
								<th scope="row" class="header_row" colspan="2">
									<label>
										<?php _e("Table header font", 'timetable'); ?>
									</label>
								</th>
							</tr>-->
							<tr valign="top">
								<th scope="row">
									<label for="timetable_font_custom"><?php _e("Enter font name", 'timetable'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="timetable_font_custom" name="timetable_font_custom">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="timetable_font"><?php _e("or choose Google font", 'timetable'); ?></label>
								</th>
								<td>
									<select name="timetable_font" id="timetable_font" class="google_font_chooser">
										<option value=""><?php _e("Default", 'timetable'); ?></option>
										<?php
											echo $fontsHtml;
										?>
									</select>
									<span class="spinner"></span>
								</td>
							</tr>
							<tr valign="top" class="fontSubsetRow">
								<th scope="row">
									<label for="timetable_font_subset"><?php _e("Google font subset", 'timetable'); ?></label>
								</th>
								<td>
									<select name="timetable_font_subset[]" id="timetable_font_subset" class="fontSubset" multiple="multiple"></select>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="timetable_font_size"><?php _e("Font size (in px)", 'timetable'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="timetable_font_size" name="timetable_font_size">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="tab-custom-css">
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label for="timetable_custom_css"><?php _e("Custom CSS", 'timetable'); ?></label>
								</th>
								<td>
									<textarea id="timetable_custom_css" name="timetable_custom_css" style="width: 540px; height: 200px;"></textarea>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</form>
		<div class="timetable_shortcode_container">
			<input style="width: 630px;" type="text" class="regular-text tt_shortcode" value="[tt_timetable]" data-default="[tt_timetable]" name="shortcode">
			<a href="#" id="copy_to_clipboard2" class="button-primary"><?php _e("Copy to Clipboard", "timetable"); ?></a>
			<span class="copy_info"><?php _e("Shortcode has been copied to clipboard!", 'timetable'); ?></span>
		</div>
		<?php
	}
}

//timetable
function tt_timetable($atts, $content)
{
	extract(shortcode_atts(array(
		"event" => "",
		"event_category" => "",
		"events_page" => "",
		"filter_style" => "dropdown_list",
		"filter_kind" => "event",
		"measure" => 1,
		"filter_label" => "All Events",
		"hour_category" => "",
		"columns" => "",
		"time_format" => "H.i",
		"hide_hours_column" => 0,
		"show_end_hour" => 0,
		"event_layout" => 1,
		"box_bg_color" => "00A27C",
		"box_hover_bg_color" => "1F736A",
		"box_txt_color" => "FFFFFF",
		"box_hover_txt_color" => "FFFFFF",
		"box_hours_txt_color" => "FFFFFF",
		"box_hours_hover_txt_color" => "FFFFFF",
		"filter_color" => "00A27C",
		"row1_color" => "F0F0F0",
		"row2_color" => "",
		"hide_empty" => 0,
		"disable_event_url" => 0,
		"text_align" => "center",
		"row_height" => 31,
		"id" => "",
		"responsive" => 1,
		"font_custom" => "",
		"font" => "",
		"font_subset" => "",
		"font_size" => "",
		"custom_css" => ""
	), $atts));

	$events_array = array_values(array_diff(array_filter(array_map('trim', explode(",", $event))), array("-")));
	$event_category_array = array_values(array_diff(array_filter(array_map('trim', explode(",", $event_category))), array("-")));
	if(count($event_category_array))
	{
		//events array ids
		$events_array_id = array();
		for($i=0; $i<count($events_array); $i++)
		{
			$event = get_posts(array(
			  'name' => $events_array[$i],
			  'post_type' => 'events',
			  'post_status' => 'publish',
			  'numberposts' => 1
			));
			$events_array_id[] = $event[0]->ID;
		}
		$events_array_cat = get_posts(array(
			'include' => $events_array_id,
			'post_type' => 'events',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'events_category' => implode(",", $event_category_array)
		));
		$events_array = array();
		for($i=0; $i<count($events_array_cat); $i++)
			$events_array[] = $events_array_cat[$i]->post_name;
	}
	$events_list_html = '<li><a href="#all-events' . ($id!='' ? '-' . $id : '') . '" title="' . esc_attr($filter_label) . '">' . $filter_label . '</a></li>';
	if($filter_kind=="event" || !count($event_category_array))
	{
		$events_array_count = count($events_array);
		for($i=0; $i<$events_array_count; $i++)
		{
			query_posts(array(
				"name" => $events_array[$i],
				'post_type' => 'events',
				'post_status' => 'publish'
			));
			if(have_posts())
			{
				the_post();
				$events_list_html .= '<li><a href="#' . $events_array[$i] . '" title="' . esc_attr(get_the_title()) . '">' . get_the_title() . '</a></li>';
			}
		}
	}
	else
	{
		$events_category_array_count = count($event_category_array);
		for($i=0; $i<$events_category_array_count; $i++)
		{
			$category = get_term_by("slug", $event_category_array[$i], "events_category");
			$events_list_html .= '<li><a href="#' . $event_category_array[$i] . '" title="' . esc_attr($category->name) . '">' . $category->name . '</a></li>';
		}
	}
	$output = '';
	if($filter_style=="dropdown_list")
	{
		$output .= '<ul class="timetable_clearfix tabs_box_navigation' . ((int)$responsive ? " tt_responsive" : "") . ' sf-timetable-menu' . ($id!="" ? ' ' . $id : '') . '">
			<li class="tabs_box_navigation_selected"><label>' . $filter_label . '</label><span class="tabs_box_navigation_icon"></span><ul class="sub-menu">' . $events_list_html . '</ul></li>
		</ul>';
	}
	if((int)$row_height!=31 || strtoupper($box_bg_color)!="00A27C" || strtoupper($filter_color)!="00A27C" || $custom_css!="")
	{
		$output .= '<style type="text/css">' . $custom_css . ((int)$row_height!=31 ? ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable td{height: ' . (int)$row_height . (substr($row_height, -2)!="px" ? 'px' : '') . ';}' : '') . (strtoupper($box_bg_color)!="00A27C" ? ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable .event{background: #' . $box_bg_color . ';}' : '') . (strtoupper($filter_color)!="00A27C" ? ($id!="" ? '#' . $id : '') . ' .tt_tabs_navigation li a:hover,' . ($id!="" ? '#' . $id : '') . ' .tt_tabs_navigation li a.selected,' . ($id!="" ? '#' . $id : '') . ' .tt_tabs_navigation li.ui-tabs-active a{border-color:#' . $filter_color . ' !important;}' . ($id!="" ? '.' . $id : '') . '.tabs_box_navigation.sf-timetable-menu .tabs_box_navigation_selected{background-color:#' . $filter_color . ';border-color:#' . $filter_color . ';}' . ($id!="" ? '.' . $id : '') . '.tabs_box_navigation.sf-timetable-menu .tabs_box_navigation_selected:hover{background-color: #FFF; border: 1px solid rgba(0, 0, 0, 0.1);}' . ($id!="" ? '.' . $id : '') . '.sf-timetable-menu li ul li a:hover, .sf-timetable-menu li ul li.selected a:hover{background-color:#' . $filter_color . ';}' : '') . '</style>';
	}
	if($font!="")
			$output .= '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' . $font . '&subset=' . $font_subset . '">';
	if($font_custom!="" || $font!="" || (int)$font_size>0)
	{
		$font_explode = explode(":", $font);
			$font = '"' . $font_explode[0] . '"';
		$output .= '<style type="text/css">' . ($font_custom!="" || $font!="" ? ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable{font-family:' . ($font_custom!="" ? $font_custom : $font) . ' !important;}' : '') . ((int)$font_size>0 ? ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable th,' . ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable td,' . ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable .event .before_hour_text,' . ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable .event .after_hour_text,' . ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable .event .event_header{font-size:' . (int)$font_size . 'px !important;}' : '') . '</style>';
	}
	$output .= '<div class="timetable_clearfix tt_tabs' . ((int)$responsive ? " tt_responsive" : "") . " event_layout_" . $event_layout . '"' . ($id!="" ? ' id="' . $id . '"' : '') . '>
		<ul class="timetable_clearfix tt_tabs_navigation"' . ($filter_style=="dropdown_list" ? ' style="display: none;"' : '') . '>' . $events_list_html . '</ul>';
	$output .= '<div id="all-events' . ($id!='' ? '-' . $id : '') . '">' . tt_get_timetable($atts, $events_array) . '</div>';
	
	if($filter_kind=="event" || !count($event_category_array))
	{
		for($i=0; $i<$events_array_count; $i++)
			$output .= '<div id="' . $events_array[$i] . '" class="tt-ui-tabs-hide">' . tt_get_timetable($atts, $events_array[$i]) . '</div>';
	}
	else
	{
		for($i=0; $i<$events_category_array_count; $i++)
		{
			$events_array = array();
			$events_array = get_posts(array(
				'include' => (array)$events_array_id,
				'post_type' => 'events',
				'post_status' => 'publish',
				'events_category' => $event_category_array[$i],
				'posts_per_page' => -1,
			));
			$events_array_for_timetable = array();
			for($j=0; $j<count($events_array); $j++)
				$events_array_for_timetable[] = $events_array[$j]->post_name;
			$output .= '<div id="' . $event_category_array[$i] . '" class="tt-ui-tabs-hide">' . (count($events_array) ? tt_get_timetable($atts, $events_array_for_timetable) : __('No events available in ' . $event_category_array[$i] . ' category!', 'timetable')) . '</div>';
		}
	}
	$output .= '</div>';
	
	//Reset Query
	wp_reset_query();
	return $output;
}
add_shortcode("tt_timetable", "tt_timetable");

function to_decimal_time($time, $midReplace = false)
{
	$timeExplode = explode(".", $time);
	return ($midReplace && (int)$timeExplode[0]==0 ? 24 : $timeExplode[0]) . "." . (isset($timeExplode[1]) && (int)$timeExplode[1]>0 ? ceil($timeExplode[1]/60*100) : "00");
}
function tt_hour_in_array($hour, $array, $measure, $hours_min)
{
	$array_count = count($array);
	for($i=0; $i<$array_count; $i++)
	{
		if((int)$measure==1)
		{
			if((!isset($array[$i]["displayed"]) || (bool)$array[$i]["displayed"]!=true) && (int)$array[$i]["start"]==(int)$hour)
				return true;
		}
		else
		{
			if((!isset($array[$i]["displayed"]) || (bool)$array[$i]["displayed"]!=true) && to_decimal_time(roundMin($array[$i]["start"], $measure, $hours_min))==(double)$hour)
				return true;
		}
	}
	return false;
}
/*function get_next_row_hour($hour, $measure, $next = 1)
{
	$hourExplode = explode(".", $hour);
	if((int)$hourExplode[1]>0)
	{
		if((int)$hourExplode[1]+$measure*100>=100)
		{
			$hour = (int)$hourExplode[0]+1;
			//if($hour==24)
				//$hour = 0;
			if((int)$hourExplode[1]+$measure*100==100 || !$next)
				$minutes = "00";
			else
				$minutes = $measure*100;
		}
		else
		{
			if(fmod((int)$hourExplode[1],(double)$measure*100)==0)
				$minutes = (int)$hourExplode[1];
			else
				for($i=0; $i<100; $i=$i+$measure*100)
				{
					if((int)$hourExplode[1]<$i)
					{
						$minutes = $i;
						break;
					}
				}
			$hour = (int)$hourExplode[0];
			if($next)
				$minutes = $minutes+$measure*100;
			if($minutes>100-$measure*100)
			{
				$hour = $hour+1;
				if($minutes==100 || !$next)
					$minutes = "00";
				else
					$minutes = $measure*100;
			}
		}
	}
	else
	{
		$hour = (int)$hourExplode[0];
		if($next)
			$minutes = $measure*100;
		else
			$minutes = (int)$hourExplode[1];
	}
	return $hour . "." . $minutes;
}*/
function get_next_row_hour($hour, $measure)
{
	$hourExplode = explode(".", $hour);
	if((int)$hourExplode[1]>0)
	{
		if((int)$hourExplode[1]+$measure*100>100)
		{
			$hour = (int)$hourExplode[0]+1;
			if($hour==24)
				$hour = 0;
			$minutes = "00";
		}
		else if(fmod((int)$hourExplode[1],(double)$measure*100)!=0)
		{
			for($i=0; $i<100; $i=$i+$measure*100)
			{
				if((int)$hourExplode[1]<$i)
				{
					$minutes = $i;
					break;
				}
			}
			$hour = (int)$hourExplode[0];
		}
		else
		{
			$hour = (int)$hourExplode[0];
			$minutes = (int)$hourExplode[1];
		}
	}
	else
	{
		$hour = (int)$hourExplode[0];
		$minutes = (int)$hourExplode[1];
	}
	if($hour . "." . $minutes == "0.00")
		return "24.00";
	return $hour . "." . $minutes;
}
function tt_get_rowspan_value($hour, $array, $rowspan, $measure, $hours_min)
{
	$array_count = count($array);
	$found = false;
	$hours = array();
	if((int)$measure==1)
	{
		for($i=(int)$hour; $i<(int)$hour+$rowspan; $i++)
			$hours[] = $i;
		for($i=0; $i<$array_count; $i++)
		{
			if(in_array((int)$array[$i]["start"], $hours))
			{
				$end_explode = explode(".", $array[$i]["end"]);
				$end_hour = (int)$array[$i]["end"] + ((int)$end_explode[1]>0 ? 1 : 0);
				if($end_hour-(int)$hour>1 && $end_hour-(int)$hour>$rowspan)
				{
					$rowspan = $end_hour-(int)$hour;
					$found = true;
				}
			}
		}
	}
	else
	{
		for($i=(double)$hour; $i<(double)$hour+$rowspan*$measure; $i=$i+$measure)
			$hours[] = $i;
		for($i=0; $i<$array_count; $i++)
		{
			if(in_array(to_decimal_time(roundMin($array[$i]["start"], $measure, $hours_min)), $hours))
			{
				$end_hour = to_decimal_time($array[$i]["end"], true);
				//$end_hour = ($end_hour<24 ? get_next_row_hour($end_hour, $measure) : $end_hour);
				$end_hour = get_next_row_hour($end_hour, $measure);
				if($end_hour-(double)$hour>$measure && ($end_hour-(double)$hour)/$measure>$rowspan)
				{
					$rowspan = ($end_hour-(double)$hour)/$measure;
					$found = true;
				}
			}
		}
	}
	if(!$found)
		return $rowspan;
	else
		return tt_get_rowspan_value($hour, $array, $rowspan, $measure, $hours_min);
}
function tt_get_row_content($events, $events_page, $time_format, $event_layout, $global_colors, $disable_event_url)
{
	$content = "";
	
	foreach($events as $key=>$details)
	{
		$color = "";
		$hover_color = "";
		$textcolor = "";
		$hover_text_color = "";
		$hours_text_color = "";
		$hours_count = count($details["hours"]);
		if(count($events)>1 || (count($events)==1 && $hours_count>1))
		{
			$color = get_post_meta($details["id"], "timetable_color", true);
			$hover_color = get_post_meta($details["id"], "timetable_hover_color", true);
			if($color=="" && strtoupper($global_colors["box_bg_color"])!="00A27C")
				$color = $global_colors["box_bg_color"];
			if($hover_color=="" && strtoupper($global_colors["box_hover_bg_color"])!="1F736A")
				$hover_color = $global_colors["box_hover_bg_color"];
		}
		$text_color = get_post_meta($details["id"], "timetable_text_color", true);
		if($text_color=="" && strtoupper($global_colors["box_txt_color"])!="FFFFFF")
			$text_color = $global_colors["box_txt_color"];
		$hover_text_color = get_post_meta($details["id"], "timetable_hover_text_color", true);
		if($hover_text_color=="" && strtoupper($global_colors["box_hover_txt_color"])!="FFFFFF")
		{
			$hover_text_color = $global_colors["box_hover_txt_color"];
			if($text_color=="")
				$text_color = "FFFFFF";
		}
		$hours_text_color = get_post_meta($details["id"], "timetable_hours_text_color", true);
		if($hours_text_color=="" && strtoupper($global_colors["box_hours_txt_color"])!="FFFFFF")
			$hours_text_color = $global_colors["box_hours_txt_color"];
		$hours_hover_text_color = get_post_meta($details["id"], "timetable_hours_hover_text_color", true);
		if($hours_hover_text_color=="" && (strtoupper($global_colors["box_hours_hover_txt_color"])!="FFFFFF" || $hours_text_color!=""))
		{
			$hours_hover_text_color = $global_colors["box_hours_hover_txt_color"];
			if($hours_text_color=="")
				$hours_text_color = "FFFFFF";
		}
		$timetable_custom_url = get_post_meta($details["id"], "timetable_custom_url", true);
		$classes_url = "";
		if(!(int)get_post_meta($details["id"], "timetable_disable_url", true) && !(int)$disable_event_url)
			$classes_url = ($timetable_custom_url!="" ? $timetable_custom_url : get_permalink($details["id"]));
		
		$class_link = '<' . ($classes_url!="" ? 'a' : 'span') . ' class="event_header"' . ($classes_url!="" ? ' href="' . $classes_url /*. '#' . urldecode($details["name"])*/ . '"' : '') . ' title="' .  esc_attr($details["title"]) . '"' . ($text_color!="" ? ' style="color: #' . $text_color . ' !important;"' : '') . '>' . $details["title"] . '</' . ($classes_url!="" ? 'a' : 'span') . '>';
				
		for($i=0; $i<$hours_count; $i++)
		{
			$tooltip = "";
			$content .= '<div class="event_container id-' . $details["id"] . (count(array_filter(array_values($details['tooltip']))) && (count($events)>1 || (count($events)==1 && $hours_count>1)) ? ' tt_tooltip' : '' ) . '"' . ($color!="" || ($text_color!="" && (count($events)>1 || (count($events)==1 && $hours_count>1))) ? ' style="' . ($color!="" ? 'background-color: #' . $color . ';' : '') . ($text_color!="" && (count($events)>1 || (count($events)==1 && $hours_count>1)) ? 'color: #' . $text_color . ';' : '') . '"': '') . (($hover_color!="" || $hover_text_color!="" || $hours_hover_text_color!="") && (count($events)>1 || (count($events)==1 && $hours_count>1)) ? ' onMouseOver="' . ($hover_color!="" ? 'this.style.background=\'#'.$hover_color.'\';' : '') . ($hover_text_color!="" ? 'this.style.color=\'#'.$hover_text_color.'\';jQuery(this).find(\'.event_header\').css(\'cssText\', \'color: #'.$hover_text_color.' !important\');' : '') . ($hours_hover_text_color!="" ? 'jQuery(this).find(\'.hours\').css(\'color\',\'#'.$hours_hover_text_color.'\');' : '') . '" onMouseOut="' . ($hover_color!="" ? 'this.style.background=\'#'.$color.'\';' : '') . ($hover_text_color!="" ? 'this.style.color=\'#'.$text_color.'\';jQuery(this).find(\'.event_header\').css(\'cssText\',\'color: #'.$text_color.' !important\');' : '') . ($hours_hover_text_color!="" ? 'jQuery(this).find(\'.hours\').css(\'color\',\'#'.$hours_text_color.'\');' : '') . '"' : '') . '>';
			$hoursExplode = explode(" - ", $details["hours"][$i]);
			$startHour = date($time_format, strtotime($hoursExplode[0]));
			$endHour = date($time_format, strtotime($hoursExplode[1]));
			
			$description1_content = "";
			if($details["before_hour_text"][$i]!="")
				$description1_content = "<div class='before_hour_text'>" . do_shortcode($details["before_hour_text"][$i]) . "</div>";
			$description2_content = "";
			if($details["after_hour_text"][$i]!="")
				$description2_content = "<div class='after_hour_text'>" . do_shortcode($details["after_hour_text"][$i]) . "</div>";
			$top_hour_content = '<div class="top_hour"><span class="hours"' . ($hours_text_color!="" ? ' style="color:#' . $hours_text_color . ';"' : '') . '>' . $startHour . '</span></div>';
			$bottom_hour_content = '<div class="bottom_hour"><span class="hours"' . ($hours_text_color!="" ? ' style="color:#' . $hours_text_color . ';"' : '') . '>' . $endHour . '</span></div>';
			$hours_content = '<div class="hours_container"><span class="hours"' . ($hours_text_color!="" ? ' style="color:#' . $hours_text_color . ';"' : '') . '>' . $startHour . ' - ' . $endHour . '</span></div>';
			$class_link_tooltip = '<a' . ($hover_text_color!="" ? ' style="color: #' . $hover_text_color . ';"': '') . ' href="' . $classes_url /*. '#' . urldecode($details["name"])*/ . '" title="' .  esc_attr($details["title"]) . '">' . $details["title"] . '</a>';
			$tooltip = ($details["tooltip"][$i]!="" ? $class_link_tooltip : '') . $details["tooltip"][$i];
			
			if((int)$event_layout==1)
			{
				$content .= $class_link;
				$content .= $description1_content;
				$content .= $top_hour_content;
				$content .= $bottom_hour_content;
				$content .= $description2_content;
			}
			else if((int)$event_layout==2)
			{
				$content .= $top_hour_content;
				$content .= $bottom_hour_content;
				$content .= $description1_content;
				$content .= $class_link;
				$content .= $description2_content;
			}
			else if((int)$event_layout==3)
			{
				$content .= $class_link;
				$content .= $description1_content;
				$content .= $hours_content;
				$content .= $description2_content;
			}
			else if((int)$event_layout==4)
			{
				$content .= $class_link;
				$content .= $description1_content;
				$content .= $top_hour_content;
				$content .= $description2_content;
			}
			else if((int)$event_layout==5)
			{
				$content .= $class_link;
				$content .= $description1_content;
				$content .= $description2_content;
			}
			if(count($events)==1 && $hours_count==1)
				$content .= '</div>';
			if($tooltip!="")
			{
				$hover_color = get_post_meta($details["id"], "timetable_hover_color", true);
				if($hover_color=="" && strtoupper($global_colors["box_hover_bg_color"])!="1F736A")
					$hover_color = $global_colors["box_hover_bg_color"];
				$content .= '<div class="tt_tooltip_text"><div class="tt_tooltip_content"' . ($hover_color!="" || $hover_text_color!="" ? ' style="' . ($hover_color!="" ? 'background-color: #' . $hover_color . ';' : '') . ($hover_text_color!="" ? 'color: #' . $hover_text_color . ';' : '') . '"': '') . '>' . $tooltip . '</div><div class="tt_tooltip_arrow"' . ($hover_color!="" ? ' style="border-color: #' . $hover_color . ' transparent;"' : '') . '></div></div>';	
			}
			if(count($events)>1 || (count($events)==1 && $hours_count>1))
				$content .= '</div>' . (end($events)!=$details || (end($events)==$details && $i+1<$hours_count) ? '<hr>' : '');
		}
		
		
		/*$content .= $class_link;
		$hours_count = count($details["hours"]);
		for($i=0; $i<$hours_count; $i++)
		{
			if($time_format!="H.i")
			{
				$hoursExplode = explode(" - ", $details["hours"][$i]);
				$details["hours"][$i] = date($time_format, strtotime($hoursExplode[0])) . " - " . date($time_format, strtotime($hoursExplode[1]));
			}
			$content .= ($i!=0 ? '<br />' : '');
			if($details["before_hour_text"][$i]!="")
				$content .= "<div class='before_hour_text'>" . $details["before_hour_text"][$i] . "</div>";
			$content .= '<span class="hours"' . ($hours_text_color!="" ? ' style="color:#' . $hours_text_color . ';"' : '') . '>' . $details["hours"][$i] . '</span>';
			if($details["after_hour_text"][$i]!="")
				$content .= "<div class='after_hour_text'>" . $details["after_hour_text"][$i] . "</div>";
			$class_link_tooltip = '<a' . ($hover_text_color!="" ? ' style="color: #' . $hover_text_color . ';"': '') . ' href="' . $classes_url . '#' . urldecode($details["name"]) . '" title="' .  esc_attr($key) . '">' . $key . '</a>';
			$tooltip .= ($tooltip!="" && $details["tooltip"][$i]!="" ? '<br /><br />' : '' ) . ($details["tooltip"][$i]!="" ? $class_link_tooltip : '') . $details["tooltip"][$i];
		}*/
		/*if(count($events)==1)
			$content .= '</div>';
		if($tooltip!="")
		{
			$hover_color = get_post_meta($details["id"], "timetable_hover_color", true);
			$content .= '<div class="tooltip_text"><div class="tooltip_content"' . ($hover_color!="" || $hover_text_color!="" ? ' style="' . ($hover_color!="" ? 'background-color: #' . $hover_color . ';' : '') . ($hover_text_color!="" ? 'color: #' . $hover_text_color . ';' : '') . '"': '') . '>' . $tooltip . '</div><span class="tooltip_arrow"' . ($hover_color!="" ? ' style="border-color: #' . $hover_color . ' transparent;"' : '') . '></span></div>';	
		}
		
		if(count($events)>1)
			$content .= '</div>' . (end($events)!=$details ? '<hr>' : '');*/
	}
	return $content;
}
function roundMin($time, $measure, $hours_min)
{
	/*echo "TIME:" . $time . "<br>";
	echo "HOURS_MIN:" . $hours_min . "<br>";
	$roundTo = $measure*60;
	$seconds = date('U', strtotime($time));
	return date("H.i", floor($seconds / ($roundTo * 60)) * ($roundTo * 60));*/
	
	$decimal_time = to_decimal_time($time);
	$found = false;
	while(!$found)
	{
		$hours_min=$hours_min+$measure;
		if($hours_min>$decimal_time)
			$found = true;
	}
	$hours_min = number_format($hours_min-$measure, 2);
	$hours_min_explode = explode(".", $hours_min);
	return str_pad($hours_min_explode[0], 2, '0', STR_PAD_LEFT) . "." . ((int)$hours_min_explode[1]>0 ? (int)$hours_min_explode[1]*60/100 : "00");
}
function tt_get_timetable($atts, $event = null)
{
	extract(shortcode_atts(array(
		"events_page" => "",
		"measure" => 1,
		"filter_style" => "dropdown_list",
		"filter_label" => "All Events",
		"hour_category" => "",
		"columns" => "",
		"time_format" => "H.i",
		"hide_hours_column" => 0,
		"show_end_hour" => 0,
		"event_layout" => 1,
		"box_bg_color" => "00A27C",
		"box_hover_bg_color" => "1F736A",
		"box_txt_color" => "FFFFFF",
		"box_hover_txt_color" => "FFFFFF",
		"box_hours_txt_color" => "FFFFFF",
		"box_hours_hover_txt_color" => "FFFFFF",
		"row1_color" => "F0F0F0",
		"row2_color" => "",
		"hide_empty" => 0,
		"disable_event_url" => 0,
		"text_align" => "center",
		"row_height" => 31,
		"id" => "",
		"responsive" => 1
	), $atts));
	$measure = (double)$measure;
	global $wpdb;
	if($columns!="")
	{
		$weekdays_explode = explode(",", $columns);
		$weekdays_in_query = "";
		foreach($weekdays_explode as $weekday_explode)
			$weekdays_in_query .= "'" . $weekday_explode . "'" . ($weekday_explode!=end($weekdays_explode) ? "," : "");
	}
	if($hour_category!=null && $hour_category!="-")
		$hour_category = array_values(array_diff(array_filter(array_map('trim', explode(",", $hour_category))), array("-")));
	$output = "";
	$query = "SELECT TIME_FORMAT(t1.start, '%H.%i') AS start, TIME_FORMAT(t1.end, '%H.%i') AS end, t1.tooltip AS tooltip, t1.before_hour_text AS before_hour_text, t1.after_hour_text AS after_hour_text, t2.ID AS event_id, t2.post_title AS event_title, t2.post_name AS post_name, t3.post_title, t3.menu_order FROM " . $wpdb->prefix . "event_hours AS t1 
			LEFT JOIN {$wpdb->posts} AS t2 ON t1.event_id=t2.ID 
			LEFT JOIN {$wpdb->posts} AS t3 ON t1.weekday_id=t3.ID 
			WHERE 
			t2.post_type='events'
			AND t2.post_status='publish'";
	if(is_array($event) && count($event))
		$query .= "
			AND t2.post_name IN('" . join("','", $event) . "')";
	else if($event!=null)
		$query .= "
			AND t2.post_name='" . strtolower(urlencode($event)) . "'";
	if($hour_category!=null && $hour_category!="-")
		$query .= "
			AND t1.category IN('" . join("','", $hour_category) . "')";
	$query .= "
			AND 
			t3.post_type='timetable_weekdays'";
	if(isset($weekdays_in_query) && $weekdays_in_query!="")
		$query .= " AND t3.post_name IN(" . $weekdays_in_query . ")";
	//$query .= " ORDER BY FIELD(t3.menu_order,2,3,4,5,6,7,1), t1.start, t1.end";
	$query .= " ORDER BY t3.menu_order, t1.start, t1.end";
	$event_hours = $wpdb->get_results($query);
	$event_hours_tt = array();
	foreach($event_hours as $event_hour)
	{
		//$event_hours_tt[($event_hour->menu_order>1 ? $event_hour->menu_order-1 : 7)][] = array(
		$event_hours_tt[$event_hour->menu_order][] = array(
			"start" => $event_hour->start,
			"end" => $event_hour->end,
			"tooltip" => $event_hour->tooltip,
			"before_hour_text" => $event_hour->before_hour_text,
			"after_hour_text" => $event_hour->after_hour_text,
			"tooltip" => $event_hour->tooltip,
			"id" => $event_hour->event_id,
			"title" => $event_hour->event_title,
			"name" => $event_hour->post_name
		);
	}
	
	$output .= '<table class="tt_timetable">
				<thead>
					<tr class="row_gray"' . ($row1_color!="" ? ' style="background-color: ' . ($row1_color!="transparent" ? '#' : '') . $row1_color . ' !important;"' : '') . '>';
					if(!(int)$hide_hours_column)
						$output .= '<th></th>';
	//get weekdays
	$query = "SELECT post_title, menu_order FROM {$wpdb->posts}
			WHERE 
			post_type='timetable_weekdays'
			AND post_status='publish'";
	if(isset($weekdays_in_query) && $weekdays_in_query!="")
		$query .= " AND post_name IN(" . $weekdays_in_query . ")";
	//$query .= " ORDER BY FIELD(menu_order,2,3,4,5,6,7,1)";
	$query .= " ORDER BY menu_order";
	$weekdays = $wpdb->get_results($query);
	foreach($weekdays as $weekday)
	{
		$output .= '	<th>' . $weekday->post_title . '</th>';
	}
	$output .= '	</tr>
				</thead>
				<tbody>';
	//get min anx max hour
	$query = "SELECT min(TIME_FORMAT(t1.start, '%H.%i')) AS min, max(REPLACE(TIME_FORMAT(t1.end, '%H.%i'), '00.00', '24.00')) AS max FROM " . $wpdb->prefix . "event_hours AS t1
			LEFT JOIN {$wpdb->posts} AS t2 ON t1.event_id=t2.ID 
			LEFT JOIN {$wpdb->posts} AS t3 ON t1.weekday_id=t3.ID 
			WHERE 
			t2.post_type='events'
			AND t2.post_status='publish'";
	if(is_array($event) && count($event))
		$query .= "
			AND t2.post_name IN('" . join("','", $event) . "')";
	else if($event!=null)
		$query .= "
			AND t2.post_name='" . strtolower(urlencode($event)) . "'";
	if($hour_category!=null && $hour_category!="-")
		$query .= "
			AND t1.category IN('" . join("','", $hour_category) . "')";
	$query .= "
			AND 
			t3.post_type='timetable_weekdays'";
	if(isset($weekdays_in_query) && $weekdays_in_query!="")
		$query .= " AND t3.post_name IN(" . $weekdays_in_query . ")";
	$hours = $wpdb->get_row($query);
	$drop_columns = array();
	$l = 0;
	$increment = 1;
	$hours_min = (int)$hours->min;
	if((int)$measure==1)
	{
		$max_explode = explode(".", $hours->max);
		$max_hour = (int)$hours->max + ((int)$max_explode[1]>0 ? 1 : 0);
	}
	else
	{
		$max_hour = $hours->max;
		$max_hour = to_decimal_time($max_hour);
		$max_hour = get_next_row_hour($max_hour, $measure);
		$increment = (double)$measure;
		$hours_min = to_decimal_time(roundMin($hours->min, $measure, to_decimal_time($hours_min)));
	}
	for($i=$hours_min; $i<$max_hour; $i=$i+$increment)
	{
		if((int)$measure==1)
		{
			$start = str_pad($i, 2, '0', STR_PAD_LEFT) . '.00';
			$end = str_replace("24", "00", str_pad($i+1, 2, '0', STR_PAD_LEFT)) . '.00';
		}
		else
		{
			$i = number_format($i, 2);
			$hourIExplode = explode(".", $i);
			$hourI = $hourIExplode[0] . "." . ((int)$hourIExplode[1]>0 ? (int)$hourIExplode[1]*60/100 : "00");
			$start = number_format($i, 2);
			$end = number_format(str_replace("24", "00", $i+$measure), 2);
			$startExplode = explode(".", $start);
			$start = str_pad($startExplode[0], 2, '0', STR_PAD_LEFT) . "." . ((int)$startExplode[1]>0 ? (int)$startExplode[1]*60/100 : "00");
			$endExplode = explode(".", $end);
			$end = str_pad($endExplode[0], 2, '0', STR_PAD_LEFT) . "." . ((int)$endExplode[1]>0 ? (int)$endExplode[1]*60/100 : "00");
		}
		if($time_format!="H.i")
		{
			$start = date($time_format, strtotime($start));
			$end = date($time_format, strtotime($end));
		}
	
	/*$max_explode = explode(".", $hours->max);
	$max_hour = (int)$hours->max + ((int)$max_explode[1]>0 ? 1 : 0);
	for($i=(int)$hours->min; $i<$max_hour; $i++)
	{
		$start = str_pad($i, 2, '0', STR_PAD_LEFT) . '.00';
		$end = str_replace("24", "00", str_pad($i+1, 2, '0', STR_PAD_LEFT)) . '.00';
		if($time_format!="H.i")
		{
			$start = date($time_format, strtotime($start));
			$end = date($time_format, strtotime($end));
		}*/
		
		$row_empty = true;
		$temp_empty_count = 0;
		$row_content = "";
		for($j=0; $j<count($weekdays); $j++)
		{
			//$weekday_fixed_number = ($weekdays[$j]->menu_order>1 ? $weekdays[$j]->menu_order-1 : 7);
			$weekday_fixed_number = $weekdays[$j]->menu_order;
			if(!in_array($weekday_fixed_number, (array)(isset($drop_columns[$i]["columns"]) ? $drop_columns[$i]["columns"] : array())))
			{
				if(tt_hour_in_array($i, (isset($event_hours_tt[$weekday_fixed_number]) ? $event_hours_tt[$weekday_fixed_number] : array()), $measure, $hours_min))
				{
					$rowspan = tt_get_rowspan_value($i, $event_hours_tt[$weekday_fixed_number], 1, $measure, $hours_min);
					if($rowspan>1)
					{
						if((int)$measure==1)
						{
							for($k=1; $k<$rowspan; $k++)
								$drop_columns[$i+$k]["columns"][] = $weekday_fixed_number;	
						}
						else
						{
							for($k=$measure; $k<$rowspan*$measure; $k=$k+$measure)
							{
								$tmp = number_format($i+$k, 2);
								$drop_columns["$tmp"]["columns"][] = $weekday_fixed_number;	
							}
						}
					}
					$array_count = count($event_hours_tt[$weekday_fixed_number]);
					$hours = array();
					if((int)$measure==1)
					{
						for($k=(int)$i; $k<(int)$i+$rowspan; $k++)
							$hours[] = $k;
					}
					else
					{
						for($k=(double)$i; $k<(double)$i+$rowspan*$measure; $k=$k+$measure)
							$hours[] = $k;
					}
					$events = array();
					for($k=0; $k<$array_count; $k++)
					{
						if(((int)$measure==1 && in_array((int)$event_hours_tt[$weekday_fixed_number][$k]["start"], $hours)) || ((int)$measure!=1 && in_array(to_decimal_time(roundMin($event_hours_tt[$weekday_fixed_number][$k]["start"], $measure, $hours_min)), $hours)))
						{
							$events[$event_hours_tt[$weekday_fixed_number][$k]["name"]]["name"] = $event_hours_tt[$weekday_fixed_number][$k]["name"];
							$events[$event_hours_tt[$weekday_fixed_number][$k]["name"]]["title"] = $event_hours_tt[$weekday_fixed_number][$k]["title"];
							$events[$event_hours_tt[$weekday_fixed_number][$k]["name"]]["tooltip"][] = $event_hours_tt[$weekday_fixed_number][$k]["tooltip"];
							$events[$event_hours_tt[$weekday_fixed_number][$k]["name"]]["before_hour_text"][] = $event_hours_tt[$weekday_fixed_number][$k]["before_hour_text"];
							$events[$event_hours_tt[$weekday_fixed_number][$k]["name"]]["after_hour_text"][] = $event_hours_tt[$weekday_fixed_number][$k]["after_hour_text"];
							$events[$event_hours_tt[$weekday_fixed_number][$k]["name"]]["id"] = $event_hours_tt[$weekday_fixed_number][$k]["id"];
							$events[$event_hours_tt[$weekday_fixed_number][$k]["name"]]["hours"][] = $event_hours_tt[$weekday_fixed_number][$k]["start"] . " - " . $event_hours_tt[$weekday_fixed_number][$k]["end"];
							$event_hours_tt[$weekday_fixed_number][$k]["displayed"] = true;
						}
					}
					$color = "";
					$text_color = "";
					$hover_color = "";
					$hover_text_color = "";
					$hours_text_color = "";
					$hours_hover_text_color = "";
					if(count($events)==1 && count($events[key($events)]['hours'])==1)
					{
						$color = get_post_meta($events[key($events)]["id"], "timetable_color", true);
						if($color=="" && strtoupper($box_bg_color)!="00A27C")
							$color = $box_bg_color;
						$hover_color = get_post_meta($events[key($events)]["id"], "timetable_hover_color", true);
						if($hover_color=="" && strtoupper($box_hover_bg_color)!="1F736A")
							$hover_color = $box_hover_bg_color;
						$text_color = get_post_meta($events[key($events)]["id"], "timetable_text_color", true);
						if($text_color=="" && strtoupper($box_txt_color)!="FFFFFF")
							$text_color = $box_txt_color;
						$hover_text_color = get_post_meta($events[key($events)]["id"], "timetable_hover_text_color", true);
						if($hover_text_color=="" && strtoupper($box_hover_txt_color)!="FFFFFF")
						{
							$hover_text_color = $box_hover_txt_color;
							if($text_color=="")
								$text_color = "FFFFFF";
						}
						$hours_text_color = get_post_meta($events[key($events)]["id"], "timetable_hours_text_color", true);
						if($hours_text_color=="" && strtoupper($box_hours_txt_color)!="FFFFFF")
							$hours_text_color = $box_hours_txt_color;
						$hours_hover_text_color = get_post_meta($events[key($events)]["id"], "timetable_hours_hover_text_color", true);
						if($hours_hover_text_color=="" && (strtoupper($box_hours_hover_txt_color)!="FFFFFF" || $hours_text_color!=""))
						{
							$hours_hover_text_color = $box_hours_hover_txt_color;
							if($hours_text_color=="")
								$hours_text_color = "FFFFFF";
						}
					}
					$global_colors = array(
						"box_bg_color" => $box_bg_color,
						"box_hover_bg_color" => $box_hover_bg_color,
						"box_txt_color" => $box_txt_color,
						"box_hover_txt_color" => $box_hover_txt_color,
						"box_hours_txt_color" => $box_hours_txt_color,
						"box_hours_hover_txt_color" => $box_hours_hover_txt_color
					);
					$row_content .= '<td' . ($color!="" || $text_color!="" || $text_align!="center" ? ' style="' . ($text_align!="center" ? 'text-align:' . $text_align . ';' : '') . ($color!="" ? 'background: #' . $color . ';' : '') . ($text_color!="" ? 'color: #' . $text_color . ';' : '') . '"': '') . ($hover_color!="" || $hover_text_color!="" || $hours_hover_text_color!="" ? ' onMouseOver="' . ($hover_color!="" ? 'this.style.background=\'#'.$hover_color.'\';' : '') . ($hover_text_color!="" ? 'this.style.color=\'#'.$hover_text_color.'\';jQuery(this).find(\'.event_header\').css(\'cssText\', \'color: #'.$hover_text_color.' !important\');' : '') . ($hours_hover_text_color!="" ? 'jQuery(this).find(\'.hours\').css(\'color\',\'#'.$hours_hover_text_color.'\');' : '') . '" onMouseOut="' . ($hover_color!="" ? 'this.style.background=\'#'.$color.'\';' : '') . ($hover_text_color!="" ? 'this.style.color=\'#'.$text_color.'\';jQuery(this).find(\'.event_header\').css(\'cssText\',\'color: #'.$text_color.' !important\');' : '') . ($hours_hover_text_color!="" ? 'jQuery(this).find(\'.hours\').css(\'color\',\'#'.$hours_text_color.'\');' : '') . '"' : '') . ' class="event' . (count(array_filter(array_values($events[key($events)]['tooltip']))) && count($events)==1 && count($events[key($events)]['hours'])==1 ? ' tt_tooltip' : '' ) . (count($events)==1 && count($events[key($events)]['hours'])==1 ? ' tt_single_event' : '') . '"' . ($rowspan>1 ? ' rowspan="' . $rowspan . '"' : '') . '>';
					$row_content .= tt_get_row_content($events, $events_page, $time_format, $event_layout, $global_colors, $disable_event_url);
					$row_content .= '</td>';
					$row_empty = false;
				}
				else
					$row_content .= '<td></td>';
				$temp_empty_count++;
			}
		}
		if($temp_empty_count!=$j)
			$row_empty = false;
		if(((int)$hide_empty && !$row_empty) || !(int)$hide_empty)
		{
			$output .= '<tr class="row_' . ($l+1) . ($l%2==1 ? ' row_gray' : '') . '"' . ($l%2==1 && strtoupper($row1_color)!="F0F0F0" ? ' style="background: ' . ($row1_color!="transparent" ? '#' : '') . $row1_color . ' !important;"' : '') . ($l%2==0 && $row2_color!="" ? ' style="background: ' . ($row2_color!="transparent" ? '#' : '') . $row2_color . ' !important;"' : '') . '>';
			if(!(int)$hide_hours_column)
			{
				$output .= '<td class="tt_hours_column">
					' . $start . ((int)$show_end_hour ? ' - ' . $end : '') . '
				</td>';
			}
			$output .= $row_content;				
			$output .= '</tr>';
			$l++;
		}
	}
	$output .= '</tbody>
			</table>';
	if((int)$responsive)
	{
		$output .= '<div class="tt_timetable small">';
		$l = 0;
		foreach($weekdays as $weekday)
		{
			//$weekday_fixed_number = ($weekday->menu_order>1 ? $weekday->menu_order-1 : 7);
			$weekday_fixed_number = $weekday->menu_order;
			if(isset($event_hours_tt[$weekday_fixed_number]))
			{
				$output .= '<h3 class="box_header' . ($l>0 ? ' page_margin_top' : '') . '">
					' . $weekday->post_title . '
				</h3>
				<ul class="tt_items_list thin page_margin_top timetable_clearfix' . (isset($mode) && $mode=='12h' ? ' mode12' : '') . '">';
					$event_hours_count = count($event_hours_tt[$weekday_fixed_number]);
						
					for($i=0; $i<$event_hours_count; $i++)
					{
						if($time_format!="H.i")
						{
							$event_hours_tt[$weekday_fixed_number][$i]["start"] = date($time_format, strtotime($event_hours_tt[$weekday_fixed_number][$i]["start"]));
							$event_hours_tt[$weekday_fixed_number][$i]["end"] = date($time_format, strtotime($event_hours_tt[$weekday_fixed_number][$i]["end"]));
						}
						$classes_url = "";
						$timetable_custom_url = get_post_meta($event_hours_tt[$weekday_fixed_number][$i]["id"], "timetable_custom_url", true);
						if(!(int)get_post_meta($event_hours_tt[$weekday_fixed_number][$i]["id"], "timetable_disable_url", true) && !(int)$disable_event_url)
							$classes_url = ($timetable_custom_url!="" ? $timetable_custom_url : get_permalink($event_hours_tt[$weekday_fixed_number][$i]["id"]));
						$output .= '<li class="timetable_clearfix icon_clock_black"><' . ($classes_url!="" ? 'a' : 'span') . ($classes_url!="" ? ' href="' . $classes_url /*. '#' . urldecode($event_hours_tt[$weekday_fixed_number][$i]["name"])*/ . '"' : '') . ' title="' .  esc_attr($event_hours_tt[$weekday_fixed_number][$i]["title"]) . '"' . '>' . $event_hours_tt[$weekday_fixed_number][$i]["title"] . '</' . ($classes_url!="" ? 'a' : 'span') . '>';
						$output .= '<div class="value">
									' . $event_hours_tt[$weekday_fixed_number][$i]["start"] . ' - ' . $event_hours_tt[$weekday_fixed_number][$i]["end"] . '
								</div>
							</li>';
					}
				$output .= '</ul>';
				$l++;
			}
		}
		$output .= '</div>';
	}
	return $output;
}
?>