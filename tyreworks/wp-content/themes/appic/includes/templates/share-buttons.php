<?php
$sharrePluginConfig = array(
	'urlCurl' => admin_url('admin-ajax.php?action=sharrre_curl'),
	'itemsSelector' => '#shareBoxContainer .share-box__item[data-btntype]'
);
wp_enqueue_script('sharrre');
JsClientScript::addScript('sharreInit', 'initSharrres('.json_encode($sharrePluginConfig).');');
?>

<div id="shareBoxContainer" class="share-box">
	<div class="share-box__item share-box__item--facebook" data-btntype="facebook" data-title="Like"></div>
	<div class="share-box__item share-box__item--twitter" data-btntype="twitter" data-title="Tweet"></div>
	<div class="share-box__item share-box__item--gplus" data-btntype="googlePlus" data-title="+"></div>
	<div class="share-box__item share-box__item--pinterest" data-btntype="pinterest" data-title="Pin it"></div>
	<div class="share-box__item share-box__item--linkedin" data-btntype="linkedin" data-title="Share"></div>
</div>
<div class="clearfix"></div>
