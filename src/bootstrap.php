<?php

use Frisby\Framework\Router;

$Frisby->router->get('/',[\Frisby\Application\Controller\DefaultController::class,"SchemaTest"]);
$Frisby->router->get('/test',function (){
	echo "test in /test route";
});
$Frisby->router->get('/schema-tester',[\Frisby\Application\Controller\DefaultController::class,"SchemaTest"]);