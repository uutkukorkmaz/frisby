<?php
use Frisby\Component\Router;
$Frisby->route->pattern(':id',[Router::MUST_HAVE_NUMERIC]);

$Frisby->route->add('/test/:id','test');