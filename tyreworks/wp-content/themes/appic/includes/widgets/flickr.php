<?php
add_action('widgets_init', 'flickr_load_widgets');

function flickr_load_widgets()
{
	register_widget('Flickr_Widget');
}

class Flickr_Widget extends WP_Widget
{
	public function __construct()
	{
		parent::__construct(
			'flickr-widget', //widget ID
			'Appic: Flickr' //Name of the widget
		);
	}
	
	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		
		echo '<ul class="flickr"></ul>';
		
		echo $after_widget;
		
		$number = !empty($instance['number']) ? $instance['number'] : '10';
		$flickr_id = !empty($instance['flickr_id']) ? $instance['flickr_id'] : '52617155@N08';
		
		wp_register_script('flickr', PARENT_URL . '/scripts/vendor/jflickrfeed.js', array('jquery'));
		wp_enqueue_script('flickr');
		wp_enqueue_script('colorbox');

		JsClientScript::addScript('init-flickr-widget',
			'$(".flickr").jflickrfeed({' .
				'limit:' . $number .', qstrings:{id:"' . $flickr_id .'"},' .
				'itemTemplate: \'<li><a href="{{image_b}}" data-rel="colorbox"><img src="{{image_s}}" alt="{{title}}" /><span class="hover-effect"></span></a></li>\'' .
			'},function(data){' .
				'jQuery(".flickr a").colorbox({"data-rel":"colorbox"});' .
			'});'
		);
	}

	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['flickr_id'] = $new_instance['flickr_id'];
		$instance['number'] = $new_instance['number'];

		return $instance;
	}

	public function form($instance)
	{
		$defaults = array('title' => 'Flickr Stream', 'flickr_id' => '', 'number' => '10');
		$instance = wp_parse_args((array) $instance, $defaults);
		$output = '<p>' .
				'<label for="' . $this->get_field_id('title') . '">' . __('Title:', 'appic') . '</label><br>' .
				'<input class="widefat" style="width: 100%;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" value="' . $instance['title'] . '" />' .
			'</p>' .
			'<p>' .
				'<label for="' . $this->get_field_id('flickr_id') . '">' . __('Flickr User or Group ID:', 'appic') . '</label><br>' .
				'<input class="widefat" style="width: 100%;" id="' . $this->get_field_id('flickr_id') . '" name="' . $this->get_field_name('flickr_id') . '" value="' . $instance['flickr_id'] . '" />' .
			'</p>' .
			'<p>' .
				'<label for="' . $this->get_field_id('number') . '">' . __('Images to show', 'appic') . '</label>' .
				'<input type="number" min="1" max="20" id="' . $this->get_field_id('number') . '" name="' . $this->get_field_name('number') . '" value="' . $instance['number'] . '" size="2">' .
				'<small>Max: 20</small>' .
			'</p>';
		echo $output;
	}
}
