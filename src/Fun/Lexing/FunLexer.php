<?php namespace Fun\Lexing;

use Fun\Lexing\Tokens\TokenDefinition;
use Fun\Lexing\Tokens\TokenType;

class FunLexer extends Lexer
{
    public function __construct()
    {
        $this->addTokenDefinition('/\s+/', TokenType::Whitespace);
        $this->addTokenDefinition('/\d+/', TokenType::Number);
        $this->addTokenDefinition('/[+\-*\/%]/', TokenType::Operator);
        $this->addTokenDefinition('/[_a-zA-Z][_a-zA-Z0-9]*/', TokenType::Identifier);
        $this->addTokenDefinition('/=/', TokenType::AssignmentOperator);
        $this->addTokenDefinition('/;/', TokenType::Terminator);
        $this->addTokenDefinition('/==|!=|<=|>=|<|>/', TokenType::ConditionalOperator);
        $this->addTokenDefinition('/\{|\}|\(|\)/', TokenType::Symbol);
    }

    private function addTokenDefinition($pattern, $type)
    {
        $this->add(new TokenDefinition($pattern, $type));
    }
}