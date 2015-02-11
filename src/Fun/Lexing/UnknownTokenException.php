<?php namespace Fun\Lexing;

class UnknownTokenException extends \Exception
{
    public function __construct($line, $column)
    {
        parent::__construct("Unknown token encountered at position $line:$column");
    }
}