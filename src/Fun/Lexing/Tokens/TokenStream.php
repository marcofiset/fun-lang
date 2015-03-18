<?php namespace Fun\Lexing\Tokens;

use Fun\Lexing\Exceptions\UnexpectedTokenException;
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

    /**
     * @return Token
     */
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
     * @param $expectedType
     * @return Token
     * @throws UnexpectedTokenException
     */
    public function expectTokenType($expectedType)
    {
        $token = $this->currentToken();
        $actualType = $token ? $token->getType() : '';

        if (!$token || $actualType !== $expectedType)
            throw new UnexpectedTokenException($expectedType, $actualType);

        return $this->consumeToken();
    }

    /**
     * Expects the current token to be of a specific value.
     *
     * @param $expectedValue
     * @return Token
     * @throws UnexpectedTokenException
     */
    public function expectTokenValue($expectedValue)
    {
        $token = $this->currentToken();
        $actualValue = $token ? $token->getValue() : '';

        if ($expectedValue !== $actualValue)
            throw new UnexpectedTokenException($expectedValue, $actualValue);

        return $this->consumeToken();
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