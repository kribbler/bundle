<?php
/**
 * This file contains the comments functionality.
 * @author Pexeto
 */


/**
 * Displays a single comment.
 */
function pexeto_comments($comment, $args, $depth) {

	global $wpdb;
	$user_level = 8; //Default user level (1-10)
	$admin_emails = array(); //Hold Admin Emails

	//Search for the ID numbers of all accounts at specified user level and up
	$admin_accounts = $wpdb->get_results("SELECT * FROM $wpdb->usermeta WHERE meta_key = 'wp_user_level' AND meta_value >= $user_level ");

	//Get the email address for each administrator via ID number
	foreach ($admin_accounts as $admin_account){

		//Get database row for current user id
		$admin_info = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE ID = $admin_account->user_id");

		//Add current user's email to array
		$admin_emails[$admin_account->user_id] = $admin_info->user_email;
	}

	$GLOBALS['comment'] = $comment;

	?>
<li <?php comment_class(); ?>>
	<div class="comment-container">
		<div class="coment-box">
			<div class="comment-info">
				<span class="coment-autor-name"><?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?></span>
				<span class="comment-date"><?php printf(__('%1$s', 'pexeto'), get_comment_date(get_option('date_format'))); ?> &nbsp;  </span>
		
				<span class="reply">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => 4, 'reply_text'=>pexeto_text('reply_text'))));
					?> &rarr;</span>
			</div>	
			<div class="clear"></div>	
			<div class="comment-wrapper">
			<div class="comment-autor"><?php echo get_avatar($comment,$size='80',$default='' ); ?></div>

				<div class="comment-text"><?php comment_text(); ?></div>
				
			</div>
			<div class="clear"></div>
		</div>
	</div>
</li>
	<?php
}