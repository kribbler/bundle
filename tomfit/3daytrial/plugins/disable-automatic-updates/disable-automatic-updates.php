<?php
/*
Plugin Name: Disable Automatic Updates
Plugin URI: http://onetarek.com/my-wordpress-plugins/disable-automatic-updates
Description: This plugin let you enable or disable automatic updates features in WordPress 3.7+ which is enabled by default. You are able to control automatic core, plugin, themes, translation updates and vcs check. You can set permisson to send you email after any type of core updates. 
Version: 2.0.0
Author: oneTarek
Author URI: http://www.onetarek.com
License: GPLv2
*/


function disau_get_options()
{
			
			$defaults = array(
			'automatic_update'	=> 1, #automatic updates active by default
			'core'				=> 1,
			'core_dev'			=>0,
			'core_minor'		=>1, #active by default
			'core_major'		=>0,
			'plugin'			=> 0,
			'theme'				=> 0,
			'translation'		=> 1,
			'vcscheck'			=> 1,
			'successemail'		=> 1,
			'failureemail'		=> 1,
			'criticalemail'		=> 1,
			'debugemail'		=> 0
		);
		return get_option( 'disable_automatic_update_options', $defaults );

}
add_action( 'init', 'disau_set_upgrade_filters');

function disau_set_upgrade_filters()
{
	$options=disau_get_options();
		if ($options['automatic_update']==0) {
		
			add_filter( 'auto_upgrader_disabled', '__return_true', 1 );
			
		} else {

			if ( $options['core']==1) 
			{
				if ( $options['core_dev']==1) {add_filter( 'allow_dev_auto_core_updates', '__return_true', 1 );}else{add_filter( 'allow_dev_auto_core_updates', '__return_false', 1 );}
				if ( $options['core_minor']==1) {add_filter( 'allow_minor_auto_core_updates', '__return_true', 1 );}else{add_filter( 'allow_minor_auto_core_updates', '__return_false', 1 );}
				if ( $options['core_major']==1) {add_filter( 'allow_major_auto_core_updates', '__return_true', 1 );}else{add_filter( 'allow_major_auto_core_updates', '__return_false', 1 );}
			}
			else
			{
				add_filter( 'auto_update_core', '__return_false' );
			}

			if ( $options['plugin'] ){add_filter( 'auto_update_plugin', '__return_true', 1 );}else{add_filter( 'auto_update_plugin', '__return_false', 1 );}

			if ( $options['theme'] ){add_filter( 'auto_update_theme', '__return_true', 1 );}else{add_filter( 'auto_update_theme', '__return_false', 1 );}

			if ( $options['translation'] ){add_filter( 'auto_update_translation', '__return_true', 1 );}else{add_filter( 'auto_update_translation', '__return_false', 1 );}

			if ( $options['vcscheck'] ){add_filter( 'automatic_updates_is_vcs_checkout', '__return_true', 1 );}else{add_filter( 'automatic_updates_is_vcs_checkout', '__return_false', 1 );}
		
			add_filter( 'auto_core_update_send_email', 'disau_core_update_email_filter', 1, 2 );


			if ( $options['debugemail'] ){	add_filter( 'automatic_updates_send_debug_email ', '__return_true', 1 );}elseif ( $options['debugemail'] ){	add_filter( 'automatic_updates_send_debug_email ', '__return_false', 1 );}

		}


}#end of function ....filter()

 function disau_core_update_email_filter( $bool_value, $type ) {
		$options = disau_get_options();

		if ('success' == $type && ! $options['successemail'] )
			return false;

		if ('fail' == $type && ! $options['failureemail'] )
			return false;

		if ('critical' == $type && ! $options['criticalemail'] )
			return false;

		return $bool_value;
	}





function disau_option_page()
{

if(isset($_POST['save']))
{
	$new_options=array();
	$new_options['automatic_update']=intval($_POST['automatic_update']);
	$new_options['core']=intval($_POST['core']);
	$new_options['core_dev']=intval($_POST['core_dev']);
	$new_options['core_minor']=intval($_POST['core_minor']);
	$new_options['core_major']=intval($_POST['core_major']);
	$new_options['plugin']=intval($_POST['plugin']);
	$new_options['theme']=intval($_POST['theme']);
	$new_options['translation']=intval($_POST['translation']);
	$new_options['vcscheck']=intval($_POST['vcscheck']);
	$new_options['emailactive']=intval($_POST['emailactive']);
	$new_options['successemail']=intval($_POST['successemail']);
	$new_options['failureemail']=intval($_POST['failureemail']);
	$new_options['criticalemail']=intval($_POST['criticalemail']);
	$new_options['debugemail']=intval($_POST['debugemail']);
	update_option('disable_automatic_update_options', $new_options);
}


$disau_options=disau_get_options();
?>
	<script type="text/javascript">
		function show_all_other_options()
		{
		   document.getElementById("all_other_options").style.display="block";
		}
		function hide_all_other_options()
		{
		   document.getElementById("all_other_options").style.display="none";
		}

		function show_core_update_options()
		{
		   document.getElementById("core_update_options").style.display="block";
		}
		function hide_core_update_options()
		{
		   document.getElementById("core_update_options").style.display="none";
		}
				
	</script>
	<div style="width: 800px; padding-left: 10px;" class="wrap">
		<div id="icon-options-general" class="icon32"></div><h2>Disable Automatic Updates Options</h2>
		<form action="" method="post">
		<table class="form-table widefat">
			<thead>
				<tr><th style="width:100px">&nbsp;</th><th>&nbsp;</th></tr>
			</thead>
			<tr>
				<td style="width:100px">Automatic Updates</td>
				<td>
				<input type="radio" name="automatic_update" value="1" id="au_enable" <?php echo ($disau_options['automatic_update'])?' checked="checked"':"";?> onclick="show_all_other_options()" />&nbsp;<label for="au_enable">Enable</label>&nbsp;&nbsp;
				<input type="radio" name="automatic_update" value="0" id="au_disable" <?php echo ($disau_options['automatic_update'])?"":' checked="checked"';?> onclick="hide_all_other_options()" />&nbsp;<label for="au_disable">Disable</label>
				</td>
			</tr>
		</table>
	  <table class="form-table widefat" width="100%" id="all_other_options" style=" <?php echo ($disau_options['automatic_update']!=1)?' display:none':'' ?>">			

			<tr>
				<td style="width:170px">Automatic Core Updates</td>
				<td>
				<input type="radio" name="core" value="1" id="core_enable" <?php echo ($disau_options['core'])?' checked="checked"':"";?> onclick="show_core_update_options()" />&nbsp;<label for="core_enable">Enable</label>&nbsp;&nbsp;
				<input type="radio" name="core" value="0" id="core_disable" <?php echo ($disau_options['core'])?"":' checked="checked"';?> onclick="hide_core_update_options()" />&nbsp;<label for="core_disable">Disable</label>
				<div id="core_update_options"  style=" <?php echo ($disau_options['core']!=1)?' display:none':'' ?>">
				<input type="checkbox" name="core_dev" id="core_dev" value="1" <?php echo ($disau_options['core_dev'])?' checked="checked"':"";?>   />&nbsp;<label for="core_dev">Core development updates, known as the "bleeding edge"</label><br />
				<input type="checkbox" name="core_minor" id="core_minor" value="1" <?php echo ($disau_options['core_minor'])?' checked="checked"':"";?>   />&nbsp;<label for="core_minor">Minor core updates, such as maintenance and security releases</label><br />
				<input type="checkbox" name="core_major" id="core_major" value="1" <?php echo ($disau_options['core_major'])?' checked="checked"':"";?>   />&nbsp;<label for="core_major">Major core release updates</label><br />				
				</div>
				
				
				</td>
			</tr>

			<tr>
				<td>Automatic Plugin Updates</td>
				<td>
				<input type="radio" name="plugin" value="1" id="plugin_enable" <?php echo ($disau_options['plugin'])?' checked="checked"':"";?> />&nbsp;<label for="plugin_enable">Enable</label>&nbsp;&nbsp;
				<input type="radio" name="plugin" value="0" id="plugin_disable" <?php echo ($disau_options['plugin'])?"":' checked="checked"';?> />&nbsp;<label for="plugin_disable">Disable</label>
				</td>
			</tr>
			<tr>
				<td>Automatic Theme Updates</td>
				<td>
				<input type="radio" name="theme" value="1" id="theme_enable" <?php echo ($disau_options['theme'])?' checked="checked"':"";?> />&nbsp;<label for="theme_enable">Enable</label>&nbsp;&nbsp;
				<input type="radio" name="theme" value="0" id="theme_disable" <?php echo ($disau_options['theme'])?"":' checked="checked"';?> />&nbsp;<label for="theme_disable">Disable</label>
				</td>
			</tr>			

			<tr>
				<td>Automatic Translation  Updates</td>
				<td>
				<input type="radio" name="translation" value="1" id="translation_enable" <?php echo ($disau_options['translation'])?' checked="checked"':"";?> />&nbsp;<label for="translation_enable">Enable</label>&nbsp;&nbsp;
				<input type="radio" name="translation" value="0" id="translation_disable" <?php echo ($disau_options['translation'])?"":' checked="checked"';?> />&nbsp;<label for="translation_disable">Disable</label>
				</td>
			</tr>
			<tr><td colspan="2"><strong>Advance Settings</strong></td></tr>
			<tr>
				<td>VCS Check</td>
				<td>
				<input type="radio" name="vcscheck" value="1" id="vcscheck_enable" <?php echo ($disau_options['vcscheck'])?' checked="checked"':"";?> />&nbsp;<label for="vcscheck_enable">Enable</label>&nbsp;&nbsp;
				<input type="radio" name="vcscheck" value="0" id="vcscheck_disable" <?php echo ($disau_options['vcscheck'])?"":' checked="checked"';?> />&nbsp;<label for="vcscheck_disable">Disable</label>
				</td>
			</tr>

			<tr>
				<td>Send Emails for </td>
				<td>
				<input type="checkbox" name="successemail" id="successemail" value="1" <?php echo ($disau_options['successemail'])?' checked="checked"':"";?>   />&nbsp;<label for="successemail">Successful Updates</label><br />
				<input type="checkbox" name="failureemail" id="failureemail" value="1" <?php echo ($disau_options['failureemail'])?' checked="checked"':"";?>   />&nbsp;<label for="failureemail">Failed Updates</label><br />
				<input type="checkbox" name="criticalemail" id="criticalemail" value="1" <?php echo ($disau_options['criticalemail'])?' checked="checked"':"";?>   />&nbsp;<label for="criticalemail">Critically Failed Updates</label><br />
				<input type="checkbox" name="debugemail" id="debugemail" value="1" <?php echo ($disau_options['debugemail'])?' checked="checked"':"";?>   />&nbsp;<label for="debugemail">Update Debug</label>
				</td>
			</tr>
			
		</table>

		<table class="form-table widefat" width="100%">
			<tr><td colspan="2"><input type="submit" class="button-primary" name="save" value="Save Change" /></td></tr>
		</table>
		</form>		
	</div>
<?php 
}

function add_disau_menu_pages()

{
add_options_page( "Disable Automatic Updates", "Disable Automatic Updates" ,'manage_options', 'disable_automatic_updates', 'disau_option_page');
}

add_action('admin_menu', 'add_disau_menu_pages'); 



?>