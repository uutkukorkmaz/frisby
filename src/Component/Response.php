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
	public ?object $exception = null;
	public int $time;
	public array $params = [];
	public string $execute;
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
				$this->setException(NotFound::class);
				break;
			case 405:
				$this->setException(MethodNotAllowed::class);
				break;
			case self::INVALID_ROUTE:
				$this->setException(InvalidRoute::class);
				break;
			default:
				$this->setException(null);
				break;
		}

		http_response_code($code < self::FRISBY_CODES_START ? $code : 200);
	}

	public function setException(?string $exception)
	{
		if (is_null($exception)) return null;
		$this->exception = new $exception();
		return $this->exception;
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

	public function __destruct()
	{
		$core = Core::getInstance();
		if ($this->code == 200 && $this->exception == null) {
			$this->controller = $core->route->routes[$core->request->method][$this->execute];
			if(is_string($this->controller)){
				$this->controller = new $this->controller();
				$this->controller->render($this->params);
			}
			if(is_callable($this->controller)){
				call_user_func($this->controller,$this->params);
			}
			if(is_array($this->controller)){
				$method = count($this->controller)<2?'render':$this->controller[1];
				$this->controller = new $this->controller[0]();
				$this->controller->{$method}($this->params);
			}
		} else {
			print_r($this->exception);
		}

	}


}