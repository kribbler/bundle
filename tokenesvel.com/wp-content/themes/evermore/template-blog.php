<?php
/**
 * Template Name: Blog page
 */
get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		//get all the page meta data (settings) needed (function located in functions/meta.php)
		$pexeto_page = pexeto_get_post_meta( $post->ID, array( 'slider', 'blog_layout', 
			'show_title', 'sidebar', 'post_number', 'exclude_cats' ) );

		if ( $pexeto_page['blog_layout']=='twocolumn' || $pexeto_page['blog_layout']=='threecolumn' ) {
			global $pexeto_scripts;
			$pexeto_masonry = true;
			$pexeto_scripts['blog_masonry']=true;
			$pexeto_scripts['blog_masonry_cols'] = $pexeto_page['blog_layout']=='twocolumn' ? 2 : 3;
			$pexeto_page['layout'] = 'full';
		}else {
			$pexeto_masonry = false;
			$pexeto_page['layout']=$pexeto_page['blog_layout'];
		}

		//include the before content template
		locate_template( array( 'includes/html-before-content.php' ), true, true );

		//include the title template
		locate_template( array( 'includes/page-title.php' ), true, true );

		the_content();
	}
}

//set the main post arguments
$args = array(
	'post_type'=>'post',
	'paged' => get_query_var( 'paged' ),
	'posts_per_page'=>$pexeto_page['post_number']
);

if ( isset( $pexeto_page['exclude_cats'] ) && !empty( $pexeto_page['exclude_cats'] ) ) {
	$exclude_cats = explode( ',', $pexeto_page['exclude_cats'] );
	$args['category__not_in'] = $exclude_cats;
}

query_posts( $args );

if ( have_posts() ) {

	if ( $pexeto_masonry ) {
		//it is a multi-column layout, wrap the content into a masonry div
		?><div id="blog-masonry" class="page-masonry"><?php
	}
	while ( have_posts() ) {
		the_post();
		global $more;
		$more = 0;

		//include the post template
		locate_template( array( 'includes/post-template.php' ), true, false );
	}

	if ( $pexeto_masonry ) {
		?></div><?php
	}


	locate_template( array( 'includes/post-pagination.php' ), true, false );

}else {
	echo pexeto_text( 'no_posts_available' );
}

//reset the inital page query
wp_reset_query();
wp_reset_postdata();

//include the after content template
locate_template( array( 'includes/html-after-content.php' ), true, true );

get_footer();
?>
