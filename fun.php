<?php

use Fun\Lexing\Lexer;
use Fun\Lexing\Token;
use Fun\Lexing\TokenDefinition;
use Fun\Lexing\TokenType;
use Fun\Parsing\Parser;

include 'vendor/autoload.php';

$fileName = $argv[1];
$fileContent = file_get_contents($fileName);

$lexer = new Lexer();
$lexer->add(new TokenDefinition('/\s+/', TokenType::Whitespace));
$lexer->add(new TokenDefinition('/\d+/', TokenType::Number));
$lexer->add(new TokenDefinition('/[+\-*\/]/', TokenType::Operator));

$tokens = $lexer->tokenize($fileContent);

$tokens = array_filter($tokens, function(Token $t) {
    return $t->getType() !== TokenType::Whitespace;
});

$parser = new Parser();
$tree = $parser->parse($tokens);

var_dump($tree);