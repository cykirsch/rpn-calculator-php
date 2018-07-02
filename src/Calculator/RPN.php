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

    private $result;
    private $operand_stack;

    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->result = null;
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
            if ($this->result === null) {
                $this->result = array_pop($this->operand_stack);
            }

            $operand = array_pop($this->operand_stack);
            switch($operator) {
                case self::OPERATOR_ADD:        $this->result += $operand; break;
                case self::OPERATOR_SUBTRACT:   $this->result -= $operand; break;
                case self::OPERATOR_MULTIPLY:   $this->result *= $operand; break;
                case self::OPERATOR_DIVIDE:     $this->result /= $operand; break;
            }
        }

        return round($this->result, 10);
    }

    /**
     * Must be at least one operand on the stack before accepting an operator;
     * if this is the first operator in the calculation, must be at least two operands.
     * @return boolean Only if true/valid
     * @throws Exception\InvalidInputException
     */
    private function isEnoughOperands() : bool
    {
        if ($this->result === null && count($this->operand_stack) < 2) {
            throw new InvalidInputException("Cannot accept an operator before there are at least two operands.");
        }

        if ($this->result !== null && count($this->operand_stack) < 1) {
            throw new InvalidInputException("Need at least one more operand before accepting an operator.");
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
            $current = $this->result === null ? 'empty' : (string) $this->result;
            throw new InvalidInputException("'$operand' is not a valid arithmetic operand. The current result is still $current.");
        }

        return true;
    }
}
