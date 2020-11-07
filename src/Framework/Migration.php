<?php


namespace Frisby\Framework;


use Frisby\Service\Database;
use Frisby\Service\FileSystem;
use Frisby\Service\Schema;

class Migration
{

    public array $migrations;

    public function __construct()
    {
        Schema::create('frisby_migrations', function (Schema\Builder $builder) {
            $table = $builder->int('id', 11, true)->setPrimaryKey('id')
                ->varchar('name')->setUniqueKey('name')
                ->timestamp('executedAt')
                ->create();
            if (!$table->isCreated()) {
                throw new \PDOException('Frisby Migrations table can not creatable' . PHP_EOL);
            }
        });
    }

    public function getAllMigrations()
    {
        $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . "Migrations";
        $fs = new FileSystem($path);
        $migrations = $fs->read();
        foreach ($migrations as $migration) {
            if (is_dir($migration)) continue;
            $this->migrations[] = $this->getMigration($migration);
        }
        return $this->migrations;
    }

    private function getMigrationName(string $file)
    {
        return pathinfo($file, PATHINFO_FILENAME);
    }

    public function getMigration(string $file)
    {
        $cname = $this->getMigrationName($file);
        $arr = explode('_', $cname);
        $id = (int)$arr[1];
        unset($arr[0], $arr[1]);
        $name = implode('_', $arr);
        return [
            "className" => 'Frisby\\Migrations\\' . $cname,
            "id" => $id,
            "name" => $name
        ];
    }

    public function migrate($migration)
    {
        $this->executeMigration($migration, 'up');
    }

    public function rollback($migration)
    {
        $this->executeMigration($migration, 'down');
    }

    private function executeMigration(array $migration, string $direction = 'up')
    {
        $cli = CommandLine::getInstance();
        $cli->echo("Performing migration {$migration['name']} on direction $direction", get_class($this), $cli::FG_YELLOW);
        call_user_func_array([$migration['className'], strtolower($direction)], []);
        sleep(1);
        Database::Insert('frisby_migrations', ["id" => $migration['id'], "name" => $migration['name']]);

        if (Database::getInstance()->lastID() != 0) {
            $cli->echo("Applied migration inserted to database", get_class($this), $cli::FG_GREEN);
        } else {
            $cli->echo("There is no migration to apply", get_class($this), $cli::FG_MAGENTA);
        }
    }

    public function applyAllMigrations(string $direction)
    {
        $applied = 0;
        foreach ($this->getAllMigrations() as $migration) {
            if ($direction == 'up' && in_array($migration, $this->getAppliedMigrations())) continue;
            $this->executeMigration($migration, $direction);
            $applied++;
        }
        if ($applied > 0) {
            CommandLine::getInstance()->echo("$applied migration(s) successfully applied",$this,CommandLine::FG_GREEN);
        } else {
            CommandLine::getInstance()->echo("There is no migration to apply",$this,CommandLine::FG_MAGENTA);
        }
    }

    public function getAppliedMigrations()
    {
        $appliedMigrations = Database::SelectAll('frisby_migrations') ?? [];
        $applied = [];
        foreach ($appliedMigrations as $item) {
            $applied[] = $this->getMigration($this->findMigrationFile($item->name));
        }
        return $applied;
    }


    private function findMigrationFile(string $name, $ext = true)
    {
        $record = Database::GetDataByColumn('frisby_migrations', 'name', $name, true);
        $filename = "migration_" .
            str_pad($record->id, $_ENV['MIGRATION_ID_LENGTH'], "0", STR_PAD_LEFT) . "_" .
            $record->name;
        return $filename . (!$ext ?: '.php');
    }


}