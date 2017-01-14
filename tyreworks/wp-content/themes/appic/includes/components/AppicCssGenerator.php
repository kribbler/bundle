<?php
require_once dirname(__FILE__) . '/ThemeCssGenerator.php';

/**
 * Class for Appic theme inline css generation.
 * 
 * @author kollega <oleg.kutcyna@gmail.com>
 * @version  1.0
 */
class AppicCssGenerator extends ThemeCssGenerator
{
	public $defaultRequiredFonts = array(
		'Oswald' => array(
			'400' => '400',
		),
		'PT Sans' => array(
			'400' => '400',
			'700' => '700',
			'400italic' => '400italic'
		),
	);

	public function __construct()
	{
		parent::__construct(PARENT_DIR . '/includes/custom-css-view.php');

		$this->cssSettingDefaults = $this->readDefaults();
	}

	public function cssSettingsMod($cssSettings)
	{
		if (empty($cssSettings)) {
			return $cssSettings;
		}

		$fontPrefixes = array(
			'h1','h2', 'nav', 'body','button'
		);
		$postfixesConverter = array(
			'_font_face' => 'font-face',
			'_font_style' => 'font-style',
			'_font_weight' => 'font-weight',
		);

		foreach ($fontPrefixes as $prefix) {
			$groupSet = array();

			foreach ($postfixesConverter as $postfix => $convertedKey) {
				$fullName = $prefix . $postfix;
				if (isset($cssSettings[$fullName])) {
					if (true === $convertedKey) {
						$convertedKey = $postfix;
					}
					$groupSet[$convertedKey] = $cssSettings[$fullName];
					unset($cssSettings[$fullName]);
				}
			}

			if ($groupSet) {
				$cssSettings[$prefix . '_font_settings'] = $groupSet;
			}
		}

		return $cssSettings;
	}

	public function readDefaults()
	{
		return array(
			'custom_css_text' => '',

			'h1_font_face' => 'PT Sans',
			'h1_font_style' => '',
			'h1_font_weight' => 'normal',//'400'

			'h2_font_face' => 'Oswald',
			'h2_font_style' => '',
			'h2_font_weight' => 'normal',

			'nav_font_face' => 'PT Sans',
			'nav_font_style' => '',
			'nav_font_weight' => 'normal',

			'body_font_face' => 'PT Sans',
			'body_font_style' => '',
			'body_font_weight' => 'normal',

			'button_font_face' => 'PT Sans',
			'button_font_style' => '',
			'button_font_weight' => 'normal',

			'button_font_size' => array('20','px'),
			'large_button_font_size' => array('24','px'),
		);
	}
}
