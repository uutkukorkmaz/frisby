<?php
declare(strict_types=1);


namespace FrisbyModule\Frisby;

use \PDO;

/**
 * Frisby Framework
 * Database Class
 *
 * This class handles database connection and query stuff
 *
 * @author Utku Korkmaz
 * @package FrisbyModule\Frisby
 */
class Database
{
	protected $handler;

	const DEFAULT_FETCH_MODE = PDO::FETCH_ASSOC;

	protected $defaults = [
		"dbhost" => "localhost", "username" => "root", "password" => "", "charset" => "utf8", "dbname" => null, "options" => null
	];

	/**
	 * Database constructor.
	 * @param array $options
	 */
	public function __construct($options = [])
	{
		try {
			$options = array_merge($this->defaults, $options);
			$this->handler = new PDO("mysql:host={$options['dbhost']};dbname={$options['dbname']};charset={$options['charset']};", $options['username'], $options['password'], $options['options']);
			$this->handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->handler->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, self::DEFAULT_FETCH_MODE);
			return $this->handler;
		} catch (\PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	/**
	 * @param $sql
	 * @param array $params
	 * @param string $fetch_function
	 * @return bool|\PDOStatement
	 */
	public function query($sql, $params = [], $fetch_function = 'fetchAll')
	{
		$statement = $this->handler->prepare($sql);
		$statement->execute($params);

		return explode(' ', $sql)[0] == 'SELECT' ? $statement->$fetch_function() : $statement;
	}

}