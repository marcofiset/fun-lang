<?php

use Fun\Lexing\Tokens\Token;
use Fun\Lexing\Tokens\TokenType;
use Fun\Parsing\Parser;

class ParserTest extends PHPUnit_Framework_TestCase
{
    public function testCanParseSingleNumberExpression()
    {
        $tokens = [
            new Token('3', TokenType::Number),
            new Token(';', TokenType::Terminator)
        ];

        $node = $this->parse($tokens);

        $this->assertInstanceOf('Fun\Parsing\Nodes\ExpressionListNode', $node);

        $expr = $node->getExpressions()[0];
        $this->assertNumberNode($expr->getLeft(), 3);
    }

    public function testCanParseBinaryExpression()
    {
        $tokens = [
            new Token('3', TokenType::Number),
            new Token('+', TokenType::Operator),
            new Token('5', TokenType::Number),
            new Token(';', TokenType::Terminator)
        ];

        $node = $this->parse($tokens);

        $this->assertInstanceOf('Fun\Parsing\Nodes\ExpressionListNode', $node);

        $expr = $node->getExpressions()[0];

        $this->assertNumberNode($expr->getLeft(), 3);
        $this->assertEquals('+', $expr->getOperator());
        $this->assertNumberNode($expr->getRight(), 5);
    }

    public function testNodesHaveLineInformation()
    {
        $token = new Token('3', TokenType::Number);
        $terminator = new Token(';', TokenType::Terminator);

        $expressionListNode = $this->parse([$token, $terminator]);
        $expressionNode = $expressionListNode->getExpressions()[0];
        $numberNode = $expressionNode->getLeft();

        $this->assertEquals(1, $expressionListNode->getPosition()->getLine());
        $this->assertEquals(1, $expressionNode->getPosition()->getLine());
        $this->assertEquals(1, $numberNode->getPosition()->getLine());
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