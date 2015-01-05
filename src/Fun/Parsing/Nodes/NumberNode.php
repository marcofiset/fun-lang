<?php namespace Fun\Parsing\Nodes;

class NumberNode
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
}