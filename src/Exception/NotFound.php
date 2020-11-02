<?php


namespace Frisby\Exception;


use Frisby\Component\Core;
use Throwable;

class NotFound extends \Exception
{

    public $message = "Not found";
    public $code = 404;

    public function __construct(Core $core,Throwable $previous = null)
    {
        $_ENV['CORE_JSON'] = print_r($core,true);
        parent::__construct($this->message, $this->code, $previous);

    }
}