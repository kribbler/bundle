<?php
/**
 * Template that displays the page title.
 */
global $pexeto_page;

if ( !isset( $pexeto_page['show_title'] ) || $pexeto_page['show_title']==='global' ) {
	$pexeto_page['show_title']=pexeto_option( 'show_page_title' );
}

if ( $pexeto_page['show_title']=='on' || $pexeto_page['show_title']===true ) {?>
	<h1 class="page-heading">
		<?php
	if ( isset( $pexeto_page['title'] ) ) {
		echo $pexeto_page['title'];
	}else {
		the_title();
	}
?>
	</h1>
<?php }
