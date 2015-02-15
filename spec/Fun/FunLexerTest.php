<?php

use Fun\Lexing\Exceptions\UnknownTokenException;
use Fun\Lexing\FunLexer;
use Fun\Lexing\Tokens\Token;
use Fun\Lexing\Tokens\TokenType;

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

        $this->assertTokenEquals('3', TokenType::Number, $tokens[0]);
        $this->assertTokenEquals('+', TokenType::Operator, $tokens[1]);
        $this->assertTokenEquals('5', TokenType::Number, $tokens[2]);
    }

    public function testCanTokenizeWhitespaces()
    {
        $tokens = $this->lexer->tokenize('        ');

        $token = $tokens[0];
        $this->assertEmpty(trim($token->getValue()));
        $this->assertEquals(TokenType::Whitespace, $token->getType());
    }

    public function testCanTokenizeNewLines()
    {
        $tokens = $this->lexer->tokenize('
        ');

        $this->assertEquals(TokenType::NewLine, $tokens[0]->getType());
    }

    public function testCanTokenizeIdentifiers()
    {
        $tokens = $this->lexer->tokenize('_aBc A1_23 foO_');

        $this->assertTokenEquals('_aBc', TokenType::Identifier, $tokens[0]);
        $this->assertTokenEquals('A1_23', TokenType::Identifier, $tokens[2]);
        $this->assertTokenEquals('foO_', TokenType::Identifier, $tokens[4]);
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

    public function testTokensHavePositionInformation()
    {
        $tokens = $this->lexer->tokenize('123 456');

        $this->assertTokenPosition($tokens[0], 1, 1);
        $this->assertTokenPosition($tokens[1], 1, 4);
        $this->assertTokenPosition($tokens[2], 1, 5);
    }

    public function testNewLinesArePreservedAsTokens()
    {
        $tokens = $this->lexer->tokenize("123\n456");

        $this->assertTokenEquals("\n", TokenType::NewLine, $tokens[1]);
    }

    public function testTokensHavePositionInformationMultiLine()
    {
        $tokens = $this->lexer->tokenize("123\n456");

        $this->assertTokenPosition($tokens[0], 1, 1);
        $this->assertTokenPosition($tokens[2], 2, 1);
    }

    private function assertTokenEquals($value, $type, Token $token)
    {
        $this->assertEquals($value, $token->getValue());
        $this->assertEquals($type, $token->getType());
    }

    private function assertTokenPosition(Token $token, $line, $column)
    {
        $this->assertEquals($line, $token->getLine());
        $this->assertEquals($column, $token->getColumn());
    }
}