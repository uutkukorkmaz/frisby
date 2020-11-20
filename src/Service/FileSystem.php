<?php


namespace Frisby\Service;


use Frisby\Framework\Singleton;

/**
 * Class FileSystem
 * @package Frisby\Service
 */
class FileSystem extends Singleton
{
    public string $path;


    /**
     * FileSystem constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        $this->type = is_dir($path) ? 'dir' : (is_file($path) ? 'file' : 'unknown');
    }

    public function read($ignore = [".", ".."])
    {
        switch ($this->type) {
            case "dir":
                $arr = array_diff(scandir($this->path), $ignore);
                sort($arr);
                return $arr;
                break;
            case "file":
                return file_get_contents($this->path);
                break;
            case "unknown":
            default:

                break;
        }
    }


}