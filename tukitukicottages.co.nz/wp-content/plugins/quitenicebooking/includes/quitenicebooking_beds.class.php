<?php
/**
 * Defines the bed types
 */
class Quitenicebooking_Beds {
	/**
	 * Properties
	 */
	
	/**
	 * @var array Key definitions; see constructor
	 */
	public $keys;

	/**
	 * Methods
	 * 
	 * @param int $id The accommodation post ID
	 */
	public function __construct() {
		$this->keys = array();
		$this->keys['beds']['king']['meta_key'] = 'quitenicebooking_beds_king';
		$this->keys['beds']['king']['description'] = __('King bed', 'quitenicebooking');
		$this->keys['beds']['queen']['meta_key'] = 'quitenicebooking_beds_queen';
		$this->keys['beds']['queen']['description'] = __('Queen bed', 'quitenicebooking');
		$this->keys['beds']['single']['meta_key'] = 'quitenicebooking_beds_single';
		$this->keys['beds']['single']['description'] = __('Single bed', 'quitenicebooking');
		$this->keys['beds']['double']['meta_key'] = 'quitenicebooking_beds_double';
		$this->keys['beds']['double']['description'] = __('Double bed', 'quitenicebooking');
		$this->keys['beds']['twin']['meta_key'] = 'quitenicebooking_beds_twin';
		$this->keys['beds']['twin']['description'] = __('Twin beds', 'quitenicebooking');
		$this->keys['disabled']['meta_key'] = 'quitenicebooking_disable_beds';
		$this->keys['disabled']['description'] = __('Room', 'quitenicebooking');
	}
	
	/**
	 * Saves the meta defined in this class
	 * 
	 * @param int $id The post ID
	 * @param array $post The $_POST array
	 */
	public function save_meta($id, $post) {
		if (isset($post[$this->keys['disabled']['meta_key']])) {
			update_post_meta($id, $this->keys['disabled']['meta_key'], sanitize_text_field($post[$this->keys['disabled']['meta_key']]));
		}
		foreach ($this->keys['beds'] as $key => $defs) {
			if (isset($post[$defs['meta_key']])) {
				update_post_meta($id, $defs['meta_key'], sanitize_text_field($post[$defs['meta_key']]));
			}
		}
	}
}
