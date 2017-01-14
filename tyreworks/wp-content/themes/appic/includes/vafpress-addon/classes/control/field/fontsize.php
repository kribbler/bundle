<?php
/**
 * Implementation of the font size selector field for the Vaffpress framework.
 *
 * @author kollega <oleg.kutcyna@gmail.com>
 * @version 1.0
 */
class VP_Control_Field_FontSize extends VP_Control_Field implements VP_MultiSelectable
{
	protected $_default = array(
		//'size' => '14','dem' => 'px',
		'14','px'
	);

	public function __construct()
	{
		parent::__construct();
	}

	public static function withArray($arr = array(), $class_name = null)
	{
		if(is_null($class_name))
			$instance = new self();
		else
			$instance = new $class_name;
		$instance->_basic_make($arr);
		return $instance;
	}

	protected function _setup_data()
	{
		$opt = array(
			'value' => $this->get_value(),
		);
		//$this->add_data('opt', VP_Util_Text::make_opt($opt));
		$this->add_data('dementionOptions', self::getDementionOptions());
		parent::_setup_data();
	}

	public function render($is_compact = false)
	{
		$this->_setup_data();
		$this->add_data('is_compact', $is_compact);
		return VP_View::instance()->load('control/fontsize', $this->get_data());
	}

	public static function getDementionOptions()
	{
		static $demList;
		if ( ! $demList ) {
			$demList = array(
				'px' => 'px',
				'em' => 'em',
				'%' => '%',
			);
		}

		return $demList;
	}
}
