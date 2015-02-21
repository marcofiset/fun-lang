<?php namespace Fun\Lexing\Tokens;

use Fun\Lexing\Exceptions\UnexpectedTokenException;

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

    /**
     * @return Token
     */
    public function consumeToken()
    {
        return array_shift($this->tokens);
    }

    public function expectTokenType($expectedType)
    {
        $token = $this->currentToken();
        $actualType = $token ? $token->getType() : '';

        if ($expectedType !== $actualType)
            throw new UnexpectedTokenException($expectedType, $actualType);

        return $this->consumeToken();
    }

    public function expectTokenValue($expectedValue)
    {
        $token = $this->currentToken();
        $actualValue = $token ? $token->getValue() : '';

        if ($expectedValue !== $actualValue)
            throw new UnexpectedTokenException($expectedValue, $actualValue);

        return $this->consumeToken();
    }
}