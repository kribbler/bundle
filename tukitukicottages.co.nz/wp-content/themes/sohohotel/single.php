<?php
	
	if ( is_post_type( "testimonial" )) {
		load_template(get_template_directory().'/single-testimonial.php');
	}
	
	elseif ( is_post_type( "accommodation" )) {
		load_template(get_template_directory().'/single-accommodation.php');
	}
	
	elseif ( is_post_type( "event" )) {
		load_template(get_template_directory().'/single-event.php');
	}

	else {
		load_template(get_template_directory().'/single-default.php');
	}

?>