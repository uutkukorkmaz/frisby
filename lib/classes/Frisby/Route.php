<?php


namespace FrisbyModule\Frisby;


/**
 * Class Route
 * @package FrisbyModule\Frisby
 */
class Route
{

	public $currentRoute = '/';

	public $routes = [];

	public $validRoutes = [];

	public $query;

	public $url;

	public $patterns = [];

	/**
	 * Route constructor.
	 */
	public function __construct()
	{
		$this->parseUrl();
	}

	/**
	 * @param $patternKey
	 * @param array $pattern
	 */
	public function pattern($patternKey, $pattern = [])
	{
		$this->patterns[$patternKey] = self::generatePattern($pattern);
	}

	/**
	 * @param array $options
	 * @return string
	 */
	private static function generatePattern($options)
	{
		$pattern = '([';
		$pattern .= isset($options['numeric']) && $options['numeric'] ? '0-9' : null;
		$pattern .= isset($options['lowercase']) && $options['lowercase'] ? 'a-z' : null;
		$pattern .= isset($options['uppercase']) && $options['uppercase'] ? 'A-Z' : null;
		$pattern .= isset($options['minus']) && $options['minus'] ? '_-' : null;
		$pattern .= ']+)';
		return $pattern;
	}

	/**
	 * Parses the URL and sets current requested route and HTTP query
	 */
	public function parseUrl()
	{
		$directory = dirname($_SERVER['SCRIPT_NAME']);
		$directory = $directory != '/' ? $directory : null;
		$basename = basename($_SERVER['SCRIPT_NAME']);
		$this->currentRoute = isset($_GET['route']) ? '/' . $_GET['route'] : str_replace([$directory, $basename], null, explode('?', $_SERVER['REQUEST_URI'])[0]);
		unset($_GET['route']);
		$this->url = array_filter(explode('/', rtrim($this->currentRoute)));
		$this->query = count($_GET) ? '?' . http_build_query($_GET) : null;
	}

	/**
	 * @param $route
	 * @param $callback
	 */
	public function add($route, $callback, $method = 'get|post')
	{
		$method = explode('|', strtoupper($method));


		if (in_array($_SERVER['REQUEST_METHOD'], $method)) {

			$route = str_replace(array_keys($this->patterns), array_values($this->patterns), $route);
			if (preg_match('@^' . $route . '/?$@', $this->currentRoute, $params)) {
				$this->routes[$route] = $callback;
				$this->__renderPage($route, $params);
			}
		} else {
			http_response_code(405); //Method Not Allowed
		}
	}

	private function __renderPage($route, $params)
	{
		global $app;
		if (is_callable($this->routes[$route])) {
			call_user_func($this->routes[$route], $params);
		} else {
			if (preg_match('@^([A-Za-z-_/]+)::([A-Za-z-_/]+)$@', $this->routes[$route])) {
				$appObj = explode('::', $this->routes[$route]);
				$app->setController($appObj[0]);
				$method = $appObj[1];

			} else {
				$app->setController($this->routes[$route]);
				$method = 'root';
			}
			try {
				if (in_array($method, get_class_methods($app->Controller))) {
					call_user_func_array([new $app->Controller, $method], $params);
				} else {
					throw new FrisbyException("Controller method '{$method}' does not exists on {$app->Controller}");
				}
			} catch (FrisbyException $e) {
				echo $e->getMessage();
				// TODO:: ERROR HANDLER
			}

		}
	}
}