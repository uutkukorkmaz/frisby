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

	public Database $db;

	public Whoops $whoops;

	public function __construct()
	{
		$this->whoops = new Whoops();
		$this->whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
		$this->whoops->register();
		self::$DIRECTORY_ROOT = $_ENV['APP_ROOT'];
		self::$instance = $this;
		$this->initServices();
	}

	public static function getInstance()
	{
		return self::$instance;
	}

	protected function initServices(){
		$this->request = new Request();
        $this->response = new Response();
		$this->route = new Router();
		$this->db = new Database();

	}

}