<?php namespace Fun\Lexing;

final class TokenType
{
    const Number = 1;
    const Operator = 2;
    const Whitespace = 3;
    const Identifier = 4;
    const AssignmentOperator = 5;
    const Terminator = 6;
}