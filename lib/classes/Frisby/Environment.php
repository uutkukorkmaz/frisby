<?php


namespace FrisbyModule\Frisby;


/**
 * Class Environment
 * @package FrisbyModule\Frisby
 */
class Environment
{
	public $state;

	/**
	 * Environment constructor.
	 * @param $environment
	 */
	public function __construct($environment)
	{
		$this->state = $environment;
	}
}