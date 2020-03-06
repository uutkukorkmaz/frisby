<?php

namespace FrisbyApp\Controller;


use FrisbyApp\Model\IndexModel;

class IndexController
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

	public function __destruct()
	{
		//echo 'index footer';
	}


}