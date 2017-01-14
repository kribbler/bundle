<?php
/**
 * This file contains the main general theme functions.
 * All the functions are pluggable, which means that they can be replaced in a
 * child theme.
 *
 * @author Pexeto
 */


if ( !function_exists( 'pexeto_get_categories' ) ) {
	/**
	 * Gets the post categories.
	 *
	 * @return array containing the categories with keys id containing the category ID and
	 * name containing the category name.
	 */
	function pexeto_get_categories() {
		global $pexeto;

		if ( !isset( $pexeto->categories ) ) {
			$categories=get_categories( 'hide_empty=0' );
			$pexeto_categories=array();
			for ( $i=0; $i<sizeof( $categories ); $i++ ) {
				$pexeto_categories[]=array( 'id'=>$categories[$i]->cat_ID, 'name'=>$categories[$i]->cat_name );
			}
			$pexeto->categories = $pexeto_categories;
		}

		return $pexeto->categories;
	}
}


if ( !function_exists( 'pexeto_option' ) ) {
	/**
	 * Gets an option from the options panel by its key.
	 *
	 * @param string  $option the option ID
	 * @return the option value. If there isn't a value set, returns the default value for the option.
	 */
	function pexeto_option( $option ) {
		global $pexeto;
		$val = $pexeto->options->get_value( $option );
		if ( is_string( $val ) ) {
			$val = stripslashes( $val );
		}
		return $val;
	}
}



if ( !function_exists( 'pexeto_text' ) ) {

	/**
	 * Returns a text depending on the settings set. By default the theme gets uses
	 * the texts set in the Translation section of the Options page. If multiple languages enabled,
	 * the default language texts are used from the Translation section and the additional language
	 * texts are used from the added .mo files within the lang folder.
	 *
	 * @param string  $textid the ID of the text
	 * @return string the value of the text
	 */
	function pexeto_text( $textid ) {

		$locale=get_locale();
		$int_enabled=pexeto_option( 'enable_translation' );
		$default_locale=pexeto_option( 'def_locale' );

		if ( $int_enabled && $locale!=$default_locale ) {
			//use translation - extract the text from a defined .mo file
			return __( $textid, 'pexeto' );
		}else {
			//use the default text settings
			return stripslashes( pexeto_option( $textid ) );
		}
	}
}


if ( !function_exists( 'pexeto_get_resized_image' ) ) {

	/**
	 * Gets the URL for a Timthumb resized image.
	 *
	 * @param string  $imgurl the original image URL
	 * @param string  $width  the width to which the image will be cropped
	 * @param string  $height the height to which the image will be cropped
	 * @param string  align align of the cropping (c=center, t=top, b=bottom, l=left, r=right)
	 * @return string the URL of the image resized with Timthumb
	 */
	function pexeto_get_resized_image( $imgurl, $width, $height, $align='c' ) {
		if ( function_exists( 'get_blogaddress_by_id' ) ) {
			//this is a WordPress Network (multi) site, use the image path (not the URL)
			$imgurl = str_replace(home_url(), '', $imgurl);
		}
		return get_template_directory_uri().'/lib/utils/timthumb.php?src='.
			$imgurl.'&h='.$height.'&w='.$width.'&zc=1&c=1&q=100&a='.$align;
	}
}


if ( !function_exists( 'pexeto_get_featured_image_url' ) ) {

	/**
	 * Gets the URL of the featured image of a post.
	 *
	 * @param int     $pid the ID of the post
	 * @return string the URL of the image
	 */
	function pexeto_get_featured_image_url( $pid ) {
		$attachment = wp_get_attachment_image_src( get_post_thumbnail_id( $pid ), 'single-post-thumbnail' );
		return $attachment[0];
	}
}

if ( !function_exists( 'pexeto_get_content_img_sizes' ) ) {

	/**
	 * Retrieves the size settings for the current page according to
	 * its layout.
	 *
	 * @param array   $pexeto_page array containing the page settings.
	 * 'layout' (referring to  the global page layout) and 'blog_layout' (referring to the single post layout)
	 * keys must be set into this array
	 * @return array contains the following keys:
	 * width : the default image width for the selected layout
	 * height : the default image height for the selected layout
	 * size_id: the default size ID for the selected layout (the registered image size)
	 * layout: the layout that will be used for the images
	 */
	function pexeto_get_content_img_sizes( $pexeto_page ) {
		$res = array();

		$layout = isset( $pexeto_page['blog_layout'] ) ? $pexeto_page['blog_layout'] : $pexeto_page['layout'];

		$size_id =  $layout=='full' ? 'post-box-img-full' : 'post-box-img';
		$img_size_key = 'blog_image_size';
		if ( $layout!='left' && $layout!='right' ) {
			$img_size_key = $layout.'_'.$img_size_key;
		}
		$img_size = pexeto_option( $img_size_key );

		return array(
			'layout' => $layout,
			'size_id' => $size_id,
			'width' => $img_size['width'],
			'height' => $img_size['height']
		);
	}
}


if ( !function_exists( 'pexeto_get_post_attachments' ) ) {

	/**
	 * Retrieves the attachments of a post.
	 *
	 * @param int     $id the ID of the post
	 * @return array     containing the attachments of the posts
	 */
	function pexeto_get_post_attachments( $id ) {
		return get_children( array(
				'order'=> 'ASC',
				'orderby'=>'menu_order',
				'post_parent' => $id,
				'post_type' => 'attachment',
				'post_mime_type' =>'image'
			) );
	}
}


if ( !function_exists( 'pexeto_print_video' ) ) {

	/**
	 * Prints a video. For Flash videos uses the standard flash embed code and for other videos uses
	 * the WordPress embed tag.
	 *
	 * @param string  $video_url the URL of the video
	 * @param string  $width     the width to set to the video
	 */
	function pexeto_print_video( $video_url, $width ) {
		echo pexeto_get_video_html( $video_url, $width );
	}
}


if ( !function_exists( 'pexeto_get_lightbox_options' ) ) {

	/**
	 * Returns all the saved lightbox options in the panel.
	 *
	 * @return array containing all the settings
	 */
	function pexeto_get_lightbox_options() {
		$opt_ids=array( 'theme', 'animation_speed', 'overlay_gallery', 'allow_resize' );
		$res_arr=array();

		foreach ( $opt_ids as $opt_id ) {
			$res_arr[$opt_id]=pexeto_option( $opt_id );
		}

		return $res_arr;
	}
}


if ( !function_exists( 'pexeto_get_nivo_args' ) ) {

	/**
	 * Retrieves the Nivo slider settings depending on where the slider is
	 * inserted (header/content).
	 * @param  string $suffix the suffix for the key options, for slider in the
	 * content the suffix should be set to "content"
	 * @return array         containing all the settings for this slider
	 */
	function pexeto_get_nivo_args( $suffix='' ) {
		//slider navigation
		$exclude_navigation = pexeto_option( 'exclude_nivo_navigation'.$suffix );
		$show_buttons = in_array( 'buttons', $exclude_navigation ) ? false : true;
		$show_arrows = in_array( 'arrows', $exclude_navigation ) ? false : true;
		$autoplay = pexeto_option( 'nivo_autoplay'.$suffix );
		$pause_hover = pexeto_option( 'nivo_pause_hover'.$suffix );

		$args = array(
			'interval'=>intval( pexeto_option( 'nivo_interval'.$suffix ) ),
			'animation'=> implode( ',', pexeto_option( 'nivo_animation'.$suffix ) ),
			'slices'=>intval( pexeto_option( 'nivo_slices'.$suffix ) ),
			'columns'=>intval( pexeto_option( 'nivo_columns'.$suffix ) ),
			'rows'=>intval( pexeto_option( 'nivo_rows'.$suffix ) ),
			'speed'=>intval( pexeto_option( 'nivo_speed'.$suffix ) ),
			'autoplay'=>$autoplay,
			'pauseOnHover'=>$pause_hover,
			'buttons' => $show_buttons,
			'arrows' =>$show_arrows
		);

		return $args;
	}
}

if ( !function_exists( 'pexeto_get_font_options' ) ) {

	/**
	 * Loads all the font options from which the user can select. First adds
	 * the default for the theme font set and then loads the custom Google
	 * fonts that the user has added.
	 * @return array all the font options with keys:
	 * id: the name of the font
	 * name: the name of the font
	 */
	function pexeto_get_font_options() {
		global $pexeto;

		if(isset($pexeto->fonts) && !empty($pexeto->fonts)){
			return $pexeto->fonts;
		}

		$fonts = array(
			array( 'id'=>'default', 'name'=>'Default Theme Font'),
			array( 'id'=>'georgia', 'name'=>'Georgia, serif' ),
			array( 'id'=>'palationo', 'name'=>'Palatino Linotype, Book Antiqua, Palatino, serif' ),
			array( 'id'=>'timesnewroman', 'name'=>'Times New Roman, Times, serif' ),
			array( 'id'=>'arial', 'name'=>'Arial, Helvetica, sans-serif' ),
			array( 'id'=>'arialblack', 'name'=>'Arial Black, Gadget, sans-serif' ),
			array( 'id'=>'comicsansms', 'name'=>'Comic Sans MS, cursive, sans-serif' ),
			array( 'id'=>'impact', 'name'=>'Impact, Charcoal, sans-serif' ),
			array( 'id'=>'lucida', 'name'=>'Lucida Sans Unicode, Lucida Grande, sans-serif' ),
			array( 'id'=>'tahoma', 'name'=>'Tahoma, Geneva, sans-serif' ),
			array( 'id'=>'trebutchet', 'name'=>'Trebuchet MS, Helvetica, sans-serif' ),
			array( 'id'=>'verdana', 'name'=>'Verdana, Geneva, sans-serif' ),
			array( 'id'=>'couriernew', 'name'=>'Courier New, Courier, monospace' ),
			array( 'id'=>'lucidaconsole', 'name'=>'Lucida Console, Monaco, monospace' )
			);

		$google_fonts = pexeto_option( 'google_fonts' );

		if ( !empty( $google_fonts ) ) {
			foreach ( $google_fonts as $font ) {
				$fonts[] = array( 'id'=> str_replace('"', '', $font['link']), 'name'=>stripslashes($font['name']));
			}
		}

		$pexeto->fonts = $fonts;

		return $fonts;

	}
}

if(!function_exists('pexeto_get_font_name_by_key')){

	/**
	 * Retrieves a font name from by its key from the registered fonts.
	 * @param  string $key the key of the font
	 * @return string      the name of the font if it exists or null if it
	 * doesn't exist within the included fonts.
	 */
	function pexeto_get_font_name_by_key($key){
		$fonts = pexeto_get_font_options();

		foreach ($fonts as $font) {
			if($font['id']==$key){
				return $font['name'];
			}
		}

		return null;
	}
}

if ( !function_exists( 'pexeto_get_slider_type' ) ) {

	/**
	 * Retrieves the selected slider type for the current page.
	 * @return string the type of the slider. Will return null if a slider
	 * has not been selected for the current page.
	 */
	function pexeto_get_slider_type() {
		global $post;
		$slider_type = null;

		if ( !empty( $post ) ) {
			$page_settings = pexeto_get_post_meta( $post->ID, array( 'slider', 'blog_layout' ) );
			if ( !empty( $page_settings['slider'] ) ) {
				$slider = PexetoCustomPageHelper::get_slider_data_parts( $page_settings['slider'] );
				$slider_type = $slider[0];
			}
		}

		return $slider_type;
	}
}


if ( !function_exists( 'pexeto_contains_posts' ) ) {

	/**
	 * Checks whether the current page contains post.
	 * @return boolean true if it contains posts - these are the blog page,
	 * archive pages, search results page and blog page template, and will
	 * return false in all other cases.
	 */
	function pexeto_contains_posts() {
		if ( is_page_template( 'template-blog.php' ) || is_home() 
			|| is_archive() || is_search() ) {
			return true;
		}else {
			return false;
		}
	}
}
