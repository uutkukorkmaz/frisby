<?php
require 'lib/autoload.php';
use FrisbyModule\Frisby\Core;
use FrisbyModule\Frisby\Language;
use FrisbyModule\Frisby\Database;
$app = new Core('development');
$lang = new Language();
$db = new Database(['dbname'=>'jig']);
$cookie = new \FrisbyModule\Frisby\Cookie($_COOKIE);
require 'lib/Routes.php';


//print_r($db->query("SELECT * FROM options WHERE name=:opt",[':opt'=>'domain'],'fetch'));
