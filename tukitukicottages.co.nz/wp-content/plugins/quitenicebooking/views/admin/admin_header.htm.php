<div id="icon-options-general" class="icon32"><br /></div>
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab <?php echo $get['tab'] == 'general' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url('admin.php?page=quitenicebooking_settings&tab=general'); ?>"><?php _e('General', 'quitenicebooking'); ?></a>
		<a class="nav-tab <?php echo $get['tab'] == 'pages' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url('admin.php?page=quitenicebooking_settings&tab=pages'); ?>"><?php _e('Pages', 'quitenicebooking'); ?></a>
		<?php if (has_action('quitenicebooking_settings_forms_tab')) { do_action('quitenicebooking_settings_forms_tab'); } ?>
		<a class="nav-tab <?php echo $get['tab'] == 'payment' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url('admin.php?page=quitenicebooking_settings&tab=payment'); ?>"><?php _e('Payment', 'quitenicebooking'); ?></a>
		<a class="nav-tab <?php echo $get['tab'] == 'messages' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url('admin.php?page=quitenicebooking_settings&tab=messages'); ?>"><?php _e('Messages', 'quitenicebooking'); ?></a>
		<a class="nav-tab <?php echo $get['tab'] == 'email' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url('admin.php?page=quitenicebooking_settings&tab=email'); ?>"><?php _e('Email', 'quitenicebooking'); ?></a>
		<a class="nav-tab <?php echo $get['tab'] == 'maintenance' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url('admin.php?page=quitenicebooking_settings&tab=maintenance'); ?>"><?php _e('Maintenance', 'quitenicebooking'); ?></a>
	</h2>
