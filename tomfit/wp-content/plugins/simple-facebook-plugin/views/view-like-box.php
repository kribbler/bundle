<?php 
// Check if shortcode return string and not bool 
if ( is_string( $border ) ) $border = ( $border == 'true') ? true : false;
if ( is_string( $faces 	) ) $faces 	= ( $faces 	== 'true') ? true : false;
if ( is_string( $stream ) ) $stream = ( $stream == 'true') ? true : false;
if ( is_string( $header ) ) $header = ( $header == 'true') ? true : false;

$like_box_classes = array( "sfp-container" );
$like_box_classes = apply_filters( "sfp_like_box_classes", $like_box_classes, $instance );
$like_box_classes = implode( " ", $like_box_classes );

?>
<div id="fb-root"></div>
<script>
	(function(d){
		var js, id = 'facebook-jssdk';
		if (d.getElementById(id)) {return;}
		js = d.createElement('script');
		js.id = id;
		js.async = true;
		js.src = "//connect.facebook.net/<?php echo $local; ?>/all.js#xfbml=1";
		d.getElementsByTagName('head')[0].appendChild(js);
	}(document));
</script>
<!-- SFPlugin by topdevs -->
<!-- Like Box Code START -->
<div class="<?php echo $like_box_classes; ?>">
	<div class="fb-like-box"
		data-href="<?php echo $url; ?>"
		data-width="<?php echo $width; ?>"
		data-height="<?php echo $height; ?>"
		data-colorscheme="<?php echo $colorscheme; ?>"
		data-show-faces="<?php echo ( $faces ) ? 'true' : 'false'; ?>"
		data-show-border="<?php echo ( $border ) ? 'true' : 'false'; ?>"
		data-stream="<?php echo ( $stream ) ? 'true' : 'false' ;?>" 
		data-header="<?php echo ( $header ) ? 'true' : 'false' ;?>">
	</div>
</div>
<!-- Like Box Code END -->