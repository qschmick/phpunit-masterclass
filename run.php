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

use In2it\Masterclass\PayDay;

require_once __DIR__ . '/vendor/autoload.php';

$payDay = new PayDay();
$days = $payDay->calculatePayDay();
$days->rewind();
while ($days->valid()) {
    echo sprintf(
        '%d %9s: %s %s',
        $days->current()->year,
        $days->current()->month,
        $days->current()->midPayday,
        $days->current()->endPayday
    ) . PHP_EOL;
    $days->next();
}