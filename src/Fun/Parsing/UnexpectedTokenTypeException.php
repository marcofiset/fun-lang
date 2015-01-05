<?php
namespace Fun\Parsing;

class UnexpectedTokenTypeException extends \Exception
{
    function __construct($expectedType, $actualType)
    {
        parent::__construct('Expected a token of type "' . $expectedType .
            '", but got a token of type "' . $actualType . '" instead.');
    }
}