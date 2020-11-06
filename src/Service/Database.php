<?php


namespace Frisby\Service;


use Frisby\Framework\Singleton;
use \PDO;

/**
 * Class Database
 * @package Frisby\Service
 * @extends Frisby\Framework\Singleton
 */
class Database extends Singleton
{
    const DEFAULT_FETCH_MODE = PDO::FETCH_OBJ;
    public ?PDO $pdo;

    const SQL_SelectAll = "SELECT * FROM %s";
    const SQL_SelectByID = "SELECT * FROM %s WHERE id=?";
    const SQL_SelectByOneColumn = "SELECT * FROM %s WHERE %s=?";
    const SQL_SelectFlex = "SELECT * FROM %s WHERE %s";

    const SQL_Insert = "INSERT INTO %s SET %s";
    const SQL_Update = "UPDATE %s SET %s WHERE %s";
    const SQL_Delete = "DELETE FROM %s WHERE %s";

    private static ?string $dbPrefix;

    protected function __construct()
    {
        parent::__construct();
        self::$dbPrefix = $_ENV['DB_PREFIX'] ?? null;
        $this->pdo = new PDO(self::generateDSN(), $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, self::DEFAULT_FETCH_MODE);
    }

    public function query(string $sql, array $params = [], string $fetch_function = 'fetchAll')
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);

        return explode(' ', $sql)[0] == 'SELECT' ? $statement->$fetch_function() : $statement;
    }

    public function lastID()
    {
        return $this->pdo->lastInsertId();
    }

    public function getTableName(string $table = "")
    {
        return self::$dbPrefix . $table;
    }

    private static function generateDSN(): string
    {
        return sprintf("mysql:host=%s;port=%s;dbname=%s;charset=%s;",
            $_ENV['DB_HOST'],
            $_ENV['DB_PORT'],
            $_ENV['DB_NAME'],
            $_ENV['DB_CHARSET']);
    }

}