<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 11/13/17
 * Time: 11:58 AM
 */

namespace In2it\Masterclass\Service;

use In2it\Masterclass\Model\TaskEntityInterface;
use In2it\Masterclass\Model\TaskGatewayInterface;

class TaskService implements TaskEntityInterface
{
    /**
     * @var TaskGatewayInterface $tasks
     */
    protected $tasks;

    /**
     * @var String $label
     */
    protected $label;

    /**
     * @var bool $isDone
     */
    protected $isDone;

    public function __construct($gateway){
        $this->tasks = $gateway;
    }
    /**
     * Get the ID for this task entity
     *
     * @return string
     */
    public function getId(): string
    {
        // TODO: Implement getId() method.
    }

    /**
     * Get the label for this task entity
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param String $label
     */
    public function setLabel(String $label)
    {
        $this->label = $label;
    }

    /**
     * Get the description for this task entity
     *
     * @return string
     */
    public function getDescription(): string
    {
        // TODO: Implement getDescription() method.
    }

    /**
     * Check if this task entry is done or not
     *
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->isDone;
    }

    public function setDone(bool $isDone) {
        $this->isDone = $isDone;
    }

    /**
     * Get the creation date for this task entity
     *
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        // TODO: Implement getCreated() method.
    }

    /**
     * Get the modification date for this task entry
     *
     * @return \DateTime
     */
    public function getModified(): \DateTime
    {
        // TODO: Implement getModified() method.
    }

    /**
     * @return \Iterator
     */
    public function getAllTasks(): \Iterator{
        return $this->tasks->fetchAll();
    }

    /**
     * @param TaskEntityInterface $taskEntity
     */
    public function addTask(TaskEntityInterface $taskEntity) {
        $this->tasks->add($taskEntity);
    }

    /**
     * @param string $id
     * @return TaskEntityInterface|null
     */
    public function findTask(string $id) {
        return $this->tasks->find($id);
    }

    /**
     * @param TaskEntityInterface $taskEntity
     * @return bool
     */
    public function updateTask(TaskEntityInterface $taskEntity) {
        return $this->tasks->update($taskEntity);
    }

    /**
     * @param TaskEntity $taskEntity
     * @return bool
     */
    public function MarkTaskDone($taskEntity) {
        if($taskEntity->isDone()) {
            throw new \DomainException('Cannot mark done task as done.');
        }
        return $this->tasks->update($taskEntity);
    }

    public function removeTask(TaskEntityInterface $taskEntity) {
        return $this->tasks->remove($taskEntity);
    }
}