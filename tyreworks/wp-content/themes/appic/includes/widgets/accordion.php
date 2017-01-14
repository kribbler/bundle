<?php 
add_action('widgets_init', 'accordion_load_widgets');

function accordion_load_widgets()
{
	register_widget('accordion_load_widgets');
}

class Accordion_Load_Widgets extends WP_Widget
{
	public function __construct()
	{
		parent::__construct(
			'accordion_widgets_appic', //widget ID
			'Appic: Accordion', //Name of the widget
			array( 'description' => 'Accordion' ) //Options
		);
	}
	
	public function widget( $args, $instance )
	{
		extract($args);
		
		$heading = $instance['heading'];
		
		$style = $instance['style'];
		
		echo '<div id="text-3">';
		if( !empty($heading) ){
			echo '<h3 class="page-elements-title">'.$heading.'</h3>';
		}
		echo '<div class="textwidget">';
		$id = self::generateId();
		if($style == 1) {
			echo '<div id="'.$id.'" class="accordion style-2">';
		} elseif($style == 2) {
			echo '<div id="'.$id.'" class="accordion">';
		} else {
			echo '<div id="'.$id.'" class="accordion style-3">';
		}
		
		for($i=1; $i<=5; $i++) {
			$itemTitle = $instance['title' . $i];
			$itemValue = $instance['body' . $i];
			
			if(empty($itemTitle) || empty($itemValue)){
				continue;
			}
			
			$itemId = $id .'_' . $i;
			echo '<div class="accordion-group">' .
				'<div class="accordion-heading">' .
					'<a class="accordion-toggle accordion-plus" href="#' . $itemId . '" data-parent="#'.$id.'" data-toggle="collapse">'.$itemTitle.'</a>' .
				'</div>' .
				'<div id="'.$itemId.'" class="accordion-body collapse">' .
					'<div class="accordion-inner"> '.$itemValue.' </div>' .
				'</div>' .
			'</div>';
		}
		
		echo '</div>';// end of #accordionX
		echo '</div>';// end of .textwidget
		echo '</div>';// end of #text-3
	}
	
	public function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		$keys = $this->_getFieldsList();
		
		foreach ($keys as $fieldName) {
			//$instance[$fieldName] = isset($new_instance[$fieldName]) ? $new_instance[$fieldName] : '';
			$instance[$fieldName] = $new_instance[$fieldName];
		}

		return $instance;
	}
	
	private function _getFieldsList()
	{
		static $keys;
		if (!$keys) {
			$keys = array('style', 'heading');
			for($i = 1; $i < 6; $i++) {
				$keys[] = 'title' .$i;
				$keys[] = 'body' .$i;
			}
		}
		return $keys;
	}

	public function form( $instance )
	{
		/* Set up some default widget settings. */
		$defaults = array(
			'style' => '',
			
			'heading' => '',
			
			'title1' => '',
			'body1' => '',
			
			'title2' => '',
			'body2' => '',
			
			'title3' => '',
			'body3' => '',
			
			'title4' => '',
			'body4' => '',
			
			'title5' => '',
			'body5' => ''
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<?php
			$title_name = "Title";
			$title_body = "Body";
			foreach($defaults as $key=>$name) :
				$pos_title = strripos($key, "title");
				$pos_body = strripos($key, "body");
				if($key == 'style') :
		?>
					<p>
						<label for="<?php echo $this->get_field_id('heading'); ?>"><?php echo __("Title widget", 'appic') ?></label><br>
						<input class="widefat" style="width: 100%;" id="<?php echo $this->get_field_id('heading'); ?>" name="<?php echo $this->get_field_name('heading'); ?>" value="<?php echo $instance['heading']; ?>" />
					</p>
					<hr>
					<p>
						<label for="<?php echo $this->get_field_id($key); ?>"><?php echo __('Style:', 'appic') ?></label><br>
						<select class="widefat" style="width: 100%"; name="<?php echo $this->get_field_name($key); ?>" id="<?php echo $this->get_field_id($key); ?>">
							<option value="1" <?php if($instance['style'] == 1) echo'selected="selected"'; ?> >Style 1</option>
							<option value="2" <?php if($instance['style'] == 2) echo'selected="selected"'; ?> >Style 2</option>
							<option value="3" <?php if($instance['style'] == 3) echo'selected="selected"'; ?> >Style 3</option>
						</select>
					</p>
					<hr> 
				<?php elseif( $pos_title == "true" ) : ?>
					<p>
						<label for="<?php echo $this->get_field_id($key); ?>"><?php echo __("Title", 'appic') ?></label><br>
						<input class="widefat" style="width: 100%;" id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" value="<?php echo $instance[$key]; ?>" />
					</p>
					<hr>
				<?php elseif( $pos_body == "true" ) : ?>
					<p>
						<label for="<?php echo $this->get_field_id($key); ?>"><?php echo __("Body", 'appic') ?></label><br>
						<textarea class="widefat" style="width: 100%;" id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" ><?php echo $instance[$key]; ?></textarea>
					</p>
					<hr> 
				<?php endif; ?>
			<?php endforeach; ?>
		<?php
	}

	static protected function generateId()
	{
		static $curId;
		if ($curId == null) {
			$curId = 0;
		}
		$curId++;
		return 'accordionW' . $curId;
	}
}
