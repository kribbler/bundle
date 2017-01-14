<?php

function create_post_type_event() {
	
	register_post_type('event', 
		array(
			'labels' => array(
				'name' => __( 'Events', 'qns' ),
                'singular_name' => __( 'Event', 'qns' ),
				'add_new' => __('Add New', 'qns' ),
				'add_new_item' => __('Add New Event' , 'qns' )
			),
		'public' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-flag',
		'rewrite' => array(
			'slug' => __('event','qns')
		), 
		'supports' => array( 'title','editor','thumbnail'),
	));
}

add_action( 'init', 'create_post_type_event' );



// Add the Meta Box  
function add_custom_meta_box() {  
    add_meta_box(  
        'custom_meta_box', // $id  
        'Event', // $title  
        'show_custom_meta_box', // $callback  
        'event', // $page  
        'normal', // $context  
        'high'); // $priority  
}  
add_action('add_meta_boxes', 'add_custom_meta_box');



// Field Array  
$prefix = 'qns_';  
$custom_meta_fields = array(  
    array(  
        'label'=> __('Event Date','qns'),  
        'desc'  => '',  
        'id'    => $prefix.'event_date',  
        'type'  => 'date'
    ),

	array(  
        'label'=> __('Event Time','qns'),  
        'desc'  => '',  
        'id'    => $prefix.'event_time',  
        'type'  => 'text'
    ),
	array(  
    	'label'=> __('Event Location','qns'),  
    	'desc'  => '',  
    	'id'    => $prefix.'event_location',  
    	'type'  => 'text'
	)
        
);



// add some custom js to the head of the page
add_action('admin_head','add_custom_scripts');
add_action('admin_head','admin_style2');
add_action('admin_head','admin_script');

function add_custom_scripts() {
	global $custom_meta_fields, $post;	
	$output = '<script type="text/javascript">
				jQuery(function() {';
	foreach ($custom_meta_fields as $field) { // loop through the fields looking for certain types
		// date
		if($field['type'] == 'date')
			$output .= 'jQuery(".datepicker").datepicker({ dateFormat: \'yy-mm-dd\' });';
	}
	$output .= '});
		</script>';
	echo $output;
}

function admin_style2() {
	wp_enqueue_style('jquery-ui-custom', get_template_directory_uri().'/css/jquery-ui-custom.css');
}

function admin_script() {
	wp_enqueue_script('jquery-ui-datepicker');
}



// The Callback  
function show_custom_meta_box() {  
global $custom_meta_fields, $post;  
// Use nonce for verification  
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
  
    foreach ($custom_meta_fields as $field) {  
        // get value of this field if it exists for this post  
        $meta = get_post_meta($post->ID, $field['id'], true);  
        
		echo '<div class="section">';

        echo '<h3 class="heading">'.$field['label'].'</h3>';  
                switch($field['type']) {  
					
					// text  
					case 'text':  
					    echo '<div class="control-area"><input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" /></div>
					        <div class="label-area">'.$field['desc'].'</div>
							<div class="clearboth"></div>';  
					break;

					// textarea  
					case 'textarea':  
					    echo '<div class="control-area"><textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea></div>
					        <div class="label-area">'.$field['desc'].'</div>
							<div class="clearboth"></div>';  
					break;

					// checkbox  
					case 'checkbox':  
					    echo '<div class="control-area"><input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/></div>
					        <div class="label-area">'.$field['desc'].'</div>
							<div class="clearboth"></div>';  
					break;

					// select  
					case 'select':  
					    echo '<div class="control-area">
					<div class="select_wrapper"><select name="'.$field['id'].'" id="'.$field['id'].'">';  
					    foreach ($field['options'] as $option) {  
					        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';  
					    }  
					    echo '</select></div></div>
					<div class="label-area">'.$field['desc'].'</div>
					<div class="clearboth"></div>';  
					break;
					
					// date
					case 'date':
						echo '<div class="control-area"><input type="text" class="datepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" /></div>
								<div class="label-area">'.$field['desc'].'</div>
								<div class="clearboth"></div>';
					break;
					
			
                
			} //end switch  
			
			echo '</div>';
			
    } // end foreach  
	
	echo '<div class="clearboth admin-bottom"></div>';
}



// Save the Data  
function save_custom_meta($post_id) {  
    global $custom_meta_fields;  
  	
	$post_data = '';
	
	if(isset($_POST['custom_meta_box_nonce'])) {
		$post_data = $_POST['custom_meta_box_nonce'];
	}

    // verify nonce  
    if (!wp_verify_nonce($post_data, basename(__FILE__)))  
        return $post_id;

    // check autosave  
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
        return $post_id;

    // check permissions  
    if ('page' == $_POST['post_type']) {  
        if (!current_user_can('edit_page', $post_id))  
            return $post_id;  
        } elseif (!current_user_can('edit_post', $post_id)) {  
            return $post_id;  
    }  
  
    // loop through fields and save the data  
    foreach ($custom_meta_fields as $field) {  
        $old = get_post_meta($post_id, $field['id'], true);  
        $new = $_POST[$field['id']];  
        if ($new && $new != $old) {  
            update_post_meta($post_id, $field['id'], $new);  
        } elseif ('' == $new && $old) {  
            delete_post_meta($post_id, $field['id'], $old);  
        }  
    } // end foreach  
}  
add_action('save_post', 'save_custom_meta');


/**
 * Add date column to admin UI
 *
 * @param array $columns
 * @return array
 */
function qns_add_event_columns($columns) {
	$date = $columns['date'];
	unset($columns['date']);
	$columns['event_date'] = __('Event Date', 'qns');
	$columns['date'] = $date;
	return $columns;
}
add_action('manage_edit-event_columns', 'qns_add_event_columns');


/**
 * Render the date column in admin UI
 *
 * @param string $column_name
 * @param int $post_id
 */
function qns_event_columns($column_name, $post_id) {
	if ($column_name == 'event_date') {
		echo date('Y/m/d', strtotime(get_post_meta($post_id, 'qns_event_date', TRUE)));
	}
}
add_action('manage_event_posts_custom_column', 'qns_event_columns', 10, 2);

/**
 * Add CSS for custom column in admin UI
 */
function qns_event_columns_css() {
	echo '<style>th#event_date { width: 10%; } </style>';
}
add_action('admin_head', 'qns_event_columns_css');
