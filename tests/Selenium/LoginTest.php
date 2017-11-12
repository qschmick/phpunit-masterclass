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
    const SCREENSHOT_PATH = __DIR__ . '/_errors';

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

        // Capture a screenshot in case the test fails
        file_put_contents(
            self::SCREENSHOT_PATH . '/weCanReachWebsite.jpg',
            $this->currentScreenshot()
        );
    }

    public function testLoginFailsForUnknownCredentials()
    {
        $this->url('http://www.theialive.com/login');
        $this->byName('email')->value('foo+12345654321@bar.com');
        $this->byName('password')->value('thisisatest');
        $this->byTag('form')->submit();

        $expectedError = 'Invalid username and/or password provided';
        $errorMessage = $this->byClassName('errors')->byTag('li')->text();
        $this->assertSame($expectedError, $errorMessage);

        // Capture a screenshot in case the test fails
        file_put_contents(
            self::SCREENSHOT_PATH . '/loginFailsForUnknownCredentials.jpg',
            $this->currentScreenshot()
        );
    }

    public function testLoginSucceedsWithCorrectCredentials()
    {
        $this->url('http://www.theialive.com/login');
        $this->byName('email')->value('dragonbe+phpworld@gmail.com');
        $this->byName('password')->value('test1234');
        $this->byTag('form')->submit();

        $this->byLinkText('projects');
        $expectedProjectTitle = 'Acceptance testing at phpworld';
        $projectTitle = $this->byClassName('tableRow')->byTag('a')->text();
        $this->assertSame($expectedProjectTitle, $projectTitle);

        // Capture a screenshot in case the test fails
        file_put_contents(
            self::SCREENSHOT_PATH . '/loginSucceedsWithCorrectCredentials.jpg',
            $this->currentScreenshot()
        );
    }

    public function testCanListTasksInProject()
    {
        $this->url('http://www.theialive.com/login');
        $this->byName('email')->value('dragonbe+phpworld@gmail.com');
        $this->byName('password')->value('test1234');
        $this->byTag('form')->submit();

        $this->byLinkText('projects')->click();

        $webdriver = $this;
        $taskLink = $this->waitUntil(function() use($webdriver){
            try {
                $element = $webdriver->byLinkText('Acceptance testing at phpworld');
                if ($element->displayed()) {
                    return $element;
                }
                return null;
            } catch (\Exception $ex) {
                return null;
            }
        }, 3000);

        $taskLink->click();

        $expectedTasks = 8;
        $tasks = $this->elements($this->using('className')->value('tableRow'));
        $this->assertCount($expectedTasks, $tasks);

        // Capture a screenshot in case the test fails
        file_put_contents(
            self::SCREENSHOT_PATH . '/canListTasksInProject.jpg',
            $this->currentScreenshot()
        );
    }

    public function testCannotVisitProjectsBeforeLogin()
    {
        $this->url('http://www.theialive.com/project');
        $expectedProjectTitle = 'Sign in your Theialive account';
        $projectTitle = $this->byTag('h1')->text();
        $this->assertSame($expectedProjectTitle, $projectTitle);

        // Capture a screenshot in case the test fails
        file_put_contents(
            self::SCREENSHOT_PATH . '/cannotVisitProjectBeforeLogin.jpg',
            $this->currentScreenshot()
        );
    }
}
