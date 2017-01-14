<?php 
add_action('widgets_init', 'news_load_widgets');

function news_load_widgets(){
	register_widget('news_load_widgets');
}

class News_Load_Widgets extends WP_Widget
{

	public function __construct()
	{
		parent::__construct(
			'news_widgets_appic', //widget ID
			'Appic: Subscribe to News', //Name of the widget
			array( 'description' => 'News' ) //Options
		);
	}

	public function widget( $args, $instance )
	{
		extract($args);
		$title = $instance['title'];
		$description = $instance['description'];
		$form = $instance['form'];
		$phone = $instance['phone'];
		$email = $instance['email'];
		$address = $instance['address'];

		$output  = '<h3 class="widget-title">'.$title.'</h3>' .
			'<p class="pull-left">'.$description.'</p>' .
			do_shortcode($form) .
			'<div class="clearfix"></div>' .
			'<address>';
				if(!empty($phone)){
					$output .= '<span class="widget-news-phone">'.$phone.'</span>';
				}
				
				if(!empty($email)){
					$output .= '<span class="widget-news-email"><a href="mailto:'.$email.'">'.$email.'</a></span>';
				}
				
				if(!empty($address)){
					$output .= '<span class="widget-news-address">'.$address.'</span>';
				}
			
			$output .= '</address>';
		echo $output;
	}

	public function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		$instance['title']           = $new_instance['title'];
		$instance['description']     = $new_instance['description'];
		$instance['form']            = $new_instance['form'];
		$instance['phone']           = $new_instance['phone'];
		$instance['email']           = $new_instance['email'];
		$instance['address']         = $new_instance['address'];

		return $instance;
	}

	public function form( $instance )
	{
		$defaults = array(
			'title' => '',
			'description' => '',
			'form' => '',
			'phone' => '',
			'email' => '',
			'address' => ''
		);
		$instance = wp_parse_args((array) $instance, $defaults);

		$output = '<p>' .
				'<label for="' . $this->get_field_id('title') . '">' . __('Title:', 'appic') . '</label><br>' .
				'<input class="widefat" style="width: 100%;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" value="' . $instance['title'] . '" />' .
			'</p>' .
			'<p>' .
				'<label for="' . $this->get_field_id('description') . '">' . __('Description:', 'appic') . '</label><br>' .
				'<textarea class="widefat" style="width: 100%;" id="' . $this->get_field_id('description') . '" name="' . $this->get_field_name('description') . '">' . $instance['description'] . '</textarea>' .
			'</p>' .
			'<p>' .
				'<label for="' . $this->get_field_id('form') . '">' . __('Form shortcode (Contact Form 7 or Mailchimp):', 'appic') . '</label><br>' .
				'<textarea class="widefat" style="width: 100%;" id="' . $this->get_field_id('form') . '" name="' . $this->get_field_name('form') . '">' . $instance['form'] . '</textarea>' .
			'</p>' .
			'<p>' .
				'<label for="' . $this->get_field_id('phone') . '">' . __('Phone:', 'appic') . '</label><br>' .
				'<input class="widefat" style="width: 100%;" id="' . $this->get_field_id('phone') . '" name="' . $this->get_field_name('phone') . '" value="' . $instance['phone'] . '" />' .
			'</p>' .
			'<p>' .
				'<label for="' . $this->get_field_id('email') . '">' . __('Email:', 'appic') . '</label><br>' .
				'<input class="widefat" style="width: 100%;" id="' . $this->get_field_id('email') . '" name="' . $this->get_field_name('email') . '" value="' . $instance['email'] . '" />' .
			'</p>' .
			'<p>' .
				'<label for="' . $this->get_field_id('address') . '">' . __('Address:', 'appic') . '</label><br>' .
				'<input class="widefat" style="width: 100%;" id="' . $this->get_field_id('address') . '" name="' . $this->get_field_name('address') . '" value="' . $instance['address'] . '" />' .
			'</p>';
		echo $output;
	}
}
