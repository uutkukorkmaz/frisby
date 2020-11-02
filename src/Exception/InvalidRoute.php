<?php


namespace Frisby\Exception;


use Throwable;

/**
 * Class InvalidRoute
 * @package Frisby\Exception
 */
class InvalidRoute extends \Exception
{

    public $message = "Invalid Route";
    public $code = 11001;
    public $trace;
    public function __construct(Throwable $previous = null)
    {
        parent::__construct($this->message, $this->code, $previous);
        $this->trace = parent::getTrace();
    }
}