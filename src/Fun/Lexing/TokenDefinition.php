<?php namespace Fun\Lexing;

class TokenDefinition
{
    private $pattern;
    private $tokenType;

    public function __construct($pattern, $tokenType)
    {
        $this->pattern = $pattern;
        $this->tokenType = $tokenType;
    }

    public function match($input)
    {
        $result = preg_match($this->pattern, $input, $matches, PREG_OFFSET_CAPTURE);

        // preg_match returns false if an error occured
        if ($result === false)
            throw new \Exception(preg_last_error());

        if ($result === 0)
            return null;

        return $this->getTokenFromMatch($matches[0]);
    }

    private function getTokenFromMatch($match)
    {
        $value = $match[0];
        $offset = $match[1];

        if ($offset !== 0)
            return null;

        return new Token($value, $this->tokenType);
    }
}