<?php


namespace Frisby\Middlewares;


use Frisby\Framework\Middleware;

class TestMiddleware extends Middleware
{

    public function interrupt()
    {
        if (isset($_GET['test'])) {
            return;
        }
        throw new \Exception('This is a test interrupt');
    }
}