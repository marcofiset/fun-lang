<?php namespace Fun\Interpreting\Visitors;

interface Visitable
{
    function accept(Visitor $visitor);
}