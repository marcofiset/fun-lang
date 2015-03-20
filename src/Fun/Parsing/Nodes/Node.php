<?php namespace Fun\Parsing\Nodes;

use Fun\Interpreting\Visitors\Visitable;
use Fun\Position;

abstract class Node implements Visitable
{
    /** @var Position */
    private $position;

    /**
     * Gets the position information in the source file that resulted in this particular node
     *
     * @return Position
     */
    public function getPosition()
    {
        return $this->position ?: new Position(0, 0);
    }

    /**
     * Sets the source file position of the node
     *
     * @param Position $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}