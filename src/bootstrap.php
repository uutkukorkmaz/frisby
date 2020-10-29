<?php
use Frisby\Module\Router;
$Frisby->route->pattern('%id%',[Router::MUST_HAVE_NUMERIC]);

$Frisby->route->add('test','test');