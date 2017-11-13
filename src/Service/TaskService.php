<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 11/13/17
 * Time: 11:58 AM
 */

namespace In2it\Masterclass\Service;

use In2it\Masterclass\Model\TaskEntityInterface;

class TaskService implements TaskEntityInterface
{
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
        // TODO: Implement getLabel() method.
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
        // TODO: Implement isDone() method.
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

}