<?php


namespace Frisby\Component;


use Frisby\Service\Cryption;
use Frisby\Service\Database;

/**
 * Class ServiceProvider
 * @package Frisby\Component
 */
class ServiceProvider
{

	public array $services = [];

	/**
	 * ServiceProvider constructor.
	 */
	public function __construct($services)
	{
		$this->resolveServices($services);
	}

	private static function serviceName($service)
	{
		$array = explode('\\', $service);

		return end($array);
	}

	private function resolveServices($services)
	{
		$core = Core::getInstance();
		foreach ($services as $service) {
			$this->services[self::serviceName($service)] = new $service();
			$core->bind(self::serviceName($service),$this->services[self::serviceName($service)]);
		}
	}


}