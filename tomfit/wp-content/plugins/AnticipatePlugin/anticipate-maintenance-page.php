<?php
    global $ET_Anticipate;
    if ( isset($_POST['anticipate_email']) ) $ET_Anticipate->add_email( $_POST['anticipate_email'] );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php bloginfo('name'); ?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo $ET_Anticipate->location_folder ; ?>/css/style.css" />

	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ET_Anticipate->location_folder ; ?>/css/ie6style.css" />
		<script type="text/javascript" src="<?php echo $ET_Anticipate->location_folder ; ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
		<script type="text/javascript">DD_belatedPNG.fix('img#logo, #anticipate-top-shadow, #anticipate-center-highlight, #anticipate-overlay, #anticipate-piece, #anticipate-social-icons img');</script>
	<![endif]-->
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ET_Anticipate->location_folder ; ?>/css/ie7style.css" />
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body>

	<div id="anticipate-top-shadow">
		<div id="anticipate-center-highlight">
			<div id="anticipate-container" class="clearfix">
				<div id="anticipate-header">
					<?php do_action('et_anticipate_header'); ?>
					<?php if ( $ET_Anticipate->get_option('et_anticipate_logo') ) { ?>
						<img src="<?php echo $ET_Anticipate->get_option('et_anticipate_logo'); ?>" alt="logo" id="logo"/>
				   <?php } ?>

					<div id="anticipate-timer"></div>
					
					<div id="anticipate-progress-bar" class="clearfix">
						<div id="anticipate-bar"></div>
						<div id="anticipate-piece"></div>
						<span id="percent_text"><?php echo intval($ET_Anticipate->get_option('et_anticipate_complete_percent')); ?>%</span>
						<div id="anticipate-overlay"></div>
					</div> <!-- end #anticipate-progress-bar -->
				</div> <!-- end #anticipate-header -->
				
				<?php do_action('et_anticipate_before_slider'); ?>
				
				<div id="anticipate-slider">
					<?php do_action('et_anticipate_inside_slider'); ?>
					<div id="anticipate-slider-top">
						<a id="anticipate-left-arrow" href="#"><?php _e('Previous');?></a>
						<a id="anticipate-right-arrow" href="#"><?php _e('Next'); ?></a>
                                                
							<div id="anticipate-slider-content">
								<?php
									$et_content_pages = $ET_Anticipate->get_option('et_anticipate_content-pages');
									$et_anticipate_query_args = array('post_type' => 'page', 'orderby' => 'menu_order','order' => 'ASC','post__in' => $et_content_pages);
									$et_anticipate_query_args = apply_filters('et_anticipate_query_args', $et_anticipate_query_args);
									query_posts($et_anticipate_query_args);
									if (have_posts()) : while (have_posts()) : the_post();
								?>

									<div class="anticipate-slide">
										<div class="anticipate-quote">
											<div class="anticipate-quote-bottom">
												<h2><?php the_title(); ?></h2>
												<?php global $more; $more = 0;
												the_content(''); ?>
											</div> <!-- end .anticipate-quote-bottom -->
										</div> <!-- end .anticipate-quote -->
									</div> <!-- end .anticipate-slide -->
								<?php endwhile; endif; wp_reset_query(); ?>
							</div> <!-- end #anticipate-slider-content -->
					</div> <!-- end #anticipate-slider-top -->
				</div> <!-- end #anticipate-slider -->

				<div id="anticipate-footer">
					<?php do_action('et_anticipate_footer_icons'); ?>

					<div id="anticipate-subscribe">
						<form method="post" id="searchform" action="#">
							<input type="text" value="Enter your email to receive updates..." name="anticipate_email" id="searchinput" />
							<input type="submit" value="Submit" id="searchsubmit" />
						</form>
					</div> <!-- end #anticipate-subscribe -->
				</div> <!-- end #anticipate-footer -->
				
				<?php do_action('et_anticipate_footer'); ?>
			</div> <!-- end #anticipate-container -->
		</div> <!-- end #anticipate-center-highlight -->
	</div> <!-- end #anticipate-top-shadow -->
	
	<?php if ( $ET_Anticipate->get_option('et_anticipate_cufon') == 1 ) { ?>
		<script src="<?php echo $ET_Anticipate->location_folder ; ?>/js/cufon-yui.js" type="text/javascript"></script>
		<script src="<?php echo $ET_Anticipate->location_folder ; ?>/js/League_Gothic_400.font.js" type="text/javascript"></script>
		<script type="text/javascript">
			Cufon.replace('h1, h2, h3, h4, h5, h6');
		</script>
	<?php } ?>

	<script type="text/javascript" src="<?php echo $ET_Anticipate->location_folder ; ?>/js/jquery.cycle.all.min.js"></script>
	<script type="text/javascript" src="<?php echo $ET_Anticipate->location_folder ; ?>/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="<?php echo $ET_Anticipate->location_folder ; ?>/js/jquery.countdown.min.js"></script>

	<script type="text/javascript">
	//<![CDATA[
		jQuery.noConflict();

		et_subscribe_bar();

		var AnticipateDay = new Date();
		AnticipateDay = new Date('<?php echo $ET_Anticipate->get_option('et_anticipate_date'); ?>');
		jQuery('#anticipate-timer').countdown({until: AnticipateDay,layout: '<span class="timer"><strong>{dn}</strong> {dl}</span><span class="timer"><strong>{hn}</strong> {hl}</span><span class="timer"><strong>{mn}</strong> {ml}</span><span class="timer"><strong>{sn}</strong> {sl}</span>'});

		var $featured_content = jQuery('#anticipate-slider-content');

		if ($featured_content.length) {
			$featured_content.cycle({
				timeout: 0,
				speed: 500,
				cleartypeNoBg: true,
				prev:   '#anticipate-left-arrow',
				next:   '#anticipate-right-arrow'
			});
		}

		<!---- Search Bar Improvements ---->
		function et_subscribe_bar(){
			var $searchform = jQuery('#anticipate-subscribe'),
				$searchinput = $searchform.find("input#searchinput"),
				searchvalue = $searchinput.val();

			$searchinput.focus(function(){
				if (jQuery(this).val() === searchvalue) jQuery(this).val("");
			}).blur(function(){
				if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
			});
		};
		
		var $progress_bar = jQuery('#anticipate-bar'),
		$progress_torn_piece = jQuery('#anticipate-piece'),
		et_multiply = 7,
		et_percent = <?php echo intval($ET_Anticipate->get_option('et_anticipate_complete_percent')); ?>,
		et_percent_width = et_multiply*et_percent;
		
		if ( et_percent === 100 ) et_percent_width = 714;

		$progress_bar.animate({ width: ( et_percent_width - 20 ) }, 2000, function(){
			jQuery(this).animate({ width: ( et_percent_width ) }, 200);
			jQuery('#percent_text').animate({'opacity': 'toggle'}, 300);
			if ( et_percent != 100 ) 
				$progress_torn_piece.css({left: (et_percent_width-9), 'display': 'block'});
		});
		
		Cufon.now();
	//]]>
	</script>
	<?php wp_footer(); ?>
</body>
</html>