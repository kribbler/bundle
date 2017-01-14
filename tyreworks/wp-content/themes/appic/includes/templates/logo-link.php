<?php 
	$bName = get_bloginfo('name');
	$bDescription = esc_attr(get_bloginfo('description'));
	$bDescriptionEscAttr = esc_attr($bDescription);
?>
<?php if(get_theme_option('logo_type') == 'text'){ ?>
	<?php if( is_front_page() || is_home() || is_404() ) { ?>
		<h1 class="logo-text"><a href="<?php echo home_url(); ?>" title="<?php echo $bDescriptionEscAttr; ?>"><?php echo esc_html($bName); ?></a></h1>
		<p class="tagline"><?php echo esc_html($bDescription); ?></p>
	<?php } elseif(is_page_template('template-coming-soon.php')) { ?>
		<h1 class="logo-text"><?php echo esc_html($bName); ?></h1>
	<?php } else { ?>
		<h2><a href="<?php echo home_url(); ?>" title="<?php echo $bDescriptionEscAttr; ?>"><?php echo esc_html($bName); ?></a></h2>
		<p class="tagline"><?php echo esc_html($bDescription); ?></p>
	<?php } ?>
<?php } else { //logo_image_retina ?>
	<?php $bNameEscAttr = esc_attr($bName); ?>
	<a id="logoLink" href="<?php echo home_url(); ?>">
		<img id="normalImageLogo" src="<?php echo get_theme_option('logo_image'); ?>" alt="<?php echo $bNameEscAttr; ?>" title="<?php echo $bDescriptionEscAttr; ?>">
		<img id="retinaImageLogo" src="<?php echo get_theme_option('logo_image_retina'); ?>" alt="<?php echo $bNameEscAttr; ?>" title="<?php echo $bDescriptionEscAttr; ?>">
	</a>
<?php } ?>