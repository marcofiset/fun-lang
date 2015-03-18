<?php namespace Fun\Interpreting;

use Exception;
use Fun\Interpreting\Visitors\Visitor;
use Fun\Parsing\Nodes\BlockNode;
use Fun\Parsing\Nodes\ConditionalExpressionNode;
use Fun\Parsing\Nodes\ConditionalStatementNode;
use Fun\Parsing\Nodes\InstructionListNode;
use Fun\Parsing\Nodes\Node;
use Fun\Parsing\Nodes\OperationNode;
use Fun\Parsing\Nodes\NumberNode;
use Fun\Parsing\Nodes\VariableAssignmentNode;
use Fun\Parsing\Nodes\VariableNode;
use Fun\Parsing\Nodes\WhileStatementNode;

class Interpreter implements Visitor
{
    private $context;

    /**
     * @param Node $rootNode The root node of the AST at which to start interpreting
     * @return mixed The result of the interpretation
     */
    public function run(Node $rootNode)
    {
        $this->context = [];

        return $rootNode->accept($this);
    }

    public function visitInstructionListNode(InstructionListNode $node)
    {
        $result = null;

        foreach ($node->getInstructions() as $expr) {
            $result = $expr->accept($this);
        }

        return $result;
    }

    public function visitOperationNode(OperationNode $node)
    {
        $leftValue = $node->getLeft()->accept($this);
        $operator = $node->getOperator();

        // The operator and the right side are optional, remember?
        if (!$operator)
            return $leftValue;

        $rightValue = $node->getRight()->accept($this);

        return $this->performOperation($leftValue, $operator, $rightValue);
    }

    private function performOperation($leftValue, $operator, $rightValue)
    {
        // Perform the right operation based on the operator
        switch ($operator) {
            case '+':
                return $leftValue + $rightValue;

            case '-':
                return $leftValue - $rightValue;

            case '*':
                return $leftValue * $rightValue;

            case '/':
                if ($rightValue == 0)
                    throw new Exception('Cannot divide by zero');

                return $leftValue / $rightValue;

            case '%':
                return $leftValue % $rightValue;

            default:
                // This should not happen, as it's the Lexer's job to identify supported operators
                throw new Exception('Unsupported operator: ' . $operator);
        }
    }

    public function visitNumberNode(NumberNode $node)
    {
        return intval($node->getValue());
    }

    public function visitVariableAssignmentNode(VariableAssignmentNode $node)
    {
        $variableName = $node->getVariableName();
        $value = $node->getOperation()->accept($this);

        $this->context[$variableName] = $value;

        //Assignment operators return the assigned value;
        return $value;
    }

    public function visitVariableNode(VariableNode $node)
    {
        $variableName = $node->getName();

        if (!array_key_exists($variableName, $this->context))
            throw new Exception('Undefined variable: ' . $variableName);

        return $this->context[$variableName];
    }

    public function visitConditionalExpressionNode(ConditionalExpressionNode $node)
    {
        $leftValue = $node->getLeftNode()->accept($this);
        $rightValue = $node->getRightNode()->accept($this);

        switch ($node->getConditionalOperator()) {
            case '==':
                return $leftValue === $rightValue;

            case '!=':
                return $leftValue !== $rightValue;

            case '<=':
                return $leftValue <= $rightValue;

            case '>=':
                return $leftValue >= $rightValue;

            case '<';
                return $leftValue < $rightValue;

            case '>';
                return $leftValue > $rightValue;

            default:
                // This should not happen, it should instead fail in the Lexer first.
                throw new Exception('Unsupported conditional operator: ' . $node->getConditionalOperator());
        }
    }

    public function visitIfStatementNode(ConditionalStatementNode $node)
    {
        $conditionValue = $node->getCondition()->accept($this);

        if ($conditionValue)
            return $node->getBody()->accept($this);

        return null;
    }

    public function visitWhileStatementNode(WhileStatementNode $node)
    {
        $result = null;

        $condition = $node->getCondition();
        $body = $node->getBody();

        while ($condition->accept($this))
            $result = $body->accept($this);

        return $result;
    }

    public function visitBlockNode(BlockNode $node)
    {
        return $node->getInstructionListNode()->accept($this);
    }
}