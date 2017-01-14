<?php
/**
 * Class for inline JS injections.
 * @example
 * <pre>
 * // to execute code on document redy event
 * JsClientScript::addScript('initExampleClass','Example.init({x:100,y:200});');
 * 
 * // to execute code in footer (without any wrappers)
 * JsClientScript::addScript('initExampleClass','Example.init({x:100,y:200});', JsClientScript::POS_FOOTER);
 * </pre>
 * 
 * @author kollega <oleg.kutcyna@gmail.com>
 * @version  1.0
 */
class JsClientScript
{
	private static $onReady = array();

	private static $footerScripts = array();

	private static $footerScriptFiles = array();

	const POS_ON_READY = 1;

	const POS_FOOTER = 2;

	const HANDLER_FOOTER = 1;

	private static $addedHandlers = array();

	public static function initHandler($type)
	{
		if (empty(self::$addedHandlers[$type])) {
			self::$addedHandlers[$type] = true;
		} else {
			return false;
		}

		switch($type){
			case self::HANDLER_FOOTER:
				//wp_footer
				$actionName = is_admin() ? 'admin_print_footer_scripts' : 'wp_print_footer_scripts';
				add_action($actionName, array('JsClientScript', 'printFooteScripts'));
			break;
		}
	}

	public static function addScript($id, $text, $position = 1)
	{
		self::initHandler(self::HANDLER_FOOTER);
		switch($position) {
		case self::POS_FOOTER:
			self::$footerScripts[$id] = $text;
			break;
		case self::POS_ON_READY:
			self::$onReady[$id] = $text;
			break;
		default:
			throw new Exception("Unsupported value for position parameter ($position).");
			break;
		}
	}

	public static function addScriptScriptFile($id, $url, $position = 2)
	{
		self::initHandler(self::HANDLER_FOOTER);
		switch ($position) {
		case self::POS_FOOTER:
			self::$footerScriptFiles[$id] = $url;
			break;
		default:
			throw new Exception("Unsupported value for position parameter ($position).");
			break;
		}
	}

	public static function getOnReadyScriptText($withoutReset = false)
	{
		$result = '';
		if (self::$onReady) {
			$result = 'jQuery(document).ready(function($){'.
				join("\n", self::$onReady) . 
			"\n" .'})';
			if (!$withoutReset) {
				self::$onReady = array();
			}
		}
		return $result;
	}

	public static function getFooterScriptsText($withoutReset = false)
	{
		$result = '';
		if (self::$footerScriptFiles) {
			foreach (self::$footerScriptFiles as $url) {
				$result .= '<script type="text/javascript" src="'.$url.'"></script>' . "\n";
			}
			if (!$withoutReset) {
				self::$footerScriptFiles = array();
			}
		}
		if (self::$footerScripts) {
			foreach (self::$footerScripts as $jsCode) {
				$result .= '<script type="text/javascript">' . $jsCode . '</script>' . "\n";
			}
			if (!$withoutReset) {
				self::$footerScripts = array();
			}
		}
		if ($onReadyScript = self::getOnReadyScriptText($withoutReset)) {
			$result .= '<script type="text/javascript">' . $onReadyScript . '</script>' . "\n";
		}
		return $result;
	}

	public static function printFooteScripts()
	{
		echo self::getFooterScriptsText();
	}
}
