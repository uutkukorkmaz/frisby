<?php


namespace Frisby\Framework;


/**
 * Class Controller
 * @package Frisby\Framework
 */
abstract class Controller
{


	public function __construct()
	{
	}

	/**
	 * @param mixed ...$params
	 * @return mixed
	 */
	abstract public function base(...$params);
}