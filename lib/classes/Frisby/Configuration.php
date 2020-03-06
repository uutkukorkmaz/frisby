<?php


namespace FrisbyModule\Frisby;


class Configuration
{
	private $configs = [];

	/**
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
	 * @return array
	 */
	public function get($config)
	{
		return $this->exists($config) ? $this->configs[$config]:null;
	}

	public function exists($config){
		return isset($this->configs[$config]);
	}
}