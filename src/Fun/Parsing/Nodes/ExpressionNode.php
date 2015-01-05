<?php namespace Fun\Parsing\Nodes;

class ExpressionNode
{
    private $left;
    private $operator;
    private $right;

    function __construct(NumberNode $left, $operator = null, NumberNode $right = null)
    {
        $this->left = $left;

        // $operator and $right are optional in case we have an expression consisting of a single NumberNode
        $this->operator = $operator;
        $this->right = $right;
    }

    /**
     * @return NumberNode
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @return NumberNode
     */
    public function getRight()
    {
        return $this->right;
    }
}