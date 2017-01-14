<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title>
<?php if (is_home() || is_front_page()) {
	if(pexeto_text('seo_home_title')){
		echo pexeto_text('seo_home_title').' '.pexeto_option('seo_serapartor').' ';
	}
} elseif (is_category()) {
	echo pexeto_text('seo_category_title'); wp_title('&laquo; '.pexeto_option('seo_serapartor').' ', TRUE, 'right');
} elseif (is_tag()) {
	echo pexeto_text('seo_tag_title'); wp_title('&laquo; '.pexeto_option('seo_serapartor').' ', TRUE, 'right');
} elseif (is_search()) {
	echo pexeto_text('search_tag_title');
	echo the_search_query();
	echo '&laquo; '.pexeto_option('seo_serapartor').' ';
} elseif (is_404()) {
	echo '404 '; wp_title(' '.pexeto_option('seo_serapartor').' ', TRUE, 'right');
} else {
	echo wp_title(' '.pexeto_option('seo_serapartor').' ', TRUE, 'right');
} 
echo bloginfo('name');
?>
</title>

<?php
//print the Facebook and Google+ meta tags to include the featured image
//of the post/page when it is shared
global $post;
if(is_single() && isset($post)){ 
	if($post->post_type==PEXETO_PORTFOLIO_POST_TYPE){
		$image = pexeto_get_portfolio_preview_img($post->ID);
		$image = $image['img'];
	}else{
		$image = pexeto_get_featured_image_url($post->ID);
	}

	if(!empty($image)){
	?>
	<!-- facebook meta tag for image -->
    <meta property="og:image" content="<?php echo $image; ?>"/>
    <!-- Google+ meta tag for image -->
    <meta itemprop="image" content="<?php echo $image; ?>">
<?php } 
}
?>


<!-- Description meta-->
<meta name="description" content="<?php if ((is_home() || is_front_page()) && pexeto_option('seo_description')) { echo (pexeto_option('seo_description')); }else{ bloginfo('description');}?>" />
<!-- Mobile Devices Viewport Resset-->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- <meta name="viewport" content="initial-scale=1.0, user-scalable=1" /> -->
<?php if(pexeto_option('seo_keywords')){ ?>
<!-- Keywords-->
<meta name="keywords" content="<?php echo pexeto_option('seo_keywords'); ?>" />
<?php } ?>




<?php 
//remove SEO indexation and following for the selected archives pages
if(is_archive() || is_search() || is_page_template('template-portfolio-gallery.php')){
	$exclude_index_pages=pexeto_option('seo_indexation');
	if($exclude_index_pages == '') $exclude_index_pages = array();
	if((is_category() && in_array('category', $exclude_index_pages))
	|| (is_author() && in_array('author', $exclude_index_pages))
	|| (is_tag() && in_array('tag', $exclude_index_pages))
	|| (is_date() && in_array('date', $exclude_index_pages))
	|| (is_search() && in_array('search', $exclude_index_pages))
	|| (is_page_template('template-portfolio-gallery.php') && isset($_GET['cat']) && in_array('pgcategory', $exclude_index_pages))
	){ ?>
	<!-- Disallow content indexation on this page to remove duplicate content problems -->
	<meta name="googlebot" content="noindex,nofollow" />
	<meta name="robots" content="noindex,nofollow" />
	<meta name="msnbot" content="noindex,nofollow" />
	<?php }
}
?>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo pexeto_option('favicon'); ?>" />

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="main-container">
	<div  class="page-wrapper" >
		<!--HEADER -->
		<div id="header">
			<div id="logo-container"><a href="<?php echo home_url(); ?>"></a></div>	
			<?php locate_template( array( 'includes/social-icons.php' ), true, false ); ?>	
	        <div class="mobile-nav">
				<span class="mob-nav-btn"><?php echo pexeto_text('menu_text'); ?></span>
			</div>
			<div class="clear"></div>
			<div class="header-separator"></div>
	 		<div id="navigation-container">
				<div id="menu-container">
		        	<div id="menu">
					<?php wp_nav_menu(array('theme_location' => 'pexeto_main_menu', 'fallback_cb'=>'pexeto_no_menu')); ?>
					</div>
		        </div> 
	  	 	</div> 
	 
		    <div class="clear"></div>       
		    <div id="navigation-line"></div>
		</div> <!-- end #header -->
