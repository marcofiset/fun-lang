<?php namespace Fun\Exceptions;

use Fun\PositionInformation;

class UnknownTokenException extends FunException
{
    public function __construct(PositionInformation $position)
    {
        parent::__construct('Unknown token encountered at position', $position);
    }
}