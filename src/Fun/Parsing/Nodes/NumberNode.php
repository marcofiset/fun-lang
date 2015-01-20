<?php namespace Fun\Parsing\Nodes;

use Fun\Interpreting\Visitors\Visitor;

class NumberNode extends Node
{
    private $value;

    function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public function accept(Visitor $visitor)
    {
        return $visitor->visitNumberNode($this);
    }
}