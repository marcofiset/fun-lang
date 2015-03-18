<?php namespace Fun\Interpreting\Visitors;

use Fun\Parsing\Nodes\BlockNode;
use Fun\Parsing\Nodes\ConditionalExpressionNode;
use Fun\Parsing\Nodes\ConditionalStatementNode;
use Fun\Parsing\Nodes\InstructionListNode;
use Fun\Parsing\Nodes\OperationNode;
use Fun\Parsing\Nodes\NumberNode;
use Fun\Parsing\Nodes\VariableAssignmentNode;
use Fun\Parsing\Nodes\VariableNode;
use Fun\Parsing\Nodes\WhileStatementNode;

interface Visitor
{
    function visitInstructionListNode(InstructionListNode $node);
    function visitOperationNode(OperationNode $node);
    function visitNumberNode(NumberNode $node);
    function visitVariableNode(VariableNode $node);
    function visitVariableAssignmentNode(VariableAssignmentNode $node);
    function visitConditionalExpressionNode(ConditionalExpressionNode $node);
    function visitBlockNode(BlockNode $node);
    function visitIfStatementNode(ConditionalStatementNode $node);
    function visitWhileStatementNode(WhileStatementNode $node);
}