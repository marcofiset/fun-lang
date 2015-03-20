<?php namespace Fun\Lexing\Tokens;

use Fun\Position;

class Token
{
    private $value;
    private $type;

    /** @var Position */
    private $position;

    public function __construct($value, $type)
    {
        $this->value = $value;
        $this->type = $type;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * The position of the token in the source file
     *
     * @return Position
     */
    public function getPosition()
    {
        return $this->position ?: new Position(0, 0);
    }

    /**
     * Sets the position of the token
     *
     * @param $line
     * @param $column
     */
    public function setPosition($line, $column)
    {
        $this->position = new Position($line, $column);
    }
}