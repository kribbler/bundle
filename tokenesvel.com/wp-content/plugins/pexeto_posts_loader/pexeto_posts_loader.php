<?php
/*
Plugin Name: Pexeto's latest posts loader
Description: Displays the latest posts from a category
Version: 1.0
Author: Pexeto
Author URI: http://pexeto.com
*/ 

add_action('init', 'pexeto_blog_posts_register');
function pexeto_blog_posts_register() {
	
	$prefix = 'pexeto-blog-posts'; // $id prefix
	$name = __("Pexeto's latest posts loader");
	$widget_ops = array('classname' => 'pexeto_blog_posts', 'description' => __('Displays the latest posts from a category'));
	$control_ops = array('width' => 200, 'height' => 200, 'id_base' => $prefix);
	
	$options = get_option('pexeto_blog_posts');
	if(isset($options[0])) unset($options[0]);
	
	if(!empty($options)){
		foreach(array_keys($options) as $widget_number){
			wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'pexeto_blog_posts', $widget_ops, array( 'number' => $widget_number ));
			wp_register_widget_control($prefix.'-'.$widget_number, $name, 'pexeto_blog_posts_control', $control_ops, array( 'number' => $widget_number ));
		}
	} else{
		$options = array();
		$widget_number = 1;
		wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'pexeto_blog_posts', $widget_ops, array( 'number' => $widget_number ));
		wp_register_widget_control($prefix.'-'.$widget_number, $name, 'pexeto_blog_posts_control', $control_ops, array( 'number' => $widget_number ));
	}
}

function pexeto_blog_posts($args, $vars = array()) {
    extract($args);
    $widget_number = (int)str_replace('pexeto-blog-posts-', '', @$widget_id);
    $options = get_option('pexeto_blog_posts');
    if(!empty($options[$widget_number])){
    	$vars = $options[$widget_number];
    }
    // widget open tags
		echo $before_widget;
		
		// print title from admin 
		if(!empty($vars['title'])){
			echo $before_title . stripslashes($vars['title']) . $after_title;
		} 
		
		// print content and widget end tags
    
	$catId=$vars['catId'];
	$number=$vars['postNumber'];
	$title=$vars['title'];

	$exclude_fromats = array();
	$post_formats = get_terms(array('post_format'));
	foreach ($post_formats as $format) {
		if(isset($vars[$format->slug]) && $vars[$format->slug]){
			$exclude_fromats[]=$format->slug;
		}
	}

	printPosts($catId,$number,$title,$exclude_fromats);
		
    echo $after_widget;
}

function pexeto_blog_posts_control($args) {

	$prefix = 'pexeto-blog-posts'; // $id prefix
	
	$options = get_option('pexeto_blog_posts');
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
		$options = bf_smart_multiwidget_update($prefix, $options, $_POST[$prefix], $_POST['sidebar'], 'pexeto_blog_posts');
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
	$format=@$opts['format'];

	 
	?>
  	<p>
  	<label>Title</label><br />
	<input type="text" name="<?php echo $prefix; ?>[<?php echo $number; ?>][title]" value="<?php echo $title; ?>" />
	</p>
	
	<p>
	<label>Number of posts to show</label><br />
    <input type="text" name="<?php echo $prefix; ?>[<?php echo $number; ?>][postNumber]" value="<?php echo $postNumber; ?>"/>
    </p>
    
    
    <p>
   <label>Post category<br /></label><select name="<?php echo $prefix; ?>[<?php echo $number; ?>][catId]"> 
      <option value="-1">ALL</option>
     <?php 
		$cats=get_categories();
		
      foreach ($cats as $cat) {
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

	<p>
	<label>Exclude custom post formats</label><br />

	<?php $post_formats = get_terms(array('post_format'));

	foreach ($post_formats as $format) {
		?><input type="checkbox" name="<?php echo $prefix; ?>[<?php echo $number; ?>][<?php echo $format->slug;?>]" 
		value="<?php echo $format->slug; ?>"
		<?php if(@$opts[$format->slug]){ ?>
		checked
		<?php } ?>
		><?php echo $format->name; ?><br/><?php
	}
	 ?>
    
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

function printPosts($catId,$number,$title,$exclude_fromats){

	$args=array('showposts' => $number, 'ignore_sticky_posts' => 1);
	$tax_query = array('ralation' => 'AND' );

	if($catId!='' && $catId!='-1'){
      	$tax_query[]=array(
			'taxonomy' => 'category',
			'field' => 'id',
			'terms' => array( $catId ),
			'operator' => 'IN'
		);
    }
    if(!empty($exclude_fromats)){
    	$tax_query[]=array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => $exclude_fromats,
			'operator' => 'NOT IN'
		);
	}
    
    $args['tax_query']=$tax_query;


	$posts = get_posts($args); ?>

	<div class="sidebar-latest-posts">
	<?php foreach ($posts as $post) { ?>
		<div class="lp-wrapper">
		<?php
		 if(has_post_thumbnail($post->ID)){ 
			$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium');
			$thumbnail=pexeto_get_resized_image($large_image_url[0], 55, 47);
		?>
		<a href="<?php echo get_permalink($post->ID); ?>"> <img src="<?php echo $thumbnail; ?>" class="alignleft img-frame" width="55" height="47" />
		</a>
		<?php } ?>
		<div class="lp-info-wrapper">
			<span class="lp-title"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></span>
			<span class="lp-post-info"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('j/n, Y', $post); ?> </a> </span>
			<div class="clear"></div>		
		</div>
	    
		<div class="clear"></div>
	    </div>
		
		<?php 
		}?>
	</div>
	<?php
}
?>