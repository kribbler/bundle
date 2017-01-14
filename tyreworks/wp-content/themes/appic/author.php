<?php get_header(); ?>

<?php
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));

$display_name = $curauth->display_name ? $curauth->display_name : $curauth->nickname;
?>
<div class="white-wrap">
	<section class="container blog-style-wrap">
		<div class="row">
			<aside class="span4 pull-right">
				<div class="aside-wrap">
					<div class="author-post-photo-wrap border-triangle">
						<div class="author-page-photo-wrap">
							<?php echo get_avatar($curauth->ID); ?>
							<div class="holder-author-photo"></div>
						</div>
					</div>
					<div class="clearfix"></div>
					<h2 class="author-page"><?php echo $display_name; ?></h2>
					<?php if ( ! empty($curauth->user_url) ) { ?>
						<div class="author-additional-info">
							<a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a>
						</div>
					<?php } ?>
					<?php if ( ! empty($curauth->user_description) ) { ?>
						<div class="author-description"><?php echo $curauth->user_description; ?></div>
					<?php } ?>
				</div>
			</aside>
			<div class="span8">
			<?php if (have_posts()) : ?>
				<?php get_template_part('loop'); ?>
			<?php endif;?>
			</div>
		</div>
	</section>
</div>

<?php get_footer(); ?>