<?php namespace Fun\Interpreting;

use Exception;
use Fun\Interpreting\Visitors\Visitor;
use Fun\Parsing\Nodes\ExpressionListNode;
use Fun\Parsing\Nodes\Node;
use Fun\Parsing\Nodes\OperationNode;
use Fun\Parsing\Nodes\NumberNode;
use Fun\Parsing\Nodes\VariableAssignmentNode;
use Fun\Parsing\Nodes\VariableNode;

class Interpreter implements Visitor
{
    private $context;

    public function run(Node $rootNode)
    {
        $this->context = [];

        return $rootNode->accept($this);
    }

    public function visitExpressionListNode(ExpressionListNode $node)
    {
        $result = null;

        foreach ($node->getExpressions() as $expr) {
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

            default:
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
    }

    public function visitVariableNode(VariableNode $node)
    {
        $variableName = $node->getName();

        if (!array_key_exists($variableName, $this->context))
            throw new Exception('Undefined variable: ' . $variableName);

        return $this->context[$variableName];
    }
}