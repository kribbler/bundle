<?php
/*
 * Template Name: Home
 */

// hiding breadcrumbs for this template
ThemeFlags::set('hide_breadcrumbs', true);

get_header();
?>

<?php if (get_theme_option('home_call_block_show')) {
	get_template_part('includes/templates/home/call-action-block');
} ?>

<div class="white-wrap container page-content">
	<?php if (have_posts()): ?>
		<?php while(have_posts()) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	<?php endif; ?>
</div>

<?php get_footer(); ?>