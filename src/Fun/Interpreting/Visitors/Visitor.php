<?php namespace Fun\Interpreting\Visitors;

use Fun\Parsing\Nodes\ExpressionNode;
use Fun\Parsing\Nodes\NumberNode;

interface Visitor
{
    function visitExpressionNode(ExpressionNode $node);
    function visitNumberNode(NumberNode $node);
}