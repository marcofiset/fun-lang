<?php namespace Fun\Lexing;

class Lexer
{
    private $tokenDefinitions = [];

    public function add(TokenDefinition $tokenDefinition)
    {
        $this->tokenDefinitions[] = $tokenDefinition;
    }

    public function tokenize($input)
    {
        $tokens = [];
        $currentIndex = 0;

        //The basic loop is to run through the whole input string
        while ($currentIndex < strlen($input)) {
            $token = $this->findMatchingToken(substr($input, $currentIndex));

            // If no tokens were matched, it means that the string has invalid tokens
            // for which we did not define a token definition for
            if (!$token)
                throw new UnknownTokenException($currentIndex);

            // Add the matched token to our list of token
            $tokens[] = $token;

            // Increment the string index by the length of the matched token,
            // so we can now process the rest of the string.
            $currentIndex += strlen($token->getValue());
        }

        return $tokens;
    }

    private function findMatchingToken($input)
    {
        // Check with all tokenDefinitions
        foreach ($this->tokenDefinitions as $tokenDefinition) {
            $token = $tokenDefinition->match($input);

            // Return the first token that was matched.
            if ($token)
                return $token;
        }

        // Return null if no tokens were matched.
        return null;
    }
}