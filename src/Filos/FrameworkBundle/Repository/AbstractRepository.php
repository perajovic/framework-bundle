<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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

    protected function getEntityRepository(): EntityRepository
    {
        $class = explode('\\', static::class);
        $class[1] = 'Entity';
        $class[2] = str_replace('Repository', '', $class[2]);
        $class = implode('\\', $class);

        return $this->entityManager->getRepository($class);
    }
}
