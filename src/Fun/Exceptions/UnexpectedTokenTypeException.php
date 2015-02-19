<?php namespace Fun\Exceptions;

use Fun\Lexing\Tokens\Token;
use Fun\PositionInformation;

class UnexpectedTokenTypeException extends FunException
{
    public function __construct($expectedType, Token $token = null, PositionInformation $position)
    {
        $message = $this->buildMessage($expectedType, $token);
        parent::__construct($message, $position);
    }

    private function buildMessage($type, $token)
    {
        $expected = "Expected token type to be $type, but got";
        $got = $token ? $token->getType() : '<end of stream>';

        return "$expected $got instead";
    }
}