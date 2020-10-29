<?php


namespace Frisby\Module;


class Core
{
    public Request $request;

    public Response $response;

    public Router $route;

    public const DIRECTORY_ROOT = '/frisby';

    public static Core $instance;

    public function __construct()
    {
        self::$instance = $this;
        $this->request = new Request();
        $this->route = new Router();
    }

}