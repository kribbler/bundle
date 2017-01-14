<?php
class Appic_WC_Widget_Accordion_Filters extends WC_Widget
{
	/**
	 * Attribute layered.
	 * @var string
	 */
	public static $attribute_color = 'color';

	/**
	 * Name GET varible for filter color.
	 * @var string
	 */
	public static $filter_color_var_get = 'filter_color';

	/**
	 * Name GET varible for tilter color
	 * @var string
	 */
	public static $filter_color_query_type = 'query_type_';

	/**
	 * Name GET varible for filter quantity product in page.
	 * @var string
	 */
	public static $quantity_product_var_get = 'filter_page_size';

	public $undefinedFilterColor = '#FFF';

	public static $pagination_list = array(
		//'2' => 2,
		//'5' => 5,
		'10' => 10,
		'20' => 20,
		'30' => 30,
		'50' => 50,
		'100' => 100,
	);

	/**
	 * Name GET varible for filter price min
	 * @var string
	 */
	public static $filter_price_var_get_min = 'min_price';

	/**
	 * Name GET varible for filter price max
	 * @var string
	 */
	public static $filter_price_var_get_max = 'max_price';

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->widget_cssclass = 'woocommerce widget_price_filter';
		$this->widget_description = __( 'Woocommerce accordion filter', 'appic' );
		$this->widget_id = 'appic_woocommerce_accordion_filter';
		$this->widget_name = __( 'Appic: WooCommerce Accordion Filter', 'appic' );
		parent::__construct();
	}

	/**
	 * Widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void | string
	 */
	public function widget( $args, $instance )
	{
		global $_chosen_attributes, $wpdb, $wp_query, $wp;

		extract( $args );

		if ( !is_post_type_archive( 'product' ) && !is_tax( get_object_taxonomies( 'product' ) ) ) {
			return;
		}

		// prefix for cookies that store state of accordions used in the filter
		$filter_cookie_prefix = 'themefilter_';

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$show_price_filter = isset( $instance['show_price_filter'] ) ? $instance['show_price_filter'] : 'yes';
		$show_quantity_product = isset( $instance['show_quantity_product'] ) ? $instance['show_quantity_product'] : 'yes';
		$show_color_filter = isset( $instance['show_color_filter'] ) ? $instance['show_color_filter'] : 'yes';

		$srciptItems = array();
		// Start color filter
		$color_accordion_group = '';
		if ( 'yes' == $show_color_filter ) {
			$taxonomy = wc_attribute_taxonomy_name( self::$attribute_color );
			if ( taxonomy_exists( $taxonomy ) ) {
				$terms = get_terms( $taxonomy );
				if ( count( $terms ) > 0 ) {

					$get_var_filter_color = self::$filter_color_var_get;
					$get_var_filter_color_query_tyep = self::init_varible_filter_color_query_type();
					$current_color = self::get_value_varidle_filter($get_var_filter_color);
					$multi_color_select = '';
					$current_arr = array();
					if ( !empty( $current_color ) ) {
						$current_arr = explode( ',', $current_color );
						$current_arr = array_flip( $current_arr );
						$multi_color_select = $current_color;
					}

					$colorBaseUrl = add_query_arg(array(
						$get_var_filter_color_query_tyep => $instance['query_type_for_color'],
						'page' => false,
						'paged' => false,
					));
					// reseting the pagination for permalinks
					if ( get_option( 'permalink_structure' ) != '' ) {
						$colorBaseUrl = preg_replace( '`\/page\/[0-9]+`', '', $colorBaseUrl );
					};

					$color_list = '<ul class="color-box inline">';
					foreach ( $terms as $term ) {
						$isPresent = isset( $current_arr[$term->term_id] );

						$newColorsFilter = !$isPresent
							? $multi_color_select . ($multi_color_select ? ',' : '') . $term->term_id
							: preg_replace('`('.$term->term_id.'[^1-9],?)|(,?'.$term->term_id.'$)`','', $multi_color_select);

						$linkAttributes = array(
							'style="background-color:' . (isset($instance['colors'][$term->slug]) ? $instance['colors'][$term->slug] : $this->undefinedFilterColor) . ';"',
							'href="' . add_query_arg($get_var_filter_color, $newColorsFilter, $colorBaseUrl) . '"',
							'title="' . ($isPresent ? ' - ' : ' + ') . esc_attr($term->name) . '"',
						);

						$color_list .= '<li'.($isPresent ? ' class="chosen"' : '').'><a ' . join(' ', $linkAttributes) . '.></a></li>';
					}

					$color_list .= '</ul>';
					if ( !empty( $current_color )) {
						$color_list .= '<div><a href="' . remove_query_arg($get_var_filter_color) . '">' . __('Reset all', 'appic') . '</a></div>';
					}

					$filter_cookie_name = $filter_cookie_prefix .'color';
					$color_is_open = isset($_COOKIE[$filter_cookie_name]) && $_COOKIE[$filter_cookie_name] == '1';

					$color_accordion_group = '<div class="accordion-group">' .
						'<div class="accordion-heading">' .
							'<a data-paramname="color" class="accordion-toggle '. ($color_is_open ? 'accordion-minus' : 'accordion-plus') .'" data-toggle="collapse" href="#collapse1-3">Color</a>' .
						'</div>' .
						'<div id="collapse1-3" class="accordion-body '. ($color_is_open ? 'in collapse' : 'collapse') .'">' .
							'<div class="accordion-inner">' .
							$color_list .
						'</div>' .
						'</div>' .
					'</div>';
				}
			}
		}
		// End color filter

		// Start price filter
		$price_accordion_group = '';
		if ( 'yes' == $show_price_filter && class_exists( 'WC_Widget_Price_Filter' ) ) {
			ob_start();
			the_widget('WC_Widget_Price_Filter', array( 'title' => '' ) );
			$priceFilterHtml = ob_get_contents();
			ob_end_clean();

			if ( empty($priceFilterHtml) ) {
				$price_min = self::get_value_varidle_filter( self::$filter_price_var_get_min );
				$price_max = self::get_value_varidle_filter( self::$filter_price_var_get_max );

				if ( !empty($price_min) || !empty($price_man) ) {
					$price_min = !empty( $price_min ) ? __( 'Price min: ', 'appic' ) . $price_min : '';
					$price_max = !empty( $price_max ) ? __( 'Price max: ', 'appic' ) . $price_max : '';
					$price_info_delimiter = $price_min && $price_max ? ' - ' : '';

					$priceFilterHtml = '<div>' .
						'<div>' . $price_min . $price_info_delimiter .$price_max . '</div>' .
						'<a href="' . remove_query_arg( array( self::$filter_price_var_get_max, self::$filter_price_var_get_min ) ) . '">' . __( 'Reset all', 'appic' ) . '</a>' .
					'</div>';
				}
			}

			if ( !empty($priceFilterHtml) ) {
				$filter_cookie_name = $filter_cookie_prefix .'price';
				$price_is_open = isset($_COOKIE[$filter_cookie_name]) && $_COOKIE[$filter_cookie_name] == '1';

				$price_accordion_group = '<div class="accordion-group">' .
					'<div class="accordion-heading">' .
						'<a data-paramname="price" class="accordion-toggle '. ($price_is_open ? 'accordion-minus' : 'accordion-plus') .'" data-toggle="collapse" href="#collapse1-1">Price</a>' .
					'</div>' .
					'<div id="collapse1-1" class="accordion-body '.($price_is_open ? 'in ' : '').'collapse">' .
						'<div class="accordion-inner">' .
							$priceFilterHtml .
						'</div>' .
					'</div>' .
				'</div>';
			}
		}
		// End price filter

		// Start product quantity
		$quantity_product_accordion_group = '';
		// locked for now
		if ( false && 'yes' == $show_quantity_product && self::$pagination_list) {
			$qvar = $wp_query->query_vars;
			if ( !empty( $qvar['post_type'] ) && 'product' == $qvar['post_type'] ) {
				$quantity_product_per_page = $wp_query->query_vars['posts_per_page'];
			}
			$quantity_item = self::$pagination_list;

			$page_size_field_name = self::$quantity_product_var_get;

			$quantity_num = self::get_value_varidle_filter( self::$quantity_product_var_get );

			$quantity_selected = !empty( $quantity_num ) ? $quantity_num : $quantity_product_per_page;

			$getArgs = $_GET;
			if (isset($getArgs[self::$quantity_product_var_get])) {
				unset($getArgs[self::$quantity_product_var_get]);
			}

			$quantity_product = '<div class="custom-select">' .
				'<form id="filter-accordion-quantity" method="get" action="'. remove_query_arg( self::$quantity_product_var_get ).'"">' .
					'<select name="' . self::$quantity_product_var_get . '" id="page-quantity" tabindex="1">' .
						$this->render_options_html(self::$pagination_list, $quantity_selected) .
					'</select>' .
					self::build_hidden_fields($getArgs) .
				'</form>' .
			'</div>';

			$filter_cookie_name = $filter_cookie_prefix .'pagesize';
			$quantity_is_open = isset($_COOKIE[$filter_cookie_name]) && $_COOKIE[$filter_cookie_name] == '1';

			$quantity_product_accordion_group = '<div class="accordion-group">' .
				'<div class="accordion-heading">' .
					'<a data-paramname="pagesize" class="accordion-toggle '. ($quantity_is_open ? 'accordion-minus' : 'accordion-plus') .'" data-toggle="collapse" href="#collapse1-2">'.__('Products per page','appic').'</a>' .
				'</div>' .
				'<div id="collapse1-2" class="accordion-body '.($quantity_is_open ? 'in ' : '').'collapse">' .
					'<div class="accordion-inner">' .
						$quantity_product .
					'</div>' .
				'</div>' .
			'</div>';

			wp_enqueue_script( 'selectbox' );
			$srciptItems[] = '$("#page-quantity").change(function(){this.form.submit();}).selectbox();';
			if ($quantity_num) {
				// to add page size option to price filters
				$srciptItems[] = 'jQuery(\'.widget[class*=filter] form\').each(function(){' .
					'jQuery(\'<input type="hidden" name="' . $page_size_field_name . '" value="' . $quantity_num .'" />\').appendTo(this);' .
				'});';
			}
		}
		// End product quantity

		if ( !empty( $price_accordion_group ) || !empty( $quantity_product_accordion_group ) || !empty( $color_accordion_group ) ) {
			$output = $before_widget .
				'<h3 class="page-elements-title">'.$title.'</h3>' .
				'<div class="accordion style-2 filter" id="accordion2323">' .
					$price_accordion_group .
					$color_accordion_group .
					$quantity_product_accordion_group .
				'</div>'.
			$after_widget;

			echo $output;

			$srciptItems[] = 'jQuery("#'.$widget_id.' .accordion-toggle[data-paramname]").click(function(){' .
				'var el=jQuery(this),' .
				'    isOpen = el.hasClass("accordion-plus");' .
				'theme_setCookie("'.$filter_cookie_prefix.'"+el.data("paramname"),isOpen?"1":"", 7);' .
			'});';
			if ($srciptItems) {
				JsClientScript::addScript( 'filter_accordion_quantity_form_submit',join("\n", $srciptItems));
			}
		}
	}

	/**
	 * Form function.
	 *
	 * @see WP_Widget->form
	 * @access public
	 * @param array $instance
	 * @return void
	 */
	public function form( $instance )
	{
		$defaults = array(
			'title' => __( 'Filters:', 'appic' ),
			'show_price_filter' => 'yes',
			'show_quantity_product' => 'no',
			'show_color_filter' => 'yes',
			'query_type_for_color' => 'and',
		);

		$colors = self::get_color_list();
		foreach ($colors as $color) {
			$defaults['colors'][$color] = '#000000';
		}
		$instance = wp_parse_args( (array) $instance, $defaults );

		if ( 'yes' == $instance['show_color_filter'] ) {
			$style = 'style="display:block;';
		} else {
			$style = 'style="display:none;"';
		}

		$output = '<p>' .
			'<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title:', 'appic' ) . '</label><br>' .
			'<input style="width: 100%;" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . esc_attr( $instance['title'] ) . '" />' .
		'</p>' .
		'<p>' .
			'<label for="' . $this->get_field_id( 'show_price_filter' ) . '">' . __( 'Show price filter', 'appic' ) . '</label><br>' .
			'<select class="widefat" style="width: 100%;" name="' . $this->get_field_name( 'show_price_filter' ) . '">' .
			$this->render_options_html(array(
					'yes' => __( 'Yes', 'appic' ),
					'no' => __( 'No', 'appic' ),
				),
				$instance['show_price_filter']
			) .
			'</select>' .
		'</p>' .
		/*'<p>' .
			'<label for="' . $this->get_field_id( 'show_quantity_product' ) . '">' . __( 'Show producs per page', 'appic' ) . '</label><br>' .
			'<select class="widefat" style="width: 100%;" name="' . $this->get_field_name( 'show_quantity_product' ) . '">' .
			$this->render_options_html(array(
					'yes' => __( 'Yes', 'appic' ),
					'no' => __( 'No', 'appic' ),
				),
				$instance['show_quantity_product']
			) .
			'</select>' .
		'</p>' .*/
		'<p>' .
			'<label for="' . $this->get_field_id( 'show_color_filter' ) . '">' . __( 'Show color filter', 'appic' ) . '</label><br>' .
			'<select data-role="color-switcher" class="widefat" style="width: 100%;" name="' . $this->get_field_name( 'show_color_filter' ) . '">' .
			$this->render_options_html(array(
					'yes' => __( 'Yes', 'appic' ),
					'no' => __( 'No', 'appic' ),
				),
				$instance['show_color_filter']
			) .
			'</select>' .
		'</p>' .
		'<div data-role="colors-selector" ' . $style . '>' .
			'<p>' .
				'<label for="' . $this->get_field_id( 'query_type_for_color' ) . '">' . __( 'Query type for color filter', 'appic' ) . '</label><br>' .
				'<select class="widefat" style="width: 100%;" name="' . $this->get_field_name( 'query_type_for_color' ) . '">' .
				$this->render_options_html(array(
						'and' => __( 'AND', 'appic' ),
						'or' => __( 'OR', 'appic' ),
					),
					$instance['query_type_for_color']
				) .
				'</select>' .
			'</p>';

		$output .= '<label>' . __( 'Colors for color filter (e.g. #EEE)', 'appic' ) . '</label><br>';
		foreach ( $colors as $color ) {
			$output .= '<p>' .
				'<input style="width: 50%;" id="' . $this->get_field_id( $color ) . '" name="' . $this->get_field_name( $color ) . '" value="' . esc_attr( $instance['colors'][$color] ) . '" />' .
				'<label style="widgth:50%">' . __( ' - ' . $color, 'appic' ) . '</label>' .
			'</p>';
		}
		$output .= '</div>';

		JsClientScript::addScript( 'show_color_settings','jQuery("[data-role=\'color-switcher\']").live("change", function(){' .
			'var block = jQuery("[data-role=\'colors-selector\']", this.form);' .
			'if ("yes" == jQuery(this).val()) {' .
				'block.show();' .
			'} else {' .
				'block.hide();' .
			'}' .
		'});');

		echo $output;
	}

	/**
	 * Update function.
	 *
	 * @see WP_Widget->update
	 * @access public
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['show_price_filter'] = $new_instance['show_price_filter'];
		$instance['show_quantity_product'] = $new_instance['show_quantity_product'];
		$instance['show_color_filter'] = $new_instance['show_color_filter'];
		$instance['query_type_for_color'] = $new_instance['query_type_for_color'];

		$colors = self::get_color_list();
		foreach ( $colors as $color ) {
			$instance['colors'][$color] = $new_instance[$color];
		}
		return $instance;
	}

	/**
	 * Set quantity probuct in page.
	 * @param object $wp_query
	 */
	static public function products_quantity( $wp_query )
	{
		$quantity_product = self::get_value_varidle_filter( self::$quantity_product_var_get );
		if ( !empty( $quantity_product ) ) {
			$qvar = $wp_query->query_vars;
			if ( empty( $qvar->query_vars['posts_per_page'] ) && !empty( $qvar['post_type'] ) && 'product' == $qvar['post_type'] ) {
				$qvar->query_vars['posts_per_page'] = $quantity_product;
			}
		}
	}

	/**
	 * Render options html.
	 * @param array $options
	 * @param string $selectedValue
	 * @return string
	 */
	private function render_options_html( array $options, $selectedValue = '' )
	{
		$result = '';
		foreach ($options as $val => $label) {
			$selectedAttr = $val == $selectedValue ? ' selected="selected"' : '';
			$result .= '<option value="'. $val .'"' . $selectedAttr . '>'.$label.'</option>';
		}
		return $result;
	}

	/**
	 * Get color slugs.
	 * @return array
	 */
	private static function get_color_list()
	{
		static $colors;
		if (!$colors) {
			$taxonomy = wc_attribute_taxonomy_name( self::$attribute_color );
			if ( taxonomy_exists( $taxonomy ) ) {
				$terms = get_terms( $taxonomy );
				if ($terms) {
					foreach ( $terms as $term ) {
						$colors[] = $term->slug;
					}
				}
			}
		}
		return ( array ) $colors;
	}

	/**
	 * Get value varibles GET for filters.
	 * @return string
	 */
	private static function get_value_varidle_filter( $varible )
	{
		return isset( $_GET[$varible] ) ? esc_attr( $_GET[$varible] ) : '';
	}

	/**
	 * Creates a variable query_type for filter color.
	 * @return srting | void
	 */
	private static function init_varible_filter_color_query_type()
	{
		$varible = '';
		if ( !empty( self::$filter_color_query_type ) && !empty( self::$filter_color_var_get ) ) {
			$varible = self::$filter_color_query_type . self::$attribute_color;
		}
		return $varible;
	}

	private static function build_hidden_fields(array $fields, $baseName='', $returnAsString = true)
	{
		$items = array();
		if (!$fields) {
			return $returnAsString ? '' : $items;
		}
		foreach ($fields as $key => $value) {
			$fieldName = $baseName ? $baseName . '['.$key.']' : $key;
			if (is_string($value)) {
				$items[] = '<input type="hidden" name="' . $fieldName . '" value="'. esc_attr($value) .'" />';
			} else {
				$items[] = self::build_hidden_fields($value, $fieldName);
			}
		}
		return $returnAsString ? join('', $items) : $items;
	}
}
register_widget( 'Appic_WC_Widget_Accordion_Filters' );
