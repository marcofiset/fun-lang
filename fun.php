<?php

use Fun\Lexing\FunLexer;
use Fun\Parsing\Parser;
use Fun\Interpreting\Interpreter;

include 'vendor/autoload.php';

$fileName = $argv[1];
$fileContent = file_get_contents($fileName);

$lexer = new FunLexer();

$tokens = $lexer->tokenize($fileContent);

$parser = new Parser();
$rootNode = $parser->parse($tokens);

$interpreter = new Interpreter();
$result = $rootNode->accept($interpreter);

var_dump($result);