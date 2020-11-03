<?php


namespace Frisby\Framework;


use Frisby\Service\Database;
use Whoops\Run as Whoops;

/**
 * Class Core
 * @package Frisby\Framework
 */
class Core
{
	private static Core $instance;

	public Container $container;

	public Logger $log;

	public Database $database;

	private Whoops $whoops;

	public function __construct(...$services)
	{
		self::$instance = $this;
		$this->whoops = new Whoops();
		$this->whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
		$this->whoops->register();
		$this->container = new Container($services);
		$this->initServices();
	}

	private function initServices()
	{
		$this->database = $this->container->resolve(Database::class);
		$this->log = $this->container->resolve(Logger::class);
	}

	/**
	 * @return Core
	 */
	public static function getInstance()
	{
		return self::$instance;
	}

}