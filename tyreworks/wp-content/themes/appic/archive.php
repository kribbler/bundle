<?php get_header(); ?>

<div class="white-wrap container">
	<section class="blog-style-wrap">
		<div class="row">
			<div class="span8">
				<?php get_template_part('loop'); ?>
			</div>
			<aside class="span4">
				<div class="aside-wrap">
					<?php get_sidebar(); ?>
				</div>
			</aside>
		</div>
	</section>
</div>

<?php get_footer(); ?>