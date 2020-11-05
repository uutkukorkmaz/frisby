<?php


namespace Frisby\Service;

use Frisby\Framework\Singleton;

/**
 * Class Logger
 * @package Frisby\Service
 * @extends Frisby\Framework\Singleton
 */
class Logger extends Singleton
{

	private $fileHandle;


	protected function __construct()
	{
		$this->fileHandle = fopen(FRISBY_ROOT.$_ENV['FRISBY_LOG'], 'w+');
	}


	public function writeLog(string $message): void
	{
		$date = date('[Y-m-d H:i:s]');
		fwrite($this->fileHandle, "$date: $message".PHP_EOL);
	}


	public static function push(string $message): void
	{
		$logger = static::getInstance();
		$logger->writeLog($message);
	}
}