<?php
declare(strict_types=1);
require 'lib/autoload.php';

use FrisbyModule\Frisby\Core;
use FrisbyModule\Frisby\Cookie;
use FrisbyModule\Frisby\Language;
use FrisbyModule\Frisby\Database;

$app = new Core('Frisby','development');
$lang = new Language();
$db = new Database(['dbname' => 'test']);
$cookie = new Cookie($_COOKIE);
require 'lib/Routes.php';

