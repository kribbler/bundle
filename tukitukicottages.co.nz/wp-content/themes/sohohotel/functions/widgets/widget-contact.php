<?php

// Widget Class
class qns_contact_widget extends WP_Widget {


/* ------------------------------------------------
	Widget Setup
------------------------------------------------ */

	function qns_contact_widget() {
		$widget_ops = array( 'classname' => 'contact_widget', 'description' => __('Display Contact Details', 'qns') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'contact_widget' );
		$this->WP_Widget( 'contact_widget', __('Contact Widget', 'qns'), $widget_ops, $control_ops );
	}


/* ------------------------------------------------
	Display Widget
------------------------------------------------ */
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );
		$contact_phone = $instance['contact_phone'];
		$contact_fax = $instance['contact_fax'];
		$contact_email = $instance['contact_email'];
		$contact_address = $instance['contact_address'];
		
		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		 } ?>
		
		<ul class="contact_details_list">		
			<?php if ($contact_phone != '') {echo '<li class="phone_list"><strong>' . __('Phone','qns') . ':</strong> ' . $instance['contact_phone'] . '</li>';} ?>
			<?php if ($contact_fax != '') {echo '<li class="fax_list"><strong>' . __('Fax','qns') . ':</strong> '. $instance['contact_fax'] . '</li>';} ?>
			<?php if ($contact_email != '') {echo '<li class="email_list"><strong>' . __('Email','qns') . ':</strong> <a href="mailto:'.$instance['contact_email'].'">'. $instance['contact_email'] . '</a></li>';} ?>
			<?php if ($contact_address != '') {echo '<li class="address_list"><strong>' . __('Address','qns') . ':</strong> '. $instance['contact_address'] . '</li>';} ?>
		</ul>

		<?php
		
		echo $after_widget;
	}	
	
	
/* ------------------------------------------------
	Update Widget
------------------------------------------------ */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['contact_phone'] = strip_tags( $new_instance['contact_phone'] );
		$instance['contact_fax'] = strip_tags( $new_instance['contact_fax'] );
		$instance['contact_email'] = strip_tags( $new_instance['contact_email'] );
		$instance['contact_address'] = strip_tags( $new_instance['contact_address'] );
		return $instance;
	}
	
	
/* ------------------------------------------------
	Widget Input Form
------------------------------------------------ */
	 
	function form( $instance ) {
		$defaults = array(
		'title' => 'Contact Details',
		'contact_phone' => '',
		'contact_email' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'qns'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'contact_phone' ); ?>"><?php _e('Phone Number:', 'qns') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('contact_phone'); ?>" name="<?php echo $this->get_field_name('contact_phone'); ?>" value="<?php echo $instance['contact_phone']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'contact_fax' ); ?>"><?php _e('Fax Number:', 'qns') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('contact_fax'); ?>" name="<?php echo $this->get_field_name('contact_fax'); ?>" value="<?php echo $instance['contact_fax']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'contact_email' ); ?>"><?php _e('Email Address:', 'qns') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('contact_email'); ?>" name="<?php echo $this->get_field_name('contact_email'); ?>" value="<?php echo $instance['contact_email']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'contact_address' ); ?>"><?php _e('Address/Location:', 'qns') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('contact_address'); ?>" name="<?php echo $this->get_field_name('contact_address'); ?>" value="<?php echo $instance['contact_address']; ?>" />
		</p>
		
	<?php
	}	
	
}

// Add widget function to widgets_init
add_action( 'widgets_init', 'qns_contact_widget' );

// Register Widget
function qns_contact_widget() {
	register_widget( 'qns_contact_widget' );
}