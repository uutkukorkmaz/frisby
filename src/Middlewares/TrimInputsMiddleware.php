<?php


namespace Frisby\Middlewares;


class TrimInputsMiddleware extends \Frisby\Framework\Middleware
{

    public function interrupt()
    {
        $_POST = $this->trim($_POST);
        $_GET = $this->trim($_GET);
    }

    private function trim($input)
    {
        $return = [];
        foreach ($input as $item => $value) {
            $return[$item] = (is_array($value) || is_object($value)) ? $this->trim($value) : filter_var(strip_tags(trim($value)),FILTER_SANITIZE_STRIPPED);
        }
        return $return;
    }
}