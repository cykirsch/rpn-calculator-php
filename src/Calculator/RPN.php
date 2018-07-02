<?php

namespace Calculator;

class RPN
{
    const OPERATOR_ADD = '+';
    const OPERATOR_SUBTRACT = '-';
    const OPERATOR_MULTIPLY = '*';
    const OPERATOR_DIVIDE = '/';
    // TODO support alternatives like x and ÷

    public function __construct()
    {
        echo 'construct';
    }

    public function reset()
    {
        echo 'reset';
    }

    public function operand($operand)
    {
        echo $operand;
    }

    public function operator($operator)
    {
        echo $operator;
    }
}
