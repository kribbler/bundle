<?php
/**
 * Template used for all custom css settings rendering.
 */
?>
<?php if (isset($h1_font_settings) && $h1_font_settings && ($classContent = $this->getFontClassContent($h1_font_settings))) : ?>
h1, h2, h3, h4, h5, h6{
	<?php echo $classContent; ?>
}
<?php endif; ?>
<?php if (isset($h2_font_settings) && $h2_font_settings && ($classContent = $this->getFontClassContent($h2_font_settings))) : ?>
.page-elements-title{
	<?php echo $classContent; ?>
}
<?php endif; ?>
<?php if (isset($nav_font_settings) && $nav_font_settings && ($classContent = $this->getFontClassContent($nav_font_settings))) : ?>
ul#navigation li{
	<?php echo $classContent; ?>
}
<?php endif; ?>
<?php if (isset($body_font_settings) && $body_font_settings && ($classContent = $this->getFontClassContent($body_font_settings))) : ?>
body, p, #input-search, #input-email{
	<?php echo $classContent; ?>
}
<?php endif; ?>
<?php if (isset($button_font_settings) && $button_font_settings && ($classContent = $this->getFontClassContent($button_font_settings))) : ?>
.btn{
	<?php echo $classContent; ?>
}
<?php endif; ?>
<?php if(isset($button_font_size) && $button_font_size) : ?>
.btn{
	font-size:<?php echo join('', $button_font_size); ?>;
}
<?php endif; ?>
<?php if(isset($large_button_font_size) && $large_button_font_size) : ?>
.btn-large, .btn-large-maxi{
	font-size:<?php echo join('', $large_button_font_size); ?>;
}
<?php endif; ?>
<?php if(isset($custom_css_text) && $custom_css_text) : ?>
	<?php echo $custom_css_text; ?>
<?php endif; ?>