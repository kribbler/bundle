<?php
/**
 * @package theretailer
 * @since theretailer 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title gbtr_post_title_listing"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'theretailer' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<div class="gbtr_bold_sep"></div>        
            <div class="entry-meta">
                <?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
                <?php
                    /* translators: used between list items, there is a space after the comma */
                    $categories_list = get_the_category_list( __( ', ', 'theretailer' ) );
                    if ( $categories_list ) :
                ?>
                <span class="cat-links">
                    <?php printf( __( 'Filed in: %1$s', 'theretailer' ), $categories_list ); ?>
                </span>
                <?php endif; // End if categories ?>
    
                <?php
                    /* translators: used between list items, there is a space after the comma */
                    $tags_list = get_the_tag_list( '', __( ', ', 'theretailer' ) );
                    if ( $tags_list ) :
                ?>
                <span class="sep"> | </span>
                <span class="tags-links">
                    <?php printf( __( 'Tags: %1$s', 'theretailer' ), $tags_list ); ?>
                </span>
                <?php endif; // End if $tags_list ?>
            <?php endif; // End if 'post' == get_post_type() ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
    
    <footer class="entry-meta">
		<?php theretailer_posted_on(); ?>
		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="sep"> | </span>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'theretailer' ), __( '1 Comment', 'theretailer' ), __( '% Comments', 'theretailer' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'theretailer' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->

	<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>
        <div class="entry-thumbnail">
            <?php the_post_thumbnail(); ?>
        </div>
    <?php } ?>
	
    <div class="entry-content">
		<?php the_content(); ?>
        <div class="clr"></div>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'theretailer' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
    
    
    
</article><!-- #post-<?php the_ID(); ?> -->
