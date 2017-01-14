<?php
/*
Plugin Name: Custom Link Widget
Plugin URI: http://ipankaj.net/custom-link-widget-plugin
Description: This Plugin Helps You To Insert Links As Widget. You Need To Insert Link and Link Name, It Will Convert Them To Hyperlink Automatically. After Installation & Activation, Navigate to Appearence -> Widgets, There Should A Widget Called "Link Widget By Pankaj Biswas", Drag And Add That.
Author: Pankaj Biswas
Author URI: http://ipankaj.net
Version: 1.1.1
*/
class iCLW extends WP_Widget {

	function __construct(){
		$options = array(
			'description' => 'You can add links by entering the URL and LINK NAME, this widget will automatically transform them into hyperlinks.',
			'name' => 'Link Widget By Pankaj Biswas'
		);
		parent::__construct('iCLW','',$options);
	}
	
	//Taking Input From User
	public function form($instance){
		extract($instance);
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title');?>">Title: </label>
		<input class="widefat" style="background:#fff;" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" value="<?php if(isset($title)) echo esc_attr($title);?>"/>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('hLinks');?>">How Many Links You Want To Display? </label>
		<input type="number" min="1" max="20" class="widefat" style="background:#fff;width:40px;text-align:center;" id="<?php echo $this->get_field_id('numB');?>" name="<?php echo $this->get_field_name('numB');?>" value="<?php echo !empty($numB) ? $numB:1;?>"/>
		<br><i>Hit Save After Changing The Number. <b>Do Not Decrease The Number of Links</b>, If Does So, It Will Remove Some Links From The End Of The Array Permanently.</i>
		</p>
		<?php for($i=0;$i<$numB;$i++)
		{
		$count=$i+1;
		$target = 'iT'.$count;
		$link = 'iLink'.$count;
		$name = 'iName'.$count;
		?>
		<h4>Details for Link <?php echo $count;?></h4>

		<!-- New Window Opening Option -->
		<p>
			<label for="<?php echo $this->get_field_id($target);?>">Open Link In A New Window?</label>
			<input type="checkbox" class="checkbox" <?php checked($instance[$target], true) ?> id="<?php echo $this->get_field_id($target);?>" name="<?php echo $this->get_field_name($target);?>" value="1"/>
		</p>
		<!-- /New Window Opening Option -->

		<p>
		<label for="<?php echo $this->get_field_id($link);?>">URL: (Please Add http://) </label>
		<input class="widefat" style="background:#fff;" id="<?php echo $this->get_field_id($link);?>" name="<?php echo $this->get_field_name($link);?>" value="<?php if(isset($$link)) echo esc_attr($$link);?>"/>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id($name);?>">Link Title: </label>
		<input class="widefat" style="background:#fff;" id="<?php echo $this->get_field_id($name);?>" name="<?php echo $this->get_field_name($name);?>" value="<?php if(isset($$name)) echo esc_attr($$name);?>"/>
		</p>
		<?php
		}?>
		<?php
	}
	
	//Displaying The Data To Widget

	public function widget($args,$instance){
		extract($args);
		extract($instance);
		$title = apply_filters('widget_title',$title);
		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo '<ul>';
		for($i=0;$i<$numB;$i++)
		{
		$count=$i+1;
		$target = 'iT'.$count;
		$link = 'iLink'.$count;
		$name = 'iName'.$count;
		if(empty($$name)) return false;

		//Determining Whether To Open In New Window Or Not
		if($$target == 1) {
				$tar = 'target="_blank" ';
			}else{
				$tar = '';
			}
		echo '<li><a '.$tar.'href="'.esc_attr($$link).'">'.esc_attr($$name).'</a></li>';
		}
		echo '</ul>';
		echo $after_widget;
	
	}
}
add_action('widgets_init','register_iCLW');
function register_iCLW(){
	register_widget('iCLW');
}