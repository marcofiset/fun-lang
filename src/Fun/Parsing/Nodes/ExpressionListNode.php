<?php namespace Fun\Parsing\Nodes;

use Fun\Interpreting\Visitors\Visitor;

class ExpressionListNode extends Node
{
    private $expressions;

    /**
     * @param OperationNode[] $expressions
     */
    public function __construct(array $expressions)
    {
        $this->expressions = $expressions;
    }

    /**
     * @return OperationNode[]
     */
    public function getExpressions()
    {
        return $this->expressions;
    }

    public function accept(Visitor $visitor)
    {
        return $visitor->visitExpressionListNode($this);
    }
}