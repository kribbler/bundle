<?php if (get_theme_option('footer_show_widgets')) :
	if ('4' == get_theme_option('footer_widgets_columns')) {
		get_template_part('includes/templates/footer/4columns');
	} else {
		get_template_part('includes/templates/footer/3columns');
	}
endif; ?>

<div class="footer-wrap">
	<div class="blue-line-wrap">
		<footer class="container">
		<?php if (get_theme_option('footer_show_social_media')) : ?>
			<ul class="social pull-right">
			<?php
				if($slPinterest = get_theme_option("social_link_pinterest")){
					echo '<li title="pinterest" class="custom-tooltip blue-tooltip"><a href="' . $slPinterest . '" class="pinterest-icon"></a></li>';
				}
				
				if($slGoogle = get_theme_option("social_link_google")){
					echo '<li title="google" class="custom-tooltip blue-tooltip"><a href="' . $slGoogle . '" class="google-icon"></a></li>';
				}
				
				if($slLinkedIn = get_theme_option("social_link_linkedin")){
					echo '<li title="linkedin" class="custom-tooltip blue-tooltip"><a href="' . $slLinkedIn . '" class="linkedin-icon"></a></li>';
				}
				
				if($slTwitter = get_theme_option("social_link_twitter")){
					echo '<li title="twitter" class="custom-tooltip blue-tooltip"><a href="' . $slTwitter . '" class="twitter-icon"></a></li>';
				}
				
				if($slFacebook = get_theme_option("social_link_facebook")){
					echo '<li title="facebook" class="custom-tooltip blue-tooltip"><a href="' . $slFacebook . '" class="facebook-icon"></a></li>';
				}
			?>
			</ul>
		<?php endif; ?>
			<div class="copyright pull-left">
				<?php echo get_theme_option('footer_note'); ?>
			</div>
		</footer>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>