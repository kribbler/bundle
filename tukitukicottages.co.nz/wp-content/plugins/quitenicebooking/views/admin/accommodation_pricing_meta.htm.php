<div id="validation_errors" class="error"></div>

<div class="field-wrapper field-padding clearfix">
	<div class="one-fifth empty-label"></div>
	
	<?php foreach ($quitenicebooking_prices->keys['prices'] as $key) { ?>
	<div class="one-fifth">
		<label><?php echo $key['description']; ?></label>
	</div>
	<?php } ?>
</div>


<?php foreach ($quitenicebooking_prices->entity_scheme->keys as $entity_key) { // rows ?>
<div id="<?php echo 'quitenicebooking_price_per'.$entity_key['meta_part']; ?>" class="field-wrapper field-padding-below clearfix">

	<div class="one-fifth"><?php echo $entity_key['description'].' ('.$this->settings['currency_unit'].')'; ?></div>
	
	<?php foreach ($quitenicebooking_prices->keys['prices'] as $price_key) { ?>
	<div class="one-fifth">
		<input type="text" name="<?php echo 'quitenicebooking_price_per_'.$entity_key['meta_part'].'_'.$price_key['meta_part']; ?>" id="<?php echo 'quitenicebooking_price_per_'.$entity_key['meta_part'].'_'.$price_key['meta_part']; ?>" value="<?php echo isset(${'quitenicebooking_price_per_'.$entity_key['meta_part'].'_'.$price_key['meta_part']}) ? ${'quitenicebooking_price_per_'.$entity_key['meta_part'].'_'.$price_key['meta_part']} : ''; ?>" class="full-width">
	</div>
	<?php } ?>	

</div>
<?php } ?>
