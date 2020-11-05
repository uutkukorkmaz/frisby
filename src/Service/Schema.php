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
	 * CREATE TABLE `test`.`testtable` (
	 * `id` INT NOT NULL AUTO_INCREMENT ,
	 * `nullVarcharCol` VARCHAR(30) NULL ,
	 * `notNullVarcharCol` VARCHAR(30) NOT NULL ,
	 * `defaultValueVarcharCol` VARCHAR(30) NOT NULL DEFAULT 'this value is default' ,
	 * `timestampCol` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
	 * `enumSetCol` ENUM('value_1','value_2','value_3','value_4') NOT NULL ,
	 * `textCol` TEXT NOT NULL ,
	 * PRIMARY KEY  (`id`))
	 * ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
	 */

	/**
	 * @param string $table
	 * @param Closure|null $callback
	 */
	public static function create(string $table,Closure $callback=null){
		$builder = new Schema\Builder($table);
	}

}