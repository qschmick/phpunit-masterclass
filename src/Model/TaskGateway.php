<?php
declare(strict_types=1);
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

namespace In2it\Masterclass\Model;


class TaskGateway implements TaskGatewayInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * TaskGateway constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(): \Iterator
    {
        $stmt = $this->pdo->query('SELECT * FROM `task`');

        $store = new \SplObjectStorage();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($result as $entry) {
            $store->attach(new TaskEntity(
                $entry['id'],
                $entry['label'],
                $entry['description'],
                (bool) $entry['done']
            ));
        }
        return $store;
    }

    /**
     * @inheritDoc
     */
    public function add(TaskEntityInterface $taskEntity): bool
    {
        $date = new \DateTime();
        $data = [
            'id' => $taskEntity->getId(),
            'label' => $taskEntity->getLabel(),
            'description' => $taskEntity->getDescription(),
            'done' => $taskEntity->isDone(),
            'created' => $date->format('Y-m-d H:i:s'),
            'modified' => $date->format('Y-m-d H:i:s'),
        ];
        $stmt = $this->pdo->prepare('INSERT INTO `task` VALUES (?, ?, ?, ?, ?, ?)');
        return $stmt->execute(array_values($data));
    }

    /**
     * @inheritDoc
     */
    public function find(string $taskId): ?TaskEntityInterface
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `task` WHERE `id` = ?');
        $stmt->execute([$taskId]);
        if (false === ($data = $stmt->fetch(\PDO::FETCH_ASSOC))) {
            return null;
        }
        return new TaskEntity(
            $data['id'],
            $data['label'],
            $data['description'],
            (bool) $data['done']
        );
    }

    /**
     * @inheritDoc
     */
    public function remove(TaskEntityInterface $taskEntity): bool
    {
        $stmt = $this->pdo->prepare('DELETE * FROM `task` WHERE `id` = ?');
        return $stmt->execute([$taskEntity->getId()]);
    }

    /**
     * @inheritDoc
     */
    public function update(TaskEntityInterface $taskEntity): bool
    {
        $date = new \DateTime();
        $data = [
            'label' => $taskEntity->getLabel(),
            'description' => $taskEntity->getDescription(),
            'done' => $taskEntity->isDone(),
            'modified' => $date->format('Y-m-d H:i:s'),
            'id' => $taskEntity->getId(),
        ];
        $stmt = $this->pdo->prepare('UPDATE `task` SET `label` = ?, `description` = ?, `done` = ?, `modified` = ? WHERE `id` = ?');
        return $stmt->execute(array_values($data));
    }
}