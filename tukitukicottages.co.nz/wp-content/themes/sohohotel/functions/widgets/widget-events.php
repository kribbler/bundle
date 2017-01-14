<?php

// Widget Class
class qns_events_widget extends WP_Widget {


/* ------------------------------------------------
	Widget Setup
------------------------------------------------ */

	function qns_events_widget() {
		$widget_ops = array( 'classname' => 'events_widget', 'description' => __('Display Latest Events', 'qns') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'events_widget' );
		$this->WP_Widget( 'events_widget', __('Events Widget', 'qns'), $widget_ops, $control_ops );
	}


/* ------------------------------------------------
	Display Widget
------------------------------------------------ */
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );
		$events_count = $instance['events_count'];
		
		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		 } ?>
			
		<?php 
		if ($events_count != '') {
			$events_count = $instance['events_count'];
		} else {
			$events_count = '3';
		} ?>

		<?php global $post;  ?>

		<?php global $smof_data; // Get Theme Options ?>
		
		<?php $prefix = 'qns_'; 
			
			$args = array(
		
				'post_type' => 'event',
				'posts_per_page' => $events_count,
				'meta_key' => 'qns_event_date',
				'orderby' => 'meta_value',
				'order' => !empty($smof_data['event_order']) ? ($smof_data['event_order'] == 'Oldest First' ? 'ASC' : 'DESC') : 'ASC',
				'meta_query' => array(
					array(
						'key' => 'qns_event_date',
						'value' => !empty($smof_data['event_show_past']) ? 0 : date('Y-m-d'),
						'compare' => !empty($smof_data['event_show_past']) ? '>=' :'>=',
						'type' => 'DATE'
					)
				)
				
			);

			$loop = new WP_Query($args);

			if($loop->have_posts()) : ?>
			
			<ul class="event-list">
			
				<?php while($loop->have_posts()) : 
					$loop->the_post(); ?>

				<?php
					
					// Get event date
					$e_date = get_post_meta($post->ID, $prefix.'event_date', true);
					if ( $e_date !== '' ) { 									
						$event_date_string = $e_date;
						$event_monthM = mysql2date( 'M', $event_date_string );
						$event_day = mysql2date( 'd', $event_date_string );
						$event_month = apply_filters('get_the_date', $event_monthM, 'M');
					}
					
					// If no date set
					else { 
						$event_month = "---";
						$event_day = "00";
					}
					
					// Get event time
					$e_time = get_post_meta($post->ID, $prefix.'event_time', true);
					if ( $e_time !== '' ) { $event_time = $e_time; }
					else { $event_time = __('No time set','qns'); }
					
					// Get event location
					$e_location = get_post_meta($post->ID, $prefix.'event_location', true);
					if ( $e_location !== '' ) { $event_location = $e_location; }
					else { $event_location = __('No location set','qns'); }
				
				?>
				
				<!-- BEGIN .event-wrapper -->
				<li class="event-wrapper clearfix">
				
					<div class="event-date">
						<div class="event-m"><?php echo $event_month; ?></div>
						<div class="event-d"><?php echo $event_day; ?></div>	
					</div>
					
					<div class="event-info">	
						<div class="event-meta">
							<h4><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> &raquo;</a></h4>
							<p><?php echo $event_time; ?></p>
						</div>
					</div>
			
				<!-- END .event-wrapper -->
				</li>
	
			<?php endwhile; else : ?>

				<p><?php _e('No events have been added yet!','qns'); ?></p>
			
			</ul>
			
			<?php endif;
		
		echo $after_widget;
	}	
	
	
/* ------------------------------------------------
	Update Widget
------------------------------------------------ */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['events_count'] = strip_tags( $new_instance['events_count'] );
		return $instance;
	}
	
	
/* ------------------------------------------------
	Widget Input Form
------------------------------------------------ */
	 
	function form( $instance ) {
		$defaults = array(
		'title' => 'Events',
		'events_count' => '3'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'qns'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'events_count' ); ?>"><?php _e('Number of Events:', 'qns') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('events_count'); ?>" name="<?php echo $this->get_field_name('events_count'); ?>" value="<?php echo $instance['events_count']; ?>" />
		</p>
		
	<?php
	}	
	
}

// Add widget function to widgets_init
add_action( 'widgets_init', 'qns_events_widget' );

// Register Widget
function qns_events_widget() {
	register_widget( 'qns_events_widget' );
}