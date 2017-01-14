<?php if (have_comments()) : ?>

<?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>

<div class="page-elements-title-wrap horizontal-blue-lines text-center" id="comments">
	<h3 class="page-elements-title page-title-position blue-text"><?php comments_number(); ?></h3>
</div>
<ul class="comments-list">

<?php
function appic_comment($comment, $args, $depth)
{
	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
		<figure class="pull-left text-center author-reply">
		<?php
			if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] );
			if ( get_the_author() == get_comment_author_link() ) {
				echo "<figcaption>". __('author', 'appic') . "</figcaption>";
			}
		?>
		</figure>
		<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
	</div>
	<?php if ( '0' == $comment->comment_approved ) : ?>
	<em class="comment-awaiting-moderation"><?php __( 'Your comment is awaiting moderation.', 'appic') ?></em>
	<br />
	<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
		<?php
			/* translators: 1: date, 2: time */
			printf( __( '%1$s || %2$s', 'appic'), get_comment_date('M j, Y'),  get_comment_time('g:i a') ); ?></a><?php edit_comment_link( __( '(Edit)', 'appic' ), '&nbsp;&nbsp;', '' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
		<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}

$args = array(
	'walker'            => null,
	'max_depth'         => 3,
	'style'             => 'ul',
	'callback'          => 'appic_comment',
	'end-callback'      => null,
	'type'              => 'all',
	'page'              => '',
	'per_page'          => '5',
	'avatar_size'       => 100,
	'reverse_top_level' => null
);

wp_list_comments( $args );
?>
</ul>

<div class="comments-link-wrap text-center">
	<?php previous_comments_link( __('Load later comments', 'appic') ); ?>
	<?php next_comments_link( __('Load next comments', 'appic') ); ?>
</div>
<?php else : ?>
	<?php echo '<h3 class="nocomments">' . __('No Comments Yet.', 'appic') . '</h3>'; ?>
<?php endif; ?>
<?php
$fields = array(
		'author' => '<p class="comment-form-author">' . 
			'<input id="author" name="author" type="text" placeholder="'. __( 'Name:', 'appic' ) .'" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" /></p>',
		'email'  => '<p class="comment-form-email">' .
			'<input id="email" name="email" type="text" placeholder="'. __( 'Email:', 'appic' ) .'" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" /></p>'
);
$args = array(
	'fields' => apply_filters( 'comment_form_default_fields', $fields ),
	'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.', 'appic' ) . '</p>',
	'comment_notes_after' => '',
	'label_submit' => __ ('Reply', 'appic')
);
comment_form($args);
