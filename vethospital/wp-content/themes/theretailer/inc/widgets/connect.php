<?php

add_action( 'widgets_init', 'my_widget' );

function my_widget() {
	register_widget( 'MY_Widget' );
}

class MY_Widget extends WP_Widget {

	function MY_Widget() {
		$widget_ops = array( 'classname' => 'the_retailer_connect', 'description' => __('A widget that displays customized social icons ', 'theretailer') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'the_retailer_connect' );
		
		$this->WP_Widget( 'the_retailer_connect', __('The Retailer Connect', 'theretailer'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$facebook = $instance['facebook'];
		$pinterest = $instance['pinterest'];
		$linkedin = $instance['linkedin'];
		$twitter = $instance['twitter'];
		$googleplus = $instance['googleplus'];
		$rss = $instance['rss'];
		$tumblr = $instance['tumblr'];
		$instagram = $instance['instagram'];
		
		echo $before_widget;

		// Display the widget title 
		if ( $title ) echo $before_title . $title . $after_title;

		//Display icons
		if ( $facebook ) echo('<a href="' . $facebook . '" target="_blank" class="widget_connect_facebook">Facebook</a>' );
		if ( $pinterest ) echo('<a href="' . $pinterest . '" target="_blank" class="widget_connect_pinterest">Pinterest</a>' );
		if ( $linkedin ) echo('<a href="' . $linkedin . '" target="_blank" class="widget_connect_linkedin">Linkedin</a>' );
		if ( $twitter ) echo('<a href="' . $twitter . '" target="_blank" class="widget_connect_twitter">Twitter</a>' );
		if ( $googleplus ) echo('<a href="' . $googleplus . '" target="_blank" class="widget_connect_googleplus">Google+</a>' );
		if ( $rss ) echo('<a href="' . $rss . '" target="_blank" class="widget_connect_rss">RSS</a>' );
		if ( $tumblr ) echo('<a href="' . $tumblr . '" target="_blank" class="widget_connect_tumblr">Tumblr</a>' );
		if ( $instagram ) echo('<a href="' . $instagram . '" target="_blank" class="widget_connect_instagram">Instagram</a>' );
		
		echo $after_widget;
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['pinterest'] = strip_tags( $new_instance['pinterest'] );
		$instance['linkedin'] = strip_tags( $new_instance['linkedin'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['googleplus'] = strip_tags( $new_instance['googleplus'] );
		$instance['rss'] = strip_tags( $new_instance['rss'] );
		$instance['tumblr'] = strip_tags( $new_instance['tumblr'] );
		$instance['instagram'] = strip_tags( $new_instance['instagram'] );

		return $instance;
	}

	
	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 
			'title' => __('The Retailer Connect', 'theretailer'),
			'facebook' => '',
			'pinterest' => '',
			'linkedin' => '',
			'twitter' => '',
			'googleplus' => '',
			'rss' => '',
			'tumblr' => '',
			'instagram' => ''
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Widget title:', 'theretailer'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('Facebook URL', 'theretailer'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $instance['facebook']; ?>" class="widefat" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e('Pinterest URL', 'theretailer'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" value="<?php echo $instance['pinterest']; ?>" class="widefat" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e('LinkedIn URL', 'theretailer'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="<?php echo $instance['linkedin']; ?>" class="widefat" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Twitter URL', 'theretailer'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $instance['twitter']; ?>" class="widefat" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'googleplus' ); ?>"><?php _e('Google+ URL', 'theretailer'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'googleplus' ); ?>" name="<?php echo $this->get_field_name( 'googleplus' ); ?>" value="<?php echo $instance['googleplus']; ?>" class="widefat" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'rss' ); ?>"><?php _e('RSS URL', 'theretailer'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" value="<?php echo $instance['rss']; ?>" class="widefat" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'tumblr' ); ?>"><?php _e('Tumblr URL', 'theretailer'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'tumblr' ); ?>" name="<?php echo $this->get_field_name( 'tumblr' ); ?>" value="<?php echo $instance['tumblr']; ?>" class="widefat" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e('Instagram URL', 'theretailer'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" value="<?php echo $instance['instagram']; ?>" class="widefat" />
		</p>

	<?php
	}
}

?>