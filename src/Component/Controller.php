<?php


namespace Frisby\Component;


/**
 * Class Controller
 * @package Frisby\Component
 * @author Utku Korkmaz <uutkukorkmaz@gmail.com>
 */
abstract class Controller
{

	abstract public function render(array $params);
}