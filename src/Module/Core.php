<?php


namespace Frisby\Module;


class Core
{
    public Request $request;

    public Response $response;

    public Router $route;

    public const DIRECTORY_ROOT = '/frisby';

    public function __construct()
    {
        $this->request = new Request();
        $this->route = new Router($this);
        print_r($this);

    }

}