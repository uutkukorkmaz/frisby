<?php


namespace Frisby\Service;


use Closure;

/**
 * Class Schema
 * @package Frisby\Service
 */
class Schema
{


	/**
	 * @param string $table
	 * @param Closure|null $callback
	 */
	public static function create(string $table,Closure $callback=null){
		$builder = new Schema\Builder($table);
		if(is_callable($callback)) call_user_func($callback,$builder);
		return $builder;
	}
	/**
	 * @param string $table
	 */
	public static function drop(string $table){
		$db = Database::getInstance();
		$db->query(sprintf("DROP TABLE IF EXISTS %s",$db->getTableName($table)));
	}
}