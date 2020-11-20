<?php
/**
 *
 * You know what it is, right?
 *
*/
declare(strict_types=1);


/**
 *
 * Defining root directory
 *
*/
define('FRISBY_ROOT', dirname(__DIR__));

/**
 *
 * There's no Frisby without composer autoload. So...
 *
*/
require_once FRISBY_ROOT . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

/**
 *
 * Let us tell the php that we will use Frisby's Core class in this very script
 *
*/
use Frisby\Framework\Core;

/**
 *
 * DotEnv.. such a great class!
 *
*/
$dotenv = Dotenv\Dotenv::createImmutable(FRISBY_ROOT);
$dotenv->load();


/**
 *
 * Well, let's create an instance for the Core class
 *
*/
$Frisby = new Core();


/**
 *
 * Frisby needs some services and directives to run. Why don't we define 'em for Frisby?
 *
*/
require_once FRISBY_ROOT . DIRECTORY_SEPARATOR . 'src/bootstrap.php';

/**
 *
 * Everything seems like OK.
 *
 * Run Frisby, Run!
 *
*/
$Frisby->run();