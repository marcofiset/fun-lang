<?php

use Fun\Lexing\FunLexer;
use Fun\Lexing\Token;
use Fun\Lexing\TokenType;
use Fun\Lexing\UnknownTokenException;

class FunLexerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var FunLexer
     */
    private $lexer;

    public function setUp()
    {
        $lexer = new FunLexer();

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

    public function testCanTokenizeWhitespaces()
    {
        $tokens = $this->lexer->tokenize('

        ');

        $this->assertEmpty(trim($tokens[0]->getValue()));
    }

    public function testCanTokenizeIdentifiers()
    {
        $tokens = $this->lexer->tokenize('_abc a123 foo');

        $this->assertTokenEquals('_abc', TokenType::Identifier, $tokens[0]);
        $this->assertTokenEquals('a123', TokenType::Identifier, $tokens[2]);
        $this->assertTokenEquals('foo', TokenType::Identifier, $tokens[4]);
    }

    public function testCanTokenizeTerminator()
    {
        $tokens = $this->lexer->tokenize(';');

        $this->assertTokenEquals(';', TokenType::Terminator, $tokens[0]);
    }

    public function testExceptionIsThrownOnUnknownToken()
    {
        $this->setExpectedException(UnknownTokenException::class);

        $this->lexer->tokenize('$');
    }

    private function assertTokenEquals($value, $type, Token $token)
    {
        $this->assertEquals($value, $token->getValue());
        $this->assertEquals($type, $token->getType());
    }
}