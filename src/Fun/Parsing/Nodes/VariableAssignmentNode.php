<?php namespace Fun\Parsing\Nodes;

use Fun\Interpreting\Visitors\Visitor;

class VariableAssignmentNode extends Node
{
    private $variableName;
    private $operation;

    public function __construct($variableName, OperationNode $operation)
    {
        $this->variableName = $variableName;
        $this->operation = $operation;
    }

    public function getVariableName()
    {
        return $this->variableName;
    }

    /**
     * @return OperationNode
     */
    public function getOperation()
    {
        return $this->operation;
    }

    public function accept(Visitor $visitor)
    {
        return $visitor->visitVariableAssignmentNode($this);
    }
}