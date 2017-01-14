<?php

add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

add_theme_support( 'genesis-connect-woocommerce' );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );

function theme_enqueue_styles() {
    wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css');

    //wp_enqueue_style( 'bootstrap-theme', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', array('bootstrap'));

    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array('bootstrap'));

    wp_enqueue_style( 'child-theme-css',
        get_stylesheet_directory_uri() . '/style.css',
        array('bootstrap','parent-style')
    );

		wp_enqueue_style('titillium-fonts','http://fonts.googleapis.com/css?family=Titillium+Web|PT+Serif+Caption',array('bootstrap'));
		//wp_enqueue_style('titillium-fonts','http://fonts.googleapis.com/css?family=Titillium+Web',array('bootstrap'));
		//wp_enqueue_style('pt-serif-caption','http://fonts.googleapis.com/css?family=PT+Serif+Caption', array('bootstrap'));
}

function theme_enqueue_scripts() {
    wp_enqueue_script('bootstrap-js','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js');
}

add_action('genesis_before_content', 'genesis_child_before_content');
function genesis_child_before_content() {
	?>
		<div class='col-xs-7'>
	<?php
}

add_action('genesis_after_content','genesis_child_after_content');
function genesis_child_after_content() {
	?>
		</div>
	<?php
}

add_action( 'widgets_init', 'banner_widgets_init' );
function banner_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Banner', 'banner' ),
		'id' => 'banner',
		'description' => __( 'Widgets in this area will be shown on the top all posts and pages.', 'banner' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<section class="widget %2$s">',
		'after_title'   => '</section>',
	));
}

add_action( 'widgets_init', 'footer_widgets_init' );
function footer_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Footer', 'footer' ),
		'id' => 'footer',
		'description' => __( 'Widgets in this area will be shown at the bottom of all pages.', 'footer' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<section class="widget %2$s">',
		'after_title'   => '</section>',
	));
}

add_action( 'widgets_init', 'base1_widgets_init' );
function base1_widgets_init() {
	register_sidebar( array(
		'name' => __('Base 1 (Welcome)', 'base-1'),
		'id' => 'base-1',
		'description' => __('Widgets in this area will be shown at the bottom of the welcome Wordpress page.','base-1'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<section class="widget %2$s">',
		'after_title' => '</section>',
	) );
}

add_action( 'widgets_init', 'base2_widgets_init' );
function base2_widgets_init() {
	register_sidebar( array(
		'name' => __('Base 2 (Product)', 'base-2'),
		'id' => 'base-2',
		'description' => __('Widgets in this area will be shown at the bottom of the WooCommerce product page.','base-2'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<section class="widget %2$s">',
		'after_title' => '</section>',
	) );
}

add_action( 'widgets_init', 'header_widgets_init' );
function header_widgets_init() {
	register_sidebar( array(
		'name' => __('Header', 'header'),
		'id' => 'header',
		'description' => __('Widgets in this area will be shown at the top of every Wordpress page.','header'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<section class="widget %2$s">',
		'after_title' => '</section>',
	) );
}

add_action( 'widgets_init', 'search_widgets_init' );
function search_widgets_init() {
	register_sidebar( array(
		'name' => __('Search', 'search'),
		'id' => 'search',
		'description' => __('Widgets in this area will be shown to the LEFT of the sidebar known as HEADER.','search'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<section class="widget %2$s">',
		'after_title' => '</section>',
	) );
}

add_action( 'widgets_init', 'woocat_widgets_init' );
function woocat_widgets_init() {
   	register_sidebar( array(
		'name' => __('Woocat', 'woocat'),
		'id' => 'woocat',
		'description' => __('Widgets in this area will be shown at the very bottom of the Woocommerce post.','woocat'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<section class="widget %2$s">',
		'after_title' => '</section>',
	) );
}

add_action('genesis_after_header','genesis_child_after_header',15);
function genesis_child_after_header() {
    echo("<div class='row'>");
    echo("<div class='col-xs-12'>");
	echo("<aside class='sidebar widget-area' style='display: block;'>");	
	echo("<br>");
	dynamic_sidebar('banner');
	echo("</aside>");
    echo("</div>");
    echo("</div>");
}

remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'genesis_child_do_footer' );

function genesis_child_do_footer() {
	$footer_menu = array(
		'theme_location'  => '',
		'container'       => '<div>',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => '',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
	);
	echo("<div class='container'>");
    echo("<div class='row' style='margin-top: 2.5em;'>");
    echo("<div class='col-xs-12 text-center'>");
		echo("<aside class='sidebar widget-area' style='display: block;'>");
		echo("<div class='row'>");

		echo("<div class='col-xs-4'>");
		$footer_menu['menu'] = 'footer-internal';
		wp_nav_menu( $footer_menu );
		echo("</div>");

		echo("<div class='col-xs-4'>");
		$footer_menu['menu'] = 'footer-external';
		wp_nav_menu( $footer_menu );
		echo("</div>");

		echo("<div class='col-xs-4'>");
		echo("<a href='http://www.divinedesigns.ca/' target='_blank' style='text-decoration: none;'>Website Designed by: DivineDesigns.ca<br> Web Design - Graphic Design - Online Marketing<br> Orillia, Ontario</a>");
		echo("</div>");
		echo("</div>");
		echo("<div class='row'>");
		echo("<div class='col-xs-12'>");
		dynamic_sidebar('footer');
		echo("</div>");
		echo("</div>");
		echo("</aside>");
    echo("</div>");
    echo("</div>");
    echo("</div>");
}

add_action('genesis_after_loop','genesis_child_after_loop1');
function genesis_child_after_loop1() {
	if(is_front_page()) {    	
		echo("<div class='row'>");
		echo("<div class='col-xs-12'>");
		echo("<aside class='sidebar widget-area' style='display: block;'>");
			
		dynamic_sidebar('base-1');
			
		echo("</aside>");
		echo("</div>");
		echo("</div>");
	}
}

add_action('genesis_after_loop','genesis_child_after_loop2');
function genesis_child_after_loop2() {
	if(is_product()) {    	
			echo("<div class='row'>");
			echo("<div class='col-xs-12'>");
			echo("<aside class='sidebar widget-area' style='display: block;'>");		
			dynamic_sidebar('base-2');
			echo("</aside>");
			echo("</div>");
    	echo("</div>");
	}
}

add_action( 'woocommerce_after_shop_loop', 'genesis_child_cat_content', 30 );
function genesis_child_cat_content() {
    echo("<div class='row'>");
    echo("<div class='col-xs-12'>");
	echo("<aside class='sidebar widget-area' style='display: block;'>");	
	dynamic_sidebar('woocat');
	echo("</aside>");
    echo("</div>");
    echo("</div>");
}

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action( 'woocommerce_before_shop_loop', 'genesis_child_postage_open', 20 );
add_action( 'woocommerce_after_shop_loop', 'genesis_child_postage_close', 20 );

add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 21 );

add_action( 'woocommerce_after_shop_loop', 'genesis_child_category_description', 21 );
add_action( 'woocommerce_after_shop_loop', 'genesis_child_single_product_adsense', 22 );
add_action( 'woocommerce_after_shop_loop', 'genesis_child_latest_products', 23 );



function genesis_child_category_description() {
	if ( is_product_category() ) {
        global $wp_query;
        $cat_id = $wp_query->get_queried_object_id();
        $cat_desc = term_description( $cat_id, 'product_cat' );
  		echo('<div class="whitebg what_know">');
	    //echo('<h2>What We Know About This Postcard</h2>');
	    echo('<p>');
	    echo $cat_desc;
	    echo('</p>');
	    echo('</div>');
    }
}

function genesis_child_latest_products() {
	dynamic_sidebar( 'sidebar_latest_products' );
}

function genesis_child_postage_open() {
?>
    <div class="row" style='margin-top: 38px;'>
        <div class="col-xs-12">
            <div class='cyan-postage-wrap'>
                <div class='cyan-postage-bg-xl postcards'>
                		<div class="postcard-list">
                  	  <div class='ribbon-undef'><span><?php woocommerce_page_title(); ?> Vintage Postcards</span></div>
<?php
}

function genesis_child_postage_close() {
?>
									</div>
                </div>
            </div>
        </div>
    </div>
<?php
}

add_action('woocommerce_before_single_product_summary', 'genesis_child_content_wrapper_open',10);
add_action( 'woocommerce_after_single_product_summary','genesis_child_content_wrapper_close',10);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 20 );
add_action( 'woocommerce_after_single_product_summary', 'genesis_child_single_product_adsense', 30 );

function genesis_child_content_wrapper_open() {
?>
    <div class="row" style='margin-top: 18px'>
        <div class="col-xs-12">
            <div class='cyan-postage-wrap'>
                <div class='cyan-postage-bg-xl postcards'>
                		<div class="postcard-info">
                    <?php echo(woocommerce_template_single_title()); ?>
                    <?php
	                    $args = array(
			                    'delimiter' => '|',
	                    );
                    ?>
                    <?php ob_start(); ?>
                    <?php woocommerce_breadcrumb( $args ); ?>
                    <?php $output = ob_get_contents(); ?>
                    <?php ob_end_clean(); ?>
                    <?php $cats = array_slice(explode('|',$output),2); ?>
                    <?php array_pop($cats); ?>
                    <?php $buff = implode(' &raquo; ', $cats); ?>
                    <?php echo("<h3>$buff</h3>"); ?>
                    <div class='ribbon-details'>
                        <div style="background-image: url('/wp-content/themes/vintage-postcards/images/ribbon-details.png');">
                            <div>
                                <?php do_action( 'woocommerce_single_product_summary'); ?>                            
</div>
                        </div>
                    </div>
<?php
}

function genesis_child_content_wrapper_close() {
?>
									</div>
                </div>
            </div>
        </div>
    </div>
<?php
}

function genesis_child_single_product_adsense() {
?>
<div class="row">
<div class="col-xs-12" style='text-align: center;'>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 728x90 video, vintage -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-6233593691070890"
     data-ad-slot="8642723430"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br>
</div>
</div>
<?php
}


add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
	unset( $tabs['reviews'] ); // Remove the reviews tab
	unset( $tabs['additional_information'] ); // Remove the additional information tab
	return $tabs;
} 

add_filter( 'woocommerce_product_tabs', 'woo_custom_description_tab', 98 );
function woo_custom_description_tab( $tabs ) {
    $tabs['description']['callback'] = 'woo_custom_description_tab_content'; // Custom description callback
    return $tabs;
}

function woo_custom_description_tab_content($arg1,$arg2) {
    echo('<div class="whitebg what_know">');
    echo('<h2>What We Know About This Postcard</h2>');
    echo('<p>');
    the_content();    
    echo('</p>');
    echo('</div>');
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

add_action( 'woocommerce_single_product_summary', 'genesis_child_single_price', 5 );
function genesis_child_single_price($arg1) {
	$product = new WC_Product( get_the_ID() );
	$price = $product->price;	
	echo("<div class='row'>");
	echo("<div class='col-xs-offset-1 col-xs-7'>");
        echo("<div class='spacer'>&nbsp;</div>");
	echo("<h3 style='font-size: 18pt;'>PRICE : \$$price</h3>");
	echo("</div>");
	echo("</div>");

}

add_action( 'woocommerce_single_product_summary', 'genesis_child_single_dim', 10 );
function genesis_child_single_dim($arg1) {
	$product = new WC_Product( get_the_ID() );
	$dimensions_str = $product->get_dimensions();
	$arr_dimensions = explode(' x ',$dimensions_str);
	if (count($arr_dimensions) > 1) {
		echo("<div class='row'>");
		echo("<div class='col-xs-offset-1 col-xs-7'>");
		echo("<img src='/wp-content/themes/vintage-postcards/images/hr-1.png' alt='hr'>");
	  echo("<h3 style='font-size: 18pt;'>$arr_dimensions[0]\" x $arr_dimensions[1]\"</h3>");
		echo("<img src='/wp-content/themes/vintage-postcards/images/hr-1.png' alt='hr'>");
		echo("</div>");
		echo("</div>");
	}
}

add_action( 'woocommerce_single_product_summary', 'genesis_child_say_quantity', 15 );
function genesis_child_say_quantity($arg1) {
	echo("<div class='row'>");
	echo("<div class='col-xs-offset-1 col-xs-7'>");
	echo("<h3 style='font-size: 10pt;'>Quantity : </h3>");
	echo("</div>");
	echo("</div>");
}

add_action( 'woocommerce_single_product_summary', 'genesis_child_buy_now', 30 );
function genesis_child_buy_now($arg1) {
	echo("<div class='row'>");
	echo("<div class='col-xs-offset-1 col-xs-7'>");
	$productid = get_the_ID();
	$form = '<form data-productid="'.$productid.'" method="post" enctype="multipart/form-data">
                <input type="hidden" value="1" name="quantity" id="quantity">
                <input type="hidden" value="true" name="quick_buy" />
                <input type="hidden" name="add-to-cart" value="'.esc_attr($productid).'" />
                <button data-productid="'.$productid.'" type="submit" class="button alt text-center" style="width: 100%;">Buy Now</button>';
        $form .= '</form>';
	echo($form);
	echo("</div>");
	echo("</div>");
}

add_action( 'woocommerce_single_product_summary', 'genesis_child_soc', 35 );
function genesis_child_soc() {
	$encoded_link = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
	echo("<div class='row' style='margin-top: 2.5em;'>");
	echo("<div class='col-xs-3'>");
	echo("<a href='//pinterest.com/pin/create/button/
        ?url=&$encoded_link&description=Vintage%20Postcard%3A%20Photo' class='center-block'><img class='img-responsive' src='/wp-content/themes/vintage-postcards/images/button-pinterest.png' alt='Pin it'></a>");
	echo("</div>");
	echo("<div class='col-xs-3'>");
	echo("<a href='//facebook.com/sharer.php?u=$encoded_link' title='Like on Facebook' class='center-block'><img class='img-responsive' src='/wp-content/themes/vintage-postcards/images/button-facebook.png' alt='Like on Facebook'></a>");
	echo("</div>");
	echo("<div class='col-xs-3'>");
	echo("<a href='//twitter.com/intent/tweet?url=$encoded_link' title='Share on Twitter' class='center-block'><img class='img-responsive' src='/wp-content/themes/vintage-postcards/images/button-twitter.png' alt='Share on Twitter'></a>");
	echo("</div>");
	echo("</div>");
}


add_filter('widget_text', 'do_shortcode');

add_filter ( 'woocommerce_product_thumbnails_columns', 'xtra_thumb_cols' );
function xtra_thumb_cols() {
	return 4;
}

add_filter('nav_menu_css_class' , 'hide_on_mobile_nav_class' , 10 , 2);
function hide_on_mobile_nav_class($classes, $item){
/*
	if(in_array('current-menu-item', $classes) ){
		$classes[] = 'hidden-xs ';
		$classes[] = 'hidden-sm ';
	}
*/
	return $classes;
}

?>