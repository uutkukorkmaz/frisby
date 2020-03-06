<?php


namespace FrisbyModule\Frisby;


class Environment
{
	public $state;
	public function __construct($environment)
	{
		$this->state = $environment;
	}
}