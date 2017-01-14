<?php
/**
 * Single blog post template.
 */

global $pexeto_page;
$format = get_post_format();
$add_post_class = is_single() ? 'blog-single-post' : 'blog-non-single-post';
?>
<div id="post-<?php the_ID(); ?>" <?php post_class( $add_post_class ); ?>>

<?php

if ( $format == 'quote' ) {
	//QUOTE POST FORMAT
?>
	<span class="post-type-icon-wrap"><span class="post-type-icon"></span></span>
	<blockquote><?php the_content(); ?></blockquote>
	<?php
}elseif ( $format == 'aside' ) {
	//ASIDE POST FORMAT
?>
	<span class="post-type-icon-wrap"><span class="post-type-icon"></span></span>
	<aside><?php the_content(); ?></aside>
	<?php
}else {
	//ALL OTHER POST FORMATS
	$hide_thumbnail=( isset( $pexeto_page["hide_thumbnail"] )&&$pexeto_page["hide_thumbnail"] )?true:false;
	$thumb_class='';
	if ( !has_post_thumbnail() || $hide_thumbnail ) {
		$thumb_class=' no-thumbnail';
	}
?>

<?php
	//PRINT HEADER OF POST DEPENDING ON ITS FORMAT

	if ( $format == 'gallery' ) {
		//PRINT A GALLERY
		locate_template( array( 'includes/slider-nivo-content.php' ), true, false );
	}elseif ( $format == 'video'  ) {
?>
			<div class="post-video-wrapper">
				<div class="post-video">
					<?php
						$video_url = pexeto_get_single_meta( $post->ID, 'video' );
						$img_size = pexeto_get_content_img_sizes( $pexeto_page );
						if ( $video_url ) {
							pexeto_print_video( $video_url, $img_size['width'] );
						}
					?>
				</div>
			</div>
			<?php
	}else {
		//PRINT AN IMAGE
		if ( has_post_thumbnail() && !$hide_thumbnail ) {
			$img_size = pexeto_get_content_img_sizes( $pexeto_page );?>
				<div class="blog-post-img img-loading" style="min-width:<?php echo $img_size['width']; ?>px; min-height:<?php echo $img_size['height'] ?>px;">
					<?php if ( !is_single() ) {?><a href="<?php the_permalink(); ?>"><?php }

					if ( in_array( $img_size['layout'], array( 'left', 'right', 'full' ) ) 
						|| pexeto_option( 'blog_auto_resize' )===false ) {
						the_post_thumbnail( $img_size['size_id'] );
					}else {
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
						?><img src="<?php echo pexeto_get_resized_image( $thumb[0], $img_size['width'], $img_size['height'] ); ?>" /><?php
					}

					if ( !is_single() ) { ?></a><?php } ?>
				</div>
				<?php
		}
	}
?>
<div class="post-content<?php echo $thumb_class; ?>">
	<div class="post-title-wrapper">
		<h2 class="post-title">
		<?php if ( !is_single() ) { ?>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		<?php }else {
	the_title();
			} ?>
		</h2>

	</div>
	<div class="clear"></div>

	<div class="post-content-content">

	<?php
	//PRINT THE CONTENT
	$excerpt=( isset( $pexeto_page['excerpt'] ) && $pexeto_page['excerpt'] ) ? true : false;
	if ( !$excerpt && pexeto_option( 'post_summary' )!='excerpt' || is_single() ) {
		the_content( '' ); ?>
		<div class="clear"></div>
		<?php
		if ( !is_single() ) {
			$ismore = @strpos( $post->post_content, '<!--more-->' );
			if ( $ismore ) {?> <a href="<?php the_permalink(); ?>" class="read-more"><?php echo pexeto_text( 'read_more' ); ?><span class="more-arrow">&raquo;</span></a>
			<?php
			}
		} else {
			wp_link_pages();
		}
	}else {
		the_excerpt(); ?>

		<a href="<?php the_permalink(); ?>" class="read-more">
			<?php echo pexeto_text( 'read_more' ); ?>
			<span class="more-arrow">&raquo;</span>
		</a>
		<?php
	}?>
		<div class="clear"></div>
	</div>
</div>
<?php

//PRINT POST INFO

$hide_sections=pexeto_option( 'exclude_post_sections' );

if ( sizeof( $hide_sections )!=4 ) {
?>

	<div class="post-info">
		<span class="post-type-icon-wrap"><span class="post-type-icon"></span></span>
		<?php
		//PRINT THE POST INFO (CATEGORY, AUTHOR, DATE AND COMMENTS)
		if ( !in_array( 'category', $hide_sections ) && get_the_category( $post->ID ) ) {?>
			<span class="no-caps"> 
				<?php echo pexeto_text( 'in_text' ); ?>
			</span><?php the_category( ' / ' );?>
		<?php }

		if ( !in_array( 'author', $hide_sections ) ) {?>
			<span class="no-caps post-autor">
				&nbsp;<?php echo pexeto_text( 'by_text' ); ?>  <?php the_author_posts_link(); ?>
			</span>
		<?php }

		if ( !in_array( 'date', $hide_sections ) ) { ?>
			<span class="post-date">
				<?php echo get_the_date( 'd M Y' ); ?>
			</span>
		<?php }

		if ( !in_array( 'comments', $hide_sections ) ) {?>
			<span class="comments-number">
				/
				<a href="<?php the_permalink();?>#comments">
					<?php comments_number( '0', '1', '%' ); ?>
				</a><span class="no-caps"><?php echo pexeto_text( 'comments_text' ); ?></span>
			</span>
		<?php } ?>
	</div>

	<?php
	//PRINT SHARING
	if ( is_single() ) {
		echo pexeto_get_share_btns_html( $post->ID, 'post' );
	}

	// PRINT POST TAGS
	if ( is_single() ) {
		the_tags( '<span class="post-tags"><span class="post-tag-title">'.pexeto_text( 'post_tags' ).'</span>', '', '</span>' );
	} ?>

<?php } //end if
} ?>
<div class="clear"></div>
</div>
