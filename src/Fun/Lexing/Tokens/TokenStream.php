<?php namespace Fun\Lexing\Tokens;

use Fun\Exceptions\UnexpectedTokenTypeException;
use Fun\PositionInformation;

class TokenStream implements \Countable
{
    /** @var Token[] */
    private $tokens;

    /** @var Token */
    private $lastConsumedToken;

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
        return $this->lastConsumedToken = array_shift($this->tokens);
    }

    /**
     * Gets the last consumed token, or null if nothing has been consumed yet.
     *
     * @return Token
     */
    public function lastConsumedToken()
    {
        return $this->lastConsumedToken;
    }

    /**
     * Expects the current token to be of a particular type.
     *
     * @param $type
     * @return Token
     * @throws UnexpectedTokenTypeException
     */
    public function expectTokenType($type)
    {
        $token = $this->currentToken();

        if (!$token || $token->getType() !== $type)
            $this->throwUnexpectedTokenType($type, $token);

        return $this->consumeToken();
    }

    /**
     * @param $type
     * @param $token
     * @throws UnexpectedTokenTypeException
     */
    private function throwUnexpectedTokenType($type, $token)
    {
        throw new UnexpectedTokenTypeException($type, $token, $this->currentTokenPosition());
    }

    /**
     * Returns the position of the current token
     *
     * @return PositionInformation
     */
    public function currentTokenPosition()
    {
        if ($this->isEmpty())
            return new PositionInformation(0, 0);

        return $this->currentToken()->getPosition();
    }
}