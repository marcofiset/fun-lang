<?php namespace Fun\Parsing\Nodes;

use Fun\Interpreting\Visitors\Visitor;

class VariableNode extends Node
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function accept(Visitor $visitor)
    {
        return $visitor->visitVariableNode($this);
    }
}