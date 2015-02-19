<?php namespace Fun\Exceptions;

use Fun\PositionInformation;

class FunException extends \Exception
{
    public function __construct($message, PositionInformation $position)
    {
        $line = $position->getLine();
        $column = $position->getColumn();

        parent::__construct($message . ", at line:column $line:$column");
    }
}