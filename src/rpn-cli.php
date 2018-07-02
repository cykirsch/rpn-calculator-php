<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Cyk\Calculator\RPN;
use Cyk\Exception\InvalidInputException;

$rpn = new RPN();

// Continually request new input and operate on it
while (true) {
    echo "> ";
    $input = strtoupper(trim(fgets(STDIN)));

    try {
        switch ($input) {
            case "\n":
            case "\r":
            case "\r\n":
                continue;

            case 'Q':
            case 'QUIT':
            case 'EXIT':
                exit("\n");

            case RPN::OPERATOR_ADD:
            case RPN::OPERATOR_SUBTRACT:
            case RPN::OPERATOR_MULTIPLY:
            case RPN::OPERATOR_DIVIDE:
                echo $rpn->operator($input) . "\n";
                break;

            default:
                echo $rpn->operand($input) . "\n";
        }
    } catch (InvalidInputException $e) {
        echo $e->getMessage() . "\n";
    }
}
