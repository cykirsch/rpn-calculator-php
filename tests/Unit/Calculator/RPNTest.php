<?php

use PHPUnit\Framework\TestCase;
use Cyk\Calculator\RPN;
use Cyk\Exception\InvalidInputException;

class RPNTest extends TestCase
{
    /**
     * Various calculations for accuracy, this is the most important test.
     * @dataProvider calculationsDataProvider
     */
    public function testCalculations($inputs, $expected)
    {
        $subject = new RPN();
        $actual = null;

        foreach ($inputs as $input) {
            if (in_array($input, ['+', '-', '*', '/'])) {
                $actual = $subject->operator($input);
            } else {
                $subject->operand($input);
            }
        }

        $this->assertEquals($expected, $actual);
    }

    public function calculationsDataProvider()
    {
        return [
            [
                'inputs' => [5, 9, 1, '-', '/'],
                'result' => 0.625,
            ],
            [
                'inputs' => [-3, -2, '*', 5, '+'],
                'result' => 11,
            ],
            [
                'inputs' => [15, 7, 1, 1, '+', '-', '/', 3, '*', 2, 1, 1, '+', '+', '-'],
                'result' => 5,
            ],
        ];
    }

    /**
     * Can't give letters
     */
    public function testLetter()
    {
        $subject = new RPN();

        $this->expectException(InvalidInputException::class);
        $subject->operand('a');
    }

    /**
     * Can't give symbols
     */
    public function testSymbol()
    {
        $subject = new RPN();

        $this->expectException(InvalidInputException::class);
        $subject->operand('$');
    }

    /**
     * Already have a result but used too many operators
     */
    public function testMissingOne()
    {
        $subject = new RPN();
        $subject->operand(5);
        $subject->operand(20);
        $subject->operator('+');

        $this->expectException(InvalidInputException::class);
        $subject->operator('+');
    }

    /**
     * Never gave an operand
     */
    public function testMissingTwo()
    {
        $subject = new RPN();

        $this->expectException(InvalidInputException::class);
        $subject->operator('+');
    }

    /**
     * Would have enough operands except the reset removed one
     */
    public function testReset()
    {
        $subject = new RPN();
        $subject->operand(5);
        $subject->reset();
        $subject->operand(20);
        $subject->operand(20);

        $this->assertEquals(40, $subject->operator('+'));
        $this->expectException(InvalidInputException::class);
        $subject->operator('-');
    }
}
