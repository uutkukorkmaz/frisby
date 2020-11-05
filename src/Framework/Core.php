<?php


namespace Frisby\Framework;


use Frisby\Service\Database;
use Frisby\Service\Logger;
use Whoops\Run as Whoops;

/**
 * Class Core
 * @package Frisby\Framework
 */
class Core
{

	private const ERR_CODE_GROUP = 11000;

	public const ERR_INVALID_ROUTE = self::ERR_CODE_GROUP + 1;

	private static Core $instance;

	public Request $request;

	public Router $router;

	public Container $container;

	public Logger $log;

	public Database $database;

	private Whoops $whoops;


	public function __construct()
	{
		$this->initErrorHandler();
		self::$instance = $this;
		$this->container = new Container();
		$this->request = Request::getInstance();
		$this->router = $this->container->resolve(Router::class);
		$this->initServices();
	}


	private function initServices()
	{
		$this->database = $this->container->resolve(Database::class);
		$this->log = $this->container->resolve(Logger::class);
	}


	public static function getInstance(): Core
	{
		return self::$instance;
	}

	private function initErrorHandler()
	{
		$this->whoops = new Whoops();
		$this->whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
		$this->whoops->register();
	}

	public function run(){
		$this->router->run();
	}
}