<?php
declare(strict_types=1);


namespace FrisbyModule\Frisby;


/**
 * Frisby Framework
 * Configuration Class
 *
 * This class simply manages the application's hard configuration
 *
 * @author Utku Korkmaz
 * @package FrisbyModule\Frisby
 */
class Configuration
{
	private $configs = [];

	/**
	 * Sets a configuration.
	 * @param $config
	 * @param bool $value
	 * @return bool
	 */
	public function set($config,$value=false)
	{
		$this->configs[$config] = $value;
		return $value;
	}

	/**
	 * Gets a specified configuration.
	 * @return array
	 */
	public function get($config)
	{
		return $this->exists($config) ? $this->configs[$config]:null;
	}

	/**
	 * Checks given configuration name is exists or not.
	 * @param $config
	 * @return bool
	 */
	public function exists($config){
		return isset($this->configs[$config]);
	}
}