<?php namespace Fun\Lexing\Tokens;

use Fun\PositionInformation;

class Token
{
    private $value;
    private $type;

    /** @var PositionInformation */
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
     * @return PositionInformation
     */
    public function getPosition()
    {
        return $this->position ?: new PositionInformation(0, 0);
    }

    /**
     * Sets the position of the token
     *
     * @param $line
     * @param $column
     */
    public function setPosition($line, $column)
    {
        $this->position = new PositionInformation($line, $column);
    }
}