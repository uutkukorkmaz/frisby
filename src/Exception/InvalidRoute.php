<?php


namespace Frisby\Exception;


use Frisby\Component\Core;
use Throwable;

/**
 * Class InvalidRoute
 * @package Frisby\Exception
 */
class InvalidRoute extends \Exception
{

    public $message = "Invalid Route";
    public $code = 11001;

    public function __construct(Core $core, Throwable $previous = null)
    {
        $_ENV['CORE_JSON'] = print_r($core,true);
        parent::__construct($this->message, $this->code, $previous);

    }
}