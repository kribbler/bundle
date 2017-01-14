<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<!--[if lt IE 8]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]--><!--Edge mode for IE8+-->
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title><!--Change Title-->
<meta name="description" content="<?php bloginfo('description'); ?>" /><!--Change content-->
<meta name="viewport" content="width=device-width, initial-scale=1.0" /><!--Scale a webpage to a 1:1 pixel-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>><?php render_google_analytics_code(); ?>
<!--[if lt IE 8]>
	<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->
<header>
<?php if (get_theme_option('show_top_lines')) : ?>
	<div class="top-nav">
		<div class="container">
			<p class="pull-left inline hidden-phone">
				<?php echo get_theme_option ('top_line_left_text'); ?>
			</p>
			<?php do_action('icl_language_selector'); ?>
			<p class="pull-right inline">
				<?php echo get_theme_option ('top_line_right_text'); ?>
			</p>
		</div>
	</div>
<?php  endif; ?>
	<div class="main-nav-wrap">
		<div class="blue-line-wrap">
			<nav class="main-navbar container">
				<div class="logo pull-left">
					<?php get_template_part('includes/templates/logo-link'); ?>
				</div><!-- .logo -->
				<div id="navigation-box"  class="pull-right">
					<a href="#" id="navigation-toggle">
						<span class="menu-icon"></span>
					</a>
					<?php
						if(has_nav_menu('header-menu')){
							wp_nav_menu(array(
								'theme_location' => 'header-menu',
								'container' => '',
								'menu_class' => '',
								'menu_id' => 'navigation',
								'depth' => 3,
							));
						}
					?>
				</div>
			</nav>
		</div>
	</div>
</header>

<?php
// call to action block
$callToActionImage = null;
if (is_page() || (is_singular('service'))) {
	if (is_page()) {
		$caMetaObject = vp_metabox('page_call_action_meta');
	} else {
		$caMetaObject = vp_metabox('service_call_action_meta');
	}
	
	$caMetaData = $caMetaObject->meta;
	if (!empty($caMetaData['image_url'])) {
		$callToActionImage = $caMetaData['image_url'];
		$caPrimaryTitleEscaped = !empty($caMetaData['title1']) ? esc_html($caMetaData['title1']) : '';
		$caSecondaryTitleEscaped = !empty($caMetaData['title2']) ? esc_html($caMetaData['title2']) : '';
		$caBtnUrl = isset($caMetaData['btn_url']) ? $caMetaData['btn_url'] : '';
		$caBtnTitleEscaped = $caBtnUrl && !empty($caMetaData['btn_title']) ? esc_html($caMetaData['btn_title']) : '';
	}
}
?>
<section class="action-area-mini">
	<?php echo appic_breadcrumbs(); ?>
<?php if ($callToActionImage) { ?>
	<?php
		$fotoAboutStyleText = 'background-image:url(' . esc_url($callToActionImage) .');';
		if (!empty($caMetaData['bg_position'])) {
			$_bgOpt = $caMetaData['bg_position'];
			$fotoAboutStyleText .= "background-position:{$_bgOpt['v']} {$_bgOpt['h']};background-repeat:{$_bgOpt['repeat']};";
		};
	?>
	<div class="call-action-photo-wrapper" style="<?php echo $fotoAboutStyleText; ?>">
		<div class="foto-pattern">
			<div class="container">
				<h2 class="page-title pull-left page-title-margin"><?php echo $caPrimaryTitleEscaped; ?><small><?php echo $caSecondaryTitleEscaped; ?></small></h2>
			<?php if ($caBtnTitleEscaped) { ?>
				<ul class="ch-second-grid">
					<li class="pull-right download-button">
						<div class="ch-second-item">
							<h4><?php echo $caBtnTitleEscaped; ?><br><span class="download-button-arrow"></span></h4>
							<a href="<?php echo esc_url($caBtnUrl); ?>" class="ch-second-info"><h4><?php echo $caBtnTitleEscaped; ?><br><span class="download-button-arrow"></span></h4></a>
						</div>
					</li>
				</ul>
			<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
</section><!-- .action-area-mini -->

