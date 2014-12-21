<?php

use Fun\Lexing\Lexer;
use Fun\Lexing\TokenDefinition;
use Fun\Lexing\TokenType;
use Fun\Lexing\Token;
use Fun\Lexing\UnknownTokenException;

class LexerTest extends PHPUnit_Framework_TestCase
{
    private $lexer;

    public function setUp()
    {
        $lexer = new Lexer();

        $lexer->add(new TokenDefinition('/\d+/', TokenType::Number));
        $lexer->add(new TokenDefinition('/\+/', TokenType::Operator));

        $this->lexer = $lexer;
    }

    public function testCanTokenizeNumber()
    {
        $tokens = $this->lexer->tokenize('325');

        $this->assertTokenEquals('325', TokenType::Number, $tokens[0]);
    }

    public function testCanTokenizeOperator()
    {
        $tokens = $this->lexer->tokenize('+');

        $t = $tokens[0];
        $this->assertTokenEquals('+', TokenType::Operator, $t);
    }

    public function testCanTokenizeNumbersAndOperators()
    {
        $tokens = $this->lexer->tokenize('3+5');

        $this->assertCount(3, $tokens);

        $this->assertTokenEquals('3', TokenType::Number, $tokens[0]);
        $this->assertTokenEquals('+', TokenType::Operator, $tokens[1]);
        $this->assertTokenEquals('5', TokenType::Number, $tokens[2]);
    }

    public function testExceptionIsThrownOnUnknownToken()
    {
        $this->setExpectedException(UnknownTokenException::class);

        $this->lexer->tokenize('abc');
    }

    private function assertTokenEquals($value, $type, Token $token)
    {
        $this->assertEquals($value, $token->getValue());
        $this->assertEquals($type, $token->getType());
    }
}