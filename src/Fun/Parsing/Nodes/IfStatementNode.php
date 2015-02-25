<?php namespace Fun\Parsing\Nodes;

use Fun\Interpreting\Visitors\Visitor;

class IfStatementNode extends ConditionalStatementNode
{
    public function accept(Visitor $visitor)
    {
        return $visitor->visitIfStatementNode($this);
    }
}