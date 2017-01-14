<script type="text/javascript">
	function showProgress() {
		window.scrollTo(0,0);
		document.getElementById('progress').style.display = 'block';
		document.getElementById('content').style.display = 'none';
		document.getElementById('support-donate_rate').style.display = 'none';
	}
</script>

<div id="content">

	<h2 class="nav-tab-wrapper">
		<a data-tab-id="overview" class="nav-tab<?php woo_st_admin_active_tab( 'overview' ); ?>" href="<?php echo add_query_arg( array( 'page' => 'woo_st', 'tab' => 'overview' ), 'admin.php' ); ?>"><?php _e( 'Overview', 'woo_st' ); ?></a>
		<a data-tab-id="nuke" class="nav-tab<?php woo_st_admin_active_tab( 'nuke' ); ?>" href="<?php echo add_query_arg( array( 'page' => 'woo_st', 'tab' => 'nuke' ), 'admin.php' ); ?>"><?php _e( 'Nuke', 'woo_st' ); ?></a>
	</h2>
	<?php woo_st_tab_template( $tab ); ?>

</div>
<!-- #content -->

<div id="progress" style="display:none;">
	<p><?php _e( 'Chosen WooCommerce details are being nuked, this process can take awhile. Time for a beer?', 'woo_st' ); ?></p>
	<img src="<?php echo plugins_url( '/templates/admin/images/progress.gif', WOO_ST_RELPATH ); ?>" alt="" />
</div>
<!-- #progress -->