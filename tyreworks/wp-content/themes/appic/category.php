<?php get_header(); ?>

<div class="white-wrap">
	<?php
		$blogStyleType = get_theme_option('blog_style');
		get_template_part('includes/templates/blog/style' . $blogStyleType);
	?>
</div>

<?php get_footer(); ?>