<?php
/**
 * Class for inline css generation based on the values of theme options.
 * 
 * @author kollega <oleg.kutcyna@gmail.com>
 * @version  1.0
 */
class ThemeCssGenerator
{
	/**
	 * Default values that already implemented in theme css file.
	 * If setting will has same value - pice of related css can be "omitted".
	 * Name of the option should be used as a key, value is default value of this option.
	 * @var assoc
	 */
	public $cssSettingDefaults = array();

	/**
	 * List of webfonts that should be included in any case.
	 * Font family should be used as a key, value should contains a list of styles that should be loaded.
	 * @example
	 * <pre>
	 * public $defaultRequiredFonts = array(
	 * 	'Oswald' => array(
	 * 		'400' => '400',
	 * 	),
	 * 	'PT Sans' => array(
	 * 		'400' => '400',
	 * 		'700' => '700',
	 * 		'400italic' => '400italic',
	 * 	),
	 * );
	 * </pre>
	 * @var array
	 */
	public $defaultRequiredFonts = array();

	/**
	 * List of webfonts that have been found in theme settings.
	 * @var array
	 */
	protected $requiredFonts = array();

	/**
	 * Path to the view file that should be used for css generation.
	 * @var string
	 */
	public $viewFile = '';

	public function __construct($viewFile)
	{
		$this->viewFile = $viewFile;
	}

	public function generateCss($themeSettings, $plainCss = false)
	{
		$data = $this->getCssSettings($themeSettings);

		if (empty($data)) {
			return '';
		}

		$this->resetRequiredFonts();

		$cssText = $this->renderView($this->viewFile, $data);

		if ($plainCss) {
			return $cssText;
		}

		$parts = array();
		if ($webfontsUrl = $this->getWebFontsApiUrlTags()) {
			$parts[] = '<link href="' . $webfontsUrl. '" rel="stylesheet" />';
		}

		if ($cssText) {
			$parts[] = '<style type="text/css">';
			$parts[] = $cssText;
			$parts[] = '</style>';
		}

		return join("\n", $parts);
	}

	public function getCssSettingDefaultValues()
	{
		return $this->cssSettingDefaults;
	}

	private function getCssSettings($themeSettings, $ignoreDefaultValues = true)
	{
		$result = array();
		$defaults = $this->getCssSettingDefaultValues();

		if (!empty($defaults)) {
			foreach($defaults as $name => $defValue) {
				$paramValue = isset($themeSettings[$name]) ? $themeSettings[$name] : '';
				if ($ignoreDefaultValues) {
					$cmpVal = is_array($paramValue) ? join('', $paramValue) : $paramValue;
					$cmpDef = is_array($defValue) ? join('', $defValue) : $defValue;
					if ($cmpVal == $cmpDef) {
						continue;
					}
				}
				$result[$name] = $paramValue;
			}
		}
		return $this->cssSettingsMod($result);
	}

	public function cssSettingsMod($cssSettings)
	{
		return $cssSettings;
	}

	private function renderView($file, $data)
	{
		if (!$file) {
			throw new Exception('Parameter file is empty.');
		}

		if (!file_exists($file)) {
			throw new Exception(strtr('File "{file}" does not exists.', array(
				'{file}' => $file
			)));
		}

		ob_start();
		ob_implicit_flush(false);
		extract($data);
		require($file);
		return ob_get_clean();
	}

	/*** methods related on the fonts processing [start] ***/
	public function resetRequiredFonts()
	{
		$this->requiredFonts = $this->defaultRequiredFonts;
	}

	public function getWebFontsApiUrlTags()
	{
		$families = array();

		foreach ($this->requiredFonts as $faceName => $info) {
			$paramText = str_replace(' ', '+', $faceName);

			if (!empty($info)) {
				$paramText .= ':' . join(',', $info);
			}

			$families[] = $paramText;
		}

		if ($families) {
			return 'http://fonts.googleapis.com/css?family=' . join('|', $families);
		}
		return '';
	}

	public function registerRequiredFont($fontSettings)
	{
		if (!empty($fontSettings['font-face'])) {
			$newFace = $fontSettings['font-face'];

			if (empty($this->requiredFonts[$newFace])) {
				$this->requiredFonts[$newFace] = array();
			}

			$newWeight = !empty($fontSettings['font-weight']) ? $fontSettings['font-weight'] : '';
			$newStyle = !empty($fontSettings['font-style']) ? $fontSettings['font-style'] : '';

			$fullOptionLine = $newWeight . $newStyle;
			if ($fullOptionLine) {
				$this->requiredFonts[$newFace][$fullOptionLine] = $fullOptionLine;
			}
		}
	}

	public function getFontClassContent($fontSettings)
	{
		$filter = array(
			'font-face' => true,
			'font-style' => true,
			'font-weight' => true,
			'color' => true,
		);

		$optionAliases = array(
			'font-face' => 'font-family'
		);

		$parts = array();
		foreach ($fontSettings as $code => $val) {
			if (!isset($filter[$code]) || empty($val)) {
				continue;
			}
			$cssOptionName = isset($optionAliases[$code]) ? $optionAliases[$code] : $code;
			$parts[] = $cssOptionName . ':' . $val .';';
		}

		if ($parts) {
			$this->registerRequiredFont($fontSettings);
		} else {
			return '';
		}

		return join("\n", $parts) . "\n";
	}
	/*** methods related on the fonts processing [end] ***/
}
