<?php


namespace Frisby\Component;


class Router
{

    public array $routes = [];
    public array $patterns = [];

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


    public function parseURL(){
        //TODO:: Parsing URLS
    }


    public function pattern($key,$rules) : void{
        $this->patterns[$key] = self::generatePattern($rules);
    }

    private static function generatePattern(array $rules): string
    {
        $pattern = '([';
        $pattern .= in_array(self::MUST_HAVE_NUMERIC, $rules) ? self::REGEX_NUMERIC : null;
        $pattern .= in_array(self::MUST_HAVE_LOWERCASE, $rules) ? self::REGEX_LOWERCASE : null;
        $pattern .= in_array(self::MUST_HAVE_UPPERCASE, $rules) ? self::REGEX_UPPERCASE : null;
        $pattern .= in_array(self::MUST_HAVE_SCORE, $rules) ? self::REGEX_SCORE : null;
        $pattern .= ']+)';
        return $pattern;
    }

    private function addRoute($route, $callback, $method) : void
    {
        $method = strtoupper($method);
        $method = strpos('|', $method) ?: explode('|', $method);

        if (is_array($method)) {
            foreach ($method as $m):
                $this->routes[$m][$route] = $callback;
            endforeach;
        } else {
            $this->routes[$method][$route] = $callback;
        }


    }

    public function get($route, $callback) : void
    {
        $this->addRoute($route, $callback, self::METHOD_GET);
    }

    public function post($route, $callback) : void
    {
        $this->addRoute($route, $callback, self::METHOD_POST);
    }

    public function add($route, $callback, $method = self::METHOD_GET."|".self::METHOD_POST) : void
    {
        $this->addRoute($route, $callback, $method);
    }
}