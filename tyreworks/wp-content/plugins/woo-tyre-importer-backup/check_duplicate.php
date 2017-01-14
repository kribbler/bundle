<?php

echo check_duplicate($_POST['sku']);
die();

function check_duplicate($sku){
	global $wpdb;
	$query = "SELECT terms.term_id, term_taxonomy.term_taxonomy_id, term_relationships.object_id, postmeta.meta_value, pricemeta.meta_value
			FROM `wp_terms` AS terms
			LEFT JOIN  wp_term_taxonomy AS  term_taxonomy
			ON (term_taxonomy.term_id = terms.term_id)
			LEFT JOIN wp_term_relationships AS term_relationships
			ON (term_relationships.term_taxonomy_id = term_taxonomy.term_taxonomy_id)
			LEFT JOIN wp_postmeta AS postmeta
			ON (postmeta.post_id = term_relationships.object_id AND postmeta.meta_key = '_product_attributes')
			LEFT JOIN wp_postmeta AS pricemeta
			ON (pricemeta.post_id = term_relationships.object_id AND pricemeta.meta_key = '_price')

			WHERE postmeta.meta_value LIKE '%\"pa_seller-sku\";s:5:\"value\";s:".strlen($sku).":\"".$sku."\"%'";

	$query = "SELECT * FROM wp_postmeta WHERE meta_value LIKE '%\"pa_seller-sku\";s:5:\"value\";s:".strlen($sku).":\"".$sku."\"%'";
	//echo $query;
	$items = $wpdb->get_results($query);
	if ($items) return "Duplicate";
	else return "New";
}