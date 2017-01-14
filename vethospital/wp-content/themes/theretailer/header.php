<?php
global $woo_options;
global $woocommerce;
global $theretailer_theme_options;
?>

<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]--><head>

<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />

<title><?php wp_title( '|', true, 'right' ); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- ******************************************************************** -->
<!-- ************************ Custom Favicon **************************** -->
<!-- ******************************************************************** -->

<link rel="shortcut icon" href="<?php if ($theretailer_theme_options['favicon_image']) { echo $theretailer_theme_options['favicon_image']; ?>
<?php } else { ?><?php echo get_template_directory_uri(); ?>/favicon.png<?php } ?>" />

<!-- ******************************************************************** -->
<!-- ******************** Custom Retina Favicon ************************* -->
<!-- ******************************************************************** -->

<link rel="apple-touch-icon-precomposed" href="<?php if ($theretailer_theme_options['favicon_retina']) { echo $theretailer_theme_options['favicon_retina']; ?>
<?php } else { ?><?php echo get_template_directory_uri(); ?>/apple-touch-icon-precomposed.png<?php } ?>" />

<!-- ******************************************************************** -->
<!-- *********************** Custom Javascript ************************** -->
<!-- ******************************************************************** -->

<?php echo $theretailer_theme_options['custom_js_header']; ?>

<!-- ******************************************************************** -->
<!-- *********************** WordPress wp_head() ************************ -->
<!-- ******************************************************************** -->
	
<?php wp_head(); ?>
</head>

<!-- *********************************************************************** -->
<!-- ********************* EVERYTHING STARTS HERE ************************** -->
<!-- *********************************************************************** -->

<body <?php body_class(); ?>>
    
    <div id="global_wrapper">
  
    <?php if ( (!$theretailer_theme_options['hide_topbar']) || ($theretailer_theme_options['hide_topbar'] == 0) ) { ?>
    <div class="gbtr_tools_wrapper">
        <div class="container_12">
            <div class="grid_5">
        		<div class="gbtr_tools_info"><?php echo $theretailer_theme_options['topbar_text']; ?></div>
            </div>
            <div class="grid_7">
                <div class="gbtr_tools_search">
                    <form method="get" action="<?php echo home_url(); ?>">
                        <input class="gbtr_tools_search_inputtext" type="text" value="<?php echo esc_html($s, 1); ?>" name="s" id="s" />
                        <input class="gbtr_tools_search_inputbutton" type="submit" value="Search" />
                        <?php 
						/**
						* Check if WooCommerce is active
						**/
						if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
						?>
                        <input type="hidden" name="post_type" value="product">
                        <?php } ?>
                    </form>
                </div>
                <div class="gbtr_tools_account">
                    <ul>
                        <?php if ( has_nav_menu( 'tools' ) ) : ?>
						<?php  
						wp_nav_menu(array(
							'theme_location' => 'tools',
							'container' =>false,
							'menu_class' => '',
							'echo' => true,
							'items_wrap'      => '%3$s',
							'before' => '',
							'after' => '',
							'link_before' => '',
							'link_after' => '',
							'depth' => 0,
							'fallback_cb' => false,
						));
						?>
                        <?php else: ?>
                            Define your top bar navigation.
                        <?php endif; ?>
                    </ul>
                </div>               
            </div>
        </div>
    </div>
    <?php } ?>
    
    <div class="gbtr_header_wrapper">
        <div class="container_12">
            <div class="grid_3">
                <a href="<?php echo home_url(); ?>" class="gbtr_logo">
                <img src="<?php if ( !$theretailer_theme_options['site_logo'] ) { ?><?php echo get_template_directory_uri(); ?>/images/logo.png
                <?php } else echo $theretailer_theme_options['site_logo']; ?>" alt="" />
                </a>
                &nbsp;
            </div>
            <div class="grid_9">
                <div class="menus_wrapper" <?php if ( ($theretailer_theme_options['catalog_mode']) && ($theretailer_theme_options['catalog_mode'] == 1) ) { ?>style="margin:0"<?php } ?>>
                    <div class="gbtr_first_menu">
                        <div class="gbtr_first_menu_inside">
                            
							<?php
								if ( in_array( 'ubermenu/ubermenu.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
							?>
                            	<ul>
                            <?php
                            	} else {
							?>
								<ul id="menu" class="sf-menu">
                            <?php
								}
							?>
                            
                                <?php if ( has_nav_menu( 'primary' ) ) : ?>
								<?php  
                                wp_nav_menu(array(
                                    'theme_location' => 'primary',
                                    'container' =>false,
                                    'menu_class' => '',
                                    'echo' => true,
                                    'items_wrap'      => '%3$s',
                                    'before' => '',
                                    'after' => '',
                                    'link_before' => '',
                                    'link_after' => '',
                                    'depth' => 0,
                                    'fallback_cb' => false,
                                ));
                                ?>
                                <?php else: ?>
                                    <a>Define your primary navigation.</a>
                                <?php endif; ?>
                            </ul>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="gbtr_second_menu">
                        <ul>
                            <?php if ( has_nav_menu( 'secondary' ) ) : ?>
							<?php  
                            wp_nav_menu(array(
                                'theme_location' => 'secondary',
                                'container' =>false,
                                'menu_class' => '',
                                'echo' => true,
                                'items_wrap'      => '%3$s',
                                'before' => '',
                                'after' => '',
                                'link_before' => '',
                                'link_after' => '',
                                'depth' => 0,
                                'fallback_cb' => false,
                            ));
                            ?>
                            <?php else: ?>
                            	Define your secondary navigation.
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                
                <div class="mobiles_menus_wrapper">
                    <div class="gbtr_menu_mobiles">
                    <div class="gbtr_menu_mobiles_inside
                    <?php if ( ($theretailer_theme_options['catalog_mode']) && ($theretailer_theme_options['catalog_mode'] == 1) ) { ?>
                    gbtr_menu_mobiles_inside_catalog_mode
                    <?php } ?>
                    ">
                        <select>
                            <option selected><?php _e('Navigation', 'theretailer'); ?></option>
                            <?php
                            class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu{
                                function start_lvl(&$output, $depth){
                                  $indent = str_repeat("\t", $depth); // don't output children opening tag (`<ul>`)
                                }
                            
                                function end_lvl(&$output, $depth){
                                  $indent = str_repeat("\t", $depth); // don't output children closing tag
                                }
                            
                                function start_el(&$output, $item, $depth, $args){
                                  
								  // add spacing to the title based on the depth
                                  $item->title = str_repeat("&nbsp;", $depth * 4). " " . $item->title;
                            
                                  parent::start_el($output, $item, $depth, $args);
								  
                                  $output = str_replace("<li", "\n<option", $output);
                                  
                                  $output = str_replace('><a href=', ' value=', $output);
                                  $output = str_replace('</a></option>', '</option>', $output);
								  $output = str_replace('</option></option>', '</option>', $output);
								  $output = str_replace("</a>", "</option>\n", $output);
                                }
                            
                                function end_el(&$output, $item, $depth){
								}
                            }
                            
                            wp_nav_menu(array(
                                'theme_location' => 'primary',
                                'container' =>false,
                                'menu_class' => '',
                                'echo' => true,
                                'items_wrap'      => '%3$s',
                                'before' => '',
                                'after' => '',
                                'link_before' => '',
                                'link_after' => '',
                                'depth' => 0,
                                'fallback_cb' => false,
                                'walker' => new Walker_Nav_Menu_Dropdown()
                            ));
                            
                            wp_nav_menu(array(
                                'theme_location' => 'secondary',
                                'container' =>false,
                                'menu_class' => '',
                                'echo' => true,
                                'items_wrap'      => '%3$s',
                                'before' => '',
                                'after' => '',
                                'link_before' => '',
                                'link_after' => '',
                                'depth' => 0,
                                'fallback_cb' => false,
                                'walker' => new Walker_Nav_Menu_Dropdown(),
                            ));
                            
                            ?>
                        </select>            
                    </div>
                    
                    </div>
                    
                    <?php if ( (!$theretailer_theme_options['catalog_mode']) || ($theretailer_theme_options['catalog_mode'] == 0) ) { ?>
                    
                    <?php 
					/**
					* Check if WooCommerce is active
					**/
					if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					
					?>
                    
                    <!---->
                    
                    <div class="gbtr_dynamic_shopping_bag">
                
                        <div class="gbtr_little_shopping_bag_wrapper">
                            <div class="gbtr_little_shopping_bag">
                                <div class="title"><a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>"><?php _e('Shopping Bag', 'theretailer'); ?></a></div>
                                <div class="overview"><?php echo $woocommerce->cart->get_cart_total(); ?> <span class="minicart_items">/ <?php echo $woocommerce->cart->cart_contents_count; ?> <?php _e('item(s)', 'theretailer'); ?></span></div>
                            </div>
                            <div class="gbtr_minicart_wrapper">
                                <div class="gbtr_minicart">
                                <?php                                    
                                echo '<ul class="cart_list">';                                        
                                    if (sizeof($woocommerce->cart->cart_contents)>0) : foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) :
                                    
                                        $_product = $cart_item['data'];                                            
                                        if ($_product->exists() && $cart_item['quantity']>0) :                                            
                                            echo '<li class="cart_list_product">';                                                
                                                echo '<a class="cart_list_product_img" href="'.get_permalink($cart_item['product_id']).'">' . $_product->get_image().'</a>';                                                    
                                                echo '<div class="cart_list_product_title">';
                                                    $gbtr_product_title = $_product->get_title();
                                                    //$gbtr_short_product_title = (strlen($gbtr_product_title) > 28) ? substr($gbtr_product_title, 0, 25) . '...' : $gbtr_product_title;
                                                    echo '<a href="'.get_permalink($cart_item['product_id']).'">' . apply_filters('woocommerce_cart_widget_product_title', $gbtr_product_title, $_product) . '</a>';
                                                    echo '<div class="cart_list_product_quantity">'.__('Quantity:', 'theretailer').' '.$cart_item['quantity'].'</div>';
                                                echo '</div>';
                                                echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'woocommerce') ), $cart_item_key );
                                                echo '<div class="cart_list_product_price">'.woocommerce_price($_product->get_price()).'</div>';
                                                echo '<div class="clr"></div>';                                                
                                            echo '</li>';                                         
                                        endif;                                        
                                    endforeach;
                                    ?>
                                            
                                    <div class="minicart_total_checkout">                                        
                                        <?php _e('Cart subtotal', 'theretailer'); ?><span><?php echo $woocommerce->cart->get_cart_total(); ?></span>                                   
                                    </div>
                                    
                                    <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="button gbtr_minicart_cart_but"><?php _e('View Shopping Bag', 'theretailer'); ?></a>   
                                    
                                    <a href="<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>" class="button gbtr_minicart_checkout_but"><?php _e('Proceed to Checkout', 'theretailer'); ?></a>
                                    
                                    <?php                                        
                                    else: echo '<li class="empty">'.__('No products in the cart.','woocommerce').'</li>'; endif;                                    
                                echo '</ul>';                                    
                                ?>                                                                        
                
                                </div>
                            </div>
                            
                        </div>
                        
                        <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="gbtr_little_shopping_bag_wrapper_mobiles"><span><?php echo $woocommerce->cart->cart_contents_count; ?></span></a>
                    
                    </div>
                    
                    <script type="text/javascript">// <![CDATA[
					jQuery(function(){
					  jQuery(".cart_list_product_title a").each(function(i){
						len=jQuery(this).text().length;
						if(len>25)
						{
						  jQuery(this).text(jQuery(this).text().substr(0,25)+'...');
						}
					  });
					});
					// ]]></script>
                    
                    <!---->
                    
                    <?php } ?>
                    
                    <?php } ?>
                    
                    <div class="clr"></div>
                
                </div>
                
                
            </div>
            
        </div>
    </div>
