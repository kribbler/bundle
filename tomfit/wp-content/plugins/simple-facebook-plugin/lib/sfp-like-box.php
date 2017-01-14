<?php
/**
* Main Facebook Like Box Social Plagin File. Creates widget, shortcode and template tag.
*
* @package SF Plugin
* @author Ilya K.
*/

/**
* Like Box Widget Class
*
* Contains the main functions for SF and stores variables
*
* @since SF Plugin 1.0
* @author Ilya K.
*/

class SFPLikeBoxWidget extends WP_Widget {
	
	/**
	 * Register widget with WordPress
	 */
	function SFPLikeBoxWidget() {
		$widget_ops = array( 'description' => 'Display Facebook Like Box' );
		parent::WP_Widget( 'facebookwidget', $name = 'SFP - Like Box',  $widget_ops);
	}

	/**
	 * Front-end
	 */
	function widget( $args, $instance ) {
		
		global $sfplugin;

		// Add-ons hook
		$instance = apply_filters( "sfp_before_like_box", $instance, $this, $sfplugin );
		do_action( "sfp_before_like_box", $args, $instance, $this, $sfplugin );

		// extract user options
		extract( $args );
		extract( $instance );
		
		// Stnadar WP output
		echo $before_widget;
		
		// check for title
		$title = apply_filters( 'widget_title', $title );
		if ( ! empty( $title ) ) echo $before_title . $title . $after_title;
		
		// include Like Box view
		include( $sfplugin->pluginPath . 'views/view-like-box.php' );

		// Add-ons hook
		do_action("sfp_after_like_box", $args, $instance, $this, $sfplugin );
		
		// Stnadar WP output
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved
	 */
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		// save new options
		$instance['title']			= strip_tags( $new_instance['title'] );
		$instance['url'] 			= strip_tags( $new_instance['url'] );
		$instance['width']			= strip_tags( $new_instance['width'] );
		$instance['height']			= strip_tags( $new_instance['height'] );
		$instance['colorscheme']	= strip_tags( $new_instance['colorscheme'] );
		$instance['local']			= strip_tags( $new_instance['local'] );
		$instance['faces']			= isset( $new_instance['faces'] );
		$instance['stream']			= isset( $new_instance['stream'] );
		$instance['header']			= isset( $new_instance['header'] );
		$instance['border']			= isset( $new_instance['border'] );
	
		// Add-ons hook
		apply_filters( 'sfp_like_box_widget_update', $instance, $new_instance, $old_instance );
		
		return $instance;
	}

	/**
	 * Back-end form
	 */
	function form( $instance ) {

		global $sfplugin;
		
		$default = array(
			// default options
			'title'			=> 'Our Facebook Page',
			'url'			=> 'http://www.facebook.com/wordpress',
			'width'			=> '292',
			'height'		=> '',
			'colorscheme' 	=> 'light',
			'faces'			=> true,
			'stream'		=> false,
			'header'		=> true,
			'border'		=> true,
			'local'			=> 'en_US'
		);

		// Add-ons hook
		//$instance = apply_filters( 'sfp_like_box_form', $instance, $default, $this, $sfplugin );

		extract( array_merge( $default, $instance ) ); ?>

		<?php 
			// Add-ons hook
			do_action( "sfp_like_box_widget_form_start", $instance, $this, $sfplugin );
		?>
			
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Facebook Page URL:'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
		</p>
		<table>
			<tr><td>
				<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Like Box width:'); ?></label> 
				</td><td>
				<input size="6" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" />px
			</td></tr>
			<tr><td>
				<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Like Box height:'); ?></label> 
				</td><td>
				<input size="6" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" />px
			</td></tr>
			<?php 
				// Add-ons hook
				do_action( "sfp_like_box_widget_form_after_inputs", $instance, $this, $sfplugin );
			?>
			<tr><td>
				&nbsp;
			</td></tr>
			<tr><td>
				<label for="<?php echo $this->get_field_id('colorschme'); ?>"><?php _e('Color Scheme:'); ?></label> 
				</td><td>
				<input type="radio" name="<?php echo $this->get_field_name('colorscheme'); ?>" value="light" <?php checked(($colorscheme == 'light') ? 1 : 0); ?>/> Light<br />
				<input type="radio" name="<?php echo $this->get_field_name('colorscheme'); ?>" value="dark" <?php checked(($colorscheme == 'dark') ? 1 : 0); ?>/> Dark
			</td></tr>
			<tr><td>
				&nbsp;
			</td></tr>
			<tr><td>
				<label for="<?php echo $this->get_field_id('faces'); ?>"><?php _e('Show Faces'); ?></label> 
				</td><td>
				<input id="<?php echo $this->get_field_id('faces'); ?>" type="checkbox" name="<?php echo $this->get_field_name('faces'); ?>" <?php checked(isset($faces) ? $faces : 0); ?>/>
			</td></tr>
			<tr><td>
				<label for="<?php echo $this->get_field_id('stream'); ?>"><?php _e('Show Stream'); ?></label> 
				</td><td>
				<input id="<?php echo $this->get_field_id('stream'); ?>" type="checkbox" name="<?php echo $this->get_field_name('stream'); ?>" <?php checked(isset($stream) ? $stream : 0); ?>/>
			</td></tr>
			<tr><td>
				<label for="<?php echo $this->get_field_id('header'); ?>"><?php _e('Show Header'); ?></label> 
				</td><td>
				<input id="<?php echo $this->get_field_id('header'); ?>" type="checkbox" name="<?php echo $this->get_field_name('header'); ?>" <?php checked(isset($header) ? $header : 0); ?>/> 
			</td></tr>
			<tr><td>
				<label for="<?php echo $this->get_field_id('border'); ?>"><?php _e('Show Border'); ?></label> 
				</td><td>
				<input id="<?php echo $this->get_field_id('border'); ?>" type="checkbox" name="<?php echo $this->get_field_name('border'); ?>" <?php checked(isset($border) ? $border : 0); ?>/> 
			</td></tr>
			<?php 
				// Add-ons hook
				do_action("sfp_like_box_widget_form_after_checkboxes", $instance, $this, $sfplugin );
			?>
		</table>
		<br/>
		<p>
			<label for="<?php echo $this->get_field_id('local'); ?>"><?php _e('Language'); ?></label> 
			<select name="<?php echo $this->get_field_name('local'); ?>">
			<?php foreach ( $sfplugin->locales as $code => $name ) : ?>
				<option <?php selected(( $local == $code) ? 1 : 0); ?> value="<?php echo $code; ?>" ><?php echo $name; ?></option>
			<?php endforeach; ?>
			</select>
		</p>
		<?php 
			do_action( "sfp_like_box_widget_form_end", $instance, $this, $sfplugin );
		?>

	<?php }
	
} // class SFPLikeBoxWidget

/**
 * Add Like Box 'Shortcode'
 *
 * @since SF Plugin 1.2
 * @author Ilya K.
 */

function sfp_like_box_shortcode ( $instance ) {

	global $sfplugin;

	$instance = ( !$instance ) ? array() : $instance;

	// Add-ons hook
	$instance = apply_filters( "sfp_before_like_box", $instance, $sfplugin );

	extract( array_merge( array(
			// default options
			'url'			=> 'http://www.facebook.com/wordpress',
			'width'			=> '292',
			'height'		=> '',
			'colorscheme' 	=> 'light',
			'faces'			=> true,
			'stream'		=> false,
			'header'		=> true,
			'border'		=> true,
			'local'			=> 'en_US'
	), $instance ) );

	ob_start();

	// include Like Box view
	include( $sfplugin->pluginPath . 'views/view-like-box.php' );

	return ob_get_clean();
}


/**
* Add Like Box 'Template Tag'
* 
* @since SF Plugin 1.2
* @author Ilya K.
*/

function sfp_like_box ( $instance = array() ) { 
	
	global $sfplugin;

	// Add-ons hook
	$instance = apply_filters( "sfp_before_like_box", $instance, $sfplugin );
	
	extract( array_merge( array(
		// default options
		'url'			=> 'http://www.facebook.com/wordpress',
		'width'			=> '292',
		'height'		=> '',
		'colorscheme' 	=> 'light',
		'faces'			=> true,
		'stream'		=> false,
		'header'		=> true,
		'border'		=> true,
		'local'			=> 'en_US'
	), $instance ) );
	
	// include Like Box view
	include( $sfplugin->pluginPath . 'views/view-like-box.php' );
}

?>