<?php

use Frisby\Component\Router;
use Frisby\Application\Controller\DefaultController;
$Frisby->route->pattern(':id', [Router::MUST_HAVE_NUMERIC]);
$Frisby->route->pattern(':permalink', [
	Router::MUST_HAVE_NUMERIC,
	Router::MUST_HAVE_LOWERCASE,
	Router::MUST_HAVE_SCORE,
	Router::MUST_HAVE_UPPERCASE
]);

$Frisby->route->get('/page/:permalink',DefaultController::class);
