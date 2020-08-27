<?php

namespace FrisbyModule\Frisby;

/**
 * Class Core
 * @package FrisbyModule\Frisby
 */
class Core
{
	/**
	 * Contains the Route object
	 * @var Route
	 */
	public Route $route;

	/**
	 * Contains current Controller object
	 * @var
	 */
	public $Controller;

	/**
	 * Contains defined Model object
	 * @var
	 */
	public $Model;
	/**
	 * Contains the Regex patterns for Route object
	 */
	public $patterns;

	/**
	 * Contains the environment object
	 * public @var Environment
	 */
	public Environment $environment;

	/**
	 * Core constructor.
	 * @param $environment
	 */
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
	 * Redirects the page to given parameter
	 * @param null $location
	 */
	public function location($location)
	{
		header('location:' . $location);
	}

	/**
	 * Generates a URL
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
	 * Detects language from first part of URL
	 * @param Language $langObj
	 * @return mixed|string|null
	 */
	public function detectLang(Language $langObj)
	{
		global $config;
		$cookie = new Cookie($_COOKIE);

		return (isset($this->route->url[1]) && $config->get('allowLocalization')) ? $this->route->url[1] : ($cookie->exists('lang') ? $cookie->get('lang') : $langObj->getDefaultLang());
	}

	/**
	 * Returns a path for using image file in HTML
	 * @param $file
	 * @return string
	 */
	public function img($file)
	{
		return $this->go('assets/img/' . $file);
	}

	/**
	 *  Returns a path for using CSS file in HTML
	 * @param $file
	 * @return string
	 */
	public function css($file)
	{
		return $this->go('assets/css/' . $file);
	}

	/**
	 *  Returns a path for using JavaScript file in HTML
	 * @param $file
	 * @return string
	 */
	public function js($file)
	{
		return $this->go('assets/js/' . $file);
	}

}