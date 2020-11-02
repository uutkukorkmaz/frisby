<?php


namespace Frisby\Exception;


use Frisby\Component\Core;
use Throwable;

class MethodNotAllowed extends \Exception
{

    public $message = "Method Not Allowed";
    public $code = 405;

    public function __construct(Core $core, Throwable $previous = null)
    {
        $_ENV['CORE_JSON'] = print_r($core,true);
        parent::__construct($this->message, $this->code, $previous);

    }
}