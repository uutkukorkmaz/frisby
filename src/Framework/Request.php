<?php


namespace Frisby\Framework;


use Frisby\Exception\NoSuchInput;
use Frisby\Service\Validation;

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
        $this->uri = explode('?', str_replace($_ENV['APP_ROOT'], null, $_SERVER['REQUEST_URI']))[0];
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function interrupt()
    {
        // load and execute middlewares
        /**
         * @var Middleware $mw
         */
        foreach ($this->middlewares as $mw) {
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

    public static function input($key)
    {
        $inputPost = array_key_exists($key, $_POST);
        $inputGet = array_key_exists($key, $_GET);
        if ($inputPost || $inputGet)
            return $inputPost ? $_POST[$key] : $_GET[$key];
        else
            return null;

    }

    public static function inputs(...$keys)
    {
        $return = [];
        if ($keys[0] == "*") return $_GET + $_POST;
        foreach ($keys as $key) {
            $return[$key] = self::input($key);
        }
        return $return;
    }

    public function validate(array $inputs)
    {
        $validate = Validation::getInstance();
        $result = new \stdClass();

        foreach ($inputs as $input => $conditions) {
            if (is_null(self::input($input))) {
                throw new NoSuchInput($input);
            } else {
                $validate->setData(self::input($input));
                $result->{$input} = new \stdClass();
                foreach ($conditions as $method => $param) {
                    if (is_numeric($method)): $method = $param;
                        $param = null; endif;
                    $result->{$input}->{$method} = $validate->$method($param);
                }
                $result->{$input}->isValid = array_product((array)$result->$input);
            }
        }
        return (object)$result;
    }


}