<?php


namespace Frisby\Exception;


use Throwable;

class NotFound extends \Exception
{

    public $message = "Not found";
    public $code = 404;
    public $trace;
    public function __construct(Throwable $previous = null)
    {
        parent::__construct($this->message, $this->code, $previous);
        $this->trace = parent::getTrace();
    }
}