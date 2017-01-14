<?php
/*
Plugin Name: Portfolio posts loader
Description: Loads the posts from a defined category
Version: 2.0.1
Author: Pexeto
Author URI: http://pexeto.com
*/

add_action('init', 'portfolio_posts_register');
function portfolio_posts_register() {
	
	$prefix = 'portfolio-posts-multi'; // $id prefix
	$name = __("Pexeto's portfolio posts loader");
	$widget_ops = array('classname' => 'posts_multi', 'description' => __('Loads the latest portfolio posts'));
	$control_ops = array('width' => 200, 'height' => 200, 'id_base' => $prefix);
	
	$options = get_option('portfolio_posts_multi');
	if(isset($options[0])) unset($options[0]);
	
	if(!empty($options)){
		foreach(array_keys($options) as $widget_number){
			wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'portfolio_posts_multi', $widget_ops, array( 'number' => $widget_number ));
			wp_register_widget_control($prefix.'-'.$widget_number, $name, 'portfolio_posts_multi_control', $control_ops, array( 'number' => $widget_number ));
		}
	} else{
		$options = array();
		$widget_number = 1;
		wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'portfolio_posts_multi', $widget_ops, array( 'number' => $widget_number ));
		wp_register_widget_control($prefix.'-'.$widget_number, $name, 'portfolio_posts_multi_control', $control_ops, array( 'number' => $widget_number ));
	}
}

function portfolio_posts_multi($args, $vars = array()) {
    extract($args);
    $widget_number = (int)str_replace('portfolio-posts-multi-', '', @$widget_id);
    $options = get_option('portfolio_posts_multi');
    if(!empty($options[$widget_number])){
    	$vars = $options[$widget_number];
    }
    // widget open tags
		echo $before_widget;
		
	// print title from admin 
	echo $before_title . stripslashes($vars['title']) . $after_title;
		
		
	// print content and widget end tags
    
	$catId=$vars['catId'];
	$number=$vars['postNumber'];
	$title=$vars['title'];

	printPortfolioPosts($catId,$number,$title);
		
    echo $after_widget;
}

function portfolio_posts_multi_control($args) {

	$prefix = 'portfolio-posts-multi'; // $id prefix
	
	$options = get_option('portfolio_posts_multi');
	if(empty($options)) $options = array();
	if(isset($options[0])) unset($options[0]);
		
	// update options array
	if(!empty($_POST[$prefix]) && is_array($_POST)){
		foreach($_POST[$prefix] as $widget_number => $values){
			if(empty($values) && isset($options[$widget_number])) // user clicked cancel
				continue;
			
			if(!isset($options[$widget_number]) && $args['number'] == -1){
				$args['number'] = $widget_number;
				$options['last_number'] = $widget_number;
			}
			$options[$widget_number] = $values;
		}
		
		// update number
		if($args['number'] == -1 && !empty($options['last_number'])){
			$args['number'] = $options['last_number'];
		}

		// clear unused options and update options in DB. return actual options array
		$options = bf_smart_multiwidget_update($prefix, $options, $_POST[$prefix], $_POST['sidebar'], 'portfolio_posts_multi');
	}
	
	// $number - is dynamic number for Authors Loader, gived by WP
	// by default $number = -1 (if no widgets activated). In this case we should use %i% for inputs
	//   to allow WP generate number automatically
	$number = ($args['number'] == -1)? '%i%' : $args['number'];

	// now we can output control
	$opts = @$options[$number];
	
	$title = @$opts['title'];
	$catId=@$opts['catId'];
	$postNumber=@$opts['postNumber'];
	
	 
	?>
     <p><label>Title</label><br />
		<input type="text" name="<?php echo $prefix; ?>[<?php echo $number; ?>][title]" value="<?php echo $title; ?>" />
		</p>
		  <p><label>Number of items to show</label><br />
      <input type="text" name="<?php echo $prefix; ?>[<?php echo $number; ?>][postNumber]" value="<?php echo $postNumber; ?>"/>
     
    </p>
    
   <p><label>Portfolio category</label><br />
   <select name="<?php echo $prefix; ?>[<?php echo $number; ?>][catId]"> 
      <option value="0">ALL</option>
     <?php 
		$pexeto_portfolio_cats=get_terms(PEXETO_PORTFOLIO_TAXONOMY);
		
      foreach ($pexeto_portfolio_cats as $cat) {
        $option = '<option';
        if($catId==$cat->term_id){
            $option.=' selected';   
        }
        $option.=' value="'.$cat->term_id.'">'; 
        $option .= $cat->name;
        $option .= '</option>';
        echo $option;
      }
     ?>
    </select>
   </p>
	
   
    
	<?php
	
}

// helper function can be defined in another plugin
if(!function_exists('bf_smart_multiwidget_update')){
	function bf_smart_multiwidget_update($id_prefix, $options, $post, $sidebar, $option_name = ''){
		global $wp_registered_widgets;
		static $updated = false;

		// get active sidebar
		$sidebars_widgets = wp_get_sidebars_widgets();
		if ( isset($sidebars_widgets[$sidebar]) )
			$this_sidebar =& $sidebars_widgets[$sidebar];
		else
			$this_sidebar = array();
		
		// search unused options
		foreach ( $this_sidebar as $_widget_id ) {
			if(preg_match('/'.$id_prefix.'-([0-9]+)/i', $_widget_id, $match)){
				$widget_number = $match[1];
				
				// $_POST['widget-id'] contain current widgets set for current sidebar
				// $this_sidebar is not updated yet, so we can determine which was deleted
				if(!in_array($match[0], $_POST['widget-id'])){
					unset($options[$widget_number]);
				}
			}
		}
		
		// update database
		if(!empty($option_name)){
			update_option($option_name, $options);
			$updated = true;
		}
		
		// return updated array
		return $options;
	}
}

/**
 * Builds the HTML code for a single portfolio item image - can be used in plugins or
 * other widgets that display a set of portfolio items
 * @param $post_id the ID of the post
 * @param $width the width that will be set to the image
 * @param $height the height that will be set to the image
 */
function pexeto_build_portfolio_image_html($post, $width, $height, $showTitle=false, $groupName='group'){
	$post_id=$post->ID;
	$preview=pexeto_get_portfolio_preview_img($post_id);

	$settings = pexeto_get_post_meta( $post->ID, array( 'type', 'crop', 'custom_link'), PEXETO_PORTFOLIO_POST_TYPE);



	$thumbnail = pexeto_get_portfolio_preview_img($post_id);
	$thumbnail = pexeto_get_resized_image($thumbnail['img'], 
												90, 
												90, 
												$settings['crop']);

	$type=$settings['type'];

	//set the link of the image depending on the action selected
	

	switch ($type) {
		case 'smallslider':
		case 'fullslider':
		case 'standard':
		case 'fullvideo':
		case 'smallvideo':
		case 'lightbox':
			$openLink='<a href="'.get_permalink($post_id).'">';
			$closeLink='</a>';
			break;
		case 'custom':
			$openLink='<a href="'.$settings['custom_link'].'">';
			$closeLink='</a>';
			break;
	}
	

	return $openLink.'<img src="'.$thumbnail.'" class="img-frame"/>'.$closeLink;
}

function printPortfolioPosts($catId,$number,$title){
	if($number==''){
	$number=4;
	}
	
	$args= array(
         'posts_per_page' =>$number, 
		 'post_type' => 'portfolio',
         'post_status' => 'publish'		 
	);
	

	if($catId!='0'){
		// $slug=pexeto_get_taxonomy_slug($catId);
		$args['tax_query'] = array(
			array(
				'taxonomy' => PEXETO_PORTFOLIO_TAXONOMY,
				'field' => 'id',
				'terms' => array($catId)
			)
		);
	}
	
	$posts = get_posts($args);
	?>
 <ul class="portfolio-items-widget">
 
<?php 
		foreach ($posts as $post) {

 		
		echo '<li>'.pexeto_build_portfolio_image_html($post, 84, 74, false, '').'</li>';
		        
			
		}
	?></ul><?php 
}
?>