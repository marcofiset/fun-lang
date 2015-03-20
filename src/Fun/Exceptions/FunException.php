<?php namespace Fun\Exceptions;

use Fun\Position;

class FunException extends \Exception
{
    public function __construct($message, Position $position)
    {
        $line = $position->getLine();
        $column = $position->getColumn();

        parent::__construct($message . ", at line:column $line:$column");
    }
}