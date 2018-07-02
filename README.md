# rpn-calculator-php
Reverse Polish Notation CLI calculator written in PHP

## How it works
Once the program is running, it runs a continuous while loop to accept new input. *It currently only accepts a single input value per iteration.* On each input, it determines whether to quit, pass value as an operand, or pass value as an operator. Operands add to the top of the stock. Operators take the top 2 values off the stack, calculate, and put the result back on the top of the stack.

If the state of the stack does not allow an operator, or if an unaccepted value is given, a friendly error message will be shown to the user, and the stack will be unaffected.

Users can use the "clear" or "reset" command to clear; and can use "quit", "q", or "exit" to terminate the program.

## Decisions, decisions
- The first thing I did was wire up the project with composer so that I could pull in phpunit for testing. I would consider looking into additional libraries to handle some of the functionality for me (perhaps the CLI argument parsing) but found it best (and likely simplest) to demonstrate coding from scratch.
- The other major decision was to separate out the calculation class. This way it can be re-used for alternate interfaces.
- A minor decision was to include a custom exception class. In the past I've often wished I did this, even if it has no customizations. Makes it so much easier (and safer/clearer) to target specific errors in a try/catch.

## Low Hanging Fruit
These would be my next steps for immediate improvement.

1. Add --help menu via argv
1. Accept full RPN string of input in addition to the existing ability to enter one value at a time
1. Replace switch/case in the rpn-cli program. Some of it can be abstracted away, and I don't like how I have the "continue" and "exit" *hidden* in there
1. Move the main program to the bin (or possibly symlink it)
1. Alternate operators: x and × should function the same as *
1. More specific exceptions. NotEnoughOperandsException instead of just InvalidInputException for everything
1. Accept Ctrl+D input to terminate the program. This was in the spec, but I passed over it because Ctrl+C works.
1. More test samples

## Installation
Clone the project and then run `composer install`. Currently requires PHP 7.2, but that's only because I didn't take the time to test anything less.

## Usage!!
Start the program with `php src/rpn-cli.php` and then enter values to calculate individually.
