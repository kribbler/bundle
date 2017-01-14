<?php
/**
 * Checks for theme udates and renders notification about them to the root admin.
 * 
 * @author kollega <oleg.kutcyna@gmail.com>
 * @version  1.2 2014-06-10
 */
class ThemeUpdater
{
	/**
	 * Required option. Defines url to the json file with information about latest version.
	 * @var string
	 */
	public $updatesFileUrl = '';

	/**
	 * Theme name.
	 * @var string
	 */
	public $themeName = '';

	/**
	 * Theme slug.
	 * @var string
	 */
	public $themeId = '';

	/**
	 * Prefix required to enable xml file caching.
	 * @var string
	 */
	public $cachePrefix = '';

	/**
	 * Time in seconds during that class will cache file with information about latest version
	 * Default 3 hours.
	 * @var integer
	 */
	public $cacheTime = 10800;

	/**
	 * If set to true class will throws exception with any errors those happens during the init process.
	 * NOTE: should be false for production!
	 * @var boolean
	 */
	public $isDevelopmentMode = false;

	/**
	 * Cache for new version checker.
	 * @see hasNewVersion method
	 * @var boolean
	 */
	private $new_version_check_cache;

	public function __construct(array $options = array())
	{
		if ($options) {
			$this->setOptions($options);
		}

		$this->init();
	}

	/**
	 * Checks requirements and setup all required filters.
	 * @return void
	 */
	protected function init()
	{
		if (!is_super_admin()) {
			return;
		}

		$fileUrl = $this->getUpdatesFileUrl();
		if (empty($fileUrl)) {
			return $this->error('Updates file url is empty.');
		}

		if (!function_exists('json_decode')) {
			return $this->error('Function "json_decode" does not exists.');
		}

		add_action('admin_menu', array($this, 'updateAdminMenu'));

		if (is_admin_bar_showing()) {
			add_action( 'admin_bar_menu', array($this, 'updateAdminBarMenu'), 1000 );
		}
	}

	/**
	 * Renders information about available updates.
	 * @return void
	 */
	public function actionUpdateNotifier()
	{
		$updateDetails = $this->getLatestInformationDetails();
		$theme_data = wp_get_theme($this->themeId);
		
		$updatesFlatLog = array();
		$currentVersion = $theme_data->version;
		if ($updateDetails->changelog) {
			foreach ($updateDetails->changelog as $cVersion => $cList) {
				if (!$cList) {
					continue;
				}
				if (version_compare($cVersion, $currentVersion) == 1) {
					$updatesFlatLog = array_merge($updatesFlatLog, $cList);
				}
			}
		}

		echo $this->renderView('updateNotification.php',array(
			'themeName' => $this->themeName,
			'newVersion' => $updateDetails->latest,
			'currentVersion' => $currentVersion,
			'updatesFlatLog' => $updatesFlatLog,
			'updateInformation' => $updateDetails,
		));
	}

	/**
	 * Adds menu option to the admin's menu if new version of the theme is available.
	 * @return void
	 */
	public function updateAdminMenu()
	{
		if($this->hasNewVersion()){
			$themeName = $this->themeName ? $this->themeName .' ' : '';
			add_theme_page(
				$themeName . __('Theme Updates','appic'),
				$themeName . '<span class="update-plugins count-1"><span class="update-count">' . __('Update','appic') . '</span></span>',
				'administrator',
				'theme-update-notifier',
				array($this, 'actionUpdateNotifier')
			);
		}
	}

	/**
	 * Adds menu option to the admin's menu bar if any new apdates available.
	 * @return void
	 */
	public function updateAdminBarMenu()
	{
		if ($this->hasNewVersion()) {
			global $wp_admin_bar;
			$themeName = $this->themeName ? $this->themeName . ' ' : '';
			$wp_admin_bar->add_menu(array(
				'id' => 'update_notifier',
				'title' => '<span>' . $themeName . '<span id="ab-updates">' . __('New Version', 'appic') . '</span></span>',
				'href' => get_admin_url() . 'themes.php?page=theme-update-notifier'
			));
		}
	}

	/**
	 * Updates internal settings.
	 * @param assoc $options see class properies to get list of available options.
	 */
	public function setOptions(array $options)
	{
		foreach ($options as $name => $value) {
			$this->$name = $value;
		}
	}

	/**
	 * Error reporting method.
	 * @param  string $message
	 *
	 * @throws Exception If $isDevelopmentMode set to true
	 * 
	 * @return boolean
	 */
	protected function error($message)
	{
		if ($this->isDevelopmentMode) {
			if (!$message) {
				$message = strtr('Unknown {className} error.', array(
					'{className}' => get_class($this)
				));
			}
			throw new Exception($message);
		}
		return false;
	}

	/**
	 * Name of the cache option, if $cachePrefix empty - returns empty string, this means that cache is disabled.
	 * @return string
	 */
	protected function getCacheKeyId()
	{
		return $this->cachePrefix ? $this->cachePrefix . '-updater-cache' : '';
	}

	/**
	 * Fallback for case when host with updates information is unavailable.
	 * This state will be saved into cache until the next time checking event.
	 * @return assoc
	 */
	protected function getDefaultInformationDetails()
	{
		$r = new stdClass();
		$r->latest = '1.0';
		$r->changelog = array();

		return $r;
	}

	/**
	 * Retirns latest retrived information about updates.
	 *
	 * @throws Exception If $isDevelopmentMode enabled
	 * 
	 * @param  boolean $cacheAllowed set to false to prevent cache usage
	 * @return assoc
	 */
	protected function getLatestInformationDetails($cacheAllowed = true)
	{
		$cacheId = $this->cacheTime > 0 ? $this->getCacheKeyId() : null;

		$result = false;
		if ($cacheId && $cacheAllowed) {
			$result = get_transient($cacheId);
		}

		if ($result === false) {
			$fileUrl = $this->getUpdatesFileUrl();
			$response = wp_remote_get($fileUrl, array(
				'redirection' => 5,
				'timeout' => 30,
			));
			if ( is_wp_error($response) ) {
				if ($this->isDevelopmentMode) {
					return $this->error($return->get_error_message());
				}
			} else {
				$responseCode = !empty($response['response']['code']) ? $response['response']['code'] : false;
				if ($responseCode < 200 || $responseCode > 302 || empty($response['body'])) {
					// http error, so will set
					if ($this->isDevelopmentMode) {
						return $this->error(strtr('URL {fileUrl} can not be loaded.', array(
							'{fileUrl}' => $fileUrl
						)));
					}
				} else {
					try {
						$result = json_decode($response['body']);
					} catch (Exception $e) {
						$result = null;
						if ($this->isDevelopmentMode) {
							return $this->error($e->getMessage());
						}
					}
				}
			}

			if (!$result) {
				if ($this->isDevelopmentMode) {
					return $this->error(strtr('Can not decode (json_decode) {fileUrl}.', array(
						'{fileUrl}' => $fileUrl
					)));
				} else {
					$result = $this->getDefaultInformationDetails();
				}
			}
			if ($cacheId) {
				set_transient($cacheId, $result, $this->cacheTime);
			}
		}
		return $result;
	}

	/**
	 * Returns url to the file with information about available updates.
	 * @return string
	 */
	protected function getUpdatesFileUrl()
	{
		return $this->updatesFileUrl;
	}

	/**
	 * Checks if new version is available.
	 * @param  boolean $allowCache
	 * @return boolean
	 */
	public function hasNewVersion($allowCache = true)
	{
		if ($allowCache && null !== $this->new_version_check_cache) {
			return $this->new_version_check_cache;
		}
		$result = false;

		$latestDetails = $this->getLatestInformationDetails($allowCache);
		if ($latestDetails) {
			$theme_data = wp_get_theme($this->themeId);
			$result = version_compare($latestDetails->latest, $theme_data->version) == 1;
		}

		$this->new_version_check_cache = $result;

		return $result;
	}

	/**
	 * Fetch content from specefied template file.
	 * Uses getTemplatePath to convert local file name to the full file path.
	 * @param  string $fileName
	 * @param  array  $data     data that should be passed into template
	 *
	 * @throws Exception If $isDevelopmentMode enabled
	 * 
	 * @return string
	 */
	protected function renderView($fileName, array $data)
	{
		$templatePath = $this->getTemplatePath($fileName);

		if (!file_exists($templatePath)) {
			return $this->error(strtr('File "{filePath}" does not exists.', array(
				'{filePath}' => $templatePath
			)));
		}

		ob_start();
		extract($data);
		include $templatePath;
		$content = ob_get_clean();

		return $content;
	}

	/**
	 * Converts local template name to the full file path.
	 * @param  string $fileName
	 * @return string
	 */
	protected function getTemplatePath($fileName)
	{
		return dirname(__FILE__) . '/themeUpdaterViews/' . $fileName;
	}
}
