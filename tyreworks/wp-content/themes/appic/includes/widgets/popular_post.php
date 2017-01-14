<?php

add_action('widgets_init', 'popular_post_load_widgets');

function popular_post_load_widgets()
{
	register_widget('Popular_Post_Widget');
}

class Popular_Post_Widget extends WP_Widget
{
	public function __construct()
	{
		parent::__construct(
			'popular-post-widget', //widget ID
			'Appic: ' . __('Popular Post', 'appic'),
			array(
				//'description' => '',
			) //Options
		);
	}

	public function form($instance)
	{
		$defaults = array(
			'title' => __('Most Popular Post', 'appic'),
			'number' => 1
		);
		$instance = wp_parse_args ((array) $instance, $defaults);

		$output = '<p>' .
				'<label for="' . $this->get_field_id('title') .'">' . __('Title', 'appic') . ':</label><br>' .
				'<input type="text" class="widefat" style="width: 100%;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" value="' . $instance['title'] . '" />' .
			'</p>' .
			'<p>' .
				'<label for="' . $this->get_field_id('number') . '">' . __('Number', 'appic') . ':</label><br>' .
				'<input type="number" class="widefat" style="width: 100%;" id="' . $this->get_field_id('number') . '" name="' . $this->get_field_name('number') . '" value="' . $instance['number'] . '" />' .
			'</p>';
		echo $output;
	}

	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['number'] = $new_instance['number'];
		return $instance;
	}

	public function widget ($args, $instance)
	{
		//extract($args);
		extract($instance);

		$popularPosts = new Wp_Query('orderby=comment_count&posts_per_page=' . ($number > 0 ? $number : 1));

		if (! $popularPosts->have_posts() ) {
			return;
		}

		echo '<div class="popular-post">' . 
			'<div class="page-elements-title-wrap horizontal-blue-lines text-center">' .
				'<h3 class="page-elements-title page-title-position blue-text">' . esc_html($title) . '</h3>' .
			'</div>';

		$dateFormat = get_option('date_format');
		while ($popularPosts->have_posts()) {
			$popularPosts->the_post();
			$postTitle = get_the_title();
			$postPermalinkEscaped = esc_attr(get_permalink());
			$postTitleEscaped = esc_html($postTitle);

			echo '<p class="text-center simple-text-12 light-grey-text">' . get_the_time( $dateFormat ) . '</p>';

			if ( has_post_thumbnail() ) {
				$thumb = get_the_post_thumbnail(get_the_id());
				
				if(empty($thumb)){
					$thumbUrl = "http://placehold.it/280x140";
				}else{
					$attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()), 'full' );
					$thumbUrl = aq_resize($attachment_url['0'], 280, 140, true);
				}
				echo '<div class="image-wrap text-center">' .
					'<img src="' . $thumbUrl . '" alt="' . esc_attr($postTitle) .'">' .
					'<a class="mask" href="' . $postPermalinkEscaped . '"></a>' .
				'</div>';
			}
			echo '<p class="simple-text-16"><a class="link" href="'.$postPermalinkEscaped.'">'.$postTitleEscaped.'</a><a href="'.$postPermalinkEscaped.'" class="link-icon-arrow link-position"></a></p>';
		}
		echo '</div>';

		wp_reset_postdata();
	}
}
