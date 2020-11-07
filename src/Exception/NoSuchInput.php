<?php


namespace Frisby\Exception;


use Frisby\Framework\Core;

class NoSuchInput extends \Exception
{
    protected $message = "No such input: %s";
    protected $code = Core::ERR_NO_SUCH_INPUT;

    /**
     * NoSuchInput constructor.
     * @param string $input
     * @param \Throwable|null $previous
     */
    public function __construct(string $input, \Throwable $previous=null)
    {

        parent::__construct(sprintf($this->message,$input),$this->code,$previous);
    }
}