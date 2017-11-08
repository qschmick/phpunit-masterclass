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


use In2it\Masterclass\HelloWorld;
use PHPUnit\Framework\TestCase;

class HelloWorldTest extends TestCase
{
    /**
     * Testing the app returns the string "Hello World!"
     *
     * @covers \In2it\Masterclass\HelloWorld::sayHello
     */
    public function testAppOutputsHelloWorld()
    {
        $helloWorld = new HelloWorld();
        $expectedOutput = 'Hello World!';
        $this->assertSame($expectedOutput, $helloWorld->sayHello(),
            'Expected response does not match "Hello World!"');
    }
}