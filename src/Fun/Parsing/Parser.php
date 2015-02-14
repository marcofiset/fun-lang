<?php namespace Fun\Parsing;

use Exception;
use Fun\Lexing\Tokens\Token;
use Fun\Lexing\Tokens\TokenStream;
use Fun\Lexing\Tokens\TokenType;
use Fun\Parsing\Nodes\ExpressionListNode;
use Fun\Parsing\Nodes\NumberNode;
use Fun\Parsing\Nodes\OperationNode;
use Fun\Parsing\Nodes\VariableAssignmentNode;
use Fun\Parsing\Nodes\VariableNode;

class Parser
{
    /** @var  TokenStream */
    private $tokenStream;

    /**
     * @param Token[] $tokens
     * @return ExpressionListNode The root node of the parsed AST
     */
    public function parse(array $tokens)
    {
        $tokens = $this->filterTokens($tokens);
        $this->tokenStream = new TokenStream($tokens);

        return $this->parseExpressionListNode();
    }

    private function filterTokens(array $tokens)
    {
        $filteredTokens = array_filter($tokens, function (Token $t) {
            return $t->getType() !== TokenType::Whitespace;
        });

        return array_values($filteredTokens);
    }

    // ExpressionList = (Expression Terminator)+
    private function parseExpressionListNode()
    {
        $expressions = [];

        while (!$this->tokenStream->isEmpty()) {
            $expr = $this->parseExpressionNode();
            $this->tokenStream->expectTokenType(TokenType::Terminator);

            $expressions[] = $expr;
        }

        return new ExpressionListNode($expressions);
    }

    // Expression = Assignment | Operation
    private function parseExpressionNode()
    {
        $nextToken = $this->tokenStream->lookAhead();

        if ($nextToken->getType() === TokenType::AssignmentOperator)
            return $this->parseVariableAssignmentNode();

        return $this->parseOperationNode();
    }

    // Assignment = Identifier AssignmentOperator Operation
    private function parseVariableAssignmentNode()
    {
        $identifier = $this->tokenStream->expectTokenType(TokenType::Identifier);
        $this->tokenStream->expectTokenType(TokenType::AssignmentOperator);

        $operation = $this->parseOperationNode();

        return new VariableAssignmentNode($identifier->getValue(), $operation);
    }

    // Operation = Term (Operator Term)?
    private function parseOperationNode()
    {
        $left = $this->parseTerm();
        $token = $this->tokenStream->currentToken();

        if ($token->getType() === TokenType::Terminator)
            return new OperationNode($left);

        $operatorToken = $this->tokenStream->expectTokenType(TokenType::Operator);
        $right = $this->parseTerm();

        return new OperationNode($left, $operatorToken->getValue(), $right);
    }

    // Term = Idenfitier | Number
    private function parseTerm()
    {
        $currentToken = $this->tokenStream->consumeToken();

        switch ($currentToken->getType()) {
            case TokenType::Identifier:
                return new VariableNode($currentToken->getValue());

            case TokenType::Number:
                return new NumberNode($currentToken->getValue());

            default:
                throw new Exception('Expected current token to be a Number or an Identifier.');
        }
    }
}