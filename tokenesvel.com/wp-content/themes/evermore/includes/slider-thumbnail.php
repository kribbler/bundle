<?php
/**
 * Prints the Thumbnail slider in header.
 */

global $pexeto_content_sizes, $slider_data, $post, $pexeto_scripts;

//get the default slider size
$width = $pexeto_content_sizes['container'];
$height = pexeto_option('thumb_height');
$height = is_numeric( $height )?intval( $height ):400;
$slider_div_id='thumb-slider-'.$post->ID;
$style = 'style="height:'.$height.'px"';
$windowMargin = 30;
$window_style = 'style="height:'.($height-2*$windowMargin).'px"';

$data_keys = array('image_url', 'description', 'image_link');
	$slider_items=$slider_data['posts'];
?>

<div class="thumb-slider" id="<?php echo $slider_div_id; ?>">

	<!-- SLIDER THUMBNAIL SECTION -->  
	<div class="ts-thumbnail-wrapper">    
		<div class="ts-thumbnail-window" <?php echo $window_style; ?>>
			<div class="ts-thumbnail-container hover">
				<ul>
				<?php foreach( $slider_items as $item){
					$imgurl=get_post_meta($item->ID, PEXETO_CUSTOM_PREFIX.'image_url', true);
				    $path=pexeto_option('thumb_auto_resize')=='true'?pexeto_get_resized_image($imgurl, 90, 60):$imgurl;
				      ?>
					<li>
						<img src="<?php echo $path; ?>" class="img-frame" /><span class="ts-pointer"></span>
					</li>
				<?php }?>
				</ul> 
			</div>
		</div>  
	</div>

	<!-- SLIDER IMAGE SECTION -->  
	<div class="ts-image-container" <?php echo $style; ?>>
		<?php


		foreach ( $slider_items as $item ) {

			$item_data = pexeto_get_multi_meta_values($item->ID, $data_keys, PEXETO_CUSTOM_PREFIX);

			//get the image URL
			$imgurl=$item_data['image_url'];
			if ( pexeto_option( 'thumb_auto_resize' )=='true' ) {
				$imgurl=pexeto_get_resized_image( $imgurl, 850, $height );
			}

			if ( !empty( $item_data['image_link'] ) ) { ?> <a href="<?php echo $item_data['image_link']; ?>"><?php } ?>
				<img src="<?php echo $imgurl; ?>" title="<?php echo htmlspecialchars($item_data['description']); ?>"/>
			<?php if ( !empty( $item_data['image_link'] ) ) { ?> </a> <?php }
		}

		?>

	</div>
	<?php

	//set the slider initialization arguments
	$args = array();
	$args['sliderHeight'] = $height;
	$args['windowMargin'] = $windowMargin;
	$args['parentWidth'] = $width;
	$args['autoplay'] = pexeto_option('thumb_autoplay');
	$args['pauseOnHover'] = pexeto_option('thumb_pause_hover');
	$args['animationInterval'] = intval(pexeto_option('thumb_interval'));

	//add the slider to the scripts to print
	$pexeto_scripts['thumbslider']=array( 'selector'=>'#'.$slider_div_id, 'options'=>$args );

	?>
</div>
