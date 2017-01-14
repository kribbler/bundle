<?php get_header(); ?>

<div class="white-wrap container">
	<section class="blog-style-wrap">
		<div class="row">
			<div class="span8">
			<?php if(have_posts()) : ?>
				<?php while(have_posts()) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('single-post-wrap');?>>
						<h1 class="post-title-h1"><?php the_title(); ?></h1>
						<div class="image-figure">
							<?php echo theme_get_the_post_thumbnail(null, 'full', array('class' => 'grey-border'), array(770, 514)); ?>
							<div class="image-capture">
								<ul class="inline simple-text-12">
									<li><?php echo __('Date: ', 'appic'); ?><span class="light-grey-text"><?php the_date("M d, Y"); ?></span></li>
									<li><?php echo __('Author: ', 'appic'); ?><?php the_author_posts_link(); ?></li>
									<li><?php echo __('Comments: ', 'appic'); ?><span class="light-grey-text"><?php comments_number(__("no comments", "appic"), 1, "%"); ?></span></li>
									<?php
										if(has_tag()){
											echo '<li>' . __('Tags: ', 'appic');
												the_tags('', ', ', '');
											echo'</li>';
										}
										if( $categories = get_the_category_list(', ') ){
											echo '<li>' . __('Categories: ', 'appic') . $categories . '</li>';
										}
									?>
								</ul>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="simple-text-14"><?php the_content(); ?></div>
					</article>

					<?php appic_post_pagination(); ?>

					<?php if (get_theme_option('post_social_sharing')) { ?>
					<div class="post-share">
						<span class="page-elements-title dark-grey-text pull-left"><?php echo __('Share', 'appic'); ?>:</span>
						<?php get_template_part('includes/templates/share-buttons'); ?>
					</div>
					<?php } ?>
					<?php $user_data = get_userdata($authordata->ID); ?>
					<section class="post-author">
						<div class="client-photo-wrap pull-left">
							<figure class="client-photo">
								<?php echo get_avatar( $user_data->nickname, "", "", "client-photo-1"); ?>
								<figcaption>
								<?php
									if( !empty($user_data->first_name) &&  !empty($user_data->last_name) ){
										echo $user_data->first_name." ".$user_data->last_name;
									}else{
										echo $user_data->nickname;
									}
								?>
								</figcaption>
							</figure>
						</div>
						<div class="about-author-wrap">
							<div class="about-author">
								<h4 class="simple-text-14 bold upper"><?php echo __('About author', 'appic'); ?></h4>
								<p class="simple-text-14"><?php echo $user_data->description; ?></p>
							</div>
						</div>
					</section>
					<section class="comments-list-wrap">
						<?php comments_template(); ?>
					</section>

				<?php endwhile; ?>
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