<?php
// ----------------------------------------#
// General
// ----------------------------------------#

// add theme support for WooCommerce
add_theme_support( 'woocommerce' );

// images sizes
add_image_size('shop-description', 826, 496, true);
add_image_size('shop-single-product', 1140, 1060, true);
add_image_size('shop-product-grid', 740, 480, true);
add_image_size('shop-product-list', 440, 440, true);
add_image_size('shop-widget-top-rated-products', 560, 280, true);
add_image_size('shop-related-product', 270, 160, true);

// WooCommerce widgets intit
function appic_woocommerce_widgets_init()
{
	//widget search_products
	if ( class_exists( 'WC_Widget_Product_Search' ) ) {
		require_once PARENT_DIR . '/woocommerce/widgets/class-appic-wc-widget-product-search.php';
	}

	//widget top_rated_products
	if ( class_exists( 'WC_Widget_Top_Rated_Products' ) ) {
		require_once PARENT_DIR . '/woocommerce/widgets/class-appic-wc-widget-top-rated-products.php';
	}

	//widget accordion_filters
	if ( class_exists( 'WC_Widget' ) ) {
		//add_filter( 'pre_get_posts', 'Appic_WC_Widget_Accordion_Filters::products_quantity' );

		function appic_woocommerce_widget_price_filter_init( $fullList )
		{
			static $placedMap, $needAdd;

			$id_woocommerce_widgets = array('woocommerce_price_filter', 'woocommerce_layered_nav');

			if (null == $needAdd) {
				$placedMap = array(
					'woocommerce_price_filter' => false,
					'woocommerce_layered_nav' => false,
					'appic_woocommerce_accordion_filter' => false
				);

				$placedMapLength = count($placedMap);
				if ($fullList) {
					foreach ($fullList as $toolbar => $widgets) {
						foreach ($widgets as $wid) {
							$alreadPlacedCounter = 0;
							foreach ($placedMap as $themeWidgetId => $_isPlaced) {
								if ($_isPlaced) {
									$alreadPlacedCounter++;
									continue;
								}
								if (0 === strpos($wid, $themeWidgetId)) {
									$placedMap[$themeWidgetId] = true;
									$alreadPlacedCounter++;
								}
							}
							if ($alreadPlacedCounter >= $placedMapLength) {
								break 2;// no sense to continue, as all widgets have been added
							}
						}
					}
				}
				$needAdd = $placedMap['appic_woocommerce_accordion_filter'];
				unset($placedMap['appic_woocommerce_accordion_filter']);
			}

			if ($needAdd) {
				foreach ($placedMap as $wId => $_isPlaced) {
					if (!$_isPlaced) {
						$fullList['appic-hidden-toolbar'][] = $wId . '-1';
					}
				}
			}
			return $fullList;
		}
		add_action('sidebars_widgets', 'appic_woocommerce_widget_price_filter_init');

		require_once PARENT_DIR . '/woocommerce/widgets/class-appic-wc-widget-accordion-filters.php';
	}
}
add_action( 'widgets_init', 'appic_woocommerce_widgets_init', 15 );

// custom style
function appic_woocommerce_custom_style_init()
{
	// woocommerce single project, selectbox
	wp_register_script( 'selectbox', PARENT_URL . '/scripts/vendor/jquery.selectbox.js', array( 'jquery' ) );

	if ( ! is_admin() ) {
		//widget layered_nav add script selectbox for Display type = dropdown
		if ( is_active_widget( false, false, 'woocommerce_layered_nav', true ) ) {
			wp_enqueue_script( 'selectbox' );
			JsClientScript::addScript( 'selectboxInitLayeredNavFilter', '$("#dropdown_layered_nav_color").selectbox(); $(".sbOptions > li").css({"list-style-image":"none"});' );
		}

		//widget product_categories add script selectbox for Display type = dropdown
		if ( is_active_widget( false, false, 'woocommerce_product_categories', true ) ) {
			wp_enqueue_script( 'selectbox' );
			JsClientScript::addScript( 'selectboxInitProdCategoriesFilter', '$("#dropdown_product_cat").selectbox();' );
		}
	}

	// add theme styles for woocommerce
	wp_register_style( 'theme-woocommerce', PARENT_URL . '/css/woocommerce.css' );
	wp_enqueue_style( 'theme-woocommerce' );
}
add_action( 'wp_enqueue_scripts', 'appic_woocommerce_custom_style_init' );

// sidebar
if ( function_exists( 'register_sidebar' ) ) {
	register_sidebar( array(
		'name' => __( 'Woocommerce Sidebar', 'appic' ),
		'id' => 'woocommerce',
		'description' => __( 'Filters and items woocommerce', 'appic' ),
		'before_widget' => '<div id="%1$s" class="widget_price_filter">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="page-elements-title">',
		'after_title' => '</h3>'
	) );
}

function woocommerce_get_thumbnail( $postId = null, $size = 'full', array $attr = array() )
{
	$result = false;
	if ( null == $postId ) {
		$postId = get_the_ID();
	}

	if ( has_post_thumbnail( $postId ) ) {
		$thumb = get_the_post_thumbnail( $postId, $size, $attr );
		// $thumb = theme_get_the_post_thumbnail($postId, $size, $attr);
		if ( $thumb ) {
			return $thumb;
		}
	}

	$urlImgDefault = get_theme_option('woocommerce_def_img');
	if ($urlImgDefault) {
		//$filePath = $urlImgDefault;
		//$iEditor = wp_get_image_editor($filePath);
		//$sizeInfo = get_image_size_details();
		//$iEditor->resize($sizeInfo['width'], $sizeInfo['height'], $sizeInfo['crop']);
	} else {
		$urlImgDefault = wc_placeholder_img_src();
	}

	if ( $urlImgDefault ) {
		$class = ! empty( $attr['class'] ) ? ' class="' . $attr['class'] . '" ' : '';
		$result = '<img src="' . $urlImgDefault . '" ' . $class . '>';
	}
	return $result;
}

// ----------------------------------------#
// Single product
// ----------------------------------------#

// product_images and product_thumbnails
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

function appic_woocommerce_show_product_images()
{
	global $product;

	$images = array();
	$size = 'shop-single-product';
	$sizeDetails = get_image_size_details($size);

	//Thumbnail
	$thumbnail = woocommerce_get_thumbnail( null, $size, array( 'class' => 'active item' ) );
	if ( ! empty( $thumbnail ) ) {
		$images[] = $thumbnail;
	}

	//Gallery
	$attachment_ids = $product->get_gallery_attachment_ids();
	if ( $attachment_ids && !empty($sizeDetails) ) {
		foreach ( $attachment_ids as $attachment_id ) {
			$image_link = wp_get_attachment_url( $attachment_id );
			if ( $image_link ) {
				$image_link = aq_resize( $image_link, $sizeDetails['width'], $sizeDetails['height'], true ); //resize & crop img
				if ( !empty( $image_link ) ) {
					$class_active = empty($images) ? ' active' : '';
					$images[] = '<img class="item' . $class_active . '" src="' . $image_link . '" width="' . $sizeDetails['width'] . '" height="' . $sizeDetails['height'] . '">';
				}
			}
		}
	}

	$carouselNav = '';
	if ( $images ) {
		$imagesHtml = join( '', $images );
		if ( count( $images ) > 1 ) {
			$carouselNav = '<div class="carousel-control-holder text-center">' .
				'<a class="left-control" href="#projectCarousel" data-slide="prev"></a>' .
				'<a class="right-control" href="#projectCarousel" data-slide="next"></a>' .
			'</div>';
		}
	} else {
		$imagesHtml = '<img src="http://placehold.it/' . $sizeDetails['width'] . 'x' . $sizeDetails['height'] . '">';
	}

	$output = '<div class="span6 product-carousel-wrapper">' .
		'<div id="projectCarousel" class="carousel2 slide">' .
			'<div class="carousel-inner image-border">' .
				$imagesHtml .
			'</div>' .
			$carouselNav .
		'</div>' .
	'</div>';

	echo $output;
}
add_action( 'woocommerce_before_single_product_summary', 'appic_woocommerce_show_product_images', 20 );

// title
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

function appic_woocommerce_template_single_title()
{
	echo '<h2 class="single-product-title">' . get_the_title() . '</h2>';
}
add_action( 'woocommerce_single_product_summary', 'appic_woocommerce_template_single_title', 5 );

// price
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

function appic_woocommerce_template_single_price()
{
	global $product;
	echo '<div class="bold cost">' . $product->get_price_html() . '</div>';
}
add_action( 'woocommerce_single_product_summary', 'appic_woocommerce_template_single_price', 10 );

// rating
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );

// description
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

function appic_woocommerce_template_single_excerpt()
{
	global $post;
	echo apply_filters( 'woocommerce_short_description', $post->post_excerpt );
}
add_action( 'woocommerce_single_product_summary', 'appic_woocommerce_template_single_excerpt', 20 );

// meta
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
function appic_woocommerce_single_product_meta()
{
	global $post, $product;

	$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
	$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

	$skuOutput = '';
	if ( wc_product_sku_enabled() ) {
		$sku = $product->get_sku();
		if ( $sku || $product->is_type( 'variable' ) ) {
			$skuOutput = '<p>' .
				'<strong>' .
					__( 'SKU:', 'appic' ) .
				'</strong>' .
				($sku ? $sku : __( 'N/A', 'appic' )).
			'</p>';
		}
	}

	$catOutput = '';
	$cat = $product->get_categories();
	if ( ! empty( $cat ) ) {
		$catOutput = '<p>' .
			'<strong>' .
				_n( 'Category:', 'Categories:', $cat_count, 'appic' ) .
			'</strong>' .
			$product->get_categories() .
		'</p>';
	}

	$tagtOutput = '';
	$tag = $product->get_tags();
	if ( ! empty( $tag ) ) {
		$tagtOutput = '<p>' .
			'<strong>' .
				_n( 'Tag:', 'Tags:', $tag_count, 'appic' ) .
			'</strong>' .
			$product->get_tags() .
		'</p>';
	}

	$availabilityOutput = '';
	$availability = $product->get_availability();
	if ( ! empty( $availability['availability'] ) ) {
		//echo apply_filters( 'woocommerce_stock_html', '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>', $availability['availability'] );
		$availabilityOutput = '<p>' .
			'<strong>' .
				$availability['availability'] .
			'</strong>' .
		'</p>';
	}

	if ( ! empty( $skuOutput ) || ! empty( $catOutput ) || ! empty( $tagtOutput ) || ! empty( $availabilityOutput ) ) {
		$output = '<div class="details-wrap">' .
			$skuOutput .
			$catOutput .
			$tagtOutput .
			$availabilityOutput .
		'</div>';
		echo $output;
	}
}
add_action( 'woocommerce_single_product_summary', 'appic_woocommerce_single_product_meta', 20 );

//button add to cart
remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
function appic_woocommerce_simple_add_to_cart()
{
	global $product;
	if ( ! $product->is_purchasable() ) {
		return;
	}

	if ( $product->is_in_stock() ) {
		ob_start();
		if ( ! $product->is_sold_individually() ) {
			woocommerce_quantity_input( array(
				'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
				'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
			) );
		}
		$input_quntity = ob_get_contents();
		ob_end_clean();

		$output = '<form class="cart simple-add-to-cart appic-woocommerce" method="post" enctype="multipart/form-data">' .
			$input_quntity .
			'<input type="hidden" name="add-to-cart" value="' . esc_attr( $product->id ) . '">' .
			'<button type="submit" class="btn btn-info cart">' . $product->single_add_to_cart_text() . '</button>' .
		'</form>';

		echo $output;
	}
}
add_action( 'woocommerce_simple_add_to_cart', 'appic_woocommerce_simple_add_to_cart', 30 );

//product group
remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
function appic_woocommerce_grouped_add_to_cart(){
	global $product, $post;
	$grouped_products = $product->get_children();
	$quantites_required = false;
	$parent_product_post = $post;
	$output = '';
	$itemHtml = '';

	foreach ( $grouped_products as $product_id ) {
		$product = get_product( $product_id );
		$post = $product->post;
		setup_postdata( $post );

		$itemHtml .= '<div class="row-fluid group-prodict-item">';

		//input quantity product or button read more
		if ( $product->is_sold_individually() || ! $product->is_purchasable() ) {
			$itemHtml .= '<div class="span4">';
			$itemHtml .= apply_filters( 'woocommerce_loop_add_to_cart_link',
				'<a ' .
					'href="' . esc_url( $product->add_to_cart_url() ) . '" ' .
					'rel="nofollow" '.
					'data-product_id="' . esc_attr( $product->id ) . '" ' .
					'data-product_sku="' . esc_attr( $product->get_sku() ) . '" '.
					'class="">' .
					esc_html( $product->add_to_cart_text() ) .
				'</a>',
				$product
			);
			$itemHtml .= '</div>';
		} else {
			$quantites_required = true;
			ob_start();
			woocommerce_quantity_input( array( 'input_name' => 'quantity[' . $product_id . ']', 'input_value' => '0' ) );
			$itemHtml .= '<div class="pull-left">' . ob_get_contents() . '&nbsp;</div>';
			ob_clean();
		}

		//title product
		$itemHtml .= $product->is_visible() ? '<div class="pull-left"><a href="' . get_permalink() . '">' . get_the_title() . '</a></div>' : get_the_title();

		//price product
		$itemHtml .= '<div class="pull-right">' . $product->get_price_html();
		if ( ( $availability = $product->get_availability() ) && $availability['availability'] ) {
			$itemHtml .= apply_filters( 'woocommerce_stock_html', '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>', $availability['availability'] );
		}
		$itemHtml .= '</div>';

		$itemHtml .='<div class="clearfix"></div></div>';
	}

	// Reset to parent grouped product
	$post = $parent_product_post;
	$product = get_product( $parent_product_post->ID );
	setup_postdata( $parent_product_post );

	$button = '<input type="hidden" name="add-to-cart" value="' . esc_attr( $product->id ) . '">';
	if ( $quantites_required ) {
		$button .= '<button type="submit" class="btn btn-info cart">' . $product->single_add_to_cart_text() . '</button>';
	}

	$output = '<form class="cart" method="post" enctype="multipart/form-data"> ' . $itemHtml . $button . ' </form>';

	echo $output;
}
add_action( 'woocommerce_grouped_add_to_cart', 'appic_woocommerce_grouped_add_to_cart', 30 );

// tabs
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

function appic_woocommerce_output_product_data_tabs()
{
	$tabs = apply_filters( 'woocommerce_product_tabs', array() );
	if ( !empty( $tabs ) ) {
		echo '<div class="woocommerce-tabs">' . '<section class="container">' . '<ul class="nav nav-tabs" id="myTab">';

		$i = 1;
		foreach ( $tabs as $key => $tab ) {
			$class = $i == 1 ? ' class="active"' : '';
			echo '<li' . $class . '><a href="#tab_woocommerce_' . $key . '" data-toggle="tab">' . $tab['title'] . '</a></li>';
			$i++;
		}
		echo '</ul><div class="tab-content">';

		$i = 1;
		foreach ( $tabs as $key => $tab ) {
			echo '<div class="tab-pane' . ( $i == 1 ? ' active' : '' ) . '" id="tab_woocommerce_' . $key . '"><p class="simple-text-14 text-tab-bottom">';
			if( isset( $tab['callback'] ) ) {
				call_user_func( $tab['callback'], $key, $tab );
			}
			echo '</p></div>';
			$i++;
		}
		echo '</div></section></div>';
	}
}
add_action( 'woocommerce_after_single_product_summary', 'appic_woocommerce_output_product_data_tabs', 10 );

// related products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

function appic_woocommerce_output_related_products()
{
	global $product;

	$related = $product->get_related();
	if ( empty( $related ) ) {
		return;
	}

	$args = apply_filters( 'woocommerce_related_products_args', array(
		'post_type' => 'product',
		'ignore_sticky_posts' => 1,
		'no_found_rows' => 1,
		'post__in' => $related,
		'post__not_in' => array(
			$product->id,
		)
	) );

	$products = array();
	$query = new WP_Query( $args );
	while ( $query->have_posts() ) {
		$query->the_post();
		$image = woocommerce_get_thumbnail( null, 'shop-related-product' );
		if( !empty($image) ) {
			$products[] = '<li>' .
				'<div class="view hover-effect-image">' .
					$image.
					'<a href="' . get_permalink() . '" class="mask-no-border show-text">' .
						'<span class="mask-icon">' . get_the_title() . '</span>' .
					'</a>' .
				'</div>' .
			'</li>';
		}
	}

	if ( !empty($products) ) {
		$curIndex = 0;
		while ( count( $products ) < 4 ) {
			$products[] = $products[$curIndex];
			$curIndex++;
		}
		
		$productsHtml = join('', $products);
		$output = '<div class="similar-products-wrap horizontal-blue-lines stretch-over-container">' .
			'<section class="container similar-products">' .
				'<h2 class="article-title">' . __('Similar', 'appic') . '<span>' . __('Products', 'appic') . '</span></h2>' .
				'<ul class="bxslider">' .
					$productsHtml .
				'</ul>' .
			'</section>' .
		'</div>';

		wp_enqueue_script( 'bxslider' );
		JsClientScript::addScript( 'initSimilarProjects', '$(".bxslider").bxSlider({pager: false, minSlides: 1, maxSlides: 4, slideWidth: 270, slideMargin: 30});' );

		echo $output;
	}
}
add_action( 'woocommerce_after_single_product_summary', 'appic_woocommerce_output_related_products', 20 );

// ----------------------------------------#
// Shops page
// ----------------------------------------#
/**
 * Class for view products list/grid.
 * 
 * 
 * @version  1.0
 */
class ThemeWooCommerceViewMode
{
	/**
	 * Name of the query parameter used for curren view mode storing.
	 * @var srting
	 */
	public static $paramName = 'view';

	/**
	 * Name of the default mode.
	 * @var string
	 */
	public static $defaultType = 'grid';

	/**
	 * Type list.
	 * @var string
	 */
	const TYPE_LIST = 'list';

	/**
	 * Type grid.
	 * @var string
	 */
	const TYPE_GRID = 'grid';

	/**
	 * Types aliases.
	 * @var array
	 */
	protected static $typeAliases = array();

	/**
	 * Allows define alias value for specefied type.
	 * @param string $type
	 * @param string $alias
	 */
	static public function set_alis( $type, $alias )
	{
		if ( !$alias ) {
			if ( isset( self::$typeAliases[$type] ) ) {
				unset( self::$typeAliases[$type] );
			}
		} else {
			self::$typeAliases[$type] = $alias;
		}
	}

	/**
	 * Build url that presents specefied type.
	 * @param string $type
	 * @return string
	 */
	static public function build_url( $type )
	{
		if ($type == self::$defaultType) {
			return remove_query_arg( self::getParamName() );
		} else {
			return add_query_arg( self::getParamName(), self::getTypeAlias( $type ) );
		}
	}

	/**
	 * Returns current mode name base of the GET parameter value.
	 * @return string
	 */
	static public function get_current_mode()
	{
		$paramName = self::getParamName();
		$aliasedValue = isset( $_GET[$paramName] ) ? trim( $_GET[$paramName] ) : null;

		return $aliasedValue ? self::getTypeByAlias( $aliasedValue ) : self::$defaultType;
	}

	/**
	 * Returns type dy alias name.
	 * @param srting $alias
	 * @return srting
	 */
	static protected function getTypeByAlias( $alias )
	{
		if ( self::$typeAliases ) {
			$type = array_search( $alias, self::$typeAliases );
			if ( $type ) {
				return $type;
			}
		}

		return $alias;
	}

	/**
	 * Returns alias name for specefied type.
	 * @param string $type
	 * @return string
	 */
	static protected function getTypeAlias( $type )
	{
		if ($type && isset(self::$typeAliases[$type])) {
			return self::$typeAliases[$type];
		}
		return $type;
	}

	/**
	 * Get name of the get parameter used for view mode storing.
	 * @return string
	 */
	static protected function getParamName()
	{
		return self::$paramName ? self::$paramName : 'wc-view-mode';
	}
}

// title page
function woocommerce_content()
{
	if ( is_singular( 'product' ) ) {
		while ( have_posts() ) {
			the_post();
			wc_get_template_part( 'content', 'single-product' );
		}
	} else {
		if ( apply_filters( 'woocommerce_show_page_title', true ) ) {
			echo '<h2 class="section-title templ-wrap">';
			woocommerce_page_title();
			echo '</h2>';
		}
		do_action( 'woocommerce_archive_description' );
		if ( have_posts() ) {
			do_action( 'woocommerce_before_shop_loop' );
			woocommerce_product_loop_start();
			woocommerce_product_subcategories();
			while ( have_posts() ) {
				the_post();
				wc_get_template_part( 'content', 'product' );
			}
			woocommerce_product_loop_end();
			do_action( 'woocommerce_after_shop_loop' );
		} elseif ( !woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) {
			wc_get_template( 'loop/no-products-found.php' );
		}
	}
}

// result count
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

// catalog ordering
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

function appic_woocommerce_catalog_ordering()
{
	$orderby = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

	$active_class_attribute = ' class="sort-bar-active"';
	$grid_active = '';
	$list_active = '';
	if ( ThemeWooCommerceViewMode::get_current_mode() == ThemeWooCommerceViewMode::TYPE_LIST ) {
		$list_active = $active_class_attribute;
	} else {
		$grid_active = $active_class_attribute;
	}

	$output = '<div class="sort-bar-wrap">' .
		'<ul class="inline sort-bar pull-left">' .
			'<li' . $list_active . '>' .
				'<a href="' . ThemeWooCommerceViewMode::build_url( ThemeWooCommerceViewMode::TYPE_LIST ) . '">' .
					'<i class="fa-list fa"></i> ' .
					__( 'List view', 'appic' ) .
				'</a>' .
			'</li>' .
			'<li' . $grid_active . '>' .
				'<a href="' . ThemeWooCommerceViewMode::build_url( ThemeWooCommerceViewMode::TYPE_GRID ) . '">' .
					'<i class="fa-th fa"></i> ' .
					__( 'Grid view', 'appic' ) .
				'</a>' .
			'</li>' .
		'</ul>';

	$catalog_orderby = apply_filters( 'woocommerce_catalog_orderby', array(
		'menu_order' => __( 'Default sorting', 'woocommerce' ),
		'popularity' => __( 'Sort by popularity', 'woocommerce' ),
		'rating' => __( 'Sort by average rating', 'woocommerce' ),
		'date' => __( 'Sort by newness', 'woocommerce' ),
		'price' => __( 'Sort by price: low to high', 'woocommerce' ),
		'price-desc' => __( 'Sort by price: high to low', 'woocommerce' )
	) );
	
	if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
		unset( $catalog_orderby['rating'] );
	}
	
	$output .= '<div class="select-wrap pull-right">' .
		'<form class="woocommerce-ordering" method="get">' .
			'<select name="orderby" class="orderby" id="orderby">';

	foreach ( $catalog_orderby as $id => $name ) {
		$output .= '<option value="' . esc_attr( $id ) . '" ' . selected( $orderby, $id, false ) . '>' . esc_attr( $name ) . '</option>';
	}

	$output .= '</select>';

	// Keep query string vars intact
	foreach ( $_GET as $key => $val ) {
		if ( 'orderby' == $key ) {
			continue;
		}
		if ( is_array( $val ) ) {
			foreach ( $val as $innerVal ) {
				$output .= '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
			}
		} else {
			$output .= '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
		}
	}

	$output .= '</form></div><div class="clearfix"></div></div>';

	echo $output;

	wp_enqueue_script( 'selectbox' );
	JsClientScript::addScript( 'selectboxObredByInit', '$("#orderby").selectbox();' );
}
add_action( 'woocommerce_before_shop_loop', 'appic_woocommerce_catalog_ordering', 30 );

// shop product column
function appic_woocommerce_shop_columns($columns)
{
	return 2;
}
add_filter( 'loop_shop_columns', 'appic_woocommerce_shop_columns' );

// loop start
function woocommerce_product_loop_start()
{
	if ( ThemeWooCommerceViewMode::get_current_mode() == ThemeWooCommerceViewMode::TYPE_LIST ) {
		$output = '<ul id="productsListView" class="image-gallery category-grid">'; // products list_view
		ThemeFlags::set('woocommerce_product_loop_tag','li');
	} else {
		$output = '<div id="productsGridView" class="row image-gallery category-grid">';
	}
	echo $output;
}

function woocommerce_product_loop_end()
{
	$tag = ThemeFlags::get('woocommerce_product_loop_tag','div');
	if ('li' == $tag) $tag = 'ul';
	echo '</' . $tag .'>';
}


// shop product
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

function appic_woocommerce_shop_item()
{
	global $post, $product;

	$output = '';
	$link_post = get_permalink();
	$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
	$price = $product->get_price_html();
	$add_to_cart_href = esc_url( $product->add_to_cart_url() );
	$add_to_cart_id = esc_attr( $product->id );
	$add_to_cart_sku = esc_attr( $product->get_sku() );
	$add_to_cart_class = $product->is_purchasable() ? 'add_to_cart_button' : '';
	$add_to_cart_type = esc_attr( $product->product_type );
	$add_to_cart_text = esc_html( $product->add_to_cart_text() );
	$class_button_add_to_cart = 'btn btn-info cart product_type_' . $add_to_cart_type . ' ' . $add_to_cart_class;

	$is_list_mode = ThemeWooCommerceViewMode::get_current_mode() == ThemeWooCommerceViewMode::TYPE_LIST;

	if ( $is_list_mode ) {
		$class_button_add_to_cart .= ' pull-right';
		$class_wrap_thumb = ' pull-left catalogue-img';
		$size = 'shop-product-list';
		$bottom_item = '<div class="simple-text-12 list-product-content">' . do_excerpt( get_the_content(), 20 ) . '</div>';

		// rating list
		$count = $product->get_rating_count();
		$average = $product->get_average_rating();

		if ( $count > 0 ) {
			$bottom_item .= '<div class="rate bold">' .
				'<div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope="">' .
					'<div class="star-rating ">' .
						'<span style="width:' . ( ( $average / 5 ) * 100 ) . '%"></span>' .
					'</div>' .
				'</div>' .
				/*'<div class="rating-value pull-left">' .
					__('Rate:','appic'). ' ' . $average .
				'</div>'.
				'<div style="clearfix"></div>' .*/
			'</div>';
		}
		$class_wrap_button_add_to_cart = ' pull-left list-product-price';
	} else {
		$class_wrap_thumb = '';
		$size = 'shop-product-grid';
		$bottom_item = '';
		$class_wrap_button_add_to_cart = ' pull-right';
	}

	$thumb = woocommerce_get_thumbnail( null, $size );
	if ( empty($thumb) ) {
		$class_not_margin = ' list-product-no-img';
	} else {
		$class_not_margin = '';
		$output .= '<div class="view hover-effect-image' . $class_wrap_thumb . '">' .
			$thumb .
			'<a class="mask" data-rel="colorbox1" href="' . $link_post . '">' .
				'<span class="mask-icon">' . __('Full Image', 'appic') . '</span>' .
			'</a>' .
		'</div>';
	}

	$add_to_cart = apply_filters(
		'woocommerce_loop_add_to_cart_link',
		'<a' .
			' href="' . $add_to_cart_href . '"' .
			' rel="nofollow"' .
			' data-product_id="' . $add_to_cart_id . '"' .
			' data-product_sku="' . $add_to_cart_sku . '"' .
			' class="' . $class_button_add_to_cart . '"' .
		'>' .
			$add_to_cart_text .
		'</a>'
	);

	$wrap_add_to_cart = '<div class="bold cost' . $class_wrap_button_add_to_cart . '">' . $price . '</div>' . $add_to_cart;

	$category_html = '';
	if ($product_category = $product->get_categories( $cat_count )) {
		$category_html = '<h5 class="simple-text-14 dark-grey-text">' .
			__('Category:', 'appic') . ' ' . $product_category .
		'</h5>';
	}

	$output .= '<div class="image-capture' . $class_not_margin . '">' .
			'<h2 class="font-style-20 bold">' .
				'<a class="link" data-rel="colorbox2" href="' . $link_post . '">' .
					get_the_title() .
				'</a>' .
			'</h2>' .
			$category_html .
			$bottom_item .
			$wrap_add_to_cart .
		'</div>';

	if (!$is_list_mode) {
		$output = '<div class="image-figure">' .
			$output .
		'</div>';
	}

	echo $output;
}
add_action( 'woocommerce_before_shop_loop_item_title', 'appic_woocommerce_shop_item' );

// pagination
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

function appic_woocommerce_shop_pagination()
{
	appic_pagenavi();
}
add_action( 'woocommerce_after_shop_loop', 'appic_woocommerce_shop_pagination', 10 );

// header shop
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );

function appic_woocommerce_template_shop_description()
{
	$shop_page = get_post( wc_get_page_id( 'shop' ) );
	if ( $shop_page ) {
		$description = apply_filters( 'the_content', $shop_page->post_content );
		if ( !$description ) {
			$description = '';
		}

		$thumb = get_the_post_thumbnail( $shop_page->ID, 'shop-description', array( 'class' => 'shop-header-img' ) );

		if ( !empty( $description ) || !empty( $thumb ) ) {
			if ( empty( $thumb ) ) {
				$class_padding_rignt_none = ' shop-header-no-img';
			} else {
				$class_padding_rignt_none = '';
			}
			$output = '<div class="category-header-box' . $class_padding_rignt_none . '">' .
				'<h3 class="category-header bold">
					<small>' . $description . '</small>
				</h3>' .
				$thumb .
			'</div>';

			echo $output;
		}
	}
}

add_action( 'woocommerce_archive_description', 'appic_woocommerce_template_shop_description', 10 );
