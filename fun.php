<?php

use Fun\Interpreting\Interpreter;
use Fun\Lexing\Lexer;
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

$parser = new Parser();
$rootNode = $parser->parse($tokens);

$interpreter = new Interpreter();
$result = $rootNode->accept($interpreter);

var_dump($result);