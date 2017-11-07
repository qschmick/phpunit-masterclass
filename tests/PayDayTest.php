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


use In2it\Masterclass\PayDay;
use PHPUnit\Framework\TestCase;

class PayDayTest extends TestCase
{
    /**
     * Testing that we're getting 12 entries back from the
     * PayDay application.
     *
     * @covers \In2it\Masterclass\PayDay::calculatePayDay
     */
    public function testPayDayReturnsTwelveEntries()
    {
        $payday = new PayDay();
        $expectedCount = 12;
        $result = $payday->calculatePayDay();
        $this->assertInstanceOf(\Iterator::class, $result);
        $this->assertSame($expectedCount, \iterator_count($result));
    }


    /**
     * Testing that our application returns indeed entries
     * for PayDays
     *
     * @covers \In2it\Masterclass\PayDay::calculatePayDay
     */
    public function testPayDayReturnsPayDayEntities()
    {
        $payday = new PayDay();

        $expectedYear = '2017';
        $expectedMonth = 'November';
        $expectedMidPayday = '2017-11-20';
        $expectedEndPayday = '2017-11-24';

        $result = $payday->calculatePayDay();

        $result->rewind();
        $firstEntry = $result->current();

        $this->assertInstanceOf(\stdClass::class, $firstEntry);
        $this->assertSame($expectedYear, $firstEntry->year);
        $this->assertSame($expectedMonth, $firstEntry->month);
        $this->assertSame($expectedMidPayday, $firstEntry->midPayday);
        $this->assertSame($expectedEndPayday, $firstEntry->endPayday);
    }
}