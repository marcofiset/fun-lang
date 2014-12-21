<?php namespace Fun\Lexing;

class UnknownTokenException extends \Exception
{
    public function __construct($index)
    {
        parent::__construct("Unknown token encountered at position $index");
    }
}