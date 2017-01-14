<?php

class wp_opening_hours_widget extends WP_Widget {

function __construct() {
	parent::__construct(
	// Base ID of your widget
	'wp_opening_hours_widget', 
	
	// Widget name will appear in UI
	__('Opening Hours Widget', 'wp_opening_hours_widget_domain'), 
	
	// Widget description
	array( 'description' => __( 'Opening Hours Widget', 'wp_opening_hours_widget_domain' ), ) 
	);
	}
	
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		//if ( ! empty( $title ) )
		//echo $args['before_title'] . $title . $args['after_title'];
		echo $instance['opening_content'];
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
		
		if ( isset( $instance['opening_content'] ) ){
			$opening_content = $instance[ 'opening_content' ];
		}
	
		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		<label for="<?php echo $this->get_field_id( 'opening_content' ); ?>">Opening Hours Content</label>
		<textarea class="widefat" name="<?php echo $this->get_field_name( 'opening_content' ); ?>"><?php echo esc_attr( $opening_content ); ?></textarea>
		</p>
		<?php 
	}
		
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['opening_content'] = ( ! empty( $new_instance['opening_content'] ) ) ? $new_instance['opening_content'] : '';
		return $instance;
	}
} 

// Register and load the widget
function wp_opening_hours_load_widget() {
	register_widget( 'wp_opening_hours_widget' );
}
add_action( 'widgets_init', 'wp_opening_hours_load_widget' );
