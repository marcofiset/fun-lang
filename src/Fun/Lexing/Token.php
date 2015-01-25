<?php namespace Fun\Lexing;

class Token
{
    private $value;
    private $type;
    private $line;
    private $column;

    public function __construct($value, $type)
    {
        $this->value = $value;
        $this->type = $type;
        $this->line = 0;
        $this->column = 0;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getLine()
    {
        return $this->line;
    }

    public function setLine($value)
    {
        $this->line = $value;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function setColumn($value)
    {
        $this->column = $value;
    }
}