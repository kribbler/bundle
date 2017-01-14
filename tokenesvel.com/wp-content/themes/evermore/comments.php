<?php 
/**
 * Comments template.
 */
?>
<div id="comments">
<?php

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) { ?>

<p class="nocomments">This post is password protected. Enter the
  password to view comments.</p>
  </div>
<?php
return;
}
?>
<?php if ( comments_open() ) { ?>
<?php if(have_comments()){ ?>
<h4 class="comments-titile">
  <?php comments_number(pexeto_text('no_comments_text'), pexeto_text('one_comment_text'), '% '.pexeto_text('comments_text'))?>
</h4>
<?php } //end if have comments ?>
<div id="comment-content-container">
  <?php if(have_comments()){?>
  <ul class="commentlist">
    <?php wp_list_comments('type=all&callback=pexeto_comments'); ?>
  </ul>
  <div class="comment-navigation" class="navigation">
  <div class="alignleft">
    <?php next_comments_link('<span>&laquo;</span> Previous') ?>
  </div>
  <div class="alignright">
    <?php previous_comments_link('Next<span>&raquo;</span>') ?>
  </div>
</div>
<?php } //end if have comments 

$fields =  array(
	'author' => '<p class="comment-form-author">' . '<label for="author">' . pexeto_text('comment_name_text') . ( $req ? '<span class="mandatory">*</span>'. '</label> '  : '' ) .
	            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" /></p>',
	'email'  => '<p class="comment-form-email"><label for="email">' . pexeto_text('email_text')  . ( $req ? '<span class="mandatory">*</span>' . '</label> ': '' ) .
	            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"/></p>',
	'url'    => '<p class="comment-form-url"><label for="url">' .pexeto_text('website_text') . '</label>' .
	            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
);
$args=array();
$args['fields']=$fields;
$args['comment_field']='<p class="comment-form-comment"><label for="comment">' . pexeto_text('your_comment_text') . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';
$args['comment_notes_before']='<div class="double-line"></div>';
$args['comment_notes_after']='';
$args['title_reply']=pexeto_text('leave_comment_text');
$args['label_submit']=pexeto_text('submit_comment_text');
$args['logged_in_as']='';
$args['title_reply_to']=pexeto_text('leave_reply_to_text').' %s';
$args['cancel_reply_link']=pexeto_text('cancel_reply_text');
 comment_form( $args ); 
 ?>
</div>
<?php } //end if comments open ?>
</div>
