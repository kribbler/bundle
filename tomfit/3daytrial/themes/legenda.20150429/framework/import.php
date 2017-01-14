<?php 

add_action('wp_ajax_etheme_import_ajax', 'etheme_import_data');

function etheme_import_data() {
    //delete_option('demo_data_installed');die();
	if(!isset($_POST['version'])) {
	   $style = 'e-commerce';
	} else {
	   $style = $_POST['version'];
	}
	// Load Importer API
	require_once ABSPATH . 'wp-admin/includes/import.php';
	$importerError = false;
    $demo_data_installed = get_option('demo_data_installed');
    switch ($style){ 
    	case 'e-commerce':
            $file = get_template_directory() ."/framework/dummy/Dummy.xml";
    	break;
    
    	case 'corporate':
	       $file = get_template_directory() ."/framework/dummy/Dummy_corpo.xml";
    	break;
    
    	default :
	       $file = get_template_directory() ."/framework/dummy/Dummy_corpo.xml";
    }
	
	//check if wp_importer, the base importer class is available, otherwise include it
	if ( !class_exists( 'WP_Importer' ) ) {
		$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		if ( file_exists( $class_wp_importer ) ) 
			require_once($class_wp_importer);
		else 
			$importerError = true;
	}
    
	
	if($importerError !== false) {
		echo ("The Auto importing script could not be loaded. Please use the wordpress importer and import the XML file that is located in your themes folder manually.");
	} else {
		
		if(class_exists('WP_Importer')){
			try{
                
                if($demo_data_installed != 'yes') {
    				$importer = new WP_Import();
    				$importer->fetch_attachments = true;
    				$importer->import($file);
                }	
                
					etheme_update_options($style);
                
				    etheme_update_menus();
                die('Success!');
				
				
				
			} catch (Exception $e) {
				echo ("Error while importing");
			}

		}
		
	}
		
	
	die();
}

function etheme_update_options($style = 'e-commerce') {
    global $options_presets;
	$home_id = get_page_by_title('Home Page');
	$blog_id = get_page_by_title('Blog');;
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $home_id->ID );
    update_option( 'page_for_posts', $blog_id->ID );
    add_option('demo_data_installed', 'yes');
    
    
    // Update Theme Optinos
    $new_options = json_decode(base64_decode($options_presets[$style]),true);
	update_option( 'option_tree', $new_options );
}

function etheme_update_menus(){
	
	global $wpdb;
	
    $menuname = 'Main Menu';
	$bpmenulocation = 'main-menu';
	$mobilemenulocation = 'mobile-menu';
	
	$tablename = $wpdb->prefix.'terms';
	$menu_ids = $wpdb->get_results(
	    "
	    SELECT term_id
	    FROM ".$tablename." 
	    WHERE name= '".$menuname."'
	    "
	);
	
	// results in array 
	foreach($menu_ids as $menu):
	    $menu_id = $menu->term_id;
	endforeach; 

	
	
    if( !has_nav_menu( $bpmenulocation ) ){
        $locations = get_theme_mod('nav_menu_locations');
        $locations[$bpmenulocation] = $menu_id;
        $locations[$mobilemenulocation] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
        
}
