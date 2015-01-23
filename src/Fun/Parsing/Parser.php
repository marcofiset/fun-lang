<?php namespace Fun\Parsing;

use Exception;
use Fun\Lexing\Token;
use Fun\Lexing\TokenType;
use Fun\Parsing\Nodes\OperationNode;
use Fun\Parsing\Nodes\NumberNode;

class Parser
{
    private $tokens;

    public function parse(array $tokens)
    {
        $tokens = $this->filterTokens($tokens);
        $this->tokens = $tokens;

        return $this->parseExpressionNode();
    }

    private function filterTokens(array $tokens)
    {
        return array_filter($tokens, function(Token $t) {
            return $t->getType() !== TokenType::Whitespace;
        });
    }

    private function parseExpressionNode()
    {
        $left = $this->parseNumberNode();

        if ($this->isEmpty())
            return new OperationNode($left);

        $operatorToken = $this->expectTokenType(TokenType::Operator);
        $right = $this->parseNumberNode();

        return new OperationNode($left, $operatorToken->getValue(), $right);
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
        $peek = $this->tokens[0];

        if ($peek->getType() !== $tokenType)
            throw new Exception('Unexpected token type.');

        return array_shift($this->tokens);
    }

    private function isEmpty()
    {
        return count($this->tokens) === 0;
    }
}