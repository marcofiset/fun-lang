<?php namespace Fun\Lexing\Tokens;

final class TokenType
{
    const Number = 'T_NUMBER';
    const Operator = 'T_OPERATOR';
    const Whitespace = 'T_WHITESPACE';
    const Identifier = 'T_IDENTIFIER';
    const AssignmentOperator = 'T_ASSIGNMENT_OPERATOR';
    const Terminator = 'T_TERMINATOR';
    const NewLine = 'T_NEWLINE';
    const ConditionalOperator = 'T_CONDITIONAL_OPERATOR';
    const Symbol = 'T_SYMBOL';
}