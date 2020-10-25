<?php


namespace Frisby\Module;






class Router
{

    public Request $request;

    public function __construct($core)
    {
        $core->response = new Response();


    }

    public static function parseURL()
    {


    }
}