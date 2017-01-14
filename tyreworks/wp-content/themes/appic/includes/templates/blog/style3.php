<section class="container blog-style3-wrap">
	<div id="blog">
		<?php while (have_posts()) : the_post(); ?>
		<?php $x = rand(0, 2)?>
		<?php if ($x == 1) { ?> 
		<div id="post-<?php the_ID(); ?>" <?php post_class('item-blog-style block-height-1 block-width-2'); ?>>
			<div class="blog-styly-block">
				<?php if (has_post_thumbnail()) : ?>
					<?php
						$width = 470;
						$height = 340;
						$thumb = get_the_post_thumbnail($post->ID);
						if(empty($thumb)){
							$thumbUrl = "http://placehold.it/".$width."x".$height;
						}else{
							$imgUrl = wp_get_attachment_url(get_post_thumbnail_id(), 'full'); //get img URL
							$thumbUrl = aq_resize($imgUrl, 470, 340, true ); //resize & crop img
						}
					?>
					<img src="<?php echo $thumbUrl; ?>" class="pull-left" />
				<?php endif; ?>
				<div class="block-content clearfix">
					<h3 class="page-elements-title text-right"><?php the_time('F j, Y'); ?></h3>
					<h2 class="font-style-20  text-right"><?php the_title(); ?></h2>
					<div class="clearfix"></div>
					<div class="simple-text-12"><?php the_content(''); ?></div>
				</div>
				<a href="<?php the_permalink(); ?>" class="link-icon-arrow"></a>
			</div>
		</div>
		<?php } elseif ($x == 2) { ?>
		<div id="post-<?php the_ID(); ?>" class="item-blog-style block-height-2 block-width-1">
			<div class="blog-styly-block">
				<?php if (has_post_thumbnail()) : ?>
					<?php
						$width = 370;
						$height = 340;
						$thumb = get_the_post_thumbnail($post->ID);
						if(empty($thumb)){
							$thumbUrl = "http://placehold.it/".$width."x".$height;
						}else{
							$imgUrl = wp_get_attachment_url(get_post_thumbnail_id(), 'full'); //get img URL
							$thumbUrl = aq_resize($imgUrl, $width, $height, true ); //resize & crop img
						}
					?>
					<img src="<?php echo $thumbUrl; ?>" class="blog-image-wrap" />
				<?php endif; ?>
				<div class="block-content clearfix">
					<h3 class="page-elements-title text-right"><?php the_time('F j, Y'); ?></h3>
					<h2 class="font-style-20 text-right"><?php the_title(); ?></h2>
					<div class="clearfix"></div>
					<div class="simple-text-12"><?php the_content(''); ?></div>
				</div>
				<a href="<?php the_permalink(); ?>" class="link-icon-arrow"></a>
			</div>
		</div>
		<?php } elseif ($x == 0) { ?>
		<div id="post-<?php the_ID(); ?>" class="item-blog-style block-height-1 block-width-1">
			<div class="blog-styly-block">
				<?php if (has_post_thumbnail()) : ?>
					<?php
						$width = 370;
						$height = 200;
						$thumb = get_the_post_thumbnail($post->ID);
						if(empty($thumb)){
							$thumbUrl = "http://placehold.it/".$width."x".$height;
						}else{
							$imgUrl = wp_get_attachment_url(get_post_thumbnail_id(), 'full'); //get img URL
							$thumbUrl = aq_resize($imgUrl, $width, $height, true ); //resize & crop img
						}
					?>
					<img src="<?php echo $thumbUrl; ?>" class="blog-image-wrap" />
				<?php endif; ?>
				<div class="block-content clearfix">
					<h3 class="page-elements-title text-right"><?php the_time('F j, Y'); ?></h3>
					<h2 class="font-style-20 text-right"><?php the_title(); ?></h2>
					<div class="clearfix"></div>
					<div class="simple-text-12"><?php the_content(''); ?></div>
				</div>
				<a href="<?php the_permalink(); ?>" class="link-icon-arrow"></a>
			</div>
		</div>
		<?php } ?>
		<?php endwhile; ?>
	</div>
	<?php echo appic_posts_navigation(); ?>
</section>

<?php
wp_enqueue_script('masonry');
JsClientScript::addScript('initBlogMasonryBlocks',
	'$("#blog").masonry({' .
		'columnWidth: blog.querySelector(".block-width-1"),' .
		'itemSelector: ".item-blog-style",' .
		'gutter: 30' .
	'});'
);
