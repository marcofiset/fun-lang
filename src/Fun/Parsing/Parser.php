<?php namespace Fun\Parsing;

use Exception;
use Fun\Lexing\Token;
use Fun\Lexing\TokenType;
use Fun\Parsing\Nodes\ExpressionNode;
use Fun\Parsing\Nodes\NumberNode;

class Parser
{
    private $tokens;

    public function parse($tokens)
    {
        $this->tokens = $tokens;

        return $this->parseExpressionNode();
    }

    private function parseExpressionNode()
    {
        $left = $this->parseNumberNode();

//        if ($this->isEmpty())
            return new ExpressionNode($left);

//        $operatorToken = $this->expectTokenType(TokenType::Operator);
//        $right = $this->parseNumberNode();
//
//        return new ExpressionNode($left, $operatorToken->getValue(), $right);
    }

    private function parseNumberNode()
    {
        $numberToken = $this->expectTokenType(TokenType::Number);

        return new NumberNode($numberToken->getValue());
    }

    /**
     * @param $tokenType
     * @return Token
     * @throws Exception
     */
    private function expectTokenType($tokenType)
    {
//        if ($this->isEmpty())
//            throw new Exception('Expected a token, but stream is empty.');

        $peek = $this->tokens[0];

        if ($peek->getType() !== $tokenType)
            throw new Exception('Unexpected token type.');

        return array_shift($this->tokens);
    }

//    private function isEmpty()
//    {
//        return count($this->tokens) === 0;
//    }
}