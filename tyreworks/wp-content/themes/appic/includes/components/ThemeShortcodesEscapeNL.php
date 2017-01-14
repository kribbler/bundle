<?php
/**
 * Class allows escape unexpected <br /> & <p> tags between nested theme shortcodes.
 * For example we have following structute of the shortcodes:
 * <pre>
 * [table]
 * 	[tr]
 * 		[td]cell 1[td]
 * 		[td]cell 2[/td]
 * 	[/tr]
 * [/table]
 * </pre>
 *
 * So to prevent tags P or BR between table, tr, td tags we should register this structure via following call:
 * <pre>
 * ThemeShortcodesEscapeNL::register_nested_shortcods('table','tr','td');
 *
 * //or alternative way:
 * ThemeShortcodesEscapeNL::add_relation('table','tr');
 * ThemeShortcodesEscapeNL::add_relation('tr','td');
 * </pre>
 * 
 * @author kollega <oleg.kutcyna@gmail.com>
 * @version  1.0
 */
class ThemeShortcodesEscapeNL
{
	/**
	 * Stores list of possible parent & child tags combinations.
	 * @see is_nested
	 * @var array
	 */
	protected static $relation_variations = array();

	protected static $delimiter = '|';

	/**
	 * Parts of the regexp.
	 * @var array
	 */
	protected static $regPartsOpens = array();

	/**
	 * Parts of the regexp.
	 * @var array
	 */
	protected static $regPartsCloses = array();

	/**
	 * Flag that stores init state.
	 * @var boolean
	 */
	private static $inited = false;

	/**
	 * Component init method
	 * @return [type] [description]
	 */
	public static function init()
	{
		if (!self::$inited) {
			add_filter('the_content', array('ThemeShortcodesEscapeNL','remove_whitespaces'), 2);
			self::$inited = true;
		}
	}

	/**
	 * Registers relations between all arguments passed to the function.
	 * @example
	 * <pre>
	 * ThemeShortcodesEscapeNL::register_nested_shortcods('table','tr','td');
	 * </pre>
	 * @return void
	 */
	public static function register_nested_shortcods()
	{
		$items = func_get_args();

		if (count($items) < 2) {
			return;
		}

		$parent = array_shift($items);

		foreach ($items as $child) {
			self::add_relation($parent, $child);
			$parent = $child;
		}
	}

	/**
	 * Registers relation between parent and child shortcodes.
	 * @example
	 * <pre>
	 * ThemeShortcodesEscapeNL::add_relation('table','tr');
	 * ThemeShortcodesEscapeNL::add_relation('tr','td');
	 * </pre>
	 * 
	 * @param string $parent name of the parent shortcode
	 * @param string $child  name of the child shortcode
	 * @return void
	 */
	public static function add_relation($parent, $child)
	{
		self::$relation_variations[] = $parent . self::$delimiter . $child;
		self::$relation_variations[] = '/' . $child . self::$delimiter . '/' . $parent;
		self::$relation_variations[] = '/' . $child . self::$delimiter . $child;

		self::push_to_regexp_parts('open', $parent);
		self::push_to_regexp_parts('open', '\/' . $child);

		self::push_to_regexp_parts('close', '\/' . $parent);
		self::push_to_regexp_parts('close', '\/?' . $child);
	}

	public static function remove_whitespaces($content)
	{
		return preg_replace_callback(self::get_regexp(),array('ThemeShortcodesEscapeNL','_parse_callback'), $content);
	}

	public static function _parse_callback($res)
	{
		$fullText = $res[0];
		if (self::is_nested($res[1], $res[3])) {
			return preg_replace('`(\])\s+(\[)`', '$1$2', $fullText);
		}
		return $fullText;
	}

	public static function get_regexp()
	{
		//$result = '`\[\/?(\w+)[^\]]*\](\s)+\[\/?(\w+)[^\]]*\]`';
		$attributesPattern = '[^\]]*';
		return '`\[('.join('|', self::$regPartsOpens).')'.$attributesPattern.'\](\s)+\[('.join('|', self::$regPartsCloses).')'.$attributesPattern.'\]`';
	}

	protected static function push_to_regexp_parts($type, $regexp)
	{
		if ('open' == $type) {
			$targetList = &self::$regPartsOpens;
		} else {
			$targetList = &self::$regPartsCloses;
		}
		if (!isset($targetList[$regexp])) {
			$targetList[$regexp] = $regexp;
		}
	}

	public static function is_nested($tag1, $tag2)
	{
		return in_array($tag1 . self::$delimiter . $tag2, self::$relation_variations);
	}
}
