<?php

use Fun\Lexing\Token;
use Fun\Lexing\TokenType;
use Fun\Parsing\Parser;

class ParserTest extends PHPUnit_Framework_TestCase
{
    public function testCanParseSingleNumberExpression()
    {
        $tokens = [
            new Token('3', TokenType::Number)
        ];

        $node = $this->parse($tokens);

        $this->assertInstanceOf('Fun\Parsing\Nodes\ExpressionNode', $node);
        $this->assertNumberNode($node->getLeft(), 3);
    }

    public function testCanParseBinaryExpression()
    {
        $tokens = [
            new Token('3', TokenType::Number),
            new Token('+', TokenType::Operator),
            new Token('5', TokenType::Number)
        ];

        $node = $this->parse($tokens);

        $this->assertInstanceOf('Fun\Parsing\Nodes\ExpressionNode', $node);

        $this->assertNumberNode($node->getLeft(), 3);
        $this->assertEquals('+', $node->getOperator());
        $this->assertNumberNode($node->getRight(), 5);
    }

    private function parse($tokens)
    {
        $parser = new Parser();
        return $parser->parse($tokens);
    }

    private function assertNumberNode($node, $value)
    {
        $this->assertInstanceOf('Fun\Parsing\Nodes\NumberNode', $node);
        $this->assertEquals($value, $node->getValue());
    }
}