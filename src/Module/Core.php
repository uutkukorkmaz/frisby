<?php


namespace Frisby\Module;


class Core
{
    public Request $request;

    public Response $response;

    public Router $route;

    public static string $DIRECTORY_ROOT;

    public static Core $instance;

    public function __construct()
    {
        self::$DIRECTORY_ROOT = $_ENV['APP_ROOT'];
        self::$instance = $this;
        $this->request = new Request();
        $this->route = new Router();
        $this->response = new Response();
    }

}