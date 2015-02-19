<?php namespace Fun;

class PositionInformation
{
    private $line;
    private $column;

    public function __construct($line, $column)
    {
        $this->line = $line;
        $this->column = $column;
    }

    public function getLine()
    {
        return $this->line;
    }

    public function getColumn()
    {
        return $this->column;
    }
}