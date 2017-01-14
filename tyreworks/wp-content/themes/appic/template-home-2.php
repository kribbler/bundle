<?php
/*
 * Template Name: Home - Revo Slider
 */

// hiding breadcrumbs for this template
ThemeFlags::set('hide_breadcrumbs', true);

get_header();
?>

<?php if (get_theme_option('home_show_slider')) {
	$sliderAlias = get_theme_option('home_slider_alias');
	if ('full_width' == get_theme_option('home_slider_mode')) { ?>
<section id="home-revo-slider2">
	 <div class="fullwidthbanner-container">
		<div class="fullwidthbanner">
			<?php echo do_shortcode('[rev_slider ' . $sliderAlias . ']'); ?>
			<div class="tp-bannertimer tp-bottom"></div>
		</div>
	</div>
</section>
	<?php } else { ?>
<section id="home-revo-slider1">
	<div class="bannercontainer">
		<div class="banner">
			<?php echo do_shortcode('[rev_slider ' . $sliderAlias . ']'); ?>
			<div class="tp-bannertimer tp-bottom"></div>
		</div>
	</div>
</section>
	<?php } ?>
<?php } ?>


<div class="white-wrap container page-content">
	<?php if (have_posts()): ?>
		<?php while(have_posts()) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	<?php endif; ?>
</div>

<?php get_footer(); ?>