<?php namespace Fun\Parsing\Nodes;

use Fun\Interpreting\Visitors\Visitor;

class InstructionListNode extends Node
{
    private $instructions;

    /**
     * @param Node[] $instructions
     */
    public function __construct(array $instructions)
    {
        $this->instructions = $instructions;
    }

    /**
     * @return Node[]
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    public function accept(Visitor $visitor)
    {
        return $visitor->visitInstructionListNode($this);
    }
}