<?php namespace Fun\Exceptions;

use Fun\Lexing\Tokens\Token;

class UnexpectedTokenTypeException extends \Exception
{
    public function __construct($expectedType, Token $token = null)
    {
        $message = $this->buildMessage($expectedType, $token);
        parent::__construct($message);
    }

    private function buildMessage($type, $token)
    {
        $expected = "Expected token type to be $type, but got";
        $got = $token ? $token->getType() : '<end of stream>';

        return "$expected $got instead";
    }
}