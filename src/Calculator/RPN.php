<?php

namespace Cyk\Calculator;

use Cyk\Exception\InvalidInputException;

class RPN
{
    const OPERATOR_ADD = '+';
    const OPERATOR_SUBTRACT = '-';
    const OPERATOR_MULTIPLY = '*';
    const OPERATOR_DIVIDE = '/';
    // TODO support alternatives like x and ÷

    private $operand_stack;

    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->operand_stack = [];
    }

    public function operand(string $operand)
    {
        if ($this->isValidOperand($operand)) {
            $operand = round($operand, 10);
            array_push($this->operand_stack, $operand);
        }

        return $operand;
    }

    public function operator(string $operator)
    {
        if ($this->isEnoughOperands()) {
            $right = array_pop($this->operand_stack);
            $left = array_pop($this->operand_stack);

            switch($operator) {
                case self::OPERATOR_ADD:        $result = $left + $right; break;
                case self::OPERATOR_SUBTRACT:   $result = $left - $right; break;
                case self::OPERATOR_MULTIPLY:   $result = $left * $right; break;
                case self::OPERATOR_DIVIDE:     $result = $left / $right; break;
            }

            array_push($this->operand_stack, $result);

            return round($result, 10);
        }
    }

    /**
     * Must be at least one operand on the stack before accepting an operator;
     * if this is the first operator in the calculation, must be at least two operands.
     * @return boolean Only if true/valid
     * @throws Exception\InvalidInputException
     */
    private function isEnoughOperands() : bool
    {
        if (count($this->operand_stack) < 2) {
            throw new InvalidInputException("Please provide at least one more operand before an operator.");
        }

        return true;
    }

    /**
     * Determine if the given operand is valid. Must be numeric. As far as I am aware nothing else matters.
     * @return boolean Only if true/valid
     * @throws Exception\InvalidInputException
     */
    private function isValidOperand($operand) : bool
    {
        if (!is_numeric($operand)) {
            throw new InvalidInputException("'$operand' is not a valid number.");
        }

        return true;
    }
}
