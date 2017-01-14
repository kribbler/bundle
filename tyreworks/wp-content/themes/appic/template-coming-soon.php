<?php
/*
 * Template Name: Coming Soon 
 */
wp_enqueue_script('count_down', PARENT_URL . '/scripts/count.down.js', array('jquery'));
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<!--[if lt IE 8]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]--><!--Edge mode for IE8+-->
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title><!--Change Title-->
<meta name="description" content="<?php bloginfo('description'); ?>" /><!--Change content-->
<meta name="viewport" content="width=device-width, initial-scale=1.0" /><!--Scale a webpage to a 1:1 pixel-->
<?php wp_head(); ?>
</head>
<body class="oneContainer coming-soon"><?php render_google_analytics_code(); ?>
	<header>
		<div class="logo text-center coming-soon-logo horizontal-blue-lines">
			<?php get_template_part('includes/templates/logo-link'); ?>
		</div><!-- #logo -->
	</header>
<?php
$releaseDate = get_theme_option('coming_soon_date');
if (!$releaseDate) {
	$releaseDate = date('Y-m-d', strtotime('+1day'));
}

$showForm = get_theme_option('coming_soon_sb');
$formCode = $showForm ? get_theme_option('coming_soon_sb_form_code') : '';

JsClientScript::addScript('runCountDown', "countDown('', '{$releaseDate}');");
?>
<?php while (have_posts()) : the_post(); ?>
<div class="white-wrap horizontal-blue-lines counters-wrap">
	<section class="text-center container">
		<h2 class="counters-title"><?php the_title(); ?></h2>
		<h3 class="font-style-24"><?php the_content(); ?></h3>
		<div class="counters clearfix">
			<div class="timer-wrap">
				<div class="timer-bg"></div>
				<span class="digits">0</span>
				<input class="knob day" data-min="0" data-max="100" data-bgColor="#e5f5fe" data-fgColor="#7ccbfc" data-displayInput=false data-width="200" data-height="200" data-thickness=".11">
				<div class="digits-label">days</div>
			</div>
			<div class="timer-wrap">
				<div class="timer-bg"></div>
				<span class="digits">0</span>
				<input class="knob hour" data-min="0" data-max="24" data-bgColor="#e5f5fe" data-fgColor="#7ccbfc" data-displayInput=false data-width="200" data-height="200" data-thickness=".11">
				<div class="digits-label">hours</div>
			</div>
			<div class="timer-wrap">
				<div class="timer-bg"></div>
				<span class="digits">0</span>
				<input class="knob minute" data-min="0" data-max="60" data-bgColor="#e5f5fe" data-fgColor="#7ccbfc" data-displayInput=false data-width="200" data-height="200" data-thickness=".11">
				<div class="digits-label">minutes</div>
			</div>
			<div class="timer-wrap">
				<div class="timer-bg"></div>
				<span class="digits">0</span>
				<input class="knob second" data-min="0" data-max="60" data-bgColor="#e5f5fe" data-fgColor="#7ccbfc" data-displayInput=false data-width="200" data-height="200" data-thickness=".11">
				<div class="digits-label">seconds</div>
			</div>
		</div>
		<p class="simple-text-14"><?php echo get_theme_option('coming_soon_description'); ?></p>
	<?php if (!empty($formCode)) : ?>
		<span class="separation"></span>
		<?php if ($sbNote = get_theme_option('coming_soon_sb_note')) { ?>
			<h3 class="font-style-24"><?php echo $sbNote; ?></h3>
		<?php } ?>
		<?php echo do_shortcode($formCode); ?>
	<?php endif; ?>
	</section>
</div>
<?php endwhile; ?>

<?php get_footer(); ?>