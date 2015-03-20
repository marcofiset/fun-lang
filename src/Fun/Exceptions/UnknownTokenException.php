<?php namespace Fun\Exceptions;

use Fun\Position;

class UnknownTokenException extends FunException
{
    public function __construct(Position $position)
    {
        parent::__construct('Unknown token encountered at position', $position);
    }
}