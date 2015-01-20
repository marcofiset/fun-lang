<?php namespace Fun\Interpreting;

use Exception;
use Fun\Interpreting\Visitors\Visitor;
use Fun\Parsing\Nodes\ExpressionNode;
use Fun\Parsing\Nodes\NumberNode;

class Interpreter implements Visitor
{
    public function visitExpressionNode(ExpressionNode $node)
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
}