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
	public const ERR_NO_SUCH_INPUT = self::ERR_CODE_GROUP + 2;

	private static Core $instance;

	public Request $request;

	public Response $response;
	public Router $router;

	public Container $container;

	public Logger $log;

	public Database $database;

	private Whoops $whoops;


	public function __construct()
	{
	    unset($_GET['route']);
		$this->initErrorHandler();
		self::$instance = $this;
		$this->container = new Container();
		$this->request = Request::getInstance();
		$this->response = Response::getInstance();
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
		$handler = $_ENV['ENVIRONMENT'] == "production" ? new \Whoops\Handler\PlainTextHandler() :new \Whoops\Handler\PrettyPageHandler;
		$this->whoops->pushHandler($handler);
		$this->whoops->register();
	}

	public function run()
	{
		$this->router->run();
	}
}