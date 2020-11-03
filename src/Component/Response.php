<?php


namespace Frisby\Component;


use Frisby\Exception\InvalidRoute;
use Frisby\Exception\MethodNotAllowed;
use Frisby\Exception\NotFound;

class Response
{


	private const FRISBY_CODES_START = 11000;
	public const INVALID_ROUTE = self::FRISBY_CODES_START + 1;
	public const PUSH_TYPE_ERR = 'danger';
	public const PUSH_TYPE_SUCS = 'success';
	public const PUSH_TYPE_INFO = 'info';
	public const PUSH_TYPE_WARN = 'warning';

	public int $code;
	public ?string $exception = null;
	public int $time;
	public array $params = [];
	public ?string $execute = null;
	public $controller;
	public array $messages = [];

	public function __construct()
	{
		$this->code = self::INVALID_ROUTE;
		$this->time = time();

	}

	public function setCode($code)
	{
		$this->code = $code;
		switch ($this->code) {
			case 404:
				$this->exception = NotFound::class;
				break;
			case 405:
				$this->exception = MethodNotAllowed::class;
				break;
			case self::INVALID_ROUTE:
				$this->exception = InvalidRoute::class;
				break;
		}
		if (!is_null($this->exception)) throw new $this->exception;
		http_response_code($code < self::FRISBY_CODES_START ? $code : 200);
	}

	public function push(string $message, string $type = self::PUSH_TYPE_INFO)
	{
		$this->messages[] = (object)[
			"message" => $message,
			"type" => $type,
			"isError" => ($type == self::PUSH_TYPE_ERR),
			"time" => $this->time,
		];
	}

	protected function runControllerFromString()
	{
		$this->controller = new $this->controller();
		$this->controller->render($this->params);
	}

	protected function runControllerFromClosure()
	{
		call_user_func($this->controller, $this->params);
	}

	protected function runControllerFromArray()
	{
		$method = count($this->controller) < 2 ? 'render' : $this->controller[1];
		$this->controller = new $this->controller[0]();
		$this->controller->{$method}($this->params);
	}

	public function __destruct()
	{
		$core = Core::getInstance();
		if (array_key_exists($this->execute, $core->route->routes[$core->request->method])) {
			if ($this->code == 200 && $this->exception == null) {
				$this->controller = $core->route->routes[$core->request->method][$this->execute];
				if (is_string($this->controller)): $this->runControllerFromString(); endif;
				if (is_callable($this->controller)) : $this->runControllerFromClosure(); endif;
				if (is_array($this->controller)) : $this->runControllerFromArray(); endif;
			}
		} else {
			$core->response->setCode(404);
		}

	}


}