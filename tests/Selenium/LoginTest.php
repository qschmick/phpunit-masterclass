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


class LoginTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->setBrowserUrl('http://www.theialive.com');
        $this->setBrowser('chrome');
    }

    protected function tearDown()
    {
        $this->stop();
        parent::tearDown();
    }

    public function testWeCanReachWebsite()
    {
        $this->url('http://www.theialive.com/');
        $expectedTitle = 'The easy task manager';
        $title = $this->byTag('h1')->text();
        $this->assertEquals($expectedTitle, $title);
    }
}
