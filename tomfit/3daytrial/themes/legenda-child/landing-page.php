<?php
/*
Template Name: Landing Page
*/


	
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
  _fbq.push(['addPixelId', '1467292390178359']);
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', 'PixelInitialized', {}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=1467292390178359&amp;ev=NoScript" /></noscript>
    <?php global $etheme_responsive, $woocommerce;; ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <?php if($etheme_responsive): ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <?php endif; ?>
	<link rel="shortcut icon" href="<?php etheme_option('favicon',true) ?>" />
<link href='http://fonts.googleapis.com/css?family=Exo:400,900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;

		wp_title( '|', true, 'right' );

		// Add the blog name.
		bloginfo( 'name' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', ETHEME_DOMAIN ), max( $paged, $page ) );

		?></title>
		
        <!--[if IE 9]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri().'/css/'; ?>ie9.css"><![endif]-->
        
		<?php
			if ( is_singular() && get_option( 'thread_comments' ) )
				wp_enqueue_script( 'comment-reply' );

			wp_head();
		?>
    
   
</head>
<?php if(is_front_page()){ ?>
<style>
.d_inner_bg {
    background-image: url('http://www.tomfit.co.nz/wp-content/uploads/2014/06/bg03-1.png') !important;
}
</style>
<?php } ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=144999605548997";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<body <?php body_class(); ?>>
	

	<div class="mobile-nav side-block">
		<div class="close-mobile-nav close-block"><?php _e('Navigation', ETHEME_DOMAIN) ?></div>
		<?php 
			wp_nav_menu(array(
				'theme_location' => 'mobile-menu'
			)); 
		?>
	</div>

	<?php if(etheme_get_option('right_panel')): ?>
		<div class="side-area side-block hidden-phone hidden-tablet">
			<div class="close-side-area close-block"><i class="icon-remove"></i></div>
			<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('right-panel-sidebar')): ?>
				
				<div class="sidebar-widget">
					<h6><?php _e('Add any widgets you want in Apperance->Widgets->"Right side panel area"', ETHEME_DOMAIN) ?></h6>
				</div>

			<?php endif; ?>	
		</div>
	<?php endif; ?>	

	<?php $ht = ''; $ht = apply_filters('custom_header_filter',$ht); ?>


	<?php if (etheme_get_option('fixed_nav')): ?>
		<div class="fixed-header-area fixed-menu-type<?php etheme_option('menu_type'); ?> hidden-phone">
			<div class="fixed-header">
				<div class="container">
					<div class="menu-wrapper">
                        
					    <div class="menu-icon hidden-desktop"><i class="icon-reorder"></i></div>
						<div class="logo-with-menu">
							<?php etheme_logo(); ?>
						</div>

						<div class="modal-buttons">
							<?php if (class_exists('Woocommerce') && etheme_get_option('top_links')): ?>
	                        	<a href="#" class="shopping-cart-link hidden-desktop" data-toggle="modal" data-target="#cartModal">&nbsp;</a>
							<?php endif ?>
							<?php if (is_user_logged_in() && etheme_get_option('top_links')): ?>
								<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="my-account-link hidden-desktop">&nbsp;</a>
							<?php elseif(etheme_get_option('top_links')): ?>
								<a href="#" data-toggle="modal" data-target="#loginModal" class="my-account-link hidden-desktop">&nbsp;</a>
							<?php endif ?>
							<?php if (etheme_get_option('search_form')): ?>
								<a href="#" data-toggle="modal" data-target="#searchModal" class="search-link hidden-desktop">&nbsp;</a>
							<?php endif ?>
						</div>

						<?php if ( has_nav_menu( 'main-menu' ) ) : ?>
							<?php wp_nav_menu(array(
								'theme_location' => 'main-menu',
								'before' => '',
								'after' => '',
								'link_before' => '',
								'link_after' => '',
								'depth' => 4,
								'fallback_cb' => false,
								'walker' => new Et_Navigation
							)); ?>
						<?php else: ?>
							<p class="install-info">Set your main menu in <strong>Apperance &gt; Menus</strong></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif ?>
	
	<?php if (etheme_get_option('top_panel')): ?>
		<div class="top-panel">
			<div class="container">
				<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('top-panel-sidebar')): ?>
					
					<div class="sidebar-widget">
						<h6><?php _e('Add any widgets you want in Apperance->Widgets->"Hidden top panel area"', ETHEME_DOMAIN) ?></h6>
					</div>

				<?php endif; ?>	
			</div>
		</div>
	<?php endif ?>

	<div class="page-wrapper">
	

	<div class="header-wrapper<?php if(etheme_get_option('fade_animation')): ?> fade-in delay1<?php endif; ?> header-type-<?php echo $ht; ?>">
		<?php if (etheme_get_option('top_bar')): ?>
			<div class="top-bar">
				<div class="container">
					<div class="row-fluid">
						<div class="languages-area">
							<?php if(etheme_get_option('languages_area') && (!function_exists('dynamic_sidebar') || !dynamic_sidebar('languages-sidebar'))): ?>
									<div class="languages hidden-phone">
										<ul class="links">
											<li class="active"><a href="#">EN</a></li>
											<li><a href="#">DE</a></li>
											<li><a href="#">ES</a></li>
											<li><a href="#">FR</a></li>
										</ul>
									</div>
							<?php endif; ?>	
						</div>
						
						<?php if (etheme_get_option('top_panel')): ?>
							<div class="show-top-panel hidden-phone"></div>
						<?php endif ?>
						
						<?php if (etheme_get_option('search_form')): ?>
							<div class="search hide-input a-right">
								<span data-toggle="modal" data-target="#searchModal" class="search-link">search</span>
							</div>
						<?php endif ?>

						<?php if (class_exists('Woocommerce')): ?>
                        	<a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="shopping-cart-link" ><span><?php _e('Cart', ETHEME_DOMAIN) ?></span><span class="price-summ cart-totals"><?php echo $woocommerce->cart->get_cart_subtotal(); ?></span></a>
                        	
						<?php endif ?>


						<?php if (is_user_logged_in() && etheme_get_option('top_links')): ?>
							<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="my-account-link hidden-desktop">&nbsp;</a>
						<?php elseif(etheme_get_option('top_links')): ?>
							<a href="#" data-toggle="modal" data-target="#loginModal" class="my-account-link hidden-tablet hidden-desktop">&nbsp;</a>
						<?php endif ?>



						<?php if (etheme_get_option('top_links')): ?>
							<div class="top-links hidden-phone a-center">
								<?php child_etheme_top_links(); ?>
							</div>  <?php if(class_exists('Woocommerce') && !etheme_get_option('just_catalog') && etheme_get_option('cart_widget')): ?> 	                    <?php etheme_top_cart(); ?> 		            <?php endif ;?> 
						<?php endif ?>

						<?php if (class_exists('YITH_WCWL') && etheme_get_option('wishlist_link')): ?>
							<div class="fl-r wishlist-link">
								<a href="<?php echo YITH_WCWL::get_wishlist_url(); ?>"><i class="icon-heart-empty"></i><span><?php _e('Wishlist', ETHEME_DOMAIN) ?></span></a>
							</div>
						<?php endif ?>
						<?php if(etheme_get_option('right_panel')): ?>
							<div class="side-area-icon hidden-phone hidden-tablet"><i class="icon-reorder"></i></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif ?>

		<header class="header header<?php echo $ht; ?>">
			
			<div class="container">
				<div class="table-row">

    				<?php if (etheme_get_option('search_form')): ?>
    					<div class="search search-left hidden-phone hidden-tablet a-left">
								<?php echo etheme_search(array()); ?>
    					</div>
    				<?php endif ?>
                    
					<div class="logo"><?php etheme_logo(); ?></div>

					<?php if (etheme_get_option('search_form')): ?>
						<div class="search search-center hidden-phone hidden-tablet">
							<div class="site-description hidden-phone hidden-tablet"><?php bloginfo( 'description' ); ?></div>
								<?php echo etheme_search(array()); ?>
						</div>
					<?php endif ?>

		          
		            <div class="d_header_links">		            	<ul>		            		<li><a href="#" style="background-color:grey; box-shadow: 0px 0px 15px #000;margin-right:12px;">Timetable</a></li>		            		<li><a href="#" style="background-color:grey; box-shadow: 0px 0px 15px #000;margin-right:5px;">Location</a></li>		            		<li></li>		            		<li><a href="https://www.facebook.com/pages/TomFIT-Personal-Training-Studios/114265438627357" target="_blank"><img id="icon_fb" src="<?php echo get_stylesheet_directory_uri();?>/images/icon_facebook.png" /></a></li>		            		<li><a href="#" ><img id="icon_tw" src="<?php echo get_stylesheet_directory_uri();?>/images/icon_twitter.png" /></a></li>		            		<li><a href="#" ><img id="icon_li" src="<?php echo get_stylesheet_directory_uri();?>/images/icon_linkedin.png" /></a></li>
		            	
		            	</ul>
		            </div>
		            <div id="d_call"><h2 style="font-size: 30px !important;">WHERE IT’S ALL ABOUT <span style="color: rgb(0, 172, 241); font-size: 40px;">YOU</span><br /><span style="text-transform: none;">Call</span> 09 215 7956</h2></div>
					<div class="menu-icon hidden-desktop"><i class="icon-reorder"></i></div>
				</div>
			</div>

		</header>
		<div class="main-nav visible-desktop">
			<div class="double-border">
				<div class="container">
					<div class="menu-wrapper menu-type<?php etheme_option('menu_type'); ?>">
						<div class="logo-with-menu">
							<?php etheme_logo(); ?>
						</div>
						<?php if ( has_nav_menu( 'main-menu' ) ) : ?>
							<?php wp_nav_menu(array(
								'theme_location' => 'main-menu',
								'before' => '',
								'after' => '',
								'link_before' => '',
								'link_after' => '',
								'depth' => 4,
								'fallback_cb' => false,
								'walker' => new Et_Navigation
							)); ?>
						<?php else: ?>
							<br>
							<p class="install-info">Set your main menu in <strong>Apperance &gt; Menus</strong></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php 	if (is_woocommerce()) echo '<div class="d_woocommerce_bg">';	else if(!is_home()) echo '<div class="d_inner_bg">';		?>
<script type="text/javascript"> jQuery(document).ready(function() { jQuery.fn.cleardefault = function() { return this.focus(function() { if( this.value == this.defaultValue ) { this.value = ""; } }).blur(function() { if( !this.value.length ) { this.value = this.defaultValue; } }); }; jQuery(".focusfix input, .focusfix textarea").cleardefault(); }); </script>
<style>
body {
    background-color: #151515;
    background-image: url("http://www.tomfit.co.nz/wp-content/uploads/2014/08/background.png") !important;
    background-repeat: repeat;
    margin-top: -58px;
    font-family: 'Roboto Condensed' !important;
    font-size: 16px !important;
}
.logo {display: none !important; }
.top-bar { display: none; }
.d_header_links { display: none; }
#d_call { display: none; }
.page-wrapper {
    background: none repeat scroll 0 0 transparent;
    transition: all 0.2s ease-in-out 0s;
}
.main-nav { display: none !important; }
.landing-header {background-color: #000;
    color: #fff;
    margin-top: -55px;
    min-height: 400px; }
.header5, .header6, .header1, .header7 { display: none !important; }
.d_inner_bg {background: none !important; }
.landing-header-2 { color: #fff; }
.landing-header-2 ol, .landing-header-2 ul {
    list-style-type: square;
    margin-bottom: 20px;
    padding-left: 20px;
}
.landing-header-1 {  background-image: url("http://www.tomfit.co.nz/wp-content/uploads/2014/08/top_landing.png");
    background-position: center top;
    background-repeat: repeat-x;
    margin-bottom: -35px;
    min-height: 760px; }
.landing-header-2 ul li { padding-bottom: 15px; }
.landing-header-3 { background-color: #0083bf;
    color: #fff;
    font-family: 'Oswald';
    line-height: 38px;
    text-transform: uppercase; }
.landing-header-3 label, .landing-header-4 label { }
.gform_wrapper .left_label .gfield_label {
	font-weight: normal !important;
}
.landing-header-3 input, [type="text"], .landing-header-4 input, [type="text"] { 
	background-color: #fff !important; width: 100% !important; 
}
.landing-header-3 ol, ul, .landing-header-4 ol,.landing-header-4 ul {
    list-style-type: none;
    margin-bottom: 0;
    padding-left: 0;
}
.landing-header-3 input[type="submit"], .landing-header-4 input[type="submit"], .landing-header-1 input[type="submit"] { background-color: #ffe200 !important;
    border: medium none;
    color: #30312c !important;
    font-size: 16px;
    font-weight: bold;
    padding: 10px;
    border-radius: 10px; }

.landing-header-1 input[type="submit"] { border-radius: 10px;
    padding: 10px 32px !important; }
.landing-header-4 { background-color: #0a0a0a;
    color: #fff;
    font-family: 'Oswald';
    font-size: 16px;
    font-weight: normal;
    margin-top: 40px;
    padding: 25px 0;
    text-transform: uppercase; }

.gform_wrapper .gform_footer {
	padding: 16px 0 10px !important;
}

footer {
	display: none;
}
@media screen and (max-width: 769px) { 
.landing-header-1 { margin-bottom: 35px; }
}

</style>
<script type="text/javascript">
	jQuery(document).ready(function() {
	 
	    jQuery.fn.cleardefault = function() {
	    return this.focus(function() {
	        if( this.value == this.defaultValue ) {
	            this.value = "";
	        }
	    }).blur(function() {
	        if( !this.value.length ) {
	            this.value = this.defaultValue;
	        }
	    });
	};
	jQuery(".clearit input, .clearit textarea").cleardefault();
	 
	});
	 
	</script>
<?php 
	//extract(etheme_get_page_sidebar());
?>

<?php if (1==2 && $page_heading != 'disable' && ($page_slider == 'no_slider' || $page_slider == '')): ?>
	<div class="page-heading bc-type-<?php etheme_option('breadcrumb_type'); ?>">
		<div class="container">
			<div class="row-fluid">
				<div class="span12 a-center">
					<h1 class="title"><span><?php the_title(); ?></span></h1>
					<?php etheme_breadcrumbs(); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>

<?php if($page_slider != 'no_slider' && $page_slider != ''): ?>
	
	<?php echo do_shortcode('[rev_slider_vc alias="'.$page_slider.'"]'); ?>

<?php endif; ?>

<div class="container">
	<div class="page-content sidebar-position-<?php echo $position; ?> responsive-sidebar-<?php echo $responsive; ?>">
		<div class="row-fluid">
			

			<?php if($position == 'right' || ($responsive == 'bottom' && $position == 'left')): ?>
				<div class="<?php echo $sidebar_span; ?> sidebar sidebar-right">
					<?php etheme_get_sidebar($sidebarname); ?>
				</div>
			<?php endif; ?>
		</div><!-- end row-fluid -->

	</div>
</div><!-- end container -->
<div class="landing-header-1">
	<div class="container">
		<?php echo do_shortcode("[block id='212']"); //Dont wait another Monday?>
	</div>
</div>
<div class="landing-header-2">
	<div class="container">
		<?php echo do_shortcode("[block id='194']"); //Dont wait another Monday?>
	</div>
</div>

<div class="landing-header-3">
	<div class="container">
		<?php echo do_shortcode("[block id='202']"); //Sign Up Now?>
	</div>
</div>
<div class="landing-header-2">
	<div class="container">
		<?php echo do_shortcode("[block id='205']"); //What our clients are saying about us?>
	</div>
</div>
<div class="landing-header-4">
	<div class="container">
		<?php echo do_shortcode("[block id='208']"); //Sign Up?>
	</div>
</div>
</div>	 
<?php echo do_shortcode("[block id='']"); //Google Map - Home Page?>	
	
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('p:empty').remove();
	});
</script>	
	
<?php
	get_footer();
?>