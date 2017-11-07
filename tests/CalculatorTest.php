<?php
/**
 * PHPUnit Masterclass
 *
 * With in2it’s PHPUnit Masterclass you will learn how to test legacy
 * PHP apps, use test-driven development for new projects and to write
 * better tests.
 *
 * @copyright 2009 - 2017 © In2it. All rights reserved
 * @license Apache License 2.0 - See LICENSE for details
 * @see https://www.in2it.be/training-courses/phpunit-masterclass/
 */
namespace In2it\Masterclass\Test;

use In2it\Masterclass\Calculator;
use PHPUnit\Framework\TestCase;

/**
 * Class CalculatorTest
 *
 * Unit tests for In2it\Masterclass\Calculator class
 *
 * @package In2it\Masterclass\Test
 */
class CalculatorTest extends TestCase
{
    /**
     * Test the calculator starts with value zero (0) so
     * we don't have weird results because the initial value
     * was not set upfront.
     */
    public function testCalculatorStartsWithZeroResult()
    {
        $calculator = new Calculator();
        $expectedResult = 0;
        $this->assertSame($expectedResult, $calculator->getResult());
    }

    /**
     * Test that the calculator can add a value to the
     * existing result.
     */
    public function testCalculatorCanAddValue()
    {
        $calculator = new Calculator();
        $calculator->add(1);
        $expectedResult = 1;
        $this->assertSame($expectedResult, $calculator->getResult());
    }

    /**
     * Test that the calculator can subtract a value
     * from the existing result
     */
    public function testCalculatorCanSubtractValue()
    {
        $calculator = new Calculator();
        $calculator->subtract(1);
        $expectedResult = -1;
        $this->assertSame($expectedResult, $calculator->getResult());
    }
}