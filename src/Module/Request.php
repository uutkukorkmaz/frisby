<?php


namespace Frisby\Module;


class Request
{

    public string $uri;

    public string $route;

    public string $method;

    public function __construct()
    {
       $this->uri = str_replace(Core::DIRECTORY_ROOT, null, $_SERVER['REQUEST_URI']);
        $this->route = $_GET['route'] != "" ? $_GET['route'] : '/';
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->time =  $_SERVER['REQUEST_TIME'];
        unset($_GET['route']);
    }

    public function method(){
        return $this->method;
    }

}