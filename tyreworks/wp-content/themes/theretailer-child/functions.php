<?php

add_action( 'widgets_init', 'child_theretailer_widgets_init' );

function child_theretailer_widgets_init(){
    if ( function_exists('register_sidebar') ) {
        register_sidebar(array(
            'name' => __( 'Footer Links', 'theretailer' ),
            'id' => 'footer_links',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));	
		
		register_sidebar(array(
            'name' => __( 'Header Left', 'theretailer' ),
            'id' => 'header_left',
            'before_widget' => '<div id="%1$s" class="header_right widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));	
		
		register_sidebar(array(
            'name' => __( 'Header Right', 'theretailer' ),
            'id' => 'header_right',
            'before_widget' => '<div id="%1$s" class="header_right widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));	
		
		register_sidebar(array(
            'name' => __( 'Header Slogan', 'theretailer' ),
            'id' => 'header_slogan',
            'before_widget' => '<div id="%1$s" class="header_slogan widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));	
		
		register_sidebar(array(
            'name' => __( 'Important Note', 'theretailer' ),
            'id' => 'important_note',
            'before_widget' => '<div id="%1$s" class="important_note widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));
    }
}

function get_product_attribute_value($product_id, $taxonomy){
	$attribute = wc_get_product_terms($product_id, $taxonomy);
	@$attribute = $attribute[0];
	/*if (!$attribute){
		$attribute = "X";
	}*/
	return $attribute;
}

add_filter( 'get_product_search_form' , 'woo_custom_product_searchform' );
 
/**
* woo_custom_product_searchform
*
* @access public
* @since 1.0
* @return void
*/
function woo_custom_product_searchform( $form ) {
	//it's defined in product-searchform.php file
}

function show_product_page_title(){
	global $_chosen_attributes;
	//var_dump($_GET);
	$page_extra_title = "<h1 class='page-title'>Car Tyres";
	if ($_chosen_attributes){
		$page_extra_title .= " - ";
		if (count($_chosen_attributes > 1)){
			$k = 1;
			foreach ($_chosen_attributes as $key=>$value){
				$term = get_term_by('id', $value['terms'][0], $key);
				$page_extra_title .= $term->name;
				if ($k++ < count($_chosen_attributes)){
					$page_extra_title .= ", ";
				}
			}
		}
	} elseif (isset($_GET['enter_your_reg']) && $_GET['enter_your_reg'] && $_GET['enter_your_reg'] != 'ENTER YOUR REG'){
		$page_extra_title .= ' for ';
		$page_extra_title .= $_GET['tyres_for'];
	}
	$page_extra_title .= "</h1>";
	echo $page_extra_title;
	if ($_chosen_attributes ){
		dynamic_sidebar('important_note');
	} elseif (isset($_GET['enter_your_reg']) && $_GET['enter_your_reg'] && $_GET['enter_your_reg'] != 'ENTER YOUR REG'){
		dynamic_sidebar('important_note');?>
		<div id="tyre_reg">
			<span class="span_blue_bg"><?php echo $_GET['pa_width'];?></span>
			<span class="span_blue_bg"><?php echo $_GET['pa_profile'];?></span>
			<span class="span_no_bg">R</span>
			<span class="span_blue_bg"><?php echo $_GET['pa_rim-size'];?></span>
			<span class="span_blue_bg"><?php echo strtoupper($_GET['pa_speed']);?></span>
		</div><?php
	}
	
	return null;
		
}

add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
function custom_pre_get_posts_query( $q ) {
	if ( ! $q->is_main_query() ) return;
	if ( ! $q->is_post_type_archive() ) return;
	if ( ! is_admin() && is_shop() ) {
		$q->set( 'tax_query', array(array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => array( 'batteries' ), // Don't display products in the knives category on the shop page
			'operator' => 'NOT IN'
		)));

		$q->set( 'meta_query', array(array(
		    'key'       => '_stock_status',
		    'value'     => 'instock',
		    'compare'   => 'IN'
		)));
	}
	remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
} 


