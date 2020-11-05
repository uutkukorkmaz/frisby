<?php
define('FRISBY_ROOT', dirname(__DIR__));
require_once FRISBY_ROOT . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use Frisby\Framework\Core;

$dotenv = Dotenv\Dotenv::createImmutable(FRISBY_ROOT);
$dotenv->load();

$Frisby = new Core();
$Frisby->container->registerService([\Frisby\Service\Logger::class, \Frisby\Service\Database::class]);

require_once FRISBY_ROOT . DIRECTORY_SEPARATOR . 'src/bootstrap.php';

$Frisby->run();