<?php


namespace Frisby\Component;


use \PDO;

/**
 * Class Database
 * @package Frisby\Component
 */
class Database
{

	const DEFAULT_FETCH_MODE = PDO::FETCH_OBJ;
	protected ?PDO $pdo;

	const SQL_SelectAll = "SELECT * FROM %s";
	const SQL_SelectByID = "SELECT * FROM %s WHERE id=?";
	const SQL_SelectByOneColumn = "SELECT * FROM %s WHERE %s=?";
	const SQL_SelectFlex = "SELECT * FROM %s WHERE %s";

	const SQL_Insert = "INSERT INTO %s SET %s";
	const SQL_Update = "UPDATE %s SET %s WHERE %s";
	const SQL_Delete = "DELETE FROM %s WHERE %s";

	private static ?string $dbPrefix;

	private static Database $instance;

	public function __construct()
	{
		self::$instance = $this;
		self::$dbPrefix = $_ENV['DB_PREFIX'] ?? null;
		$this->pdo = new PDO(self::generateDSN($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_CHARSET']), $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, self::DEFAULT_FETCH_MODE);

	}

	public static function getInstance()
	{
		return self::$instance;
	}

	public static function selectAll(string $table)
	{
		$db = self::getInstance();
		//$db->query(sprintf())
	}

	public function query(string $sql, array $params = [], string $fetch_function = 'fetchAll'): ?\PDOStatement
	{
		$statement = $this->pdo->prepare($sql);
		$statement->execute($params);

		return explode(' ', $sql)[0] == 'SELECT' ? $statement->$fetch_function() : $statement;
	}

	public function lastID(): int
	{
		return $this->pdo->lastInsertId();
	}

	private static function generateDSN(string $host, string $db, string $charset): string
	{
		return "mysql:host={$host};dbname={$db};charset={$charset};";
	}
}