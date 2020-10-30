<?php
define('FRISBY_ROOT',dirname(__DIR__));
require_once FRISBY_ROOT . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use Frisby\Component\Core;

$dotenv = Dotenv\Dotenv::createImmutable(FRISBY_ROOT);
$dotenv->load();
$Frisby = new Core();
require_once FRISBY_ROOT. DIRECTORY_SEPARATOR . 'src/bootstrap.php';
