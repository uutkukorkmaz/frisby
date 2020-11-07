<?php


namespace Frisby\Framework;


class Command
{

    public string $name;
    public string $description;
    public string $namespace="Frisby\\Command\\";

    /**
     * Command constructor.
     * @param string $commandName
     */
    public function __construct(string $commandName)
    {
        $this->name = $commandName;
    }
    
    public function description(string $desc){
        $this->description = $desc;
        return $this;
    }


}