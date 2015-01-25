<?php namespace Fun\Lexing;

class Lexer
{
    /** @var TokenDefinition[]  */
    private $tokenDefinitions = [];

    public function add(TokenDefinition $tokenDefinition)
    {
        $this->tokenDefinitions[] = $tokenDefinition;
    }

    /**
     * @param $input
     * @return Token[]
     * @throws UnknownTokenException
     */
    public function tokenize($input)
    {
        $lines = $this->inputToLines($input);

        $tokenStream = [];
        $column = 0;

        foreach ($lines as $lineNumber => $line) {
            while ($column < strlen($line)) {
                $token = $this->findMatchingToken(substr($line, $column));

                if (!$token)
                    throw new UnknownTokenException($column);

                $token->setLine($lineNumber + 1);
                $token->setColumn($column + 1);

                $tokenStream[] = $token;
                $column += strlen($token->getValue());
            }

            $column = 0;
        }

        return $tokenStream;
    }

    private function inputToLines($input)
    {
        $input = str_replace('\r\n', '\n', $input);
        $lines = explode("\n", $input);

        return array_map(
            function($line) {
                return $line . "\n";
            }, $lines
        );
    }

    /**
     * @param $input
     * @return Token
     */
    private function findMatchingToken($input)
    {
        foreach ($this->tokenDefinitions as $tokenDefinition) {
            $token = $tokenDefinition->match($input);

            if ($token)
                return $token;
        }

        // Return null if no tokens were matched.
        return null;
    }
}