<?php
/**
 * Prints the Nivo slider in header.
 */

global $pexeto_content_sizes, $slider_data, $post, $pexeto_scripts;

//get the default slider size
$width = $pexeto_content_sizes['container'];
$height = pexeto_option( 'nivo_height' );
$height = is_numeric( $height )?intval( $height ):400;
$slider_div_id='nivo-slider-'.$post->ID;
?>

<div class="nivo-slider" id="<?php echo $slider_div_id; ?>" style="min-height:<?php echo $height; ?>px;">
	<?php

	$data_keys = array('image_url', 'description', 'image_link');
	$slider_items=$slider_data['posts'];

	foreach ( $slider_items as $key=>$item ) {

		$item_data = pexeto_get_multi_meta_values($item->ID, $data_keys, PEXETO_CUSTOM_PREFIX);

		//get the image URL
		$imgurl=$item_data['image_url'];
		if ( pexeto_option( 'nivo_auto_resize' )=='true' ) {
			$imgurl=pexeto_get_resized_image( $imgurl, $width, $height );
		}

		if ( !empty( $item_data['image_link'] ) ) { ?> <a href="<?php echo $item_data['image_link']; ?>"><?php } ?>
		<img src="<?php echo $imgurl; ?>" title="<?php echo $item_data['description']; ?>"/>
		<?php if ( !empty( $item_data['image_link'] ) ) { ?> </a> <?php }
	}

	$args = pexeto_get_nivo_args();
	//add the Nivo slider to the scripts to print
	if ( !isset( $pexeto_scripts['nivo'] ) ) {
		$pexeto_scripts['nivo'] = array();
	}
	$pexeto_scripts['nivo'][]=array( 'selector'=>'#'.$slider_div_id, 'options'=>$args );

	?>
</div>
