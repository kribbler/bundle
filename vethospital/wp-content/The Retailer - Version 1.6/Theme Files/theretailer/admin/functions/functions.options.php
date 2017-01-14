<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories = array();  
		$of_categories_obj = get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp = array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages = array();
		$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp = array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select = array("one","two","three","four","five"); 
		$of_options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
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
				"placebo" => "placebo", //REQUIRED!
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
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads = get_option('of_uploads');
		$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
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

// General tab

$of_options[] = array( "name" => "General",
					"type" => "heading");
					
$url =  ADMIN_DIR . 'assets/images/';
$of_options[] = array( "name" => "Main Layout",
					"desc" => "Select the Layout Style. Choose between Fullscreen or Boxed layout.",
					"id" => "gb_layout",
					"std" => "fullscreen",
					"type" => "images",
					"options" => array(
						'fullscreen' => $url . '1col.png',
						'boxed' => $url . '3cm.png')
					);
					
$of_options[] = array( "name" => "Boxed Layout Width",
					"desc" => "The Width of the boxed layout in px.",
					"id" => "boxed_layout_width",
					"std" => "1100",
					"type" => "text");
					
$of_options[] = array( "name" => "Favicon",
					"desc" => "Add your custom Favicon image. 16x16px .ico or .png file required.",
					"id" => "favicon_image",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => "Favicon - Retina",
					"desc" => "The Retina version of your Favicon. 144x144px .png file required.",
					"id" => "favicon_retina",
					"std" => "",
					"mod" => "min",
					"type" => "media");
										
$of_options[] = array( "name" => "Revolution Slider",
					"desc" => "Check to turn off the Revolution Slider in mobile phones.",
					"id" => "revolution_slider_in_mobile_phones",
					"std" => 0,
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Comments on Pages",
					"desc" => "Check to display comments form on pages.",
					"id" => "page_comments",
					"std" => 0,
					"type" => "checkbox");

$of_options[] = array( "name" => "Light Footer on All Site",
					"desc" => "Check to hide the Light Footer on All Site.",
					"id" => "light_footer_all_site",
					"std" => 0,
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Dark Footer on All Site",
					"desc" => "Check to hide the Dark Footer on All Site.",
					"id" => "dark_footer_all_site",
					"std" => 0,
					"type" => "checkbox");









// Shop tab
$of_options[] = array( "name" => "Shop",
                    "type" => "heading");
					
$of_options[] = array( "name" => "Catalog Mode",
					"desc" => "Check to enable Catalog Mode. This option will turn off the shopping functionality of WooCommerce on theme pages.",
					"id" => "catalog_mode",
					"std" => 0,
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Shop With Sidebar",
					"desc" => "Check to enable the left sidebar on shop.",
					"id" => "sidebar_listing",
					"std" => 0,
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Flipping Products Animation",
					"desc" => "Check to turn off the flipping animation.",
					"id" => "flip_product",
					"std" => 0,
					"type" => "checkbox");
					
$of_options[] = array( "name" => "",
					"desc" => "Check to turn off the flipping animation on mobiles only.",
					"id" => "flip_product_mobiles",
					"std" => 0,
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Category in Product Listing",
					"desc" => "Check to hide the Category in Product Listing",
					"id" => "category_listing",
					"std" => 0,
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Products/Page in Product Listing",
					"desc" => "Enter the Number of Products per Page in Product Listing.",
					"id" => "products_per_page",
					"std" => "12",
					"type" => "text");
					
$of_options[] = array( "name" => "Register",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Register</h4>",
					"icon" => true,
					"type" => "info");
					
/*$of_options[] = array( "name" => "Register Title",
					"desc" => "Title for the registration text block.",
					"id" => "registration_title",
					"std" => "I'm a New Customer",
					"type" => "text");*/
					
$of_options[] = array( "name" => "Register Content",
					"desc" => "Registration body text.",
					"id" => "registration_content",
					"std" => "<h3>Your text here</h3>
<ul>
<li>Your text here</li>
<li>Your text here</li>
<li>Your text here</li>
<li>Your text here</li>
</ul>",
					"type" => "textarea");
					
/*$of_options[] = array( "name" => "Register Button",
					"desc" => "The text on your registration button.",
					"id" => "registration_button",
					"std" => "Create an account",
					"type" => "text");*/
					
$of_options[] = array( "name" => "Login",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Login</h4>",
					"icon" => true,
					"type" => "info");
					
/*$of_options[] = array( "name" => "Login Title",
					"desc" => "Title for the login block.",
					"id" => "login_title",
					"std" => "I'm a Returning Customer",
					"type" => "text");*/
					
$of_options[] = array( "name" => "Login Content",
					"desc" => "The body text for the Login text block.",
					"id" => "login_content",
					"std" => "<h3>Your text here</h3>
<ul>
<li>Your text here</li>
<li>Your text here</li>
<li>Your text here</li>
<li>Your text here</li>
</ul>",
					"type" => "textarea");
					
/*$of_options[] = array( "name" => "Login Button",
					"desc" => "The text on your Login button.",
					"id" => "login_button",
					"std" => "Login",
					"type" => "text");*/
				
					
					
					
					
					
// Header tab			
			
$of_options[] = array( "name" => "Header",
                    "type" => "heading");
					
					
$of_options[] = array( "name" => "Top Bar",
					"desc" => "Check to hide the Top Bar.",
					"id" => "hide_topbar",
					"std" => 0,
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Top Bar Text",
					"desc" => "Enter your Top Bar information here.",
					"id" => "topbar_text",
					"std" => "Define this text in Theme Options.",
					"type" => "text");
					
$of_options[] = array( "name" => "Main Navigation - Top Spacing",
					"desc" => "Set the spacing above the main navigation to adjust the size of your header.",
					"id" => "menu_header_top_padding",
					"std" => array('size' => '30px'),
					"type" => "typography");
					
$of_options[] = array( "name" => "Main Navigation - Bottom Spacing",
					"desc" => "Set the spacing below the main navigation to adjust the size of your header.",
					"id" => "menu_header_bottom_padding",
					"std" => array('size' => '30px'),
					"type" => "typography");					
					
					
					
					
					
// Footer tab					
					
$of_options[] = array( "name" => "Footer",
					"type" => "heading");
					
$of_options[] = array( "name" => "Custom Footer Logos/Credit Cards Sprite",
					"desc" => "Upload your custom icons sprite.",
					"id" => "footer_logos",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => "Copyright Text",
					"desc" => "Enter your copyright information here.",
					"id" => "copyright_text",
					"std" => "Define this text in Theme Options.",
					"type" => "text");							
					




// Styling tab

$of_options[] = array( "name" => "Styling",
					"type" => "heading");
					
$of_options[] = array( "name" => "Logo",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Logo</h4>",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( "name" => "Your Logo Image",
					"desc" => "Upload your Retina Logo. The canvas is 270 x 100 px. For retina upload a double size image (540 x 200 px)",
					"id" => "site_logo",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => "Main Background",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Main Background Options</h4>",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( "name" => "Background Color",
					"desc" => "Select a background color for your site.",
					"id" => "main_bg_color",
					"std" => "#fff",
					"type" => "color");
					
$of_options[] = array( "name" => "Background Image",
					"desc" => "Upload a background image or specify an image url (used with Boxed Layout).",
					"id" => "main_bg",
					"std" => "",
					"type" => "media");
					
$of_options[] = array( "name" => "Colors",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Colors</h4>",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( "name" => "Main Theme Color (Accent Color)",
					"desc" => "Define the main (accent) color for your theme. You can define colors for the header and footers individually.",
					"id" => "accent_color",
					"std" => "#b39964",
					"type" => "color");
					
$of_options[] = array( "name" => "Primary Font Color",
					"desc" => "Select a color for your Primary Font selected in the Typography section.",
					"id" => "primary_color",
					"std" => "#000",
					"type" => "color");
					
$of_options[] = array( "name" => "Header",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Header</h4>",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( "name" => "Header Background Color",
					"desc" => "Select a header background color.",
					"id" => "header_bg_color",
					"std" => "#f4f4f4",
					"type" => "color");
					
$of_options[] = array( "name" => "Primary Menu Color",
					"desc" => "Select a color for primary menu.",
					"id" => "primary_menu_color",
					"std" => "#000",
					"type" => "color");
					
$of_options[] = array( "name" => "Secondary Menu Color",
					"desc" => "Select a color for secondary menu.",
					"id" => "secondary_menu_color",
					"std" => "#777",
					"type" => "color");
					
$of_options[] = array( "name" => "Footer",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Footer</h4>",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( "name" => "Light Footer - Background Color",
					"desc" => "Select a background color for the light footer.",
					"id" => "primary_footer_bg_color",
					"std" => "#f4f4f4",
					"type" => "color");
					
$of_options[] = array( "name" => "Dark Footer - Background Color",
					"desc" => "Select a background color for the dark footer.",
					"id" => "secondary_footer_bg_color",
					"std" => "#000",
					"type" => "color");
					
$of_options[] = array( "name" => "Dark Footer - Text Color",
					"desc" => "Select Color for the texts.",
					"id" => "secondary_footer_color",
					"std" => "#fff",
					"type" => "color");

					
$of_options[] = array( "name" => "Dark Footer - Widget Title Border",
					"desc" => "This is the border for the widget titles. Size in px.",
					"id" => "secondary_footer_title_border",
					"std" => array('width' => '2','style' => 'solid','color' => '#3d3d3d'),
					"type" => "border");
					
$of_options[] = array( "name" => "Dark Footer - List separators and borders",
					"desc" => "Select Color for list separators and borders.",
					"id" => "secondary_footer_borders_color",
					"std" => "#3d3d3d",
					"type" => "color");
					
$of_options[] = array( "name" => "Copyright Bar - Background Color",
					"desc" => "Select a background color for the copyright bar.",
					"id" => "copyright_bar_bg_color",
					"std" => "#000",
					"type" => "color");
					
$of_options[] = array( "name" => "Copyright Bar - Top Border Style",
					"desc" => "Define the style for your copyright bar.",
					"id" => "copyright_bar_top_border",
					"std" => array('width' => '2','style' => 'solid','color' => '#3d3d3d'),
					"type" => "border");
					
$of_options[] = array( "name" => "Copyright Text Color",
					"desc" => "Select a color for the Copyright Text.",
					"id" => "copyright_text_color",
					"std" => "#a8a8a8",
					"type" => "color");	
					

					
$of_options[] = array( "name" => "Icons",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h4 class=\"theretailer_theme_options_subheader\">Icons</h4>",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( "name" => "Site Icons - Sprite",
					"desc" => "Upload your custom icons sprite.",
					"id" => "icons_sprite_normal",
					"std" => "",
					"mod" => "min",
					"type" => "upload");
					
$of_options[] = array( "name" => "Site Icons - Sprite (Retina)",
					"desc" => "Upload the retina version for your custom icons sprite.",
					"id" => "icons_sprite_retina",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
					
					
					
					
					
					
// Typography tab

$of_options[] = array( "name" => "Typography",
					"type" => "heading");
					
$all_font_faces = array('arial'=>'Arial',
				'verdana'=>'Verdana, Geneva',
				'trebuchet'=>'Trebuchet MS',
				'georgia' =>'Georgia',
				'times'=>'Times New Roman',
				'tahoma'=>'Tahoma, Geneva',
				'helvetica'=>'Helvetica',
				
				'Abel' => 'Abel',
				'Abril Fatface' => 'Abril Fatface',
				'Aclonica' => 'Aclonica',
				'Acme' => 'Acme',
				'Actor' => 'Actor',
				'Adamina' => 'Adamina',
				'Advent Pro' => 'Advent Pro',
				'Aguafina Script' => 'Aguafina Script',
				'Aladin' => 'Aladin',
				'Aldrich' => 'Aldrich',
				'Alegreya' => 'Alegreya',
				'Alegreya SC' => 'Alegreya SC',
				'Alex Brush' => 'Alex Brush',
				'Alfa Slab One' => 'Alfa Slab One',
				'Alice' => 'Alice',
				'Alike' => 'Alike',
				'Alike Angular' => 'Alike Angular',
				'Allan' => 'Allan',
				'Allerta' => 'Allerta',
				'Allerta Stencil' => 'Allerta Stencil',
				'Allura' => 'Allura',
				'Almendra' => 'Almendra',
				'Almendra SC' => 'Almendra SC',
				'Amaranth' => 'Amaranth',
				'Amatic SC' => 'Amatic SC',
				'Amethysta' => 'Amethysta',
				'Andada' => 'Andada',
				'Andika' => 'Andika',
				'Angkor' => 'Angkor',
				'Annie Use Your Telescope' => 'Annie Use Your Telescope',
				'Anonymous Pro' => 'Anonymous Pro',
				'Antic' => 'Antic',
				'Antic Didone' => 'Antic Didone',
				'Antic Slab' => 'Antic Slab',
				'Anton' => 'Anton',
				'Arapey' => 'Arapey',
				'Arbutus' => 'Arbutus',
				'Architects Daughter' => 'Architects Daughter',
				'Arimo' => 'Arimo',
				'Arizonia' => 'Arizonia',
				'Armata' => 'Armata',
				'Artifika' => 'Artifika',
				'Arvo' => 'Arvo',
				'Asap' => 'Asap',
				'Asset' => 'Asset',
				'Astloch' => 'Astloch',
				'Asul' => 'Asul',
				'Atomic Age' => 'Atomic Age',
				'Aubrey' => 'Aubrey',
				'Audiowide' => 'Audiowide',
				'Average' => 'Average',
				'Averia Gruesa Libre' => 'Averia Gruesa Libre',
				'Averia Libre' => 'Averia Libre',
				'Averia Sans Libre' => 'Averia Sans Libre',
				'Averia Serif Libre' => 'Averia Serif Libre',
				'Bad Script' => 'Bad Script',
				'Balthazar' => 'Balthazar',
				'Bangers' => 'Bangers',
				'Basic' => 'Basic',
				'Battambang' => 'Battambang',
				'Baumans' => 'Baumans',
				'Bayon' => 'Bayon',
				'Belgrano' => 'Belgrano',
				'Belleza' => 'Belleza',
				'Bentham' => 'Bentham',
				'Berkshire Swash' => 'Berkshire Swash',
				'Bevan' => 'Bevan',
				'Bigshot One' => 'Bigshot One',
				'Bilbo' => 'Bilbo',
				'Bilbo Swash Caps' => 'Bilbo Swash Caps',
				'Bitter' => 'Bitter',
				'Black Ops One' => 'Black Ops One',
				'Bokor' => 'Bokor',
				'Bonbon' => 'Bonbon',
				'Boogaloo' => 'Boogaloo',
				'Bowlby One' => 'Bowlby One',
				'Bowlby One SC' => 'Bowlby One SC',
				'Brawler' => 'Brawler',
				'Bree Serif' => 'Bree Serif',
				'Bubblegum Sans' => 'Bubblegum Sans',
				'Buda' => 'Buda',
				'Buenard' => 'Buenard',
				'Butcherman' => 'Butcherman',
				'Butterfly Kids' => 'Butterfly Kids',
				'Cabin' => 'Cabin',
				'Cabin Condensed' => 'Cabin Condensed',
				'Cabin Sketch' => 'Cabin Sketch',
				'Caesar Dressing' => 'Caesar Dressing',
				'Cagliostro' => 'Cagliostro',
				'Calligraffitti' => 'Calligraffitti',
				'Cambo' => 'Cambo',
				'Candal' => 'Candal',
				'Cantarell' => 'Cantarell',
				'Cantata One' => 'Cantata One',
				'Cardo' => 'Cardo',
				'Carme' => 'Carme',
				'Carter One' => 'Carter One',
				'Caudex' => 'Caudex',
				'Cedarville Cursive' => 'Cedarville Cursive',
				'Ceviche One' => 'Ceviche One',
				'Changa One' => 'Changa One',
				'Chango' => 'Chango',
				'Chau Philomene One' => 'Chau Philomene One',
				'Chelsea Market' => 'Chelsea Market',
				'Chenla' => 'Chenla',
				'Cherry Cream Soda' => 'Cherry Cream Soda',
				'Chewy' => 'Chewy',
				'Chicle' => 'Chicle',
				'Chivo' => 'Chivo',
				'Coda' => 'Coda',
				'Coda Caption' => 'Coda Caption',
				'Codystar' => 'Codystar',
				'Comfortaa' => 'Comfortaa',
				'Coming Soon' => 'Coming Soon',
				'Concert One' => 'Concert One',
				'Condiment' => 'Condiment',
				'Content' => 'Content',
				'Contrail One' => 'Contrail One',
				'Convergence' => 'Convergence',
				'Cookie' => 'Cookie',
				'Copse' => 'Copse',
				'Corben' => 'Corben',
				'Cousine' => 'Cousine',
				'Coustard' => 'Coustard',
				'Covered By Your Grace' => 'Covered By Your Grace',
				'Crafty Girls' => 'Crafty Girls',
				'Creepster' => 'Creepster',
				'Crete Round' => 'Crete Round',
				'Crimson Text' => 'Crimson Text',
				'Crushed' => 'Crushed',
				'Cuprum' => 'Cuprum',
				'Cutive' => 'Cutive',
				'Damion' => 'Damion',
				'Dancing Script' => 'Dancing Script',
				'Dangrek' => 'Dangrek',
				'Dawning of a New Day' => 'Dawning of a New Day',
				'Days One' => 'Days One',
				'Delius' => 'Delius',
				'Delius Swash Caps' => 'Delius Swash Caps',
				'Delius Unicase' => 'Delius Unicase',
				'Della Respira' => 'Della Respira',
				'Devonshire' => 'Devonshire',
				'Didact Gothic' => 'Didact Gothic',
				'Diplomata' => 'Diplomata',
				'Diplomata SC' => 'Diplomata SC',
				'Doppio One' => 'Doppio One',
				'Dorsa' => 'Dorsa',
				'Dosis' => 'Dosis',
				'Dr Sugiyama' => 'Dr Sugiyama',
				'Droid Sans' => 'Droid Sans',
				'Droid Sans Mono' => 'Droid Sans Mono',
				'Droid Serif' => 'Droid Serif',
				'Duru Sans' => 'Duru Sans',
				'Dynalight' => 'Dynalight',
				'EB Garamond' => 'EB Garamond',
				'Eater' => 'Eater',
				'Economica' => 'Economica',
				'Electrolize' => 'Electrolize',
				'Emblema One' => 'Emblema One',
				'Emilys Candy' => 'Emilys Candy',
				'Engagement' => 'Engagement',
				'Enriqueta' => 'Enriqueta',
				'Erica One' => 'Erica One',
				'Esteban' => 'Esteban',
				'Euphoria Script' => 'Euphoria Script',
				'Ewert' => 'Ewert',
				'Exo' => 'Exo',
				'Expletus Sans' => 'Expletus Sans',
				'Fanwood Text' => 'Fanwood Text',
				'Fascinate' => 'Fascinate',
				'Fascinate Inline' => 'Fascinate Inline',
				'Federant' => 'Federant',
				'Federo' => 'Federo',
				'Felipa' => 'Felipa',
				'Fjord One' => 'Fjord One',
				'Flamenco' => 'Flamenco',
				'Flavors' => 'Flavors',
				'Fondamento' => 'Fondamento',
				'Fontdiner Swanky' => 'Fontdiner Swanky',
				'Forum' => 'Forum',
				'Francois One' => 'Francois One',
				'Fredericka the Great' => 'Fredericka the Great',
				'Fredoka One' => 'Fredoka One',
				'Freehand' => 'Freehand',
				'Fresca' => 'Fresca',
				'Frijole' => 'Frijole',
				'Fugaz One' => 'Fugaz One',
				'GFS Didot' => 'GFS Didot',
				'GFS Neohellenic' => 'GFS Neohellenic',
				'Galdeano' => 'Galdeano',
				'Gentium Basic' => 'Gentium Basic',
				'Gentium Book Basic' => 'Gentium Book Basic',
				'Geo' => 'Geo',
				'Geostar' => 'Geostar',
				'Geostar Fill' => 'Geostar Fill',
				'Germania One' => 'Germania One',
				'Gilda Display' => 'Gilda Display',
				'Give You Glory' => 'Give You Glory',
				'Glass Antiqua' => 'Glass Antiqua',
				'Glegoo' => 'Glegoo',
				'Gloria Hallelujah' => 'Gloria Hallelujah',
				'Goblin One' => 'Goblin One',
				'Gochi Hand' => 'Gochi Hand',
				'Gorditas' => 'Gorditas',
				'Goudy Bookletter 1911' => 'Goudy Bookletter 1911',
				'Graduate' => 'Graduate',
				'Gravitas One' => 'Gravitas One',
				'Great Vibes' => 'Great Vibes',
				'Gruppo' => 'Gruppo',
				'Gudea' => 'Gudea',
				'Habibi' => 'Habibi',
				'Hammersmith One' => 'Hammersmith One',
				'Handlee' => 'Handlee',
				'Hanuman' => 'Hanuman',
				'Happy Monkey' => 'Happy Monkey',
				'Henny Penny' => 'Henny Penny',
				'Herr Von Muellerhoff' => 'Herr Von Muellerhoff',
				'Holtwood One SC' => 'Holtwood One SC',
				'Homemade Apple' => 'Homemade Apple',
				'Homenaje' => 'Homenaje',
				'IM Fell DW Pica' => 'IM Fell DW Pica',
				'IM Fell DW Pica SC' => 'IM Fell DW Pica SC',
				'IM Fell Double Pica' => 'IM Fell Double Pica',
				'IM Fell Double Pica SC' => 'IM Fell Double Pica SC',
				'IM Fell English' => 'IM Fell English',
				'IM Fell English SC' => 'IM Fell English SC',
				'IM Fell French Canon' => 'IM Fell French Canon',
				'IM Fell French Canon SC' => 'IM Fell French Canon SC',
				'IM Fell Great Primer' => 'IM Fell Great Primer',
				'IM Fell Great Primer SC' => 'IM Fell Great Primer SC',
				'Iceberg' => 'Iceberg',
				'Iceland' => 'Iceland',
				'Imprima' => 'Imprima',
				'Inconsolata' => 'Inconsolata',
				'Inder' => 'Inder',
				'Indie Flower' => 'Indie Flower',
				'Inika' => 'Inika',
				'Irish Grover' => 'Irish Grover',
				'Istok Web' => 'Istok Web',
				'Italiana' => 'Italiana',
				'Italianno' => 'Italianno',
				'Jim Nightshade' => 'Jim Nightshade',
				'Jockey One' => 'Jockey One',
				'Jolly Lodger' => 'Jolly Lodger',
				'Josefin Sans' => 'Josefin Sans',
				'Josefin Slab' => 'Josefin Slab',
				'Judson' => 'Judson',
				'Julee' => 'Julee',
				'Junge' => 'Junge',
				'Jura' => 'Jura',
				'Just Another Hand' => 'Just Another Hand',
				'Just Me Again Down Here' => 'Just Me Again Down Here',
				'Kameron' => 'Kameron',
				'Karla' => 'Karla',
				'Kaushan Script' => 'Kaushan Script',
				'Kelly Slab' => 'Kelly Slab',
				'Kenia' => 'Kenia',
				'Khmer' => 'Khmer',
				'Knewave' => 'Knewave',
				'Kotta One' => 'Kotta One',
				'Koulen' => 'Koulen',
				'Kranky' => 'Kranky',
				'Kreon' => 'Kreon',
				'Kristi' => 'Kristi',
				'Krona One' => 'Krona One',
				'La Belle Aurore' => 'La Belle Aurore',
				'Lancelot' => 'Lancelot',
				'Lato' => 'Lato',
				'League Script' => 'League Script',
				'Leckerli One' => 'Leckerli One',
				'Ledger' => 'Ledger',
				'Lekton' => 'Lekton',
				'Lemon' => 'Lemon',
				'Lilita One' => 'Lilita One',
				'Limelight' => 'Limelight',
				'Linden Hill' => 'Linden Hill',
				'Lobster' => 'Lobster',
				'Lobster Two' => 'Lobster Two',
				'Londrina Outline' => 'Londrina Outline',
				'Londrina Shadow' => 'Londrina Shadow',
				'Londrina Sketch' => 'Londrina Sketch',
				'Londrina Solid' => 'Londrina Solid',
				'Lora' => 'Lora',
				'Love Ya Like A Sister' => 'Love Ya Like A Sister',
				'Loved by the King' => 'Loved by the King',
				'Lovers Quarrel' => 'Lovers Quarrel',
				'Luckiest Guy' => 'Luckiest Guy',
				'Lusitana' => 'Lusitana',
				'Lustria' => 'Lustria',
				'Macondo' => 'Macondo',
				'Macondo Swash Caps' => 'Macondo Swash Caps',
				'Magra' => 'Magra',
				'Maiden Orange' => 'Maiden Orange',
				'Mako' => 'Mako',
				'Marcellus' => 'Marcellus',
				'Marcellus SC' => 'Marcellus SC',
				'Marck Script' => 'Marck Script',
				'Marko One' => 'Marko One',
				'Marmelad' => 'Marmelad',
				'Marvel' => 'Marvel',
				'Mate' => 'Mate',
				'Mate SC' => 'Mate SC',
				'Maven Pro' => 'Maven Pro',
				'Meddon' => 'Meddon',
				'MedievalSharp' => 'MedievalSharp',
				'Medula One' => 'Medula One',
				'Megrim' => 'Megrim',
				'Merienda One' => 'Merienda One',
				'Merriweather' => 'Merriweather',
				'Metal' => 'Metal',
				'Metamorphous' => 'Metamorphous',
				'Metrophobic' => 'Metrophobic',
				'Michroma' => 'Michroma',
				'Miltonian' => 'Miltonian',
				'Miltonian Tattoo' => 'Miltonian Tattoo',
				'Miniver' => 'Miniver',
				'Miss Fajardose' => 'Miss Fajardose',
				'Modern Antiqua' => 'Modern Antiqua',
				'Molengo' => 'Molengo',
				'Monofett' => 'Monofett',
				'Monoton' => 'Monoton',
				'Monsieur La Doulaise' => 'Monsieur La Doulaise',
				'Montaga' => 'Montaga',
				'Montez' => 'Montez',
				'Montserrat' => 'Montserrat',
				'Montserrat Alternates' => 'Montserrat Alternates',
				'Montserrat Subrayada' => 'Montserrat Subrayada',
				'Moul' => 'Moul',
				'Moulpali' => 'Moulpali',
				'Mountains of Christmas' => 'Mountains of Christmas',
				'Mr Bedfort' => 'Mr Bedfort',
				'Mr Dafoe' => 'Mr Dafoe',
				'Mr De Haviland' => 'Mr De Haviland',
				'Mrs Saint Delafield' => 'Mrs Saint Delafield',
				'Mrs Sheppards' => 'Mrs Sheppards',
				'Muli' => 'Muli',
				'Mystery Quest' => 'Mystery Quest',
				'Neucha' => 'Neucha',
				'Neuton' => 'Neuton',
				'News Cycle' => 'News Cycle',
				'Niconne' => 'Niconne',
				'Nixie One' => 'Nixie One',
				'Nobile' => 'Nobile',
				'Nokora' => 'Nokora',
				'Norican' => 'Norican',
				'Nosifer' => 'Nosifer',
				'Nothing You Could Do' => 'Nothing You Could Do',
				'Noticia Text' => 'Noticia Text',
				'Noto Sans' => 'Noto Sans',
				'Nova Cut' => 'Nova Cut',
				'Nova Flat' => 'Nova Flat',
				'Nova Mono' => 'Nova Mono',
				'Nova Oval' => 'Nova Oval',
				'Nova Round' => 'Nova Round',
				'Nova Script' => 'Nova Script',
				'Nova Slim' => 'Nova Slim',
				'Nova Square' => 'Nova Square',
				'Numans' => 'Numans',
				'Nunito' => 'Nunito',
				'Odor Mean Chey' => 'Odor Mean Chey',
				'Old Standard TT' => 'Old Standard TT',
				'Oldenburg' => 'Oldenburg',
				'Oleo Script' => 'Oleo Script',
				'Open Sans' => 'Open Sans',
				'Open Sans Condensed' => 'Open Sans Condensed',
				'Orbitron' => 'Orbitron',
				'Original Surfer' => 'Original Surfer',
				'Oswald' => 'Oswald',
				'Over the Rainbow' => 'Over the Rainbow',
				'Overlock' => 'Overlock',
				'Overlock SC' => 'Overlock SC',
				'Ovo' => 'Ovo',
				'Oxygen' => 'Oxygen',
				'PT Mono' => 'PT Mono',
				'PT Sans' => 'PT Sans',
				'PT Sans Caption' => 'PT Sans Caption',
				'PT Sans Narrow' => 'PT Sans Narrow',
				'PT Serif' => 'PT Serif',
				'PT Serif Caption' => 'PT Serif Caption',
				'Pacifico' => 'Pacifico',
				'Parisienne' => 'Parisienne',
				'Passero One' => 'Passero One',
				'Passion One' => 'Passion One',
				'Patrick Hand' => 'Patrick Hand',
				'Patua One' => 'Patua One',
				'Paytone One' => 'Paytone One',
				'Permanent Marker' => 'Permanent Marker',
				'Petrona' => 'Petrona',
				'Philosopher' => 'Philosopher',
				'Piedra' => 'Piedra',
				'Pinyon Script' => 'Pinyon Script',
				'Plaster' => 'Plaster',
				'Play' => 'Play',
				'Playball' => 'Playball',
				'Playfair Display' => 'Playfair Display',
				'Podkova' => 'Podkova',
				'Poiret One' => 'Poiret One',
				'Poller One' => 'Poller One',
				'Poly' => 'Poly',
				'Pompiere' => 'Pompiere',
				'Pontano Sans' => 'Pontano Sans',
				'Port Lligat Sans' => 'Port Lligat Sans',
				'Port Lligat Slab' => 'Port Lligat Slab',
				'Prata' => 'Prata',
				'Preahvihear' => 'Preahvihear',
				'Press Start 2P' => 'Press Start 2P',
				'Princess Sofia' => 'Princess Sofia',
				'Prociono' => 'Prociono',
				'Prosto One' => 'Prosto One',
				'Puritan' => 'Puritan',
				'Quantico' => 'Quantico',
				'Quattrocento' => 'Quattrocento',
				'Quattrocento Sans' => 'Quattrocento Sans',
				'Questrial' => 'Questrial',
				'Quicksand' => 'Quicksand',
				'Qwigley' => 'Qwigley',
				'Radley' => 'Radley',
				'Raleway' => 'Raleway',
				'Rammetto One' => 'Rammetto One',
				'Rancho' => 'Rancho',
				'Rationale' => 'Rationale',
				'Redressed' => 'Redressed',
				'Reenie Beanie' => 'Reenie Beanie',
				'Revalia' => 'Revalia',
				'Ribeye' => 'Ribeye',
				'Ribeye Marrow' => 'Ribeye Marrow',
				'Righteous' => 'Righteous',
				'Rochester' => 'Rochester',
				'Rock Salt' => 'Rock Salt',
				'Rokkitt' => 'Rokkitt',
				'Ropa Sans' => 'Ropa Sans',
				'Rosario' => 'Rosario',
				'Rosarivo' => 'Rosarivo',
				'Rouge Script' => 'Rouge Script',
				'Ruda' => 'Ruda',
				'Ruge Boogie' => 'Ruge Boogie',
				'Ruluko' => 'Ruluko',
				'Ruslan Display' => 'Ruslan Display',
				'Russo One' => 'Russo One',
				'Ruthie' => 'Ruthie',
				'Sail' => 'Sail',
				'Salsa' => 'Salsa',
				'Sancreek' => 'Sancreek',
				'Sansita One' => 'Sansita One',
				'Sarina' => 'Sarina',
				'Satisfy' => 'Satisfy',
				'Schoolbell' => 'Schoolbell',
				'Seaweed Script' => 'Seaweed Script',
				'Sevillana' => 'Sevillana',
				'Seymour One' => 'Seymour One',
				'Shadows Into Light' => 'Shadows Into Light',
				'Shadows Into Light Two' => 'Shadows Into Light Two',
				'Shanti' => 'Shanti',
				'Share' => 'Share',
				'Shojumaru' => 'Shojumaru',
				'Short Stack' => 'Short Stack',
				'Siemreap' => 'Siemreap',
				'Sigmar One' => 'Sigmar One',
				'Signika' => 'Signika',
				'Signika Negative' => 'Signika Negative',
				'Simonetta' => 'Simonetta',
				'Sirin Stencil' => 'Sirin Stencil',
				'Six Caps' => 'Six Caps',
				'Slackey' => 'Slackey',
				'Smokum' => 'Smokum',
				'Smythe' => 'Smythe',
				'Sniglet' => 'Sniglet',
				'Snippet' => 'Snippet',
				'Sofia' => 'Sofia',
				'Sonsie One' => 'Sonsie One',
				'Sorts Mill Goudy' => 'Sorts Mill Goudy',
				'Special Elite' => 'Special Elite',
				'Spicy Rice' => 'Spicy Rice',
				'Spinnaker' => 'Spinnaker',
				'Spirax' => 'Spirax',
				'Squada One' => 'Squada One',
				'Stardos Stencil' => 'Stardos Stencil',
				'Stint Ultra Condensed' => 'Stint Ultra Condensed',
				'Stint Ultra Expanded' => 'Stint Ultra Expanded',
				'Stoke' => 'Stoke',
				'Sue Ellen Francisco' => 'Sue Ellen Francisco',
				'Sunshiney' => 'Sunshiney',
				'Supermercado One' => 'Supermercado One',
				'Suwannaphum' => 'Suwannaphum',
				'Swanky and Moo Moo' => 'Swanky and Moo Moo',
				'Syncopate' => 'Syncopate',
				'Tangerine' => 'Tangerine',
				'Taprom' => 'Taprom',
				'Telex' => 'Telex',
				'Tenor Sans' => 'Tenor Sans',
				'The Girl Next Door' => 'The Girl Next Door',
				'Tienne' => 'Tienne',
				'Tinos' => 'Tinos',
				'Titan One' => 'Titan One',
				'Titillium Web' => 'Titillium Web',
				'Trade Winds' => 'Trade Winds',
				'Trocchi' => 'Trocchi',
				'Trochut' => 'Trochut',
				'Trykker' => 'Trykker',
				'Tulpen One' => 'Tulpen One',
				'Ubuntu' => 'Ubuntu',
				'Ubuntu Condensed' => 'Ubuntu Condensed',
				'Ubuntu Mono' => 'Ubuntu Mono',
				'Ultra' => 'Ultra',
				'Uncial Antiqua' => 'Uncial Antiqua',
				'UnifrakturCook' => 'UnifrakturCook',
				'UnifrakturMaguntia' => 'UnifrakturMaguntia',
				'Unkempt' => 'Unkempt',
				'Unlock' => 'Unlock',
				'Unna' => 'Unna',
				'VT323' => 'VT323',
				'Varela' => 'Varela',
				'Varela Round' => 'Varela Round',
				'Vast Shadow' => 'Vast Shadow',
				'Vibur' => 'Vibur',
				'Vidaloka' => 'Vidaloka',
				'Viga' => 'Viga',
				'Voces' => 'Voces',
				'Volkhov' => 'Volkhov',
				'Vollkorn' => 'Vollkorn',
				'Voltaire' => 'Voltaire',
				'Waiting for the Sunrise' => 'Waiting for the Sunrise',
				'Wallpoet' => 'Wallpoet',
				'Walter Turncoat' => 'Walter Turncoat',
				'Wellfleet' => 'Wellfleet',
				'Wire One' => 'Wire One',
				'Yanone Kaffeesatz' => 'Yanone Kaffeesatz',
				'Yellowtail' => 'Yellowtail',
				'Yeseva One' => 'Yeseva One',
				'Yesteryear' => 'Yesteryear',
				'Zeyada' => 'Zeyada'
);

/*$of_options[] = array( "name" => "Main Font",
					"desc" => "Pick the main font for your website.",
					"id" => "gb_main_font",
					"std" => "Arvo",
					"type" => "select",
					"options" => $all_font_faces);*/
					
$of_options[] = array( "name" => "Main Font",
					"desc" => "Pick the main font for your website.",
					"id" => "gb_main_font",
					"std" => "Arvo",
					"type" => "select_google_font",
					"options" => $all_font_faces); 

/*$of_options[] = array( "name" => "Secondary Font",
					"desc" => "Pick the secondary font for your website.",
					"id" => "gb_secondary_font",
					"std" => "Lato",
					"type" => "select",
					"options" => $all_font_faces);*/
					
$of_options[] = array( "name" => "Secondary Font",
					"desc" => "Pick the secondary font for your website.",
					"id" => "gb_secondary_font",
					"std" => "Lato",
					"type" => "select_google_font",
					"options" => $all_font_faces); 					
					
					
					


// Custom Code tab

$of_options[] = array( "name" => "Custom Code",
					"type" => "heading");
					
$of_options[] = array( "name" => "Custom CSS",
					"desc" => "Paste your custom CSS code here. The code will be added to the header of your site.",
					"id" => "custom_css",
					"std" => ".add-your-own-classes-here {

}",
					"type" => "textarea"); 
					
$of_options[] = array( "name" => "Header JavaScript Code",
					"desc" => "Paste your custom JS code here. The code will be added to the header of your site.",
					"id" => "custom_js_header",
					"std" => '<script type="text/javascript">
					
//JavaScript goes here

</script>',
					"type" => "textarea");
					
$of_options[] = array( "name" => "Google Analytics / Footer JavaScript Code",
					"desc" => "Here is the place to paste your Google Analytics code or any other JS code you might want to add to be loaded in the footer of your website.",
					"id" => "custom_js_footer",
					"std" => '<script type="text/javascript">
					
//JavaScript goes here

</script>',
					"type" => "textarea");
					
					
					
					
// Backup Options tab
$of_options[] = array( "name" => "Backup",
					"type" => "heading");
					
$of_options[] = array( "name" => "Backup and Restore Options",
                    "id" => "of_backup",
                    "std" => "",
                    "type" => "backup",
					"desc" => 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
					);
					
$of_options[] = array( "name" => "Transfer Theme Options Data",
                    "id" => "of_transfer",
                    "std" => "",
                    "type" => "transfer",
					"desc" => 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".
						',
					);
					
					
					
					
					
					
// Documentation tab
$of_options[] = array( "name" => "Documentation",
					"type" => "heading");
					
$of_options[] = array( "name" => "Documentation Info",
					"desc" => "",
					"id" => "doc_info",
					"std" => "<p class=\"theretailer_theme_options_info_paragraph\">Checkout our <a href=\"http://theretailer.getbowtied.com/docs/\" target=\"_blank\">Online Documentation</a>. From the first steps of installing the theme, to creating custom pages and style the whole thing for your needs, the documentation will provide you with the help you need to get started with your new theme.</p>",
					"icon" => true,
					"type" => "info");
					
	}
}
?>
