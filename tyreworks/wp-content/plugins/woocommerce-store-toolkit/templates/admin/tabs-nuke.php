<ul class="subsubsub">
	<li><a href="#empty-woocommerce-tables"><?php _e( 'Empty WooCommerce Tables', 'woo_st' ); ?></a> |</li>
	<li><a href="#empty-product-by-category"><?php _e( 'Empty Products by Product Category', 'woo_st' ); ?></a> |</li>
	<li><a href="#delete-sales-by-sale-status"><?php _e( 'Delete Orders by Order Status', 'woo_st' ); ?></a> |</li>
	<li><a href="#empty-wordpress-tables"><?php _e( 'Empty WordPress Tables', 'woo_st' ); ?></a></li>
</ul>
<br class="clear" />
<h3><?php _e( 'Nuke WooCommerce', 'woo_st' ); ?></h3>
<p><?php _e( 'Select the WooCommerce tables you wish to empty then click Remove to permanently remove WooCommerce generated details from your WordPress database.', 'woo_st' ); ?></p>
<form method="post" onsubmit="showProgress()">
	<div id="poststuff">

		<div class="postbox" id="empty-woocommerce-tables">
			<h3 class="hndle"><?php _e( 'Empty WooCommerce Tables', 'woo_st' ); ?></h3>
			<div class="inside">
				<p class="description"><?php _e( 'Permanently remove WooCommerce details.', 'woo_st' ); ?></p>
				<p><a href="javascript:void(0)" id="woocommerce-checkall"><?php _e( 'Check All', 'woo_st' ); ?></a> | <a href="javascript:void(0)" id="woocommerce-uncheckall"><?php _e( 'Uncheck All', 'woo_st' ); ?></a></p>
				<fieldset>
					<table class="form-table">

						<tr>
							<th>
								<label for="products"><?php _e( 'Products', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="products" name="woo_st_products"<?php echo disabled( $products, 0 ); ?> /> (<?php echo $products; ?>)
							</td>
						</tr>

						<tr>
							<th>
								<label for="product_categories"><?php _e( 'Product Categories', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="product_categories" name="woo_st_product_categories"<?php echo disabled( $categories, 0 ); ?> /> (<?php echo $categories; ?>)
							</td>
						</tr>

						<tr>
							<th>
								<label for="product_tags"><?php _e( 'Product Tags', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="product_tags" name="woo_st_product_tags"<?php echo disabled( $tags, 0 ); ?> /> (<?php echo $tags; ?>)
							</td>
						</tr>

						<tr>
							<th>
								<label for="product_images"><?php _e( 'Product Images', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="product_images" name="woo_st_product_images"<?php echo disabled( $images, 0 ); ?> /> (<?php echo $images; ?>)
							</td>
						</tr>

						<tr>
							<th>
								<label for="attributes"><?php _e( 'Product Attributes', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="attributes" name="woo_st_attributes"<?php echo disabled( $attributes, 0 ); ?> /> (<?php echo $attributes; ?>)
							</td>
						</tr>

						<tr>
							<th>
								<label for="sales_orders"><?php _e( 'Orders', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="sales_orders" name="woo_st_sales_orders"<?php echo disabled( $orders, 0 ); ?> /> (<?php echo $orders; ?>)
							</td>
						</tr>

						<tr>
							<th>
								<label for="tax_rates"><?php _e( 'Tax Rates', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="tax_rates" name="woo_st_tax_rates"<?php echo disabled( $tax_rates, 0 ); ?> /> (<?php echo $tax_rates; ?>)
							</td>
						</tr>

						<tr>
							<th>
								<label for="download_permissions"><abbr title="<?php _e( 'Product Download Permissions', 'woo_st' ); ?>"><?php _e( 'Download Permissions', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="download_permissions" name="woo_st_download_permissions"<?php echo disabled( $download_permissions, 0 ); ?> /> (<?php echo $download_permissions; ?>)
							</td>
						</tr>

						<tr>
							<th>
								<label for="coupons"><?php _e( 'Coupons', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="coupons" name="woo_st_coupons"<?php echo disabled( $coupons, 0 ); ?> /> (<?php echo $coupons; ?>)
							</td>
						</tr>

<?php if( isset( $credit_cards ) ) { ?>
						<tr>
							<th>
								<label for="creditcards"><?php _e( 'Credit Cards', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="creditcards" name="woo_st_creditcards"<?php echo disabled( $credit_cards, 0 ); ?> /> (<?php echo $credit_cards; ?>)
								<span class="description"><?php echo sprintf( __( 'via %s', 'woo_st' ), '<a href="http://www.visser.com.au/woocommerce/plugins/offline-credit-card-processing/" target="_blank">' . __( 'Offline Credit Card Processing', 'woo_st' ) . '</a>' ); ?></span>
							</td>
						</tr>

<?php } ?>
<?php if( isset( $brands ) ) { ?>
						<tr>
							<th>
								<label for="product_brands"><?php _e( 'Product Brands', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="product_brands" name="woo_st_product_brands"<?php echo disabled( $brands, 0 ); ?> /> (<?php echo $brands; ?>)
								<span class="description"><?php echo sprintf( __( 'via %s', 'woo_st' ), '<a href="http://www.woothemes.com/products/brands/" target="_blank">' . __( 'WooCommerce Brands', 'woo_st' ) . '</a>' ); ?></span>
							</td>
						</tr>

<?php } ?>
<?php if( isset( $vendors ) ) { ?>
						<tr>
							<th>
								<label for="product_vendors"><?php _e( 'Product Vendors', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="product_vendors" name="woo_st_product_vendors"<?php echo disabled( $vendors, 0 ); ?> /> (<?php echo $vendors; ?>)
								<span class="description"><?php echo sprintf( __( 'via %s', 'woo_st' ), '<a href="http://www.woothemes.com/products/product-vendors/" target="_blank">' . __( 'Product Vendors', 'woo_st' ) . '</a>' ); ?></span>
							</td>
						</tr>

<?php } ?>
					</table>
				</fieldset>
				<p class="submit">
					<input type="submit" value="<?php _e( 'Remove', 'woo_st' ); ?>" class="button-primary" />
				</p>
			</div>
		</div>
		<!-- .postbox -->

		<div class="postbox">
			<h3 class="hndle" id="empty-product-by-category"><?php _e( 'Empty Products by Product Category', 'woo_st' ); ?></h3>
			<div class="inside">
<?php if( $categories ) { ?>
				<p class="description"><?php _e( 'Remove Products from specific Product Categories by selecting the Product Categories below, then click Remove to permanently remove those Products.', 'woo_st' ); ?></p>
				<ul>
	<?php foreach( $categories_data as $category_single ) { ?>
					<li>
						<label>
							<input type="checkbox" name="woo_st_categories[<?php echo $category_single->term_id; ?>]" value="<?php echo $category_single->term_id; ?>"<?php if( $category_single->count == 0 ) { ?> disabled="disabled"<?php } ?> />
							<?php echo $category_single->name; ?> (<?php echo $category_single->count; ?>)
						</label>
					</li>
	<?php } ?>
				</ul>
				<p class="submit">
					<input type="submit" value="<?php _e( 'Remove', 'woo_st' ); ?>" class="button-primary" />
				</p>
<?php } else { ?>
				<p><?php _e( 'No Categories have been created.', 'woo_st' ); ?></p>
<?php } ?>
			</div>
		</div>
		<!-- .postbox -->

		<div class="postbox">
			<h3 class="hndle" id="delete-sales-by-sale-status"><?php _e( 'Delete Orders by Order Status', 'woo_st' ); ?></h3>
			<div class="inside">
<?php if( $orders ) { ?>
				<p class="description"><?php _e( 'Remove Orders based on the Order Status by selecting the the Order Status below, then click Remove to permanently remove those Orders.', 'woo_st' ); ?></p>
				<ul>
<?php if( $orders_data ) { ?>
	<?php foreach( $orders_data as $order_single ) { ?>
					<li>
						<label>
							<input type="checkbox" name="woo_st_orders[<?php echo $order_single->term_id; ?>]" value="<?php echo $order_single->term_id; ?>"<?php if( $order_single->count == 0 ) { ?> disabled="disabled"<?php } ?> />
							<?php echo woo_st_convert_sale_status( $order_single->name ); ?> (<?php echo $order_single->count; ?>)
						</label>
					</li>
	<?php } ?>
<?php } else { ?>
				<li><?php _e( 'No Order Status\'s were found.', 'woo_ce' ); ?></li>
<?php } ?>
				</ul>
				<p class="submit">
					<input type="submit" value="<?php _e( 'Remove', 'woo_st' ); ?>" class="button-primary" />
				</p>
<?php } else { ?>
				<p><?php _e( 'No Orders were found.', 'woo_st' ); ?></p>
<?php } ?>
			</div>
		</div>
		<!-- .postbox -->

		<div class="postbox" id="empty-wordpress-tables">
			<h3 class="hndle"><?php _e( 'Empty WordPress Tables', 'woo_st' ); ?></h3>
			<div class="inside">
				<p class="description"><?php _e( 'Permanently remove WordPress details.', 'woo_st' ); ?></p>
				<p><a href="javascript:void(0)" id="wordpress-checkall"><?php _e( 'Check All', 'woo_st' ); ?></a> | <a href="javascript:void(0)" id="wordpress-uncheckall"><?php _e( 'Uncheck All', 'woo_st' ); ?></a></p>
				<fieldset>
					<table class="form-table">

						<tr>
							<th>
								<label for="posts"><?php _e( 'Posts', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="posts" name="woo_st_posts"<?php echo disabled( $posts, 0 ); ?> /> (<?php echo $posts; ?>)
							</td>
						</tr>

						<tr>
							<th>
								<label for="post_categories"><?php _e( 'Post Categories', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="post_categories" name="woo_st_post_categories"<?php echo disabled( $post_categories, 0 ); ?> /> (<?php echo $post_categories; ?>)
							</td>
						</tr>

						<tr>
							<th>
								<label for="post_tags"><?php _e( 'Post Tags', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="post_tags" name="woo_st_post_tags"<?php echo disabled( $post_tags, 0 ); ?> /> (<?php echo $post_tags; ?>)
							</td>
						</tr>

						<tr>
							<th>
								<label for="links"><?php _e( 'Links', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="links" name="woo_st_links"<?php echo disabled( $links, 0 ); ?> /> (<?php echo $links; ?>)
							</td>
						</tr>

						<tr>
							<th>
								<label for="comments"><?php _e( 'Comments', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="links" name="woo_st_comments"<?php echo disabled( $comments, 0 ); ?> /> (<?php echo $comments; ?>)
							</td>
						</tr>

						<tr>
							<th>
								<label for="comments"><?php _e( 'Media: Images', 'woo_st' ); ?></label>
							</th>
							<td>
								<input type="checkbox" id="links" name="woo_st_media_images"<?php echo disabled( $media_images, 0 ); ?> /> (<?php echo $media_images; ?>)
							</td>
						</tr>

					</table>
				</fieldset>
				<p class="submit">
					<input type="submit" value="<?php _e( 'Remove', 'woo_st' ); ?>" class="button-primary" />
				</p>
			</div>
		</div>
		<!-- .postbox -->

	</div>
	<!-- #poststuff -->

	<input type="hidden" name="action" value="nuke" />
</form>