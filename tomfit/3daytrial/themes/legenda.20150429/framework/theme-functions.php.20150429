<?php
// **********************************************************************// 
// ! Set Content Width
// **********************************************************************//  
if (!isset( $content_width )) $content_width = 1170;

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

// **********************************************************************// 
// ! Include CSS and JS
// **********************************************************************// 
if(!function_exists('etheme_enqueue_styles')) {
    function etheme_enqueue_styles() {
	   global $etheme_responsive, $etheme_theme_data;
	    $etheme_theme_data = wp_get_theme( 'legenda' );

        $custom_css = etheme_get_option('custom_css');

        if ( !is_admin() ) {
            wp_enqueue_style("style",get_stylesheet_directory_uri().'/style.css', array(), $etheme_theme_data->Version);
            //wp_enqueue_style("theme_style",get_template_directory_uri().'/css/style.css');
            //echo "<link href='".get_template_directory_uri().'/css/style.less'."' rel='stylesheet/less' type='text/css'/>";
            wp_enqueue_style("font-lato",et_http()."fonts.googleapis.com/css?family=Lato:300,400,700,300italic");
            wp_enqueue_style("open-sans",et_http()."fonts.googleapis.com/css?family=Open+Sans:300,400,700,300italic");


            if($etheme_responsive){
                wp_enqueue_style("responsive",get_template_directory_uri().'/css/responsive.css', array(), $etheme_theme_data->Version);
            }

            if($custom_css) {
                wp_enqueue_style("custom",get_template_directory_uri().'/custom.css', array(), $etheme_theme_data->Version);  
            }

            $etheme_color_version = etheme_get_option('main_color_scheme');
            
            if($etheme_color_version=='dark') {
                wp_enqueue_style("dark",get_template_directory_uri().'/css/dark.css', array(), $etheme_theme_data->Version);  
            }

            $script_depends = array();

            if(class_exists('WooCommerce')) {
                $script_depends = array('wc-add-to-cart-variation');
            }
            
                
            wp_enqueue_script('head', get_template_directory_uri().'/js/head.js'); // modernizr, owl carousel, Swiper, FullWidth helper
            if(etheme_get_option('product_img_hover') == 'tooltip')
                wp_enqueue_script('tooltip', get_template_directory_uri().'/js/tooltip.js');
            wp_enqueue_script('jquery');
            wp_enqueue_script('all_plugins', get_template_directory_uri().'/js/plugins.min.js',$script_depends,false,true);
            wp_enqueue_script('waypoints');
            // IN HEAD.js wp_enqueue_script('owlcarousel', get_template_directory_uri().'/js/owl.carousel.min.js');
            /*wp_enqueue_script('flexslider', get_template_directory_uri().'/js/jquery.flexslider-min.js',array(),false,true);
            wp_enqueue_script('emodal', get_template_directory_uri().'/js/emodal.js',array(),false,true);
            wp_enqueue_script('magnific-popup', get_template_directory_uri().'/js/jquery.magnific-popup.min.js',array(),false,true);
            wp_enqueue_script('hoverIntent', get_template_directory_uri().'/js/jquery.hoverIntent.js',array(),false,true);
            wp_enqueue_script('masonry', get_template_directory_uri().'/js/jquery.masonry.min.js',array(),false,true);
            wp_enqueue_script('mousewheel', get_template_directory_uri().'/js/jquery.mousewheel.js',array(),false,true);
            wp_enqueue_script('easing', get_template_directory_uri().'/js/jquery.easing-1.3.js',array(),false,true);
            wp_enqueue_script('touch', get_template_directory_uri().'/js/touch.js',array(),false,true);
            wp_enqueue_script('cookie', get_template_directory_uri().'/js/cookie.js',array(),false,true);
            wp_enqueue_script('zoom', get_template_directory_uri().'/js/zoom.js',array(),false,true);
            wp_enqueue_script('cbpQTRotator', get_template_directory_uri().'/js/jquery.cbpQTRotator.min.js',array(),false,true);
            wp_enqueue_script('nicescroll', get_template_directory_uri().'/js/jquery.nicescroll.min.js',array(),false,true);
            wp_enqueue_script('bootstrap', get_template_directory_uri().'/js/bootstrap.min.js',array(),false,true);
            wp_enqueue_script('favico', get_template_directory_uri().'/js/favico-0.3.0.min.js',array(),false,true);
            wp_enqueue_script('media-elements', get_template_directory_uri().'/js/mediaelement-and-player.min.js',array(),false,true);*/
            wp_enqueue_script('etheme', get_template_directory_uri().'/js/etheme.js',$script_depends,false,true);
            wp_localize_script( 'etheme', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'noresults' => __('No results were found!', ETHEME_DOMAIN)));
         
        }
    }
}

add_action( 'wp_enqueue_scripts', 'etheme_enqueue_styles', 30);

// **********************************************************************// 
// ! Screet chat fix
// **********************************************************************// 

define('SC_CHAT_LICENSE_KEY', '69e13e4c-3dfd-4a70-83c8-3753507f5ae8');
if(!function_exists('etheme_chat_init')) {
    function etheme_chat_init () {
        update_option('sc_chat_validate_license', 1);
    }  
}

add_action( 'after_setup_theme', 'etheme_chat_init');

// **********************************************************************// 
// ! Function for disabling Responsive layout
// **********************************************************************// 
if(!function_exists('etheme_set_responsive')) {
    function etheme_set_responsive() {
        global $etheme_responsive;
        $etheme_responsive = etheme_get_option('responsive');
        if(isset($_COOKIE['responsive'])) {
        	$etheme_responsive = false;
        }
    	if(isset($_GET['responsive']) && $_GET['responsive'] == 'off') {
    		if (!isset($_COOKIE['responsive'])) {
    			setcookie('responsive', 1, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
    		}
    		wp_redirect(get_home_url()); exit();
    	}elseif(isset($_GET['responsive']) && $_GET['responsive'] == 'on') {
    		if (isset($_COOKIE['responsive'])) {
    			setcookie('responsive', 1, time()-1209600, COOKIEPATH, COOKIE_DOMAIN, false);
    		}
    		wp_redirect(get_home_url()); exit();
    	}
    }  
}

add_action( 'init', 'etheme_set_responsive');

if(!function_exists('et_http')) {
	function et_http() {
		return (is_ssl())?"https://":"http://";
	}
}

if(!function_exists('et_print_filters_for')) {
	function et_print_filters_for( $hook = '' ) {
	    global $wp_filter;
	    if( empty( $hook ) || !isset( $wp_filter[$hook] ) )
	        return;
	
	    print '<pre>';
	    print_r( $wp_filter[$hook] );
	    print '</pre>';
	}
}


// **********************************************************************// 
// ! BBPress add user role
// **********************************************************************// 
if(!function_exists('etheme_bb_user_role')) {
    function etheme_bb_user_role() {
    	if(!function_exists('bbp_is_deactivation')) return;
    	
	 	// Bail if deactivating bbPress
	 	
		if ( bbp_is_deactivation() )
			return;
	
		// Catch all, to prevent premature user initialization
		if ( ! did_action( 'set_current_user' ) )
			return;
	
		// Bail if not logged in or already a member of this site
		if ( ! is_user_logged_in() )
			return;
	
		// Get the current user ID
		$user_id = get_current_user_id();
	
		// Bail if user already has a forums role
		if ( bbp_get_user_role( $user_id ) )
			return;
	
		// Bail if user is marked as spam or is deleted
		if ( bbp_is_user_inactive( $user_id ) )
			return;
	
		/** Ready *****************************************************************/
	
		// Load up bbPress once
		$bbp         = bbpress();
	
		// Get whether or not to add a role to the user account
		$add_to_site = bbp_allow_global_access();
	
		// Get the current user's WordPress role. Set to empty string if none found.
		$user_role   = bbp_get_user_blog_role( $user_id );
	
		// Get the role map
		$role_map    = bbp_get_user_role_map();
	
		/** Forum Role ************************************************************/
	
		// Use a mapped role
		if ( isset( $role_map[$user_role] ) ) {
			$new_role = $role_map[$user_role];
	
		// Use the default role
		} else {
			$new_role = bbp_get_default_role();
		}
		
		/** Add or Map ************************************************************/
	
		// Add the user to the site
		if ( true === $add_to_site ) {
	
			// Make sure bbPress roles are added
			bbp_add_forums_roles();
	
			$bbp->current_user->add_role( $new_role );
	
		// Don't add the user, but still give them the correct caps dynamically
		} else {		
			$bbp->current_user->caps[$new_role] = true;
			$bbp->current_user->get_role_caps();
		}
    
		$new_role = bbp_get_default_role();
		
		bbp_set_user_role( $user_id, $new_role );
    }  
}

add_action( 'init', 'etheme_bb_user_role');



// **********************************************************************// 
// ! Exclude some css from minifier
// **********************************************************************// 


add_filter('bwp_minify_style_ignore', 'et_exclude_css');

if(!function_exists('et_exclude_css')) {
    function et_exclude_css($excluded) {
        $excluded = array('font-awesome');
        return $excluded;
    } 
}


// **********************************************************************// 
// ! Add classes to body
// **********************************************************************//
add_filter('body_class','et_add_body_classes');
if(!function_exists('et_add_body_classes')) {
    function et_add_body_classes($classes) {
        if(etheme_get_option('top_panel')) $classes[] = 'topPanel-enabled ';  
        if(etheme_get_option('right_panel')) $classes[] = 'rightPanel-enabled ';  
        if(etheme_get_option('fixed_nav')) $classes[] = 'fixNav-enabled ';
        if(etheme_get_option('fade_animation')) $classes[] = 'fadeIn-enabled ';
        if(etheme_get_option('cats_accordion')) $classes[] = 'accordion-enabled ';
        if(!class_exists('Woocommerce') || etheme_get_option('just_catalog') || !etheme_get_option('cart_widget')) $classes[] = 'top-cart-disabled ';
        $classes[] = 'banner-mask-'.etheme_get_option('banner_mask');
        $classes[] = etheme_get_option('main_layout');
        return $classes;
    }
}
// **********************************************************************// 
// ! Ititialize theme confoguration and variables
// **********************************************************************// 
add_action('wp_head', 'etheme_init');
if(!function_exists('etheme_init')) {
    function etheme_init() {
        global $etheme_responsive;
        foreach(etheme_get_chosen_google_font() as $font) {
            ?>
                <link href='<?php echo et_http() ?>fonts.googleapis.com/css?family=<?php echo $font; ?>' rel='stylesheet' type='text/css'/>
            <?php 
        }
        ?>

            <style type="text/css">

                <?php if ( etheme_get_option('sale_icon') ) : ?>
                    .label-icon.sale-label { 
                        width: <?php echo (etheme_get_option('sale_icon_width')) ? etheme_get_option('sale_icon_width') : 67 ?>px; 
                        height: <?php echo (etheme_get_option('sale_icon_height')) ? etheme_get_option('sale_icon_height') : 67 ?>px;
                    }            
                    .label-icon.sale-label { background-image: url(<?php echo (etheme_get_option('sale_icon_url')) ? etheme_get_option('sale_icon_url') : get_template_directory_uri() .'/images/label-sale.png' ?>); }
                <?php endif; ?>
                
                <?php if ( etheme_get_option('new_icon') ) : ?>
                    .label-icon.new-label { 
                        width: <?php echo (etheme_get_option('new_icon_width')) ? etheme_get_option('new_icon_width') : 67 ?>px; 
                        height: <?php echo (etheme_get_option('new_icon_height')) ? etheme_get_option('new_icon_height') : 67 ?>px;
                    }            
                    .label-icon.new-label { background-image: url(<?php echo (etheme_get_option('new_icon_url')) ? etheme_get_option('new_icon_url') : get_template_directory_uri() .'/images/label-new.png' ?>); }
                    
                <?php endif; ?>

            </style>

            <div id="styles-bg">
                <style type="text/css">
                    <?php $bg = etheme_get_option('background_img'); ?>
                    body {
                        <?php if(!empty($bg['background-color'])): ?>  background-color: <?php echo $bg['background-color']; ?>;<?php endif; ?>
                        <?php if(!empty($bg['background-image'])): ?>  background-image: url(<?php echo $bg['background-image']; ?>) ; <?php endif; ?>
                        <?php if(!empty($bg['background-attachment'])): ?>  background-attachment: <?php echo $bg['background-attachment']; ?>;<?php endif; ?>
                        <?php if(!empty($bg['background-repeat'])): ?>  background-repeat: <?php echo $bg['background-repeat']; ?>;<?php  endif; ?>
                        <?php if(!empty($bg['background-color'])): ?>  background-color: <?php echo $bg['background-color']; ?>;<?php  endif; ?>
                        <?php if(!empty($bg['background-position'])): ?>  background-position: <?php echo $bg['background-position']; ?>;<?php endif; ?>
                        <?php if(etheme_get_option('background_cover') == 'enable'): ?>
                            background-size: cover;
                        <?php endif; ?>
                    }
                </style>
            </div>
            <?php 

                $selectors = array();
                $selectors['main_font'] = '
                    .dropcap,
                    blockquote,
                    .team-member .member-mask .mask-text fieldset legend,
                    .button,
                    button,
                    .coupon .button,
                    input[type="submit"],
                    .font2,
                    .shopping-cart-widget .totals,
                    .main-nav .menu > li > a,
                    .menu-wrapper .menu .nav-sublist-dropdown .menu-parent-item > a,
                    .fixed-header .menu .nav-sublist-dropdown .menu-parent-item > a,
                    .fixed-header .menu > li > a,
                    .side-block .close-block,
                    .side-area .widget-title,
                    .et-mobile-menu li > a,
                    .page-heading .row-fluid .span12 > .back-to,
                    .breadcrumbs .back-to,
                    .recent-post-mini a,
                    .etheme_widget_recent_comments ul li .post-title,
                    .product_list_widget a,
                    .widget_price_filter .widget-title,
                    .widget_layered_nav .widget-title,
                    .widget_price_filter h4,
                    .widget_layered_nav h4,
                    .products-list .product .product-name,
                    .table.products-table th,
                    .table.products-table .product-name a,
                    .table.products-table .product-name dl dt,
                    .table.products-table .product-name dl dd,
                    .cart_totals .table .total th strong,
                    .cart_totals .table .total td strong .amount,
                    .pricing-table table .plan-price,
                    .pricing-table table.table thead:first-child tr:first-child th,
                    .pricing-table.style3 table .plan-price sup,
                    .pricing-table.style2 table .plan-price sup,
                    .pricing-table ul li.row-title,
                    .pricing-table ul li.row-price,
                    .pricing-table.style2 ul li.row-price sup,
                    .pricing-table.style3 ul li.row-price sup,
                    .tabs .tab-title,
                    .left-bar .left-titles .tab-title-left,
                    .right-bar .left-titles .tab-title-left,
                    .slider-container .show-all-posts,
                    .bc-type-variant2 .woocommerce-breadcrumb,
                    .bc-type-variant2 .breadcrumbs,
                    .post-single .post-share .share-title,
                    .toggle-element .toggle-title,
                    #bbpress-forums li.bbp-header,
					#bbpress-forums .bbp-forum-title,
					#bbpress-forums .bbp-topic-title,
					#bbpress-forums .bbp-reply-title,
					.product-thumbnails-slider .slides li.video-thumbnail span,
					.coupon label,
					.product-image-wrapper .out-of-stock,
					.shop_table .product-name a,
					.shop_table th,
					.cart_totals .order-total th,
					.page-heading .row-fluid .span12 .back-to,
					.woocommerce table.shop_table th, 
					.woocommerce-page table.shop_table th
                ';
                
                $selectors['font_color'] = '
                    body,
                    select,
                    .products-small .product-item a,
                    .woocommerce-breadcrumb,
                    #breadcrumb,
                    .woocommerce-breadcrumb a,
                    #breadcrumb a,
                    .etheme_widget_recent_comments .comment_link a,
                    .product-categories li ul a,
                    .product_list_widget del .amount,
                    .page-numbers li a,
                    .page-numbers li span,
                    .pagination li a,
                    .pagination li span,
                    .images .main-image-slider ul.slides .zoom-link:hover,
                    .quantity .qty,
                    .price .from,
                    .price del,
                    .shopping-cart-widget .cart-summ .items,
                    .shopping-cart-widget .cart-summ .for-label,
                    .posted-in a,
                    .tabs .tab-title,
                    .toggle-element .open-this,
                    .blog-post .post-info .posted-in a,
                    .menu-type1 .menu ul > li > a,
                    .post-next-prev a

                ';
                $selectors['active_color'] = '
                    a:hover,
                    .button:hover,
                    button:hover,
                    input[type="submit"]:hover,
                    .menu-icon:hover,
                    .widget_layered_nav ul li:hover,
                    .page-numbers li span,
                    .pagination li span,
                    .page-numbers li a:hover,
                    .pagination li a:hover,
                    .largest,
                    .thumbnail:hover i,
                    .demo-icons .demo-icon:hover,
                    .demo-icons .demo-icon:hover i,
                    .switchToGrid:hover, 
                    .switchToList:hover, 
                    .switcher-active, 
                    .switcher-active:hover,
                    .emodal .close-modal:hover,
                    .prev.page-numbers:hover:after, 
                    .next.page-numbers:hover:after,
                    strong.active,
                    span.active,
                    em.active,
                    a.active,
                    p.active,
                    .shopping-cart-widget .cart-summ .price-summ,
                    .products-small .product-item h5 a:hover,
                    .slider-container .slider-next:hover:before, 
                    .slider-container .slider-prev:hover:before,
                    .fullwidthbanner-container .tp-rightarrow.default:hover:before, 
                    .fullwidthbanner-container .tp-leftarrow.default:hover:before,
                    .side-area .close-block:hover i,
                    .back-to-top:hover, .back-to-top:hover i,
                    .product-info .single_add_to_wishlist:hover:before,
                    .images .main-image-slider ul.slides .zoom-link i:hover,
                    .footer_menu li:hover:before,
                    .main-nav .menu > li.current-menu-parent > a,
                    .main-nav .menu > li.current-menu-item > a,
                    .page-numbers .next:hover:before, 
                    .pagination .next:hover:before,
                    .etheme_twitter .tweet a,
                    .small-slider-arrow.arrow-left:hover,
                    .small-slider-arrow.arrow-right:hover,
                    .active2:hover,
                    .active2,
                    .checkout-steps-nav a.button.active,
                    .checkout-steps-nav a.button.active:hover,
                    .button.active,
                    button.active,
                    input[type="submit"].active,
                    .widget_categories .current-cat a,
                    div.dark_rounded .pp_contract:hover,
                    div.dark_rounded .pp_expand:hover,
                    div.dark_rounded .pp_close:hover,
                    .etheme_cp .etheme_cp_head .etheme_cp_btn_close:hover,
                    .hover-icon:hover,
                    .side-area-icon:hover,
                    .etheme_cp .etheme_cp_content .etheme_cp_section .etheme_cp_section_header .etheme_cp_btn_clear:hover,
                    .header-type-3 .main-nav .menu-wrapper .menu > li.current-menu-item > a, 
                    .header-type-3 .main-nav .menu-wrapper .menu > li.current-menu-parent > a,
                    .header-type-3 .main-nav .menu-wrapper .menu > li > a:hover,
                    .fixed-header .menu > li.current-menu-item > a,
                    .fixed-header .menu > li > a:hover,
                    .main-nav .menu > li > a:hover,
                    .product-categories > li > a:hover,
                    .custom-info-block.a-right span, 
                    .custom-info-block.a-left span,
                    .custom-info-block a i:hover,
                    .product-categories > li.current-cat > a,
                    .menu-wrapper .menu .nav-sublist-dropdown .menu-parent-item > a:hover,
                    .woocommerce .woocommerce-breadcrumb a:hover, 
                    .woocommerce-page .woocommerce-breadcrumb a:hover,
                    .product-info .posted_in a:hover,
                    .slide-item .product .products-page-cats a:hover, 
                    .products-grid .product .products-page-cats a:hover,
                    .widget_layered_nav ul li:hover a,
                    .page-heading .row-fluid .span12 > .back-to:hover,
                    .breadcrumbs .back-to:hover,
                    #breadcrumb a:hover,
                    .links li a:hover,
					.menu-wrapper .menu > .nav-sublist-dropdown .menu-parent-item ul li:hover, 
					.menu-wrapper .menu > .nav-sublist-dropdown .menu-parent-item ul li:hover a,
					.menu-wrapper .menu ul > li > a:hover,
                    .filled.active,
                    .shopping-cart-widget .cart-summ a:hover,
                    .product-categories > li > ul > li > a:hover,
                    .product-categories > li > ul > li > a:hover + span,
                    .product-categories ul.children li > a:hover,
                    .product-categories ul.children li > a:hover + span,
                    .product-categories > li.current-cat > a+span,
                    .widget_nav_menu .current-menu-item a,
                    .widget_nav_menu .current-menu-item:before,
                    .fixed-menu-type2 .fixed-header .nav-sublist-dropdown li a:hover,
                    .product-category h5:hover,
                    .product-categories .children li.current-cat,
                    .product-categories .children li.current-cat a,
                    .product-categories .children li.current-cat span,
                    .pricing-table ul li.row-price,
                    .product-category:hover h5,
                    .widget_nav_menu li a:hover,
                    .widget_nav_menu li:hover:before,
                    .list li:before,
                    .blog-post .post-info a:hover,
					.show-all-posts:hover,
                    .cbp-qtrotator .testimonial-author .excerpt,
                    .top-bar .wishlist-link a:hover span,
                    .menu-type2 .menu .nav-sublist-dropdown .menu-parent-item li:hover:before,
                    .back-to-top:hover:before,
                    .tabs .tab-title:hover,
                    .flex-direction-nav a:hover,
                    .widget_layered_nav ul li a:hover,
                    .widget_layered_nav ul li:hover,
                    .product-categories .open-this:hover,
                    .widget_categories li:hover:before,
                    .etheme-social-icons li a:hover,
                    .product-categories > li.opened .open-this:hover,
                    .slider-container .show-all-posts:hover,
                    .widget_layered_nav ul li.chosen .count,
                    .widget_layered_nav ul li.chosen a,
                    .widget_layered_nav ul li.chosen a:before,
                    .recent-post-mini strong,
                    .menu-wrapper .menu ul > li:hover:before, 
                    .fixed-header .menu ul > li:hover:before,
                    .team-member .member-mask .mask-text a:hover,
                    .show-quickly:hover,
                    .header-type-6 .top-bar .top-links .submenu-dropdown ul li a:hover,
                    .header-type-6 .top-bar .top-links .submenu-dropdown ul li:hover:before,
                    .side-area-icon i:hover:before, 
                    .menu-icon i:hover:before,
                    a.bbp-author-name,
                    #bbpress-forums #bbp-single-user-details #bbp-user-navigation li.current a,
                    #bbpress-forums #bbp-single-user-details #bbp-user-navigation li.current:before,
					.bbp-forum-header a.bbp-forum-permalink,
					.bbp-topic-header a.bbp-topic-permalink,
					.bbp-reply-header a.bbp-reply-permalink,
					.et-tweets.owl-carousel .owl-prev:hover:before,
					.et-tweets.owl-carousel .owl-next:hover:before,
					.etheme_widget_brands ul li.active-brand a,
                    .comment-block .author-link a:hover,
                    .header-type-3 .shopping-cart-link span.amount, 
                    .header-type-4 .shopping-cart-link span.amount, 
                    .header-type-6 .shopping-cart-link span.amount
                ';

                // important
                $selectors['active_color_important'] = '
                    .hover-icon:hover,
                    .breadcrumbs .back-to:hover
                ';

                // Price COLOR!
                $selectors['pricecolor'] = '
                    .products-small .product-item .price,
                    .product_list_widget .amount,
                    .cart_totals .table .total .amount,
                    .price
                ';

                $selectors['active_bg'] = '
                    .filled:hover,
                    .progress-bar > div,
                    .active2:hover,
                    .button.active:hover,
                    button.active:hover,
                    input[type="submit"].active:hover,
                    .checkout-steps-nav a.button.active:hover,
                    .portfolio-filters .active,
                    .product-info .single_add_to_cart_button,
                    .product-info .single_add_to_wishlist:hover,
                    .checkout-button.button,
                    .checkout-button.button:hover,
                    .header-type-6 .top-bar, 
					.filled.active,
					.block-with-ico.ico-position-top i,
                    .added-text,
                    .etheme_cp_btn_show,
                    .toolbar .switchToList:hover, 
                    .toolbar .switchToList.switcher-active,
                    .toolbar .switchToGrid:hover, 
                    .toolbar .switchToGrid.switcher-active,
                    .button.white.filled:hover,
                    .button.active,
                    .button.active2,
                    .button.white:hover
                ';
                $selectors['active_border'] = '
                    .button:hover,
                    button:hover,
                    .button.white.filled:hover,
                    input[type="submit"]:hover,
                    .button.active,
                    button.active,
                    input[type="submit"].active,
                    .filled:hover,
                    .widget_layered_nav ul li:hover,
                    .page-numbers li span,
                    .pagination li span,
                    .page-numbers li a:hover,
                    .pagination li a:hover,
                    .switchToGrid:hover, 
                    .switchToList:hover, 
                    .toolbar .switchToGrid.switcher-active,
                    .toolbar .switchToList.switcher-active, 
                    textarea:focus,
                    input[type="text"]:focus,
                    input[type="password"]:focus,
                    input[type="datetime"]:focus,
                    input[type="datetime-local"]:focus,
                    input[type="date"]:focus,
                    input[type="month"]:focus,
                    input[type="time"]:focus,
                    input[type="week"]:focus,
                    input[type="number"]:focus,
                    input[type="email"]:focus,
                    input[type="url"]:focus,
                    input[type="search"]:focus,
                    input[type="tel"]:focus,
                    input[type="color"]:focus,
                    .uneditable-input:focus,
                    .active2,
                    .woocommerce.widget_price_filter .ui-slider .ui-slider-range, 
                    .woocommerce-page .widget_price_filter .ui-slider .ui-slider-range,
                    .checkout-steps-nav a.button.active,
                    .product-info .single_add_to_cart_button,
                    .main-nav .menu > li.current-menu-parent > a:before, 
                    .main-nav .menu > li.current-menu-item > a:before,
                    .cta-block.style-filled,
                    .search #searchform input[type="text"]:focus,
                    .product-categories .open-this:hover,
                    .product-categories > li.opened .open-this:hover

                ';


                $selectors['darken_color'] = '
                ';

                $selectors['darken_bg'] = '
                    .woocommerce.widget_price_filter .ui-slider .ui-slider-handle
                ';

                $selectors['darken_border'] = '
                ';
            ?>

            <style type="text/css">
                <?php echo jsString($selectors['font_color']); ?> { color: #6f6f6f; }
            </style>

            <?php 
                $activeColor = (etheme_get_option('activecol')) ? etheme_get_option('activecol') : '#d7a200';
                $priceColor = (etheme_get_option('pricecolor')) ? etheme_get_option('pricecolor') : '#d7a200';

                $rgb = hex2rgb($activeColor);
                

                $darkenRgb = array();

                $darkenRgb[0] = ($rgb[0] > 30) ? $rgb[0] - 30 : 0;
                $darkenRgb[1] = ($rgb[1] > 30) ? $rgb[1] - 30 : 0;
                $darkenRgb[2] = ($rgb[2] > 30) ? $rgb[2] - 30 : 0;

                $darkenColor = 'rgb('.$darkenRgb[0].','.$darkenRgb[1].','.$darkenRgb[2].')';
                
            ?>

            <div id="styles-main-color">
                <style type="text/css">
                <?php echo jsString($selectors['active_color']); ?>              { color: <?php echo $activeColor; ?>; }

                <?php echo jsString($selectors['active_color_important']); ?>    { color: <?php echo $activeColor; ?>!important; }

                <?php echo jsString($selectors['active_bg']); ?>                 { background-color: <?php echo $activeColor; ?>; }

                <?php echo jsString($selectors['active_border']); ?>             { border-color: <?php echo $activeColor; ?>; }

                </style>
            </div>

            <div id="styles-price-color">
                <style type="text/css">
                    <?php echo jsString($selectors['pricecolor']); ?>              { color: <?php echo $priceColor; ?>; }
                </style>
            </div>

            <div id="styles-darken-color">
                <style type="text/css">
                <?php echo jsString($selectors['darken_color']); ?>              { color: <?php echo $darkenColor; ?>; }

                <?php echo jsString($selectors['darken_bg']); ?>                 { background-color: <?php echo $darkenColor; ?>; }

                <?php echo jsString($selectors['darken_border']); ?>             { border-color: <?php echo $darkenColor; ?>; }

                </style>
            </div>

            <style>
                .woocommerce.widget_price_filter .ui-slider .ui-slider-range, 
                .woocommerce-page .widget_price_filter .ui-slider .ui-slider-range{
                  background: <?php echo 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.35)' ?>;
                }

            </style>

            <style type="text/css">
                <?php $h1 = etheme_get_option('h1'); ?>
                <?php $h2 = etheme_get_option('h2'); ?>
                <?php $h3 = etheme_get_option('h3'); ?>
                <?php $h4 = etheme_get_option('h4'); ?>
                <?php $h5 = etheme_get_option('h5'); ?>
                <?php $h6 = etheme_get_option('h6'); ?>
                <?php $sfont = etheme_get_option('sfont'); ?>
                <?php $mainfont = etheme_get_option('mainfont'); ?>
                
                body {
                    <?php if(!empty($sfont['font-color'])) :?>      color: <?php echo $sfont['font-color'].';'; endif; ?>
                    <?php if(!empty($sfont['font-family'])): ?>     font-family: <?php echo $sfont['font-family'].';'; endif; ?>
                    <?php if(!empty($sfont['google-font'])): ?>     font-family: <?php echo str_replace("+", " ", $sfont['google-font']).';'; endif; ?>
                    <?php if(!empty($sfont['font-size'])): ?>       font-size: <?php echo $sfont['font-size'].';'; endif; ?>
                    <?php if(!empty($sfont['font-style'])): ?>      font-style: <?php echo $sfont['font-style'].';'; endif; ?>
                    <?php if(!empty($sfont['font-weight'])): ?>     font-weight: <?php echo $sfont['font-weight'].';'; endif; ?>
                    <?php if(!empty($sfont['font-variant'])): ?>    font-variant: <?php echo $sfont['font-variant'].';'; endif; ?>
                    <?php if(!empty($sfont['letter-spacing'])): ?>  letter-spacing: <?php echo $sfont['letter-spacing'].';'; endif; ?>
                    <?php if(!empty($sfont['line-height'])): ?>     line-height: <?php echo $sfont['line-height'].';'; endif; ?>
                    <?php if(!empty($sfont['text-decoration'])): ?> text-decoration:  <?php echo $sfont['text-decoration'].';'; endif; ?>
                    <?php if(!empty($sfont['text-transform'])): ?>  text-transform:  <?php echo $sfont['text-transform'].';'; endif; ?>
                }
                
                h1 {
                    <?php if(!empty($h1['font-color'])) :?>      color: <?php echo $h1['font-color'].';'; endif; ?>
                    <?php if(!empty($h1['font-family'])): ?>     font-family: <?php echo $h1['font-family'].';'; endif; ?>
                    <?php if(!empty($h1['google-font'])): ?>     font-family: <?php echo str_replace("+", " ", $h1['google-font']).';'; endif; ?>
                    <?php if(!empty($h1['font-size'])): ?>       font-size: <?php echo $h1['font-size'].';'; endif; ?>
                    <?php if(!empty($h1['font-style'])): ?>      font-style: <?php echo $h1['font-style'].';'; endif; ?>
                    <?php if(!empty($h1['font-weight'])): ?>     font-weight: <?php echo $h1['font-weight'].';'; endif; ?>
                    <?php if(!empty($h1['font-variant'])): ?>    font-variant: <?php echo $h1['font-variant'].';'; endif; ?>
                    <?php if(!empty($h1['letter-spacing'])): ?>  letter-spacing: <?php echo $h1['letter-spacing'].';'; endif; ?>
                    <?php if(!empty($h1['line-height'])): ?>     line-height: <?php echo $h1['line-height'].';'; endif; ?>
                    <?php if(!empty($h1['text-decoration'])): ?> text-decoration:  <?php echo $h1['text-decoration'].';'; endif; ?>
                    <?php if(!empty($h1['text-transform'])): ?>  text-transform:  <?php echo $h1['text-transform'].';'; endif; ?>
                }
                h2 {
                    <?php if(!empty($h2['font-color'])) :?>      color: <?php echo $h2['font-color'].';'; endif; ?>
                    <?php if(!empty($h2['font-family'])): ?>     font-family: <?php echo $h2['font-family'].';'; endif; ?>
                    <?php if(!empty($h2['google-font'])): ?>     font-family: <?php echo str_replace("+", " ", $h2['google-font']).';'; endif; ?>
                    <?php if(!empty($h2['font-size'])): ?>       font-size: <?php echo $h2['font-size'].';'; endif; ?>
                    <?php if(!empty($h2['font-style'])): ?>      font-style: <?php echo $h2['font-style'].';'; endif; ?>
                    <?php if(!empty($h2['font-weight'])): ?>     font-weight: <?php echo $h2['font-weight'].';'; endif; ?>
                    <?php if(!empty($h2['font-variant'])): ?>    font-variant: <?php echo $h2['font-variant'].';'; endif; ?>
                    <?php if(!empty($h2['letter-spacing'])): ?>  letter-spacing: <?php echo $h2['letter-spacing'].';'; endif; ?>
                    <?php if(!empty($h2['line-height'])): ?>     line-height: <?php echo $h2['line-height'].';'; endif; ?>
                    <?php if(!empty($h2['text-decoration'])): ?> text-decoration:  <?php echo $h2['text-decoration'].';'; endif; ?>
                    <?php if(!empty($h2['text-transform'])): ?>  text-transform:  <?php echo $h2['text-transform'].';'; endif; ?>
                }
                h3 {
                    <?php if(!empty($h3['font-color'])) :?>      color: <?php echo $h3['font-color'].';'; endif; ?>
                    <?php if(!empty($h3['font-family'])): ?>     font-family: <?php echo $h3['font-family'].';'; endif; ?>
                    <?php if(!empty($h3['google-font'])): ?>     font-family: <?php echo str_replace("+", " ", $h3['google-font']).';'; endif; ?>
                    <?php if(!empty($h3['font-size'])): ?>       font-size: <?php echo $h3['font-size'].';'; endif; ?>
                    <?php if(!empty($h3['font-style'])): ?>      font-style: <?php echo $h3['font-style'].';'; endif; ?>
                    <?php if(!empty($h3['font-weight'])): ?>     font-weight: <?php echo $h3['font-weight'].';'; endif; ?>
                    <?php if(!empty($h3['font-variant'])): ?>    font-variant: <?php echo $h3['font-variant'].';'; endif; ?>
                    <?php if(!empty($h3['letter-spacing'])): ?>  letter-spacing: <?php echo $h3['letter-spacing'].';'; endif; ?>
                    <?php if(!empty($h3['line-height'])): ?>     line-height: <?php echo $h3['line-height'].';'; endif; ?>
                    <?php if(!empty($h3['text-decoration'])): ?> text-decoration:  <?php echo $h3['text-decoration'].';'; endif; ?>
                    <?php if(!empty($h3['text-transform'])): ?>  text-transform:  <?php echo $h3['text-transform'].';'; endif; ?>
                }
                h4 {
                    <?php if(!empty($h4['font-color'])) :?>      color: <?php echo $h4['font-color'].';'; endif; ?>
                    <?php if(!empty($h4['font-family'])): ?>     font-family: <?php echo $h4['font-family'].';'; endif; ?>
                    <?php if(!empty($h4['google-font'])): ?>     font-family: <?php echo str_replace("+", " ", $h4['google-font']).';'; endif; ?>
                    <?php if(!empty($h4['font-size'])): ?>       font-size: <?php echo $h4['font-size'].';'; endif; ?>
                    <?php if(!empty($h4['font-style'])): ?>      font-style: <?php echo $h4['font-style'].';'; endif; ?>
                    <?php if(!empty($h4['font-weight'])): ?>     font-weight: <?php echo $h4['font-weight'].';'; endif; ?>
                    <?php if(!empty($h4['font-variant'])): ?>    font-variant: <?php echo $h4['font-variant'].';'; endif; ?>
                    <?php if(!empty($h4['letter-spacing'])): ?>  letter-spacing: <?php echo $h4['letter-spacing'].';'; endif; ?>
                    <?php if(!empty($h4['line-height'])): ?>     line-height: <?php echo $h4['line-height'].';'; endif; ?>
                    <?php if(!empty($h4['text-decoration'])): ?> text-decoration:  <?php echo $h4['text-decoration'].';'; endif; ?>
                    <?php if(!empty($h4['text-transform'])): ?>  text-transform:  <?php echo $h4['text-transform'].';'; endif; ?>
                }
                h5 {
                    <?php if(!empty($h5['font-color'])) :?>      color: <?php echo $h5['font-color'].';'; endif; ?>
                    <?php if(!empty($h5['font-family'])): ?>     font-family: <?php echo $h5['font-family'].';'; endif; ?>
                    <?php if(!empty($h5['google-font'])): ?>     font-family: <?php echo str_replace("+", " ", $h5['google-font']).';'; endif; ?>
                    <?php if(!empty($h5['font-size'])): ?>       font-size: <?php echo $h5['font-size'].';'; endif; ?>
                    <?php if(!empty($h5['font-style'])): ?>      font-style: <?php echo $h5['font-style'].';'; endif; ?>
                    <?php if(!empty($h5['font-weight'])): ?>     font-weight: <?php echo $h5['font-weight'].';'; endif; ?>
                    <?php if(!empty($h5['font-variant'])): ?>    font-variant: <?php echo $h5['font-variant'].';'; endif; ?>
                    <?php if(!empty($h5['letter-spacing'])): ?>  letter-spacing: <?php echo $h5['letter-spacing'].';'; endif; ?>
                    <?php if(!empty($h5['line-height'])): ?>     line-height: <?php echo $h5['line-height'].';'; endif; ?>
                    <?php if(!empty($h5['text-decoration'])): ?> text-decoration:  <?php echo $h5['text-decoration'].';'; endif; ?>
                    <?php if(!empty($h5['text-transform'])): ?>  text-transform:  <?php echo $h5['text-transform'].';'; endif; ?>
                }         
                h6 {
                    <?php if(!empty($h6['font-color'])) :?>      color: <?php echo $h6['font-color'].';'; endif; ?>
                    <?php if(!empty($h6['font-family'])): ?>     font-family: <?php echo $h6['font-family'].';'; endif; ?>
                    <?php if(!empty($h6['google-font'])): ?>     font-family: <?php echo str_replace("+", " ", $h6['google-font']).';'; endif; ?>
                    <?php if(!empty($h6['font-size'])): ?>       font-size: <?php echo $h6['font-size'].';'; endif; ?>
                    <?php if(!empty($h6['font-style'])): ?>      font-style: <?php echo $h6['font-style'].';'; endif; ?>
                    <?php if(!empty($h6['font-weight'])): ?>     font-weight: <?php echo $h6['font-weight'].';'; endif; ?>
                    <?php if(!empty($h6['font-variant'])): ?>    font-variant: <?php echo $h6['font-variant'].';'; endif; ?>
                    <?php if(!empty($h6['letter-spacing'])): ?>  letter-spacing: <?php echo $h6['letter-spacing'].';'; endif; ?>
                    <?php if(!empty($h6['line-height'])): ?>     line-height: <?php echo $h6['line-height'].';'; endif; ?>
                    <?php if(!empty($h6['text-decoration'])): ?> text-decoration:  <?php echo $h6['text-decoration'].';'; endif; ?>
                    <?php if(!empty($h6['text-transform'])): ?>  text-transform:  <?php echo $h6['text-transform'].';'; endif; ?>
                }
                <?php echo jsString($selectors['main_font']); ?> {
                    <?php if(!empty($mainfont['font-color'])) :?>      color: <?php echo $mainfont['font-color'].';'; endif; ?>
                    <?php if(!empty($mainfont['font-family'])): ?>     font-family: <?php echo $mainfont['font-family'].';'; endif; ?>
                    <?php if(!empty($mainfont['google-font'])): ?>     font-family: <?php echo str_replace("+", " ", $mainfont['google-font']).';'; endif; ?>
                    <?php if(!empty($mainfont['font-size'])): ?>       font-size: <?php echo $mainfont['font-size'].';'; endif; ?>
                    <?php if(!empty($mainfont['font-style'])): ?>      font-style: <?php echo $mainfont['font-style'].';'; endif; ?>
                    <?php if(!empty($mainfont['font-weight'])): ?>     font-weight: <?php echo $mainfont['font-weight'].';'; endif; ?>
                    <?php if(!empty($mainfont['font-variant'])): ?>    font-variant: <?php echo $mainfont['font-variant'].';'; endif; ?>
                    <?php if(!empty($mainfont['letter-spacing'])): ?>  letter-spacing: <?php echo $mainfont['letter-spacing'].';'; endif; ?>
                    <?php if(!empty($mainfont['line-height'])): ?>     line-height: <?php echo $mainfont['line-height'].';'; endif; ?>
                    <?php if(!empty($mainfont['text-decoration'])): ?> text-decoration:  <?php echo $mainfont['text-decoration'].';'; endif; ?>
                    <?php if(!empty($mainfont['text-transform'])): ?>  text-transform:  <?php echo $mainfont['text-transform'].';'; endif; ?> 
                }
            </style>
            <script type="text/javascript">
                var active_color_selector = '<?php echo jsString($selectors['active_color']); ?>';
                var active_bg_selector = '<?php echo jsString($selectors['active_bg']); ?>';
                var active_border_selector = '<?php echo jsString($selectors['active_border']); ?>';
                var active_color_default = '<?php echo $activeColor; ?>';
                var bg_default = '<?php etheme_option('backgroundcol') ?>'; 
                var pattern_default = '<?php if(!empty($bg['background-image'])): echo $bg['background-image'];  endif; ?>'; 


                var ajaxFilterEnabled = <?php echo (etheme_get_option('ajax_filter')) ? 1 : 0; ?>;
                var successfullyAdded = '<?php _e('successfully added to your shopping cart', ETHEME_DOMAIN) ?>';
                var view_mode_default = '<?php echo etheme_get_option('view_mode'); ?>';
                var catsAccordion = false;
                <?php if (etheme_get_option('cats_accordion')) {
                    ?>
                        catsAccordion = true;
                    <?php
                } ?>
                <?php if (class_exists('WooCommerce')) {
                    global $woocommerce;
                    ?>
                        var checkoutUrl = '<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>';
                        var contBtn = '<?php _e('Continue shopping', ETHEME_DOMAIN) ?>';
                        var checkBtn = '<?php _e('Checkout', ETHEME_DOMAIN) ?>';
                    <?php
                } ?>
                <?php if(etheme_get_option('nice_scroll')): ?>
                    jQuery(document).ready(function(){
                        jQuery("body").niceScroll({
                            hidecursordelay: 100000,
                            scrollspeed: 60,
                            cursorwidth: 6,
                            cursorborder: '1px solid #909090',
                            cursorborderradius: 0,
                            horizrailenabled:false
                        });
                    });
                <?php endif; ?>
            </script>

        <?php if ($etheme_responsive): ?>
            <style type="text/css">
            @import url("<?php echo get_template_directory_uri(); ?>/css/large-resolution.css") (min-width:<?php echo (etheme_get_option('responsive_from')) ? etheme_get_option('responsive_from') : '1440' ; ?>px);
            </style>
        <?php endif;
    }
}


// **********************************************************************// 
// ! Add theme support
// **********************************************************************// 

if(function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails', array('post'));
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'woocommerce' );
}
// **********************************************************************// 
// ! Add admin styles and scripts
// **********************************************************************// 

add_action('admin_init', 'etheme_load_admin_styles');
function etheme_load_admin_styles() {
    wp_enqueue_style('farbtastic');
    wp_enqueue_style('etheme_admin_css', ETHEME_CODE_CSS_URL.'/admin.css');
}
add_action('admin_init','etheme_add_admin_script', 1130);

function etheme_add_admin_script(){
    add_thickbox();
    wp_enqueue_script('theme-preview');
    wp_enqueue_script('common');
    wp_enqueue_script('wp-lists');
    wp_enqueue_script('postbox');
    wp_enqueue_script('farbtastic');
    wp_enqueue_script('etheme_admin_js', ETHEME_CODE_JS_URL.'/admin.js',array('wpb_php_js','wpb_js_composer_js_view','wpb_js_composer_js_custom_views'),false,true);   
    wp_enqueue_style("font-awesome",get_template_directory_uri().'/css/font-awesome.min.css');
    wp_enqueue_style("font-lato",et_http()."fonts.googleapis.com/css?family=Lato:300,400,700,300italic");
}


// **********************************************************************// 
// ! Menus
// **********************************************************************// 
if(!function_exists('etheme_register_menus')) {
    function etheme_register_menus() {
        register_nav_menus(array(
            'main-menu' => __('Main menu', ETHEME_DOMAIN),
            'mobile-menu' => __('Mobile menu', ETHEME_DOMAIN),
            'account-menu' => __('Account menu', ETHEME_DOMAIN)
        ));
    }
}

add_action('init', 'etheme_register_menus');

// **********************************************************************// 
// ! Get logo
// **********************************************************************// 
if (!function_exists('etheme_logo')) {
    function etheme_logo() {
    	global $panel_filters;
        $logoimg = etheme_get_option('logo');
        $logoimg = apply_filters('etheme_logo_src',$logoimg); 
    	if($panel_filters) {
        	$logoimg = apply_filters('logo_panel_filters',$logoimg); 
    	}
    	?>
        <?php if($logoimg): ?>
            <a href="<?php echo home_url(); ?>"><img src="<?php echo $logoimg ?>" alt="<?php bloginfo( 'description' ); ?>" /></a>
        <?php else: ?>
            <a href="<?php echo home_url(); ?>"><img src="<?php echo PARENT_URL.'/images/logo.png'; ?>" alt="<?php bloginfo('name'); ?>"></a>
        <?php endif ;
    }
}

// **********************************************************************// 
// ! For demo site
// **********************************************************************// 
if(!function_exists('logo_panel_filters')) {
	add_filter('logo_panel_filters', 'logo_panel_filters');
	function logo_panel_filters($value) {
		global $post;
		$logo = '';
		switch($post->post_name) {
			case 'restaurant':
				$logo = '_restaurant';
			break;
			case 'toys':
				$logo = '_toys';
			break;
			case 'underwear':
				$logo = '_underwear';
			break;
			case 'sport':
				$logo = '_sport';
			break;
			case 'candy':
				$logo = '_candy';
			break;
			case 'watches':
				$logo = '_watches';
			break;
			case 'cars':
				$logo = '_cars';
			break;
			case 'games':
				$logo = '_games';
			break;
		}
		if($logo != '') 
		
			$value = get_etheme_panel_url().'images/params/logo'.$logo.'.png';
		
		return $value;
	}
}


if(!function_exists('etheme_top_links')) {
    function etheme_top_links() {
        ?>
            <ul class="links">
                <?php if ( is_user_logged_in() ) : ?>
                    <?php if(class_exists('Woocommerce')): ?> <li class="my-account-link"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php _e( 'Your Account', ETHEME_DOMAIN ); ?></a>
                    <div class="submenu-dropdown">
                        <?php  if ( has_nav_menu( 'account-menu' ) ) : ?>
                            <?php wp_nav_menu(array(
                                'theme_location' => 'account-menu',
                                'before' => '',
                                'after' => '',
                                'link_before' => '',
                                'link_after' => '',
                                'depth' => 4,
                                'fallback_cb' => false
                            )); ?>
                        <?php else: ?>
		                    <h4 class="a-center install-menu-info">Set your account menu in <em>Apperance &gt; Menus</em></h4>
                        <?php endif; ?>
                    </div>
                </li><?php endif; ?>
                        <li class="logout-link"><a href="<?php echo wp_logout_url(home_url()); ?>"><?php _e( 'Logout', ETHEME_DOMAIN ); ?></a></li>
                <?php else : ?>
                    <?php 
                        $reg_id = etheme_tpl2id('et-registration.php'); 
                        $reg_url = get_permalink($reg_id);
                    ?>    
                    <?php if(class_exists('Woocommerce')): ?><li class="login-link"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php _e( 'Sign In', ETHEME_DOMAIN ); ?></a></li><?php endif; ?>
                    <?php if(!empty($reg_id)): ?><li class="register-link"><a href="<?php echo $reg_url; ?>"><?php _e( 'Register', ETHEME_DOMAIN ); ?></a></li><?php endif; ?>
                <?php endif; ?>
            </ul>
        <?php
    }
}

// **********************************************************************// 
// ! Registration 
// **********************************************************************// 
add_action( 'wp_ajax_et_register_action', 'et_register_action' );
add_action( 'wp_ajax_nopriv_et_register_action', 'et_register_action' );
if(!function_exists('et_register_action')) {
	function et_register_action() {
		global $wpdb, $user_ID;
		$captcha_instance = new ReallySimpleCaptcha();
		if(!$captcha_instance->check( $_REQUEST['captcha-prefix'], $_REQUEST['captcha-word'] )) {
			$return['status'] = 'error';
			$return['msg'] = __('The security code you entered did not match. Please try again.', ETHEME_DOMAIN);
			echo json_encode($return);
			die();
		}
	    if(!empty($_GET['et_register'])){
	        //We shall SQL escape all inputs
	        $username = esc_sql($_REQUEST['username']);
	        if(empty($username)) {
				$return['status'] = 'error';
				$return['msg'] = __( "User name should not be empty.", ETHEME_DOMAIN );
				echo json_encode($return);
	            die();
	        }
	        $email = esc_sql($_REQUEST['email']);
	        if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {
				$return['status'] = 'error';
				$return['msg'] = __( "Please enter a valid email.", ETHEME_DOMAIN );
				echo json_encode($return);
	            die();
	        }
	        $pass = esc_sql($_REQUEST['et_pass']);
	        $pass2 = esc_sql($_REQUEST['et_pass2']);
	        if(empty($pass) || strlen($pass) < 5) {
				$return['status'] = 'error';
				$return['msg'] = __( "Password should have more than 5 symbols", ETHEME_DOMAIN );
				echo json_encode($return);
	            die();
	        }
	        if($pass != $pass2) {
				$return['status'] = 'error';
				$return['msg'] = __( "The passwords do not match", ETHEME_DOMAIN );
				echo json_encode($return);
	            die();
	        }
	        
	        $status = wp_create_user( $username, $pass, $email );
	        if ( is_wp_error($status) ) {
				$return['status'] = 'error';
				$return['msg'] = __( "Username already exists. Please try another one.", ETHEME_DOMAIN );
				echo json_encode($return);
	        }
	        else {
	            $from = get_bloginfo('name');
	            $from_email = get_bloginfo('admin_email');
	            $headers = 'From: '.$from . " <". $from_email .">\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	            $subject = __("Registration successful", ETHEME_DOMAIN);
	            $message = et_registration_email($username);
	            wp_mail( $email, $subject, $message, $headers );
				$return['status'] = 'success';
				$return['msg'] = __( "Please check your email for login details.", ETHEME_DOMAIN );
				echo json_encode($return);
	        }
	        die();
	    } 
	}
}

if(!function_exists('et_registration_email')) {
	function et_registration_email($username = '') {
        global $woocommerce;
        $logoimg = etheme_get_option('logo');
        $logoimg = apply_filters('etheme_logo_src',$logoimg);
		ob_start(); ?>
			<div style="background-color: #f5f5f5;width: 100%;-webkit-text-size-adjust: none;margin: 0;padding: 70px 0 70px 0;">
				<div style="-webkit-box-shadow: 0 0 0 3px rgba(0,0,0,0.025) ;box-shadow: 0 0 0 3px rgba(0,0,0,0.025);-webkit-border-radius: 6px;border-radius: 6px ;background-color: #fdfdfd;border: 1px solid #dcdcdc; padding:20px; margin:0 auto; width:500px; max-width:100%; color: #737373; font-family:Arial; font-size:14px; line-height:150%; text-align:left;">
			        <?php if($logoimg): ?>
			            <a href="<?php echo home_url(); ?>" style="display:block; text-align:center;"><img style="max-width:100%;" src="<?php echo $logoimg ?>" alt="<?php bloginfo( 'description' ); ?>" /></a>
			        <?php else: ?>
			            <a href="<?php echo home_url(); ?>" style="display:block; text-align:center;"><img style="max-width:100%;" src="<?php echo PARENT_URL.'/images/logo.png'; ?>" alt="<?php bloginfo('name'); ?>"></a>
			        <?php endif ; ?>
					<p><?php printf(__('Thanks for creating an account on %s. Your username is %s.', ETHEME_DOMAIN), get_bloginfo( 'name' ), $username);?></p>
					<?php if (class_exists('Woocommerce')): ?>
					
						<p><?php printf(__('You can access your account area to view your orders and change your password here: <a href="%s">%s</a>.', ETHEME_DOMAIN), get_permalink( get_option('woocommerce_myaccount_page_id') ), get_permalink( get_option('woocommerce_myaccount_page_id') ));?></p>
					
					<?php endif; ?>
					
				</div>
			</div>
		<?php 
	    $output = ob_get_contents();
	    ob_end_clean();
	    return $output;
	}
}

// **********************************************************************// 
// ! Header Type
// **********************************************************************// 
function get_header_type() {
    return etheme_get_option('header_type');
}

add_filter('custom_header_filter', 'get_header_type',10);


// **********************************************************************// 
// ! Footer Type
// **********************************************************************// 
function get_footer_type() {
    return etheme_get_option('footer_type');
}

add_filter('custom_footer_filter', 'get_footer_type',10);


// **********************************************************************// 
// ! Function to display comments
// **********************************************************************// 


if(!function_exists('etheme_comments')) {
    function etheme_comments($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        if(get_comment_type() == 'pingback' || get_comment_type() == 'trackback') :
            ?>
            
            <li id="comment-<?php comment_ID(); ?>" class="pingback">
                <div class="comment-block row-fluid">
                    <div class="span12">
                        <div class="author-link"><?php _e('Pingback:', ETHEME_DOMAIN) ?></div>
                        <div class="comment-reply"> <?php edit_comment_link(); ?></div>
                        <?php comment_author_link(); ?>

                    </div>
                </div>
            <?php
        elseif(get_comment_type() == 'comment') :?>
            
            <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
                <div class="comment-block row-fluid">
                    
                    <div class="row-fluid comment-heading">
                        <div class="comment-author-avatar">
                            <?php 
                                $avatar_size = 170;
                                echo get_avatar($comment, $avatar_size);
                             ?>
                        </div>
                        <div class="author-link"><?php comment_author_link(); ?></div><br>
                        <div class="comment-date"><?php comment_date(); ?> - <?php comment_time(); ?></div>
                        <div class="comment-reply"> <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?></div>
                    </div>

                    <div class="row-fluid">

                        <?php if ($comment->comment_approved == '0'): ?>
                            <p class="awaiting-moderation"><?php __('Your comment is awaiting moderation.', ETHEME_DOMAIN) ?></p>
                        <?php endif ?>

                        <?php comment_text(); ?>

                    </div>
                </div>

        <?php endif;
    }
}

// **********************************************************************// 
// ! Custom Comment Form
// **********************************************************************// 

if(!function_exists('etheme_custom_comment_form')) {
    function etheme_custom_comment_form($defaults) {
        $defaults['comment_notes_before'] = '';
        $defaults['comment_notes_after'] = '';
        $dafaults['id_form'] = 'comments_form';

        $defaults['comment_field'] = '<label for="comment">'.__('Comment', ETHEME_DOMAIN).'</label><div class="comment-form-comment row-fluid"><textarea class="span8 required-field"  id="comment" name="comment" cols="45" rows="12" aria-required="true"></textarea></div>';

        return $defaults;
    }
}

add_filter('comment_form_defaults', 'etheme_custom_comment_form');

if(!function_exists('etheme_custom_comment_form_fields')) {
    function etheme_custom_comment_form_fields() {
        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $reqT = '<span class="required">*</span>';
        $aria_req = ($req ? " aria-required='true'" : ' ');

        $fields = array(
            'author' => '<p class="comment-form-author">'.
                            '<label for="author">'.__('Name', ETHEME_DOMAIN).' '.($req ? $reqT : '').'</label>'.
                            '<div class="row-fluid">'.
                            '<input id="author" name="author" type="text" class="span5 ' . ($req ? ' required-field' : '') . '" value="' . esc_attr($commenter['comment_author']) . '" size="30" ' . $aria_req . '>'.
                            '</div>'.
                        '</p>',
            'email' => '<p class="comment-form-email">'.
                            '<label for="email">'.__('Email', ETHEME_DOMAIN).' '.($req ? $reqT : '').'</label>'.
                            '<div class="row-fluid">'.
                            '<input id="email" name="email" type="text" class="span5' . ($req ? ' required-field' : '') . '" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" ' . $aria_req . '>'.
                            '</div>'.
                        '</p>',
            'url' => '<p class="comment-form-url">'.
                            '<label for="url">'.__('Website', ETHEME_DOMAIN).'</label>'.
                            '<div class="row-fluid">'.
                            '<input id="url" name="url" type="text" class="span5" value="' . esc_attr($commenter['comment_author_url']) . '" size="30">'.
                            '</div>'.
                        '</p>'
        );

        return $fields;
    }
}

add_filter('comment_form_default_fields', 'etheme_custom_comment_form_fields');
// **********************************************************************// 
// ! Register Sidebars
// **********************************************************************// 

if(function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => __('Main Sidebar', ETHEME_DOMAIN),
        'id' => 'main-sidebar',
        'description' => __('The main sidebar area', ETHEME_DOMAIN),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Shop Sidebar', ETHEME_DOMAIN),
        'id' => 'shop-sidebar',
        'description' => __('Shop page widget area', ETHEME_DOMAIN),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Single product page Sidebar', ETHEME_DOMAIN),
        'id' => 'single-sidebar',
        'description' => __('Single product page widget area', ETHEME_DOMAIN),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Shopping cart sidebar', ETHEME_DOMAIN),
        'id' => 'cart-sidebar',
        'description' => __('Area after cart totals block', ETHEME_DOMAIN),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Right side panel area', ETHEME_DOMAIN),
        'id' => 'right-panel-sidebar',
        'description' => __('Right side panel widget area', ETHEME_DOMAIN),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Hidden top panel area', ETHEME_DOMAIN),
        'id' => 'top-panel-sidebar',
        'description' => __('Hidden top panel widget area', ETHEME_DOMAIN),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Place in header top bar', ETHEME_DOMAIN),
        'id' => 'languages-sidebar',
        'description' => __('Can be used for placing languages switcher of some contacts information.', ETHEME_DOMAIN),
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Prefooter Row', ETHEME_DOMAIN),
        'id' => 'prefooter',
        'before_widget' => '<div id="%1$s" class="prefooter-sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //prefooter-sidebar-widget -->',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));


    register_sidebar(array(
        'name' => __('Footer 1', ETHEME_DOMAIN),
        'id' => 'footer1',
        'before_widget' => '<div id="%1$s" class="footer-sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //footer-sidebar-widget -->',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Footer 2', ETHEME_DOMAIN),
        'id' => 'footer2',
        'before_widget' => '<div id="%1$s" class="footer-sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //sidebar-widget -->',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));


    register_sidebar(array(
        'name' => __('Footer Copyright', ETHEME_DOMAIN),
        'id' => 'footer9',
        'before_widget' => '<div id="%1$s" class="footer-sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //footer-sidebar-widget -->',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Footer Links', ETHEME_DOMAIN),
        'id' => 'footer10',
        'before_widget' => '<div id="%1$s" class="footer-sidebar-widget %2$s">',
        'after_widget' => '</div><!-- //footer-sidebar-widget -->',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}

// **********************************************************************// 
// ! Set exerpt 
// **********************************************************************//
function etheme_excerpt_length( $length ) {
    return 35;
}

add_filter( 'excerpt_length', 'etheme_excerpt_length', 999 );

function etheme_excerpt_more( $more ) {
    return '...';
}

add_filter('excerpt_more', 'etheme_excerpt_more');

// **********************************************************************// 
// ! Contact page functions
// **********************************************************************//
if(!function_exists('isValidEmail')){
    function isValidEmail($email){ 
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}



/***************************************************************/
/* Etheme Global Search */
/***************************************************************/

add_action("wp_ajax_et_get_search_result", "et_get_search_result");
add_action("wp_ajax_nopriv_et_get_search_result", "et_get_search_result");
if(!function_exists('et_get_search_result')) {
	function et_get_search_result() {
		$word = esc_attr(stripslashes($_REQUEST['s']));
		if(isset($word) && $word != '') {
			$response = array(
				'results' => false,
				'html' => ''
			);
			
			if(isset($_GET['count'])) {
				$count = $_GET['count'];
			} else {
				$count = 3;
			}
			
			
			if($_GET['products'] && class_exists('WooCommerce')) {
				$products_args = array(
					'args' => array(
						'post_type' => 'product',
						'post_status' => 'publish',
						'posts_per_page' => $count,
						's' => $word
					),
					'image' => $_GET['images'],
					'link' => true,
					'title' => __('View Products', ETHEME_DOMAIN),
					'class' => 'et-result-products'
				);
				$products = et_search_get_result($products_args);
				if($products) {
					$response['results'] = true;
					$response['html'] .= $products;
				}
			}
			
			if($_GET['posts']) {
				$posts_args = array(
					'args' => array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => $count,
						's' => $word
					),
					'title' => __('From the blog', ETHEME_DOMAIN),
					'image' => false,
					'link' => true,
					'class' => 'et-result-post'
				);
				$posts = et_search_get_result($posts_args);
				if($posts) {
					$response['results'] = true;
					$response['html'] .= $posts;
				}
			}
			
			
			if($_GET['portfolio']) {
				$portfolio_args = array(
					'args' => array(
						'post_type' => 'etheme_portfolio',
						'post_status' => 'publish',
						'posts_per_page' => $count,
						's' => $word
					),
					'image' => false,
					'link' => false,
					'title' => __('Portfolio', ETHEME_DOMAIN),
					'class' => 'et-result-portfolio'
				);
				$portfolio = et_search_get_result($portfolio_args);
				if($portfolio) {
					$response['results'] = true;
					$response['html'] .= $portfolio;
				}
			}
	
			
			if($_GET['pages']) {
				$pages_args = array(
					'args' => array(
						'post_type' => 'page',
						'post_status' => 'publish',
						'posts_per_page' => $count,
						's' => $word
					),
					'image' => false,
					'link' => false,
					'title' => __('Pages', ETHEME_DOMAIN),
					'class' => 'et-result-pages'
				);
				$pages = et_search_get_result($pages_args);
				if($pages) {
					$response['results'] = true;
					$response['html'] .= $pages;
				}
			}
			
			echo json_encode($response);
			
			die();
		} else {
			die();
		}
	}
}


if(!function_exists('et_search_get_result')) {
	function et_search_get_result($args) {
		extract($args);
		$query = new WP_Query( $args );
		
		// The Loop
		if ( $query->have_posts() ) {
	
		    ob_start();
			if($title != '') {
				?>
									
					<h5 class="title"><span><?php if($link): ?><a href="<?php echo get_bloginfo('url').'/?s='.$args['s'].'&post_type='.$args['post_type']; ?>" title="<?php _e('Show all', ETHEME_DOMAIN); ?>"><?php endif; ?>
						<?php echo $title; ?>
					<?php if($link): ?>&rarr;</a><?php endif; ?></span></h5>
					
				<?php
			}
			?>
				<ul class="<?php echo $class; ?>">
					<?php
						while ( $query->have_posts() ) {
							$query->the_post();
							?>
								<li>
									<?php if($image && has_post_thumbnail( get_the_ID() )): ?>
										<?php $src = etheme_get_image(get_post_thumbnail_id( get_the_ID() ),30,30,false); ?>
										<img src="<?php echo $src; ?>" />
									<?php endif; ?>
									
									
									<a href="<?php the_permalink(); ?>">
										<?php echo get_the_title(); ?>
									</a>
									
								</li>
							<?php
						}
					?>
				</ul>
			<?php
		    $output = ob_get_contents();
		    ob_end_clean();
		    return $output;
		} else {
			return false;
		}
		/* Restore original Post Data */
		wp_reset_postdata();
		return;
	}	
}



// **********************************************************************// 
// ! Posted info
// **********************************************************************//
if(!function_exists('etheme_posted_info')) {
	function etheme_posted_info ($title = ''){
		$posted_by = '<div class="post-info">';
		$posted_by .= '<span class="posted-on">';
		$posted_by .= __('Posted on', ETHEME_DOMAIN).' ';
		$posted_by .= get_the_time(get_option('date_format')).' ';
		$posted_by .= get_the_time(get_option('time_format')).' ';
		$posted_by .= '</span>';
		$posted_by .= '<span class="posted-by"> '.__('by', ETHEME_DOMAIN).' '.get_the_author_link().'</span>';
		$posted_by .= '</div>';
		return $title.$posted_by;
	}
} 

// **********************************************************************// 
// ! Posts Teaser Grid 
// **********************************************************************//
if(!function_exists('etheme_teaser')) {
	function etheme_teaser($atts, $content = null) {
		$title = $grid_columns_count = $grid_teasers_count = $grid_layout = $grid_link = $grid_link_target = $pagination = '';
		$grid_template = $grid_thumb_size = $grid_posttypes =  $grid_taxomonies = $grid_categories = $posts_in = $posts_not_in = '';
		$grid_content = $el_class = $width = $orderby = $order = $el_position = $isotope_item = $isotope_class = $posted_by = $posted_block = $hover_mask = $border = '';
		extract(shortcode_atts(array(
		    'title' => '',
		    'grid_columns_count' => 4,
		    'grid_teasers_count' => 8,
		    'grid_layout' => 'title_thumbnail_text', // title_thumbnail_text, thumbnail_title_text, thumbnail_text, thumbnail_title, thumbnail, title_text
		    'grid_link' => 'link_post', // link_post, link_image, link_image_post, link_no
		    'grid_link_target' => '_self',
		    'grid_template' => 'grid', //grid, carousel
		    'grid_thumb_size' => '500x300',
		    'grid_posttypes' => '',
		    'border' => 'on',
		    'pagination' => 'show',
		    'posted_block' => 'show',
		    'hover_mask' => 'show',
		    'grid_taxomonies' => '',
		    'grid_categories' => '',
		    'posts_in' => '',
		    'posts_not_in' => '',
		    'grid_content' => 'teaser', // teaser, content
		    'el_class' => '',
		    'width' => '1/1',
		    'orderby' => NULL,
		    'order' => 'DESC',
		    'el_position' => ''
		), $atts));
		
		if ( $grid_template == 'grid' || $grid_template == 'filtered_grid') {
		    $isotope_item = 'et_isotope-item ';
		} else if ( $grid_template == 'carousel' ) {
		    $isotope_item = '';
		}
		
		$output = '';
		
		$el_class = WPBakeryShortCode::getExtraClass( $el_class );
		$width = '';//wpb_translateColumnWidthToSpan( $width );
		$li_span_class = et_translateColumnsCountToSpanClass( $grid_columns_count );
		
		
		$query_args = array();
		
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
		if(is_front_page()) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		}
		
		$query_args['paged'] = $paged;
		
		$not_in = array();
		if ( $posts_not_in != '' ) {
		    $posts_not_in = str_ireplace(" ", "", $posts_not_in);
		    $not_in = explode(",", $posts_not_in);
		}
		
		$link_target = $grid_link_target=='_blank' ? ' target="_blank"' : '';
		
		
		//exclude current post/page from query
		if ( $posts_in == '' ) {
		    global $post;
		    array_push($not_in, $post->ID);
		}
		else if ( $posts_in != '' ) {
		    $posts_in = str_ireplace(" ", "", $posts_in);
		    $query_args['post__in'] = explode(",", $posts_in);
		}
		if ( $posts_in == '' || $posts_not_in != '' ) {
		    $query_args['post__not_in'] = $not_in;
		}
		
		// Post teasers count
		if ( $grid_teasers_count != '' && !is_numeric($grid_teasers_count) ) $grid_teasers_count = -1;
		if ( $grid_teasers_count != '' && is_numeric($grid_teasers_count) ) $query_args['posts_per_page'] = $grid_teasers_count;
		
		// Post types
		$pt = array();
		if ( $grid_posttypes != '' ) {
		    $grid_posttypes = explode(",", $grid_posttypes);
		    foreach ( $grid_posttypes as $post_type ) {
		        array_push($pt, $post_type);
		    }
		    $query_args['post_type'] = $pt;
		}
		
		// Taxonomies
		
		$taxonomies = array();
		if ( $grid_taxomonies != '' ) {
		    $grid_taxomonies = explode(",", $grid_taxomonies);
		    foreach ( $grid_taxomonies as $taxom ) {
		        array_push($taxonomies, $taxom);
		    }
		}
		
		// Narrow by categories
		if ( $grid_categories != '' ) {
		    $grid_categories = explode(",", $grid_categories);
		    $gc = array();
		    foreach ( $grid_categories as $grid_cat ) {
		        array_push($gc, $grid_cat);
		    }
		    $gc = implode(",", $gc);
		    ////http://snipplr.com/view/17434/wordpress-get-category-slug/
		    $query_args['category_name'] = $gc;
		
		    $taxonomies = get_taxonomies('', 'object');
		    $query_args['tax_query'] = array('relation' => 'OR');
		    foreach ( $taxonomies as $t ) {
		        if ( in_array($t->object_type[0], $pt) ) {
		            $query_args['tax_query'][] = array(
		                'taxonomy' => $t->name,//$t->name,//'portfolio_category',
		                'terms' => $grid_categories,
		                'field' => 'slug',
		            );
		        }
		    }
		}
		
		// Order posts
		if ( $orderby != NULL ) {
		    $query_args['orderby'] = $orderby;
		}
		$query_args['order'] = $order;
		
		// Run query
		$my_query = new WP_Query($query_args);
		//global $_wp_additional_image_sizes;
		
		$teasers = '';
		$teaser_categories = Array();
		if($grid_template == 'filtered_grid' && empty($grid_taxomonies)) {
		    $taxonomies = get_object_taxonomies(!empty($query_args['post_type']) ? $query_args['post_type'] : get_post_types(array('public' => false, 'name' => 'attachment'), 'names', 'NOT'));
		}
		
		if($posted_block == 'show') {
			add_filter('vc_teaser_grid_title', 'etheme_posted_info');
		}
		
		$posts_Ids = array();
		
		while ( $my_query->have_posts() ) {
		    $link_title_start = $link_image_start = $p_link = $link_image_end = $p_img_large = '';
		
		    $my_query->the_post();
		
		    $posts_Ids[] = $my_query->post->ID;
		
		
		    $categories_css = '';
		    if( $grid_template == 'filtered_grid' ) {
		        /** @var $post_cate``gories get list of categories */
		        // $post_categories = get_the_category($my_query->post->ID);
		        $post_categories = wp_get_object_terms($my_query->post->ID, ($taxonomies));
		        if(!is_wp_error($post_categories)) {
		            foreach($post_categories as $cat) {
		                if(!in_array($cat->term_id, $teaser_categories)) {
		                    $teaser_categories[] = $cat->term_id;
		                }
		                $categories_css .= ' grid-cat-'.$cat->term_id;
		            }
		        }
		
		    }
		    $post_title = the_title("", "", false);
		    $post_id = $my_query->post->ID;
		
		    $teaser_post_type = 'posts_grid_teaser_'.$my_query->post->post_type . ' ';
		    if($grid_content == 'teaser') {
		        $content = apply_filters('the_excerpt', get_the_excerpt());
		    } else {
		        $content = get_the_content();
		        $content = apply_filters('the_content', $content);
		        $content = str_replace(']]>', ']]&gt;', $content);
		    }
		
		    // $content = ( $grid_content == 'teaser' ) ? apply_filters('the_excerpt', get_the_excerpt()) : get_the_content(); //TODO: get_the_content() rewrite more WP native way.
		    $content = wpautop($content);
		    $link = '';
		    $thumbnail = '';
		
		    // Read more link
		    if ( $grid_link != 'link_no' ) {
		        $link = '<a class="more-link" href="'. get_permalink($post_id) .'"'.$link_target.' title="'. sprintf( esc_attr__( 'Permalink to %s', 'js_composer' ), the_title_attribute( 'echo=0' ) ).'">'. __("Read more", "js_composer") .'</a>';
		    }
		
		    // Thumbnail logic
		    if ( in_array($grid_layout, array('title_thumbnail_text', 'thumbnail_title_text', 'thumbnail_text', 'thumbnail_title', 'thumbnail', 'title_text') ) ) {
		        $post_thumbnail = $p_img_large = '';
		        //$attach_id = get_post_thumbnail_id($post_id);
		
		        $post_thumbnail = wpb_getImageBySize(array( 'post_id' => $post_id, 'thumb_size' => $grid_thumb_size ));
		        $thumbnail = $post_thumbnail['thumbnail'];
		        $p_img_large = $post_thumbnail['p_img_large'];
		    }
		
		    // Link logic
		    if ( $grid_link != 'link_no' ) {
		        $p_video = '';
		        if ( $grid_link == 'link_image' || $grid_link == 'link_image_post' ) {
		            $p_video = get_post_meta($post_id, "_p_video", true);
		        }
		
		        if ( $grid_link == 'link_post' ) {
		            $link_image_start = '<a class="link_image" href="'.get_permalink($post_id).'"'.$link_target.' title="'.sprintf( esc_attr__( 'Permalink to %s', 'js_composer' ), the_title_attribute( 'echo=0' ) ).'">';
		            $link_title_start = '<a class="link_title" href="'.get_permalink($post_id).'"'.$link_target.' title="'.sprintf( esc_attr__( 'Permalink to %s', 'js_composer' ), the_title_attribute( 'echo=0' ) ).'">';
		        }
		        else if ( $grid_link == 'link_image' ) {
		            if ( $p_video != "" ) {
		                $p_link = $p_video;
		            } else {
		                $p_link = $p_img_large[0];
		            }
		            $link_image_start = '<a class="link_image prettyphoto" href="'.$p_link.'"'.$link_target.' title="'.the_title_attribute('echo=0').'">';
		            $link_title_start = '<a class="link_title prettyphoto" href="'.$p_link.'"'.$link_target.' title="'.the_title_attribute('echo=0').'">';
		        }
		        else if ( $grid_link == 'link_image_post' ) {
		            if ( $p_video != "" ) {
		                $p_link = $p_video;
		            } else {
		                $p_link = $p_img_large[0];
		            }
		            $link_image_start = '<a class="link_image prettyphoto" href="'.$p_link.'"'.$link_target.' title="'.the_title_attribute('echo=0').'">';
		            $link_title_start = '<a class="link_title" href="'.get_permalink($post_id).'"'.$link_target.' title="'.sprintf( esc_attr__( 'Permalink to %s', 'js_composer' ), the_title_attribute( 'echo=0' ) ).'">';
		        }
		        $link_title_end = $link_image_end = '</a>';
		    } else {
		        $link_image_start = '';
		        $link_title_start = '';
		        $link_title_end = $link_image_end = '';
		    }
		    
		    if($hover_mask == 'show') {
			    $link_image_end .= '
	
						<div class="block-mask">
							<div class="mask-content">
								<a href="'.etheme_get_image(get_post_thumbnail_id($post_id)).'" rel="lightbox"><i class="icon-resize-full"></i></a>
								<a href="'.get_permalink($post_id).'"><i class="icon-link"></i></a>
							</div>
						</div>
			    ';
		    }
		    
		    $teasers .= '<div class="'.$isotope_item.apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $li_span_class, 'vc_teaser_grid_li').$categories_css.'">';
		    // If grid layout is: Title + Thumbnail + Text
		    if ( $grid_layout == 'title_thumbnail_text' ) {
		        if ( $post_title ) 	{
		            $to_filter = '<h4 class="post-title">' . $link_title_start . $post_title . $link_title_end . '</h2>';
		            $teasers .= apply_filters('vc_teaser_grid_title', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "title" => $post_title, "media_link" => $p_link) );
		        }
		        if ( $thumbnail ) {
		            $to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end .'</div>';
		            $teasers .= apply_filters('vc_teaser_grid_thumbnail', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link) );
		        }
		        if ( $content ) {
		            $to_filter = '<div class="entry-content">' . $content . '</div>';
		            $teasers .= apply_filters('vc_teaser_grid_content', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "content" => $content, "media_link" => $p_link) );
		        }
		    }
		    // If grid layout is: Thumbnail + Title + Text
		    else if ( $grid_layout == 'thumbnail_title_text' ) {
		        if ( $thumbnail ) {
		            $to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end .'</div>';
		            $teasers .= apply_filters('vc_teaser_grid_thumbnail', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link) );
		        }
		        
		        if ( $post_title && $content ) {
			        $teasers .= '<div class="teaser-post-info">';
		        }
		        
		        if ( $post_title ) 	{
		            $to_filter = '<h4 class="post-title">' . $link_title_start . $post_title . $link_title_end . '</h2>';
		            $teasers .= apply_filters('vc_teaser_grid_title', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "title" => $post_title, "media_link" => $p_link) );
		        }
		        if ( $content ) {
		            $to_filter = '<div class="entry-content">' . $content . '</div>';
		            $teasers .= apply_filters('vc_teaser_grid_content', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "content" => $content, "media_link" => $p_link) );
		        }
		        
		        if ( $post_title && $content ) {
			        $teasers .= '</div>';
		        }
		    }
		    // If grid layout is: Thumbnail + Text
		    else if ( $grid_layout == 'thumbnail_text' ) {
		        if ( $thumbnail ) {
		            $to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end .'</div>';
		            $teasers .= apply_filters('vc_teaser_grid_thumbnail', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link) );
		        }
		        if ( $content ) {
		            $to_filter = '<div class="teaser-post-info entry-content">' . $content . '</div>';
		            $teasers .= apply_filters('vc_teaser_grid_content', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "content" => $content, "media_link" => $p_link) );
		        }
		    }
		    // If grid layout is: Thumbnail + Title
		    else if ( $grid_layout == 'thumbnail_title' ) {
		        if ( $thumbnail ) {
		            $to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end .'</div>';
		            $teasers .= apply_filters('vc_teaser_grid_thumbnail', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link) );
		        }
		        if ( $post_title ) 	{
		            $to_filter = '<h4 class="teaser-post-info post-title">' . $link_title_start . $post_title . $link_title_end . '</h2>';
		            $teasers .= apply_filters('vc_teaser_grid_title', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "title" => $post_title, "media_link" => $p_link) );
		        }
		    }
		    // If grid layout is: Thumbnail
		    else if ( $grid_layout == 'thumbnail' ) {
		        if ( $thumbnail ) {
		            $to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end .'</div>';
		            $teasers .= apply_filters('vc_teaser_grid_thumbnail', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link) );
		        }
		    }
		    // If grid layout is: Title + Text
		    else if ( $grid_layout == 'title_text' ) {
		        if ( $post_title ) 	{
		            $to_filter = '<h4 class="post-title">' . $link_title_start . $post_title . $link_title_end . '</h2>';
		            $teasers .= apply_filters('vc_teaser_grid_title', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "title" => $post_title, "media_link" => $p_link) );
		        }
		        if ( $content ) {
		            $to_filter = '<div class="entry-content">' . $content . '</div>';
		            $teasers .= apply_filters('vc_teaser_grid_content', $to_filter, array("grid_layout" => $grid_layout, "ID" => $post_id, "content" => $content, "media_link" => $p_link) );
		        }
		    }

		    $teasers .= '</div> ' . WPBakeryShortCode::endBlockComment('single teaser');
		} // endwhile loop
		wp_reset_query();
		
		if( $grid_template == 'filtered_grid' && $teasers && !empty($teaser_categories)) {
		    /*
		    $categories_list = wp_list_categories(array(
		        'orderby' => 'name',
		        'walker' => new Teaser_Grid_Category_Walker(),
		        'include' => implode(',', $teaser_categories),
		        'show_option_none'   => __('No categories', 'js_composer'),
		        'echo' => false
		    ));
		    */
		    $categories_array = get_terms(($taxonomies), array(
		        'orderby' => 'name',
		        'include' => implode(',', $teaser_categories)
		    ));
		
		    $categories_list_output = '<ul class="et_categories_filter clearfix">';
		    $categories_list_output .= '<li class="active"><a href="#" data-filter="*" class="button active">' . __('All', 'js_composer') . '</a></li>';
		    if(!is_wp_error($categories_array)) {
		        foreach($categories_array as $cat) {
		            $categories_list_output .= '<li><a href="#" data-filter=".grid-cat-'.$cat->term_id.'" class="button">' . esc_attr($cat->name) . '</a></li>';
		        }
		    }
		    $categories_list_output.= '</ul><div class="clearfix"></div>';
		} else {
		    $categories_list_output = '';
		}
		
        $box_id = rand(1000,10000);
        
		if($grid_template == 'grid' || $grid_template == 'filtered_grid') {
			$isotope_class = 'et_isotope';
		} else {
			$isotope_class = 'teaser-carousel-'.$box_id;
		}
		 
		if ( $teasers ) { $teasers = '<div class="teaser_grid_container isotope-container">'.$categories_list_output.'<div class="'.$isotope_class.' et_row clearfix">'. $teasers .'</div></div>'; }
		else { $teasers = __("Nothing found." , "js_composer"); }
		
		$posttypes_teasers = '';
		
		
		
		if ( is_array($grid_posttypes) ) {
		    //$posttypes_teasers_ar = explode(",", $grid_posttypes);
		    $posttypes_teasers_ar = $grid_posttypes;
		    foreach ( $posttypes_teasers_ar as $post_type ) {
		        $posttypes_teasers .= 'wpb_teaser_grid_'.$post_type . ' ';
		    }
		}
		
		$grid_class = 'wpb_'.$grid_template . ' columns_count_'.$grid_columns_count . ' grid_layout-'.$grid_layout . ' '  . $grid_layout.'_' . ' ' . 'columns_count_'.$grid_columns_count.'_'.$grid_layout . ' ' . $posttypes_teasers.' teaser-border-'.$border.' post-by-info-'.$posted_block;
		$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_teaser_grid wpb_content_element '.$grid_class.$width.$el_class);
		
		$output .= "\n\t".'<div class="'.$css_class.'">';
		$output .= "\n\t\t".'<div class="wpb_wrapper">';
		$output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="title"><span>'.$title.'</span></h3>' : '';
		//$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_teaser_grid_heading'));
		$output .= $teasers;
		$output .= "\n\t\t".'</div> '.WPBakeryShortCode::endBlockComment('.wpb_wrapper');
		$output .= "\n\t".'</div> '.WPBakeryShortCode::endBlockComment('.wpb_teaser_grid');
		if($pagination == 'show') {
			$output .= etheme_pagination($my_query, $paged);
		}
		if ( $grid_template == 'carousel' ) {
		
            $output .=     "<script type='text/javascript'>";
            $output .=         'jQuery(".teaser-carousel-'.$box_id.'").owlCarousel({';
            $output .=             'items:4,';
            $output .=             'lazyLoad : true,';
            $output .=             'navigation: true,';
            $output .=             'navigationText:false,';
            $output .=             'rewindNav: false,';
            $output .=             'itemsCustom: [[0, 1], [479,2], [619,2], [768,4],  [1200, 4], [1600, 4]]';
            $output .=         '});';

            $output .=     '</script>';
		}
		
		
		remove_all_filters('vc_teaser_grid_title');
		
		return $output;
	}
	
}

if(!function_exists('etheme_pagination')) {
	function etheme_pagination($wp_query, $paged, $pages = '', $range = 2) {  
		 $output = '';
	     $showitems = ($range * 2)+1;  
	
	     if(empty($paged)) $paged = 1;
	
	     if($pages == '')
	     {
	         $pages = $wp_query->max_num_pages;
	         if(!$pages)
	         {
	             $pages = 1;
	         }
	     }   
	
	     if(1 != $pages)
	     {
	         $output .= "<nav class='portfolio-pagination'>";
		         $output .= '<ul class="page-numbers">';
			         if($paged > 2 && $paged > $range+1 && $showitems < $pages) $output .= "<li><a href='".get_pagenum_link(1)."' class='prev page-numbers'>prev</a></li>";
			
			         for ($i=1; $i <= $pages; $i++)
			         {
			             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
			             {
			                 $output .= ($paged == $i)? "<li><span class='page-numbers current'>".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
			             }
			         }
			
			         if ($paged < $pages && $showitems < $pages) $output .= "<li><a href='".get_pagenum_link($paged + 1)."' class='next page-numbers'>next</a></li>";
		         $output .= '</ul>';
	         $output .= "</nav>\n";
	     }
	     
	     return $output;
	}
}

// **********************************************************************// 
// ! Create products grid by args
// **********************************************************************//
if(!function_exists('etheme_products')) {
    function etheme_products($args,$title = false, $columns = 4){
        global $wpdb, $woocommerce_loop;
        ob_start();

        $products = new WP_Query( $args );
        $class = $title_output = '';
        $shop_url = get_permalink(woocommerce_get_page_id('shop'));

        if ($title != '') {
            $title_output = '<h2 class="title"><span>'.$title.'</span></h2>';
        }   

        $woocommerce_loop['shortcode_columns'] = $columns;

        if ( $products->have_posts() ) :  echo $title_output; ?>
            <?php woocommerce_product_loop_start(); ?>

                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                    <?php woocommerce_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>
                
            <?php woocommerce_product_loop_end(); ?>

        <?php endif;

        wp_reset_postdata();

        return '<div class="woocommerce">' . ob_get_clean() . '</div>';
            
    }
}
// **********************************************************************// 
// ! Create products slider by args
// **********************************************************************//
if(!function_exists('etheme_create_slider')) {
    function etheme_create_slider($args, $slider_args = array()){//, $title = false, $shop_link = true, $slider_type = false, $items = '[[0, 1], [479,2], [619,2], [768,4],  [1200, 4], [1600, 4]]', $style = 'default'
        global $wpdb, $woocommerce_loop;
        $product_per_row = etheme_get_option('prodcuts_per_row');
        extract(shortcode_atts(array( 
	        'title' => false,
	        'shop_link' => false,
	        'slider_type' => false,
	        'items' => '[[0, 1], [479,2], [619,2], [768,4],  [1200, 4], [1600, 4]]',
	        'style' => 'default',
	        'block_id' => false
	    ), $slider_args));
	    
        $box_id = rand(1000,10000);
        $multislides = new WP_Query( $args );
        $shop_url = get_permalink(woocommerce_get_page_id('shop'));
        $class = $title_output = '';
        if(!$slider_type) {
        	$woocommerce_loop['lazy-load'] = true;
        	$woocommerce_loop['style'] = $style;
        }
        
        if($multislides->post_count > 1) {
            $class .= ' posts-count-gt1';
        }
        if($multislides->post_count < 4) {
            $class .= ' posts-count-lt4';
        }
        if ( $multislides->have_posts() ) :
            if ($title) {
                $title_output = '<h2 class="title"><span>'.$title.'</span></h2>';
            }   
              echo '<div class="slider-container '.$class.'">';
                  echo $title_output;
                  if($shop_link && $title)
                    echo '<a href="'.$shop_url.'" class="show-all-posts hidden-tablet hidden-phone">'.__('View more products', ETHEME_DOMAIN).'</a>';
                  echo '<div class="items-slider products-slider '.$slider_type.'-container slider-'.$box_id.'">';
                        echo '<div class="slider '.$slider_type.'-wrapper">';
                        $_i=0;
                        	if($block_id && $block_id != '' && et_get_block($block_id) != '') {
	                            echo '<div class=" '.$slider_type.'-slide">';
	                                echo et_get_block($block_id);
	                            echo '</div><!-- slide-item -->';
                        	}
                            while ($multislides->have_posts()) : $multislides->the_post();
                                $_i++;
                                
                                if(class_exists('Woocommerce')) {
                                    global $product;
                                    if (!$product->is_visible()) continue; 
                                    echo '<div class="slide-item product-slide '.$slider_type.'-slide">';
                                        woocommerce_get_template_part( 'content', 'product' );
                                    echo '</div><!-- slide-item -->';
                                }

                            endwhile; 
                        echo '</div><!-- slider -->'; 
                  echo '</div><!-- products-slider -->'; 
              echo '</div><!-- slider-container -->'; 
        endif;
        wp_reset_query();
        unset($woocommerce_loop['lazy-load']);
        unset($woocommerce_loop['style']);
        
        if($items != '[[0, 1], [479,2], [619,2], [768,4],  [1200, 4], [1600, 4]]') {
            $items = '[[0, '.$items['phones'].'], [479,'.$items['phones'].'], [619,'.$items['tablet'].'], [768,'.$items['tablet'].'],  [1200, '.$items['notebook'].'], [1600, '.$items['desktop'].']]';
        } 
        if(!$slider_type) {
	        echo '
	
	            <script type="text/javascript">
	                jQuery(".slider-'.$box_id.' .slider").owlCarousel({
	                    items:4, 
	                    lazyLoad : true,
	                    navigation: true,
	                    navigationText:false,
	                    rewindNav: false,
	                    itemsCustom: '.$items.'
	                });
	
	            </script>
	        ';
        } elseif($slider_type == 'swiper') {
	        echo '
	
	            <script type="text/javascript">
	              if(jQuery(window).width() > 767) {
		              jQuery(".slider-'.$box_id.'").etFullWidth();
					  var mySwiper'.$box_id.' = new Swiper(".slider-'.$box_id.'",{
						keyboardControl: true,
						centeredSlides: true,
						calculateHeight : true,
						slidesPerView: "auto"
					  })
	              } else {
					  var mySwiper'.$box_id.' = new Swiper(".slider-'.$box_id.'",{
						calculateHeight : true
					  })
	              }

				    jQuery(function($){
						$(".slider-'.$box_id.' .slide-item").click(function(){
							mySwiper'.$box_id.'.swipeTo($(this).index());
							$(".lookbook-index").removeClass("active");
							$(this).addClass("active");
						});
						
						$(".slider-'.$box_id.' .slide-item a").click(function(e){
							if($(this).parents(".swiper-slide-active").length < 1) {
								e.preventDefault();
							}
						});
				    }, jQuery);
	            </script>
	        ';
        }
            
    }
}


if(!function_exists('etheme_create_flex_slider')) {
    function etheme_create_flex_slider($args,$title = false, $shop_link = true, $sidebar_slider = false){
        global $wpdb;
        $product_per_row = etheme_get_option('prodcuts_per_row');
        $box_id = rand(1000,10000);
        $multislides = new WP_Query( $args );
        $sliderHeight = etheme_get_option('default_slider_height');
        $shop_url = get_permalink(woocommerce_get_page_id('shop'));
        $class = '';
        if($sidebar_slider) {
            $class .= ' sidebar-slider-flex';
            $sliderHeight = 410;
        }

        if($multislides->post_count > 1) {
            $class .= ' posts-count-gt1';
        }
        if($multislides->post_count < 5) {
            $class .= ' posts-count-lt5';
        }
        if ( $multislides->have_posts() ) :
            if ($title) {
                $title_output = '<h5 class="title"><span>'.$title.'</span></h5>';
            }   
              echo '<div class="slider-container '.$class.'">';
                  echo $title_output;
                  if($shop_link)
                    echo '<a href="'.$shop_url.'" class="show-all-posts hidden-tablet hidden-phone">'.__('View more products', ETHEME_DOMAIN).'</a>';
                    echo '<div class="slider-viewport">';
                        echo '<div class="slider-'.$box_id.'">';
                            echo '<div class="slider">';
                            $_i=0;
                            echo '<div class="slide-item product-slide">';
                                while ($multislides->have_posts()) : $multislides->the_post();
                                    $_i++;
                                    
                                    if(class_exists('Woocommerce')) {
                                        global $product;
                                        if (!$product->is_visible()) continue; 
                                            woocommerce_get_template_part( 'content', 'product' );
                                        if($sidebar_slider){
                                            if($_i%2 == 0 && $_i != $multislides->post_count) {
                                                echo '</div><!-- slide-item -->';
                                                echo '<div class="slide-item product-slide">';
                                            }
                                        } else {
                                            echo '</div><!-- slide-item -->';
                                            echo '<div class="slide-item product-slide">';
                                        }
                                    }

                                endwhile; 
                            echo '</div><!-- slide-item -->';
                            echo '</div><!-- slider -->'; 
                        echo '</div><!-- products-slider -->'; 
                    echo '</div><!-- slider-viewport -->';
              echo '</div><!-- slider-container -->'; 
        endif;
        wp_reset_query();

        echo '
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    jQuery(".slider-'.$box_id.'").flexslider({
                        selector: ".slider .slide-item",
                        animation: "slide",
                        slideshow: false,
                        animationLoop: false,
                        controlNav: true,
                        directionNav:true,
                        itemWidth:105,
                        itemMargin:0,
                        move: 1
                    });
                });
            </script>
        ';
            
    }
}


// **********************************************************************// 
// ! Create posts slider by args
// **********************************************************************//
if(!function_exists('etheme_create_posts_slider')) {
    function etheme_create_posts_slider($args,$title = false, $more_link = true, $date = false, $excerpt = false, $width = 300, $height = 200, $crop = true){
        $box_id = rand(1000,10000);
        $multislides = new WP_Query( $args );
        $lightbox = etheme_get_option('blog_lightbox');
        $sliderHeight = etheme_get_option('default_blog_slider_height');
        $posts_url = get_permalink(get_option('page_for_posts'));
        $class = '';
        if($multislides->post_count > 1) {
            $class = ' posts-count-gt1';
        }
        if($multislides->post_count < 4) {
            $class .= ' posts-count-lt4';
        }
        
        if ( $multislides->have_posts() ) :
            $title_output = '';
            if ($title) {
                $title_output = '<h2 class="title"><span>'.$title.'</span></h2>';
            }   
              echo '<div class="slider-container '.$class.'">';
                  echo $title_output;
                  if($more_link)
                    echo '<a href="'.$posts_url.'" class="show-all-posts hidden-tablet hidden-phone">'.__('View more posts', ETHEME_DOMAIN).'</a>';
                  echo '<div class="items-slider posts-slider slider-'.$box_id.'">';
                        echo '<div class="slider">';
                        $_i=0;
                        while ($multislides->have_posts()) : $multislides->the_post();
                            $_i++;
                                echo '<div class="slide-item post-slide">';
                                    if(has_post_thumbnail()){
                                        echo '<div class="post-images">';
                                            echo '<a href="'.get_permalink().'"><img src="' . etheme_get_image(false, $width, $height, true) . '" class="post-slide-img"></a>';

                                            echo '<div class="blog-mask">';
                                                echo '<div class="mask-content">';
                                                    if($lightbox): 
                                                        echo '<a href="'.etheme_get_image(false).'" rel="lightbox"><i class="icon-resize-full"></i></a>';
                                                    endif;
                                                    echo '<a href="'.get_permalink().'"><i class="icon-link"></i></a>';
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>';
                                    }

                                    if($date){
                                        echo '<div class="post-information">';
                                        the_category(',&nbsp;');
                                        echo ' '.get_the_date('M') . ' <span>' . get_the_date('d') . '</span>' . ', ' . get_the_date('Y');
                                        echo '</div>';
                                    }
                                    echo '<h5><a href="'.get_permalink().'">' . get_the_title() . '</a></h5>';
                                    if($excerpt) the_excerpt();
                                echo '</div><!-- slide-item -->';

                        endwhile; 
                        echo '</div><!-- slider -->'; 
                  echo '</div><!-- items-slider -->';
              echo '</div><div class="clear"></div><!-- slider-container -->';
           
            echo '
                <script type="text/javascript">
                    jQuery(".slider-'.$box_id.' .slider").owlCarousel({
                        items:4, 
                        lazyLoad : true,
                        navigation: true,
                        navigationText:false,
                        rewindNav: false,
                        itemsCustom: [[0, 1], [479,2], [619,2], [768,4],  [1200, 4], [1600, 4]]
                    });

                </script>
            ';

        endif;
        wp_reset_query();
       
    }
}

// **********************************************************************// 
// ! Custom sidebars
// **********************************************************************//

/**
*
*   Function for adding sidebar (AJAX action) 
*/

function etheme_add_sidebar(){
    if (!wp_verify_nonce($_GET['_wpnonce_etheme_widgets'],'etheme-add-sidebar-widgets') ) die( 'Security check' );
    if($_GET['etheme_sidebar_name'] == '') die('Empty Name');
    $option_name = 'etheme_custom_sidebars';
    if(!get_option($option_name) || get_option($option_name) == '') delete_option($option_name); 
    
    $new_sidebar = $_GET['etheme_sidebar_name'];    
    
    
    if(get_option($option_name)) {
        $et_custom_sidebars = etheme_get_stored_sidebar();
        $et_custom_sidebars[] = trim($new_sidebar);
        $result = update_option($option_name, $et_custom_sidebars);
    }else{
        $et_custom_sidebars[] = $new_sidebar;
        $result2 = add_option($option_name, $et_custom_sidebars);
    }
    
    
    if($result) die('Updated');
    elseif($result2) die('added');
    else die('error');
}

/**
*
*   Function for deleting sidebar (AJAX action) 
*/

function etheme_delete_sidebar(){
    $option_name = 'etheme_custom_sidebars';
    $del_sidebar = trim($_GET['etheme_sidebar_name']);
        
    if(get_option($option_name)) {
        $et_custom_sidebars = etheme_get_stored_sidebar();
        
        foreach($et_custom_sidebars as $key => $value){
            if($value == $del_sidebar)
                unset($et_custom_sidebars[$key]);
        }
        
        
        $result = update_option($option_name, $et_custom_sidebars);
    }
    
    if($result) die('Deleted');
    else die('error');
}

/**
*
*   Function for registering previously stored sidebars
*/
function etheme_register_stored_sidebar(){
    $et_custom_sidebars = etheme_get_stored_sidebar();
    if(is_array($et_custom_sidebars)) {
        foreach($et_custom_sidebars as $name){
            register_sidebar( array(
                'name' => ''.$name.'',
                'id' => $name,
                'class' => 'etheme_custom_sidebar',
                'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ) );
        }
    }

}

/**
*
*   Function gets stored sidebar array
*/
function etheme_get_stored_sidebar(){
    $option_name = 'etheme_custom_sidebars';
    return get_option($option_name);
}


/**
*
*   Add form after all widgets
*/
function etheme_sidebar_form(){
    ?>
    
    <form action="<?php echo admin_url( 'widgets.php' ); ?>" method="post" id="etheme_add_sidebar_form">
        <h2>Custom Sidebar</h2>
        <?php wp_nonce_field( 'etheme-add-sidebar-widgets', '_wpnonce_etheme_widgets', false ); ?>
        <input type="text" name="etheme_sidebar_name" id="etheme_sidebar_name" />
        <button type="submit" class="button-primary" value="add-sidebar">Add Sidebar</button>
    </form>
    <script type="text/javascript">
        var sidebarForm = jQuery('#etheme_add_sidebar_form');
        var sidebarFormNew = sidebarForm.clone();
        sidebarForm.remove();
        jQuery('#widgets-right').append('<div style="clear:both;"></div>');
        jQuery('#widgets-right').append(sidebarFormNew);
        
        sidebarFormNew.submit(function(e){
            e.preventDefault();
            var data =  {
                'action':'etheme_add_sidebar',
                '_wpnonce_etheme_widgets': jQuery('#_wpnonce_etheme_widgets').val(),
                'etheme_sidebar_name': jQuery('#etheme_sidebar_name').val(),
            };
            //console.log(data);
            jQuery.ajax({
                url: ajaxurl,
                data: data,
                success: function(response){
                    console.log(response);
                    window.location.reload(true);
                    
                },
                error: function(data) {
                    console.log('error');
                    
                }
            });
        });
        
    </script>
    <?php
}

add_action( 'sidebar_admin_page', 'etheme_sidebar_form', 30 );
add_action('wp_ajax_etheme_add_sidebar', 'etheme_add_sidebar');
add_action('wp_ajax_etheme_delete_sidebar', 'etheme_delete_sidebar');
add_action( 'widgets_init', 'etheme_register_stored_sidebar' );


// **********************************************************************// 
// ! Get sidebar
// **********************************************************************// 

if(!function_exists('etheme_get_sidebar')) {
    function etheme_get_sidebar ($name = false) {
        do_action( 'get_sidebar', $name );
        if($name) {
            include(TEMPLATEPATH . '/sidebar-'.$name.'.php');
        }else{
            include(TEMPLATEPATH . '/sidebar.php');
        }
    }
}

// **********************************************************************// 
// ! Site breadcrumbs
// **********************************************************************//
if(!function_exists('etheme_breadcrumbs')) {
    function etheme_breadcrumbs() {

      $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
      $delimiter = '<span class="delimeter">/</span>'; // delimiter between crumbs
      $home = __('Home', ETHEME_DOMAIN); // text for the 'Home' link
      $blogPage = __('Blog', ETHEME_DOMAIN);
      $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
      $before = '<span class="current">'; // tag before the current crumb
      $after = '</span>'; // tag after the current crumb
      
      global $post;
      $homeLink = home_url();
      if (is_front_page()) {
      
        if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
      
	      } else if (class_exists('bbPress') && is_bbpress()) {
      	$bbp_args = array(
      		'before' => '<div class="breadcrumbs" id="breadcrumb">',
      		'after' => '</div>'
      	);	      
      	bbp_breadcrumb($bbp_args);
      } else {
      
        echo '<div class="breadcrumbs">';
        echo '<div id="breadcrumb">';
        echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
      
        if ( is_category() ) {
          $thisCat = get_category(get_query_var('cat'), false);
          if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
          echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
      
        } elseif ( is_search() ) {
          echo $before . 'Search results for "' . get_search_query() . '"' . $after;
      
        } elseif ( is_day() ) {
          echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
          echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
          echo $before . get_the_time('d') . $after;
      
        } elseif ( is_month() ) {
          echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
          echo $before . get_the_time('F') . $after;
      
        } elseif ( is_year() ) {
          echo $before . get_the_time('Y') . $after;
      
        } elseif ( is_single() && !is_attachment() ) {
          if ( get_post_type() == 'etheme_portfolio' ) {
            $portfolioId = etheme_tpl2id('portfolio.php'); 
            $portfolioLink = get_permalink($portfolioId);
            $post_type = get_post_type_object(get_post_type());
            $slug = $post_type->rewrite;
            echo '<a href="' . $portfolioLink . '/">' . $post_type->labels->name . '</a>';
            if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
          } elseif ( get_post_type() != 'post' ) {
            $post_type = get_post_type_object(get_post_type());
            $slug = $post_type->rewrite;
            echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
            if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
          } else {
            $cat = get_the_category(); 
            if(isset($cat[0])) {
	            $cat = $cat[0];
	            $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
	            if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
	            echo $cats;
            }
	        if ($showCurrent == 1) echo $before . get_the_title() . $after;
          }
      
        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
          $post_type = get_post_type_object(get_post_type());
          echo $before . $post_type->labels->singular_name . $after;
      
        } elseif ( is_attachment() ) {
          $parent = get_post($post->post_parent);
          //$cat = get_the_category($parent->ID); $cat = $cat[0];
          //echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
          //echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
          if ($showCurrent == 1) echo ' '  . $before . get_the_title() . $after;
      
        } elseif ( is_page() && !$post->post_parent ) {
          if ($showCurrent == 1) echo $before . get_the_title() . $after;
      
        } elseif ( is_page() && $post->post_parent ) {
          $parent_id  = $post->post_parent;
          $breadcrumbs = array();
          while ($parent_id) {
            $page = get_page($parent_id);
            $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
            $parent_id  = $page->post_parent;
          }
          $breadcrumbs = array_reverse($breadcrumbs);
          for ($i = 0; $i < count($breadcrumbs); $i++) {
            echo $breadcrumbs[$i];
            if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';
          }
          if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
      
        } elseif ( is_tag() ) {
          echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
      
        } elseif ( is_author() ) {
           global $author;
          $userdata = get_userdata($author);
          echo $before . 'Articles posted by ' . $userdata->display_name . $after;
      
        } elseif ( is_404() ) {
          echo $before . 'Error 404' . $after;
        }else{
            
            echo $blogPage;
        }
      
        if ( get_query_var('paged') ) {
          if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
          echo ' ('.__('Page') . ' ' . get_query_var('paged').')';
          if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }
      
        echo '</div>';
        et_back_to_page();
        echo '</div>';
      
      }
    }
}

if(!function_exists('et_back_to_page')) {
    function et_back_to_page() {
        echo '<a class="back-to" href="javascript: history.go(-1)"><span>‹</span>'.__('Return to Previous Page',ETHEME_DOMAIN).'</a>';
    }
}


if(!function_exists('et_show_more_posts')) {
	function et_show_more_posts() {
		return 'class="button big"';
	}
}


// **********************************************************************// 
// ! Footer Demo Widgets
// **********************************************************************// 

if(!function_exists('etheme_footer_demo')) {
    function etheme_footer_demo($position){
        switch ($position) {
            case 'footer2':

                ?>

                    <div class="row-fluid">
                        <div class="span3">
                            <h4 class="widget-title">About Company</h4>
                            <div>
                                <p>We are a company of highly skilled developers and designers, specialized in working with Magento/Wordpress system management</p>

                                <h6>Contact information</h6>
                                30 South Park Avenue
                                San Francisco, CA 94108
                                Phone: +78 123 456 789
                            </div>

                        </div>
                        <div class="span3">
                            <?php
                                $args = array(
                                    'widget_id' => 'etheme_widget_recent_comments',
                                    'before_widget' => '<div class="footer-sidebar-widget etheme_widget_recent_comments">',
                                    'after_widget' => '</div><!-- //sidebar-widget -->',
                                    'before_title' => '<h4 class="widget-title">',
                                    'after_title' => '</h4>'
                                );

                                $instance = array(
                                    'number' => 2,
                                    'title' => __('Recent Comments', ETHEME_DOMAIN)
                                );


                                $widget = new Etheme_Recent_Comments_Widget();
                                $widget->widget($args, $instance);
                            ?>
                        </div>
                        <div class="span3">
                            <?php
                                echo do_shortcode('[vc_wp_posts show_date="1" title="Recent Posts" number="3"]');
                            ?>
                        </div>
                        <div class="span3">
                            <?php
                                $args = array(
                                    'widget_id' => 'etheme_widget_flickr',
                                    'before_widget' => '<div class="footer-sidebar-widget etheme_widget_flickr">',
                                    'after_widget' => '</div><!-- //sidebar-widget -->',
                                    'before_title' => '<h4 class="widget-title">',
                                    'after_title' => '</h4>'
                                );

                                $instance = array(
                                    'screen_name' => '52617155@N08',
                                    'number' => 6,
                                    'show_button' => 1,
                                    'title' => __('Flickr Photos', ETHEME_DOMAIN)
                                );


                                $widget = new Etheme_Flickr_Widget();
                                $widget->widget($args, $instance);
                            ?>
                        </div>
                    </div>

                <?php 

            break;
            case 'footer9':
                ?>
                    <p><a href="<?php home_url(); ?>"><img src="<?php echo PARENT_URL.'/images/'; ?>logo-small.png" class="logo-small"></a></p>
                <?php
                break;
            case 'footer10':
                ?>
                    <p style="line-height: 35px;"><?php _e('Wordpress DEMO Store. All Rights Reserved.', ETHEME_DOMAIN) ?><p>
                <?php
                break;
        }
    }
}

// **********************************************************************// 
// ! Replace variation images
// **********************************************************************// 

if(!function_exists('etheme_replace_variation_images')) {
    function etheme_replace_variation_images($variations, $width = 1000, $height = 1000, $crop = false) {

        $newVariations = $variations;

        foreach ($variations as $key => $value) {
            $attachment_id = get_post_thumbnail_id( $variations[$key]['variation_id'] );

            $newImage = etheme_get_image($attachment_id, $width, $height, $crop);

            $newVariations[$key]['image_src'] = $newImage;
        }

        return $newVariations;
    }
}


// **********************************************************************// 
// ! Wishlist
// **********************************************************************//

//add_action('woocommerce_after_add_to_cart_button', 'etheme_wishlist_btn', 20);
//add_action('woocommerce_after_shop_loop_item', 'etheme_wishlist_btn', 20);

if(!function_exists('etheme_wishlist_btn')) {
    function etheme_wishlist_btn() {
        if(class_exists('YITH_WCWL')) {
        	$class = (get_option( 'yith_wcwl_frontend_css' ) == 'yes') ? 'with-styles' : '';
        	echo '<div class="wishlist-btn-container '.$class.'">';
            	echo do_shortcode('[yith_wcwl_add_to_wishlist]');
            echo '</div>';
        }
    }
}

// **********************************************************************// 
// ! Get page sidebar position
// **********************************************************************// 

if(!function_exists('etheme_get_page_sidebar')) {
    function etheme_get_page_sidebar() {
        $result = array(
            'position' => '',
            'responsive' => '',
            'sidebarname' => '',
            'page_heading' => 'enable',
            'page_slider' => 'no_slider',
            'sidebar_span' => 'span4',
            'content_span' => 'span8'
        );
        

        $result['responsive'] = etheme_get_option('blog_sidebar_responsive');
        $result['position'] = etheme_get_option('blog_sidebar');
        $result['page_heading'] = etheme_get_custom_field('page_heading');
        $result['page_slider'] = etheme_get_custom_field('page_slider');
        $result['sidebar_width'] = etheme_get_option('blog_sidebar_width');
        
        $page_sidebar_state = etheme_get_custom_field('sidebar_state');
        $sidebar_width = etheme_get_custom_field('sidebar_width');
        $widgetarea = etheme_get_custom_field('widget_area');
        

        if($result['sidebar_width'] != '') {
	        $content_width = 12 - $result['sidebar_width'];
	        $result['sidebar_span'] = 'span'.$result['sidebar_width'];
	        $result['content_span'] = 'span'.$content_width;
        }
        
        if($sidebar_width != '') {
            $content_width = 12 - $sidebar_width;
            $result['sidebar_span'] = 'span'.$sidebar_width;
            $result['content_span'] = 'span'.$content_width;
        }
        
        if($widgetarea != '') {
            $result['sidebarname'] = 'custom';
        }
        if($page_sidebar_state != '') {
            $result['position'] = $page_sidebar_state;
        }
        if($result['position'] == 'no_sidebar') {
            $result['position'] = 'without';
            $result['content_span'] = 'span12';
        } 

        return $result;
        
    }
}


// **********************************************************************// 
// ! Get blog sidebar position
// **********************************************************************// 

if(!function_exists('etheme_get_blog_sidebar')) {
    function etheme_get_blog_sidebar() {
    
		$page_for_posts = get_option( 'page_for_posts' );

        $result = array(
            'position' => '',
            'responsive' => '',
            'sidebarname' => '',
            'sidebar_width' => 3,
            'sidebar_span' => 'span4',
            'content_span' => 'span8',
            'blog_layout' => 'default',
        );
        
        $result['responsive'] = etheme_get_option('blog_sidebar_responsive');
        $result['position'] = etheme_get_option('blog_sidebar');
        $result['blog_layout'] = etheme_get_option('blog_layout');
        $result['sidebar_width'] = etheme_get_option('blog_sidebar_width');
        $result['page_slider'] = etheme_get_custom_field('page_slider', $page_for_posts);
        
        
        $result['page_heading'] = etheme_get_custom_field('page_heading', $page_for_posts);
        $page_sidebar_state = etheme_get_custom_field('sidebar_state', $page_for_posts);
        $sidebar_width = etheme_get_custom_field('sidebar_width', $page_for_posts);

        $content_width = 12 - $result['sidebar_width'];
        $result['sidebar_span'] = 'span'.$result['sidebar_width'];
        $result['content_span'] = 'span'.$content_width;
        
        
        if($sidebar_width != '') {
            $content_width = 12 - $sidebar_width;
            $result['sidebar_span'] = 'span'.$sidebar_width;
            $result['content_span'] = 'span'.$content_width;
        }
        
        if($page_sidebar_state != '') {
            $result['position'] = $page_sidebar_state;
        }
        
        if($result['position'] == 'no_sidebar' || $result['blog_layout'] == 'grid') {
            $result['position'] = 'without';
            $result['content_span'] = 'span12';
        } 
        
        return $result;
        
    }
}

// **********************************************************************// 
// ! Get shop sidebar position
// **********************************************************************// 

if(!function_exists('etheme_get_shop_sidebar')) {
    function etheme_get_shop_sidebar() {

        $result = array(
            'position' => 'left',
            'responsive' => '',
            'product_per_row' => 3,
            'sidebar_span' => 'span3',
            'content_span' => 'span9'
        );
        
        
        $result['responsive'] = etheme_get_option('blog_sidebar_responsive');         
        $result['position'] = etheme_get_option('grid_sidebar');
        $result['product_per_row'] = etheme_get_option('prodcuts_per_row');


        //$result['product_per_row'] = apply_filters('shop_column_count', $result['product_per_row']);
        //$result['product_page_sidebar'] = apply_filters('shop_sidebar', $result['product_page_sidebar']);

        if($result['position'] == 'without') {
            $result['content_span'] = 'span12';
        }
        
         
        if($result['product_per_row'] == 6){
            $result['position'] = 'without';
            $result['content_span'] = 'span12';
        }
        
        
        return $result;
    }
}

// **********************************************************************// 
// ! Get single product page sidebar position
// **********************************************************************// 

if(!function_exists('etheme_get_single_product_sidebar')) {
    function etheme_get_single_product_sidebar() {

        $result = array(
            'position' => 'left',
            'responsive' => '',
            'images_span' => '5',
            'meta_span' => '4'
        );
        
        $result['single_product_sidebar'] = is_active_sidebar('single-sidebar');
        $result['responsive'] = etheme_get_option('blog_sidebar_responsive');         
        $result['position'] = etheme_get_option('single_sidebar');

        $result['single_product_sidebar'] = apply_filters('single_product_sidebar', $result['single_product_sidebar']);
        
        if(!$result['single_product_sidebar'] || $result['position'] == 'no_sidebar') {
            $result['position'] = 'without';
            $result['images_span'] = '6';
            $result['meta_span'] = '6';
        }
        
        return $result;
    }
}



// **********************************************************************// 
// ! Custom navigation
// **********************************************************************// 

class Et_Navigation extends Walker_Nav_Menu
{
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $display_depth = ($depth + 1); 
        if($display_depth == '1') {
            $class_names = 'nav-sublist-dropdown';
            $container = 'container';
        } else {
            $class_names = 'nav-sublist';
            $container = '';
        }

        $indent = str_repeat("\t", $depth);

         $output .= "\n$indent<div class=".$class_names."><div class='".$container."'><ul>\n";
    }

    function end_lvl( &$output, $depth = 1, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div></div>\n";
    }

    function start_el ( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . apply_filters('custom_menu_link', esc_attr( $item->url )) .'"' : '';

        $description = '';
        if(strpos($class_names,'image-item') !== false){$description = '<img src="'.do_shortcode($item->description).'" alt=" "/>';}

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= $description;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    } 


}

// **********************************************************************// 
// ! http://codex.wordpress.org/Function_Reference/wp_nav_menu#How_to_add_a_parent_class_for_menu_item
// **********************************************************************// 

add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' );
function add_menu_parent_class( $items ) {
    
    $parents = array();
    foreach ( $items as $item ) {
        if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
            $parents[] = $item->menu_item_parent;
        }
    }
    
    foreach ( $items as $item ) {
        if ( in_array( $item->ID, $parents ) ) {
            $item->classes[] = 'menu-parent-item'; 
        }
    }
    
    return $items;    
}


// **********************************************************************// 
// ! Enable shortcodes in text widgets
// **********************************************************************// 
add_filter('widget_text', 'do_shortcode');

// **********************************************************************// 
// ! Add GOOGLE fonts
// **********************************************************************// 
/*
$content = json_decode($content, true);
echo '<pre>';
//print_r($content);
foreach($content['items'] as $font) {
    //print_r($font);
    echo "'".str_replace(" ", "+", $font['family'])."' => '".$font['family']."',<br>";
}
echo '</pre>';*/

if(!function_exists('etheme_recognized_google_font_families')) {
    function etheme_recognized_google_font_families( $array, $field_id ) {
        $array = array(
            'Open+Sans'           => '"Open Sans", sans-serif',
            'Droid+Sans'          => '"Droid Sans", sans-serif',
            'Lato'                => '"Lato"',
            'Cardo'               => '"Cardo"',
            'Roboto'              => '"Roboto"',
            'Fauna+One'           => '"Fauna One"',
            'Oswald'              => '"Oswald"',
            'Yanone+Kaffeesatz'   => '"Yanone Kaffeesatz"',
            'Muli'                => '"Muli"',
            'ABeeZee' => 'ABeeZee',
            'Abel' => 'Abel',
            'Abril+Fatface' => 'Abril Fatface',
            'Aclonica' => 'Aclonica',
            'Acme' => 'Acme',
            'Actor' => 'Actor',
            'Adamina' => 'Adamina',
            'Advent+Pro' => 'Advent Pro',
            'Aguafina+Script' => 'Aguafina Script',
            'Akronim' => 'Akronim',
            'Aladin' => 'Aladin',
            'Aldrich' => 'Aldrich',
            'Alef' => 'Alef',
            'Alegreya' => 'Alegreya',
            'Alegreya+SC' => 'Alegreya SC',
            'Alex+Brush' => 'Alex Brush',
            'Alfa+Slab+One' => 'Alfa Slab One',
            'Alice' => 'Alice',
            'Alike' => 'Alike',
            'Alike+Angular' => 'Alike Angular',
            'Allan' => 'Allan',
            'Allerta' => 'Allerta',
            'Allerta+Stencil' => 'Allerta Stencil',
            'Allura' => 'Allura',
            'Almendra' => 'Almendra',
            'Almendra+Display' => 'Almendra Display',
            'Almendra+SC' => 'Almendra SC',
            'Amarante' => 'Amarante',
            'Amaranth' => 'Amaranth',
            'Amatic+SC' => 'Amatic SC',
            'Amethysta' => 'Amethysta',
            'Anaheim' => 'Anaheim',
            'Andada' => 'Andada',
            'Andika' => 'Andika',
            'Angkor' => 'Angkor',
            'Annie+Use+Your+Telescope' => 'Annie Use Your Telescope',
            'Anonymous+Pro' => 'Anonymous Pro',
            'Antic' => 'Antic',
            'Antic+Didone' => 'Antic Didone',
            'Antic+Slab' => 'Antic Slab',
            'Anton' => 'Anton',
            'Arapey' => 'Arapey',
            'Arbutus' => 'Arbutus',
            'Arbutus+Slab' => 'Arbutus Slab',
            'Architects+Daughter' => 'Architects Daughter',
            'Archivo+Black' => 'Archivo Black',
            'Archivo+Narrow' => 'Archivo Narrow',
            'Arimo' => 'Arimo',
            'Arizonia' => 'Arizonia',
            'Armata' => 'Armata',
            'Artifika' => 'Artifika',
            'Arvo' => 'Arvo',
            'Asap' => 'Asap',
            'Asset' => 'Asset',
            'Astloch' => 'Astloch',
            'Asul' => 'Asul',
            'Atomic+Age' => 'Atomic Age',
            'Aubrey' => 'Aubrey',
            'Audiowide' => 'Audiowide',
            'Autour+One' => 'Autour One',
            'Average' => 'Average',
            'Average+Sans' => 'Average Sans',
            'Averia+Gruesa+Libre' => 'Averia Gruesa Libre',
            'Averia+Libre' => 'Averia Libre',
            'Averia+Sans+Libre' => 'Averia Sans Libre',
            'Averia+Serif+Libre' => 'Averia Serif Libre',
            'Bad+Script' => 'Bad Script',
            'Balthazar' => 'Balthazar',
            'Bangers' => 'Bangers',
            'Basic' => 'Basic',
            'Battambang' => 'Battambang',
            'Baumans' => 'Baumans',
            'Bayon' => 'Bayon',
            'Belgrano' => 'Belgrano',
            'Belleza' => 'Belleza',
            'BenchNine' => 'BenchNine',
            'Bentham' => 'Bentham',
            'Berkshire+Swash' => 'Berkshire Swash',
            'Bevan' => 'Bevan',
            'Bigelow+Rules' => 'Bigelow Rules',
            'Bigshot+One' => 'Bigshot One',
            'Bilbo' => 'Bilbo',
            'Bilbo+Swash+Caps' => 'Bilbo Swash Caps',
            'Bitter' => 'Bitter',
            'Black+Ops+One' => 'Black Ops One',
            'Bokor' => 'Bokor',
            'Bonbon' => 'Bonbon',
            'Boogaloo' => 'Boogaloo',
            'Bowlby+One' => 'Bowlby One',
            'Bowlby+One+SC' => 'Bowlby One SC',
            'Brawler' => 'Brawler',
            'Bree+Serif' => 'Bree Serif',
            'Bubblegum+Sans' => 'Bubblegum Sans',
            'Bubbler+One' => 'Bubbler One',
            'Buda' => 'Buda',
            'Buenard' => 'Buenard',
            'Butcherman' => 'Butcherman',
            'Butterfly+Kids' => 'Butterfly Kids',
            'Cabin' => 'Cabin',
            'Cabin+Condensed' => 'Cabin Condensed',
            'Cabin+Sketch' => 'Cabin Sketch',
            'Caesar+Dressing' => 'Caesar Dressing',
            'Cagliostro' => 'Cagliostro',
            'Calligraffitti' => 'Calligraffitti',
            'Cambo' => 'Cambo',
            'Candal' => 'Candal',
            'Cantarell' => 'Cantarell',
            'Cantata+One' => 'Cantata One',
            'Cantora+One' => 'Cantora One',
            'Capriola' => 'Capriola',
            'Cardo' => 'Cardo',
            'Carme' => 'Carme',
            'Carrois+Gothic' => 'Carrois Gothic',
            'Carrois+Gothic+SC' => 'Carrois Gothic SC',
            'Carter+One' => 'Carter One',
            'Caudex' => 'Caudex',
            'Cedarville+Cursive' => 'Cedarville Cursive',
            'Ceviche+One' => 'Ceviche One',
            'Changa+One' => 'Changa One',
            'Chango' => 'Chango',
            'Chau+Philomene+One' => 'Chau Philomene One',
            'Chela+One' => 'Chela One',
            'Chelsea+Market' => 'Chelsea Market',
            'Chenla' => 'Chenla',
            'Cherry+Cream+Soda' => 'Cherry Cream Soda',
            'Cherry+Swash' => 'Cherry Swash',
            'Chewy' => 'Chewy',
            'Chicle' => 'Chicle',
            'Chivo' => 'Chivo',
            'Cinzel' => 'Cinzel',
            'Cinzel+Decorative' => 'Cinzel Decorative',
            'Clicker+Script' => 'Clicker Script',
            'Coda' => 'Coda',
            'Coda+Caption' => 'Coda Caption',
            'Codystar' => 'Codystar',
            'Combo' => 'Combo',
            'Comfortaa' => 'Comfortaa',
            'Coming+Soon' => 'Coming Soon',
            'Concert+One' => 'Concert One',
            'Condiment' => 'Condiment',
            'Content' => 'Content',
            'Contrail+One' => 'Contrail One',
            'Convergence' => 'Convergence',
            'Cookie' => 'Cookie',
            'Copse' => 'Copse',
            'Corben' => 'Corben',
            'Courgette' => 'Courgette',
            'Cousine' => 'Cousine',
            'Coustard' => 'Coustard',
            'Covered+By+Your+Grace' => 'Covered By Your Grace',
            'Crafty+Girls' => 'Crafty Girls',
            'Creepster' => 'Creepster',
            'Crete+Round' => 'Crete Round',
            'Crimson+Text' => 'Crimson Text',
            'Croissant+One' => 'Croissant One',
            'Crushed' => 'Crushed',
            'Cuprum' => 'Cuprum',
            'Cutive' => 'Cutive',
            'Cutive+Mono' => 'Cutive Mono',
            'Damion' => 'Damion',
            'Dancing+Script' => 'Dancing Script',
            'Dangrek' => 'Dangrek',
            'Dawning+of+a+New+Day' => 'Dawning of a New Day',
            'Days+One' => 'Days One',
            'Delius' => 'Delius',
            'Delius+Swash+Caps' => 'Delius Swash Caps',
            'Delius+Unicase' => 'Delius Unicase',
            'Della+Respira' => 'Della Respira',
            'Denk+One' => 'Denk One',
            'Devonshire' => 'Devonshire',
            'Didact+Gothic' => 'Didact Gothic',
            'Diplomata' => 'Diplomata',
            'Diplomata+SC' => 'Diplomata SC',
            'Domine' => 'Domine',
            'Donegal+One' => 'Donegal One',
            'Doppio+One' => 'Doppio One',
            'Dorsa' => 'Dorsa',
            'Dosis' => 'Dosis',
            'Dr+Sugiyama' => 'Dr Sugiyama',
            'Droid+Sans' => 'Droid Sans',
            'Droid+Sans+Mono' => 'Droid Sans Mono',
            'Droid+Serif' => 'Droid Serif',
            'Duru+Sans' => 'Duru Sans',
            'Dynalight' => 'Dynalight',
            'EB+Garamond' => 'EB Garamond',
            'Eagle+Lake' => 'Eagle Lake',
            'Eater' => 'Eater',
            'Economica' => 'Economica',
            'Electrolize' => 'Electrolize',
            'Elsie' => 'Elsie',
            'Elsie+Swash+Caps' => 'Elsie Swash Caps',
            'Emblema+One' => 'Emblema One',
            'Emilys+Candy' => 'Emilys Candy',
            'Engagement' => 'Engagement',
            'Englebert' => 'Englebert',
            'Enriqueta' => 'Enriqueta',
            'Erica+One' => 'Erica One',
            'Esteban' => 'Esteban',
            'Euphoria+Script' => 'Euphoria Script',
            'Ewert' => 'Ewert',
            'Exo' => 'Exo',
            'Expletus+Sans' => 'Expletus Sans',
            'Fanwood+Text' => 'Fanwood Text',
            'Fascinate' => 'Fascinate',
            'Fascinate+Inline' => 'Fascinate Inline',
            'Faster+One' => 'Faster One',
            'Fasthand' => 'Fasthand',
            'Fauna+One' => 'Fauna One',
            'Federant' => 'Federant',
            'Federo' => 'Federo',
            'Felipa' => 'Felipa',
            'Fenix' => 'Fenix',
            'Finger+Paint' => 'Finger Paint',
            'Fjalla+One' => 'Fjalla One',
            'Fjord+One' => 'Fjord One',
            'Flamenco' => 'Flamenco',
            'Flavors' => 'Flavors',
            'Fondamento' => 'Fondamento',
            'Fontdiner+Swanky' => 'Fontdiner Swanky',
            'Forum' => 'Forum',
            'Francois+One' => 'Francois One',
            'Freckle+Face' => 'Freckle Face',
            'Fredericka+the+Great' => 'Fredericka the Great',
            'Fredoka+One' => 'Fredoka One',
            'Freehand' => 'Freehand',
            'Fresca' => 'Fresca',
            'Frijole' => 'Frijole',
            'Fruktur' => 'Fruktur',
            'Fugaz+One' => 'Fugaz One',
            'GFS+Didot' => 'GFS Didot',
            'GFS+Neohellenic' => 'GFS Neohellenic',
            'Gabriela' => 'Gabriela',
            'Gafata' => 'Gafata',
            'Galdeano' => 'Galdeano',
            'Galindo' => 'Galindo',
            'Gentium+Basic' => 'Gentium Basic',
            'Gentium+Book+Basic' => 'Gentium Book Basic',
            'Geo' => 'Geo',
            'Geostar' => 'Geostar',
            'Geostar+Fill' => 'Geostar Fill',
            'Germania+One' => 'Germania One',
            'Gilda+Display' => 'Gilda Display',
            'Give+You+Glory' => 'Give You Glory',
            'Glass+Antiqua' => 'Glass Antiqua',
            'Glegoo' => 'Glegoo',
            'Gloria+Hallelujah' => 'Gloria Hallelujah',
            'Goblin+One' => 'Goblin One',
            'Gochi+Hand' => 'Gochi Hand',
            'Gorditas' => 'Gorditas',
            'Goudy+Bookletter+1911' => 'Goudy Bookletter 1911',
            'Graduate' => 'Graduate',
            'Grand+Hotel' => 'Grand Hotel',
            'Gravitas+One' => 'Gravitas One',
            'Great+Vibes' => 'Great Vibes',
            'Griffy' => 'Griffy',
            'Gruppo' => 'Gruppo',
            'Gudea' => 'Gudea',
            'Habibi' => 'Habibi',
            'Hammersmith+One' => 'Hammersmith One',
            'Hanalei' => 'Hanalei',
            'Hanalei+Fill' => 'Hanalei Fill',
            'Handlee' => 'Handlee',
            'Hanuman' => 'Hanuman',
            'Happy+Monkey' => 'Happy Monkey',
            'Headland+One' => 'Headland One',
            'Henny+Penny' => 'Henny Penny',
            'Herr+Von+Muellerhoff' => 'Herr Von Muellerhoff',
            'Holtwood+One+SC' => 'Holtwood One SC',
            'Homemade+Apple' => 'Homemade Apple',
            'Homenaje' => 'Homenaje',
            'IM+Fell+DW+Pica' => 'IM Fell DW Pica',
            'IM+Fell+DW+Pica+SC' => 'IM Fell DW Pica SC',
            'IM+Fell+Double+Pica' => 'IM Fell Double Pica',
            'IM+Fell+Double+Pica+SC' => 'IM Fell Double Pica SC',
            'IM+Fell+English' => 'IM Fell English',
            'IM+Fell+English+SC' => 'IM Fell English SC',
            'IM+Fell+French+Canon' => 'IM Fell French Canon',
            'IM+Fell+French+Canon+SC' => 'IM Fell French Canon SC',
            'IM+Fell+Great+Primer' => 'IM Fell Great Primer',
            'IM+Fell+Great+Primer+SC' => 'IM Fell Great Primer SC',
            'Iceberg' => 'Iceberg',
            'Iceland' => 'Iceland',
            'Imprima' => 'Imprima',
            'Inconsolata' => 'Inconsolata',
            'Inder' => 'Inder',
            'Indie+Flower' => 'Indie Flower',
            'Inika' => 'Inika',
            'Irish+Grover' => 'Irish Grover',
            'Istok+Web' => 'Istok Web',
            'Italiana' => 'Italiana',
            'Italianno' => 'Italianno',
            'Jacques+Francois' => 'Jacques Francois',
            'Jacques+Francois+Shadow' => 'Jacques Francois Shadow',
            'Jim+Nightshade' => 'Jim Nightshade',
            'Jockey+One' => 'Jockey One',
            'Jolly+Lodger' => 'Jolly Lodger',
            'Josefin+Sans' => 'Josefin Sans',
            'Josefin+Slab' => 'Josefin Slab',
            'Joti+One' => 'Joti One',
            'Judson' => 'Judson',
            'Julee' => 'Julee',
            'Julius+Sans+One' => 'Julius Sans One',
            'Junge' => 'Junge',
            'Jura' => 'Jura',
            'Just+Another+Hand' => 'Just Another Hand',
            'Just+Me+Again+Down+Here' => 'Just Me Again Down Here',
            'Kameron' => 'Kameron',
            'Karla' => 'Karla',
            'Kaushan+Script' => 'Kaushan Script',
            'Kavoon' => 'Kavoon',
            'Keania+One' => 'Keania One',
            'Kelly+Slab' => 'Kelly Slab',
            'Kenia' => 'Kenia',
            'Khmer' => 'Khmer',
            'Kite+One' => 'Kite One',
            'Knewave' => 'Knewave',
            'Kotta+One' => 'Kotta One',
            'Koulen' => 'Koulen',
            'Kranky' => 'Kranky',
            'Kreon' => 'Kreon',
            'Kristi' => 'Kristi',
            'Krona+One' => 'Krona One',
            'La+Belle+Aurore' => 'La Belle Aurore',
            'Lancelot' => 'Lancelot',
            'Lato' => 'Lato',
            'League+Script' => 'League Script',
            'Leckerli+One' => 'Leckerli One',
            'Ledger' => 'Ledger',
            'Lekton' => 'Lekton',
            'Lemon' => 'Lemon',
            'Libre+Baskerville' => 'Libre Baskerville',
            'Life+Savers' => 'Life Savers',
            'Lilita+One' => 'Lilita One',
            'Lily+Script+One' => 'Lily Script One',
            'Limelight' => 'Limelight',
            'Linden+Hill' => 'Linden Hill',
            'Lobster' => 'Lobster',
            'Lobster+Two' => 'Lobster Two',
            'Londrina+Outline' => 'Londrina Outline',
            'Londrina+Shadow' => 'Londrina Shadow',
            'Londrina+Sketch' => 'Londrina Sketch',
            'Londrina+Solid' => 'Londrina Solid',
            'Lora' => 'Lora',
            'Love+Ya+Like+A+Sister' => 'Love Ya Like A Sister',
            'Loved+by+the+King' => 'Loved by the King',
            'Lovers+Quarrel' => 'Lovers Quarrel',
            'Luckiest+Guy' => 'Luckiest Guy',
            'Lusitana' => 'Lusitana',
            'Lustria' => 'Lustria',
            'Macondo' => 'Macondo',
            'Macondo+Swash+Caps' => 'Macondo Swash Caps',
            'Magra' => 'Magra',
            'Maiden+Orange' => 'Maiden Orange',
            'Mako' => 'Mako',
            'Marcellus' => 'Marcellus',
            'Marcellus+SC' => 'Marcellus SC',
            'Marck+Script' => 'Marck Script',
            'Margarine' => 'Margarine',
            'Marko+One' => 'Marko One',
            'Marmelad' => 'Marmelad',
            'Marvel' => 'Marvel',
            'Mate' => 'Mate',
            'Mate+SC' => 'Mate SC',
            'Maven+Pro' => 'Maven Pro',
            'McLaren' => 'McLaren',
            'Meddon' => 'Meddon',
            'MedievalSharp' => 'MedievalSharp',
            'Medula+One' => 'Medula One',
            'Megrim' => 'Megrim',
            'Meie+Script' => 'Meie Script',
            'Merienda' => 'Merienda',
            'Merienda+One' => 'Merienda One',
            'Merriweather' => 'Merriweather',
            'Merriweather+Sans' => 'Merriweather Sans',
            'Metal' => 'Metal',
            'Metal+Mania' => 'Metal Mania',
            'Metamorphous' => 'Metamorphous',
            'Metrophobic' => 'Metrophobic',
            'Michroma' => 'Michroma',
            'Milonga' => 'Milonga',
            'Miltonian' => 'Miltonian',
            'Miltonian+Tattoo' => 'Miltonian Tattoo',
            'Miniver' => 'Miniver',
            'Miss+Fajardose' => 'Miss Fajardose',
            'Modern+Antiqua' => 'Modern Antiqua',
            'Molengo' => 'Molengo',
            'Molle' => 'Molle',
            'Monda' => 'Monda',
            'Monofett' => 'Monofett',
            'Monoton' => 'Monoton',
            'Monsieur+La+Doulaise' => 'Monsieur La Doulaise',
            'Montaga' => 'Montaga',
            'Montez' => 'Montez',
            'Montserrat' => 'Montserrat',
            'Montserrat+Alternates' => 'Montserrat Alternates',
            'Montserrat+Subrayada' => 'Montserrat Subrayada',
            'Moul' => 'Moul',
            'Moulpali' => 'Moulpali',
            'Mountains+of+Christmas' => 'Mountains of Christmas',
            'Mouse+Memoirs' => 'Mouse Memoirs',
            'Mr+Bedfort' => 'Mr Bedfort',
            'Mr+Dafoe' => 'Mr Dafoe',
            'Mr+De+Haviland' => 'Mr De Haviland',
            'Mrs+Saint+Delafield' => 'Mrs Saint Delafield',
            'Mrs+Sheppards' => 'Mrs Sheppards',
            'Muli' => 'Muli',
            'Mystery+Quest' => 'Mystery Quest',
            'Neucha' => 'Neucha',
            'Neuton' => 'Neuton',
            'New+Rocker' => 'New Rocker',
            'News+Cycle' => 'News Cycle',
            'Niconne' => 'Niconne',
            'Nixie+One' => 'Nixie One',
            'Nobile' => 'Nobile',
            'Nokora' => 'Nokora',
            'Norican' => 'Norican',
            'Nosifer' => 'Nosifer',
            'Nothing+You+Could+Do' => 'Nothing You Could Do',
            'Noticia+Text' => 'Noticia Text',
            'Noto+Sans' => 'Noto Sans',
            'Noto+Serif' => 'Noto Serif',
            'Nova+Cut' => 'Nova Cut',
            'Nova+Flat' => 'Nova Flat',
            'Nova+Mono' => 'Nova Mono',
            'Nova+Oval' => 'Nova Oval',
            'Nova+Round' => 'Nova Round',
            'Nova+Script' => 'Nova Script',
            'Nova+Slim' => 'Nova Slim',
            'Nova+Square' => 'Nova Square',
            'Numans' => 'Numans',
            'Nunito' => 'Nunito',
            'Odor+Mean+Chey' => 'Odor Mean Chey',
            'Offside' => 'Offside',
            'Old+Standard+TT' => 'Old Standard TT',
            'Oldenburg' => 'Oldenburg',
            'Oleo+Script' => 'Oleo Script',
            'Oleo+Script+Swash+Caps' => 'Oleo Script Swash Caps',
            'Open+Sans' => 'Open Sans',
            'Open+Sans+Condensed' => 'Open Sans Condensed',
            'Oranienbaum' => 'Oranienbaum',
            'Orbitron' => 'Orbitron',
            'Oregano' => 'Oregano',
            'Orienta' => 'Orienta',
            'Original+Surfer' => 'Original Surfer',
            'Oswald' => 'Oswald',
            'Over+the+Rainbow' => 'Over the Rainbow',
            'Overlock' => 'Overlock',
            'Overlock+SC' => 'Overlock SC',
            'Ovo' => 'Ovo',
            'Oxygen' => 'Oxygen',
            'Oxygen+Mono' => 'Oxygen Mono',
            'PT+Mono' => 'PT Mono',
            'PT+Sans' => 'PT Sans',
            'PT+Sans+Caption' => 'PT Sans Caption',
            'PT+Sans+Narrow' => 'PT Sans Narrow',
            'PT+Serif' => 'PT Serif',
            'PT+Serif+Caption' => 'PT Serif Caption',
            'Pacifico' => 'Pacifico',
            'Paprika' => 'Paprika',
            'Parisienne' => 'Parisienne',
            'Passero+One' => 'Passero One',
            'Passion+One' => 'Passion One',
            'Pathway+Gothic+One' => 'Pathway Gothic One',
            'Patrick+Hand' => 'Patrick Hand',
            'Patrick+Hand+SC' => 'Patrick Hand SC',
            'Patua+One' => 'Patua One',
            'Paytone+One' => 'Paytone One',
            'Peralta' => 'Peralta',
            'Permanent+Marker' => 'Permanent Marker',
            'Petit+Formal+Script' => 'Petit Formal Script',
            'Petrona' => 'Petrona',
            'Philosopher' => 'Philosopher',
            'Piedra' => 'Piedra',
            'Pinyon+Script' => 'Pinyon Script',
            'Pirata+One' => 'Pirata One',
            'Plaster' => 'Plaster',
            'Play' => 'Play',
            'Playball' => 'Playball',
            'Playfair+Display' => 'Playfair Display',
            'Playfair+Display+SC' => 'Playfair Display SC',
            'Podkova' => 'Podkova',
            'Poiret+One' => 'Poiret One',
            'Poller+One' => 'Poller One',
            'Poly' => 'Poly',
            'Pompiere' => 'Pompiere',
            'Pontano+Sans' => 'Pontano Sans',
            'Port+Lligat+Sans' => 'Port Lligat Sans',
            'Port+Lligat+Slab' => 'Port Lligat Slab',
            'Prata' => 'Prata',
            'Preahvihear' => 'Preahvihear',
            'Press+Start+2P' => 'Press Start 2P',
            'Princess+Sofia' => 'Princess Sofia',
            'Prociono' => 'Prociono',
            'Prosto+One' => 'Prosto One',
            'Puritan' => 'Puritan',
            'Purple+Purse' => 'Purple Purse',
            'Quando' => 'Quando',
            'Quantico' => 'Quantico',
            'Quattrocento' => 'Quattrocento',
            'Quattrocento+Sans' => 'Quattrocento Sans',
            'Questrial' => 'Questrial',
            'Quicksand' => 'Quicksand',
            'Quintessential' => 'Quintessential',
            'Qwigley' => 'Qwigley',
            'Racing+Sans+One' => 'Racing Sans One',
            'Radley' => 'Radley',
            'Raleway' => 'Raleway',
            'Raleway+Dots' => 'Raleway Dots',
            'Rambla' => 'Rambla',
            'Rammetto+One' => 'Rammetto One',
            'Ranchers' => 'Ranchers',
            'Rancho' => 'Rancho',
            'Rationale' => 'Rationale',
            'Redressed' => 'Redressed',
            'Reenie+Beanie' => 'Reenie Beanie',
            'Revalia' => 'Revalia',
            'Ribeye' => 'Ribeye',
            'Ribeye+Marrow' => 'Ribeye Marrow',
            'Righteous' => 'Righteous',
            'Risque' => 'Risque',
            'Roboto' => 'Roboto',
            'Roboto+Condensed' => 'Roboto Condensed',
            'Roboto+Slab' => 'Roboto Slab',
            'Rochester' => 'Rochester',
            'Rock+Salt' => 'Rock Salt',
            'Rokkitt' => 'Rokkitt',
            'Romanesco' => 'Romanesco',
            'Ropa+Sans' => 'Ropa Sans',
            'Rosario' => 'Rosario',
            'Rosarivo' => 'Rosarivo',
            'Rouge+Script' => 'Rouge Script',
            'Ruda' => 'Ruda',
            'Rufina' => 'Rufina',
            'Ruge+Boogie' => 'Ruge Boogie',
            'Ruluko' => 'Ruluko',
            'Rum+Raisin' => 'Rum Raisin',
            'Ruslan+Display' => 'Ruslan Display',
            'Russo+One' => 'Russo One',
            'Ruthie' => 'Ruthie',
            'Rye' => 'Rye',
            'Sacramento' => 'Sacramento',
            'Sail' => 'Sail',
            'Salsa' => 'Salsa',
            'Sanchez' => 'Sanchez',
            'Sancreek' => 'Sancreek',
            'Sansita+One' => 'Sansita One',
            'Sarina' => 'Sarina',
            'Satisfy' => 'Satisfy',
            'Scada' => 'Scada',
            'Schoolbell' => 'Schoolbell',
            'Seaweed+Script' => 'Seaweed Script',
            'Sevillana' => 'Sevillana',
            'Seymour+One' => 'Seymour One',
            'Shadows+Into+Light' => 'Shadows Into Light',
            'Shadows+Into+Light+Two' => 'Shadows Into Light Two',
            'Shanti' => 'Shanti',
            'Share' => 'Share',
            'Share+Tech' => 'Share Tech',
            'Share+Tech+Mono' => 'Share Tech Mono',
            'Shojumaru' => 'Shojumaru',
            'Short+Stack' => 'Short Stack',
            'Siemreap' => 'Siemreap',
            'Sigmar+One' => 'Sigmar One',
            'Signika' => 'Signika',
            'Signika+Negative' => 'Signika Negative',
            'Simonetta' => 'Simonetta',
            'Sintony' => 'Sintony',
            'Sirin+Stencil' => 'Sirin Stencil',
            'Six+Caps' => 'Six Caps',
            'Skranji' => 'Skranji',
            'Slackey' => 'Slackey',
            'Smokum' => 'Smokum',
            'Smythe' => 'Smythe',
            'Sniglet' => 'Sniglet',
            'Snippet' => 'Snippet',
            'Snowburst+One' => 'Snowburst One',
            'Sofadi+One' => 'Sofadi One',
            'Sofia' => 'Sofia',
            'Sonsie+One' => 'Sonsie One',
            'Sorts+Mill+Goudy' => 'Sorts Mill Goudy',
            'Source+Code+Pro' => 'Source Code Pro',
            'Source+Sans+Pro' => 'Source Sans Pro',
            'Special+Elite' => 'Special Elite',
            'Spicy+Rice' => 'Spicy Rice',
            'Spinnaker' => 'Spinnaker',
            'Spirax' => 'Spirax',
            'Squada+One' => 'Squada One',
            'Stalemate' => 'Stalemate',
            'Stalinist+One' => 'Stalinist One',
            'Stardos+Stencil' => 'Stardos Stencil',
            'Stint+Ultra+Condensed' => 'Stint Ultra Condensed',
            'Stint+Ultra+Expanded' => 'Stint Ultra Expanded',
            'Stoke' => 'Stoke',
            'Strait' => 'Strait',
            'Sue+Ellen+Francisco' => 'Sue Ellen Francisco',
            'Sunshiney' => 'Sunshiney',
            'Supermercado+One' => 'Supermercado One',
            'Suwannaphum' => 'Suwannaphum',
            'Swanky+and+Moo+Moo' => 'Swanky and Moo Moo',
            'Syncopate' => 'Syncopate',
            'Tangerine' => 'Tangerine',
            'Taprom' => 'Taprom',
            'Tauri' => 'Tauri',
            'Telex' => 'Telex',
            'Tenor+Sans' => 'Tenor Sans',
            'Text+Me+One' => 'Text Me One',
            'The+Girl+Next+Door' => 'The Girl Next Door',
            'Tienne' => 'Tienne',
            'Tinos' => 'Tinos',
            'Titan+One' => 'Titan One',
            'Titillium+Web' => 'Titillium Web',
            'Trade+Winds' => 'Trade Winds',
            'Trocchi' => 'Trocchi',
            'Trochut' => 'Trochut',
            'Trykker' => 'Trykker',
            'Tulpen+One' => 'Tulpen One',
            'Ubuntu' => 'Ubuntu',
            'Ubuntu+Condensed' => 'Ubuntu Condensed',
            'Ubuntu+Mono' => 'Ubuntu Mono',
            'Ultra' => 'Ultra',
            'Uncial+Antiqua' => 'Uncial Antiqua',
            'Underdog' => 'Underdog',
            'Unica+One' => 'Unica One',
            'UnifrakturCook' => 'UnifrakturCook',
            'UnifrakturMaguntia' => 'UnifrakturMaguntia',
            'Unkempt' => 'Unkempt',
            'Unlock' => 'Unlock',
            'Unna' => 'Unna',
            'VT323' => 'VT323',
            'Vampiro+One' => 'Vampiro One',
            'Varela' => 'Varela',
            'Varela+Round' => 'Varela Round',
            'Vast+Shadow' => 'Vast Shadow',
            'Vibur' => 'Vibur',
            'Vidaloka' => 'Vidaloka',
            'Viga' => 'Viga',
            'Voces' => 'Voces',
            'Volkhov' => 'Volkhov',
            'Vollkorn' => 'Vollkorn',
            'Voltaire' => 'Voltaire',
            'Waiting+for+the+Sunrise' => 'Waiting for the Sunrise',
            'Wallpoet' => 'Wallpoet',
            'Walter+Turncoat' => 'Walter Turncoat',
            'Warnes' => 'Warnes',
            'Wellfleet' => 'Wellfleet',
            'Wendy+One' => 'Wendy One',
            'Wire+One' => 'Wire One',
            'Yanone+Kaffeesatz' => 'Yanone Kaffeesatz',
            'Yellowtail' => 'Yellowtail',
            'Yeseva+One' => 'Yeseva One',
            'Yesteryear' => 'Yesteryear',
            'Zeyada' => 'Zeyada'
            
        );
        
        return $array;
        
    } 
}


if(!function_exists('etheme_get_chosen_google_font')) {
    function etheme_get_chosen_google_font() {
        $chosenFonts = array();
        $fontOptions = array(
            etheme_get_option('mainfont'),
            etheme_get_option('h1'),
            etheme_get_option('h2'),
            etheme_get_option('h3'),
            etheme_get_option('h4'),
            etheme_get_option('h5'),
            etheme_get_option('h6'),
            etheme_get_option('sfont')
        );
        

        foreach($fontOptions as $value){
            if(!empty($value['google-font']) && $value['google-font'] != 'Open+Sans')
                $chosenFonts[] = $value['google-font'];
        }
        
        return array_unique($chosenFonts);
    }
}



// **********************************************************************// 
// ! Custom meta fields to categories
// **********************************************************************// 
if(function_exists('get_term_meta')){

function etheme_taxonomy_edit_meta_field($term, $taxonomy) {
    $id = $term->term_id;
    $term_meta = get_term_meta($id,'cat_meta');

    if(!$term_meta){$term_meta = add_term_meta($id, 'cat_meta', '');}
     ?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[cat_header]"><?php _e( 'Category Header', ETHEME_DOMAIN ); ?></label></th>
        <td>                
            <?php 

                $content = ( isset($term_meta[0]['cat_header']) ) ? ( $term_meta[0]['cat_header'] ) : ''; 
                wp_editor($content,'term_meta[cat_header]');

            ?>
        </td>
    </tr>
<?php
}

add_action( 'product_cat_edit_form_fields', 'etheme_taxonomy_edit_meta_field', 20, 2 );

// **********************************************************************// 
// ! Save meta fields
// **********************************************************************// 
function save_taxonomy_custom_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $term_meta = get_term_meta($term_id,'cat_meta');
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_term_meta($term_id, 'cat_meta', $term_meta);

    }
}  
add_action( 'edited_product_cat', 'save_taxonomy_custom_meta', 10, 2 );  
}



// **********************************************************************// 
// ! Load option tree plugin
// **********************************************************************// 
    
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
load_template( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );

// **********************************************************************// 
// ! Add google analytics code
// **********************************************************************// 
add_action('init', 'et_google_analytics');
if(!function_exists('et_google_analytics')) {
function et_google_analytics() {
    $googleCode = etheme_get_option('google_code');

    if(empty($googleCode)) return;

    if(strpos($googleCode,'UA-') === 0) {

        $googleCode = "

<script type='text/javascript'>

var _gaq = _gaq || [];
_gaq.push(['_setAccount', '".$googleCode."']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>

";
    }

    add_action('wp_head', 'et_print_google_code');
}

function et_print_google_code() {
    $googleCode = etheme_get_option('google_code');

    if(!empty($googleCode)) {
        echo $googleCode;
    }
}

}

// **********************************************************************// 
// ! Twitter API functions
// **********************************************************************// 
function etheme_capture_tweets($consumer_key,$consumer_secret,$user_token,$user_secret,$user, $count) {
    
    $connection = getConnectionWithAccessToken($consumer_key,$consumer_secret,$user_token, $user_secret);
    $params = array(
        'screen_name' => $user,
        'count' => $count
    );
    
    $content = $connection->get("statuses/user_timeline",$params);
    
    //prar($content);
    
    return json_encode($content);
}

function getConnectionWithAccessToken($consumer_key,$consumer_secret,$oauth_token, $oauth_token_secret) {
    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
    return $connection;
}


function etheme_tweet_linkify($tweet) {
    $tweet = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $tweet);
    $tweet = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $tweet);
    $tweet = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $tweet);
    $tweet = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $tweet);
    return $tweet;
}

function etheme_store_tweets($file, $tweets) {
    ob_start(); // turn on the output buffering 
    $fo = fopen($file, 'w'); // opens for writing only or will create if it's not there
    if (!$fo) return etheme_print_tweet_error(error_get_last());
    $fr = fwrite($fo, $tweets); // writes to the file what was grabbed from the previous function
    if (!$fr) return etheme_print_tweet_error(error_get_last());
    fclose($fo); // closes
    ob_end_flush(); // finishes and flushes the output buffer; 
}

function etheme_pick_tweets($file) {
    ob_start(); // turn on the output buffering 
    $fo = fopen($file, 'r'); // opens for reading only 
    if (!$fo) return etheme_print_tweet_error(error_get_last());
    $fr = fread($fo, filesize($file));
    if (!$fr) return etheme_print_tweet_error(error_get_last());
    fclose($fo);
    ob_end_flush();
    return $fr;
}

function etheme_print_tweet_error($errorArray) {
    return '<p class="eth-error">Error: ' . $errorArray['message'] . 'in ' . $errorArray['file'] . 'on line ' . $errorArray['line'] . '</p>';
}

function etheme_twitter_cache_enabled(){
    return true;
}

function etheme_print_tweets($consumer_key,$consumer_secret,$user_token,$user_secret,$user, $count, $cachetime=50) {
    if(etheme_twitter_cache_enabled()){
        //setting the location to cache file
        $cachefile = ETHEME_CODE_DIR . '/cache/twitterCache.json'; 
        
        // the file exitsts but is outdated, update the cache file
        if (file_exists($cachefile) && ( time() - $cachetime > filemtime($cachefile)) && filesize($cachefile) > 0) {
            //capturing fresh tweets
            $tweets = etheme_capture_tweets($consumer_key,$consumer_secret,$user_token,$user_secret,$user, $count);
            $tweets_decoded = json_decode($tweets, true);
            //if get error while loading fresh tweets - load outdated file
            if(isset($tweets_decoded['error'])) {
                $tweets = etheme_pick_tweets($cachefile);
            }
            //else store fresh tweets to cache
            else
                etheme_store_tweets($cachefile, $tweets);
        }
        //file doesn't exist or is empty, create new cache file
        elseif (!file_exists($cachefile) || filesize($cachefile) == 0) {
            $tweets = etheme_capture_tweets($consumer_key,$consumer_secret,$user_token,$user_secret,$user, $count);
            $tweets_decoded = json_decode($tweets, true);
            //if request fails, and there is no old cache file - print error
            if(isset($tweets_decoded['error']))
                return 'Error: ' . $tweets_decoded['error'];
            //make new cache file with request results
            else
                etheme_store_tweets($cachefile, $tweets);            
        }
        //file exists and is fresh
        //load the cache file
        else { 
           $tweets = etheme_pick_tweets($cachefile);
        }
    } else{
       $tweets = etheme_capture_tweets($consumer_key,$consumer_secret,$user_token,$user_secret,$user, $count);
    }

    $tweets = json_decode($tweets, true);
    $html = '';
    foreach ($tweets as $tweet) {
        $html .= '<div class="tweet">' . $tweet['text'] . '</div>';
    }
    $html = etheme_tweet_linkify($html);
    return $html;
}



// **********************************************************************// 
// ! Related posts 
// **********************************************************************// 

if(!function_exists('et_get_related_posts')) {
    function et_get_related_posts($postId = false, $limit = 5){
        global $post;
        if(!$postId) {
            $postId = $post->ID;
        }
        $categories = get_the_category($postId);
        if ($categories) {
            $category_ids = array();
            foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

            $args = array(
                'category__in' => $category_ids,
                'post__not_in' => array($postId),
                'showposts'=>$limit, // Number of related posts that will be shown.
                'caller_get_posts'=>1
            );
            etheme_create_posts_slider($args);
        }
    }
}

// **********************************************************************// 
// ! Custom Static Blocks Post Type
// **********************************************************************// 

add_action('init', 'et_register_static_blocks');

if(!function_exists('et_register_static_blocks')) {
    function et_register_static_blocks() {
            $labels = array(
                'name' => _x( 'Static Blocks', 'post type general name', ETHEME_DOMAIN ),
                'singular_name' => _x( 'Block', 'post type singular name', ETHEME_DOMAIN ),
                'add_new' => _x( 'Add New', 'static block', ETHEME_DOMAIN ),
                'add_new_item' => sprintf( __( 'Add New %s', ETHEME_DOMAIN ), __( 'Static Blocks', ETHEME_DOMAIN ) ),
                'edit_item' => sprintf( __( 'Edit %s', ETHEME_DOMAIN ), __( 'Static Blocks', ETHEME_DOMAIN ) ),
                'new_item' => sprintf( __( 'New %s', ETHEME_DOMAIN ), __( 'Static Blocks', ETHEME_DOMAIN ) ),
                'all_items' => sprintf( __( 'All %s', ETHEME_DOMAIN ), __( 'Static Blocks', ETHEME_DOMAIN ) ),
                'view_item' => sprintf( __( 'View %s', ETHEME_DOMAIN ), __( 'Static Blocks', ETHEME_DOMAIN ) ),
                'search_items' => sprintf( __( 'Search %a', ETHEME_DOMAIN ), __( 'Static Blocks', ETHEME_DOMAIN ) ),
                'not_found' =>  sprintf( __( 'No %s Found', ETHEME_DOMAIN ), __( 'Static Blocks', ETHEME_DOMAIN ) ),
                'not_found_in_trash' => sprintf( __( 'No %s Found In Trash', ETHEME_DOMAIN ), __( 'Static Blocks', ETHEME_DOMAIN ) ),
                'parent_item_colon' => '',
                'menu_name' => __( 'Static Blocks', ETHEME_DOMAIN )

            );
            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array( 'slug' => 'staticblocks' ),
                'capability_type' => 'post',
                'has_archive' => 'staticblocks',
                'hierarchical' => false,
                'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
                'menu_position' => 8
            );
            register_post_type( 'staticblocks', $args );
    }
}

if(!function_exists('et_get_static_blocks')) {
    function et_get_static_blocks () {
        $return_array = array();
        $args = array( 'post_type' => 'staticblocks', 'posts_per_page' => 50);
		//if ( class_exists( 'bbPress') ) remove_action( 'set_current_user', 'bbp_setup_current_user' );         
		$myposts = get_posts( $args );
        $i=0;
        foreach ( $myposts as $post ) {
            $i++;
            $return_array[$i]['label'] = get_the_title($post->ID);
            $return_array[$i]['value'] = $post->ID;
        } 
        wp_reset_postdata();
		//if ( class_exists( 'bbPress') ) add_action( 'set_current_user', 'bbp_setup_current_user', 10 );
        return $return_array;
    }
}


if(!function_exists('et_show_block')) {
    function et_show_block ($id = false) {
        echo et_get_block($id);
    }
}

add_filter('et_the_content', 'wpautop', 10);
add_filter('et_the_content', 'do_shortcode', 11);

if(!function_exists('et_get_block')) {
    function et_get_block($id = false) {
    	if(!$id) return;
        $args = array( 'include' => $id,'post_type' => 'staticblocks', 'posts_per_page' => 50);
        $output = '';
        $myposts = get_posts( $args );
        foreach ( $myposts as $post ) {
        	setup_postdata($post);
        	//$output = wpautop(do_shortcode(get_the_content($post->ID)));
        	$output = apply_filters('et_the_content', get_the_content());
        } 
        wp_reset_postdata();
        return $output;
   }
}


// **********************************************************************// 
// ! Promo Popup
// **********************************************************************// 
add_action('after_page_wrapper', 'et_promo_popup');
if(!function_exists('et_promo_popup')) {
    function et_promo_popup() {
        if(!etheme_get_option('promo_popup')) return;
        $bg = etheme_get_option('pp_bg');
        $padding = etheme_get_option('pp_padding');
        ?>
            <a class="etheme-popup " href="#etheme-popup">Open modal</a>
            
            <div id="etheme-popup" class="white-popup-block mfp-hide">
                <?php echo do_shortcode(etheme_get_option('pp_content')); ?>
                <a class="popup-modal-dismiss" href="#"><i class="icon-remove"></i></a>
                <p class="checkbox-label">
                    <input type="checkbox" value="do-not-show" name="showagain" id="showagain" class="showagain" />
                    <label for="showagain"><?php _e('Do not show this popup again', ETHEME_DOMAIN); ?></label>
                </p>
            </div>
            <style type="text/css">
                #etheme-popup {
                    width: <?php echo (etheme_get_option('pp_width') != '') ? etheme_get_option('pp_width') : 770 ; ?>px;
                    height: <?php echo (etheme_get_option('pp_height') != '') ? etheme_get_option('pp_height') : 350 ; ?>px;
                    <?php if(!empty($bg['background-color'])): ?>  background-color: <?php echo $bg['background-color']; ?>;<?php endif; ?>
                    <?php if(!empty($bg['background-image'])): ?>  background-image: url(<?php echo $bg['background-image']; ?>) ; <?php endif; ?>
                    <?php if(!empty($bg['background-attachment'])): ?>  background-attachment: <?php echo $bg['background-attachment']; ?>;<?php endif; ?>
                    <?php if(!empty($bg['background-repeat'])): ?>  background-repeat: <?php echo $bg['background-repeat']; ?>;<?php  endif; ?>
                    <?php if(!empty($bg['background-color'])): ?>  background-color: <?php echo $bg['background-color']; ?>;<?php  endif; ?>
                    <?php if(!empty($bg['background-position'])): ?>  background-position: <?php echo $bg['background-position']; ?>;<?php endif; ?>
                }
            </style>
        <?php
    }
}


// **********************************************************************// 
// ! QR Code generation
// **********************************************************************// 
if(!function_exists('generate_qr_code')) {
    function generate_qr_code($text='QR Code', $title = 'QR Code', $size = 128, $class = '', $self_link = false, $lightbox = false ) {
        if($self_link) {
            global $wp;
            $text = @$_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
            if ( $_SERVER['SERVER_PORT'] != '80' )
                $text .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
            else 
                $text .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        }
        $image = 'https://chart.googleapis.com/chart?chs=' . $size . 'x' . $size . '&cht=qr&chld=H|1&chl=' . $text;

        if($lightbox) {
            $class .= ' qr-lighbox';
            $output = '<a href="'.$image.'" rel="lightbox" class="'.$class.'">'.$title.'</a>';
        } else{
            $class .= ' qr-image';
            $output = '<img src="'.$image.'"  class="'.$class.'" />';
        }

        return $output;
    }
}


// **********************************************************************// 
// ! Helper functions
// **********************************************************************// 
if(!function_exists('pr')) {
    function pr($arr) {
        echo '<pre>';
            print_r($arr);
        echo '</pre>';   
    }
}

if(!function_exists('jsString')) {
    function jsString($str='') { 
        return trim(preg_replace("/('|\"|\r?\n)/", '', $str)); 
    } 
} 
if(!function_exists('hex2rgb')) {
    function hex2rgb($hex) {
       $hex = str_replace("#", "", $hex);

       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       $rgb = array($r, $g, $b);
       //return implode(",", $rgb); // returns the rgb values separated by commas
       return $rgb; // returns an array with the rgb values
    }
}

if(!function_exists('trunc')) {
    function trunc($phrase, $max_words) {
       $phrase_array = explode(' ',$phrase);
       if(count($phrase_array) > $max_words && $max_words > 0)
          $phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).' ...';
       return $phrase;
    }
}

if(!function_exists('et_get_icons')) {
    function et_get_icons() {
        $iconsArray = array("compass","collapse","collapse-top","expand","eur","euro","gbp","usd","dollar","inr","rupee","jpy","yen","cny","renminbi","krw","won","btc","bitcoin","file","file-text","sort-by-alphabet","sort-by-alphabet-alt","sort-by-attributes","sort-by-attributes-alt","sort-by-order","sort-by-order-alt","thumbs-up","thumbs-down","youtube-sign","youtube","xing","xing-sign","youtube-play","dropbox","stackexchange","instagram","flickr","adn","bitbucket","bitbucket-sign","tumblr","tumblr-sign","long-arrow-down","long-arrow-up","long-arrow-left","long-arrow-right","apple","windows","android","linux","dribbble","skype","foursquare","trello","female","male","gittip","sun","moon","archive","bug","vk","weibo","renren","adjust","anchor","archive","asterisk","ban-circle","bar-chart","barcode","beaker","beer","bell","bell-alt","bolt","book","bookmark","bookmark-empty","briefcase","bug","building","bullhorn","bullseye","calendar","calendar-empty","camera","camera-retro","certificate","check","check-empty","check-minus","check-sign","circle","circle-blank","cloud","cloud-download","cloud-upload","code","code-fork","coffee","cog","cogs","collapse","collapse-alt","collapse-top","comment","comment-alt","comments","comments-alt","compass","credit-card","crop","dashboard","desktop","download","download-alt","edit","edit-sign","ellipsis-horizontal","ellipsis-vertical","envelope","envelope-alt","eraser","exchange","exclamation","exclamation-sign","expand","expand-alt","external-link","external-link-sign","eye-close","eye-open","facetime-video","female","fighter-jet","film","filter","fire","fire-extinguisher","flag","flag-alt","flag-checkered","folder-close","folder-close-alt","folder-open","folder-open-alt","food","frown","gamepad","gear","gears","gift","glass","globe","group","hdd","headphones","heart","heart-empty","home","inbox","info","info-sign","key","keyboard","laptop","leaf","legal","lemon","level-down","level-up","lightbulb","location-arrow","lock","magic","magnet","mail-forward","mail-reply","mail-reply-all","male","map-marker","meh","microphone","microphone-off","minus","minus-sign","minus-sign-alt","mobile-phone","money","moon","move","music","off","ok","ok-circle","ok-sign","pencil","phone","phone-sign","picture","plane","plus","plus-sign","plus-sign-alt","power-off","print","pushpin","puzzle-piece","qrcode","question","question-sign","quote-left","quote-right","random","refresh","remove","remove-circle","remove-sign","reorder","reply","reply-all","resize-horizontal","resize-vertical","retweet","road","rocket","rss","rss-sign","screenshot","search","share","share-alt","share-sign","shield","shopping-cart","sign-blank","signal","signin","signout","sitemap","smile","sort","sort-by-alphabet","sort-by-alphabet-alt","sort-by-attributes","sort-by-attributes-alt","sort-by-order","sort-by-order-alt","sort-down","sort-up","spinner","star","star-empty","star-half","star-half-empty","star-half-full","subscript","suitcase","sun","superscript","tablet","tag","tags","tasks","terminal","thumbs-down","thumbs-down-alt","thumbs-up","thumbs-up-alt","ticket","time","tint","trash","trophy","truck","umbrella","unchecked","unlock","unlock-alt","upload","upload-alt","user","volume-down","volume-off","volume-up","warning-sign","wrench","zoom-in","zoom-out","bitcoin","btc","cny","dollar","eur","euro","gbp","inr","jpy","krw","renminbi","rupee","usd","won","yen","align-center","align-justify","align-left","align-right","bold","columns","copy","cut","eraser","file","file-alt","file-text","file-text-alt","font","indent-left","indent-right","italic","link","list","list-alt","list-ol","list-ul","paper-clip","paperclip","paste","repeat","rotate-left","rotate-right","save","strikethrough","table","text-height","text-width","th","th-large","th-list","underline","undo","unlink","angle-down","angle-left","angle-right","angle-up","arrow-down","arrow-left","arrow-right","arrow-up","caret-down","caret-left","caret-right","caret-up","chevron-down","chevron-left","chevron-right","chevron-sign-down","chevron-sign-left","chevron-sign-right","chevron-sign-up","chevron-up","circle-arrow-down","circle-arrow-left","circle-arrow-right","circle-arrow-up","double-angle-down","double-angle-left","double-angle-right","double-angle-up","hand-down","hand-left","hand-right","hand-up","long-arrow-down","long-arrow-left","long-arrow-right","long-arrow-up","backward","eject","fast-backward","fast-forward","forward","fullscreen","pause","play","play-circle","play-sign","resize-full","resize-small","step-backward","step-forward","stop","youtube-play","adn","android","apple","bitbucket","bitbucket-sign","bitcoin","btc","css3","dribbble","dropbox","facebook","facebook-sign","flickr","foursquare","github","github-alt","github-sign","gittip","google-plus","google-plus-sign","html5","instagram","linkedin","linkedin-sign","linux","maxcdn","pinterest","pinterest-sign","renren","skype","stackexchange","trello","tumblr","tumblr-sign","twitter","twitter-sign","vk","weibo","windows","xing","xing-sign","youtube","youtube-play","youtube-sign","ambulance","h-sign","hospital","medkit","plus-sign-alt","stethoscope","user-md");

        return array_unique($iconsArray);
            
    }
}



if(!function_exists('vc_icon_form_field')) {
    function vc_icon_form_field($settings, $value) {
        $settings_line = '';
        $selected = '';
        $array = et_get_icons();
        if($value != '') {
            $array = array_diff($array, array($value));
            array_unshift($array,$value);
        }
        
        $settings_line .= '<div class="et-icon-selector">';
        $settings_line .= '<input type="hidden" value="'.$value.'" name="'.$settings['param_name'].'" class="et-hidden-icon wpb_vc_param_value wpb-icon-select '.$settings['param_name'].' '.$settings['type'] . '">';
            foreach ($array as $icon) {
                if ($value == $icon) {
                    $selected = 'selected';
                }
                $settings_line .= '<span class="et-select-icon '.$selected.'" data-icon-name='.$icon.'><i class="icon-'.$icon.'"></i></span>';
                $selected = '';
            }

        $settings_line .= '<script>';
        $settings_line .= 'jQuery(".et-select-icon").click(function(){';
            $settings_line .= 'var iconName = jQuery(this).data("icon-name");';
            $settings_line .= 'console.log(iconName);';
            $settings_line .= 'if(!jQuery(this).hasClass("selected")) {';
                $settings_line .= 'jQuery(".et-select-icon").removeClass("selected");';
                $settings_line .= 'jQuery(this).addClass("selected");';
                $settings_line .= 'jQuery(this).parent().find(".et-hidden-icon").val(iconName);';
            $settings_line .= '}';

        $settings_line .= '});';
        $settings_line .= '</script>';

        $settings_line .= '</div>';
        return $settings_line;
    }
}
