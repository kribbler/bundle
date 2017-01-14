<?php
/**
 * This file contains HTML generation functions.
 *
 * @author  Pexeto
 */


if ( !function_exists( 'pexeto_build_portfolio_carousel_html' ) ) {

	/**
	 * Generates the portfolio carousel HTML code.
	 *
	 * @param array   $posts containing all the post objects that will be displayed
	 * in the carousel
	 * @param string  $title the title of the carousel
	 * @return string        the generated HTML code of the carousel
	 */
	function pexeto_build_portfolio_carousel_html( $posts, $title ) {
		$columns = 2;
		$i=0;
		$html= '<div class="portfolio-carousel"><div class="pc-header">'
			.'<h4 class="small-title">'.$title.'</h4>'
			.'</div><div class="pc-wrapper"><div class="pc-holder">';
		foreach ( $posts as $post ) {
			$preview = pexeto_get_portfolio_preview_img( $post->ID );
			//open a page wrapper div on each first image of the page/slide
			if ( $i%$columns==0 ) {
				$html.='<div class="pc-page-wrapper">';
			}
			//pexeto_build_portfolio_image_html() is located in lib/functions/portfolio.php
			$html.=pexeto_get_gallery_thumbnail_html( $post, 5, 120, 'pc-item' );
			if ( ( $i+1 )%$columns==0 || $i+1==sizeof( $posts ) ) {
				//close the page wrapper div on the last image
				$html.='</div>';
			}

			$i++;
		}
		$html.='</div></div><div class="clear"></div></div>';
		return $html;
	}
}


if ( !function_exists( 'pexeto_get_share_btns_html' ) ) {

	/**
	 * Generates the sharing buttons HTML code.
	 *
	 * @param int     $post_id      the ID of the post that the buttons will be
	 * added to
	 * @param string  $content_type the type of the containing element - can
	 * be a post, page, portfolio or slider
	 * @return string               the HTML code of the buttons
	 */
	function pexeto_get_share_btns_html( $post_id, $content_type ) {
		if ( !in_array( $content_type, pexeto_option( 'show_share_buttons' ) ) ) {
			return '';
		}
		$display_buttons = pexeto_option( 'share_buttons' );
		$permalink = get_permalink( $post_id );
		$title = get_the_title( $post_id );
		$html = '<div class="social-share"><div class="share-title">'
			.pexeto_text( 'share_text' ).'</div><ul>';

		foreach ( $display_buttons as $btn ) {
			switch ( $btn ) {
			case 'facebook':
				$html.='<li title="Facebook" class="share-item share-fb" data-url="'.$permalink
					.'" data-type="'.$btn.'" data-title="'.$title.'"></li>';
				break;

			case 'googlePlus':
				$html.='<li title="Google+" class="share-item share-gp" data-url="'.$permalink
					.'" data-lang="'.pexeto_option( 'gplus_lang' ).'" data-title="'.$title
					.'" data-type="'.$btn.'"></li>';
				break;

			case 'twitter':
				$html.='<li title="Twitter" class="share-item share-tw" data-url="'.$permalink
					.'" data-title="'.$title.'" data-type="'.$btn.'"></li>';
				break;

			case 'pinterest':
				$img = pexeto_get_portfolio_preview_img( $post_id );
				$img = $img['img'];
				$html.='<li title="Pinterest" class="share-item share-pn" data-url="'.$permalink
					.'" data-title="'.$title.'" data-media="'.$img.'" data-type="'.$btn.'"></li>';
				break;
			}
		}

		$html.='</ul></div><div class="clear"></div>';

		return $html;
	}
}


if ( !function_exists( 'pexeto_get_video_html' ) ) {

	/**
	 * Generates a video HTML. For Flash videos uses the standard flash embed code
	 * and for other videos uses the WordPress embed tag.
	 *
	 * @param string  $video_url the URL of the video
	 * @param string  $width     the width to set to the video
	 */
	function pexeto_get_video_html( $video_url, $width ) {
		$video_html='<div class="video-wrap">';
		//check if it is a swf file
		if ( strstr( $video_url, '.swf' ) ) {
			//print embed code for swf file
			$video_html .= '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
			WIDTH="'.$width.'" id="pexeto-flash" ALIGN=""><PARAM NAME=movie VALUE="'.$video_url.'">
			<PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#333399> <EMBED src="'.$video_url.'"
			quality=high bgcolor=#333399 WIDTH="'.$width.'" NAME="pexeto-flash" ALIGN=""
			TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">
			</EMBED> </OBJECT>';
		}else {
			$video_html .= apply_filters( 'the_content', '[embed width="'.$width.'"]' . $video_url . '[/embed]' );
		}
		$video_html.='</div>';
		return $video_html;
	}
}
