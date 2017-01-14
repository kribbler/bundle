<?php
/*
Template Name: Home Page
*/


	get_header();
?>

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
<?php
if ($_SERVER['REMOTE_ADDR'] == '83.103.200.163' || $_SERVER['REMOTE_ADDR'] == '203.96.192.232'){
}
?>
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

<div class="container"><div style="margin-top: -61px; min-height:440px"><?php 
if ($_SERVER['REMOTE_ADDR'] == '83.103.200.163'){
	putRevSlider("homepage2","homepage2");
} else {
	putRevSlider("homepage2","homepage2");
}
?></div>
	
</div>

<div class="wide_51">
	<div class="container">
		<?php echo do_shortcode("[block id='100']"); //Start yourt body transformation today?>
	</div>
</div>
<div class="container">
	<?php echo do_shortcode("[block id='69']"); //Our latest transformation success stories?>
</div>
		
<div id="bg_01">		<div class="container">
	<?php echo do_shortcode("[block id='71']"); //Get started and join today!?>	</div>
</div>
	
<div class="container bl_04">
	<?php echo do_shortcode("[block id='56']"); //What you will find at TomFit?>
</div>




<div class="wide_72">
	<div class="container wide_72_in">
		<div id="wide_72_in_in">
			<?php echo do_shortcode("[block id='72']");//For a motivating positive environment and a ton of fun?>
		</div>
	</div>
</div>



<div class="wide_blue">
	<div class="container wide_blue">
		<?php echo do_shortcode("[block id='70']"); //Don't wait another day to start your body transformation?>
	</div>
</div>

<!-- <div class="container">
	<?php echo do_shortcode("[block id='77']"); //Tabs block?>
</div> -->
 <div class="black-tab">
 <div class="container">
	<?php echo do_shortcode("[block id='62']"); //Tabs block?>
</div> 
</div>	 
<?php echo do_shortcode("[block id='68']"); //Google Map - Home Page?>	
	
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('p:empty').remove();
	});
</script>	
	
<?php
	get_footer();
?>
