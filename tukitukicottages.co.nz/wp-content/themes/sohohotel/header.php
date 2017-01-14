<?php 

// Fetch options stored in $smof_data
global $smof_data;
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html <?php language_attributes(); ?> class="ie6"> <![endif]-->
<!--[if IE 7]>    <html <?php language_attributes(); ?> class="ie7"> <![endif]-->
<!--[if IE 8]>    <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<!-- BEGIN head -->
<head>

	<!-- Meta Tags -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1" >
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
	
	<?php 
		// Dislay Google Analytics Code
		if( $smof_data['google_analytics'] ) { 
			echo $smof_data['google_analytics'];
		}
		
		// Dislay Favicon
		if( $smof_data['favicon_url'] ) { 			
			echo '<link rel="shortcut icon" href="' . $smof_data['favicon_url'] . '" type="image/x-icon" />';
		}
	?>
	
	<!-- Title -->
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<?php wp_head(); ?>
	
<!-- END head -->
</head>

<!-- BEGIN body -->
<body <?php body_class('loading'); ?>>

	<!-- BEGIN #background-wrapper -->
	<div id="background-wrapper">
	
	<!-- BEGIN #wrapper -->
	<div id="wrapper">
		
		<!-- BEGIN #header-gmap -->
		<div id="header-gmap">
			
			<div id="map-canvas"></div>
			
		<!-- END #header-gmap -->
		</div>
		
		<!-- BEGIN #topbar -->
		<div id="topbar">
			
			<!-- #topbar-wrapper -->
			<div id="topbar-wrapper" class="clearfix">
				
				<!-- BEGIN .topbar-left -->
				<div class="topbar-left">
					
					<a href="#" class="gmap-button"></a>
					
				<!-- END .topbar-left -->
				</div>
				
				<!-- BEGIN .topbar-right -->
				<div class="topbar-right clearfix">
					
					<?php if(is_plugin_active('quitenicebooking/quitenicebooking.php')) { ?>
						<a href="<?php $book_now = get_option('quitenicebooking'); echo get_permalink($book_now['step_1_page_id']); ?>" class="button0"><?php _e('Book Now','qns'); ?></a>
					<?php } ?>
					
					<!-- Secondary Navigation -->
					<?php wp_nav_menu( array(
						'theme_location' => 'secondary',
						'container' =>false,
						'items_wrap' => '<ul id="language-selection">%3$s</ul>',
						'fallback_cb' => false,
						'echo' => true,
						'before' => '',
						'after' => '',
						'link_before' => '',
						'link_after' => '',
						'depth' => 0 )
					); ?>

					<?php if( ($smof_data['phone_number']) or ($smof_data['email_address']) ) { ?>
						<ul class="header-contact">
					<?php } ?>
						
						<?php if($smof_data['phone_number'] != '') { ?>
							<li class="phone_icon"><?php echo $smof_data['phone_number']; ?></li>
						<?php } ?>

						<?php if($smof_data['email_address'] != '') { ?>
							<li class="email_icon"><a href="mailto:<?php echo $smof_data['email_address']; ?>"><?php echo $smof_data['email_address']; ?></a></li>
						<?php } ?>
						
					<?php if( ($smof_data['phone_number']) or ($smof_data['email_address']) ) { ?>
						</ul>
					<?php } ?>

				<!-- END .topbar-right -->
				</div>
			
			<!-- END #topbar-right -->
			</div>
			
		<!-- END #topbar -->
		</div>
		
		<div role="banner">
		
			<!-- BEGIN .content-wrapper -->
			<div class="content-wrapper clearfix">

				<?php if( $smof_data['text_logo'] ) : ?>
					<div id="logo">
						<h1>
							<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ) ?>
							<span id="tagline"><?php bloginfo( 'description' ) ?></span></a>
						</h1>
					</div>

				<?php elseif( $smof_data['image_logo'] ) : ?>
					<div id="logo" class="site-title-image">
						<h1>
							<a href="<?php echo home_url(); ?>"><img src="<?php echo $smof_data['image_logo']; ?>" alt="" /></a>
							<span id="tagline"><?php bloginfo( 'description' ) ?></span>
						</h1>
					</div>

				<?php else : ?>	
					<div id="logo">
						<h1>	
							<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ) ?>
							<span id="tagline"><?php bloginfo( 'description' ) ?></span></a>
						</h1>
					</div>
				<?php endif ?>
				
				<!-- .main-navigation -->
				<nav class="main-navigation">
					
					<!-- Main Menu -->
					<?php wp_nav_menu( array(
						'theme_location' => 'primary',
						'container' => false,
						'items_wrap' => '<ul id="navigation">%3$s</ul>',
						'fallback_cb' => 'wp_page_menu_qns',
						'echo' => true,
						'before' => '',
						'after' => '',
						'link_before' => '',
						'link_after' => '',
						'depth' => 0,
						'walker' => new description_walker() )
				 	); ?>
				
				<!-- .main-navigation -->
				</nav>
				
				<!-- BEGIN .mobile-menu-wrapper -->
				<div class="mobile-menu-wrapper clearfix">
					<div class="mobile-menu-button"></div>
					<div class="mobile-menu-title"><?php _e('Navigation','qns'); ?></div>
					
					<!-- mobile-menu-inner -->
					<div class="mobile-menu-inner">				
						
						<!-- Mobile Menu -->
						<?php wp_nav_menu( array(
							'theme_location' => 'primary',
							'container' => false,
							'items_wrap' => '<ul id="mobile-menu">%3$s</ul>',
							'fallback_cb' => 'wp_page_mobile_menu_qns',
							'echo' => true,
							'before' => '',
							'after' => '',
							'link_before' => '',
							'link_after' => '',
							'depth' => 0 )
					 	); ?>

					<!-- mobile-menu-inner -->
					</div>

				<!-- END .mobile-menu-wrapper -->
				</div>

			<!-- END .content-wrapper -->
			</div>
		
		</div>