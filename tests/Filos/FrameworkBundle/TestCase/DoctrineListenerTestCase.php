<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\TestCase;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Filos\FrameworkBundle\Model\ManagedBy;
use Filos\FrameworkBundle\RequestContext\UserContextInterface;
use Filos\FrameworkBundle\TestCase\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

abstract class DoctrineListenerTestCase extends TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $lifecycleEventArgs;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $objectManager;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $entityRepository;

    protected function setUp()
    {
        parent::setUp();

        if (!class_exists(EntityManager::class, true)) {
            $this->markTestSkipped('Doctrine ORM is not found.');
        }

        $this->lifecycleEventArgs = $this->createMockFor(LifecycleEventArgs::class);
        $this->objectManager = $this->createMockFor(EntityManager::class);
        $this->entityRepository = $this->createMockFor(EntityRepository::class);
    }

    /**
     * @param object $object
     */
    protected function ensureObject($object)
    {
        $this
            ->lifecycleEventArgs
            ->expects($this->once())
            ->method('getObject')
            ->will($this->returnValue($object));
    }

    protected function ensureObjectManagerIsNotCalled()
    {
        $this
            ->lifecycleEventArgs
            ->expects($this->never())
            ->method('getObjectManager');
    }

    protected function ensureManagedByResult(?ManagedBy $managedBy, UserContextInterface $entity)
    {
        $this
            ->lifecycleEventArgs
            ->expects($this->atLeastOnce())
            ->method('getObjectManager')
            ->will($this->returnValue($this->objectManager));
        $this
            ->objectManager
            ->expects($this->once())
            ->method('getRepository')
            ->with(ManagedBy::class)
            ->will($this->returnValue($this->entityRepository));
        $this
            ->entityRepository
            ->expects($this->once())
            ->method('findBy')
            ->with([
                'id' => $entity->getId(),
                'type' => get_class($entity),
            ])
            ->will($this->returnValue($managedBy ? [$managedBy] : null));
    }

    protected function ensureEntityManagerIsFlushed()
    {
        $this
            ->objectManager
            ->expects($this->once())
            ->method('flush');
    }

    protected function ensureManagedByIsPersisted()
    {
        $this
            ->objectManager
            ->expects($this->once())
            ->method('persist')
            ->with($this->callback(function ($arg) {
                $this->assertInstanceOf(ManagedBy::class, $arg);

                return $arg;
            }));
    }
}
