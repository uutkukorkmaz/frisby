<?php


namespace Frisby\Migrations;


use Frisby\Framework\MigrationBase;
use Frisby\Service\Database;
use Frisby\Service\Schema;

class migration_00001_initial extends MigrationBase
{

    public static function up()
    {
        Schema::create('frisby_migrations', function (Schema\Builder $builder) {
            $table = $builder->int('id', 11, true)->setPrimaryKey('id')
                ->varchar('name')->setUniqueKey('name')
                ->timestamp('executedAt')
                ->create();
            if($table->isCreated()){
                echo "Migration : ".static::class."::up has been applied".PHP_EOL;
            }else{
               echo $table->tableSQL.PHP_EOL.PHP_EOL;
               //throw new \PDOException('Frisby Migrations table can not creatable'.PHP_EOL);
            }
        });
    }


    public static function down()
    {}
}