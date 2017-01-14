<style>
	div.price_filter {
		border: 1px solid #dfdfdf;
		border-radius: 2px;
		margin: 15px;
	}
</style>
<div class="field-wrapper field-padding-above clearfix">
	<p class="description"><?php _e('Price filters will be applied from top to bottom (prices below will override the ones above if their date ranges overlap). Drag the price filter boxes to rearrange them', 'quitenicebooking'); ?></p>
</div>
<div id="dynamic_add_price_filter">
<?php for ($i = 1; $i <= $quitenicebooking_num_price_filters; $i ++) {  ?>
<div class="price_filter" id="<?php echo "price_filter_{$i}"; ?>">
<h3><?php printf(__('Filter %d', 'quitenicebooking'), $i); ?></h3>
<div class="field-wrapper field-padding clearfix">

	<div class="one-fifth empty-label"></div>

	<div class="one-fifth">
		<label><?php _e('From', 'quitenicebooking'); ?> (<?php echo $this->settings['date_format_strings'][$this->settings['date_format']]['display']; ?>)</label>
	</div>

	<div class="one-fifth">
		<label><?php _e('To', 'quitenicebooking'); ?> (<?php echo $this->settings['date_format_strings'][$this->settings['date_format']]['display']; ?>)</label>
	</div>

</div>
<div class="field-wrapper field-padding-below clearfix">

	<div class="one-fifth">
		<label><?php _e('Date range'); ?></label>
	</div>

	<div class="one-fifth">
		<input type="text" name="<?php echo "quitenicebooking_price_filter_{$i}_startdate"; ?>" id="<?php echo "quitenicebooking_price_filter_{$i}_startdate"; ?>" value="<?php echo ${"quitenicebooking_price_filter_{$i}_startdate"}; ?>" class="full-width datepicker">
	</div>

	<div class="one-fifth">
		<input type="text" name="<?php echo "quitenicebooking_price_filter_{$i}_enddate"; ?>" id="<?php echo "quitenicebooking_price_filter_{$i}_enddate"; ?>" value="<?php echo ${"quitenicebooking_price_filter_{$i}_enddate"}; ?>" class="full-width datepicker">
	</div>

</div>
<hr class="space1" />

<div class="field-wrapper field-padding clearfix">

	<div class="one-fifth empty-label"></div>

	<?php foreach ($quitenicebooking_prices->keys['prices'] as $key) { ?>
	<div class="one-fifth">
		<label><?php echo $key['description']; ?></label>
	</div>
	<?php } ?>
	
</div>

<?php foreach ($quitenicebooking_prices->entity_scheme->keys as $entity_key) { // rows ?>
<div class="field-wrapper field-padding-below clearfix">

	<div class="one-fifth"><?php echo $entity_key['description'].' ('.$quitenicebooking_currency_unit.')'; ?></div>

	<?php foreach ($quitenicebooking_prices->keys['prices'] as $price_key) { // columns ?>
	<div class="one-fifth">
		<input type="text" name="<?php echo 'quitenicebooking_price_filter_'.$i.'_'.$entity_key['meta_part'].'_'.$price_key['meta_part']; ?>" id="<?php echo 'quitenicebooking_price_filter_'.$i.'_'.$entity_key['meta_part'].'_'.$price_key['meta_part']; ?>" value="<?php echo isset(${'quitenicebooking_price_filter_'.$i.'_'.$entity_key['meta_part'].'_'.$price_key['meta_part']}) ? ${'quitenicebooking_price_filter_'.$i.'_'.$entity_key['meta_part'].'_'.$price_key['meta_part']} : ''; ?>" class="full-width">
		
	</div>
	<?php } ?>

</div>
<?php } ?>

<div class="field-wrapper field-padding-below clearfix">
	<button type="button" class="remove_price_filter button"><?php _e('Remove filter', 'quitenicebooking'); ?></button>
</div>
</div>
<?php } // end for ?>
</div><!-- #dynamic_add_price_filter -->
<div class="field-padding">
	<button type="button" id="add_price_filter" class="button-primary"><?php _e('Add Filter', 'quitenicebooking'); ?></button>
</div>
