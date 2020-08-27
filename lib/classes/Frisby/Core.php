<?php

namespace FrisbyModule\Frisby;

class Core
{

	public $route = [];

	public $Controller;

	public $Model;

	public $patterns;

	public $environment;

	public function __construct($environment)
	{
		$this->route = new Route();
		$_ENV['FRISBY'] = $this;
		$this->environment = new Environment($environment);
	}

	/**
	 * Defines current Controller class
	 * @param string $controller
	 * @return string
	 */
	public function setController($controller)
	{
		$this->Controller = 'FrisbyApp\\Controller\\' . $controller;
		return $this->Controller;

	}

	/**
	 * Defines current Model class
	 * @param string $model
	 * @return string
	 */
	public function setModel($model)
	{
		$this->Model = 'FrisbyApp\\Model\\' . $model;
		return $this->Model;
	}

	/**
	 * @param null $location
	 */
	public function location($location)
	{
		header('location:' . $location);
	}

	/**
	 * @param string $href
	 * @return string
	 */
	public function go($href = '')
	{
		global $config;
		$href = substr($href, 0, 1) == '/' ? $href : '/' . $href;
		return $config->get('domain') . $href;
	}

	/**
	 * @param Language $langObj
	 * @return mixed|string|null
	 */
	public function detectLang(Language $langObj)
	{
		global $config;
		$cookie = new Cookie($_COOKIE);

		return (isset($this->route->url[1]) && $config->get('allowLocalization')) ? $this->route->url[1] : ($cookie->exists('lang') ? $cookie->get('lang') : $langObj->getDefaultLang());
	}

	public function img($file){
		return $this->go('assets/img/'.$file);
	}
	public function css($file){
		return $this->go('assets/css/'.$file);
	}
	public function js($file){
		return $this->go('assets/js/'.$file);
	}

}