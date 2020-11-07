<?php


namespace Frisby\Command;


use Frisby\Framework\CommandInterface;
use Frisby\Framework\CommandLine;
use Frisby\Framework\Migration;

class migrate implements CommandInterface
{

    public function call($args)
    {
        $migration = new Migration();
        if(in_array('--up',$args) || in_array('-u',$args)){
            $migration->applyAllMigrations('up');
        }else if(in_array('--down',$args) || in_array('-d',$args) ||
            in_array('--rollback',$args) ||
            in_array('-rb',$args)
        ){
            $migration->applyAllMigrations('down');
        }else{
            CommandLine::getInstance()->echo('You need to provide a direction to migrate',$this,CommandLine::FG_MAGENTA);
        }
    }
}