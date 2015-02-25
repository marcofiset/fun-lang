<?php namespace Fun\Lexing\Tokens;

final class TokenType
{
    const Number = 1;
    const Operator = 2;
    const Whitespace = 3;
    const Identifier = 4;
    const AssignmentOperator = 5;
    const Terminator = 6;
    const NewLine = 7;
    const ConditionalOperator = 8;
    const Symbol = 9;
}