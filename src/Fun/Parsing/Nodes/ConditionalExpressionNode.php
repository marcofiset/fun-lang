<?php namespace Fun\Parsing\Nodes;

use Fun\Interpreting\Visitors\Visitor;

class ConditionalExpressionNode extends Node
{
    private $leftNode;
    private $conditionalOperator;
    private $rightNode;

    public function __construct(Node $leftNode, $conditionalOperator, Node $rightNode)
    {
        $this->leftNode = $leftNode;
        $this->conditionalOperator = $conditionalOperator;
        $this->rightNode = $rightNode;
    }

    /**
     * @return Node
     */
    public function getLeftNode()
    {
        return $this->leftNode;
    }

    public function getConditionalOperator()
    {
        return $this->conditionalOperator;
    }

    /**
     * @return Node
     */
    public function getRightNode()
    {
        return $this->rightNode;
    }

    public function accept(Visitor $visitor)
    {
        return $visitor->visitConditionalExpressionNode($this);
    }
}