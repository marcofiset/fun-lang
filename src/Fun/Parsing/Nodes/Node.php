<?php namespace Fun\Parsing\Nodes;

use Fun\Interpreting\Visitors\Visitable;
use Fun\PositionInformation;

abstract class Node implements Visitable
{
    /** @var PositionInformation */
    private $position;

    /**
     * Gets the position information in the source file that resulted in this particular node
     *
     * @return PositionInformation
     */
    public function getPosition()
    {
        return $this->position ?: new PositionInformation(0, 0);
    }

    /**
     * Sets the source file position of the node
     *
     * @param PositionInformation $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}