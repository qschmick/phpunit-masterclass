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

    /**
     * A provider for edge case testing
     *
     * @return array
     */
    public function edgeDateProvider(): array
    {
        return [
            ['2017-01-22', '2017', 'January', '2017-01-16', '2017-01-27'],
            ['2016-02-29', '2016', 'February', '2016-02-22', '2016-02-26'],
        ];
    }

    /**
     * Testing edge cases for date calculations
     *
     * @param string $startDate
     * @param string $year
     * @param string $month
     * @param string $midDate
     * @param string $endDate
     *
     * @covers \In2it\Masterclass\PayDay::calculatePayDay
     * @dataProvider edgeDateProvider
     */
    public function testPayDayEdgeCases(string $startDate, string $year, string $month, string $midDate, string $endDate)
    {
        $startDateObj = new \DateTime($startDate, new \DateTimeZone(PayDay::APP_TIMEZONE));
        $payDay = new PayDay($startDateObj);

        $result = $payDay->calculatePayDay();
        $this->assertInstanceOf(\Iterator::class, $result);
        $this->assertSame(12, \iterator_count($result));
        $result->rewind();
        $firstEntry = $result->current();
        $this->assertSame($year, $firstEntry->year);
        $this->assertSame($month, $firstEntry->month);
        $this->assertSame($midDate, $firstEntry->midPayday);
        $this->assertSame($endDate, $firstEntry->endPayday);
    }
}