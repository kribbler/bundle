<?php
/**
 * This file contains the main Media settings for the theme.
 */

global $pexeto;

$pexeto_pages_options= array( array(
		'name' => 'Media Settings',
		'type' => 'title',
		'img' => 'icon-media'
	),

	array(
		'type' => 'open',
		'subtitles'=>array(
			array( 'id'=>'img_size', 'name'=>'Image Size' ),
			array( 'id'=>'lightbox', 'name'=>'Lightbox' ),
			array( 'id'=>'quick_gallery', 'name'=>'Quick Gallery' )
		)
	),

	/* ------------------------------------------------------------------------*
	 * MEDIA
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'img_size'
	),

	array(
		'type' => 'multioption',
		'id' => 'blog_image_size',
		'name' => 'Blog standard layout image size in pixels',
		'fields' => array(
			array(
				'id' => 'width',
				'name' => 'Width',
				'type' => 'text',
				'std' => $pexeto_content_sizes['content']
			),
			array(
				'id' => 'height',
				'name' => 'Height',
				'type' => 'text',
				'std' => '350'
			),
		),
		'desc' => 'This is the size of the image in blog and posts pages in a 
			left or right sidebar layout. <br/>
			<strong>Important:</strong> Please keep in mind that WordPress crops the images
			to the predefined sizes during upload, so if you change the default sizes, 
			you have to reupload the images. If you already have lots of images, 
			you can use the Regenerate Thumbnails plugin instead:<br/>
			http://wordpress.org/extend/plugins/regenerate-thumbnails'
	),

	array(
		'type' => 'multioption',
		'id' => 'full_blog_image_size',
		'name' => 'Blog full-width layout image size in pixels',
		'fields' => array(
			array(
				'id' => 'width',
				'name' => 'Width',
				'type' => 'text',
				'std' => $pexeto_content_sizes['fullwidth']
			),
			array(
				'id' => 'height',
				'name' => 'Height',
				'type' => 'text',
				'std' => '400'
			),
		),
		'desc' => 'This is the size of the image in blog and posts pages in a 
		full-width layout. <br/>
		<strong>Important:</strong> Please keep in mind that WordPress crops the images
		to the predefined sizes during upload, so if you change the default sizes, 
		you have to reupload the images. If you already have lots of images, you can use the
		Regenerate Thumbnails plugin instead:<br/>
		http://wordpress.org/extend/plugins/regenerate-thumbnails'
	),

	array(
		'type' => 'multioption',
		'id' => 'twocolumn_blog_image_size',
		'name' => 'Two columns layout image size in pixels',
		'fields' => array(
			array(
				'id' => 'width',
				'name' => 'Width',
				'type' => 'text',
				'std' => $pexeto_content_sizes['twocolumn']
			),
			array(
				'id' => 'height',
				'name' => 'Height',
				'type' => 'text',
				'std' => '270'
			),
		),
		'desc' => 'This is the size of the image in a blog two-column layout page.'
	),

	array(
		'type' => 'multioption',
		'id' => 'threecolumn_blog_image_size',
		'name' => 'Three columns layout image size in pixels',
		'fields' => array(
			array(
				'id' => 'width',
				'name' => 'Width',
				'type' => 'text',
				'std' => $pexeto_content_sizes['threecolumn']
			),
			array(
				'id' => 'height',
				'name' => 'Height',
				'type' => 'text',
				'std' => '180'
			),
		),
		'desc' => 'This is the size of the image in a blog three-column layout page. <br/>'
	),


	array(
		'name' => 'Automatic image resizing in multi-column blog layout',
		'id' => 'blog_auto_resize',
		'type' => 'checkbox',
		'std' => true,
		'desc' => 'If enabled, the images will be automatically resized using 
			Timthumb in a two and three column blog layout to the exact size
			set in the relevant size section above. It is recommended to leave 
			this option enabled.' ),





	array(
		'type' => 'close' ),


	/* ------------------------------------------------------------------------*
	 * LIGHTBOX
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'lightbox'
	),

	array(
		'name' => 'Lightbox Theme',
		'id' => 'theme',
		'type' => 'select',
		'options' => array( array( 'id'=>'light_rounded', 'name'=>'Light Rounded' ),
			array( 'id'=>'dark_rounded', 'name'=>'Dark Rounded' ),
			array( 'id'=>'pp_default', 'name'=>'Default' ),
			array( 'id'=>'facebook', 'name'=>'Facebook' ),
			array( 'id'=>'light_square', 'name'=>'Light Square' ),
			array( 'id'=>'dark_square', 'name'=>'Dark Square' ) ),

		'std' => 'pp_default',
		'desc' => 'This is the global theme setting for the PrettyPhoto lightbox.'
	),

	array(
		'name' => 'Animation Speed',
		'id' => 'animation_speed',
		'type' => 'select',
		'options' => array( array( 'id'=>'normal', 'name'=>'Normal' ),
			array( 'id'=>'fast', 'name'=>'Fast' ),
			array( 'id'=>'slow', 'name'=>'Slow' ) ),
		'std' => 'normal'
	),

	array(
		'name' => 'Overlay Gallery',
		'id' => 'overlay_gallery',
		'type' => 'checkbox',
		'std' => false,
		'desc' => 'If enabled, on lightbox galleries a small gallery of 
			thumbnails will be displayed in the bottom of the preview image.' ),

	array(
		'name' => 'Resize image to fit window',
		'id' => 'allow_resize',
		'type' => 'checkbox',
		'std' => true,
		'desc' => 'If enabled, when the image is bigger than the window, it will 
			be resized to fit it. Otherwise, the image will be displayed in its 
			full size.' ),

	array(
		'type' => 'close' ),

	/* ------------------------------------------------------------------------*
	 * QUICK GALLERY
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'quick_gallery'
	),

	array(
		'type' => 'documentation',
		'text' => '<h3>Quick Gallery in Pages</h3>'
	),

	array(
		'name' => 'Thumbnail image height',
		'id' => 'qg_thumbnail_height_page',
		'type' => 'text',
		'std' => 200,
		'desc' => 'If the masonry layout option is enabled below, the height
				will be automatically calculated according to the image ratio'
	),

	array(
		'name' => 'Masonry layout',
		'id' => 'qg_masonry_page',
		'type' => 'checkbox',
		'std' =>  false
	),

	array(
		'type' => 'documentation',
		'text' => '<h3>Quick Gallery in Blog Posts</h3>'
	),

	array(
		'name' => 'Thumbnail image height',
		'id' => 'qg_thumbnail_height_post',
		'type' => 'text',
		'std' => 200,
		'desc' => 'If the masonry layout option is enabled below, the height
				will be automatically calculated according to the image ratio'
	),

	array(
		'name' => 'Masonry layout',
		'id' => 'qg_masonry_post',
		'type' => 'checkbox',
		'std' =>  false
	),

	array(
		'type' => 'documentation',
		'text' => '<h3>Quick Gallery in Portfolio Posts</h3>'
	),

	array(
		'name' => 'Thumbnail image height',
		'id' => 'qg_thumbnail_height_'.PEXETO_PORTFOLIO_POST_TYPE,
		'type' => 'text',
		'std' => 200,
		'desc' => 'If the masonry layout option is enabled below, the height
				will be automatically calculated according to the image ratio'
	),

	array(
		'name' => 'Masonry layout',
		'id' => 'qg_masonry_'.PEXETO_PORTFOLIO_POST_TYPE,
		'type' => 'checkbox',
		'std' =>  false
	),

	array(
		'type' => 'close' ),


	array(
		'type' => 'close' ) );

$pexeto->options->add_option_set( $pexeto_pages_options );
