<?php namespace Fun\Parsing;

use Exception;
use Fun\Lexing\Tokens\Token;
use Fun\Lexing\Tokens\TokenType;
use Fun\Parsing\Nodes\ExpressionListNode;
use Fun\Parsing\Nodes\NumberNode;
use Fun\Parsing\Nodes\OperationNode;
use Fun\Parsing\Nodes\VariableAssignmentNode;
use Fun\Parsing\Nodes\VariableNode;

class Parser
{
    /** @var  Token[] */
    private $tokens;

    /**
     * @param Token[] $tokens
     * @return ExpressionListNode The root node of the parsed AST
     */
    public function parse(array $tokens)
    {
        $tokens = $this->filterTokens($tokens);
        $this->tokens = $tokens;

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

        while (!$this->isEmpty()) {
            $expr = $this->parseExpressionNode();
            $this->expectTokenType(TokenType::Terminator);

            $expressions[] = $expr;
        }

        return new ExpressionListNode($expressions);
    }

    // Expression = Assignment | Operation
    private function parseExpressionNode()
    {
        $nextToken = $this->lookAhead();

        if ($nextToken->getType() === TokenType::AssignmentOperator)
            return $this->parseVariableAssignmentNode();

        return $this->parseOperationNode();
    }

    // Assignment = Identifier AssignmentOperator Operation
    private function parseVariableAssignmentNode()
    {
        $identifier = $this->expectTokenType(TokenType::Identifier);
        $this->expectTokenType(TokenType::AssignmentOperator);

        $operation = $this->parseOperationNode();

        return new VariableAssignmentNode($identifier->getValue(), $operation);
    }

    // Operation = Term (Operator Term)?
    private function parseOperationNode()
    {
        $left = $this->parseTerm();
        $token = $this->currentToken();

        if ($token->getType() === TokenType::Terminator)
            return new OperationNode($left);

        $operatorToken = $this->expectTokenType(TokenType::Operator);
        $right = $this->parseTerm();

        return new OperationNode($left, $operatorToken->getValue(), $right);
    }

    // Term = Idenfitier | Number
    private function parseTerm()
    {
        $currentToken = $this->consumeToken();

        switch ($currentToken->getType()) {
            case TokenType::Identifier:
                return new VariableNode($currentToken->getValue());

            case TokenType::Number:
                return new NumberNode($currentToken->getValue());

            default:
                throw new Exception('Expected current token to be a Number or an Identifier.');
        }
    }

    /**
     * @param $tokenType
     * @return Token
     * @throws Exception
     */
    private function expectTokenType($tokenType)
    {
        $peek = $this->currentToken();

        if (!$peek)
            throw new Exception('Unexpected end of stream');

        if ($peek->getType() !== $tokenType)
            throw new Exception('Unexpected token type.');

        return $this->consumeToken();
    }

    /**
     * @return Token
     */
    private function consumeToken()
    {
        return array_shift($this->tokens);
    }

    /**
     * @return Token
     */
    private function currentToken()
    {
        return $this->lookAhead(0);
    }

    /**
     * @param int $position
     * @return Token
     */
    private function lookAhead($position = 1)
    {
        if ($position >= count($this->tokens))
            return null;

        return $this->tokens[$position];
    }

    private function isEmpty()
    {
        return count($this->tokens) === 0;
    }
}