<?php


namespace Frisby\Framework;


use Frisby\Exception\InvalidRoute;
use Frisby\Exception\MethodNotAllowed;

/**
 * Class Router
 * @package Frisby\Framework
 */
class Router extends Singleton
{

    public array $routes = [];
    private array $placeholders = [];
    private array $allowedRoutes = [];

    public const MUST_HAVE_NUMERIC = 'num';
    private const REGEX_NUMERIC = '0-9';
    public const MUST_HAVE_LOWERCASE = 'lw';
    private const REGEX_LOWERCASE = 'a-z';
    public const MUST_HAVE_UPPERCASE = 'up';
    private const REGEX_UPPERCASE = 'A-Z';
    public const MUST_HAVE_SCORE = 'sc';
    private const REGEX_SCORE = '_-';

    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_DELETE = 'DELETE';
    private array $params;


    public function addRoute(string $route, $callback, string $method = self::METHOD_GET)
    {
        $route = str_replace(array_keys($this->placeholders), array_values($this->placeholders), $route);
        $this->routes[$route][$method] = $callback;
        $this->allowedRoutes[] = $route;
    }

    public function get($route, $callback)
    {
        $this->addRoute($route, $callback);
    }

    public function post($route, $callback)
    {
        $this->addRoute($route, $callback, self::METHOD_POST);
    }

    private function getCurrentRoute()
    {
        $request = Request::getInstance();
        $currentRoute = null;

        foreach ($this->allowedRoutes as $index => $routeRegex) {
            if (preg_match('@^' . $routeRegex . '/?$@', $request->uri, $params)) {
                $currentRoute = $routeRegex;
            } else {
                continue;
            }
        }
        $this->params = $params;
        return $currentRoute;
    }

    private function setControllerFromString($scope)
    {
        $request = Request::getInstance();
        $response = Response::getInstance();
        $request->interrupt();
        $response->controller = new $scope[$request->method]();
        $response->controller->base($this->params);
    }

    private function setControllerFromArray($scope)
    {
        $request = Request::getInstance();
        $response = Response::getInstance();
        $request->interrupt();
        $response->controller = new $scope[$request->method][0]();
        $controllerMethod = $scope[$request->method][1];
        $response->controller->$controllerMethod($this->params);
    }

    private function setControllerFromClosure($scope)
    {
        $request = Request::getInstance();
        $response = Response::getInstance();
        $request->interrupt();
        $response->controller = $scope[$request->method];
        call_user_func($response->controller, $this->params);
    }

    private function initController($currentRoute)
    {

        $request = Request::getInstance();
        $response = Response::getInstance();
        $scope = $this->routes[$currentRoute];
        if (array_key_exists($request->method, $scope)) {
            if (is_string($scope[$request->method])):
                $this->setControllerFromString($scope);
                return;
            endif;
            if (is_array($scope[$request->method])):
                $this->setControllerFromArray($scope);
                return;
            endif;
            if (is_callable($scope[$request->method])):
                $this->setControllerFromClosure($scope);
                return;
            endif;
        } else {
            throw new MethodNotAllowed($request->method);
        }
    }

    public function run()
    {
        $currentRoute = $this->getCurrentRoute();

        if (is_null($currentRoute)) {
            throw new InvalidRoute(Request::getInstance()->uri);
        } else {
            $this->initController($currentRoute);
        }
    }

}