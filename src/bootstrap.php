<?php
/**
 *
 * Hey, Frisby!
 * You should contain following services, so register them!
 *
 * @var \Frisby\Framework\Core $Frisby
*/
$Frisby->container->registerService([\Frisby\Service\Database::class]);

/**
 *
 * Let's tell the Frisby must use this following middlewares
 * in the Application as interrupts.
 *
*/
$Frisby->request->setMiddlewares([
    \Frisby\Middlewares\TrimInputsMiddleware::class,
]);

/**
 * Some cables here...
 *
 * OMG! What a mess!
*/
require_once "routes.php";