<?php
/**
 * Defines the 'per_person' entity
 */
class Quitenicebooking_Entity_Per_Person {
	/**
	 * Properties ==============================================================
	 */
	
	/**
	 * @var array Key definitions; see constructor
	 */
	public $keys;
	
	/**
	 * Methods =================================================================
	 */
	
	/**
	 * Constructor
	 * Creates a new instance of this class, defines keys
	 */
	public function __construct() {
		$this->keys = array();
		$this->keys['adult']['meta_part'] = 'adult';
		$this->keys['adult']['description'] = __('Per Adult', 'quitenicebooking');
		$this->keys['child']['meta_part'] = 'child';
		$this->keys['child']['description'] = __('Per Child', 'quitenicebooking');
	}
	
	/**
	 * Calculate unit price
	 * 
	 * @param float $base_price The base price
	 * @param string $key Either 'adult' or 'child'
	 * @param array $args Parameters
	 *		array('adults' => int, 'children' => int)
	 * @return float The unit price
	 */
	public function calc($base_price, $key, $args) {
		$adult = $args['adults'];
		$child = $args['children'];
		return $base_price * ${$key};
	}
}
