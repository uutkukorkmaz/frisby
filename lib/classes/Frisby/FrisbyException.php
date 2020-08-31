<?php
declare(strict_types=1);


namespace FrisbyModule\Frisby;

use Exception;
use Throwable;

/**
 * Frisby Framework
 * FrisbyException Class
 *
 * This thing is waits for me to code it but idk why I don't
 *
 * @author Utku Korkmaz
 * @package FrisbyModule\Frisby
 */
class FrisbyException extends Exception
{

	/**
	 * Construct the exception. Note: The message is NOT binary safe.
	 * @link https://php.net/manual/en/exception.construct.php
	 * @param string $message [optional] The Exception message to throw.
	 * @param int $code [optional] The Exception code.
	 * @param Throwable $previous [optional] The previous throwable used for the exception chaining.
	 */
	public function __construct($message = "", $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

}