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


class HelloWorld
{
    /**
     * This method returns the string "Hello <argument>!"
     *
     * @param string $argument
     * @return string
     */
    public function sayHello(string $argument = 'World'): string
    {
        return 'Hello ' . $argument . '!';
    }
}