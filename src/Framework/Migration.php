<?php


namespace Frisby\Framework;


use Frisby\Service\Database;
use Frisby\Service\FileSystem;

class Migration
{

    public array $migrations;

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
        echo "Migration: Performing migration {$migration['name']} on direction $direction" . PHP_EOL;
        call_user_func_array([$migration['className'], strtolower($direction)], []);
        Database::Insert('frisby_migrations', ["name" => $migration['name']]);
    }

    public function applyAllMigrations(string $direction)
    {
        $applied = 0;
        foreach ($this->getAllMigrations() as $migration) {
            if (in_array($migration, $this->getAppliedMigrations())) continue;
            $this->executeMigration($migration, $direction);
            $applied++;
        }
        return var_dump($applied);
    }

    public function getAppliedMigrations()
    {
        $appliedMigrations = Database::SelectAll('frisby_migrations');
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