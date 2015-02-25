<?php namespace Fun\Parsing\Nodes;

use Fun\Interpreting\Visitors\Visitor;

class BlockNode extends Node
{
    private $instructionListNode;

    public function __construct(InstructionListNode $instructionListNode)
    {
        $this->instructionListNode = $instructionListNode;
    }

    /**
     * @return InstructionListNode
     */
    public function getInstructionListNode()
    {
        return $this->instructionListNode;
    }

    public function accept(Visitor $visitor)
    {
        return $visitor->visitBlockNode($this);
    }
}