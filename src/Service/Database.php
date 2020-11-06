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

    public static function SelectAll($table)
    {
        $db = self::getInstance();
        return $db->query(sprintf(self::SQL_SelectAll, $db->getTableName($table)));
    }

    /**
     * Performs ID specified SELECT query on target table
     * @param $table
     * @param $id
     * @return bool|\PDOStatement
     */
    public static function GetDataByID($table, $id)
    {
        $db = self::getInstance();
        return $db->query(sprintf(self::SQL_SelectByID, $db->getTableName($table)), [$id], 'fetch');
    }

    /**
     * Performs SELECT query only one column WHERE condition on target table
     *
     * @param $table
     * @param $column
     * @param $value
     * @param false $singleRow
     * @return bool|\PDOStatement
     */
    public static function GetDataByColumn($table, $column, $value, $singleRow = false)
    {
        $db = self::getInstance();
        return $db->query(sprintf(self::SQL_SelectByOneColumn, $db->getTableName($table), $column), [$value], $singleRow ? 'fetch' : 'fetchAll');
    }

    /**
     * Performs SELECT query
     *
     * @param $table
     * @param array $where
     * @param false $singleRow
     * @return bool|\PDOStatement
     */
    public static function GetData($table, $where = [], $singleRow = false)
    {
        $db = self::getInstance();
        $whereSQL = "";
        $whereData = [];
        if (count($where) > 0) {
            foreach ($where as $column => $value) {
                $whereSQL .= "$column=? && ";
                $whereData[] = $value;
            }
        } else {
            $whereSQL = "1";
        }
        return $db->query(sprintf(self::SQL_SelectFlex, $db->getTableName($table), rtrim($whereSQL, ' && ')), $whereData, $singleRow ? 'fetch' : 'fetchAll');
    }


    /**
     * Performs INSERT query
     *
     * @param $table
     * @param $data
     * @return false|int
     */
    public static function Insert($table, $data)
    {
        $db = self::getInstance();
        $queryColumns = "";
        $pdoFormat = [];
        foreach ($data as $column => $value) {
            $queryColumns .= "$column=?, ";
            $pdoFormat[] = $value;
        }
        try {
            $db->query(sprintf(self::SQL_Insert, $db->getTableName($table), rtrim($queryColumns, ', ')), $pdoFormat);
            return $db->lastID();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * Performs UPDATE query
     * @param string $table
     * @param array $where
     * @param array $data
     * @return bool|\PDOStatement
     */
    public static function Update(string $table, array $where, array $data)
    {
        $db = self::getInstance();
        $updateColumns = "";
        $updateValues = [];
        $whereSQL = "";
        foreach ($data as $column => $value) : $updateColumns .= "$column=?, ";
            $updateValues[] = $value; endforeach;
        foreach ($where as $column => $value): $whereSQL .= "$column=? && ";
            $updateValues[] = $value; endforeach;
        try {
            return $db->query(sprintf(self::SQL_Update, $db->getTableName($table), rtrim($updateColumns, ', '), rtrim($whereSQL, ' && ')), $updateValues);
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }


    /**
     * Performs DELETE query
     *
     * @param string $table
     * @param array $where
     * @return bool|\PDOStatement
     */
    public static function Delete(string $table, array $where)
    {
        $db = self::getInstance();
        $delColumns = "";
        $delValues = [];
        foreach ($where as $column => $value): $delColumns .= "$column=? && ";
            $delValues[] = $value; endforeach;
        return $db->query(sprintf(self::SQL_Delete, $db->getTableName($table), rtrim($delColumns, ' && ')), $delValues);
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