<?php get_header(); ?>

<div class="white-wrap">
	<div class="container">
<?php $layoutType = get_theme_option('portfolio_layout'); ?>
<?php if (have_posts()): ?>
	<?php switch ($layoutType) {
	case '3':
		get_template_part('includes/templates/project/layout-3columns');
		break;

	case 'random':
		get_template_part('includes/templates/project/layout-random');
		break;

	default:
		get_template_part('includes/templates/project/layout-2columns');
		break;
	} ?>
<?php endif; ?>
	</div><!-- end of .container -->
</div><!-- end of .white-wrap -->

<?php get_footer(); ?>