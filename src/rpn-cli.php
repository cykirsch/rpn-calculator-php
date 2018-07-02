<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Calculator\RPN;

$rpn = new RPN();
// $rpn->reset();

// Continually request new input and operate on it
while (true) {
    $input = strtoupper(trim(fgets(STDIN)));

    switch ($input) {
        case 'Q':
        case 'QUIT':
        case 'EXIT':
            exit("\n");

        case RPN::OPERATOR_ADD:
        case RPN::OPERATOR_SUBTRACT:
        case RPN::OPERATOR_MULTIPLY:
        case RPN::OPERATOR_DIVIDE:
            echo $rpn->operator($input);
            break;

        default:
            try {
                echo $rpn->operand($input);
            } catch (Exception $e) {
                // TODO more specific exception
                echo $e->getMessage();
            }
    }
}
