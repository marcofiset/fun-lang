<?php namespace Fun\Exceptions;

use Fun\Position;

class UnexpectedTokenException extends FunException
{
    public function __construct($expected, $actual, Position $position)
    {
        $message = $this->buildMessage($expected, $actual);
        parent::__construct($message, $position);
    }

    private function buildMessage($expected, $actual)
    {
        $expected = "Expected token to be '$expected', but got";
        $got = $actual ?: '<end of stream>';

        return "$expected '$got' instead";
    }
}