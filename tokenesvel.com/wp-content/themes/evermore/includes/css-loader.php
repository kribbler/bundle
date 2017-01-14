<!-- CUSTOM THEME STYLES -->
<style type="text/css">
<?php 

$css='';
$option_keys = array("skin" , "custom_color" , "pattern" , "custom_pattern" , 
	"body_color" , "body_bg" , "custom_body_bg" , "body_text_size" , 
	"logo_image" , "retina_logo_image" , "logo_width" , "logo_height" , 
	"link_color" , "heading_color" , "elements_color" , "custom_elements_color",
	"footer_text_color" , "footer_link_color",
	"headings_font_family" , "body_font", "menu_font", "footer_border_color",
	"content_bg", "border_color", "secondary_color");

foreach ($option_keys as $key) {
	$pexeto_css[$key] = pexeto_option($key);
}

$pexeto_main_color=$pexeto_css['custom_color']==''?$pexeto_css['skin']:$pexeto_css['custom_color'];

/**--------------------------------------------------------------------*
 * SET THE BACKGROUND COLOR AND PATTERN
 *---------------------------------------------------------------------*/

if($pexeto_css['custom_pattern']!='' || ($pexeto_css['pattern']!='' && $pexeto_css['pattern']!='none')){
	if($pexeto_css['custom_pattern']!=''){
	$bg=$pexeto_css['custom_pattern'];
	}else{
	$bg=get_bloginfo('template_url').'/images/patterns/'.$pexeto_css['pattern'];
	}
	$css.= 'body{background-image:url('.$bg.');}';
}

$bgcolor=$pexeto_css['custom_body_bg']?$pexeto_css['custom_body_bg']:$pexeto_css['body_bg'];
if($bgcolor!=''){
	$css.= 'body {background-color:#'.$bgcolor.';}';
}

if($pexeto_css['body_text_size']!=''){
	$css.= 'body, .sidebar,#footer ul li a,#footer{font-size:'.$pexeto_css['body_text_size'].'px;}';
}

/**--------------------------------------------------------------------*
 * SET THE LOGO
 *---------------------------------------------------------------------*/

$logo_width = 134;
$logo_height = 27;


if($pexeto_css['logo_image']!=''){
	$css.= "#logo-container a{background:url('".$pexeto_css['logo_image']."') no-repeat;}";
}

if($pexeto_css['logo_width']!=''){
	$logo_width = $pexeto_css['logo_width'];
	$css.= '#logo-container, #logo-container a{width:'.$pexeto_css['logo_width'].'px; }';
}


if($pexeto_css['logo_height']!=''){
	$logo_height = $pexeto_css['logo_height'];
	$css.= '#logo-container, #logo-container a{height:'.$pexeto_css['logo_height'].'px;}';
}

if($pexeto_css['logo_width']!='' && $pexeto_css['logo_height']!=''){
	$css.= '#logo-container a{background-size:'.$pexeto_css['logo_width'].'px; '
	.$pexeto_css['logo_height'].'px;}';
}

//retina display logo
if($pexeto_css['retina_logo_image']){

	$css.= '@media only screen and (-webkit-min-device-pixel-ratio: 1.5), 
	only screen and (-o-min-device-pixel-ratio: 3/2), 
	only screen and (min--moz-device-pixel-ratio: 1.5), 
	only screen and (min-device-pixel-ratio: 1.5) {
	#logo-container a {
	    background: url("'.$pexeto_css['retina_logo_image'].'") no-repeat scroll 0 0 transparent;
	    background-size: '.$logo_width.'px '.$logo_height.'px;
	}}';
}

/**--------------------------------------------------------------------*
 * BACKGROUND OPTIONS
 *---------------------------------------------------------------------*/


$elements_color=$pexeto_css['custom_elements_color']?$pexeto_css['custom_elements_color']:$pexeto_css['elements_color'];
if($elements_color!=''){
	$css.= '.button, .item-num, #submit, input[type=submit], input[type="button"],
		td#today, button, table#wp-calendar td:hover, table#wp-calendar td#today, 
		table#wp-calendar td:hover a, table#wp-calendar td#today a
		{background-color:#'.$elements_color.';}';

	$css.='.pg-cat-filter a.current, .lp-post-info a, .footer-cta-first h5,
		.pg-cat-filter a.current, .pg-pagination a.current, .cs-title, a:hover,
		.services-title-box h1, .read-more, .post-info a, .tabs .current a,
		.post-info, .pg-categories {color:#'.$elements_color.';}';

	$css.='#menu ul .current-menu-item, #menu li:hover, #menu .current-menu-parent, 
		#menu .current-menu-ancestor, .pc-item:hover .pg-info
		{border-color:#'.$elements_color.';}';
	

}


if($pexeto_css['content_bg']!=''){
	$css.= '.page-wrapper, #menu ul li, .img-frame, .ts-pointer:after, .avatar,
	.wp-caption, #menu ul ul li, .qg-img a
	{background-color:#'.$pexeto_css['content_bg'].';}';

	$css.='.content-slider{background:none}';
}

if($pexeto_css['border_color']!=''){
	$css.= '.accordion-title.current, .header-separator, #reply-title, .comments-title,
		.small-title, .page-heading, .blog-single-post .post-info,
		.format-aside, ul#cs-navigation li span, #cs-navigation li.selected span,
		.qg-title, .pg-info, .testimonial-container .double-line, .ts-thumbnail-container .selected img,
		.sidebar-box h4, input[type="text"], input[type="password"], textarea, 
		input[type="search"], .img-frame, #navigation-container, .avatar,
		.comment-info, .widget_categories li, .widget_nav_menu li, .widget_archive li, .widget_links li, 
		.widget_recent_entries li, .widget_pages li, #recentcomments li, blockquote,
		.table th, .table td, .pg-cat-filter, .contact-captcha-container,
		.ps-navigation, .ps-share, .post-title, .post-info, .lp-wrapper,
		table th, table td, table thead, .widget_nav_menu ul ul li, .widget_categories ul ul li,
		.widget_nav_menu ul ul, .widget_categories ul ul, .content-slider,
		.pg-pagination li, .share-title, .tabs a, .accordion-title, .accordion-container,
		.archive-page li, .archive-page ul,  .tabs-container > ul li a, .tabs .current a,
		.tabs-container .panes, .tabs-container > ul
		 {border-color:#'.$pexeto_css['border_color'].';}';
	$css.= '.btn-alt{background-color:#'.$pexeto_css['border_color'].';}';
	$css.='.tabs-container > ul li a{box-shadow: none;}';
}


if($pexeto_css['footer_border_color']!=''){
	$css.= '.footer-box .title, #footer .img-frame, #footer .lp-wrapper,
		#footer #recentcomments li, .footer-cta-first h5, .footer-bottom
		 {border-color:#'.$pexeto_css['footer_border_color'].';}';
}

if($pexeto_css['secondary_color']!=''){
	$css.= '.ts-thumbnail-wrapper, #menu ul ul li:hover, #menu ul ul .current-menu-item,
		.recaptcha-input-wrap, .blog-non-single-post .post-content, .post-tags a,
		.format-quote, .format-aside, .page-masonry  .post-content, .services-box:hover,
		.wp-pagenavi span.current, .pg-cat-filter, .pg-img-wrapper .pg-loading,
		.icon-circle, .ps-content, .ps-loading, .pc-next, .pc-prev, .share-item:hover,
		.mob-nav-menu, .wp-caption, textarea:focus, input[type="password"]:focus, 
		input[type="text"]:focus, input[type="search"]:focus, input[type="text"], 
		input[type="password"], textarea, input[type="search"], .social-icons li,
		.comment-info .reply, .tabs-container > ul li a, .tabs .current a, .ps-wrapper
		{background-color:#'.$pexeto_css['secondary_color'].';}';

	$css.='.pc-next, .pc-prev, .ts-thumbnail-wrapper
		{border-color:#'.$pexeto_css['secondary_color'].';}';
}

/**--------------------------------------------------------------------*
 * TEXT COLORS
 *---------------------------------------------------------------------*/

if($pexeto_css['body_color']!=''){
	$css.= 'body, #content-container .wp-pagenavi a, #content-container .wp-pagenavi span.pages, 
		#content-container .wp-pagenavi span.current, #content-container .wp-pagenavi span.extend,
		input[type="text"], input[type="password"], textarea, input[type="search"],
		#menu ul li a, .services-title-box, .services-box h3, .services-box, .no-caps,
		.small-title span, .pg-cat-filter a, .pg-item h2, .pg-pagination a, .ps-navigation a,
		.comment-date, .lp-title a, .qg-title, .archive-page a
		{color:#'.$pexeto_css['body_color'].';}';
}

if($pexeto_css['link_color']!=''){
	$css.= 'a,.post-info, .post-info a, #main-container .sidebar-box ul li a
		{color:#'.$pexeto_css['link_color'].';}';
}

if($pexeto_css['heading_color']!=''){
	$css.= 'h1,h2,h3,h4,h5,h6,h1.page-heading,.sidebar-box h4,.post h1, 
		h2.post-title a, .content-box h2, #portfolio-categories ul li, h1 a, h2 a, 
		h3 a, h4 a, h5 a, h6 a, .services-box h4, #intro h1, #page-title h1, 
		.item-desc h4 a, .item-desc h4, .sidebar-post-wrapper h6 a, table th, 
		.post-title, .archive-page h2,
		.tabs a, .post-title a:hover{color:#'.$pexeto_css['heading_color'].';}';
}

if($pexeto_css['footer_text_color']!=''){
	$css.= '#footer,#footer ul li a,#footer ul li a:hover,#footer h4, .footer-cta-disc,
		.copyrights{color:#'.$pexeto_css['footer_text_color'].';}';
}

if($pexeto_css['footer_link_color']!=''){
	$css.= '#footer a
		{color:#'.$pexeto_css['footer_link_color'].';}';

	$css.='#footer .button{color:#fff;}';
}


/**--------------------------------------------------------------------*
 * FONTS
 *---------------------------------------------------------------------*/
if($pexeto_css['headings_font_family']!='' && $pexeto_css['headings_font_family']!='default'){
	$font_name = pexeto_get_font_name_by_key($pexeto_css['headings_font_family']);
	if(!empty($font_name)){
		$css.= 'h1,h2,h3,h4,h5,h6{font-family:'.$font_name.';}';
	}
	
}


if(isset($pexeto_css['body_font']) && isset($pexeto_css['body_font']['family'])
	&& $pexeto_css['body_font']['family']!='' && $pexeto_css['body_font']['family']!='default'){
	$font_name = pexeto_get_font_name_by_key($pexeto_css['body_font']['family']);
	if(!empty($font_name)){
		$css.= 'body{font-family:'.$font_name.';}';
	}
}

if(isset($pexeto_css['body_font']) && isset($pexeto_css['body_font']['size'])
	&& !empty($pexeto_css['body_font']['size'])){
	$css.= 'body{font-size:'.$pexeto_css['body_font']['size'].'px;}';
}

if(isset($pexeto_css['menu_font']) && isset($pexeto_css['menu_font']['family'])
	&& $pexeto_css['menu_font']['family']!='' && $pexeto_css['menu_font']['family']!='default'){
	$font_name = pexeto_get_font_name_by_key($pexeto_css['menu_font']['family']);
	if(!empty($font_name)){
		$css.= '#menu ul li a{font-family:'.$font_name.';}';
	}
}

if(isset($pexeto_css['menu_font']) && isset($pexeto_css['menu_font']['size']) 
	&& !empty($pexeto_css['menu_font']['size'])){
	$css.= '#menu ul li a{font-size:'.$pexeto_css['menu_font']['size'].'px;}';
}


/**--------------------------------------------------------------------*
 * ADDITIONAL STYLES
 *---------------------------------------------------------------------*/

if(pexeto_option('additional_styles')!=''){
	$css.=(pexeto_option('additional_styles'));
}

echo $css;
?>

</style>