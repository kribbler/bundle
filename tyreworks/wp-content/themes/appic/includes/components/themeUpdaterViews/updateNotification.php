<style>
	.update-nag { display: none; }
	#instructions {max-width: 750px;}
	.theme-screen-picture {float: right; margin: 0 0 20px 20px; border: 1px solid #ddd; width: 300px; height:auto;}
	#changeLogList {list-style-type: disc;list-style-position: inside;}
</style>

<div class="wrap">
	<div id="icon-tools" class="icon32"></div>
	<h2><?php echo $themeName; ?> Theme Updates</h2>
	<div id="message" class="updated below-h2">
		<p><strong>There is a new version of the <?php echo $themeName; ?> Theme available.</strong> You currently have version <?php echo $currentVersion; ?> installed. Please update to version <?php echo $newVersion; ?>.</p>
	</div>

	<div id="instructions">
		<img class="theme-screen-picture" src="<?php echo get_template_directory_uri(). '/screenshot.png'; ?>" />
		<h3>Update Instructions</h3>
		<p>To update <?php echo $themeName; ?>, simply download the latest files from <a href="http://themeforest.net/">Themeforest</a> and install the upgraded version.</p>
		<h4>Quick guide</h4>
		<ol style="padding-left:20px; overflow:hidden;">
			<li>Download the most recent Theme Files</li>
			<li>Install the Updated Theme</li>
		</ol>
		<div style="clear:both"></div>
	</div>
	<?php if (!empty($updatesFlatLog)) {?>
	<div>
		<h3>Changelog</h3>
		<ul id="changeLogList">
		<?php foreach ($updatesFlatLog as $message) { ?>
			<li><?php echo $message; ?></li>
		<?php } ?>
		</ul>
	</div>
	<?php } ?>
</div>