<?php


namespace Frisby\Application\Controller;


use Frisby\Component\Controller;

class DefaultController extends Controller
{

	public function render(array $params)
	{
		echo "Default Controller";
	}
}