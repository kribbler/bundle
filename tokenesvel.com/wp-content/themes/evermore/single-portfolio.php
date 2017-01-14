<?php
/**
 * Single Portfolio Template - This is the template for the single portfolio item content.
 */
get_header();

if(have_posts()){
	while(have_posts()){
		the_post();
		//get all the page data needed and set it to an object that can be used in other files
		$pexeto_page=pexeto_get_post_meta($post->ID, array('type'), PEXETO_PORTFOLIO_POST_TYPE);
		$pexeto_page['layout']=pexeto_option('portfolio_layout');
		$pexeto_page['sidebar']=pexeto_option('portfolio_sidebar');
		$pexeto_page['show_title']=pexeto_option('portfolio_show_title');
		$single_slider=false;
		$video = false;
		if(in_array($pexeto_page['type'], array('smallslider','fullslider','smallvideo','fullvideo'))){
			$pexeto_page['layout']='full';
			// $pexeto_page['portfolio_slider']=true;
			$single_slider=true;

			if($pexeto_page['type']=='fullvideo' || $pexeto_page['type']=='smallvideo'){
				$video=true;
			}
		}
		
		//include the before content template
		locate_template( array( 'includes/html-before-content.php'), true, true ); 
		

		if(!$single_slider){
			//PRINT A STANDARD LAYOUT PAGE WITH CONTENT
			
			locate_template( array( 'includes/page-title.php' ), true, true );

			if($pexeto_page['type']=='standard' || $pexeto_page['type']=='custom'){ 
				//PRINT the FEATURED IMAGE
				$custom_link = pexeto_get_single_meta($post->ID, 'custom_link');
				$link = ($pexeto_page['type']=='custom' && $custom_link) ? $custom_link : null;
				$img_id=$pexeto_page['layout']=='full'?'post-box-img-full':'post-box-img';
				if($link){
					?><a href="<?php echo $link; ?>"><?php
				}
				the_post_thumbnail($img_id);
				if($link){
					?></a><?php
				}
				?>
			<?php }

			the_content();

			//print sharing
			echo pexeto_get_share_btns_html($post->ID, 'portfolio');
			
			if(pexeto_option('portfolio_comments')=='on'){  
				comments_template();  
			} 
		}else{
			//PRINT A PORTFOLIO ITEM SLIDER
			?>
			<div id="portfolio-slider">
			<?php 
				echo pexeto_get_portfolio_slider_item_html($post->ID, true); 
				echo pexeto_get_portfolio_carousel_html($post->ID);
			?>
			</div>
			<?php
			//set the initialization scripts
			global $pexeto_scripts;
			$scr_args = array(
					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
					'singleItem' => true,
					'video' => $video,
					'itemId' => $post->ID,
					'enableAJAX' => pexeto_option('portfolio_ajax')
				);
			$pexeto_scripts['portfolio-gallery'] = array('selector'=>'#portfolio-slider', 'options'=>$scr_args);
	
		}
		
		

	}
}

	 
//include the after content template
locate_template( array( 'includes/html-after-content.php'), true, true );

get_footer();
?>

