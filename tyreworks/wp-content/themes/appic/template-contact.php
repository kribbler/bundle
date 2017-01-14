<?php
/*
 * Template Name: Contact
 */
get_header();
?>

<?php if (get_theme_option('google_map_show')) {
	echo '<div id="map-canvas" style="height:350px;"></div>';
	$coordinates = get_theme_option('google_map_coordinates');
	$zoom = get_theme_option('google_map_zoom');
	if ($zoom < 1) {
		$zoom = 10;
	}
	if ($address = get_theme_option('google_map_address')) {
		$address = esc_js($address);
	}
	JsClientScript::addScriptScriptFile('googleMapScript', 'https://maps.google.com/maps/api/js?sensor=true');
	JsClientScript::addScript('initGoogleMap',
<<<MAPSCRIPT
var map = new google.maps.Map(document.getElementById('map-canvas'),{
	scaleControl: true,
	center: new google.maps.LatLng({$coordinates}),
	zoom: {$zoom},
	mapTypeId: google.maps.MapTypeId.ROADMAP
});
var marker = new google.maps.Marker({
	map: map,
	position: map.getCenter()
});
var addressText = '{$address}';
if (addressText) {
	var infowindow = new google.maps.InfoWindow();
	infowindow.setContent(addressText);
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map, marker);
	});
}
MAPSCRIPT
	);
} ?>

<div class="white-wrap container page-content">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
</div>

<?php get_footer(); ?>