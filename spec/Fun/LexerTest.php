<?php

use Fun\Lexing\Lexer;
use Fun\Lexing\Tokens\TokenDefinition;
use Fun\Lexing\Tokens\TokenType;

class LexerTest extends PHPUnit_Framework_TestCase
{
    /** @var Lexer */
    private $lexer;

    public function setUp()
    {
        $this->lexer = new Lexer();
    }

    public function testMultipleMatchingDefinitionsReturnLongestMatch()
    {
        $this->lexer->add(new TokenDefinition('/=/', TokenType::AssignmentOperator));
        $this->lexer->add(new TokenDefinition('/==/', TokenType::ConditionalOperator));
        $this->lexer->add(new TokenDefinition('/\s+/', TokenType::Whitespace));

        $tokens = $this->lexer->tokenize('== = ==');

        $this->assertEquals('==', $tokens[0]->getValue());
        $this->assertEquals('=', $tokens[2]->getValue());
        $this->assertEquals('==', $tokens[4]->getValue());
    }
}