<?php
declare(strict_types=1);

namespace FrisbyModule\Frisby;


/**
 * Frisby Framework
 * Core Class
 *
 * This is the main core of the entire Frisby. In the application, this class
 * represented by $app variable which is accessable anywhere in the project
 *
 * @author Utku Korkmaz
 * @package FrisbyModule\Frisby
 */
class Core
{
	/**
	 * Contains the Route object
	 * @var Route
	 */
	public Route $route;

	public $appName;

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
	 * @param string $environment
	 */
	public function __construct(string $appName = 'Frisby',string $environment='development')
	{
		$this->route = new Route();
		$_ENV['FRISBY'] = $this;
		$this->appName = $appName;
		$this->environment = new Environment($environment);
	}

	/**
	 * Defines current Controller class
	 * @param string $controller
	 * @return string
	 */
	public function setController(string $controller)
	{
		$this->Controller = 'FrisbyApp\\Controller\\' . $controller;
		return $this->Controller;

	}

	/**
	 * Defines current Model class
	 * @param string $model
	 * @return string
	 */
	public function setModel(string $model)
	{
		$this->Model = 'FrisbyApp\\Model\\' . $model;
		return $this->Model;
	}

	/**
	 * Redirects the page to given parameter
	 * @param string $location
	 */
	public function location(string $location)
	{
		header('location:' . $location);
	}

	/**
	 * Generates a URL
	 * @param string $href
	 * @return string
	 */
	public function go(string $href = '')
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
	 * @param string $file
	 * @return string
	 */
	public function img(string $file)
	{
		return $this->go(Loader::IMAGE . $file);
	}

	/**
	 *  Returns a path for using CSS file in HTML
	 * @param string $file
	 * @return string
	 */
	public function css(string $file)
	{
		return $this->go(Loader::STYLE . $file);
	}

	/**
	 *  Returns a path for using JavaScript file in HTML
	 * @param $file
	 * @return string
	 */
	public function js(string $file)
	{
		return $this->go(Loader::SCRIPT . $file);
	}

}