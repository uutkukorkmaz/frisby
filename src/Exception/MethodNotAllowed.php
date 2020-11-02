<?php


namespace Frisby\Exception;


use Throwable;

class MethodNotAllowed extends \Exception
{

    public $message = "Method Not Allowed";
    public $code = 405;
    public $trace;
    public function __construct(Throwable $previous = null)
    {
        parent::__construct($this->message, $this->code, $previous);
        $this->trace = parent::getTrace();
    }
}