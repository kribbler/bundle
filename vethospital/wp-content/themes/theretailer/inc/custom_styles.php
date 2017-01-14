<?php
function theretailer_custom_styles() {
global $theretailer_theme_options;
?>

<!-- ******************************************************************** -->
<!-- Custom CSS Codes -->
<!-- ******************************************************************** -->
	
<style>

/***************************************************************/
/****************************** Body ***************************/
/***************************************************************/

body {
	<?php if ( $theretailer_theme_options['main_bg_color'] ) { ?>
	background-color:<?php echo $theretailer_theme_options['main_bg_color']; ?>;
	<?php } ?>
	<?php if ( $theretailer_theme_options['main_bg'] ) { ?>
	background-image:url(<?php echo $theretailer_theme_options['main_bg']; ?>);
	background-size:cover;
	background-attachment:fixed;
	<?php } ?>
}

/***************************************************************/
/************************** Main font **************************/
/***************************************************************/

body,.ctextfield,.cselect,.ctextarea,.ccheckbox_group label,.cradio_group label,.gbtr_light_footer_no_widgets,.gbtr_widget_footer_from_the_blog .gbtr_widget_item_title,.widget input[type=text],.widget input[type=password],.widget select,.gbtr_tools_search_inputtext,.gbtr_second_menu,.gbtr_little_shopping_bag .overview,.gbtr_featured_section_title,h1.entry-title,h1.page-title,h1.entry-title a,h1.page-title a,em.items_found,em.items_found_cart,.product_item p,div.product .product_title,#content div.product .product_title,.gbtr_product_description,div.product form.cart .variations .value select,#content div.product form.cart .variations .value select,div.product div.product_meta,#content div.product div.product_meta,div.product .woocommerce_tabs .panel,#content div.product .woocommerce_tabs .panel,#content div.product div.product_meta,div.product .woocommerce-tabs .panel,#content div.product .woocommerce-tabs .panel,.coupon .input-text,.cart_totals .shipping td,.shipping_calculator h3,.checkout h3,.gbtr_checkout_method_header,.checkout .input-text,.checkout #shiptobilling label,table.shop_table tfoot .shipping td,.gbtr_checkout_login .input-text,table.my_account orders .order-number a,.myaccount_user,.order-info,.myaccount_user span,.order-info span,.gbtr_my_account_wrapper input,.gbtr_my_account_wrapper select,.gbtr_login_register_wrapper h2,.gbtr_login_register_wrapper input,.sf-menu li li a,div.product form.cart .variations .reset_variations,#content div.product form.cart .variations .reset_variations,.shortcode_banner_simple_inside h3,.shortcode_banner_simple_inside h3 strong,.woocommerce_message a.button,.woocommerce-message a.button,.mc_var_label,form .form-row .input-text,
form .form-row textarea, form .form-row select,#icl_lang_sel_widget a,#megaMenu ul.megaMenu li li li a span, #megaMenu ul.megaMenu li li li span.um-anchoremulator span
{
	font-family: '<?php echo $theretailer_theme_options['gb_main_font']; ?>', Arial, Helvetica, sans-serif !important;
}

/********************************************************************/
/************************** Secondary font **************************/
/********************************************************************/

.cbutton,.widget h1.widget-title,.widget input[type=submit],.widget.widget_shopping_cart .total,.widget.widget_shopping_cart .total strong,ul.product_list_widget span.amount,.gbtr_tools_info,.gbtr_tools_account,.gbtr_tools_search_inputbutton,.gbtr_little_shopping_bag .title,.product_item h3,.product_item .price,a.button,button.button,input.button,#respond input#submit,#content input.button,div.product .product_brand,div.product .summary span.price,div.product .summary p.price,#content div.product .summary span.price,#content div.product .summary p.price,.quantity input.qty,#content .quantity input.qty,div.product form.cart .variations .label,#content div.product form.cart .variations .label,.gbtr_product_share ul li a,div.product .woocommerce_tabs ul.tabs li a,#content div.product .woocommerce_tabs ul.tabs li a,div.product .woocommerce-tabs ul.tabs li a,#content div.product .woocommerce-tabs ul.tabs li a,table.shop_table th,table.shop_table .product-name .category,table.shop_table td.product-subtotal,.coupon .button-coupon,.cart_totals th,.cart_totals td,form .form-row label,table.shop_table td.product-quantity,table.shop_table td.product-name .product_brand,table.shop_table td.product-total,table.shop_table tfoot th,table.shop_table tfoot td,.gbtr_checkout_method_content .title,.gbtr_left_column_my_account ul.menu_my_account,table.my_account_orders td.order-total,.minicart_total_checkout,.addresses .title h3,.sf-menu a,.shortcode_featured_1 a,.shortcode_tabgroup ul.tabs li a,.shortcode_our_services a,span.onsale,.product h3,#respond label,form label,form input[type=submit],.section_title,.entry-content-aside-title,.gbtr_little_shopping_bag_wrapper_mobiles span,.grtr_product_header_mobiles .price,.gbtr_footer_widget_copyrights,.woocommerce_message,.woocommerce_error,.woocommerce_info,.woocommerce-message,.woocommerce-error,.woocommerce-info,p.product,.empty_bag_button,.from_the_blog_date,.gbtr_dark_footer_wrapper .widget_nav_menu ul li,.widget.the_retailer_recent_posts .post_date,.shortcode_banner_simple_bullet,.theretailer_product_sort,.light_button,.dark_button,.light_grey_button,.dark_grey_button,.custom_button,.style_1 .products_slider_category,.style_1 .products_slider_price,.page_archive_subtitle,.shortcode_banner_simple_inside h4,.mc_var_label,.theretailer_style_intro,.wpmega-link-title,#megaMenu h2.widgettitle
{
	font-family: '<?php echo $theretailer_theme_options['gb_secondary_font']; ?>', Arial, Helvetica, sans-serif !important;
}

/********************************************************************/
/*************************** Main Color *****************************/
/********************************************************************/

a,
.gbtr_tools_info,
.default-slider-next i,
.default-slider-prev i,
li.product h3:hover,
.product_item h3 a,
div.product .product_brand,
div.product div.product_meta a:hover,
#content div.product div.product_meta a:hover,
#reviews a,
div.product .woocommerce_tabs .panel a,
#content div.product .woocommerce_tabs .panel a,
div.product .woocommerce-tabs .panel a,
#content div.product .woocommerce-tabs .panel a,
.product_navigation .nav-back a,
table.shop_table td.product-name .product_brand,
.woocommerce table.shop_table td.product-name .product_brand,
table.my_account_orders td.order-actions a:hover,
ul.digital-downloads li a:hover,
.addresses a:hover,
.gbtr_login_register_switch ul li,
.entry-meta a:hover,
footer.entry-meta .comments-link a,
#nav-below .nav-previous-single a:hover,
#nav-below .nav-next-single a:hover,
.gbtr_dark_footer_wrapper .widget_nav_menu ul li a:hover,
.gbtr_dark_footer_wrapper a:hover,
.shortcode_meet_the_team .role,
.accordion .accordion-title a:hover,
.testimonial_left_author h5,
.testimonial_right_author h5,
#comments a:hover,
.portfolio_item a:hover,
.emm-paginate a:hover span,
.emm-paginate a:active span,
.emm-paginate .emm-prev:hover,
.emm-paginate .emm-next:hover,
.mc_success_msg,
.page_archive_items a:hover,
.gbtr_product_share ul li a,
div.product form.cart .variations .reset_variations,
#content div.product form.cart .variations .reset_variations,
table.my_account_orders .order-number a,
.gbtr_dark_footer_wrapper .tagcloud a:hover
{
	color:<?php echo $theretailer_theme_options['accent_color']; ?>;
}

.sf-menu li:hover > a,
.accordion .accordion-title a:hover,
.gbtr_login_register_switch ul li
{
	color:<?php echo $theretailer_theme_options['accent_color']; ?> !important;
}

.woocommerce_message, .woocommerce_error, .woocommerce_info,
.woocommerce-message, .woocommerce-error, .woocommerce-info,
form input[type=submit]:hover,
.widget input[type=submit]:hover,
.tagcloud a:hover,
#wp-calendar tbody td a,
.widget.the_retailer_recent_posts .post_date,
a.button:hover,button.button:hover,input.button:hover,#respond input#submit:hover,#content input.button:hover,
.myaccount_user,
.order-info,
.shortcode_featured_1 a:hover,
.from_the_blog_date,
.style_1 .products_slider_images,
.portfolio_sep,
.portfolio_details_sep,
.gbtr_little_shopping_bag_wrapper_mobiles span,
#mc_signup_submit:hover,
.page_archive_date
{
	background: <?php echo $theretailer_theme_options['accent_color']; ?>;
}

.woocommerce_message,
.woocommerce-message,
.widget_price_filter .ui-slider .ui-slider-range,
.gbtr_minicart_cart_but:hover,
.gbtr_minicart_checkout_but:hover,
span.onsale,
.woocommerce span.onsale,
.product_main_infos span.onsale,
.quantity .minus:hover,
#content .quantity .minus:hover,
.quantity .plus:hover,
#content .quantity .plus:hover,
.single_add_to_cart_button:hover,
.add_review .button:hover,
#fancybox-close:hover,
.shipping-calculator-form .button:hover,
.coupon .button-coupon:hover,
.gbtr_left_column_cart .update-button:hover,
.gbtr_left_column_cart .checkout-button:hover,
.button_create_account_continue:hover,
.button_billing_address_continue:hover,
.button_shipping_address_continue:hover,
.button_order_review_continue:hover,
#place_order:hover,
.gbtr_my_account_button input:hover,
.gbtr_track_order_button:hover,
.gbtr_login_register_wrapper .button:hover,
.gbtr_login_register_reg .button:hover,
.gbtr_login_register_log .button:hover,
p.product a:hover,
#respond #submit:hover,
.widget_shopping_cart .button:hover,
.sf-menu li li a:hover,
.lost_reset_password .button:hover,
.widget_price_filter .price_slider_amount .button:hover
{
	background: <?php echo $theretailer_theme_options['accent_color']; ?> !important;
}

.widget.the_retailer_connect a:hover,
.gbtr_login_register_switch .button:hover,
.more-link,
.gbtr_dark_footer_wrapper .button,
.light_button:hover,
.dark_button:hover,
.light_grey_button:hover,
.dark_grey_button:hover,
.gbtr_little_shopping_bag_wrapper_mobiles:hover,
.menu_select.customSelectHover
{
	background-color:<?php echo $theretailer_theme_options['accent_color']; ?>;
}

.widget_layered_nav ul li.chosen a,
.widget_layered_nav_filters ul li.chosen a,
a.button.added::before,
button.button.added::before,
input.button.added::before,
#respond input#submit.added::before,
#content input.button.added::before,
.woocommerce a.button.added::before,
.woocommerce button.button.added::before,
.woocommerce input.button.added::before,
.woocommerce #respond input#submit.added::before,
.woocommerce #content input.button.added::before,
.custom_button:hover
{
	background-color:<?php echo $theretailer_theme_options['accent_color']; ?> !important;
}

.tagcloud a:hover
{
	border: 1px solid <?php echo $theretailer_theme_options['accent_color']; ?>;
}

.tagcloud a:hover,
.widget_layered_nav ul li.chosen a,
.widget_layered_nav_filters ul li.chosen a
{
	border: 1px solid <?php echo $theretailer_theme_options['accent_color']; ?> !important;
}

.widget.the_retailer_connect a:hover,
.default-slider-next,
.default-slider-prev,
.shortcode_featured_1 a:hover,
.light_button:hover,
.dark_button:hover,
.light_grey_button:hover,
.dark_grey_button:hover,
.emm-paginate a:hover span,
.emm-paginate a:active span
{
	border-color:<?php echo $theretailer_theme_options['accent_color']; ?>;
}

.custom_button:hover
{
	border-color:<?php echo $theretailer_theme_options['accent_color']; ?> !important;
}

.product_type_simple,
.product_type_variable,
.myaccount_user:after,
.order-info:after
{
	border-bottom-color:<?php echo $theretailer_theme_options['accent_color']; ?> !important;
}

.sf-menu ul > li:first-child
{
	border-top-color:<?php echo $theretailer_theme_options['accent_color']; ?>;
}

#megaMenu ul.megaMenu > li.ss-nav-menu-mega > ul.sub-menu-1, 
#megaMenu ul.megaMenu li.ss-nav-menu-reg ul.sub-menu 
{
	border-top-color:<?php echo $theretailer_theme_options['accent_color']; ?> !important;
}



/********************************************************************/
/************************ Secondary Color ***************************/
/********************************************************************/

.sf-menu a,
.sf-menu a:visited,
.sf-menu li li a,
.widget h1.widget-title,
h1.entry-title,
h1.page-title,
h1.entry-title a,
h1.page-title a,
.entry-content h1,
.entry-content h2,
.entry-content h3,
.entry-content h4,
.entry-content h5,
.entry-content h6,
.gbtr_little_shopping_bag .title a,
.theretailer_product_sort,
.shipping_calculator h3 a,
.gbtr_featured_section_title strong,
.shortcode_featured_1 a,
.shortcode_tabgroup ul.tabs li.active a,
ul.product_list_widget span.amount,
.woocommerce ul.product_list_widget span.amount,
{
	color:<?php echo $theretailer_theme_options['primary_color']; ?>;
}



/********************************************************************/
/****************************** Wrapper *****************************/
/********************************************************************/

#global_wrapper {
	margin:0 auto;	
	<?php if ($theretailer_theme_options['gb_layout'] == "boxed") { ?>
		width:100%;
		max-width:<?php echo $theretailer_theme_options['boxed_layout_width']; ?>px !important;
	<?php } else { ?>
		width:100%;
	<?php } ?>	
}

/********************************************************************/
/****************************** Header ******************************/
/********************************************************************/

.gbtr_header_wrapper {
	padding-top:<?php echo $theretailer_theme_options['menu_header_top_padding']['size']; ?>;
	padding-bottom:<?php echo $theretailer_theme_options['menu_header_bottom_padding']['size']; ?>;
	background-color:<?php echo $theretailer_theme_options['header_bg_color']; ?>;
}

/********************************************************************/
/************************** Light footer ****************************/
/********************************************************************/

.gbtr_light_footer_wrapper,
.gbtr_light_footer_no_widgets {
	background-color:<?php echo $theretailer_theme_options['primary_footer_bg_color']; ?>;
}

/********************************************************************/
/************************** Dark footer *****************************/
/********************************************************************/

.gbtr_dark_footer_wrapper,
.gbtr_dark_footer_wrapper .tagcloud a,
.gbtr_dark_footer_no_widgets {
	background-color:<?php echo $theretailer_theme_options['secondary_footer_bg_color']; ?>;
}

.gbtr_dark_footer_wrapper .widget h1.widget-title {
	border-bottom:<?php echo $theretailer_theme_options['secondary_footer_title_border']['width']; ?>px <?php echo $theretailer_theme_options['secondary_footer_title_border']['style']; ?> <?php echo $theretailer_theme_options['secondary_footer_title_border']['color']; ?>;
}

.gbtr_dark_footer_wrapper,
.gbtr_dark_footer_wrapper .widget h1.widget-title,
.gbtr_dark_footer_wrapper a,
.gbtr_dark_footer_wrapper .widget ul li,
.gbtr_dark_footer_wrapper .widget ul li a,
.gbtr_dark_footer_wrapper .textwidget,
.gbtr_dark_footer_wrapper #mc_subheader,
.gbtr_dark_footer_wrapper ul.product_list_widget span.amount,
.gbtr_dark_footer_wrapper .widget_calendar,
.gbtr_dark_footer_wrapper .mc_var_label,
.gbtr_dark_footer_wrapper .tagcloud a
{
	color:<?php echo $theretailer_theme_options['secondary_footer_color']; ?>;
}

.gbtr_dark_footer_wrapper ul.product_list_widget span.amount
{
		color:<?php echo $theretailer_theme_options['secondary_footer_color']; ?> !important;
}

.gbtr_dark_footer_wrapper .widget input[type=text],
.gbtr_dark_footer_wrapper .widget input[type=password],
.gbtr_dark_footer_wrapper .tagcloud a
{
	border: 1px solid <?php echo $theretailer_theme_options['secondary_footer_borders_color']; ?>;
}

.gbtr_dark_footer_wrapper .widget ul li {
	border-bottom: 1px dotted <?php echo $theretailer_theme_options['secondary_footer_borders_color']; ?>;
}

.gbtr_dark_footer_wrapper .widget.the_retailer_connect a {
	border-color:<?php echo $theretailer_theme_options['secondary_footer_bg_color']; ?>;
}

/********************************************************************/
/********************** Copyright footer ****************************/
/********************************************************************/

.gbtr_footer_wrapper {
	background:<?php echo $theretailer_theme_options['copyright_bar_bg_color']; ?>;
}

.bottom_wrapper {
	border-top:<?php echo $theretailer_theme_options['copyright_bar_top_border']['width']; ?>px <?php echo $theretailer_theme_options['copyright_bar_top_border']['style']; ?> <?php echo $theretailer_theme_options['copyright_bar_top_border']['color']; ?>;
}

.gbtr_footer_widget_copyrights {
	color:<?php echo $theretailer_theme_options['copyright_text_color']; ?>;
}

/********************************************************************/
/******************* Background sprite normal ***********************/
/********************************************************************/

blockquote:before,
.woocommerce_message::before,
.woocommerce_error::before,
.woocommerce_info::before,
.woocommerce-message::before,
.woocommerce-error::before,
.woocommerce-info::before,
.widget #searchform input[type=submit],
.widget .widget_connect_facebook,
.widget .widget_connect_pinterest,
.widget .widget_connect_linkedin,
.widget .widget_connect_twitter,
.widget .widget_connect_googleplus,
.widget .widget_connect_rss,
.widget .widget_connect_tumblr,
.widget .widget_connect_instagram,
.gbtr_tools_search_inputbutton,
.gbtr_little_shopping_bag .title,
ul.cart_list .remove,
ul.cart_list .empty:before,
.gbtr_product_sliders_header .big_arrow_right,
.gbtr_items_sliders_header .big_arrow_right,
.gbtr_product_sliders_header .big_arrow_right:hover,
.gbtr_items_sliders_header .big_arrow_right:hover,
.gbtr_product_sliders_header .big_arrow_left,
.gbtr_items_sliders_header .big_arrow_left,
.gbtr_product_sliders_header .big_arrow_left:hover,
.gbtr_items_sliders_header .big_arrow_left:hover,
.product_button a.button,
.product_button button.button,
.product_button input.button,
.product_button #respond input#submit,
.product_button #content input.button,
.product_button a.button:hover,
.product_button button.button:hover,
.product_button input.button:hover,
.product_button #respond input#submit:hover,
.product_button #content input.button:hover,
.product_type_simple,
.product_type_variable,
a.button.added::before,
button.button.added::before,
input.button.added::before,
#respond input#submit.added::before,
#content input.button.added::before,
.gbtr_product_share ul li a.product_share_facebook:before,
.gbtr_product_share ul li a.product_share_pinterest:before,
.gbtr_product_share ul li a.product_share_email:before,
.gbtr_product_share ul li a.product_share_twitter:before,
.doubleSlider-1 .zoom,
.product_single_slider_previous,
.product_single_slider_next,
.product_navigation .nav-previous-single a,
.product_navigation .nav-previous-single a:hover,
.product_navigation .nav-next-single a,
.product_navigation .nav-next-single a:hover,
table.shop_table a.remove,
table.shop_table a.remove:hover,
.gbtr_left_column_cart_sep,
.empty_bag_icon,
.checkout h3:after,
.gbtr_checkout_method_header:after,
footer.entry-meta .author a:before,
footer.entry-meta .entry-date:before,
footer.entry-meta .comments-link a:before,
#nav-below .nav-previous-single a .meta-nav,
#nav-below .nav-previous-single a:hover .meta-nav,
#nav-below .nav-next-single a .meta-nav,
#nav-below .nav-next-single a:hover .meta-nav,
.accordion .accordion-title:before,
.accordion .accordion-title.active:before,
.testimonial_left_content div:before,
.testimonial_right_content div:before,
.slide_everything .slide_everything_previous,
.slide_everything .slide_everything_next,
.products_slider_previous,
.products_slider_next,
.gbtr_little_shopping_bag_wrapper_mobiles,
.menu_select,
.theretailer_product_sort,
.img_404,
.tp-leftarrow.large,
.tp-leftarrow.default,
.tp-rightarrow.large,
.tp-rightarrow.default,
.widget ul li.recentcomments:before,
#lang_sel a.lang_sel_sel
{
	<?php if ( $theretailer_theme_options['icons_sprite_normal'] ) { ?>
	background-image:url(<?php echo $theretailer_theme_options['icons_sprite_normal']; ?>) !important;
	<?php } else { ?>
	background-image:url(<?php echo get_template_directory_uri(); ?>/images/sprites.png) !important;
	<?php } ?>
}

<?php if ( (!$theretailer_theme_options['flip_product']) || ($theretailer_theme_options['flip_product'] == 0) ) { ?>

/********************************************************************/
/************************* Flip products ****************************/
/********************************************************************/

<?php if ( ($theretailer_theme_options['flip_product_mobiles']) && ($theretailer_theme_options['flip_product_mobiles'] == 1) ) { ?>
@media only screen and (min-width: 719px) {
<?php } ?>

.image_container a {
	float: left;
	-webkit-perspective: 600px;
	-moz-perspective: 600px;
}

.image_container a .front {
	-webkit-transform: rotateX(0deg) rotateY(0deg);
	-webkit-transform-style: preserve-3d;
	-webkit-backface-visibility: hidden;

	-moz-transform: rotateX(0deg) rotateY(0deg);
	-moz-transform-style: preserve-3d;
	-moz-backface-visibility: hidden;

	-o-transition: all .4s ease-in-out;
	-ms-transition: all .4s ease-in-out;
	-moz-transition: all .4s ease-in-out;
	-webkit-transition: all .4s ease-in-out;
	transition: all .4s ease-in-out;
}

.image_container a:hover .front {
	-webkit-transform: rotateY(180deg);
	-moz-transform: rotateY(180deg);
}

.image_container a .back {
	-webkit-transform: rotateY(-180deg);
	-webkit-transform-style: preserve-3d;
	-webkit-backface-visibility: hidden;

	-moz-transform: rotateY(-180deg);
	-moz-transform-style: preserve-3d;
	-moz-backface-visibility: hidden;

	-o-transition: all .4s ease-in-out;
	-ms-transition: all .4s ease-in-out;
	-moz-transition: all .4s ease-in-out;
	-webkit-transition: all .4s ease-in-out;
	transition: all .4s ease-in-out;
	/*z-index:10;
	position:absolute;*/
}

.image_container a:hover .back {
	-webkit-transform: rotateX(0deg) rotateY(0deg);
	-moz-transform: rotateX(0deg) rotateY(0deg);
	z-index:10;
	position:absolute;
}

<?php if ( ($theretailer_theme_options['flip_product_mobiles']) && ($theretailer_theme_options['flip_product_mobiles'] == 1) ) { ?>
}
<?php } ?>

<?php } ?>

<?php if ( ($theretailer_theme_options['revolution_slider_in_mobile_phones']) && ($theretailer_theme_options['revolution_slider_in_mobile_phones'] == 1) ) { ?>
/********************************************************************/
/********** Remove Revolution on mobile phones **********************/
/********************************************************************/

@media only screen and (max-width: 479px) {
	
	.rev_slider_wrapper {
		display:none !important;
	}
	
}
<?php } ?>


/********************************************************************/
/************************ Retina Stuff ******************************/
/********************************************************************/

@media only screen and (-webkit-min-device-pixel-ratio: 2), 
only screen and (min-device-pixel-ratio: 2)
{
	blockquote:before,
	.woocommerce_message::before,
	.woocommerce_error::before,
	.woocommerce_info::before,
	.woocommerce-message::before,
	.woocommerce-error::before,
	.woocommerce-info::before,
	.widget #searchform input[type=submit],
	.widget .widget_connect_facebook,
	.widget .widget_connect_pinterest,
	.widget .widget_connect_linkedin,
	.widget .widget_connect_twitter,
	.widget .widget_connect_googleplus,
	.widget .widget_connect_rss,
	.widget .widget_connect_tumblr,
	.widget .widget_connect_instagram,
	.gbtr_tools_search_inputbutton,
	.gbtr_little_shopping_bag .title,
	ul.cart_list .remove,
	ul.cart_list .empty:before,
	.gbtr_product_sliders_header .big_arrow_right,
	.gbtr_items_sliders_header .big_arrow_right,
	.gbtr_product_sliders_header .big_arrow_right:hover,
	.gbtr_items_sliders_header .big_arrow_right:hover,
	.gbtr_product_sliders_header .big_arrow_left,
	.gbtr_items_sliders_header .big_arrow_left,
	.gbtr_product_sliders_header .big_arrow_left:hover,
	.gbtr_items_sliders_header .big_arrow_left:hover,
	.product_button a.button,
	.product_button button.button,
	.product_button input.button,
	.product_button #respond input#submit,
	.product_button #content input.button,
	.product_button a.button:hover,
	.product_button button.button:hover,
	.product_button input.button:hover,
	.product_button #respond input#submit:hover,
	.product_button #content input.button:hover,
	.product_type_simple,
	.product_type_variable,
	a.button.added::before,
	button.button.added::before,
	input.button.added::before,
	#respond input#submit.added::before,
	#content input.button.added::before,
	.gbtr_product_share ul li a.product_share_facebook:before,
	.gbtr_product_share ul li a.product_share_pinterest:before,
	.gbtr_product_share ul li a.product_share_email:before,
	.gbtr_product_share ul li a.product_share_twitter:before,
	.doubleSlider-1 .zoom,
	.product_single_slider_previous,
	.product_single_slider_next,
	.product_navigation .nav-previous-single a,
	.product_navigation .nav-previous-single a:hover,
	.product_navigation .nav-next-single a,
	.product_navigation .nav-next-single a:hover,
	table.shop_table a.remove,
	table.shop_table a.remove:hover,
	.gbtr_left_column_cart_sep,
	.empty_bag_icon,
	.checkout h3:after,
	.gbtr_checkout_method_header:after,
	footer.entry-meta .author a:before,
	footer.entry-meta .entry-date:before,
	footer.entry-meta .comments-link a:before,
	#nav-below .nav-previous-single a .meta-nav,
	#nav-below .nav-previous-single a:hover .meta-nav,
	#nav-below .nav-next-single a .meta-nav,
	#nav-below .nav-next-single a:hover .meta-nav,
	.accordion .accordion-title:before,
	.accordion .accordion-title.active:before,
	.testimonial_left_content div:before,
	.testimonial_right_content div:before,
	.slide_everything .slide_everything_previous,
	.slide_everything .slide_everything_next,
	.products_slider_previous,
	.products_slider_next,
	.gbtr_little_shopping_bag_wrapper_mobiles,
	.menu_select,
	.theretailer_product_sort,
	.img_404,
	.tp-leftarrow.large,
	.tp-leftarrow.default,
	.tp-rightarrow.large,
	.tp-rightarrow.default,
	.widget ul li.recentcomments:before,
	#lang_sel a.lang_sel_sel
	{
		<?php if ( $theretailer_theme_options['icons_sprite_retina'] ) { ?>
		background-image:url(<?php echo $theretailer_theme_options['icons_sprite_retina']; ?>) !important;
		<?php } else { ?>
		background-image:url(<?php echo get_template_directory_uri(); ?>/images/sprites@2x.png) !important;
		<?php } ?>
		background-size:1000px 1000px;
	}
}

.sf-menu a, .sf-menu a:visited {
	color: <?php echo $theretailer_theme_options['primary_menu_color']; ?>;
}
.gbtr_second_menu li a {
	color: <?php echo $theretailer_theme_options['secondary_menu_color']; ?>;
}

/********************************************************************/
/************************* Custom CSS *******************************/
/********************************************************************/

<?php echo $theretailer_theme_options['custom_css']; ?>

</style>

<?php 
}
add_action( 'wp_head', 'theretailer_custom_styles', 100 );
?>