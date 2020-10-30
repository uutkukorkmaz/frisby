<?php


namespace Frisby\Component;


use Frisby\Exception\NotFound;

class Response
{

    public int $code;
    public ?object $exception;
    public int $time;

    public function __construct()
    {
        $this->time = time();
    }

    public function setCode($code)
    {
        $this->code = $code;
        switch ($this->code) {
            case 404:
                $this->setException(NotFound::class);
                break;
            default:
                $this->setException(null);
                break;
        }
        http_response_code($code);
    }

    public function setException(?string $exception)
    {
        if(is_null($exception)) return null;
        $this->exception = new $exception();
        return $this->exception;
    }

    public function __destruct(){
        $core = Core::getInstance();
        print_r($core);
        //TODO: render page
    }


}