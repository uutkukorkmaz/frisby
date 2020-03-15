<?php


namespace FrisbyModule\Frisby;


/**
 * Class Language
 * @package FrisbyModule\Frisby
 */
class Language
{

	public $currentLang;

	private $defaultLang;

	/**
	 * @return mixed
	 */
	public function getDefaultLang()
	{
		return $this->defaultLang;
	}


	/**
	 * @param string|null $currentLang
	 */
	public function setCurrentLang($currentLang)
	{

		$cookie = new Cookie($_COOKIE);
		$this->currentLang = $currentLang;

		$cookie->forever('lang', $currentLang);
	}

	/**
	 * Language constructor.
	 */
	public function __construct()
	{
		global $loader, $config, $app;
		$cookie = new Cookie($_COOKIE);
		$this->defaultLang = $config->get('defaultLang');
		$this->setCurrentLang($app->detectLang($this));
		require (file_exists($loader->lang($this->currentLang))) ? $loader->lang($this->currentLang) : $loader->lang($this->getDefaultLang());

	}

	public function __($str)
	{
		return isset($GLOBALS['language'][$str]) ? $GLOBALS['language'][$str] : $str;
	}


}