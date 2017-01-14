<?php
/**
 * A widget that displays the reservation form and passes the data to Step 1
 */
class Quitenicebooking_Reservation_Form_Widget extends WP_Widget {
	
	/**
	 * Constructor
	 */
	public function __construct() {
		// widget setup
		$widget_ops = array(
			'classname' => 'reservations_widget',
			'description' => __('Display A Reservation Form', 'quitenicebooking')
		);
		$control_ops = array(
			'width' => 300,
			'height' => 350,
			'id_base' => 'reservations_widget'
		);
		parent::__construct('reservations_widget', __('Reservation Form Widget', 'quitenicebooking'), $widget_ops, $control_ops );
	}
	
	/**
	 * Outputs content of the widget
	 * 
	 * @param type $args
	 * @param type $instance
	 */
	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		
		echo $before_widget;
		if ($title) {
			echo $before_title.$title.$after_title;
		}
		$quitenicebooking_settings = get_option('quitenicebooking');
		include QUITENICEBOOKING_PATH.'views/reservation_form_widget.htm.php';
		echo $after_widget;
	}
	
	/**
	 * Outputs the options form on admin
	 * 
	 * @param type $instance
	 */	
	public function form($instance) {
		$defaults = array(
			'title' => 'Reservations'
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'quitenicebooking'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<?php
	}
	
	/**
	 * Processes widget options to be saved
	 * 
	 * @param type $new_instance
	 * @param type $old_instance
	 */
	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
}