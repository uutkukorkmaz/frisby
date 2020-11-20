<?php


namespace Frisby\Service\Schema;


use Frisby\Service\Database;

/**
 * Class Builder
 * @package Frisby\Service\Schema
 */
class Builder
{


    private string $tableName;
    private ?string $database;
    private ?string $primaryKey = null;
    private ?string $unique = null;
    private string $dbEngine = self::INNODB;
    private string $charset;
    private string $collate;
    public string $tableSQL;

    private const CURRENT_TS = "CURRENT_TIMESTAMP";
    private const INNODB = "InnoDB";
    private const MYISAM = "MyISAM";
    private const COL_INT = "INT";
    private const COL_VARCHAR = "VARCHAR";
    private const COL_TIMESTAMP = "TIMESTAMP";
    private const COL_ENUM = "ENUM";
    private const COL_TEXT = "TEXT";

    /**
     * Builder constructor.
     * @param $table
     */
    public function __construct($table)
    {

        $this->database = $_ENV['DB_NAME'];
        $this->charset = $_ENV['DB_CHARSET'];
        $this->collate = $_ENV['DB_TABLE_COLLATE'];
        $this->tableName = Database::getInstance()->getTableName($table);

        $this->tableSQL = "CREATE TABLE IF NOT EXISTS `{$this->database}`.`{$this->tableName}` (" . PHP_EOL;
    }

    public function int($columnName, $length = 11, $autoIncrement = false, $haveDefault = false)
    {
        return $this->addColumn($columnName, self::COL_INT, $length, false, $haveDefault, $autoIncrement);
    }

    public function varchar($columnName, $length = null, $isNull = false, $haveDefault = false)
    {
        $length = is_null($length) ? 255 : $length;
        return $this->addColumn($columnName, self::COL_VARCHAR, $length, $isNull, $haveDefault);
    }

    public function text($columnName, $isNull = false, $haveDefault = false)
    {
        return $this->addColumn($columnName, self::COL_TEXT, false, $isNull, $haveDefault);
    }


    public function timestamp($columnName, $isNull = false, $haveDefault = self::CURRENT_TS)
    {
        return $this->addColumn($columnName, self::COL_TIMESTAMP, false, $isNull, $haveDefault);
    }


    private function addColumn($columnName, $type, $length = false, $isNull = false, $haveDefault = false, $autoIncrement = false)
    {
        $len = $length ? "({$length})" : null;
        $this->tableSQL .= "`{$columnName}` {$type}{$len} " .
            ($isNull ? 'NULL' : 'NOT NULL') .
            ($haveDefault !== false ? " DEFAULT ".($haveDefault==self::CURRENT_TS?self::CURRENT_TS:"'{$haveDefault}'") : null) .
            ($autoIncrement ? " AUTO_INCREMENT" : null) .
            "," . PHP_EOL;
        return $this;
    }

    public function create($mode='live')
    {

        $this->tableSQL .= is_null($this->primaryKey) ?: "PRIMARY KEY (`{$this->primaryKey}`)".
            (is_null($this->unique)?:", UNIQUE (`{$this->unique}`)").")";
        $this->getEngine()->getCharset();
        if($mode == 'live')  Database::getInstance()->query($this->tableSQL);
        return $this;

    }

    public function isCreated()
    {
        $sql = "SELECT table_name FROM information_schema.tables WHERE table_schema=? AND table_name=?";
        $isCreated = Database::getInstance()->query($sql, [$this->database, $this->tableName], 'fetch');
        return $isCreated;
    }

    private function getEngine()
    {
        $this->tableSQL .= " ENGINE=" . $this->dbEngine . " ";
        return $this;
    }

    private function getCharset()
    {
        $this->tableSQL .= "CHARSET=" . $this->charset . " COLLATE " . $this->collate . ";";
        return $this;
    }

    public function setPrimaryKey($columnName)
    {
        $this->primaryKey = $columnName;
        return $this;
    }
    public function setUniqueKey($columnName){
        $this->unique = $columnName;
        return $this;
    }
}