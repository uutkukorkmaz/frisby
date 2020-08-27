<?php

$app->route->add('/', 'IndexController');

$app->route->add('/test', function () {
	// Your quick controller...
	echo "quick controller";
});
