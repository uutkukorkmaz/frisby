<?php


namespace Frisby\Application\Controller;


use Frisby\Component\Controller;

class DefaultController extends Controller
{

	public function render(array $params)
	{
		echo "<img src='http://localhost/frisby/public/assets/img/test.jpg'>";
	}
}