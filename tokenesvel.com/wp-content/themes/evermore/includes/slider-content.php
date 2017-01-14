<?php
/**
 * Prints the Content slider in header.
 */

global $slider_data, $post, $pexeto_scripts, $pexeto_content_sizes;

$img_width = $pexeto_content_sizes['twocolumn'];
$slider_height = pexeto_option('content_slider_height');
$slider_div_id='content-slider-'.$post->ID;
//get the slider items(posts)
$slider_items=$slider_data['posts']; ?>

<div class="content-slider cols-wrapper cols-2" id="<?php echo $slider_div_id; ?>" >
	<ul id="cs-slider-ul" style="min-height:<?php echo $slider_height; ?>px;">
		<?php

		//set the meta key values for each item that will be retrieved
		$data_keys = array('image_url', 'main_title', 'small_title', 'description', 'but_one_text', 'but_one_link', 'but_two_text', 'but_two_link');

		foreach ( $slider_items as $item ) {

			//get the meta values for the current item
			$item_data = pexeto_get_multi_meta_values($item->ID, $data_keys, PEXETO_CUSTOM_PREFIX);	

			//get the image URL
			$imgurl=$item_data['image_url'];
			if ( pexeto_option( 'content_auto_resize' )=='true' ) {
				$imgurl=pexeto_get_resized_image( $imgurl, $img_width , pexeto_option( 'content_img_height' ) );
			}


			?>

			<li>
				<!-- first slider box -->
				<div class="cs-content-left col">
					<?php if ( !empty( $item_data['small_title'] ) ){ 
							//display the small title
						 	?><p class="cs-small-title"><?php echo $item_data['small_title']; ?></p>

					<?php } if ( !empty( $item_data['main_title'] ) ) { 
							//display the main title
							?> <h1 class="cs-title"><?php echo $item_data['main_title']; ?></h1>

					<?php } if ( !empty( $item_data['description'] ) ) {
							//display the description text
							?><p><?php echo $item_data['description']; ?></p>
							<p class="clear"></p>
					
					<?php } if ( !empty( $item_data['but_one_text'] ) && !empty( $item_data['but_one_link'] ) ) {
							//display the first button
							?><a href="<?php echo $item_data['but_one_link']; ?>" class="button"><?php echo $item_data['but_one_text']; ?></a>

					<?php } if ( !empty( $item_data['but_two_text'] ) && !empty( $item_data['but_two_link'] ) ) {  
							//display the second button
							?><a href="<?php echo $item_data['but_two_link']; ?>" class="button btn-alt"><?php echo $item_data['but_two_text']; ?></a>
					<?php } ?>
				</div>
				<!-- second slider box -->
				<div class="cs-content-right col nomargin">
					<img src="<?php echo $imgurl; ?>" />
				</div>
			</li><?php

			
		}

		//set the slider initialization arguments
		$args = array();
		$args['autoplay'] = pexeto_option('content_autoplay');
		$args['pauseOnHover'] = pexeto_option('content_pause_hover');
		$args['animationSpeed'] = intval(pexeto_option('content_speed'));
		$args['animationInterval'] = intval(pexeto_option('content_interval'));

		$exclude_navigation = pexeto_option('exclude_content_navigation');
		$args['buttons'] = in_array('buttons', $exclude_navigation) ? false : true;
		$args['arrows'] = in_array('arrows', $exclude_navigation) ? false : true;

		//add the slider to the scripts to print
		$pexeto_scripts['contentslider']=array( 'selector'=>'#'.$slider_div_id, 'options'=>$args );

		?>
	</ul>
</div>
