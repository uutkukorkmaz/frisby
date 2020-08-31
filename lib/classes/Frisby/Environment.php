<?php
declare(strict_types=1);


namespace FrisbyModule\Frisby;


/**
 * Frisby Framework
 * Environment Class
 *
 * This is the most useless class I've ever think. Going to deprecated soon.
 *
 * @author Utku Korkmaz
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