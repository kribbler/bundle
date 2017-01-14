<?php
/**
 * This file contains the main general settings for the theme.
 */

$sociable_icons=array( 'facebook.png', 'twitter.png', 'googleplus.png', 'rss.png', 
	'pinterest.png', 'flickr.png', 'delicious.png', 'skype.png', 'youtube.png', 
	'vimeo.png', 'blogger.png', 'linkedin.png', 'myspace.png', 'reddit.png', 
	'dribbble.png', 'forrst.png', 'deviant-art.png', 'digg.png', 'github.png', 
	'lastfm.png', 'sharethis.png', 'stumbleupon.png', 'tumblr.png', 'wordpress.png', 
	'yahoo.png', 'amazon.png', 'apple.png', 'bing.png' );
foreach ( $sociable_icons as $key=>$value ) {
	$sociable_icons[$key]=PEXETO_FRONT_IMAGES_URL.'icons/'.$value;
}

global $pexeto_content_sizes;

$pexeto_general_options= array( array(
		'name' => 'General Settings',
		'type' => 'title',
		'img' => 'icon-settings'
	),

	array(
		'type' => 'open',
		'subtitles'=>array(
			array( 'id'=>'main', 'name'=>'Main' ),
			array( 'id'=>'footer', 'name'=>'Footer' ),
			array( 'id'=>'sidebar', 'name'=>'Sidebars' ),
			array( 'id'=>'update', 'name'=>'Theme Update' ),
			array( 'id'=>'social', 'name'=>'Social' ),
			array( 'id'=>'seo', 'name'=>'SEO' ),
			array( 'id'=>'contact', 'name'=>'Contact Form' )
		)
	),

	/* ------------------------------------------------------------------------*
	 * MAIN SETTINGS
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'main'
	),

	array(
		'type' => 'documentation',
		'text' => '<h3>Logo</h3>'
	),


	array(
		'name' => 'Logo image',
		'id' => 'logo_image',
		'type' => 'upload'
	),

	array(
		'name' => 'Retina display logo image',
		'id' => 'retina_logo_image',
		'type' => 'upload',
		'desc' => 'You can set a custom logo image for retina displays. 
		The image size for retina displays should be twice the size of the 
		regular logo - for example if the standard logo image size is 30x70 pixels, 
		the size of the retina display logo image should be 60x140 pixels. 
		If you don\'t set an image in this field, the image set in 
		the \'Logo Image\' field above will be used.'
	),

	array(
		'name' => 'Logo image width',
		'id' => 'logo_width',
		'suffix' => 'px',
		'type' => 'text',
		'desc' => 'The logo image width in pixels- default:134'
	),

	array(
		'name' => 'Logo image height',
		'id' => 'logo_height',
		'suffix' => 'px',
		'type' => 'text',
		'desc' => 'The logo image height in pixels- default:27'
	),

	array(
		'type' => 'documentation',
		'text' => '<h3>Other</h3>'
	),

	array(
		'name' => 'Favicon image URL',
		'id' => 'favicon',
		'type' => 'upload',
		'desc' => 'Upload a favicon image - with .ico extention.'
	),

	array(
		'name' => 'Enable AJAX in gallery and portfolio items',
		'id' => 'portfolio_ajax',
		'type' => 'checkbox',
		'std' => true,
		'desc' => 'If enabled, the data in the galleries and portfolio items
			will be loaded with AJAX. However, if you prefer to have the page 
			refreshed when a new item has been selected and not load the data 
			with AJAX, you can disable this option.'
	),



	array(
		'name' => 'Disable right click',
		'id' => 'disable_click',
		'type' => 'checkbox',
		'std' => false,
		'desc' => 'If "ON" selected, right click will be disabled for the theme 
			in order to add copyright protection to images. If you insert a 
			text in the "Message on right click" field below, this message will 
			be alerted.'
	),

	array(
		'name' => 'Message on right click',
		'id' => 'click_message',
		'type' => 'textarea',
		'desc' => 'This is the message that is displayed when the mouse right 
			click is disabled. If you leave the field empty, no message will be 
			alerted.'
	),


	array(
		'name' => 'Google Analytics Code',
		'id' => 'analytics',
		'type' => 'textarea',
		'desc' => 'You can paste your generated Google Analytics here and it 
			will be automatically set to the theme.'
	),

	array(
		'type' => 'close' ),

	/* ------------------------------------------------------------------------*
	 * FOOTER
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'footer'
	),


	array(
		'name' => 'Footer Layout',
		'id' => 'footer_layout',
		'type' => 'select',
		'options' => array( 
			array( 'id'=>'4', 'name'=>'Four columns' ), 
			array( 'id'=>'3', 'name'=>'Three columns' ), 
			array( 'id'=>'2', 'name'=>'Two columns' ), 
			array( 'id'=>'1', 'name'=>'One column' ), 
			array( 'id'=>'no-footer', 'name'=>'No widgetized footer' ) ),
		'std' => '4'
	),

	
	array(
		'name' => 'Footer Copyright text',
		'id' => 'copyright_text',
		'type' => 'text',
		'std' => 'Copyright &copy; '.PEXETO_THEMENAME.' by Pexeto'
	),


	array(
		'type' => 'documentation',
		'text' => '<h3>Call to action section</h3>'
	),

	array(
		'name' => 'Show call to action section above footer columns',
		'id' => 'show_ca',
		'type' => 'checkbox',
		'std' => true
	),

	array(
		'name' => 'Title',
		'id' => 'ca_title',
		'type' => 'text'
	),

	array(
		'name' => 'Description',
		'id' => 'ca_desc',
		'type' => 'textarea'
	),

	array(
		'name' => 'Button text',
		'id' => 'ca_btn_text',
		'type' => 'text'
	),

	array(
		'name' => 'Button link',
		'id' => 'ca_btn_link',
		'type' => 'text'
	),

	array(
		'type' => 'close' ),

	/* ------------------------------------------------------------------------*
	 * SIDEBARS
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'sidebar'
	),

	array(
		'name'=>'Add Sidebar',
		'id'=>'sidebars',
		'type'=>'custom',
		'button_text'=>'Add Sidebar',
		'editable' => false,
		'fields'=>array(
			array( 'id'=>'name', 'type'=>'text', 'name'=>'Sidebar Name', 'required'=>true )
		),
		'bind_to'=>array(
			'ids'=>array( 'post_sidebar', 'archive_sidebar', 'portfolio_sidebar' ),
			'links'=>array( 'id'=>'name', 'name'=>'name' )
		),
		'desc'=>'In this section you can create additional custom sidebars.
		Then for each page you will be able to assign a different sidebar.'
	),

	array(
		'type' => 'close' ),



	/* ------------------------------------------------------------------------*
	 * THEME UPDATE
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'update'
	),

	array(
		'name' => 'Envato Marketplace Username',
		'id' => 'tf_username',
		'type' => 'text',
		'desc' => 'If you would like to have an option to automatically update 
			the theme from the admin panel, you have to insert the username 
			of the account you used to purchase the theme from ThemeForest. 
			For more information you can refer to the "Updates" section of the 
			documentation.'
	),

	array(
		'name' => 'Envato Marketplace API Key',
		'id' => 'tf_api_key',
		'type' => 'text',
		'desc' => 'If you would like to have an option to automatically update 
			the theme from the admin panel, you have to insert your API Key here. 
			To obtain your API Key, visit your "My Settings" page on any of the 
			Envato Marketplaces (ThemeForest). For more information you can 
			refer to the "Updates" section of the documentation.'
	),

	array(
		'type' => 'close' ),



	/* ------------------------------------------------------------------------*
	 * SOCIAL SHARING
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'social'
	),

	array(
		'type' => 'documentation',
		'text' => '<h3>Social Sharing Buttons</h3>'
	),


	array(
		'name' => 'Display sharing buttons on',
		'id' => 'show_share_buttons',
		'type' => 'multicheck',
		'options' => array(
			array( 'id'=>'page', 'name'=>'Pages' ),
			array( 'id'=>'post', 'name'=>'Posts' ),
			array( 'id'=>'portfolio', 'name'=>'Portfolio posts' ),
			array( 'id'=>'slider', 'name'=>'Gallery/Portfolio slider' ) ),
		'class'=>'include',
		'std' => array( 'post', 'slider' ) )
	,

	array(
		'name' => 'Sharing buttons',
		'id' => 'share_buttons',
		'type' => 'multicheck',
		'options' => array(
			array( 'id'=>'facebook', 'name'=>'Facebook' ),
			array( 'id'=>'twitter', 'name'=>'Twitter' ),
			array( 'id'=>'googlePlus', 'name'=>'Google+' ),
			array( 'id'=>'pinterest', 'name'=>'Pinterest' ) ),
		'class'=>'include',
		'desc' => 'You can select which sharing buttons to be displayed on the 
			item slider',
		'std' => array( 'facebook', 'twitter', 'googlePlus', 'pinterest' ) )
	,

	array(
		'name' => 'Google+ button language code',
		'id' => 'gplus_lang',
		'type' => 'text',
		'desc' => 'The language code of the text that will be related with the 
			Google+ button functionality. You can get the list with all available 
			language codes here: 
			https://developers.google.com/+/plugins/+1button/#available-languages',
		'std' => 'en-US'
	),


	array(
		'type' => 'documentation',
		'text' => '<h3>Header Social Icons</h3>'
	),


	array(
		'name'=>'Add a social icon',
		'id'=>'sociable_icons',
		'type'=>'custom',
		'button_text'=>'Add Icon',
		'preview'=>'icon_url',
		'fields'=>array(
			array( 'id'=>'icon_url', 'type'=>'imageselect', 'name'=>'Select Icon', 'options'=>$sociable_icons ),
			array( 'id'=>'icon_link', 'type'=>'text', 'name'=>'Social Site Link' ),
			array( 'id'=>'icon_title', 'type'=>'text', 'name'=>'Hover title (optional)' )
		)
	),


	array(
		'type' => 'close' ),


	/* ------------------------------------------------------------------------*
	 * SEO
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'seo'
	),

	array(
		'type' => 'documentation',
		'text' => '<div class="note_box">
			 <b>Note: </b> This section contains some basic SEO options. For more 
			 advanced options, you may consider using an SEO plugin - some plugins 
			 that we recommend are <a href="http://wordpress.org/extend/plugins/wordpress-seo/">
			 WordPress SEO by Yoast</a> and 
			 <a href="http://wordpress.org/extend/plugins/all-in-one-seo-pack/">
			 All in One SEO Pack</a></div>'
	),

	array(
		'name' => 'Site keywords',
		'id' => 'seo_keywords',
		'type' => 'text',
		'desc' => 'The main keywords that describe your site, separated by commas. 
			Example:<br /><i>photography,design,art</i>'
	),

	array(
		'name' => 'Home Page Description',
		'id' => 'seo_description',
		'type' => 'textarea',
		'desc' => 'By default the Tagline set in <b>Settings &raquo; General</b> 
			will be displayed as a description of the site. Here you can set a 
			description that will be displayed on your home page only.'
	),

	array(
		'name' => 'Home page title',
		'id' => 'seo_home_title',
		'type' => 'text',
		'desc' => 'This is the home page document title. By default the blog 
			name is displayed and if you insert a title here, it will be 
			prepended to the blog name'
	),

	array(
		'name' => 'Page title separator',
		'id' => 'seo_serapartor',
		'type' => 'text',
		'std' => '|',
		'desc' => 'Separates the different title parts'
	),

	array(
		'name' => 'Page title for category browsing',
		'id' => 'seo_category_title',
		'type' => 'text',
		'std' => 'Category &raquo; ',
		'desc' => 'This is the page title that is set to the document when 
			browsing a category - the title is built by the text entered here, 
			the name of the category and the name of the blog - for example:
			<br /><i>Category &raquo; Business &laquo; @  Blog name</i>'
	),

	array(
		'name' => 'Page title for tag browsing',
		'id' => 'seo_tag_title',
		'type' => 'text',
		'std' => 'Tag &raquo; ',
		'desc' => 'This is the page title that is set to the document when 
			browsing a tag - the title is built by the text entered here, 
			the name of the tag and the name of the blog - for example:
			<br /><i>Tag &raquo; business &laquo; @  Blog name</i>'
	),

	array(
		'name' => 'Page title for search results',
		'id' => 'search_tag_title',
		'type' => 'text',
		'std' => 'Search results &raquo; ',
		'desc' => 'This is the page title that is set to the document when 
			displaying search results - the title is built by the text entered 
			here, the search query and the name of the blog - for example:<br />
			<i>Search results &raquo;  business &laquo; @  Blog name</i>'
	),

	array(
		'name' => 'Exclude pages from indexation',
		'id' => 'seo_indexation',
		'type' => 'multicheck',
		'options' => array( 
			array( 'id'=>'category', 'name'=>'Category Archive' ), 
			array( 'id'=>'date', 'name'=>'Date Archive' ), 
			array( 'id'=>'tag', 'name'=>'Tag Archive' ), 
			array( 'id'=>'author', 'name'=>'Author Archive' ), 
			array( 'id'=>'search', 'name'=>'Search Results' ),
			array( 'id'=>'pgcategory', 'name'=>'Gallery Category Filter' ) ),
		'class'=>'include',
		'desc' => 'Pages, such as archives pages, display some duplicate content 
			- for example, the same post can be found on your main Blog
			page, but also in a category archive, date archive, etc. Some search 
			engines are reported to penalize sites associated with too much duplicate
			content. Therefore, excluding the pages from this option will remove 
			the search engine indexiation by adding "noindex" and "nofollow" meta 
			tags which would prevent the search engines to index this duplicate content. 
			By default, all the pages are indexed, if you would like to prevent 
			indexation on some pages, just select them in this list.' ),

	array(
		'type' => 'close' ),


	/* ------------------------------------------------------------------------*
	 * CONTACT PAGE SETTINGS
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'contact'
	),

	array(
		'name' => 'Email to which to send contact form message',
		'id' => 'email',
		'type' => 'text' ),

	array(
		'type' => 'documentation',
		'text' => '<h3>CAPTCHA Settings</h3>'
	),

	array(
		'name' => 'Enable CAPTCHA',
		'id' => 'captcha',
		'type' => 'checkbox',
		'std' => false,
		'desc' => 'reCAPTCHA will protect your contact form from spam emails 
			that are generated from robots. If this field is enabled, a CAPTCHA 
			form will be added to the bottom of the contact form. The user will 
			have to insert the text from the generated image in order to prove 
			that he/she is a real human and not a spamming robot.<br /> Please 
			note that you have to also set the "reCAPTCHA public Key" and 
			"reCAPTCHA private Key" fields below.'
	),

	array(
		'name' => 'reCAPTCHA Public Key',
		'id' => 'captcha_public_key',
		'type' => 'text',
		'desc' => 'In order to use CAPTCHA you need to register a public and 
			private keys - you can do it on this page:<br/>
			http://www.google.com/recaptcha/whyrecaptcha <br/>
			For more information you can refer to the "Contact Page" section 
			of the documentation.'
	),

	array(
		'name' => 'reCAPTCHA Private Key',
		'id' => 'captcha_private_key',
		'type' => 'text',
		'desc' => 'In order to use CAPTCHA you need to register a public 
			and private keys - you can do it on this page:<br/>
			http://www.google.com/recaptcha/whyrecaptcha <br/>
			For more information you can refer to the "Contact Page" section of 
			the documentation.'
	),

	array(
		'type' => 'close' ),


	array(
		'type' => 'close' ) );

$pexeto->options->add_option_set( $pexeto_general_options );
