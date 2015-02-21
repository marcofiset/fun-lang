<?php namespace Fun\Parsing\Nodes;

abstract class ConditionalStatementNode extends Node
{
    private $condition;
    private $body;

    public function __construct(ConditionalExpressionNode $condition, BlockNode $body)
    {
        $this->condition = $condition;
        $this->body = $body;
    }

    /**
     * @return ConditionalExpressionNode
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return BlockNode
     */
    public function getBody()
    {
        return $this->body;
    }
}