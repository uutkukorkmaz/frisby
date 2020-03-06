<?php

require_once 'classes/Frisby/Loader.php';

use FrisbyModule\Frisby\Loader;

$loaded = [];
$loader = new Loader;
spl_autoload_register(function ($a) {
	global $loader;
	if(file_exists($loader->classLoader($a))){
		require_once $loader->classLoader($a);
	}
});

require_once 'config.php';