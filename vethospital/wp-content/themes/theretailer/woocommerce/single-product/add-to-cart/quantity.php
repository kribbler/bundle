<?php
/**
 * Single product quantity inputs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
 
global $theretailer_theme_options;
 
?>

<?php if ( (!$theretailer_theme_options['catalog_mode']) || ($theretailer_theme_options['catalog_mode'] == 0) ) { ?>
<div class="quantity"><input name="<?php echo $input_name; ?>" data-min="<?php echo $min_value; ?>" data-max="<?php echo $max_value; ?>" value="<?php echo $input_value; ?>" size="4" title="Qty" class="input-text qty text" maxlength="12" /></div>
<?php } ?>