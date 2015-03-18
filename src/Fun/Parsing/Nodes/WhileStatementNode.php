<?php namespace Fun\Parsing\Nodes;

use Fun\Interpreting\Visitors\Visitor;

class WhileStatementNode extends ConditionalStatementNode
{
    public function accept(Visitor $visitor)
    {
        return $visitor->visitWhileStatementNode($this);
    }
}