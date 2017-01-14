<?php
/**
 * Adds ajax action 'sharrre_curl' used by sharrre plugin to get counters for googlePlus button and stumbleupon.
 *
 * @author kollega <oleg.kutcyna@gmail.com>
 */
add_action( 'wp_ajax_sharrre_curl', 'sharrre_curl_ajax_action');
add_action( 'wp_ajax_nopriv_sharrre_curl', 'sharrre_curl_ajax_action');

function sharrre_curl_ajax_action()
{
	header('content-type: application/json');

	$urlParam = isset($_GET['url']) ? $_GET['url'] : '';
	$json = array(
		'url' => $urlParam,
		'count' => 0
	);

	if(filter_var($urlParam, FILTER_VALIDATE_URL)){
		$url = urlencode($urlParam);
		$type = isset($_GET['type']) ? urlencode($_GET['type']) : '';
		if($type == 'googlePlus'){  //source http://www.helmutgranda.com/2011/11/01/get-a-url-google-count-via-php/
			$content = sharrre_get_remote_body("https://plusone.google.com/u/0/_/+1/fastbutton?url=".$url."&count=true");
			if ($content) {
				$dom = new DOMDocument;
				$dom->preserveWhiteSpace = false;
				@$dom->loadHTML($content);
				$domxpath = new DOMXPath($dom);
				$newDom = new DOMDocument;
				$newDom->formatOutput = true;
				
				$filtered = $domxpath->query("//div[@id='aggregateCount']");
				if (isset($filtered->item(0)->nodeValue)) {
					$json['count'] = str_replace('>', '', $filtered->item(0)->nodeValue);
				}
			}
		} elseif($type == 'stumbleupon') {
			$content = sharrre_get_remote_body("http://www.stumbleupon.com/services/1.01/badge.getinfo?url=$url");
			if ($content) {
				$result = json_decode($content);
				if (isset($result->result->views)) {
					$json['count'] = $result->result->views;
				}
			}
		}
	}
	echo str_replace('\\/','/',json_encode($json));
	exit();
};

/**
 * Returns content for the passed url.
 * @param  string $encUrl url that should be loaded
 * @return string
 */
function sharrre_get_remote_body($encUrl)
{
	$response = wp_remote_get($encUrl, array(
		'redirection' => 3,
		'timeout' => 10,
		'user-agent' => 'sharrre',
		'sslverify' => false
	));
	if (!empty($response['body'])) {
		return $response['body'];
	}
	return '';
}
