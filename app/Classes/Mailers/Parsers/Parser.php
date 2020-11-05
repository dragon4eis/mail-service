<?php


namespace App\Classes\Mailers\Parsers;


abstract class Parser
{
    const  TYPE = null;

    public function getFormat(){
        return self::TYPE;
    }

    abstract public function reFormat(string $message): string;
}
