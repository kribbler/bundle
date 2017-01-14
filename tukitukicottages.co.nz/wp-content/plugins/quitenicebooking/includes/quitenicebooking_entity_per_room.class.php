<?php
/**
 * Defines the 'per_room' entity
 */
class Quitenicebooking_Entity_Per_Room {
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
		$this->keys['room']['meta_part'] = 'room';
		$this->keys['room']['description'] = __('Per Room', 'quitenicebooking');
	}
	
	/**
	 * Calculate unit price
	 * 
	 * @param float $base_price The base price
	 * @param string $key 'room', unused
	 * @param array $args Unused
	 * @return float The unit price
	 */
	public function calc($base_price, $key = NULL, $args = NULL) {
		return $base_price;
	}
}
