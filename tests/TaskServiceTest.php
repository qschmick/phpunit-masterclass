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


use PHPUnit\Framework\TestCase;

class TaskServiceTest extends TestCase
{
    /**
     * @var TaskGatewayInterface
     */
    protected $taskGateway;

    protected function setUp()
    {
        parent::setUp();

        // We create a mock object
        $taskEntity = $this->getMockBuilder(TaskEntityInterface::class)
            ->setMethods(['getId', 'getLabel', 'getDescription', 'isDone', 'getCreated', 'getModified', 'setLabel', 'setDone'])
            ->getMock();

        $taskEntry1 = clone $taskEntity;
        $taskEntry1->method('getId')->willReturn('123');
        $taskEntry1->method('getLabel')->willReturn('Task #123');
        $taskEntry1->method('getDescription')->willReturn('#123: This is task 123');
        $taskEntry1->method('isDone')->willReturn(false);
        $taskEntry1->method('getCreated')->willReturn(new \DateTime('2017-03-21 07:53:24'));
        $taskEntry1->method('getModified')->willReturn(new \DateTime('2017-03-21 08:16:53'));

        $taskEntryUpdate = clone $taskEntity;
        $taskEntryUpdate->method('getId')->willReturn('123');
        $taskEntryUpdate->method('getLabel')->willReturn('Task #123: Update from service');
        $taskEntryUpdate->method('getDescription')->willReturn('#123: This is task 123');
        $taskEntryUpdate->method('isDone')->willReturn(false);
        $taskEntryUpdate->method('getCreated')->willReturn(new \DateTime('2017-03-21 07:53:24'));
        $taskEntryUpdate->method('getModified')->willReturn(new \DateTime('now'));

        $taskEntry2 = clone $taskEntity;
        $taskEntry2->method('getId')->willReturn('456');
        $taskEntry2->method('getLabel')->willReturn('Task #456');
        $taskEntry2->method('getDescription')->willReturn('#456: This is task 456');
        $taskEntry2->method('isDone')->willReturn(true);
        $taskEntry2->method('getCreated')->willReturn(new \DateTime('2017-03-22 07:53:24'));
        $taskEntry2->method('getModified')->willReturn(new \DateTime('2017-03-22 08:16:53'));

        $taskEntry3 = clone $taskEntity;
        $taskEntry3->method('getId')->willReturn('789');
        $taskEntry3->method('getLabel')->willReturn('Task #789');
        $taskEntry3->method('getDescription')->willReturn('#789: This is task 789');
        $taskEntry3->method('isDone')->willReturn(false);
        $taskEntry3->method('getCreated')->willReturn(new \DateTime('2017-04-23 07:53:24'));
        $taskEntry3->method('getModified')->willReturn(new \DateTime('2017-04-23 08:16:53'));

        $taskEntryDone = clone $taskEntity;
        $taskEntryDone->method('getId')->willReturn('789');
        $taskEntryDone->method('getLabel')->willReturn('#789');
        $taskEntryDone->method('getDescription')->willReturn('#789: This is task 789');
        $taskEntryDone->method('isDone')->willReturn(true);
        $taskEntryDone->method('getCreated')->willReturn(new \DateTime('2017-04-23 07:53:24'));
        $taskEntryDone->method('getModified')->willReturn(new \DateTime('now'));

        $taskCollection = new \SplObjectStorage();
        $taskCollection->attach($taskEntry3);
        $taskCollection->attach($taskEntry2);
        $taskCollection->attach($taskEntry1);

        $taskGateway = $this->getMockBuilder(TaskGatewayInterface::class)
            ->setMethods(['fetchAll', 'add', 'find', 'remove', 'update'])
            ->getMock();

        $taskGateway->expects($this->any())
            ->method('fetchAll')
            ->willReturn($taskCollection);

        $taskGateway->expects($this->any())
            ->method('add')
            ->will($this->returnCallback(function ($task) use ($taskCollection) {
                $taskCollection->attach($task);
                return true;
            }));

        $taskGateway->expects($this->any())
            ->method('find')
            ->willReturnMap([
                ['789', $taskEntry3],
                ['456', $taskEntry2],
                ['123', $taskEntry1],
            ]);

        $taskCollectionLess = clone $taskCollection;
        $taskCollectionLess->detach($taskEntry1);

        $taskGateway->expects($this->any())
            ->method('remove')
            ->willReturnCallback(function ($task) use ($taskCollection) {
                $taskCollection->detach($task);
                return true;
            });

        $taskGateway->expects($this->any())
            ->method('update')
            ->willReturnCallback(function ($task) use ($taskCollection, $taskEntryUpdate, $taskEntryDone) {
                $taskCollection->detach($task);
                if ('123' === $task->getId()) {
                    $taskCollection->attach($taskEntryUpdate);
                }
                if ('789' === $task->getId()) {
                    $taskCollection->attach($taskEntryDone);
                }
                return true;
            });

        $this->taskGateway = $taskGateway;
    }

    protected function tearDown()
    {
        $this->taskGateway = null;
    }

    /**
     * List open tasks sorted newest to oldest
     *
     * @covers TaskService::fetchAll
     */
    public function testServiceReturnsListOfTasks()
    {
        $taskService = new TaskService($this->taskGateway);
        $taskList = $taskService->getAllTasks();

        $this->assertInstanceOf(\Iterator::class, $taskList);
        $this->assertGreaterThan(0, count($taskList));
        $taskList->rewind();
        $previous = null;
        while ($taskList->valid()) {
            if (null !== $previous) {
                $current = $taskList->current();
                $this->assertTrue($previous->getCreated() > $current->getCreated());
            }
            $previous = $taskList->current();
            $taskList->next();
        }
    }

    public function testServiceCanAddNewTask()
    {
        // Create a new task (label and description)
    }

    public function testServiceCanUpdateExistingTask()
    {
        // Update an existing task
    }

    public function testServiceCanMarkTaskAsDone()
    {
        // Mark task as done in the overview list
    }

    public function testServiceCanRemoveTaskMarkedAsDone()
    {
        // Remove task marked as done
    }

    public function testServiceWillThrowRuntimeExceptionWhenStorageFailsToFetchTaskList()
    {
        // Throw a runtime exception when connection to storage fails for fetching task list
    }

    public function testServiceWillThrowInvalidArgumentExceptionWhenInvalidTaskIsAdded()
    {
        // Throw an invalid argument exception for invalid task when adding
    }

    public function testServiceWillThrowRuntimeExceptionWhenStorageFails()
    {
        // Throw a runtime exception when storage of task fails
    }

    public function testServiceWillThrowDomainExceptionWhenTaskWasMarkedAsDoneWhenMarkingTaskAsDone()
    {
        // Throw a domain exception when a task was already marked as done
    }
}