<?php


namespace Frisby\Framework;


/**
 * Class Response
 * @package Frisby\Framework
 */
class Response extends Singleton
{
	public int $code = 200;

	/**
	 * @param int $code
	 */
	public function setCode(int $code){
		$this->code = $code;
	}

}