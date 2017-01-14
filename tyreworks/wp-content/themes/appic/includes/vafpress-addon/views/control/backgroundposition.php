<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>

<?php if ( ! $value ) {
	$value = $default;
} ?>

<?php
if ( ! function_exists('_bgPostROptionM') ) {
	function _bgPostROptionM($options, $selected = '') {
		$result = '';
		foreach ($options as $value => $label) {
			$result .= strtr('<option value="{value}"{selected}>{label}</option>',array(
				'{value}' => $value,
				'{label}' => $label,
				'{selected}' => $value == $selected ? ' selected' : '',
			));
		}
		return $result;
	}
}
?>

<?php if ($verticalOptions) { ?>
	<select name="<?php echo $name; ?>[v]" class="vp-input">
		<?php echo _bgPostROptionM($verticalOptions, isset($value['v']) ? $value['v'] : ''); ?>
	</select>
<?php } ?>

<?php if ($horizontalOptions) { ?>
	<select name="<?php echo $name; ?>[h]" class="vp-input">
		<?php echo _bgPostROptionM($horizontalOptions, isset($value['h']) ? $value['h'] : ''); ?>
	</select>
<?php } ?>

<?php if ($repeatOptions) { ?>
	<select name="<?php echo $name; ?>[repeat]" class="vp-input">
	<?php echo _bgPostROptionM($repeatOptions, isset($value['repeat']) ? $value['repeat'] : ''); ?>
	</select>
<?php } ?>

<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot'); ?>