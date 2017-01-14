<?php 
	get_header();
?>

<?php 
	extract(etheme_get_page_sidebar());
	$blog_slider = etheme_get_option('blog_slider');
	$postspage_id = get_option('page_for_posts');
?>


<?php if ($page_heading != 'disable' && ($page_slider == 'no_slider' || $page_slider == '')): ?>
	<div class="page-heading bc-type-<?php etheme_option('breadcrumb_type'); ?>">
		<div class="container">
			<div class="row-fluid">
				<div class="span12 a-center">
				<h1 class="title"><span><?php echo get_the_title($postspage_id); ?></span></h1>
					<?php etheme_breadcrumbs(); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>

<?php if($page_slider != 'no_slider' && $page_slider != ''): ?>
	
	<?php echo do_shortcode('[rev_slider_vc alias="'.$page_slider.'"]'); ?>

<?php endif; ?>


<div class="container">
	<div class="page-content sidebar-position-<?php echo $position; ?> responsive-sidebar-<?php echo $responsive; ?>">
		<div class="row-fluid">
			<?php if($position == 'left' || ($responsive == 'top' && $position == 'right')): ?>
				<div class="<?php echo $sidebar_span; ?> sidebar sidebar-left">
					<?php etheme_get_sidebar($sidebarname); ?>
				</div>
			<?php endif; ?>

			<div class="content <?php echo $content_span; ?>">
				<?php if(have_posts()): while(have_posts()) : the_post(); ?>
					
					<article <?php post_class('blog-post post-single'); ?> id="post-<?php the_ID(); ?>">

					<?php $images = etheme_get_images(1000,1000,false); ?>

					<?php if (count($images)>0 && has_post_thumbnail()): ?>
						<div class="post-images nav-type-small<?php if (count($images)>1): ?> images-slider<?php endif; ?>">
							<ul class="slides">
								<?php if(!$blog_slider): ?>
									<li><img src="<?php echo $images[0]; ?>"></li>
								<?php else: ?>
									<?php foreach ($images as $key => $value): ?>
										<li><img src="<?php echo $value; ?>"></li>
									<?php endforeach ?>
								<?php endif; ?>
							</ul>
						</div>
						<?php if($blog_slider): ?>
							<script type="text/javascript">
								jQuery(document).ready(function(){
									jQuery('.post-images').flexslider({
										animation: "slide",
										slideshow: false,
										animationLoop: false,
										controlNav: false,
										smoothHeight: true
									});
								});
							</script>	
						<?php endif; ?>
					<?php endif ?>
						
						<h3 class="post-title"><?php the_title(); ?></h3>
						<div class="post-info">
							<span class="posted-on">
								<?php _e('Posted on', ETHEME_DOMAIN) ?>
								<?php the_date(get_option('date_format')); ?> 
								<?php _e('at', ETHEME_DOMAIN) ?> 
								<?php the_time(get_option('time_format')); ?>
							</span> 
							<span class="posted-by"> <?php _e('by', ETHEME_DOMAIN);?> <?php the_author_posts_link(); ?></span> / 
							<span class="posted-in"><?php the_category(',&nbsp;') ?></span> 
							<?php // Display Comments 

								if(comments_open() && !post_password_required()) {
									echo ' / ';
									comments_popup_link('0', '1 Comment', '% Comments', 'post-comments-count');
								}

							 ?>
						</div>

						<?php the_content(); ?>

						<?php if (has_tag()): ?>
							<p class="tag-container"><?php the_tags(); ?></p>
						<?php endif ?>
						<div class="post-navigation">
							<?php wp_link_pages(); ?>
						</div>

						<div class="clear"></div>
					
						<?php if(etheme_get_option('post_share')): ?>
							<div class="row-fluid post-share">
								<div class="span12"><?php echo do_shortcode('[share]'); ?></div>
							</div>
						<?php endif; ?>
						
						<?php if(etheme_get_option('posts_links')): ?>
							<div class="row-fluid post-next-prev">
								<div class="span6"><?php previous_post_link() ?></div>
								<div class="span6 a-right"><?php next_post_link() ?></div>
							</div>
						<?php endif; ?>

					</article>

				<?php endwhile; else: ?>

					<h1><?php _e('No posts were found!', ETHEME_DOMAIN) ?></h1>

				<?php endif; ?>
				
				<?php comments_template('', true); ?>

			</div>

			<?php if($position == 'right' || ($responsive == 'bottom' && $position == 'left')): ?>
				<div class="<?php echo $sidebar_span; ?> sidebar sidebar-right">
					<?php etheme_get_sidebar($sidebarname); ?>
				</div>
			<?php endif; ?>

		</div>

	</div>
</div>
	
<?php
	get_footer();
?>