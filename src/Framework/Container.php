<?php


namespace Frisby\Framework;


use Frisby\Service\Database;

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
	public function __construct(array $services)
	{
		$logger = Logger::getInstance();
		foreach($services as $service):
			$logger->push('Binding service '.$service);
			self::$services[$service] = $service::getInstance();
			endforeach;
	}

	public function resolve(string $service){

		return self::$services[$service];
	}
}