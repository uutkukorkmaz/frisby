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
	 * Language constructor.
	 */
	public function __construct()
	{
		global $loader,$config;
		$this->defaultLang = $config->get('defaultLang');
		$cookie = new Cookie();
		if($cookie->exists('lang')){
			$this->currentLang = $cookie->get('lang');
			require $loader->lang($this->currentLang);
		}else{
			$cookie->forever('lang', (string)$this->defaultLang);
			require $loader->lang($cookie->get('lang'));
		}
	}

	public function __($str){
		return isset($GLOBALS['language'][$str])?$GLOBALS['language'][$str]:$str;
	}

}