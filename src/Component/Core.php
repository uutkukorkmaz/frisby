<?php


namespace Frisby\Component;


class Core
{
    public Request $request;

    public Response $response;

    public Router $route;

    public static string $DIRECTORY_ROOT;

    private static Core $instance;

    public function __construct()
    {
        self::$DIRECTORY_ROOT = $_ENV['APP_ROOT'];
        self::$instance = $this;
        $this->request = new Request();
        $this->route = new Router();
        $this->response = new Response();
    }

    public static function getInstance(){
        return self::$instance;
    }

}