<script type="text/javascript">
	jQuery(document).ready(function($){

		// Set variables
		var $image_slideshow_ids = $('#slideshow_images');
		var $slideshow_images = $('#qns_slideshow_wrapper .slideshow_images');

		// Make images sortable
		$slideshow_images.sortable({
			cursor: 'move',
			items: '.image',
			update: function(event, ui) {
				var attachment_ids = '';
				$('#qns_slideshow_wrapper ul .image').css('cursor','default').each(function() {
					var attachment_id = jQuery(this).attr( 'data-attachment_id' );
					attachment_ids = attachment_ids + attachment_id + ',';
				});
				$image_slideshow_ids.val( attachment_ids );				
			}
		});

		// Uploading files
		var slideshow_frame;

		jQuery('.add_slideshow_images').live('click', function( event ){

			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( slideshow_frame ) {
				slideshow_frame.open();
				return;
			}

			// Create the media frame.
			slideshow_frame = wp.media.frames.downloadable_file = wp.media({

				// Set the title of the modal.
				title: '<?php _e( 'Add Images to Slideshow', 'quitenicebooking' ); ?>',

				// Set the button of the modal.
				button: {
					text: '<?php _e( 'Add to slideshow', 'quitenicebooking' ); ?>',
				},

				// Set to true to allow multiple files to be selected
				multiple: true

			});

			var $el = $(this);
			var attachment_ids = $image_slideshow_ids.val();

			// When an image is selected, run a callback.
			slideshow_frame.on( 'select', function() {
				var selection = slideshow_frame.state().get('selection');
				selection.map( function( attachment ) {
					attachment = attachment.toJSON();
					if ( attachment.id ) {
						attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;
						$slideshow_images.append('\
							<li class="image" data-attachment_id="' + attachment.id + '">\
								<img src="' + attachment.url + '" />\
								<span><a href="#" class="delete_slide" title="<?php _e( 'Delete image', 'quitenicebooking' ); ?>"><?php _e( 'Delete', 'quitenicebooking' ); ?></a></span>\
							</li>');
					}
				} );
				$image_slideshow_ids.val( attachment_ids );
			});

			// Finally, open the modal
			slideshow_frame.open();

		});

		// Remove files
		$('#qns_slideshow_wrapper').on( 'click', 'a.delete_slide', function() {

			$(this).closest('.image').remove();
			var attachment_ids = '';

			$('#qns_slideshow_wrapper ul .image').css('cursor','default').each(function() {
				var attachment_id = jQuery(this).attr( 'data-attachment_id' );
				attachment_ids = attachment_ids + attachment_id + ',';
			});

			$image_slideshow_ids.val( attachment_ids );
			return false;

		} );

	});
</script>

<div id="qns_slideshow_wrapper">
	<ul class="slideshow_images clearfix">
		<?php
			if (metadata_exists('post', $post->ID, '_slideshow_images')) {
				$slideshow_images = get_post_meta($post->ID,'_slideshow_images', TRUE);
			} else {
				$attachment_ids = array_filter(array_diff(get_posts('post_parent='.$post->ID.'&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids'), array(get_post_thumbnail_id())));
				$slideshow_images = implode(',', $attachment_ids);
			}

			$attachments = array_filter(explode(',', $slideshow_images));

			if ($attachments) {
				foreach ($attachments as $attachment_id) {
					echo '<li class="image" data-attachment_id="'.$attachment_id.'">'.wp_get_attachment_image($attachment_id, 'image1').'<span><a href="#" class="delete_slide" title="'.__( 'Delete image', 'quitenicebooking').'">'.__('Delete', 'quitenicebooking').'</a></span></li>';
				}
			}
		?>
	</ul>
	<input type="hidden" id="slideshow_images" name="slideshow_images" value="<?php echo esc_attr( $slideshow_images ); ?>" />
</div>

<p class="add_images_wrapper hide-if-no-js">
	<a href="#" class="add_slideshow_images"><?php _e( 'Add slideshow images', 'quitenicebooking' ); ?></a>
</p>
