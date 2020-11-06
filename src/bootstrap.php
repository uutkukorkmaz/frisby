<?php
/**
 * @var Core $Frisby
*/

use Frisby\Framework\Router;
use Frisby\Framework\Request;
/**
 * Let's tell the Frisby must use this following middlewares
 * in the Application as interrupts.
*/
$Frisby->request->setMiddlewares([
    \Frisby\Middlewares\TestMiddleware::class,
]);

/**
 * Let's define routes.
*/
$Frisby->router->get('/',[\Frisby\Application\Controller\DefaultController::class,"SchemaTest"]);
$Frisby->router->get('/test',function (){
	echo "test in /test route";
});
$Frisby->router->get('/schema-tester',[\Frisby\Application\Controller\DefaultController::class,"SchemaTest"]);