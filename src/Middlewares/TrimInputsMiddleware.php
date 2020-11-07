<?php


namespace Frisby\Middlewares;


class TrimInputsMiddleware extends \Frisby\Framework\Middleware
{

    public function interrupt()
    {
        $_GET = $this->trim($_GET);
    }

    public function trim($input)
    {
        $return = [];
        if(is_array($input)) {
            foreach ($input as $item => $value) {
                $return[$item] = (is_array($value) || is_object($value)) ? $this->trim($value) : $this->sanitize($value) ;
            }
        }else{
            $return = $this->sanitize($input);
        }
        return $return;
    }

    public function sanitize($string){
        return filter_var(trim($string), FILTER_SANITIZE_STRIPPED);
    }
}