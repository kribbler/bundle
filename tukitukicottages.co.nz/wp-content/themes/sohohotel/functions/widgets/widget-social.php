<?php

// Widget Class
class qns_social_widget extends WP_Widget {


/* ------------------------------------------------
	Widget Setup
------------------------------------------------ */

	function qns_social_widget() {
		$widget_ops = array( 'classname' => 'social_widget', 'description' => __('Display Your Social Networks', 'qns') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'social_widget' );
		$this->WP_Widget( 'social_widget', __('Custom Social Widget', 'qns'), $widget_ops, $control_ops );
	}


/* ------------------------------------------------
	Display Widget
------------------------------------------------ */
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );
		$social_facebook = $instance['social_facebook'];	
		$social_twitter = $instance['social_twitter'];	
		$social_pinterest = $instance['social_pinterest'];
		$social_gplus = $instance['social_gplus'];
		$social_linkedin = $instance['social_linkedin'];
		$social_yelp = $instance['social_yelp'];
		$social_instagram = $instance['social_instagram'];
		
		echo $before_widget;

		if ( $title ) {
			//echo $before_title . $title . $after_title;
			echo $before_title . $title . $after_title;
		 } ?>

			<ul class="social-icons clearfix">
				
				<?php if($social_facebook != '') { ?>
					<li><a target="_blank" href="<?php echo $social_facebook; ?>"><span class="facebook-icon"></span></a></li>
				<?php } ?>
				
				<?php if($social_twitter != '') { ?>
					<li><a target="_blank" href="<?php echo $social_twitter; ?>"><span class="twitter-icon"></span></a></li>
				<?php } ?>
				
				<?php if($social_pinterest != '') { ?>
					<li><a target="_blank" href="<?php echo $social_pinterest; ?>"><span class="pinterest-icon"></span></a></li>
				<?php } ?>
				
				<?php if($social_gplus != '') { ?>
					<li><a target="_blank" href="<?php echo $social_gplus; ?>"><span class="gplus-icon"></span></a></li>
				<?php } ?>
				
				<?php if($social_linkedin != '') { ?>
					<li><a target="_blank" href="<?php echo $social_linkedin; ?>"><span class="linkedin-icon"></span></a></li>
				<?php }?>
				
				<?php if($social_yelp != '') { ?>
					<li><a target="_blank" href="<?php echo $social_yelp; ?>"><span class="yelp-icon"></span></a></li>
				<?php }?>
				
				<?php if($social_instagram != '') { ?>
					<li><a target="_blank" href="<?php echo $social_instagram; ?>"><span class="instagram-icon"></span></a></li>
				<?php }?>
				
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
		$instance['social_facebook'] = strip_tags( $new_instance['social_facebook'] );
		$instance['social_twitter'] = strip_tags( $new_instance['social_twitter'] );
		$instance['social_pinterest'] = strip_tags( $new_instance['social_pinterest'] );
		$instance['social_gplus'] = strip_tags( $new_instance['social_gplus'] );
		$instance['social_linkedin'] = strip_tags( $new_instance['social_linkedin'] );
		$instance['social_yelp'] = strip_tags( $new_instance['social_yelp'] );
		$instance['social_instagram'] = strip_tags( $new_instance['social_instagram'] );
		return $instance;
	}
	
	
/* ------------------------------------------------
	Widget Input Form
------------------------------------------------ */
	 
	function form( $instance ) {
		$defaults = array(
		'title' => 'Social Media',
		'social_facebook' => '',
		'social_twitter' => '',
		'social_pinterest' => '',
		'social_gplus' => '',
		'social_linkedin' => '',
		'social_yelp' => '',
		'social_instagram' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'qns'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'social_facebook' ); ?>"><?php _e('Facebook URL:', 'qns') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('social_facebook'); ?>" name="<?php echo $this->get_field_name('social_facebook'); ?>" value="<?php echo $instance['social_facebook']; ?>" />
		</p>
	
		<p>
			<label for="<?php echo $this->get_field_id( 'social_twitter' ); ?>"><?php _e('Twitter URL:', 'qns') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('social_twitter'); ?>" name="<?php echo $this->get_field_name('social_twitter'); ?>" value="<?php echo $instance['social_twitter']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'social_pinterest' ); ?>"><?php _e('Pinterest URL:', 'qns') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('social_pinterest'); ?>" name="<?php echo $this->get_field_name('social_pinterest'); ?>" value="<?php echo $instance['social_pinterest']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'social_gplus' ); ?>"><?php _e('Google Plus URL:', 'qns') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('social_gplus'); ?>" name="<?php echo $this->get_field_name('social_gplus'); ?>" value="<?php echo $instance['social_gplus']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'social_linkedin' ); ?>"><?php _e('Linkedin URL:', 'qns') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('social_linkedin'); ?>" name="<?php echo $this->get_field_name('social_linkedin'); ?>" value="<?php echo $instance['social_linkedin']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'social_yelp' ); ?>"><?php _e('Yelp URL:', 'qns') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('social_yelp'); ?>" name="<?php echo $this->get_field_name('social_yelp'); ?>" value="<?php echo $instance['social_yelp']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'social_instagram' ); ?>"><?php _e('Instagram URL:', 'qns') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('social_instagram'); ?>" name="<?php echo $this->get_field_name('social_instagram'); ?>" value="<?php echo $instance['social_instagram']; ?>" />
		</p>
		
	<?php
	}	
	
}

// Add widget function to widgets_init
add_action( 'widgets_init', 'qns_social_widget' );

// Register Widget
function qns_social_widget() {
	register_widget( 'qns_social_widget' );
}