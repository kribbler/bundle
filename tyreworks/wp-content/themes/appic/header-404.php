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
<body class="page-404 text-center"><?php render_google_analytics_code(); ?>
<!--[if lt IE 8]>
	<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->
<header class="header-height">
	<div class="logo" id="logo">
		<?php get_template_part('includes/templates/logo-link'); ?>
	</div><!-- #logo -->
</header>
