<?php


namespace Frisby\Exception;


use Frisby\Framework\Core;

/**
 * Class InvalidRoute
 * @package Frisby\Exception
 * @extends \Exception
 */
class InvalidRoute extends \Exception
{

	protected $message = "Invalid Route: %s";
	protected $code = Core::ERR_INVALID_ROUTE;

	/**
	 * InvalidRoute constructor.
	 * @param string $route
	 * @param \Throwable|null $previous
	 */
	public function __construct(string $route, \Throwable $previous=null)
	{
		parent::__construct(sprintf($this->message,$route),$this->code,$previous);
	}
}