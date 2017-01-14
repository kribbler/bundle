<?php
	
	/* 
	Template Name: Homepage 3
	*/

	//Display Header
	get_header();
	
	//Get Post ID
	global $wp_query; $post_id = $wp_query->post->ID;
	
	//Get Header Image
	$header_image = page_header(get_post_meta($post_id, 'qns_page_header_image_url', true));
	
	//Get Content ID/Class
	$content_id_class = content_id_class(get_post_meta($post_id, 'qns_page_sidebar', true));
	
	//Reset Query
	wp_reset_query();



/* ------------------------------------------------
	Display Slideshow
------------------------------------------------ */

if ($smof_data['slideshow_display']) { ?>

<!-- BEGIN #slider -->
<div id="slider">

	<?php if ($smof_data['homepage_slider']) { ?>

		<div class="slider">
			<ul class="slides">
				<?php $slides = $smof_data['homepage_slider']; ?>	
				<?php foreach ($slides as $slide) { ?>
					<li>
						<?php if ( $slide['link'] ) { echo '<a href="' . $slide['link'] . '" target="_blank" class="slide-link">'; } ?>
						<img src="<?php echo $slide['url']; ?>" alt="" />
						<?php if ( $slide['description'] ) { 
							echo '<div class="slider-caption-wrapper"><div class="slider-caption">' . $slide['description'] . '</div></div>'; 
						} ?>
						<?php if ( $slide['link'] ) { echo '</a>'; } ?>
					</li>
				<?php } ?>
			</ul>
		</div>

	<?php } else { ?>
		<p><?php _e('No Slides','qns'); ?></p>
	<?php }



/* ------------------------------------------------
	Display Slideshow Booking Form
------------------------------------------------ */

if(is_plugin_active('quitenicebooking/quitenicebooking.php')) {
	if ( $smof_data['display_slideshow_booking'] ) {echo do_shortcode("[booking_form]");}
} ?>

<!-- END #slider -->
</div>

<?php } else { ?>
	<hr class="space1" />
<?php }



/* ------------------------------------------------
	Display Three Blocks
------------------------------------------------ */
?>

<!-- BEGIN .content-wrapper -->
<div class="content-wrapper clearfix">
	
	<!-- BEGIN .clearfix -->
	<div class="clearfix">

		<!-- BEGIN .one-third -->
		<div class="one-third clearfix">
	
			<?php if ($smof_data['homepage_block_title_1'] ) { ?>
				<h3 class="title-style1"><?php _e($smof_data['homepage_block_title_1'],'qns'); ?><span class="title-block"></span></h3>
			<?php } ?>
			
			<?php echo do_shortcode($smof_data['homepage_block_content_1']); ?>
			
			<?php if ($smof_data['homepage_block_button_1'] ) { ?>
				<p><a href="<?php _e($smof_data['homepage_block_link_1'],'qns'); ?>" class="button1"><?php _e($smof_data['homepage_block_button_1'],'qns'); ?></a></p>
			<?php } ?>
	
		<!-- END .one-third -->	
		</div>
		
		<!-- BEGIN .one-third -->
		<div class="one-third clearfix">
	
			<?php if ($smof_data['homepage_block_title_2'] ) { ?>
				<h3 class="title-style1"><?php _e($smof_data['homepage_block_title_2'],'qns'); ?><span class="title-block"></span></h3>
			<?php } ?>
			
			<?php echo do_shortcode($smof_data['homepage_block_content_2']); ?>
			
			<?php if ($smof_data['homepage_block_button_2'] ) { ?>
				<p><a href="<?php _e($smof_data['homepage_block_link_2'],'qns'); ?>" class="button1"><?php _e($smof_data['homepage_block_button_2'],'qns'); ?></a></p>
			<?php } ?>
	
		<!-- END .one-third -->	
		</div>
		
		<!-- BEGIN .one-third -->
		<div class="one-third last-col clearfix">
	
			<?php if ($smof_data['homepage_block_title_3'] ) { ?>
				<h3 class="title-style1"><?php _e($smof_data['homepage_block_title_3'],'qns'); ?><span class="title-block"></span></h3>
			<?php } ?>
			
			<?php echo do_shortcode($smof_data['homepage_block_content_3']); ?>
			
			<?php if ($smof_data['homepage_block_button_3'] ) { ?>
				<p><a href="<?php _e($smof_data['homepage_block_link_3'],'qns'); ?>" class="button1"><?php _e($smof_data['homepage_block_button_3'],'qns'); ?></a></p>
			<?php } ?>
	
		<!-- END .one-third -->	
		</div>

	<!-- END .clearfix -->
	</div>

<!-- BEGIN .content-wrapper -->
</div>

<?php get_footer(); ?>