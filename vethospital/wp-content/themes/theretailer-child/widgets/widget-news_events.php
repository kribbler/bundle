<?php

class wp_news_events_widget extends WP_Widget {

function __construct() {
	parent::__construct(
	// Base ID of your widget
	'wp_news_events_widget', 
	
	// Widget name will appear in UI
	__('News & Events Widget', 'wp_news_events_widget_domain'), 
	
	// Widget description
	array( 'description' => __( 'News & Events Widget', 'wp_news_events_widget_domain' ), ) 
	);
	}
	
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		//if ( ! empty( $title ) )
		//echo $args['before_title'] . $title . $args['after_title'];
		?>
		<div class="w_news_events">
			<img src="<?php echo $instance['news1_image'];?>" />
			<h1><a href="<?php echo $instance['news1_link'];?>"><?php echo $instance['news1_title'];?></a></h1>
		</div>
		<div class="w_news_events">
			<img src="<?php echo $instance['news2_image'];?>" />
			<h1><a href="<?php echo $instance['news2_link'];?>"><?php echo $instance['news2_title'];?></a></h1>
		</div>
		<?php
		echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			//$title = __( '', 'wpb_widget_domain' );
		}
		
		if ( isset( $instance['news1_title'] ) ){
			$news1_title = $instance[ 'news1_title' ];
		}
		
		if ( isset( $instance['news1_link'] ) ){
			$news1_link = $instance[ 'news1_link' ];
		}
	
		if ( isset( $instance['news1_image'] ) ){
			$news1_image = $instance[ 'news1_image' ];
		}
		
		if ( isset( $instance['news2_title'] ) ){
			$news2_title = $instance[ 'news2_title' ];
		}
		
		if ( isset( $instance['news2_link'] ) ){
			$news2_link = $instance[ 'news2_link' ];
		}
	
		if ( isset( $instance['news2_image'] ) ){
			$news2_image = $instance[ 'news2_image' ];
		}
		
		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		
		<label for="<?php echo $this->get_field_id( 'news1_title' ); ?>">Title 1</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'news1_title' ); ?>" name="<?php echo $this->get_field_name( 'news1_title' ); ?>" type="text" value="<?php echo esc_attr( $news1_title ); ?>" />
		<label for="<?php echo $this->get_field_id( 'news1_link' ); ?>">Link 1</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'news1_link' ); ?>" name="<?php echo $this->get_field_name( 'news1_link' ); ?>" type="text" value="<?php echo esc_attr( $news1_link ); ?>" />
		<label for="<?php echo $this->get_field_id( 'news1_image' ); ?>">Image 1</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'news1_image' ); ?>" name="<?php echo $this->get_field_name( 'news1_image' ); ?>" type="text" value="<?php echo esc_attr( $news1_image ); ?>" />
		
		<label for="<?php echo $this->get_field_id( 'news2_title' ); ?>">Title 2</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'news2_title' ); ?>" name="<?php echo $this->get_field_name( 'news2_title' ); ?>" type="text" value="<?php echo esc_attr( $news2_title ); ?>" />
		<label for="<?php echo $this->get_field_id( 'news2_link' ); ?>">Link 2</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'news2_link' ); ?>" name="<?php echo $this->get_field_name( 'news2_link' ); ?>" type="text" value="<?php echo esc_attr( $news2_link ); ?>" />
		<label for="<?php echo $this->get_field_id( 'news2_image' ); ?>">Image 2</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'news2_image' ); ?>" name="<?php echo $this->get_field_name( 'news2_image' ); ?>" type="text" value="<?php echo esc_attr( $news2_image ); ?>" />
		
		</p>
		<?php 
	}
		
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['news1_title'] = ( ! empty( $new_instance['news1_title'] ) ) ? $new_instance['news1_title'] : '';
		$instance['news1_link'] = ( ! empty( $new_instance['news1_link'] ) ) ? $new_instance['news1_link'] : '';
		$instance['news1_image'] = ( ! empty( $new_instance['news1_image'] ) ) ? $new_instance['news1_image'] : '';
		$instance['news2_title'] = ( ! empty( $new_instance['news2_title'] ) ) ? $new_instance['news2_title'] : '';
		$instance['news2_link'] = ( ! empty( $new_instance['news2_link'] ) ) ? $new_instance['news2_link'] : '';
		$instance['news2_image'] = ( ! empty( $new_instance['news2_image'] ) ) ? $new_instance['news2_image'] : '';
		return $instance;
	}
} 

// Register and load the widget
function wp_news_events_load_widget() {
	register_widget( 'wp_news_events_widget' );
}
add_action( 'widgets_init', 'wp_news_events_load_widget' );
