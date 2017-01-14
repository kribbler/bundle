<?php

// Widget Class
class qns_map_widget extends WP_Widget {


/* ------------------------------------------------
	Widget Setup
------------------------------------------------ */

	function qns_map_widget() {
		$widget_ops = array( 'classname' => 'map_widget', 'description' => __('Display a Google Map', 'qns') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'map_widget' );
		$this->WP_Widget( 'map_widget', __('Google Map Widget', 'qns'), $widget_ops, $control_ops );
	}


/* ------------------------------------------------
	Display Widget
------------------------------------------------ */
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );
		$map_address = $instance['map_address'];
		$map_description = $instance['map_description'];
		
		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		 } ?>
		
		<?php
		
		if ( $map_address ) {
			echo '<p>' . $map_description . '</p>';
		}
		
		if ( $map_address ) {
			echo do_shortcode('[googlemap height="200px" address="' . $map_address . '"]');
		}
		
		?>

		<?php
		
		echo $after_widget;
	}	
	
	
/* ------------------------------------------------
	Update Widget
------------------------------------------------ */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['map_address'] = strip_tags( $new_instance['map_address'] );
		$instance['map_description'] = $new_instance['map_description'];
		return $instance;
	}
	
	
/* ------------------------------------------------
	Widget Input Form
------------------------------------------------ */
	 
	function form( $instance ) {
		$defaults = array(
		'title' => 'Map',
		'map_address' => '',
		'map_description' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'qns'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'map_address' ); ?>"><?php _e('Map Address (e.g. 123 Main Road, London, UK):', 'qns') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('map_address'); ?>" name="<?php echo $this->get_field_name('map_address'); ?>" value="<?php echo $instance['map_address']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'map_description' ); ?>"><?php _e('Map Description:', 'qns') ?></label>
			<textarea id="<?php echo $this->get_field_id('map_description'); ?>" class="widefat" name="<?php echo $this->get_field_name('map_description'); ?>"><?php echo $instance['map_description']; ?></textarea>
		</p>
		
	<?php
	}	
	
}

// Add widget function to widgets_init
add_action( 'widgets_init', 'qns_map_widget' );

// Register Widget
function qns_map_widget() {
	register_widget( 'qns_map_widget' );
}