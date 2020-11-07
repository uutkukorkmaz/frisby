<?php


namespace Frisby\Application\Controller;

/**
 * Class DefaultController
 * @package Frisby\Application\Controller
 */
class DefaultController extends \Frisby\Framework\Controller
{

	/**
	 * @inheritDoc
	 */
	function render(...$params)
	{
		// TODO: Implement render() method.
		echo "this is the default controller";
        var_dump($_GET);
	}

}