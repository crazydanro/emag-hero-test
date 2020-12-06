<?php


namespace src\Library;

/**
 * Class Output
 * @package src\Library
 */
class Output
{
    /**
     * @param string $message
     */
    public static function write(string $message)
    {
        echo $message.PHP_EOL;
    }
}