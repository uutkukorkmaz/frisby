<?php
declare(strict_types=1);


namespace FrisbyModule\Frisby;


/**
 * Class DatabaseHandler
 * @package FrisbyModule\Frisby
 */
class DatabaseHandler extends Database
{
	const SQL_SelectAll = "SELECT * FROM %s";
	const SQL_SelectByID = "SELECT * FROM %s WHERE id=?";
	const SQL_SelectByOneColumn = "SELECT * FROM %s WHERE %s=?";
	const SQL_SelectFlex = "SELECT * FROM %s WHERE %s";

	const SQL_Insert = "INSERT INTO %s SET %s";
	const SQL_Update = "UPDATE %s SET %s WHERE %s";
	const SQL_Delete = "DELETE FROM %s WHERE %s";
	
	const dbPrefix = "";

	/**
	 * Performs general SELECT query on target table
	 * @param $table
	 * @return bool|\PDOStatement
	 */
	public static function SelectAll($table)
	{
		global $db;
		return $db->query(sprintf(self::SQL_SelectAll, self::dbPrefix . $table));
	}

	/**
	 * Performs ID specified SELECT query on target table
	 * @param $table
	 * @param $id
	 * @return bool|\PDOStatement
	 */
	public static function GetDataByID($table, $id)
	{
		global $db;
		return $db->query(sprintf(self::SQL_SelectByID, self::dbPrefix . $table), [$id], 'fetch');
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
		global $db;
		return $db->query(sprintf(self::SQL_SelectByOneColumn, self::dbPrefix . $table, $column), [$value], $singleRow ? 'fetch' : 'fetchAll');
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
		global $db;
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
		return $db->query(sprintf(self::SQL_SelectFlex, self::dbPrefix . $table, rtrim($whereSQL, ' && ')), $whereData, $singleRow ? 'fetch' : 'fetchAll');
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
		global $db;
		$queryColumns = "";
		$pdoFormat = [];
		foreach ($data as $column => $value) {
			$queryColumns .= "$column=?, ";
			$pdoFormat[] = $value;
		}
		try {
			$db->query(sprintf(self::SQL_Insert, self::dbPrefix . $table, rtrim($queryColumns, ', ')), $pdoFormat);
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
		global $db;
		$updateColumns = "";
		$updateValues = [];
		$whereSQL = "";
		foreach ($data as $column => $value) : $updateColumns .= "$column=?, ";
			$updateValues[] = $value; endforeach;
		foreach ($where as $column => $value): $whereSQL .= "$column=? && ";
			$updateValues[] = $value; endforeach;
		try {
			return $db->query(sprintf(self::SQL_Update, self::dbPrefix . $table, rtrim($updateColumns, ', '), rtrim($whereSQL, ' && ')), $updateValues);
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
		global $db;
		$delColumns = "";
		$delValues = [];
		foreach ($where as $column => $value): $delColumns .= "$column=? && ";
			$delValues[] = $value; endforeach;
		return $db->query(sprintf(self::SQL_Delete, self::dbPrefix . $table, rtrim($delColumns, ' && ')), $delValues);
	}
}