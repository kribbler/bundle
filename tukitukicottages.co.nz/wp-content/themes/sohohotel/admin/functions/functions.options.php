<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select 	= array("one","two","three","four","five"); 
		$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			), 
			"enabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		            	natsort($bg_images); //Sorts the array into a natural order
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();

// General Settings
$of_options[] = array( "name" => "General Settings",
                    "type" => "heading");
					
$url =  ADMIN_DIR . 'assets/images/';
$of_options[] = array( "name" => "Main Layout",
					"desc" => "Select main content and sidebar alignment",
					"id" => "sidebar_position",
					"std" => "right",
					"type" => "images",
					"options" => array(
						'none' => $url . '1col.png',
						'right' => $url . '2cr.png',
						'left' => $url . '2cl.png')
					);
					
$of_options[] = array( "name" => "Text Logo",
						"desc" => "Tick this box if you don't have an image based logo",
						"id" => "text_logo",
						"std" => "0",
						"type" => "checkbox");

$of_options[] = array( "name" => "Image Logo",
						"desc" => "Upload your logo here",
						"id" => "image_logo",
						"std" => "",
						"type" => "upload");

$of_options[] = array( "name" => "Default Page Header Image",
						"desc" => "Enter your Image URL e.g. http://website.com/image.jpg",
						"id" => "page_header",
						"std" => "",
						"type" => "text");

$of_options[] = array( "name" => "Favicon",
						"desc" => "Enter your Favicon URL e.g. http://website.com/favicon.ico",
						"id" => "favicon_url",
						"std" => "",
						"type" => "text");

$of_options[] = array( "name" => "Footer Message",
						"desc" => "Copyright message to be displayed in footer",
						"id" => "footer_msg",
						"std" => "&copy; Copyright 2013",
						"type" => "textarea");
						
$of_options[] = array( "name" => "Google Analytics Code",
					"desc" => "",
					"id" => "google_analytics",
					"std" => "",
					"type" => "textarea");

// Styling Options
$of_options[] = array( "name" => "Styling Options",
					"type" => "heading");

$of_options[] = array( "name" => "Colour Scheme",
						"desc" => "",
						"id" => "colour_scheme",
						"std" => "goldblack",
						"type" => "select",
							"options" => array(
								'goldblack' => 'Gold &amp; Black',
								'blueblack' => 'Blue &amp; Black',
								'creamgreen' => 'Cream &amp; Green',
								'creamred' => 'Cream &amp; Red',)
							);

$of_options[] = array( "name" =>  "Body Background Colour",
						"desc" => "Pick a colour",
						"id" => "body_background",
						"std" => "",
						"type" => "color");
						
$of_options[] = array( "name" => "Background Image",
						"desc" => "Upload your background here",
						"id" => "body_background_image",
						"std" => "",
						"type" => "upload");
						
$of_options[] = array( "name" => "Background Repeat",
						"desc" => "Choose how to repeat the background image",
						"id" => "background_repeat",
						"std" => "repeat",
						"type" => "select",
						"options" => array(
							'repeat' => 'repeat',
							'repeat-y' => 'repeat-y',
							'repeat-x' => 'repeat-x',
							'no-repeat' => 'no-repeat',)
						);

$of_options[] = array( "name" =>  "Main Colour",
						"desc" => "Pick a colour",
						"id" => "main_color",
						"std" => "",
						"type" => "color");

$of_options[] = array( "name" =>  "Navigation/Footer Background Colour",
						"desc" => "Pick a colour",
						"id" => "nav_footer_color",
						"std" => "",
						"type" => "color");
						
$of_options[] = array( "name" =>  "Navigation/Footer Text/Border Colour (Displayed on top of the colour above)",
						"desc" => "Pick a colour",
						"id" => "nav_footer_border",
						"std" => "",
						"type" => "color");
				
$of_options[] = array( "name" =>  "Datepicker Unavailable Background Colour",
					"desc" => "Pick a colour",
					"id" => "dp_unavailable_background",
					"std" => "",
					"type" => "color");
											
$of_options[] = array( "name" =>  "Datepicker Unavailable Text Colour",
					"desc" => "Pick a colour",
					"id" => "dp_unavailable_color",
					"std" => "",
					"type" => "color");		
					
$of_options[] = array( "name" =>  "Datepicker Available Background Colour",
					"desc" => "Pick a colour",
					"id" => "dp_available_background",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "Datepicker Available Text Colour",
					"desc" => "Pick a colour",
					"id" => "dp_available_color",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "Datepicker Selected Background Colour",
					"desc" => "Pick a colour",
					"id" => "dp_selected_background",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "Datepicker Selected Text Colour",
					"desc" => "Pick a colour",
					"id" => "dp_selected_color",
					"std" => "",
					"type" => "color");

$of_options[] = array( "name" =>  "Slideshow Caption Background Colour (RGBA format)",
					"desc" => "Use http://hex2rgba.devoth.com/ e.g. rgba(191, 153, 88, 0.7)",
					"id" => "main_colorrgba",
					"std" => "rgba(191, 153, 88, 0.7)",
					"type" => "text");			

$of_options[] = array( "name" => "Custom CSS",
					"desc" => "Add any custom CSS you wish here",
					"id" => "custom_css",
					"std" => '',
					"type" => "textarea");
										
$of_options[] = array( "name" => "Google Font",
					"desc" => "Add Google Font Code Here, e.g. <br /><br /> &#60;link href='http://fonts.googleapis.com/css?family=Merriweather:400,900italic,900,700italic,700,400italic,300,300italic' rel='stylesheet' type='text/css'&#62;",
					"id" => "custom_font_code",
					"std" => "<link href='http://fonts.googleapis.com/css?family=Merriweather:400,900italic,900,700italic,700,400italic,300,300italic' rel='stylesheet' type='text/css'>",
					"type" => "textarea");

$of_options[] = array( "name" => "Google Font Name",
					"desc" => "Enter the Google Font name / family here without 'font-family', e.g. <br /><br /> 'Cardo', serif",
					"id" => "custom_font",
					"std" => "'Merriweather', serif",
					"type" => "text");

// Home Settings
$of_options[] = array( "name" => "Home Settings",
					"type" => "heading");
					
$of_options[] = array( "name" => "Display Slideshow",
					"desc" => "Tick to display slideshow on homepage",
					"id" => "slideshow_display",
					"std" => "0",
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Autoplay Slideshow",
					"desc" => "Tick to autoplay",
					"id" => "slideshow_autoplay",
					"std" => "0",
					"type" => "checkbox");
					
$of_options[] = array( 	"name" 		=> "Homepage Slideshow",
						"desc" 		=> "Add the description/caption like so:<br /><br />&lt;p class=\"colour-caption medium-caption\"&gt;<strong>Caption Line 1</strong>&lt;/p&gt;<br /><br />
						&lt;div class=\"clearboth\">&lt;/div&gt;<br /><br />
						&lt;p class=\"dark-caption large-caption\"&gt;<strong>Caption Line 2</strong>&lt;/p&gt;",
						"id" 		=> "homepage_slider",
						"std" 		=> "",
						"type" 		=> "slider");
					
$of_options[] = array( "name" => "Display Booking Form on Slideshow",
					"desc" => "Tick to display",
					"id" => "display_slideshow_booking",
					"std" => "1",
					"type" => "checkbox");

$of_options[] = array( "name" => "Block Title 1",
					"desc" => "",
					"id" => "homepage_block_title_1",
					"std" => "Block Title 1",
					"type" => "text");					

$of_options[] = array( "name" => "Block Content 1",
					"desc" => "Don't forget to use &lt;p&gt; tags",
					"id" => "homepage_block_content_1",
					"std" => '<p>Block Content 1</p>',
					"type" => "textarea");

$of_options[] = array( "name" => "Block Button Title 1",
					"desc" => "Leave this blank if you don't want a button",
					"id" => "homepage_block_button_1",
					"std" => "Block Button 1",
					"type" => "text");

$of_options[] = array( "name" => "Block Button Link 1",
					"desc" => "e.g. http://website.com/page",
					"id" => "homepage_block_link_1",
					"std" => "#",
					"type" => "text");

$of_options[] = array( "name" => "Block Title 2",
					"desc" => "",
					"id" => "homepage_block_title_2",
					"std" => "Block Title 2",
					"type" => "text");					

$of_options[] = array( "name" => "Block Content 2",
					"desc" => "Don't forget to use &lt;p&gt; tags",
					"id" => "homepage_block_content_2",
					"std" => '<p>Block Content 2</p>',
					"type" => "textarea");

$of_options[] = array( "name" => "Block Button Title 2",
					"desc" => "Leave this blank if you don't want a button",
					"id" => "homepage_block_button_2",
					"std" => "Block Button 2",
					"type" => "text");

$of_options[] = array( "name" => "Block Button Link 2",
					"desc" => "e.g. http://website.com/page",
					"id" => "homepage_block_link_2",
					"std" => "#",
					"type" => "text");

$of_options[] = array( "name" => "Block Title 3",
					"desc" => "",
					"id" => "homepage_block_title_3",
					"std" => "Block Title 3",
					"type" => "text");					

$of_options[] = array( "name" => "Block Content 3",
					"desc" => "Don't forget to use &lt;p&gt; tags",
					"id" => "homepage_block_content_3",
					"std" => '<p>Block Content 3</p>',
					"type" => "textarea");

$of_options[] = array( "name" => "Block Button Title 3",
					"desc" => "Leave this blank if you don't want a button",
					"id" => "homepage_block_button_3",
					"std" => "Block Button 3",
					"type" => "text");

$of_options[] = array( "name" => "Block Button Link 3",
					"desc" => "e.g. http://website.com/page",
					"id" => "homepage_block_link_3",
					"std" => "#",
					"type" => "text");
					
$of_options[] = array( "name" => "Photo Gallery Slider",
					"desc" => "",
					"id" => "homepage_photo_slider",
					"std" => '[gallery_section]
[gallery_image image_url=http://website.com/image.jpg]
[gallery_image image_url=http://website.com/image.jpg]
[gallery_image image_url=http://website.com/image.jpg]
[/gallery_section]

[gallery_section]
[gallery_image image_url=http://website.com/image.jpg]
[gallery_image image_url=http://website.com/image.jpg]
[gallery_image image_url=http://website.com/image.jpg]
[/gallery_section]',
					"type" => "textarea");

// News Settings
$of_options[] = array( "name" => "News Settings",
					"type" => "heading");

$of_options[] = array( "name"       => "Posts Per Page",
						"desc"      => "Enter a numerical value e.g. 10",
						"id"        => "posts_per_page",
						"std"       => "10",
						"type"      => "text");

// Event Settings
$of_options[] = array( "name" => "Event Settings",
						"type" => "heading");

$of_options[] = array( "name"       => "Events Per Page",
						"desc"      => "Enter a numerical value e.g. 10",
						"id"        => "event_items_pp",
						"std"       => "10",
						"type"      => "text");

$of_options[] = array( 	"name" 		=> "Show Past Events",
						"desc" 		=> "Check to show past events",
						"id" 		=> "event_show_past",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"name" 		=> "Order By",
						"desc" 		=> "Choose the order events are displayed",
						"id" 		=> "event_order",
						"std" 		=> "Oldest First",
						"type" 		=> "select",
						"options"	=> array('Oldest First', 'Newest First')
				);

// Contact Options
$of_options[] = array( "name" => "Contact Settings",
					"type" => "heading");

$of_options[] = array( "name" => "Street Address",
					"desc" => "To be display in contact details list",
					"id" => "street_address",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Phone Number",
					"desc" => "To be display in contact details list",
					"id" => "phone_number",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => "Fax Number",
					"desc" => "To be display in contact details list",
					"id" => "fax_number",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Email Address",
					"desc" => "To be display in contact details list",
					"id" => "email_address",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => "Google Map Latitude",
					"desc" => "e.g. 51.523728",
					"id" => "gmap-lat",
					"std" => "51.523728",
					"type" => "text");
					
$of_options[] = array( "name" => "Google Map Longitude",
					"desc" => "e.g. -0.079336",
					"id" => "gmap-long",
					"std" => "-0.079336",
					"type" => "text");
					
$of_options[] = array( "name" => "Google Map Marker Content",
					"desc" => "",
					"id" => "gmap-content",
					"std" => "<h2>Soho Hotel</h2><p>1 Main Road, London, UK</p>",
					"type" => "textarea");
				
// Backup Options
$of_options[] = array( 	"name" 		=> "Backup Options",
						"type" 		=> "heading",
						"icon"		=> "icon-slider.png"
				);
				
$of_options[] = array( 	"name" 		=> "Backup and Restore Options",
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"desc" 		=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
				);
				
$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data",
						"id" 		=> "of_transfer",
						"std" 		=> "",
						"type" 		=> "transfer",
						"desc" 		=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
				);
				
	}//End function: of_options()
}//End chack if function exists: of_options()
?>
