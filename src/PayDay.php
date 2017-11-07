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

namespace in2it\Masterclass;

/**
 * Class PayDay
 *
 * This class provides functionality to calculate pay day
 * days where salaries are being paid.
 *
 * @package in2it\Masterclass
 */
class PayDay
{
    const APP_TIMEZONE = 'Europe/Brussels';

    /**
     * @var \DateTime
     */
    protected $startDate;

    /**
     * PayDay constructor.
     *
     * @param \DateTime $startDate
     */
    public function __construct(\DateTime $startDate)
    {
        $this->startDate = $startDate;
    }


    /**
     * Method that will calculate payment days for salaries
     *
     * @return \Iterator
     */
    public function calculatePayDay(): \Iterator
    {
        $lastMonth = clone $this->startDate;
        $lastMonth->modify('last month');
        $payDayCollection = new \SplObjectStorage();

        do {
            $midPayday = $this->calculateMiddlePayday((int) $this->startDate->format('Y'), (int) $this->startDate->format('m'));
            $endPayday = $this->calculateEndPayday((int) $this->startDate->format('Y'), (int) $this->startDate->format('m'));

            $payDay = new \stdClass();
            $payDay->year = $this->startDate->format('Y');
            $payDay->month = $this->startDate->format('F');
            $payDay->midPayday = $midPayday->format('Y-m-d');
            $payDay->endPayday = $endPayday->format('Y-m-d');
            $payDayCollection->attach($payDay);

            $this->startDate->modify('next month');
        } while (((int) $lastMonth->format('m') + 1) !== (int) $this->startDate->format('m'));
        return $payDayCollection;
    }

    /**
     * Calculates the middle payment date for a given month in a given year
     *
     * @param int $year
     * @param int $month
     * @return \DateTime
     */
    private function calculateMiddlePayday(int $year, int $month): \DateTime
    {
        $midPayday = new \DateTime('now', new \DateTimeZone(self::APP_TIMEZONE));
        $midPayday->setDate($year, $month, 15);
        $midPayday->modify('next Monday');
        return $midPayday;
    }

    /**
     * Calculates the end payment date for a given month in a given year
     *
     * @param int $year
     * @param int $month
     * @return \DateTime
     */
    private function calculateEndPayday(int $year, int $month): \DateTime
    {
        $endPayday = new \DateTime('now', new \DateTimeZone(self::APP_TIMEZONE));
        $endPayday->setDate($year, $month, 15);
        $endPayday->modify('last Friday of this month');
        return $endPayday;
    }
}