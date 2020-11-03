<?php


namespace Frisby\Framework;

use Frisby\Service\Logger;

/**
 * Class Container
 * @package Frisby\Framework
 */
class Container
{

	private static array $services = [];

	/**
	 * Container constructor.
	 * @param array $services
	 */
	public function __construct(array $services = [])
	{
		$this->resolveArray($services);
	}

	public function resolve(string $service)
	{
		if (!isset(self::$services[$service])) self::$services[$service] = $service::getInstance();
		return self::$services[$service];
	}


	public function registerService($service)
	{
		if (is_array($service)): $this->resolveArray($service);endif;
		if (is_string($service)): $this->resolve($service);endif;
	}

	public function resolveArray($services)
	{
		$logger = Logger::getInstance();
		foreach ($services as $service):
			$logger->push('Binding service ' . $service);
			$this->resolve($service);
		endforeach;
	}
}