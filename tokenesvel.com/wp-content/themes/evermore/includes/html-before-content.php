<?php
/**
 * Prints the content that goes before the main page/post content and after the
 * header - loads a slider if it is set and opens the main container divs.
 */
global $pexeto_page, $slider_data;

//set the layout variables
$layoutclass='layout-'.$pexeto_page['layout'];
if ( isset( $pexeto_page['blog_layout'] ) ) {
	if ( $pexeto_page['blog_layout']=='twocolumn' ) {
		$layoutclass.=' blog-twocolumn';
	}elseif ( $pexeto_page['blog_layout']=='threecolumn' ) {
		$layoutclass.=' blog-threecolumn';
	}

}

$content_id='content';
if ( $pexeto_page['layout']=='full' ) {
	$content_id='full-width';
}
?>

<?php
if ( isset( $pexeto_page['slider'] ) && $pexeto_page['slider']!='none' && $pexeto_page['slider']!='' ) {
	if ( $pexeto_page['slider']=='static' ) {
		//this is static image
		locate_template( array( 'includes/static-header.php' ), true, true );
	}else {
		?><div id="slider-container"><?php
		//this is a slider
		$slider_data=PexetoCustomPageHelper::get_slider_data( $pexeto_page['slider'] );
		locate_template( array( 'includes/'.$slider_data['filename'] ), true, true );
		?></div><?php
	}
}
wp_reset_postdata();

?>

<div id="content-container" class="<?php echo $layoutclass; ?>">
<div id="<?php echo $content_id; ?>">
