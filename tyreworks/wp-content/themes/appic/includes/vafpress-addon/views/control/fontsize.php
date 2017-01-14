<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>

<?php if ( ! $value ) {
	$value = $default;
} ?>

<?php
if ( ! function_exists('_fsROptionM') ) {
	function _fsROptionM($options, $selected = '') {
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

<?php
//related on issues with ajax saving action
$sizeName = $name; // $name . '[0]'
$dementionName = $name; // $name . '[1]'

$sizeValue = isset($value[0]) ? $value[0] : '';
$dementionValue = isset($value[1]) ? $value[1] : '';
?>

<input type="text" name="<?php echo $sizeName ?>" class="vp-input" style="width:50px;padding-top:4px;" value="<?php echo esc_attr($sizeValue); ?>" />

<?php if ( ! empty($dementionOptions) ) { ?>
	<select name="<?php echo $dementionName; ?>" class="vp-input" style="vertical-align:top;">
		<?php echo _fsROptionM($dementionOptions, $dementionValue); ?>
	</select>
<?php } else { ?>
	<input type="text" name="<?php echo $dementionName ?>" class="vp-input" style="width:30px" readonly="true" value="<?php echo esc_attr($dementionValue); ?>" />
<?php } ?>

<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot'); ?>