<?php


namespace Frisby\Framework;


/**
 * Class MigrationBase
 * @package Frisby\Framework
 */
abstract class MigrationBase
{

    abstract public static function up();

    abstract public static function down();

}