<?php


namespace Frisby\Framework;


class CommandLine extends Singleton
{

    public array $commands;

    public const FG_BLACK = "\x1b[30m";
    public const FG_RED = "\x1b[31m";
    public const FG_GREEN = "\x1b[32m";
    public const FG_YELLOW = "\x1b[33m";
    public const FG_BLUE = "\x1b[34m";
    public const FG_MAGENTA = "\x1b[35m";
    public const FG_CYAN = "\x1b[36m";
    public const FG_WHITE = "\x1b[37m";

    public const BG_BLACK = "\x1b[40m";
    public const BG_RED = "\x1b[41m";
    public const BG_GREEN = "\x1b[42m";
    public const BG_YELLOW = "\x1b[43m";
    public const BG_BLUE = "\x1b[44m";
    public const BG_MAGENTA = "\x1b[45m";
    public const BG_CYAN = "\x1b[46m";
    public const BG_WHITE = "\x1b[47m";

    protected array $argv;
    /**
     * @var mixed
     */
    private $requestedCommand;

    public function init($argv)
    {
        $this->echo("Frisby Command Line Tool activated", $this, self::FG_BLUE);
        unset($argv[0]);
        rsort($argv);
        $this->argv = $argv;
        $this->requestedCommand = $this->argv[0];
        if (array_key_exists($this->requestedCommand, $this->commands)) {
            $command = $this->commands[$this->requestedCommand];
            $class = $command->namespace.$command->name;
            $cmd = new $class();
            $cmd->call($this->argv);
        } else {
            $this->echo('There is no such a ' . $this->requestedCommand . ' commmand');
        }
    }


    public function newCommand($commandName)
    {
        $this->commands[$commandName] = new Command($commandName);
        return $this->commands[$commandName];
    }

    public function echo(string $message, $where = 'Frisby', $foreground = self::FG_WHITE)
    {
        $where = is_string($where) ? $where : get_class($where);
        echo   PHP_EOL.$foreground . "[$where]: " . self::FG_WHITE . $message . self::FG_WHITE;
    }


}