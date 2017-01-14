<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce;
global $theretailer_theme_options;

?>

<?php $woocommerce->show_messages(); ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>

<div class="gbtr_login_register_wrapper">
                    
    <div class="gbtr_login_register_slider">    
              
            <div class='gbtr_login_register_slide_1'>

                <form method="post" class="login">                    
                    <h2><?php _e("I'm a Returning Customer", "theretailer"); ?></h2>
                
                    <p class="form-row">
                        <label for="username"><?php _e('Username or email', 'woocommerce'); ?> <span class="required">*</span></label>
                        <input type="text" class="input-text" name="username" id="username" />
                    </p>
                    <p class="form-row">
                        <label for="password"><?php _e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
                        <input class="input-text" type="password" name="password" id="password" />
                    </p>
                    <div class="clear"></div>
                
                    <p class="form-row">
                        <?php $woocommerce->nonce_field('login', 'login') ?>
                        <a class="lost_password" href="<?php echo esc_url( wp_lostpassword_url( home_url() ) ); ?>"><?php _e('Lost Password?', 'woocommerce'); ?></a>
                        <input type="submit" class="button" name="login" value="<?php _e('Login', 'woocommerce'); ?>" />
                        <input type="hidden" name="gbtr_login_register_section_name" value="login" />
                    </p>
                </form>
            
            </div>

			<?php if (get_option('woocommerce_enable_myaccount_registration')=='yes') : ?>
    
            <div class='gbtr_login_register_slide_2'>
            
                <form method="post" class="register">
                
                    <h2><?php _e('Register', 'woocommerce'); ?></h2>
                
                    <?php if ( get_option( 'woocommerce_registration_email_for_username' ) == 'no' ) : ?>
                
                        <p class="form-row">
                            <label for="reg_username"><?php _e('Username', 'woocommerce'); ?> <span class="required">*</span></label>
                            <input type="text" class="input-text" name="username" id="reg_username" value="<?php if (isset($_POST['username'])) echo esc_attr($_POST['username']); ?>" />
                        </p>
                
                        <p class="form-row">
                
                    <?php else : ?>
                
                        <p class="form-row">
                
                    <?php endif; ?>
                
                        <label for="reg_email"><?php _e('Email', 'woocommerce'); ?> <span class="required">*</span></label>
                        <input type="email" class="input-text" name="email" id="reg_email" value="<?php if (isset($_POST['email'])) echo esc_attr($_POST['email']); ?>" />
                    </p>
                
                    <div class="clear"></div>
                
                    <p class="form-row">
                        <label for="reg_password"><?php _e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
                        <input type="password" class="input-text" name="password" id="reg_password" value="<?php if (isset($_POST['password'])) echo esc_attr($_POST['password']); ?>" />
                    </p>
                    <p class="form-row">
                        <label for="reg_password2"><?php _e('Re-enter password', 'woocommerce'); ?> <span class="required">*</span></label>
                        <input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if (isset($_POST['password2'])) echo esc_attr($_POST['password2']); ?>" />
                    </p>
                    <div class="clear"></div>
                
                    <!-- Spam Trap -->
                    <div style="left:-999em; position:absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" /></div>
                
                    <?php do_action( 'register_form' ); ?>
                
                    <p class="form-row">
                        <?php $woocommerce->nonce_field('register', 'register') ?>
                        <input type="submit" class="button" name="register" value="<?php _e('Register', 'woocommerce'); ?>" />
                        <input type="hidden" name="gbtr_login_register_section_name" value="register" />
                    </p>
                
                </form>
            
            </div>

            <?php endif; ?>
            
            <div class="clr"></div>
             
        </div>
        
                                                         
    
</div>

<div class="gbtr_login_register_switch">
    <div class="gbtr_login_register_label_slider">
        <div class="gbtr_login_register_reg">
        	<h2><?php _e('Register', 'woocommerce'); ?></h2>
            <?php echo $theretailer_theme_options['registration_content']; ?>
            <input type="submit" class="button" name="create_account" value="<?php _e('Register', 'woocommerce'); ?>">
        </div>
        <div class="gbtr_login_register_log">
        	<h2><?php _e("I'm a Returning Customer", "theretailer"); ?></h2>
            <?php echo $theretailer_theme_options['login_content']; ?>
            <input type="submit" class="button" name="create_account" value="<?php _e('Login', 'woocommerce'); ?>">
        </div>
    </div>
</div>

<style>
.theme_options_lang {
	display:none;
}
</style>

<?php
if ( defined('ICL_LANGUAGE_CODE')) {
	$lang_active = ICL_LANGUAGE_CODE;
?>

<style>
.theme_options_lang.<?php echo $lang_active; ?> {
	display:block;
}
</style>

<?php
} else {
?>

<style>
.theme_options_lang.en {
	display:block;
}
</style>

<?php } ?>

<div class="clr"></div>

<?php do_action('woocommerce_after_customer_login_form'); ?>

<?php if ( isset($_POST["gbtr_login_register_section_name"]) && $_POST["gbtr_login_register_section_name"] == "register") { ?>

<script type="text/javascript">
<!--//--><![CDATA[//><!--
jQuery(document).ready(function($) {
	 $('.gbtr_login_register_slider').animate({
		left: '-500',
	 }, 0, function() {
		// Animation complete.
	 });
	 
	 $('.gbtr_login_register_wrapper').animate({
		height: $('.gbtr_login_register_slide_2').height() + 100
	 }, 0, function() {
		// Animation complete.
	 });
	 
	 $('.gbtr_login_register_label_slider').animate({
		top: '-500',
	 }, 0, function() {
		// Animation complete.
	 });
});
//--><!]]>
</script>

<?php } ?>