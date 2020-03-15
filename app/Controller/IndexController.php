<?php

namespace FrisbyApp\Controller;


use FrisbyApp\Model\IndexModel;
use FrisbyModule\Frisby\ControllerInterface;

/**
 * Class IndexController
 * @package FrisbyApp\Controller
 */
class IndexController implements ControllerInterface
{


	function __construct()
	{
		global $app, $loader,$db,$lang; // You just need to set variables to global that you want to use in your view files

		$app->Model = new IndexModel();
		require_once $loader->view('index');

	}

	/**
	 * REQUIRED CONTROLLER METHOD
	 */
	function root(){
		// If there is no defined method in routing, Frisby will try to execute this method after __construct()
	}




}