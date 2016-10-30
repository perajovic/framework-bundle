<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Repository;

use Doctrine\ORM\EntityManager;

abstract class AbstractRepository
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param object $entity
     */
    public function create($entity)
    {
        $this->persist($entity);
        $this->flush();
    }

    /**
     * @param object $entity
     */
    public function remove($entity)
    {
        $this->entityManager->remove($entity);
        $this->flush();
    }

    /**
     * @see EntityManager::persist()
     *
     * @param object $entity
     */
    public function persist($entity)
    {
        $this->entityManager->persist($entity);
    }

    /**
     * @see EntityManager::flush()
     */
    public function flush()
    {
        $this->entityManager->flush();
    }
}
