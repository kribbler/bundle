<?php get_header(); ?>

<div class="white-wrap container">
	<section class="blog-style-wrap">
		<div class="row">
			<div class="span8">
		<?php if (have_posts()): ?>
			<?php while (have_posts()) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('blog-post-wrap2 clearfix post-border'); ?>>
					<div class="blog-post-content blog-post-content-full">
						<h2 class="font-style-24"><a href="<?php the_permalink(); ?>" class="link"><?php the_title(); ?></a></h2>
						<div class="simple-text-12 light-grey-text"><?php the_excerpt(); ?></div>
					</div>
				</div>
			<?php endwhile; ?>
			<?php echo appic_posts_navigation(); ?>
		<?php else: ?>
				<h2 class="search"><?php _e('Sorry, no search results', 'appic'); ?></h2> 
		<?php endif; ?>
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