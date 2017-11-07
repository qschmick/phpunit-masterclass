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

namespace In2it\Masterclass;

/**
 * Class Calculator
 *
 * This class provides simple functionality that
 * can be tested with PHPUnit.
 *
 * @package In2it\Masterclass
 */
class Calculator
{
    /**
     * @var int
     */
    private $result;

    /**
     * Calculator constructor.
     */
    public function __construct()
    {
        $this->result = 0;
    }

    /**
     * Adds a given value
     *
     * @param int $value
     * @return Calculator
     */
    public function add(int $value): Calculator
    {
        $this->result += $value;
        return $this;
    }

    /**
     * Subtracts a given value
     *
     * @param int $value
     * @return Calculator
     */
    public function subtract(int $value): Calculator
    {
        $this->result -= $value;
        return $this;
    }

    /**
     * Gets the result
     *
     * @return int
     */
    public function getResult(): int
    {
        return $this->result;
    }
}