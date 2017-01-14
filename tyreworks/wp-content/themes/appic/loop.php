<?php if ( have_posts() ): ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('blog-post-wrap2 clearfix post-border'); ?>>
			<div class="post-comments pull-left text-right">
				<h3 class="page-elements-title"><?php the_time( 'F j, Y' ); ?></h3>
				<p class="simple-text-12 dark-grey-text"><?php comments_number(); ?> <?php //comments_link(); ?> <span class="comments-icon"></span></p>
			</div>
			<div class="blog-post-content2">
				<?php
					$noThumbClass = '';
					$thumbnail = theme_get_the_post_thumbnail( null, 'blog-style-2', array('class' => 'image-border'), array(620, 340) );
					
					if ( !empty($thumbnail) ) {
						echo '<div class="image-holder">' . $thumbnail . '</div>';
					} else {
						$noThumbClass = ' no-thumbnail';
					}
				?>
				<h2 class="font-style-24<?php echo $noThumbClass; ?>"><a href="<?php the_permalink(); ?>" class="link"><?php the_title(); ?></a></h2>
				<div class="simple-text-12 light-grey-text"><?php the_content( '<div>' . theme_excerpt_more_link() . '</div>' ); ?></div>
			</div>
		</div>
	<?php endwhile; ?>
	<?php echo appic_posts_navigation(); ?>
<?php endif; ?>