<?php
/**
 * Plugin Name: Social Ribbon
 * Plugin URI: http://gsc-orillia.org
 * Description: A ribbon of social network links
 * Version: 0.6.5
 * Author: Jason McVeigh
 * Author URI: http://gsc-orillia.org
 * License: NGPL
 */

add_action( 'widgets_init', function(){
     register_widget( 'SocRibbon_Widget' );
});

add_action( 'wp_enqueue_scripts', 'soc_ribbon_enqueue_styles' );
function soc_ribbon_enqueue_styles() {
    wp_enqueue_style( 'soc-ribbon-style',
        plugins_url('/dd-soc-ribbon.css',__FILE__),
        array('child-style','parent-style')
    );
}

class SocRibbon_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'soc_ribbon_widget', // Base ID
			__( 'Social Ribbon', 'text_domain' ), // Name
			array( 'description' => __( 'Social ribbon widget', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Generate array of social network links
	 *
	 * @param array $instance Saved values from database.
	 */
    private function get_socs($instance) {
        $arr_socs = array();

        $arr_socs[] = array('href' => !empty($instance['href_pinterest']) ? $instance['href_pinterest'] : 'http://www.pinterest.com', 'icon' => 'icon-pinterest.png', 'cta' => 'Pin us on Pinterest','label' => 'Pinterest', 'field_id' => 'href_pinterest');
        $arr_socs[] = array('href' => !empty($instance['href_facebook']) ? $instance['href_facebook'] : 'http://www.facebook.com', 'icon' => 'icon-facebook.png', 'cta' => 'Like us on Facebook','label' => 'Twitter', 'field_id' => 'href_facebook');
        $arr_socs[] = array('href' => !empty($instance['href_twitter']) ? $instance['href_twitter'] : 'http://www.twitter.com', 'icon' => 'icon-twitter.png', 'cta' => 'Follow us on Twitter','label' => 'Facebook', 'field_id' => 'href_twitter');
        $arr_socs[] = array('href' => !empty($instance['href_google']) ? $instance['href_google'] : 'http://www.google.com', 'icon' => 'icon-google.png', 'cta' => 'Add us on Google+', 'label' => 'Google+', 'field_id' => 'href_google');												

        return($arr_socs);
    }

    private function soc_ribbon_get_content($arr_socs) {

        foreach($arr_socs as $soc) {
            echo("<li class='soc'>");

            echo("<div class='soc-icon'>");
            echo("<a href='" . $soc['href'] . "' title='" . $soc['cta'] . "' target='_blank'>");
            echo("<img src=" . plugins_url($soc['icon'],__FILE__) . " alt='" . $soc['cta'] . "'>");
            echo("</a>");
            echo("</div>");

            echo("<div class='soc-cta'>");
            echo("<a href='" . $soc['href'] . "' title='" . $soc['cta'] . "' target='_blank'>");
            echo("<span>" . $soc['cta'] . "</span>");
            echo("</a>");
            echo("</div>");

            echo("</li>");
        }
    }

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
        
        $arr_socs = $this->get_socs($instance);		
		echo("<aside class='dd-ribbon'><section class='dd-ribbon-flat'><ul class='socs'>");
        $this->soc_ribbon_get_content($arr_socs);                
        echo("</ul>");
        echo("<div class='ribbon-form'>");
        echo("<h4>eNEWS &amp; UPDATES</h4>");
        echo("<p>Sign up to receive breaking news and other site updates!</p>");
        echo("<form action='#' method='post'>");
        echo("<input type='text' class='ribbon-email' placeholder='user@example.com'>");
        echo("<br>");
        echo("<input type='submit' class='ribbon-button' value='Send'>");
        echo("<br>");
        echo("</form>");
        echo("</div>");
        echo("</section></aside>");
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

        $arr_soc = $this->get_socs($instance);
        echo("<p>Links to Profiles</p>");
        foreach($arr_soc as $soc) {
		?>
		<p>        
		<label for="<?php echo $this->get_field_id( $soc['field_id'] ); ?>"><?php _e( $soc['label'] ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( $soc['field_id'] ); ?>" name="<?php echo $this->get_field_name( $soc['field_id'] ); ?>" type="text" value="<?php echo esc_attr( $soc['href'] ); ?>">
		</p>
		<?php 
        }
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
        $arr_soc = $this->get_socs($instance);
        foreach($arr_soc as $soc) {
		$instance[$soc['field_id']] = ( ! empty( $new_instance[$soc['field_id']] ) ) ? strip_tags( $new_instance[$soc['field_id']] ) : '';        }
		return $instance;
	}
} // class Foo_Widget
