<?php

global $woocommerce;

if (is_user_logged_in()) return;
?>
<form method="post" class="gbtr_checkout_login">
	<?php if ($message) echo wpautop(wptexturize($message)); ?>

	<p class="form-row">
		<input type="text" class="input-text" name="username" id="username" placeholder="<?php _e('Username or email', 'woocommerce'); ?>" />
	</p>
	
    <p class="form-row">
		<input class="input-text" type="password" name="password" id="password" placeholder="<?php _e('Password', 'woocommerce'); ?>" />
	</p>
	
    <div class="clear"></div>

	<p class="form-row">
		<?php $woocommerce->nonce_field('login', 'login') ?>
		<input type="submit" class="button_checkout_login button" name="login" value="<?php _e('Login', 'woocommerce'); ?> &raquo;" />
		<a class="lost_password" href="<?php echo esc_url( wp_lostpassword_url( home_url() ) ); ?>"><?php _e('Lost Password?', 'woocommerce'); ?></a>
        <input type="hidden" name="redirect" value="<?php echo $redirect ?>" />
	</p>

	<div class="clear"></div>
</form>