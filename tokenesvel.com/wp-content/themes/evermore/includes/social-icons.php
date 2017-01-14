<?php
//PRINT THE SOCIAL ICONS
$p_icons = pexeto_option("sociable_icons");

if(!empty($p_icons)){
		?>
	<div id="social-profiles"><ul class="social-icons">
	<?php
	foreach ($p_icons as $icon) {
		$title=!empty($icon["icon_title"])?' title="'.$icon["icon_title"].'"':'';
		?>
	<li><a href="<?php echo $icon["icon_link"];?>" target="_blank" <?php echo $title; ?>><div><img src="<?php echo $icon["icon_url"]; ?>" alt="" /></div></a></li>
	<?php } ?>
	</ul></div>
	<?php 
}
?>