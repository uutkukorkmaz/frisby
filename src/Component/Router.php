<?php


namespace Frisby\Component;


class Router
{

	public array $routes = ['GET' => [], 'POST' => [], 'PUT' => [], 'DELETE' => []];
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


	public function pattern($key, $rules): void
	{
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

	private function addRoute($route, $callback, $method): void
	{
		$method = strtoupper($method);
		$core = Core::getInstance();
		$method = strpos('|', $method) ?: explode('|', $method);
		$route = str_replace(array_keys($this->patterns), array_values($this->patterns), $route);

		if (preg_match('@^' . $route . '/?$@', $core->request->uri, $params)) {
			$core->response->params = $params;
			if (is_array($method)) {
				if (in_array($core->request->method, $method)) {
					foreach ($method as $m):
						$this->routes[$m][$route] = $callback;
					endforeach;
					$core->response->setCode(200);
					$core->response->execute = $route;
				} else {
					$core->response->setCode(405);
				}
			} else {
				if ($core->request->method == $method) {
					$this->routes[$method][$route] = $callback;
					$core->response->setCode(200);
					$core->response->execute = $route;
				} else {
					$core->response->setCode(405);
				}
			}
		}
		if ($core->response->code != 200) {
			$core->response->setCode(Response::INVALID_ROUTE);
		}


	}

	public function get($route, $callback): void
	{
		$this->addRoute($route, $callback, self::METHOD_GET);
	}

	public function post($route, $callback): void
	{
		$this->addRoute($route, $callback, self::METHOD_POST);
	}

	public function add($route, $callback, $method = self::METHOD_GET . "|" . self::METHOD_POST): void
	{
		$this->addRoute($route, $callback, $method);
	}
}