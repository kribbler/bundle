<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	
	<div class="clearboth"></div>

	<?php if(is_plugin_active('wp-pagenavi/wp-pagenavi.php')) {
		wp_pagenavi();
		echo '<div class="clearboth"></div>';
	} else { ?>
		
	<div class="pagination-wrapper">
		<p class="clearfix">
			<span class="fl prev-pagination"><?php next_posts_link( __( '&larr; Older posts', 'qns' ) ); ?></span>
			<span class="fr next-pagination"><?php previous_posts_link( __( 'Newer posts &rarr;', 'qns' ) ); ?></span>
		</p>
	</div>
		
	<?php } ?>

<?php endif; ?>