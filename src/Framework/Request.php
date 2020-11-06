<?php


namespace Frisby\Framework;


/**
 * Class Request
 * @package Frisby\Framework
 */
class Request extends Singleton
{


	public string $uri;
	public string $method;

	protected function __construct()
	{
		parent::__construct();
		$this->uri = str_replace($_ENV['APP_ROOT'],null,$_SERVER['REQUEST_URI']);
		$this->method = $_SERVER['REQUEST_METHOD'];
	}


}