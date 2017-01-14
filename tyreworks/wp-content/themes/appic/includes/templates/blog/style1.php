<section class="container blog-style-wrap">
	<div class="row">
		<div class="span8">
		<?php while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('blog-post-wrap clearfix post-border'); ?>>
				<div class="author-post pull-left text-center">
					<div class="author-post-photo-wrap border-triangle">
					<?php
						$author_id = get_the_author_meta( 'ID' );
						echo get_avatar( $author_id );
					?>
						<div class="holder-author-photo"></div>
					</div>
					<div class="author-info border-triangle">
						<h4 class="simple-text-16 bold"><?php the_author_posts_link(); ?></h4>
					</div>
					<p class="simple-text-12"><?php the_time( 'F j, Y' ); ?></p>
				</div>
				<div class="blog-post-content">
					<h2 class="font-style-24"><a href="<?php the_permalink(); ?>" class="link"><?php the_title(); ?></a></h2>
					<?php echo theme_get_the_post_thumbnail( null, 'blog-style', array(), array(630, 262) ); ?>
					<div class="simple-text-12 light-grey-text"><?php the_content( '<div>' . theme_excerpt_more_link() . '</div>' ); ?></div>
				</div>
			</div>
		<?php endwhile; ?>
		<?php appic_pagenavi();?>
		</div>
		<aside class="span4">
			<div class="aside-wrap">
			<?php get_sidebar(); ?>
			</div>
		</aside>
	</div>
</section>