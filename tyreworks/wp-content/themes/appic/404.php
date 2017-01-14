<?php get_header("404"); ?>

<?php
$suggestedLinksHtml = '<a href="' . home_url() .'" class="link-404">' . __('home', 'appic') .'</a>';

$pageTitle = get_theme_option('404_title');
$pageText = get_theme_option('404_text');

$pageText = sprintf($pageText, $suggestedLinksHtml);
?>

<section class="content-404">
	<h3 class="title-404"><?php echo $pageTitle; ?></h3>
	<p class="simple-text-14"><?php echo $pageText; ?></p>
	<?php get_search_form(); ?>
</section>

<?php
JsClientScript::addScript('placeholderClass',
<<<SCRIPT
//placeholder for old brousers and IE
if(!Modernizr.input.placeholder){
	$('[placeholder]').focus(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
				input.removeClass('placeholder');
			}
		})
		.blur(function() {
			var input = $(this);
			if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.addClass('placeholder');
				input.val(input.attr('placeholder'));
			}
		})
		.blur();

	$('[placeholder]').parents('form').submit(function() {
		$(this).find('[placeholder]').each(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
			}
		})
	});
}
SCRIPT
);
?>

<?php wp_footer(); ?>