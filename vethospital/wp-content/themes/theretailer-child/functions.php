<?php


add_action( 'widgets_init', 'child_theretailer_widgets_init' );

function child_theretailer_widgets_init(){
    if ( function_exists('register_sidebar') ) {
        register_sidebar(array(
            'name' => __( 'Header phones', 'theretailer' ),
            'id' => 'header_phones',
            'before_widget' => '<div id="%1$s" class="header_phones widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));	
		
		register_sidebar(array(
            'name' => __( 'Bellow Footer Left', 'theretailer' ),
            'id' => 'bellow_footer_left',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));
		
		register_sidebar(array(
            'name' => __( 'Bellow Footer Right', 'theretailer' ),
            'id' => 'bellow_footer_right',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));
		
		register_sidebar(array(
            'name' => __( 'My Facebook1', 'theretailer' ),
            'id' => 'my_facebook1',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));
		
		register_sidebar(array(
            'name' => __( 'My Facebook', 'theretailer' ),
            'id' => 'my_facebook',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));
    }
}

include_once( 'widgets/widget-contact_details.php' );
include_once( 'widgets/widget-opening_hours.php' );
include_once( 'widgets/widget-news_events.php' );