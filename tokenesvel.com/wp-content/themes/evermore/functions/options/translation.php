<?php

$pexeto_translation_options= array( array(
		'name' => 'Texts &amp; Translation',
		'type' => 'title',
		'img' => 'icon-microphone'
	),

	array(
		'type' => 'open',
		'subtitles'=>array(
			array( 'id'=>'settings', 'name'=>'Settings' ),
			array( 'id'=>'blog', 'name'=>'Blog' ),
			array( 'id'=>'comment', 'name'=>'Comments' ),
			array( 'id'=>'portfolio', 'name'=>'Portfolio Gallery' ),
			array( 'id'=>'search', 'name'=>'Search' ),
			array( 'id'=>'contact', 'name'=>'Contact' ),
			array( 'id'=>'other', 'name'=>'Other' ) )
	),

	/* ------------------------------------------------------------------------*
	 * SETTINGS
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'settings'
	),

	array(
		'name' => 'Enable translation',
		'id' => 'enable_translation',
		'type' => 'checkbox',
		'std' => false,
		'desc' => 'Enable this option when using .mo files for translation. 
			By default the texts from the "Translation" section are used. If you 
			would like to enable an additional language, you can use an additional 
			.mo file for this language. For more information please refer to the 
			"Translation" section of the documentation.'
	),

	array(
		'name' => 'Default locale',
		'id' => 'def_locale',
		'type' => 'text',
		'std' => 'en_US',
		'desc' => 'This is the default language locale. If the default selected 
			language is different than English (US), you have to insert the 
			locale name here. The default language can be changed here in the 
			"Translation" section, the additional language texts should be set 
			in a .mo file. For more information please refer to the "Translation" 
			section of the documentation.'
	),

	array(
		'type' => 'close' ),

	/* ------------------------------------------------------------------------*
	 * BLOG TEXTS
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'blog'
	),

	array(
		'name' => 'Read more text',
		'id' => 'read_more',
		'type' => 'text',
		'std' => 'Read More'
	),


	array(
		'name' => 'Previous page text',
		'id' => 'previous_text',
		'type' => 'text',
		'std' => 'Previous'
	),

	array(
		'name' => 'Next page text',
		'id' => 'next_text',
		'type' => 'text',
		'std' => 'Next'
	),

	array(
		'name' => 'Learn more text',
		'id' => 'learn_more',
		'type' => 'text',
		'std' => 'Learn More'
	),

	array(
		'name' => 'No posts available text',
		'id' => 'no_posts_available',
		'type' => 'text',
		'std' => 'No posts available'
	),

	array(
		'name' => 'By text',
		'id' => 'by_text',
		'type' => 'text',
		'std' => 'Posted by'
	),

	array(
		'name' => 'Categories text',
		'id' => 'categories',
		'type' => 'text',
		'std' => 'Categories'
	),

	array(
		'name' => 'Monthly archive text',
		'id' => 'month_archive',
		'type' => 'text',
		'std' => 'Monthly archive'
	),

	array(
		'name' => 'Post list text',
		'id' => 'post_list',
		'type' => 'text',
		'std' => 'Post list'
	),

	array(
		'name' => 'Post tags text',
		'id' => 'post_tags',
		'type' => 'text',
		'std' => 'Post Tags'
	),

	array(
		'type' => 'close' ),

	/* ------------------------------------------------------------------------*
	 * COMMENTS TEXTS
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'comment'
	),


	array(
		'name' => 'No comments text',
		'id' => 'no_comments_text',
		'type' => 'text',
		'std' => 'No comments'
	),

	array(
		'name' => 'One comment text',
		'id' => 'one_comment_text',
		'type' => 'text',
		'std' => 'One comment'
	),

	array(
		'name' => 'Comments text',
		'id' => 'comments_text',
		'type' => 'text',
		'std' => 'comments'
	),

	array(
		'name' => 'Comment text',
		'id' => 'comment_text',
		'type' => 'text',
		'std' => 'comment'
	),

	array(
		'name' => 'Leave a comment text',
		'id' => 'leave_comment_text',
		'type' => 'text',
		'std' => 'Leave a comment'
	),



	array(
		'name' => 'Name text',
		'id' => 'comment_name_text',
		'type' => 'text',
		'std' => 'Name'
	),

	array(
		'name' => 'Email text',
		'id' => 'email_text',
		'type' => 'text',
		'std' => 'Email(will not be published)'
	),

	array(
		'name' => 'Website text',
		'id' => 'website_text',
		'type' => 'text',
		'std' => 'Website'
	),

	array(
		'name' => 'Your comment text',
		'id' => 'your_comment_text',
		'type' => 'text',
		'std' => 'Your comment'
	),

	array(
		'name' => 'Submit comment text',
		'id' => 'submit_comment_text',
		'type' => 'text',
		'std' => 'Submit Comment'
	),

	array(
		'name' => 'Reply to comment text',
		'id' => 'reply_text',
		'type' => 'text',
		'std' => 'Reply'
	),

	array(
		'name' => 'Leave a reply to text',
		'id' => 'leave_reply_to_text',
		'type' => 'text',
		'std' => 'Leave a reply to'
	),

	array(
		'name' => 'Cancel Reply',
		'id' => 'cancel_reply_text',
		'type' => 'text',
		'std' => 'Cancel Reply'
	),

	array(
		'type' => 'close' ),

	/* ------------------------------------------------------------------------*
	 * PORTFOLIO TEXTS
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'portfolio'
	),


	array(
		'name' => 'All text',
		'id' => 'all_text',
		'type' => 'text',
		'std' => 'All'
	),

	array(
		'name' => 'View gallery text',
		'id' => 'view_gallery_text',
		'type' => 'text',
		'std' => 'View Gallery'
	),

	array(
		'name' => 'Play video text',
		'id' => 'play_video_text',
		'type' => 'text',
		'std' => 'Play video'
	),

	array(
		'name' => 'Open text',
		'id' => 'open_text',
		'type' => 'text',
		'std' => 'Open'
	),


	array(
		'name' => 'Load more text',
		'id' => 'load_more_text',
		'type' => 'text',
		'std' => 'Load More'
	),

	array(
		'name' => 'Close text',
		'id' => 'close_text',
		'type' => 'text',
		'std' => 'Close'
	),

	array(
		'name' => 'Share text',
		'id' => 'share_text',
		'type' => 'text',
		'std' => 'Share'
	),

	array(
		'name' => 'Previous project text',
		'id' => 'prev_project_text',
		'type' => 'text',
		'std' => 'Prev Project'
	),

	array(
		'name' => 'Next project text',
		'id' => 'next_project_text',
		'type' => 'text',
		'std' => 'Next Project'
	),

	array(
		'name' => 'Back to gallery text',
		'id' => 'back_to_gallery_text',
		'type' => 'text',
		'std' => 'Back to gallery'
	),


	array(
		'name' => 'Toggle fullscreen text',
		'id' => 'fullscreen_text',
		'type' => 'text',
		'std' => 'Toggle Fullscreen'
	),


	array(
		'type' => 'close' ),

	/* ------------------------------------------------------------------------*
	 * SEARCH TEXTS
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'search'
	),


	array(
		'name' => 'Search box text',
		'id' => 'search_text',
		'type' => 'text',
		'std' => 'Search...'
	),

	array(
		'name' => 'Search results text',
		'id' => 'search_results_text',
		'type' => 'text',
		'std' => 'Search results for'
	),

	array(
		'name' => 'No results found text',
		'id' => 'no_results_text',
		'type' => 'text',
		'std' => 'No results found. Try a different search?'
	),

	array(
		'type' => 'close' ),

	/* ------------------------------------------------------------------------*
	 * CONTACT TEXTS
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'contact'
	),

	array(
		'name' => 'Name text',
		'id' => 'name_text',
		'type' => 'text',
		'std' => 'Name'
	),

	array(
		'name' => 'Your e-mail text',
		'id' => 'your_email_text',
		'type' => 'text',
		'std' => 'Your e-mail'
	),

	array(
		'name' => 'Your message text',
		'id' => 'question_text',
		'type' => 'text',
		'std' => 'Your message'
	),

	array(
		'name' => 'Send text',
		'id' => 'send_text',
		'type' => 'text',
		'std' => 'Send'
	),

	array(
		'name' => 'Message sent text',
		'id' => 'contact_message_sent_text',
		'type' => 'text',
		'std' => 'Message sent'
	),

	array(
		'name' => 'Validation error message',
		'id' => 'contact_validation_error_text',
		'type' => 'text',
		'std' => 'Please fill in all the fields correctly.'
	),

	array(
		'name' => 'Contact failure message',
		'id' => 'contact_fail_error_text',
		'type' => 'text',
		'std' => 'An error occurred. Message not sent.'
	),

	array(
		'name' => 'CAPTCHA text',
		'id' => 'captcha_text',
		'type' => 'text',
		'std' => 'Insert the text from the image'
	),

	array(
		'name' => 'Wrong CAPTCHA message',
		'id' => 'wrong_captcha_error_text',
		'type' => 'text',
		'std' => 'The text you have entered did not match the text on the image. 
		Please try again.'
	),

	array(
		'name' => 'Get a new challenge text',
		'id' => 'refresh_btn_text',
		'type' => 'text',
		'std' => 'Get a new challenge'
	),

	array(
		'type' => 'close' ),

	/* ------------------------------------------------------------------------*
	 * OTHER TEXTS
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'other'
	),

	array(
		'name' => 'Menu text',
		'id' => 'menu_text',
		'type' => 'text',
		'std' => 'Menu'
	),


	array(
		'name' => '404 Page not found text',
		'id' => '404_text',
		'type' => 'text',
		'std' => 'The requested page has not been found'
	),


	array(
		'type' => 'close' ),

	array(
		'type' => 'close' ) );

$pexeto->options->add_option_set( $pexeto_translation_options );
