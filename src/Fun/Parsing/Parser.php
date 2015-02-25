<?php namespace Fun\Parsing;

use Exception;
use Fun\Lexing\Tokens\Token;
use Fun\Lexing\Tokens\TokenStream;
use Fun\Lexing\Tokens\TokenType;
use Fun\Parsing\Nodes\BlockNode;
use Fun\Parsing\Nodes\ConditionalExpressionNode;
use Fun\Parsing\Nodes\IfStatementNode;
use Fun\Parsing\Nodes\InstructionListNode;
use Fun\Parsing\Nodes\NumberNode;
use Fun\Parsing\Nodes\OperationNode;
use Fun\Parsing\Nodes\VariableAssignmentNode;
use Fun\Parsing\Nodes\VariableNode;
use Fun\Parsing\Nodes\WhileStatementNode;

class Parser
{
    /** @var  TokenStream */
    private $tokenStream;

    /**
     * @param Token[] $tokens
     * @return InstructionListNode The root node of the parsed AST
     */
    public function parse(array $tokens)
    {
        $tokens = $this->filterTokens($tokens);
        $this->tokenStream = new TokenStream($tokens);

        return $this->parseInstructionListNode(function() {
            return $this->tokenStream->isEmpty();
        });
    }

    private function filterTokens(array $tokens)
    {
        $filteredTokens = array_filter($tokens, function (Token $t) {
            return $t->getType() !== TokenType::Whitespace;
        });

        return array_values($filteredTokens);
    }

    // InstructionList = (Instruction)+
    private function parseInstructionListNode(callable $terminationCondition)
    {
        $instructions = [];

        while (!$terminationCondition()) {
            $instr = $this->parseInstruction();
            $instructions[] = $instr;
        }

        return new InstructionListNode($instructions);
    }

    // Instruction = (Expression Terminator) | Statement
    private function parseInstruction()
    {
        $currentTokenValue = $this->tokenStream->currentToken()->getValue();

        if (in_array($currentTokenValue, ['if', 'while']))
            return $this->parseStatement();

        $expr = $this->parseExpressionNode();
        $this->tokenStream->expectTokenType(TokenType::Terminator);

        return $expr;
    }

    // Statement = IfStatement | WhileStatement
    private function parseStatement()
    {
        $token = $this->tokenStream->currentToken();

        switch ($token->getValue()) {
            case 'if':
                return $this->parseIfStatement();

            case 'while':
                return $this->parseWhileStatement();

            default:
                throw new Exception('Expected if or while');
        }
    }

    private function parseIfStatement()
    {
        return $this->parseConditionalStatementNode('if', IfStatementNode::class);
    }

    private function parseWhileStatement()
    {
        return $this->parseConditionalStatementNode('while', WhileStatementNode::class);
    }

    private function parseConditionalStatementNode($keyword, $nodeClass)
    {
        $this->tokenStream->expectTokenValue($keyword);
        $this->tokenStream->expectTokenValue('(');

        $condition = $this->parseConditionalExpressionNode();

        $this->tokenStream->expectTokenValue(')');

        $body = $this->parseBlockNode();

        return new $nodeClass($condition, $body);
    }

    private function parseConditionalExpressionNode()
    {
        $leftNode = $this->parseExpressionNode();
        $operator = $this->tokenStream->expectTokenType(TokenType::ConditionalOperator);
        $rightNode = $this->parseExpressionNode();

        return new ConditionalExpressionNode($leftNode, $operator, $rightNode);
    }

    private function parseBlockNode()
    {
        $this->tokenStream->expectTokenValue('{');

        $instructions = $this->parseInstructionListNode(function() {
            $currentToken = $this->tokenStream->currentToken();

            // Stop parsing instructions once we get to the closing brace
            return $currentToken && $currentToken->getValue() === '}';
        });

        $this->tokenStream->expectTokenValue('}');

        return new BlockNode($instructions);
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