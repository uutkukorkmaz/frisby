<?php


namespace Frisby\Component;


use Whoops\Run as Whoops;

class Core
{
	public Request $request;

	public Response $response;

	public Router $route;

	public static string $DIRECTORY_ROOT;

	private static Core $instance;

	public ServiceProvider $serviceProvider;

	public Whoops $whoops;

	private array $bindings;

	public function __construct(...$services)
	{
		$this->whoops = new Whoops();
		$this->whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
		$this->whoops->register();
		self::$DIRECTORY_ROOT = $_ENV['APP_ROOT'];
		self::$instance = $this;
		$this->initServices($services);
	}

	public static function getInstance()
	{
		return self::$instance;
	}

	protected function initServices($services){
		$this->request = new Request();
		$this->route = new Router();
		$this->serviceProvider = new ServiceProvider($services);
		$this->response = new Response();
	}

	public function bind(string $key,$value){
		$this->bindings[$key] = $value;
	}

	public function resolve(string $key){
		return $this->bindings[$key];
	}

}