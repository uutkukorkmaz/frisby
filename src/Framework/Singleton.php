<?php


namespace Frisby\Framework;


/**
 * Class Singleton
 * @package Frisby\Framework
 */
class Singleton
{

	private static array $instances = [];

	protected function __construct()
	{
	}

	protected function __clone()
	{
	}

	public function __wakeup()
	{
		throw new \Exception("Can't unserialize a singleton");
	}

	public static function getInstance()
	{
		$class = static::class;
		if (!isset(self::$instances[$class])): self::$instances[$class] = new static(); endif;
		return self::$instances[$class];
	}
}