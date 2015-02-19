<?php namespace Fun\Exceptions;

class FunException extends \Exception
{
    public function __construct($message, $line, $column)
    {
        parent::__construct($message . ", at line:column $line:$column");
    }
}