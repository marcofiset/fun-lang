<?php

use Fun\Exceptions\UnexpectedTokenTypeException;
use Fun\Lexing\Tokens\Token;
use Fun\Lexing\Tokens\TokenStream;
use Fun\Lexing\Tokens\TokenType;

class TokenStreamTest extends PHPUnit_Framework_TestCase
{
    /** @var TokenStream */
    private $tokenStream;

    public function setUp()
    {
        $this->tokenStream = new TokenStream();
    }

    public function testAddTokenToStream()
    {
        $this->tokenStream->addToken(new Token('3', TokenType::Number));

        $this->assertCount(1, $this->tokenStream);
    }

    public function testIsEmpty()
    {
        $this->assertTrue($this->tokenStream->isEmpty());
    }

    public function testCurrentTokenIsNullWhenEmpty()
    {
        $this->assertNull($this->tokenStream->currentToken());
    }

    public function testCurrentTokenIsFirstOfStream()
    {
        $firstToken = new Token('3', TokenType::Number);
        $this->tokenStream->addToken($firstToken);
        $this->tokenStream->addToken(new Token('+', TokenType::Operator));

        $this->assertEquals($firstToken, $this->tokenStream->currentToken());
    }

    public function testLookAheadOnEmptyStreamReturnsNull()
    {
        $this->assertNull($this->tokenStream->lookAhead());
    }

    public function testLookAheadPastEndOfStreamReturnsNull()
    {
        $this->tokenStream->addToken(new Token('3', TokenType::Operator));

        $this->assertNull($this->tokenStream->lookAhead(2));
    }

    public function testLookAhead()
    {
        $this->tokenStream->addToken(new Token('3', TokenType::Number));

        $secondToken = new Token('+', TokenType::Operator);
        $thirdToken = new TokenType('5', TokenType::Number);

        $this->tokenStream->addToken($secondToken);
        $this->tokenStream->addToken($thirdToken);

        $this->assertEquals($secondToken, $this->tokenStream->lookAhead());
        $this->assertEquals($thirdToken, $this->tokenStream->lookAhead(2));
    }

    public function testConsumeToken()
    {
        $firstToken = new Token('3', TokenType::Number);
        $secondToken = new Token('+', TokenType::Operator);

        $this->tokenStream->addToken($firstToken);
        $this->tokenStream->addToken($secondToken);

        $this->assertEquals($firstToken, $this->tokenStream->consumeToken());
        $this->assertEquals($secondToken, $this->tokenStream->consumeToken());
    }

    public function testExpectTokenType()
    {
        $token = new Token('3', TokenType::Number);
        $this->tokenStream->addToken($token);

        $this->assertEquals($token, $this->tokenStream->expectTokenType(TokenType::Number));
    }

    public function testExpectTokenOfWrongTypeThrowsException()
    {
        $this->setExpectedException(UnexpectedTokenTypeException::class);

        $this->tokenStream->addToken(new Token('3', TokenType::Number));
        $this->tokenStream->expectTokenType(TokenType::Identifier);
    }
}