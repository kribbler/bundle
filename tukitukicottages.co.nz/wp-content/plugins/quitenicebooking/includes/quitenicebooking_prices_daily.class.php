<?php
/**
 * Defines the daily price class
 */
class Quitenicebooking_Prices_Daily {
	/**
	 * Properties ==============================================================
	 */
	
	/**
	 * @var int $id The loaded post ID
	 */
	public $id;
	
	/**
	 * @var array Key definitions; see constructor
	 */
	public $keys;
	
	/**
	 * @var Quitenicebooking_Entity_* An instance of the entity scheme
	 */
	public $entity_scheme;
	
	/**
	 * Methods =================================================================
	 */

	/**
	 * Constructor
	 * Creates a new instance of the class, defines keys, and instantiates the entity scheme class
	 * 
	 * @param string $entity_scheme The name of the entity scheme, such as 'per_room', 'per_person'
	 */
	public function __construct($entity_scheme) {
		// instantiate the entity class
		$entity_class = 'Quitenicebooking_Entity_'.str_replace(' ', '_', ucwords(str_replace('_', ' ', $entity_scheme)));
		$this->entity_scheme = new $entity_class();
		// define meta keys and descriptions
		$this->keys = array();
		$this->keys['prices']['weekday']['meta_part'] = 'weekday';
		$this->keys['prices']['weekday']['description'] = __('Weekdays (Mon-Thu)', 'quitenicebooking');
		$this->keys['prices']['weekend']['meta_part'] = 'weekend';
		$this->keys['prices']['weekend']['description'] = __('Weekends (Fri-Sun)', 'quitenicebooking');
		
		foreach ($this->entity_scheme->keys as $entity_key) {
			$this->keys['composed'][$entity_key['meta_part'].'_weekday']['meta_key'] = 'quitenicebooking_price_per_'.$entity_key['meta_part'].'_weekday';
			$this->keys['composed'][$entity_key['meta_part'].'_weekday']['meta_part'] = $entity_key['meta_part'].'_weekday';
			$this->keys['composed'][$entity_key['meta_part'].'_weekend']['meta_key'] = 'quitenicebooking_price_per_'.$entity_key['meta_part'].'_weekend';
			$this->keys['composed'][$entity_key['meta_part'].'_weekend']['meta_part'] = $entity_key['meta_part'].'_weekend';
		}
	}
	
	/**
	 * Load prices for an ID
	 * 
	 * @param int $id The post ID
	 * @throws Exception If price meta is blank for some reason
	 */
	public function load_prices($id) {
		$meta = get_post_meta($id);
		$this->id = $id;
		foreach ($this->keys['composed'] as $composed_key) {
			$this->{$composed_key['meta_part']} = $meta[$composed_key['meta_key']][0];
		}		
	}
	
	/**
	 * Calculates a unit price (1 day)
	 * load_prices() must already be run
	 * Executes calc_unit_price hook if available
	 * 
	 * @param int $date The date as a unix timestring
	 * @param array $entity_callback_args Parameters to pass to the callback
	 * @return float The price for the day
	 */
	public function calc_unit_price($date, $entity_callback_args) {
		$total = 0.0;
		if (in_array(date('N', $date), array(5, 6, 7))) {
			// weekend pricing
			foreach (array_keys($this->entity_scheme->keys) as $entity_key) {
				// load the base price
				$base_price = $this->{"{$entity_key}_weekend"};
				// filter the base price if there's a filter
				if (has_filter('calc_unit_price')) {
					$base_price = apply_filters(
						'calc_unit_price', // hook // TODO check has_filter()
						array(
							'base_price' => $this->{"{$entity_key}_weekend"}, // base price
							'meta_name' => "{$entity_key}_weekend", // meta_name
							'date' => $date, // date
							'id' => $this->id // accommodation ID
						)
					);
				}
				
				$total += call_user_func_array(
					array($this->entity_scheme, 'calc'), // entity_scheme callback
					array(
						$base_price, // base price, filtered
						$entity_key, // key
						$entity_callback_args // params
					)
				);
			}
		} else {
			// weekday pricing
			foreach (array_keys($this->entity_scheme->keys) as $entity_key) {
				// load the base price
				$base_price = $this->{"{$entity_key}_weekday"};
				// filter the base price if there's a filter
				if (has_filter('calc_unit_price')) {
					$base_price = apply_filters(
						'calc_unit_price', // hook // TODO check has_filter()
						array(
							'base_price' => $this->{"{$entity_key}_weekday"}, // base price
							'meta_name' => "{$entity_key}_weekday", // meta_name
							'date' => $date, // date
							'id' => $this->id // accommodation ID
						)
					);
				}
				
				$total += call_user_func_array(
					array($this->entity_scheme, 'calc'), // entity_scheme callback
					array(
						$base_price, // base price, filtered
						$entity_key, // key
						$entity_callback_args // params
					)
				);
			}
		}
		return $total;
	}
	
	/**
	 * Returns the next time unit
	 * 
	 * @param int $date The current date as a unix timestamp
	 * @return int Tomorrow's timestamp
	 */
	public function next_unit($date) {
		return $date + 86400;
	}
	
	/**
	 * Saves the meta defined in this class
	 * 
	 * @param int $id The post ID
	 * @param array $post The $_POST array
	 */
	public function save_meta($id, $post) {
		foreach ($this->keys['composed'] as $key => $defs) {
			if (isset($post[$defs['meta_key']])) {
				update_post_meta($id, $defs['meta_key'], sanitize_text_field($post[$defs['meta_key']]));
			}
		}
	}
}
