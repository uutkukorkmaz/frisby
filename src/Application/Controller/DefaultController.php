<?php


namespace Frisby\Application\Controller;


use Frisby\Component\Controller;
use Frisby\Component\Core;

class DefaultController extends Controller
{

	public function render(array $params)
	{
		//echo json_encode(Core::getInstance()->db::selectAll('activities'));
	}

	public function testMethod(){
	    echo "test page";

    }
}