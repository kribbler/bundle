<?php
add_action('widgets_init', 'button_load_widgets');

function button_load_widgets()
{
	register_widget('button_load_widgets');
}

class Button_Load_Widgets extends WP_Widget
{

	public function __construct()
	{
		parent::__construct(
			'button_widgets_appic', //widget ID
			'Appic: Button', //Name of the widget
			array('description' => 'Button') //Options
		);
	}

	public function widget($args, $instance)
	{
		extract($args);
		$buttonText      = !empty($instance['buttonText'])       ? $instance['buttonText']       : '';
		$buttonLink      = !empty($instance['buttonLink'])       ? $instance['buttonLink']       : '';
		$buttonSize      = !empty($instance['buttonSize'])       ? $instance['buttonSize']       : '';
		$buttonStyle     = !empty($instance['buttonStyle'])      ? $instance['buttonStyle']      : '';
		$buttonTarger    = !empty($instance['buttonTarget'])     ? $instance['buttonTarget']     : '';

		echo '<div>' .
			'<a href="'.$buttonLink.'" class="btn btn-'.$buttonSize.' btn-'.$buttonStyle.'" target="'.$buttonTarger.'">' . $buttonText . '</a>' .
		'</div>' .
		'<div class="spacer"></div>';
	}

	public function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		$instance['buttonText']      = $new_instance['buttonText'];
		$instance['buttonLink']      = $new_instance['buttonLink'];
		$instance['buttonSize']      = $new_instance['buttonSize'];
		$instance['buttonStyle']     = $new_instance['buttonStyle'];
		$instance['buttonTarget']    = $new_instance['buttonTarget'];

		return $instance;
	}

	public function form( $instance )
	{
		$defaults = array(
			'buttonText' => '',
			'buttonLink' => '',
			'buttonSize' => '',
			'buttonStyle' => '',
			'buttonTarget' => '',
		);
		$instance = wp_parse_args((array) $instance, $defaults);

		$output = '<p>' .
				'<label for="' . $this->get_field_id('buttonText') . '">' . __('Button text:', 'appic') . '</label><br>' .
				'<input class="widefat" style="width: 100%;" id="' . $this->get_field_id('buttonText') . '" name="' . $this->get_field_name('buttonText') . '" value="' . $instance['buttonText'] . '" />' .
			'</p>' .
			'<p>' .
				'<label for="' . $this->get_field_id('buttonLink') . '">' . __('Button link:', 'appic') . '</label><br>' .
				'<input class="widefat" style="width: 100%;" id="' . $this->get_field_id('buttonLink') . '" name="' . $this->get_field_name('buttonLink') . '" value="' . $instance['buttonLink'] . '" />' .
			'</p>' .
			'<p>' .
				'<label for="' . $this->get_field_id('buttonSize') . '">' . __('Button size:', 'appic') . '</label><br>' .
				'<select class="widefat" style="width: 100%;" name="' . $this->get_field_name('buttonSize') . '">' .
					$this->render_options_html(array(
							'small' => __('Small', 'appic'),
							'large' => __('Large', 'appic'),
						),
						$instance['buttonSize']
					) .
				'</select>' .
			'</p>' .
			'<p>' .
				'<label for="' . $this->get_field_id('buttonStyle') . '">' . __('Button style:', 'appic') . '</label><br>' .
				'<select class="widefat" style="width: 100%;" name="' . $this->get_field_name('buttonStyle') . '">' .
					$this->render_options_html(array(
							'primary' => __('Primary', 'appic'),
							'info'    => __('Info', 'appic'),
							'danger'  => __('Danger', 'appic'),
							'grey'    => __('Grey', 'appic'),
							'success' => __('Success', 'appic'),
							'warning' => __('Warning', 'appic'),
						),
						$instance['buttonStyle']
					) .
				'</select>' .
			'</p>' .
			'<p>' .
				'<label for="' . $this->get_field_id('buttonTarget') . '">' . __('Button target:', 'appic') . '</label><br>' .
				'<select class="widefat" style="width: 100%;" name="' . $this->get_field_name('buttonTarget') . '">' .
					$this->render_options_html(array(
							'_blank'  => __('Blank', 'appic'),
							'_self'   => __('Self', 'appic'),
							'_parent' => __('Parent', 'appic'),
							'_top'    => __('Top', 'appic'),
						),
						$instance['buttonTarget']
					) .
				'</select>' .
			'</p>';
		echo $output;
	}

	private function render_options_html(array $options, $selectedValue = '')
	{
		$result = '';
		foreach ($options as $val => $label) {
			$selectedAttr = $val == $selectedValue ? ' selected="selected"' : '';
			$result .= '<option value="'.$val.'"' . $selectedAttr . '>'.$label.'</option>';
		}
		return $result;
	}
}
