<?php
$blocks = array();

for ($i=1; $i<=3; $i++) {
	$sTitle = get_theme_option('home_ca_title_' . $i);
	if (!$sTitle) {
		continue;
	}
	$sTitleHover = get_theme_option('home_ca_title_hover_' . $i);
	$blocks[] = array(
		'title' => $sTitle,
		'titleHover' => $sTitleHover ? $sTitleHover : ' ',
		'url' => get_theme_option('home_ca_url_' . $i),
		'description' => get_theme_option('home_ca_description_' . $i),
	);
}

if (empty($blocks)) {
	return '';
}

$caMainTitle = get_theme_option('home_ca_title');
$caSubtitle = get_theme_option('home_ca_subtitle');
?>

<section class="action-area">
	<div class="pattern-wrap">
		<div class="lines-wrap horizontal-grey-lines">
			<div class="text-center">
			<?php if ($caMainTitle) { ?>
				<h2><?php echo $caMainTitle; ?></h2>
			<?php } ?>
			<?php if ($caSubtitle) { ?>
				<h3><?php echo $caSubtitle; ?></h3>
			<?php } ?>
				<ul class="ch-grid">
				<?php foreach ($blocks as $item) : ?>
					<li>
						<div class="ch-item">
							<div class="ch-info">
								<div class="ch-info-front">
									<h4><?php echo $item['title']; ?></h4>
								</div>
								<div class="ch-info-back">
									<h4><?php echo $item['titleHover']; ?></h4>
									<p class="hidden-phone"><?php echo $item['description'] ? $item['description'] : '&nbsp;'; ?></p>
								<?php if (!empty($item['url'])) { ?>
									<a href="<?php echo $item['url']; ?>"></a>
								<?php } ?>
								</div>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>