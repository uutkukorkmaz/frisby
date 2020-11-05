<?php


namespace Frisby\Exception;


use Throwable;

/**
 * Class InvalidRoute
 * @package Frisby\Exception
 * @extends \Exception
 */
class MethodNotAllowed extends \Exception
{

	protected $message = "Not Allowed Method %s";
	protected $code = 405;

	/**
	 * InvalidRoute constructor.
	 * @param string $method
	 * @param Throwable|null $previous
	 */
	public function __construct(string $method, Throwable $previous=null)
	{
		parent::__construct(sprintf($this->message,$method),$this->code,$previous);
	}
}