<?php namespace Fun\Lexing\Tokens;

use Fun\Exceptions\UnexpectedTokenTypeException;

class TokenStream implements \Countable
{
    /** @var Token[] */
    private $tokens;

    public function __construct(array $tokens = [])
    {
        $this->tokens = $tokens;
    }

    public function addToken($token)
    {
        $this->tokens[] = $token;
    }

    public function currentToken()
    {
        if ($this->isEmpty())
            return null;

        return $this->tokens[0];
    }

    public function isEmpty()
    {
        return count($this->tokens) === 0;
    }

    public function count()
    {
        return count($this->tokens);
    }

    public function lookAhead($position = 1)
    {
        if ($position >= count($this->tokens))
            return null;

        return $this->tokens[$position];
    }

    public function consumeToken()
    {
        return array_shift($this->tokens);
    }

    public function expectTokenType($type)
    {
        $token = $this->currentToken();

        if (!$token || $token->getType() !== $type)
            throw new UnexpectedTokenTypeException($type, $token);

        return $this->consumeToken();
    }
}