<?php namespace Fun\Lexing\Tokens;

use Fun\Exceptions\UnexpectedTokenTypeException;

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
        list($line, $column) = $this->getLineColumnInformation();

        throw new UnexpectedTokenTypeException($type, $token, $line, $column);
    }

    private function getLineColumnInformation()
    {
        if (!$this->lastConsumedToken)
            return [0, 0];

        return [$this->lastConsumedToken->getLine(), $this->lastConsumedToken->getColumn()];
    }
}