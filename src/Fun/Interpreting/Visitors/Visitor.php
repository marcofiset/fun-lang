<?php namespace Fun\Interpreting\Visitors;

use Fun\Parsing\Nodes\ExpressionListNode;
use Fun\Parsing\Nodes\OperationNode;
use Fun\Parsing\Nodes\NumberNode;
use Fun\Parsing\Nodes\VariableAssignmentNode;
use Fun\Parsing\Nodes\VariableNode;

interface Visitor
{
    function visitExpressionListNode(ExpressionListNode $node);
    function visitOperationNode(OperationNode $node);
    function visitNumberNode(NumberNode $node);
    function visitVariableNode(VariableNode $node);
    function visitVariableAssignmentNode(VariableAssignmentNode $node);
}