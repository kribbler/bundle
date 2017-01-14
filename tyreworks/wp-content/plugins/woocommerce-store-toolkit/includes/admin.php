<?php
// Display admin notice on screen load
function woo_st_admin_notice( $message = '', $priority = 'updated', $screen = '' ) {

	if( $priority == false || $priority == '' )
		$priority = 'updated';
	if( $message <> '' ) {
		ob_start();
		woo_st_admin_notice_html( $message, $priority, $screen );
		$output = ob_get_contents();
		ob_end_clean();
		// Check if an existing notice is already in queue
		$existing_notice = get_transient( WOO_ST_PREFIX . '_notice' );
		if( $existing_notice !== false ) {
			$existing_notice = base64_decode( $existing_notice );
			$output = $existing_notice . $output;
		}
		set_transient( WOO_ST_PREFIX . '_notice', base64_encode( $output ), MINUTE_IN_SECONDS );
		add_action( 'admin_notices', 'woo_st_admin_notice_print' );
	}

}

// HTML template for admin notice
function woo_st_admin_notice_html( $message = '', $priority = 'updated', $screen = '' ) {

	// Display admin notice on specific screen
	if( !empty( $screen ) ) {

		global $pagenow;

		if( is_array( $screen ) ) {
			if( in_array( $pagenow, $screen ) == false )
				return;
		} else {
			if( $pagenow <> $screen )
				return;
		}

	} ?>
<div id="message" class="<?php echo $priority; ?>">
	<p><?php echo $message; ?></p>
</div>
<?php

}

// Grabs the WordPress transient that holds the admin notice and prints it
function woo_st_admin_notice_print() {

	$output = get_transient( WOO_ST_PREFIX . '_notice' );
	if( $output !== false ) {
		$output = base64_decode( $output );
		echo $output;
		delete_transient( WOO_ST_PREFIX . '_notice' );
	
	}

}

// Add Store Toolkit, Docs links to the Plugins screen
function woo_st_add_settings_link( $links, $file ) {

	$this_plugin = plugin_basename( WOO_ST_RELPATH );
	if( $file == $this_plugin ) {
		$docs_url = 'http://www.visser.com.au/docs/';
		$docs_link = sprintf( '<a href="%s" target="_blank">' . __( 'Docs', 'woo_st' ) . '</a>', $docs_url );
		$settings_link = sprintf( '<a href="%s">' . __( 'Settings', 'woo_st' ) . '</a>', add_query_arg( 'page', 'woo_st', 'admin.php' ) );
		array_unshift( $links, $docs_link );
		array_unshift( $links, $settings_link );
	}
	return $links;

}
add_filter( 'plugin_action_links', 'woo_st_add_settings_link', 10, 2 );

// Load CSS and jQuery scripts for Store Toolkit screen
function woo_st_enqueue_scripts( $hook ) {

	// Simple check that WooCommerce is activated
	if( class_exists( 'WooCommerce' ) ) {

		global $woocommerce;

		wp_enqueue_style( 'woocommerce_admin_styles', $woocommerce->plugin_url() . '/assets/css/admin.css' );

	}

	// Settings
	$pages = array( 'woocommerce_page_woo_st', 'edit-tags.php', 'user-edit.php', 'profile.php' );
	if( in_array( $hook, $pages ) ) {
		wp_enqueue_style( 'woo_st_styles', plugins_url( '/templates/admin/toolkit.css', WOO_ST_RELPATH ) );
		wp_enqueue_script( 'woo_st_scripts', plugins_url( '/templates/admin/toolkit.js', WOO_ST_RELPATH ), array( 'jquery' ) );
	}

}
add_action( 'admin_enqueue_scripts', 'woo_st_enqueue_scripts' );

// HTML active class for the currently selected tab on the Store Toolkit screen
function woo_st_admin_active_tab( $tab_name = null, $tab = null ) {

	if( isset( $_GET['tab'] ) && !$tab )
		$tab = $_GET['tab'];
	else
		$tab = 'overview';

	$output = '';
	if( isset( $tab_name ) && $tab_name ) {
		if( $tab_name == $tab )
			$output = ' nav-tab-active';
	}
	echo $output;

}

// HTML template for each tab on the Store Toolkit screen
function woo_st_tab_template( $tab = '' ) {

	if( !$tab )
		$tab = 'overview';

	switch( $tab ) {

		case 'nuke':
			$products = woo_st_return_count( 'products' );
			$images = woo_st_return_count( 'product_images' );
			$tags = woo_st_return_count( 'tags' );
			$categories = woo_st_return_count( 'categories' );
			if( $categories ) {
				$term_taxonomy = 'product_cat';
				$args = array(
					'hide_empty' => 0
				);
				$categories_data = get_terms( $term_taxonomy, $args );
			}
			$orders = woo_st_return_count( 'orders' );
			if( $orders ) {
				// Check if this is a WooCommerce 2.2+ instance
				$woocommerce_version = woo_get_woo_version();
				$orders_data = false;
				if( version_compare( $woocommerce_version, '2.2', '<' ) ) {
					$term_taxonomy = 'shop_order_status';
					$args = array(
						'hide_empty' => 0
					);
					$orders_data = get_terms( $term_taxonomy, $args );
				}
			}
			$tax_rates = woo_st_return_count( 'tax_rates' );
			$download_permissions = woo_st_return_count( 'download_permissions' );
			$coupons = woo_st_return_count( 'coupons' );
			$attributes = woo_st_return_count( 'attributes' );

			$brands = woo_st_return_count( 'brands' );
			$vendors = woo_st_return_count( 'vendors' );
			$credit_cards = woo_st_return_count( 'credit-cards' );

			$posts = woo_st_return_count( 'posts' );
			$post_categories = woo_st_return_count( 'post_categories' );
			$post_tags = woo_st_return_count( 'post_tags' );
			$links = woo_st_return_count( 'links' );
			$comments = woo_st_return_count( 'comments' );
			$media_images = woo_st_return_count( 'media_images' );

			$show_table = false;
			if( $products || $images || $tags || $categories || $orders || $credit_cards || $attributes )
				$show_table = true;
			break;

	}
	if( $tab ) {
		if( file_exists( WOO_ST_PATH . 'templates/admin/tabs-' . $tab . '.php' ) ) {
			include_once( WOO_ST_PATH . 'templates/admin/tabs-' . $tab . '.php' );
		} else {
			$message = sprintf( __( 'We couldn\'t load the export template file <code>%s</code> within <code>%s</code>, this file should be present.', 'woo_st' ), 'tabs-' . $tab . '.php', WOO_CD_PATH . 'templates/admin/...' );
			woo_st_admin_notice_html( $message, 'error' );
			ob_start(); ?>
<p><?php _e( 'You can see this error for one of a few common reasons', 'woo_st' ); ?>:</p>
<ul class="ul-disc">
	<li><?php _e( 'WordPress was unable to create this file when the Plugin was installed or updated', 'woo_st' ); ?></li>
	<li><?php _e( 'The Plugin files have been recently changed and there has been a file conflict', 'woo_st' ); ?></li>
	<li><?php _e( 'The Plugin file has been locked and cannot be opened by WordPress', 'woo_st' ); ?></li>
</ul>
<p><?php _e( 'Jump onto our website and download a fresh copy of this Plugin as it might be enough to fix this issue. If this persists get in touch with us.', 'woo_st' ); ?></p>
<?php
			ob_end_flush();
		}
	}

}
?>