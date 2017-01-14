<?php
/**
 * Implementation of the background position selector field for the Vaffpress framework.
 *
 * @author kollega <oleg.kutcyna@gmail.com>
 * @version 1.0
 */
class VP_Control_Field_BackgroundPosition extends VP_Control_Field
{
	protected $_default = array(
		'h' => 'top',
		'v' => 'left',
		'repeat' => 'no-repeat',
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
		$this->add_data('verticalOptions', self::getVerticalOptions());
		$this->add_data('horizontalOptions', self::getHorizontalOptions());
		$this->add_data('repeatOptions', self::getRepeatOptions());
		parent::_setup_data();
	}

	private static function getVerticalOptions()
	{
		static $vOptions;
		if (!$vOptions) {
			$vOptions = array(
				'left' => __('Left', 'appic'),
				'center' => __('Center', 'appic'),
				'right' => __('Right', 'appic'),
			);
		}
		return $vOptions;
	}

	private static function getHorizontalOptions()
	{
		static $hOptions;
		if (!$hOptions) {
			$hOptions = array(
				'top' => __('Top', 'appic'),
				'center' => __('Middle', 'appic'),
				'bottom' => __('Bottom', 'appic'),
			);
		}
		return $hOptions;
	}

	private static function getRepeatOptions()
	{
		static $repeatOptions;
		if (!$repeatOptions) {
			$repeatOptions = array(
				'repeat' => __('Repeat', 'appic'),
				'no-repeat' => __('No Repeat', 'appic'),
				'repeat-x' => __('Repeat Horizontally', 'appic'),
				'repeat-y' => __('Repeat Vertically', 'appic'),
			);
		}
		return $repeatOptions;
	}

	public function render($is_compact = false)
	{
		$this->_setup_data();
		$this->add_data('is_compact', $is_compact);
		return VP_View::instance()->load('control/backgroundposition', $this->get_data());
	}
}
