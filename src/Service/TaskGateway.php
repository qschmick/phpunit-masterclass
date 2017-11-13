<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 11/13/17
 * Time: 12:04 PM
 */

namespace In2it\Masterclass\Service;


use In2it\Masterclass\Model\TaskEntityInterface;
use In2it\Masterclass\Model\TaskGatewayInterface;

class TaskGateway implements TaskGatewayInterface
{
    /**
     * @var \SplObjectStorage $collection
     */
    protected $collection;

    public function __construct()
    {
        $this->collection = new \SplObjectStorage();
    }

    /**
     * Fetch all tasks from the back-end storage
     *
     * @return \Iterator
     */
    public function fetchAll(): \Iterator
    {
        return $this->collection;
    }

    /**
     * Add a task to the back-end storage
     *
     * @param TaskEntityInterface $taskEntity
     * @return bool
     */
    public function add(TaskEntityInterface $taskEntity): bool
    {
        // TODO: Implement add() method.
    }

    /**
     * Find a task by given task ID
     *
     * @param string $taskId
     * @return TaskEntityInterface|null
     */
    public function find(string $taskId): ?TaskEntityInterface
    {
        // TODO: Implement find() method.
    }

    /**
     * Removes a task by given task entity
     *
     * @param TaskEntityInterface $taskEntity
     * @return bool
     */
    public function remove(TaskEntityInterface $taskEntity): bool
    {
        // TODO: Implement remove() method.
    }

    /**
     * Updates a task by given task entity
     *
     * @param TaskEntityInterface $taskEntity
     * @return bool
     */
    public function update(TaskEntityInterface $taskEntity): bool
    {
        // TODO: Implement update() method.
    }

}