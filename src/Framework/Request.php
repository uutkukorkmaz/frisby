<?php


namespace Frisby\Framework;


/**
 * Class Request
 * @package Frisby\Framework
 */
class Request extends Singleton
{


    public string $uri;
    public string $method;
    public array $middlewares;

    protected function __construct()
    {
        parent::__construct();
        $this->uri = explode('?',str_replace($_ENV['APP_ROOT'], null, $_SERVER['REQUEST_URI']))[0];
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function interrupt()
    {
        // load and execute middlewares
        /**
         * @var Middleware $mw
        */
        foreach($this->middlewares as $mw){
            $mw->interrupt();
        }
    }

    public function setMiddlewares(array $provided)
    {
        // instantiate all middlewares but nut interrupt request
        foreach ($provided as $middleware):
            $this->middlewares[] = new $middleware();
        endforeach;
    }


}