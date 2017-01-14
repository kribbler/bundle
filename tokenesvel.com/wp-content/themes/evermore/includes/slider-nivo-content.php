<?php
/**
 * Nivo slider in the content of a post/page template.
 */
global $pexeto_page, $post, $pexeto_scripts;

$img_size = pexeto_get_content_img_sizes($pexeto_page);
$autoresizing = pexeto_option('nivo_auto_resize_content');

?>
<div class="post-gallery">
	<div class="nivo-slider" id="post-gallery-<?php the_ID(); ?>" 
		style="height:<?php echo $img_size['height']; ?>px;">
		<?php
		//print the attachment images
		$attachments = pexeto_get_post_attachments( $post->ID );
		$images = array();

		foreach ( $attachments as $attachment ) {
			if(in_array($img_size['layout'], array('left', 'right', 'full'))){
				$img =  wp_get_attachment_image_src($attachment->ID, $img_size['size_id']);
				$preview = $img[0];
			}else {
				$preview = $autoresizing ? pexeto_get_resized_image( $attachment->guid, $img_size['width'], $img_size['height'], 'c' ) : $attachment->guid;
			}

		?>
		<img src="<?php echo $preview; ?>" title="<?php echo $attachment->post_content; ?>"/>
		<?php } 

		//add the Nivo slider to the scripts to print
		if(!isset($pexeto_scripts['nivo'])){
			$pexeto_scripts['nivo'] = array();
		}

		//slider navigation
		$args = pexeto_get_nivo_args('_content');
		$pexeto_scripts['nivo'][]=array('selector'=>'#post-gallery-'.$post->ID, 'options'=>$args);
		?>
	</div>
</div>
