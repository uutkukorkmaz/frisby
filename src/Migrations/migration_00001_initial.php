<?php


namespace Frisby\Migrations;


use Frisby\Framework\MigrationBase;
use Frisby\Service\Database;
use Frisby\Service\Schema;

class migration_00001_initial extends MigrationBase
{

    public static function up()
    {

    }


    public static function down()
    {
        Schema::drop('frisby_migrations');
    }
}