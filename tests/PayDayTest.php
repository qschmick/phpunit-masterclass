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
     * @var \DateTime
     */
    protected $today;

    protected function setUp()
    {
        parent::setUp();
        $this->today = new \DateTime('2017-09-15', new \DateTimeZone('Europe/Amsterdam'));
    }

    protected function tearDown()
    {
        $this->today = null;
        parent::tearDown();
    }
    /**
     * Testing that we're getting 12 entries back from the
     * PayDay application.
     *
     * @return \Iterator
     *
     * @covers \In2it\Masterclass\PayDay::calculatePayDay
     */
    public function testPayDayReturnsTwelveEntries()
    {
        $payday = new PayDay($this->today);
        $expectedCount = 12;
        $result = $payday->calculatePayDay();
        $this->assertInstanceOf(\Iterator::class, $result);
        $this->assertSame($expectedCount, \iterator_count($result));
        return $result;
    }


    /**
     * Testing that our application returns indeed entries
     * for PayDays
     *
     * @param \Iterator $result
     *
     * @covers \In2it\Masterclass\PayDay::calculatePayDay
     * @depends testPayDayReturnsTwelveEntries
     */
    public function testPayDayReturnsPayDayEntities(\Iterator $result)
    {
        $expectedYear = $this->today->format('Y');
        $expectedMonth = $this->today->format('F');
        $expectedMidPayday = $this->today->format('Y') . '-' . $this->today->format('m');
        $expectedEndPayday = $this->today->format('Y') . '-' . $this->today->format('m');

        $result->rewind();
        $firstEntry = $result->current();

        $this->assertInstanceOf(\stdClass::class, $firstEntry);
        $this->assertSame($expectedYear, $firstEntry->year);
        $this->assertSame($expectedMonth, $firstEntry->month);
        $this->assertStringStartsWith($expectedMidPayday, $firstEntry->midPayday);
        $this->assertStringStartsWith($expectedEndPayday, $firstEntry->endPayday);
    }
}