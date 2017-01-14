<?php

class wp_contact_details_widget extends WP_Widget {

function __construct() {
	parent::__construct(
	// Base ID of your widget
	'wp_contact_details_widget', 
	
	// Widget name will appear in UI
	__('Contact Details Widget', 'wp_contact_details_widget_domain'), 
	
	// Widget description
	array( 'description' => __( 'Contact Details Widget', 'wp_contact_details_widget_domain' ), ) 
	);
	}
	
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		//if ( ! empty( $title ) )
		//echo $args['before_title'] . $title . $args['after_title'];
		echo $instance['contact_content'];
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
		
		if ( isset( $instance['contact_content'] ) ){
			$contact_content = $instance[ 'contact_content' ];
		}
	
		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		<label for="<?php echo $this->get_field_id( 'contact_content' ); ?>">Contact Details Content</label>
		<textarea class="widefat" name="<?php echo $this->get_field_name( 'contact_content' ); ?>"><?php echo esc_attr( $contact_content ); ?></textarea>
		</p>
		<?php 
	}
		
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['contact_content'] = ( ! empty( $new_instance['contact_content'] ) ) ? $new_instance['contact_content'] : '';
		return $instance;
	}
} 

// Register and load the widget
function wp_contact_details_load_widget() {
	register_widget( 'wp_contact_details_widget' );
}
add_action( 'widgets_init', 'wp_contact_details_load_widget' );
