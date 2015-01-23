<?php namespace Fun\Parsing\Nodes;

use Fun\Interpreting\Visitors\Visitor;

class OperationNode extends Node
{
    private $left;
    private $operator;
    private $right;

    function __construct(Node $left, $operator = null, Node $right = null)
    {
        $this->left = $left;
        $this->operator = $operator;
        $this->right = $right;
    }

    /**
     * @return Node
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @return Node
     */
    public function getRight()
    {
        return $this->right;
    }

    public function accept(Visitor $visitor)
    {
        return $visitor->visitOperationNode($this);
    }
}